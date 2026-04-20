<?php
/**
 * Tests: Heartbeats, Strict Regex Verification, and Double Spending Protection.
 */

error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');

// 1. Setup Environment
define('FCPATH', __DIR__ . '/../');
chdir(FCPATH);
require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'production');
}

$app = \Config\Services::codeigniter();
$app->initialize();

// Load Helpers
helper(['user', 'common']);

$db = \Config\Database::connect();

echo "--- MFS Scaling & Reliability Test ---\n";

// 1. Test Heartbeat Monitoring
echo "[1/4] Testing Device Heartbeat Tracking...\n";
$testEmail = 'test_merchant@example.com';
$testKey = 'tk_' . bin2hex(random_bytes(8));

// Setup test device
$db->table('devices')->insert([
    'uid' => 999,
    'user_email' => $testEmail,
    'device_name' => 'TestPhone',
    'device_key' => $testKey,
    'device_ip' => '127.0.0.1',
    'created_at' => date('Y-m-d H:i:s')
]);
$deviceId = $db->insertID();

// Simulate Sync from Android App
$battery = 85;
$_POST['user_email'] = $testEmail;
$_POST['device_key'] = $testKey;
$_POST['device_ip'] = '1.2.3.4';
$_POST['battery_level'] = $battery;

$api = new \App\Controllers\ApiController();
$api->deviceConnect();

$refreshedDevice = $db->table('devices')->where('id', $deviceId)->get()->getRow();
if ($refreshedDevice->battery_level == $battery && !empty($refreshedDevice->last_sync_at)) {
    echo "  SUCCESS: Heartbeat updated (Battery: {$refreshedDevice->battery_level}%, Last Sync: {$refreshedDevice->last_sync_at})\n";
} else {
    echo "  FAILED: Heartbeat update failed.\n";
}

// 2. Setup Test Payment
echo "[2/4] Setting up test payment (1000 BDT)...\n";
$paymentId = 'PAY_' . time();
$db->table('api_payments')->insert([
    'ids' => $paymentId,
    'merchant_id' => 999,
    'brand_id' => 1,
    'amount' => 1000.00,
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s')
]);

$adapter = new \App\Adapters\SmsVerificationAdapter(999, 1);

// 3. Test Verification Cases
echo "[3/4] Testing Verification Logic...\n";

// Case A: Missing Transaction (Pending/Polling)
$res = $adapter->verifyPayment('TRX123', ['payment_id' => $paymentId]);
if ($res['is_pending'] === true) {
    echo "  SUCCESS: Polling triggered for missing TrxID.\n";
} else {
    echo "  FAILED: Expected pending status for missing TrxID.\n";
}

// Case B: Incorrect Amount
$db->table('module_data')->insert([
    'uid' => 999,
    'address' => 'bkash',
    'message' => 'You have received Tk 500 from 01700000000. TrxID TRX456.',
    'status' => 0,
    'created_at' => date('Y-m-d H:i:s')
]);
$res = $adapter->verifyPayment('TRX456', ['payment_id' => $paymentId]);
if ($res['code'] === 'AMOUNT_MISMATCH') {
    echo "  SUCCESS: Rejected incorrect amount (Expected 1000, Got 500).\n";
} else {
    echo "  FAILED: Expected AMOUNT_MISMATCH error.\n";
}

// Case C: Success Verification
$db->table('module_data')->insert([
    'uid' => 999,
    'address' => 'bkash',
    'message' => 'You have received Tk 1000 from 01700000000. TrxID TRX789.',
    'status' => 0,
    'created_at' => date('Y-m-d H:i:s')
]);
$res = $adapter->verifyPayment('TRX789', ['payment_id' => $paymentId]);
if ($res['success'] === true) {
    echo "  SUCCESS: Payment verified with correct TrxID and Amount.\n";
} else {
    echo "  FAILED: Expected success, got: " . $res['message'] . "\n";
}

// 4. Test Double-Spending
echo "[4/4] Testing Double-Spending Protection...\n";
$secondPaymentId = 'PAY_SECOND_' . time();
$db->table('api_payments')->insert([
    'ids' => $secondPaymentId,
    'merchant_id' => 999,
    'brand_id' => 1,
    'amount' => 1000.00,
    'status' => 'pending',
    'created_at' => date('Y-m-d H:i:s')
]);

$res = $adapter->verifyPayment('TRX789', ['payment_id' => $secondPaymentId]);
if ($res['code'] === 'ALREADY_USED') {
    echo "  SUCCESS: Prevented reuse of TrxID TRX789.\n";
} else {
    echo "  FAILED: Expected ALREADY_USED error.\n";
}

echo "--- Test Complete ---\n";

// Cleanup
$db->table('devices')->where('uid', 999)->delete();
$db->table('api_payments')->where('merchant_id', 999)->delete();
$db->table('module_data')->where('uid', 999)->delete();

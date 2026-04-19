<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('ENVIRONMENT', 'development'); // Force development
require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

$app = Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();
$keyRecord = $db->table('api_keys')->where('environment', 'test')->get()->getRow();

if (!$keyRecord) {
    die("No test API key found in DB to test with.");
}

echo "Testing api_payments insert...\n";
$paymentData = [
    'ids' => 'test_pay_' . time(),
    'merchant_id' => $keyRecord->merchant_id,
    'brand_id' => $keyRecord->brand_id,
    'amount' => 10.00,
    'currency' => 'BDT',
    'status' => 0,
    'test_mode' => 1,
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
];

try {
    $db->table('api_payments')->insert($paymentData);
    echo "Insert successful!\n";
    $db->table('api_payments')->where('ids', $paymentData['ids'])->delete();
    echo "Cleanup successful!\n";
} catch (\Throwable $e) {
    echo "INSERT FAILED: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}

echo "\nTesting WebhookService dispatch...\n";
try {
    $ws = new \App\Libraries\WebhookService();
    $ws->dispatch($keyRecord->brand_id, $keyRecord->merchant_id, 'payment.created', [
        'id' => $paymentData['ids'],
        'amount' => 10.00,
        'currency' => 'BDT',
        'status' => 'processing',
        'test_mode' => true
    ]);
    echo "Dispatch successful!\n";
} catch (\Throwable $e) {
    echo "DISPATCH FAILED: " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n";
}

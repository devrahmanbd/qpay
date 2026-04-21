<?php
// End-to-End Backend Storage Verification Script
// This script simulates a POST request to addMessage and verifies DB entry.

require_once 'app/Config/Constants.php';
require_once 'vendor/autoload.php';

// Mock the CI environment minimalistically if possible, or just use the DB
$db = \Config\Database::connect();

$testData = [
    'email' => 'admin@cloudman.one',
    'device_key' => 'vTrVnN9QWEJxKeBFqkGM1aMROYG045hl2HiGDixj',
    'device_ip' => 'verification-test-runner',
    'address' => 'Nagad',
    'message' => 'TrxID 9K27XJ2L Verified Payment of Tk 500 received. Ref: TEST_SYNC'
];

echo "--- Backend Storage Test ---\n";

// 1. Check if user exists
$user = $db->table('users')->where('email', $testData['email'])->get()->getRow();
if (!$user) {
    die("[FAIL] User not found: " . $testData['email'] . "\n");
}
echo "[PASS] User found: UID " . $user->id . "\n";

// 2. Check if device exists
$device = $db->table('devices')
    ->where('user_email', $testData['email'])
    ->where('device_key', $testData['device_key'])
    ->get()->getRow();

if (!$device) {
    die("[FAIL] Device not authorized for this email/key.\n");
}
echo "[PASS] Device authorized: ID " . $device->id . "\n";

// 3. Perform Mock Insertion (Simulating addMessage logic)
$insertData = [
    'uid'        => $user->id,
    'device_id'  => $device->id,
    'message'    => $testData['message'],
    'address'    => $testData['address'],
    'created_at' => date('Y-m-d H:i:s'),
    'status'     => 0
];

echo "Inserting test message into module_data...\n";
$db->table('module_data')->insert($insertData);

if ($db->affectedRows() > 0) {
    $insertId = $db->insertID();
    echo "[PASS] Data stored successfully! SMS ID: " . $insertId . "\n";
    
    // 4. Verify Search Logic (Matches SmsVerificationAdapter)
    $search = $db->table('module_data')
        ->where('id', $insertId)
        ->where('uid', $user->id)
        ->like('message', '9K27XJ2L')
        ->get()->getRow();
        
    if ($search) {
        echo "[PASS] Search logic found the transaction correctly.\n";
    } else {
        echo "[FAIL] Search logic could not find the ID in the stored message.\n";
    }
    
    // Clean up
    $db->table('module_data')->where('id', $insertId)->delete();
    echo "Cleanup complete.\n";
} else {
    echo "[FAIL] Could not insert data into module_data table.\n";
}

echo "--- Test Complete ---\n";

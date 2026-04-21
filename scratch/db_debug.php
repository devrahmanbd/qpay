<?php

// Manually load the CodeIgniter environment from the root
require_once __DIR__ . '/../index.php';
$db = \Config\Database::connect();

$email = 'admin@cloudman.one';
$key = 'fVSARTobNKvglddV9QhKlPFTsFcLUD884mmh1wjg';

echo "Checking records for Email: $email and Key: $key\n";

$device = $db->table('devices')
    ->where('user_email', $email)
    ->where('device_key', $key)
    ->get()
    ->getRow();

if ($device) {
    echo "Device Found:\n";
    print_r($device);
    
    // Check if the associated user exists
    $user = $db->table('users')->where('id', $device->uid)->get()->getRow();
    if ($user) {
        echo "User Found:\n";
        print_r($user);
    } else {
        echo "CRITICAL: Associated user (ID: $device->uid) NOT FOUND in users table. This will cause foreign key failures if uid is used elsewhere.\n";
    }
} else {
    echo "Device NOT FOUND with the provided credentials.\n";
}

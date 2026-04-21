<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$db = db_connect();
$db->table('device_logs')->insert([
    'device_id' => 14,
    'event' => 'test_event',
    'type' => 'success',
    'message' => 'This is a test log from the server',
    'debug_data' => 'Some debug info here',
    'created_at' => date('Y-m-d H:i:s')
]);

echo "Test log inserted for device 14\n";

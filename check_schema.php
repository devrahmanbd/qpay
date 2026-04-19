<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require __DIR__ . '/vendor/autoload.php';
$app = \Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();

$tables = ['api_payments', 'api_logs', 'brands'];

foreach ($tables as $table) {
    echo "--- Table: $table ---\n";
    if (!$db->tableExists($table)) {
        echo "TABLE MISSING!\n";
        continue;
    }
    $fields = $db->getFieldNames($table);
    foreach ($fields as $field) {
        echo "- $field\n";
    }
    echo "\n";
}

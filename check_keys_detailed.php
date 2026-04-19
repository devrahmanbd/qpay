<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);
define('ENVIRONMENT', 'development');
require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

$app = Config\Services::codeigniter();
$app->initialize();

$db = \Config\Database::connect();
$keys = $db->table('api_keys')->get()->getResult();
echo "Found " . count($keys) . " keys:\n";
foreach($keys as $k) {
    echo "- ID: {$k->id}, Prefix: {$k->key_prefix}, Last4: {$k->key_last4}, Hash: {$k->key_hash}, Env: {$k->environment}\n";
}

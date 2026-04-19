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

$brandId = 8;
$merchantId = 1;

$db = \Config\Database::connect();
$keyService = new \App\Libraries\ApiKeyService();

echo "REVOKING old test keys for Brand $brandId...\n";
$db->table('api_keys')
    ->where('brand_id', $brandId)
    ->where('merchant_id', $merchantId)
    ->where('environment', 'test')
    ->delete();

echo "GENERATING new test keys...\n";
$publishable = $keyService->generate($brandId, $merchantId, 'publishable', 'test', 'WooCommerce Test');
$secret = $keyService->generate($brandId, $merchantId, 'secret', 'test', 'WooCommerce Test');

echo "\n--- NEW TEST KEYS ---\n";
echo "Publishable Key: " . $publishable['key'] . "\n";
echo "Secret Key: " . $secret['key'] . "\n";
echo "----------------------\n";

echo "\nVerifying Secret Key...\n";
$validated = $keyService->validate($secret['key']);
if ($validated) {
    echo "SUCCESS: Secret key is valid and recognized by the system.\n";
} else {
    echo "ERROR: Validation failed for the new key!\n";
}

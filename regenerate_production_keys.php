<?php
/**
 * QPay Production Key Regenerator
 * 
 * USE: Visit this file in your browser at https://qpay.cloudman.one/regenerate_production_keys.php
 * PURPOSE: Resolves the 401 Unauthorized error caused by database migration hash mismatches.
 */

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Load CodeIgniter framework
require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

$app = Config\Services::codeigniter();
$app->initialize();

// IDs for the default Merchant/Brand (Based on production check)
$brandId = 8;
$merchantId = 1;

$db = \Config\Database::connect();
$keyService = new \App\Libraries\ApiKeyService();

echo "<h1>QPay Key Regenerator</h1>";
echo "<p>Resetting test keys for Brand ID: $brandId...</p>";

try {
    // Revoke old keys
    $db->table('api_keys')
        ->where('brand_id', $brandId)
        ->where('merchant_id', $merchantId)
        ->where('environment', 'test')
        ->delete();

    // Generate new keys
    $publishable = $keyService->generate($brandId, $merchantId, 'publishable', 'test', 'WooCommerce Test - PROD');
    $secret = $keyService->generate($brandId, $merchantId, 'secret', 'test', 'WooCommerce Test - PROD');

    echo "<h3>New Test Keys Generated Successfully!</h3>";
    echo "<p>Copy these keys into your <strong>WordPress > QPay > Settings</strong>:</p>";
    
    echo "<table border='1' cellpadding='10' style='border-collapse: collapse;'>";
    echo "<tr><th>Key Type</th><th>Key String</th></tr>";
    echo "<tr><td><strong>Test Publishable Key</strong></td><td><code>" . htmlspecialchars($publishable['key']) . "</code></td></tr>";
    echo "<tr><td><strong>Test Secret Key</strong></td><td><code>" . htmlspecialchars($secret['key']) . "</code></td></tr>";
    echo "</table>";

    echo "<p style='color: green;'><strong>System Verification:</strong> ";
    $validated = $keyService->validate($secret['key']);
    if ($validated) {
        echo "The new key is VALID and active on this server.";
    } else {
        echo "ALERT: Key validation failed! Please check your .env SECRET_KEY.";
    }
    echo "</p>";

} catch (Exception $e) {
    echo "<p style='color: red;'><strong>Error:</strong> " . $e->getMessage() . "</p>";
}

echo "<hr><p>Please DELETE this file after use for security.</p>";

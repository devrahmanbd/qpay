<?php
// Mocking CI4 environment to test ApiController
define('FCPATH', __DIR__ . '/');
define('APPPATH', __DIR__ . '/app/');
define('SYSTEMPATH', __DIR__ . '/app/system/');
define('ROOTPATH', __DIR__ . '/');

require_once SYSTEMPATH . 'bootstrap.php';
require_once APPPATH . 'Config/Paths.php';

$paths = new Config\Paths();
$app = Config\Services::codeigniter();
$app->initialize();

use App\Controllers\ApiController;

$controller = new ApiController();
$controller->initController(service('request'), service('response'), service('logger'));

echo "Testing getLogs()...\n";
try {
    $response = $controller->getLogs();
    echo "Response: " . $response . "\n";
} catch (\Throwable $e) {
    echo "CRASH! " . $e->getMessage() . "\n";
    echo $e->getTraceAsString() . "\n";
}

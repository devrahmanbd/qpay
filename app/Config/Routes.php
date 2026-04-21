<?php

$paymentHost = parse_url(getenv('PAYMENT_URL') ?: '', PHP_URL_HOST);
$mainHost = parse_url(getenv('app.baseURL') ?: '', PHP_URL_HOST);

use App\Controllers\ApiController;
use App\Controllers\File_manager;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setDefaultNamespace('Home\Controllers');

$routes->set404Override(function () {
        return view('errors/404');
});
$routes->setAutoRoute(true);

$routes->post('upload_files', [File_manager::class, 'upload_files']);
$routes->post('upload_files_tiny', [File_manager::class, 'upload_files_tiny']);
$routes->get('file-manager/view_files/(:any)', [File_manager::class, 'view_files']);

$routes->match(['get', 'post'], 'api/device-connect', [ApiController::class, 'deviceConnect']);
$routes->match(['get', 'post'], 'api/add-data', [ApiController::class, 'addMessage']);
$routes->match(['get', 'post'], 'api/get-logs', [ApiController::class, 'getLogs']);
$routes->get('api/ping', [ApiController::class, 'ping']);
$routes->get('api/debug-logs', [ApiController::class, 'getSystemLogs']);

$routes->group('', ['hostname' => $mainHost], static function ($routes) {
    $routes->group('/', static function ($routes) {
            $routes->get('cron', [ApiController::class, 'cron']);
            $routes->get('api', [ApiController::class, 'index']);
    });
});

// Checkout Routes (On Checkout Subdomain)
if ($paymentHost) {
    $routes->group('', ['hostname' => $paymentHost], static function ($routes) {
        $routes->get('api/v1/payment/checkout/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'checkout']);
        $routes->post('api/v1/payment/checkout/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'processCheckout']);
        
        // Legacy Theme Compatibility Routes
        $routes->get('api/execute/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'checkout']);
        $routes->get('api/execute_payment/(:any)/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'executePayment']);
        $routes->post('api/save_payment/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'savePayment']);
    });
} else {
    $routes->get('api/v1/payment/checkout/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'checkout']);
    $routes->post('api/v1/payment/checkout/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'processCheckout']);
    
    // Legacy Theme Compatibility Routes
    $routes->get('api/execute/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'checkout']);
    $routes->get('api/execute_payment/(:any)/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'executePayment']);
    $routes->post('api/save_payment/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'savePayment']);
}

$routes->group('api/v1', ['filter' => 'api_auth', 'hostname' => $mainHost], static function ($routes) {
    $routes->post('payments', [\App\Controllers\Api\V1\PaymentController::class, 'create']);
    $routes->post('payment/create', [\App\Controllers\Api\V1\PaymentController::class, 'create']); // Legacy Alias
    
    $routes->get('payments/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'status']);
    $routes->get('payment/status/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'status']); // Legacy Alias
    
    $routes->get('payments', [\App\Controllers\Api\V1\PaymentController::class, 'listPayments']);
    
    $routes->post('payments/(:any)/refund', [\App\Controllers\Api\V1\PaymentController::class, 'refund']);
    
    $routes->post('payments/(:any)/verify', [\App\Controllers\Api\V1\PaymentController::class, 'verify']);
    $routes->match(['get', 'post'], 'payment/verify/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'verify']); // Legacy Alias
    
    $routes->get('balance', [\App\Controllers\Api\V1\PaymentController::class, 'balance']);
    
    $routes->get('methods', [\App\Controllers\Api\V1\PaymentController::class, 'getMethods']);
    $routes->get('payment/methods', [\App\Controllers\Api\V1\PaymentController::class, 'getMethods']); // Legacy Alias
});

<?php

use App\Controllers\ApiController;
use App\Controllers\Api\V1\PaymentControllerV4;
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

$routes->group('/', static function ($routes) {
        $routes->get('cron', [ApiController::class, 'cron']);
        $routes->get('api', [ApiController::class, 'index']);
        $routes->match(['get', 'post'], 'api/device-connect', [ApiController::class, 'deviceConnect']);
        $routes->match(['get', 'post'], 'api/add-data', [ApiController::class, 'addMessage']);
});

$routes->group('api/v1', ['filter' => 'api_auth'], static function ($routes) {
    $routes->post('payments', [\App\Controllers\Api\V1\PaymentController::class, 'create']);
    $routes->get('payments/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'status']);
    $routes->get('payments', [\App\Controllers\Api\V1\PaymentController::class, 'listPayments']);
    $routes->post('payments/(:any)/refund', [\App\Controllers\Api\V1\PaymentController::class, 'refund']);
    $routes->post('payments/(:any)/verify', [\App\Controllers\Api\V1\PaymentController::class, 'verify']);
    $routes->get('balance', [\App\Controllers\Api\V1\PaymentController::class, 'balance']);
    $routes->get('methods', [\App\Controllers\Api\V1\PaymentController::class, 'getMethods']);
    $routes->get('payment/checkout/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'checkout']);
    $routes->post('payment/checkout/(:any)', [\App\Controllers\Api\V1\PaymentController::class, 'processCheckout']);
});

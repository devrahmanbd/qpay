<?php

use App\Controllers\ApiController;
use App\Controllers\Api\V1\PaymentController;
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

$routes->get('api/v1/payment/checkout/(:any)', [PaymentController::class, 'checkout/$1']);
$routes->post('api/v1/payment/checkout/(:any)/process', [PaymentController::class, 'processCheckout/$1']);

$routes->group('api/v1', ['filter' => 'api_auth'], static function ($routes) {
        $routes->post('payment/create', [PaymentController::class, 'create']);
        $routes->match(['get', 'post'], 'payment/verify/(:any)', [PaymentController::class, 'verify/$1']);
        $routes->match(['get', 'post'], 'payment/verify', [PaymentController::class, 'verify']);
        $routes->get('payment/status/(:any)', [PaymentController::class, 'status/$1']);
        $routes->get('payment/methods', [PaymentController::class, 'getMethods']);
        $routes->get('payments', [PaymentController::class, 'listPayments']);
        $routes->get('payments/(:any)', [PaymentController::class, 'status/$1']);
        $routes->post('refunds', [PaymentController::class, 'refund']);
        $routes->get('balance', [PaymentController::class, 'balance']);
});

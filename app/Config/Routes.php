<?php

use App\Controllers\ApiController;
use App\Controllers\Api\V1\PaymentControllerV3;
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

$routes->get('api/v1/payment/checkout/(:any)', [PaymentControllerV3::class, 'checkout/$1']);
$routes->post('api/v1/payment/checkout/(:any)/process', [PaymentControllerV3::class, 'processCheckout/$1']);

$routes->group('api/v1', ['filter' => 'api_auth'], static function ($routes) {
        $routes->post('payment/create', [PaymentControllerV3::class, 'create']);
        $routes->match(['get', 'post'], 'payment/verify/(:any)', [PaymentControllerV3::class, 'verify/$1']);
        $routes->match(['get', 'post'], 'payment/verify', [PaymentControllerV3::class, 'verify']);
        $routes->get('payment/status/(:any)', [PaymentControllerV3::class, 'status/$1']);
        $routes->get('payment/status', [PaymentControllerV3::class, 'status']);
        $routes->get('payments', [PaymentControllerV3::class, 'listPayments']);
        $routes->get('payments/(:any)', [PaymentControllerV3::class, 'status/$1']);
        $routes->post('payment/refund', [PaymentControllerV3::class, 'refund']);
        $routes->post('refunds', [PaymentControllerV3::class, 'refund']); // SDK Compatibility
        $routes->get('balance', [PaymentControllerV3::class, 'balance']);
        $routes->get('methods', [PaymentControllerV3::class, 'getMethods']);
        $routes->get('payment/methods', [PaymentControllerV3::class, 'getMethods']); // SDK Consistency
});

<?php
define('FCPATH', __DIR__ . '/../');
require FCPATH . 'app/Config/Paths.php';
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'development'));
}

$app = Config\Services::codeigniter();
$app->initialize();
$app->setContext('web');

// Mock request
$_POST['user_email'] = 'admin@cloudman.one';
$_POST['device_key'] = 'fVSARTobNKvglddV9QhKlPFTsFcLUD884mmh1wjg';
$_POST['device_ip'] = '127.0.0.1';
$_POST['address'] = 'bkash';
$_POST['message'] = 'Received Tk 500 from 01712345678. TransID: TXN12345';

$controller = new \App\Controllers\ApiController();
$controller->addMessage();

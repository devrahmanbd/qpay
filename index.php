<?php

putenv('database.default.hostname=/tmp/mysql.sock');
putenv('database.default.database=main');
putenv('database.default.username=root');
putenv('database.default.password=harry71Nahid920*');
putenv('database.default.DBDriver=MySQLi');
putenv('database.default.port=3306');
putenv('app.baseURL=http://localhost:5000/');
putenv('CI_ENVIRONMENT=development');
$_SERVER['database.default.hostname'] = '/tmp/mysql.sock';
$_SERVER['database.default.database'] = 'main';
$_SERVER['database.default.username'] = 'root';
$_SERVER['database.default.password'] = 'harry71Nahid920*';
$_SERVER['database.default.DBDriver'] = 'MySQLi';
$_SERVER['database.default.port'] = '3306';
$_SERVER['app.baseURL'] = 'http://localhost:5000/';
$_SERVER['CI_ENVIRONMENT'] = 'development';

$minPhpVersion = '7.4';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}

define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

require FCPATH . 'app/Config/Paths.php';

$paths = new Config\Paths();

require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Override .env values for Replit environment AFTER DotEnv loads
$_SERVER['database.default.hostname'] = '/tmp/mysql.sock';
$_SERVER['database.default.database'] = 'main';
$_SERVER['database.default.username'] = 'root';
$_SERVER['database.default.password'] = 'harry71Nahid920*';
$_SERVER['database.default.DBDriver'] = 'MySQLi';
$_SERVER['database.default.port'] = '3306';
$_SERVER['app.baseURL'] = 'http://localhost:5000/';
$_SERVER['CI_ENVIRONMENT'] = 'development';
$_SERVER['APP_STATUS'] = 'installed';
putenv('database.default.hostname=/tmp/mysql.sock');
putenv('database.default.database=main');
putenv('database.default.username=root');
putenv('database.default.password=harry71Nahid920*');
putenv('app.baseURL=http://localhost:5000/');
putenv('CI_ENVIRONMENT=development');
putenv('APP_STATUS=installed');

// Define ENVIRONMENT
if (!defined('ENVIRONMENT')) {
    define('ENVIRONMENT', 'development');
}



$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);



$app->run();

exit(EXIT_SUCCESS);

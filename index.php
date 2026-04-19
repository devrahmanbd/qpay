<?php

/**
 * CodeIgniter Post-Installation Cleanup
 * 
 * This file has been cleaned to ensure it respects .env and app/Config/ settings.
 * Removed hardcoded overrides (v1.1.0).
 */

// Check PHP version.
$minPhpVersion = '7.4';
if (version_compare(PHP_VERSION, $minPhpVersion, '<')) {
    $message = sprintf(
        'Your PHP version must be %s or higher to run CodeIgniter. Current version: %s',
        $minPhpVersion,
        PHP_VERSION
    );

    exit($message);
}

// Path to the front controller (this file)
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR);

// Ensure the current directory is pointing to the front controller's directory
if (getcwd() . DIRECTORY_SEPARATOR !== FCPATH) {
    chdir(FCPATH);
}

/*
 *---------------------------------------------------------------
 * BOOTSTRAP THE APPLICATION
 *---------------------------------------------------------------
 * This process sets up the path constants, loads and registers
 * our autoloader, along with Composer's, loads our constants
 * and determines the environment.
 */

// Load our paths config file
require FCPATH . 'app/Config/Paths.php';

$paths = new Config\Paths();

// Location of the framework bootstrap file.
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

// Load environment settings from .env files into $_SERVER and $_ENV
require_once SYSTEMPATH . 'Config/DotEnv.php';
(new CodeIgniter\Config\DotEnv(ROOTPATH))->load();

// Define ENVIRONMENT
if (! defined('ENVIRONMENT')) {
    define('ENVIRONMENT', env('CI_ENVIRONMENT', 'production'));
}

if (function_exists('opcache_invalidate')) {
    opcache_invalidate(__DIR__ . '/app/Filters/ApiAuth.php', true);
    opcache_invalidate(__DIR__ . '/app/Controllers/Api/V1/PaymentController.php', true);
}

/*
 * ---------------------------------------------------------------
 * LAUNCH THE APPLICATION
 * ---------------------------------------------------------------
 * Now that everything is setup, it's time to actually run
 * the application and send it on its way.
 */

$app = Config\Services::codeigniter();
$app->initialize();
$context = is_cli() ? 'php-cli' : 'web';
$app->setContext($context);
$app->run();

exit(EXIT_SUCCESS);

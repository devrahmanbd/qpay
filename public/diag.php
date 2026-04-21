<?php
/**
 * QPay Standalone Diagnostic Tool
 * Used to verify server state when main API is failing/out of sync.
 */

define('DIAG_VERSION', '1.1');
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

$response = [
    'diag_version' => DIAG_VERSION,
    'time' => date('Y-m-d H:i:s'),
    'php_version' => PHP_VERSION,
    'server_name' => $_SERVER['SERVER_NAME'] ?? 'unknown',
];

// 1. Check Directory Structure
$paths = [
    'app' => __DIR__ . '/../app',
    'writable' => __DIR__ . '/../writable',
    'logs' => __DIR__ . '/../writable/logs',
    'api_controller' => __DIR__ . '/../app/Controllers/ApiController.php'
];

foreach ($paths as $key => $path) {
    if (file_exists($path)) {
        $response['paths'][$key] = [
            'exists' => true,
            'is_writable' => is_writable($path),
            'mtime' => date('Y-m-d H:i:s', filemtime($path))
        ];
    } else {
        $response['paths'][$key] = ['exists' => false];
    }
}

// 2. Check Database (Manually parse .env if possible)
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    $host = $env['database.default.hostname'] ?? 'localhost';
    $user = $env['database.default.username'] ?? 'root';
    $pass = $env['database.default.password'] ?? 'harry71Nahid920*';
    $dbName = $env['database.default.database'] ?? 'main';

    try {
        $conn = new mysqli($host, $user, $pass, $dbName);
        if ($conn->connect_error) {
            $response['database'] = ['status' => 'error', 'error' => $conn->connect_error];
        } else {
            $response['database'] = ['status' => 'connected', 'db' => $dbName];
            $conn->close();
        }
    } catch (Exception $e) {
        $response['database'] = ['status' => 'exception', 'error' => $e->getMessage()];
    }
}

// 3. Fetch Last Logs
$logFile = __DIR__ . '/../writable/logs/log-' . date('Y-m-d') . '.log';
if (file_exists($logFile)) {
    $content = file_get_contents($logFile);
    $lines = explode("\n", $content);
    $response['recent_logs'] = array_slice($lines, -20);
} else {
    $response['recent_logs'] = "No log file found for today: " . basename($logFile);
}

echo json_encode($response, JSON_PRETTY_PRINT);

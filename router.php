<?php
// PHP Built-in Server Router
// Serve static files from public/ directory
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Check if this is a static file that should be served directly
if ($uri !== '/' && file_exists(__DIR__ . $uri)) {
    // Let PHP built-in server handle the static file
    return false;
}

// All other requests go through CodeIgniter
require_once __DIR__ . '/index.php';

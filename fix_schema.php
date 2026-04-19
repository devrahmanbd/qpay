<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
// We can't use vendor/autoload easily, so we'll use a direct PDO connection with credentials from .env
$env = parse_ini_file('.env');

$host = $env['database.default.hostname'] ?? 'localhost';
$dbName = $env['database.default.database'] ?? 'main';
$user = $env['database.default.username'] ?? 'root';
$pass = $env['database.default.password'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "UPDATING api_payments table...\n";
    
    // Use IF NOT EXISTS equivalent logic
    $columns = $pdo->query("SHOW COLUMNS FROM api_payments")->fetchAll(PDO::FETCH_COLUMN);
    
    if (!in_array('test_mode', $columns)) {
        echo "Adding test_mode column...\n";
        $pdo->exec("ALTER TABLE api_payments ADD COLUMN test_mode TINYINT(1) DEFAULT 0 AFTER status");
    } else {
        echo "test_mode already exists.\n";
    }

    if (!in_array('webhook_delivered', $columns)) {
        echo "Adding webhook_delivered column...\n";
        $pdo->exec("ALTER TABLE api_payments ADD COLUMN webhook_delivered TINYINT(1) DEFAULT 0 AFTER test_mode");
    } else {
        echo "webhook_delivered already exists.\n";
    }

    echo "SUCCESS: Database schema updated.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

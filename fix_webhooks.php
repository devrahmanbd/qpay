<?php
$env = parse_ini_file('.env');
$host = $env['database.default.hostname'] ?? 'localhost';
$dbName = $env['database.default.database'] ?? 'main';
$user = $env['database.default.username'] ?? 'root';
$pass = $env['database.default.password'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "UPDATING webhooks table...\n";
    
    $columns = $pdo->query("SHOW COLUMNS FROM webhooks")->fetchAll(PDO::FETCH_COLUMN);
    
    if (in_array('is_active', $columns) && !in_array('status', $columns)) {
        echo "Renaming is_active to status...\n";
        $pdo->exec("ALTER TABLE webhooks CHANGE COLUMN is_active status TINYINT(1) NOT NULL DEFAULT 1");
        echo "SUCCESS: webhooks table updated.\n";
    } else {
        echo "Column 'status' already exists or 'is_active' missing.\n";
    }

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

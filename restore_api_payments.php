<?php
$env = parse_ini_file('.env');
$host = $env['database.default.hostname'] ?? 'localhost';
$dbName = $env['database.default.database'] ?? 'main';
$user = $env['database.default.username'] ?? 'root';
$pass = $env['database.default.password'] ?? '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbName", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "CREATING api_payments table...\n";
    
    $sql = "CREATE TABLE `api_payments` (
      `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
      `ids` varchar(50) NOT NULL,
      `merchant_id` int(10) unsigned NOT NULL,
      `brand_id` int(10) unsigned DEFAULT NULL,
      `idempotency_key` varchar(255) DEFAULT NULL,
      `amount` decimal(12,3) NOT NULL DEFAULT 0.000,
      `currency` varchar(10) NOT NULL DEFAULT 'BDT',
      `status` tinyint(1) NOT NULL DEFAULT 0 COMMENT '0=pending,1=processing,2=completed,3=failed,4=refunded',
      `test_mode` tinyint(1) DEFAULT 0,
      `webhook_delivered` tinyint(1) DEFAULT 0,
      `transaction_id` varchar(50) DEFAULT NULL,
      `payment_method` varchar(50) DEFAULT NULL,
      `callback_url` text DEFAULT NULL,
      `success_url` text DEFAULT NULL,
      `cancel_url` text DEFAULT NULL,
      `customer_email` varchar(255) DEFAULT NULL,
      `customer_name` varchar(255) DEFAULT NULL,
      `metadata` text DEFAULT NULL,
      `provider_response` text DEFAULT NULL,
      `ip_address` varchar(50) DEFAULT NULL,
      `created_at` datetime DEFAULT NULL,
      `updated_at` datetime DEFAULT NULL,
      PRIMARY KEY (`id`),
      UNIQUE KEY `ids` (`ids`),
      UNIQUE KEY `idx_idempotency` (`merchant_id`,`brand_id`,`idempotency_key`),
      KEY `merchant_id` (`merchant_id`),
      KEY `brand_id` (`brand_id`),
      KEY `status` (`status`),
      KEY `transaction_id` (`transaction_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";

    $pdo->exec($sql);

    echo "SUCCESS: api_payments table created.\n";
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    exit(1);
}

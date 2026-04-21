<?php
$db = mysqli_connect('localhost', 'root', 'harry71Nahid920*', 'main');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

// 1. Add device_id to module_data
$sql_add_column = "ALTER TABLE `module_data` ADD COLUMN `device_id` INT UNSIGNED NULL AFTER `uid`";
if ($db->query($sql_add_column)) {
    echo "Added device_id column to module_data\n";
} else {
    echo "Error adding column: " . $db->error . "\n";
}

// 2. Create device_logs table
$sql_create_table = "CREATE TABLE IF NOT EXISTS `device_logs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `device_id` INT UNSIGNED NOT NULL,
  `type` ENUM('info', 'success', 'warning', 'error') DEFAULT 'info',
  `event` VARCHAR(50) NOT NULL,
  `message` TEXT,
  `debug_data` TEXT,
  `created_at` DATETIME DEFAULT CURRENT_TIMESTAMP,
  INDEX (`device_id`),
  INDEX (`created_at`)
)";

if ($db->query($sql_create_table)) {
    echo "Created device_logs table\n";
} else {
    echo "Error creating table: " . $db->error . "\n";
}

mysqli_close($db);

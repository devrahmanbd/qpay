<?php

// Direct MySQL fix script (no framework dependencies)
$host = 'localhost';
$user = 'root';
$pass = 'harry71Nahid920*'; // Using the root password discovered earlier
$db_name = 'main';

$conn = new mysqli($host, $user, $pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to database: $db_name\n";

// 1. Identify transactions with missing data
$sql = "SELECT id, ids, transaction_id FROM transactions WHERE (currency IS NULL OR currency = '') OR (type IS NULL OR type = '')";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "Found " . $result->num_rows . " transactions to fix.\n";
    while($row = $result->fetch_assoc()) {
        $trx_id = $row['id'];
        $ids = $row['ids'];
        
        // Find matching api_payment
        $api_sql = "SELECT payment_method, currency, brand_id FROM api_payments WHERE ids = '" . $conn->real_escape_with_quote($ids) . "' LIMIT 1";
        // Manual escape just in case real_escape_string isn't enough for ids
        $safe_ids = $conn->real_escape_string($ids);
        $api_sql = "SELECT payment_method, currency, brand_id FROM api_payments WHERE ids = '$safe_ids' LIMIT 1";
        $api_result = $conn->query($api_sql);
        
        if ($api_result->num_rows > 0) {
            $api_data = $api_result->fetch_assoc();
            $type = !empty($api_data['payment_method']) ? $api_data['payment_method'] : 'api';
            $currency = !empty($api_data['currency']) ? $api_data['currency'] : 'BDT';
            $brand_id = !empty($api_data['brand_id']) ? $api_data['brand_id'] : '0';
            
            $update_sql = "UPDATE transactions SET type = '$type', currency = '$currency', brand_id = '$brand_id' WHERE id = $trx_id";
            if ($conn->query($update_sql)) {
                echo "Fixed Transaction ID $trx_id (Type: $type, Currency: $currency)\n";
            } else {
                echo "Error updating record $trx_id: " . $conn->error . "\n";
            }
        } else {
            // Fallback for orphaned transactions
            $update_sql = "UPDATE transactions SET type = 'api', currency = 'BDT' WHERE id = $trx_id";
            $conn->query($update_sql);
            echo "Fixed Transaction ID $trx_id with defaults.\n";
        }
    }
} else {
    echo "No transactions found needing fixes.\n";
}

$conn->close();
echo "Fix complete.\n";

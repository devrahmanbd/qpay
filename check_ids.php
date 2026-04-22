<?php

/**
 * Diagnostic Script: check_payment_ids.php
 */

// --- CONFIGURATION ---
$host     = 'localhost';
$db_user  = 'clou_qpay1';
$db_pass  = 'harry71Nahid920*';
$db_name  = 'clou_qpay1';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error . "\n");

$ids = '2ea3c247e95d9c7bece301d70faef9b2';

echo "--- Diagnostic for Payment: $ids ---\n";

$sql = "SELECT payment_method, provider_response FROM api_payments WHERE ids = '$ids'";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "Raw Payment Method: " . ($row['payment_method'] ?: '[EMPTY]') . "\n";
    echo "Provider Response: " . substr($row['provider_response'], 0, 500) . "...\n";
} else {
    echo "Payment record not found.\n";
}

$conn->close();

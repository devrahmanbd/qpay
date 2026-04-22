<?php

/**
 * Diagnostic Script: check_db.php
 * 
 * Lists recent transactions and api_payments to debug dashboard synchronization.
 */

// --- CONFIGURATION (User: please verify these match your server) ---
$host     = 'localhost';
$db_user  = 'clou_qpay1';
$db_pass  = 'harry71Nahid920*';
$db_name  = 'clou_qpay1';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error . "\n");

echo "--- QPay Database Diagnostic ---\n";

echo "\n1. Recent Transactions (last 5):\n";
$sql = "SELECT id, ids, uid, type, amount, currency, status, created_at FROM transactions ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        printf("ID: %-4d | IDS: %-32s | UID: %-2d | Type: %-10s | Amt: %-8s | Cur: %-4s | Stat: %-1d | Date: %s\n", 
            $row['id'], $row['ids'], $row['uid'], $row['type'], $row['amount'], $row['currency'], $row['status'], $row['created_at']);
    }
} else {
    echo "No transactions found in 'transactions' table.\n";
}

echo "\n2. Recent API Payments (last 5):\n";
$sql = "SELECT id, ids, merchant_id, payment_method, amount, status, created_at FROM api_payments ORDER BY id DESC LIMIT 5";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        printf("ID: %-4d | IDS: %-32s | Merchant: %-2d | Method: %-10s | Amt: %-8s | Stat: %-1d | Date: %s\n", 
            $row['id'], $row['ids'], $row['merchant_id'], $row['payment_method'], $row['amount'], $row['status'], $row['created_at']);
    }
} else {
    echo "No API payments found.\n";
}

$conn->close();
echo "\nDiagnostic complete.\n";

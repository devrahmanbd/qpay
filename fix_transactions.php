<?php

/**
 * Advanced Maintenance Script: fix_transactions.php
 * 
 * This version adds detailed debug logging to see why names are defaulting to 'Api'.
 */

// --- CONFIGURATION ---
$host     = 'localhost';
$db_user  = 'clou_qpay1';
$db_pass  = 'harry71Nahid920*';
$db_name  = 'clou_qpay1';

$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error . "\n");

echo "--- QPay Dashboard Metadata Repair (Advanced) ---\n";

// 1. Find transactions to process
$sql = "SELECT id, ids, type, currency FROM transactions WHERE status = 2 AND (type = 'api' OR type IS NULL OR type = '')";
$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "No matching transactions found requiring fix.\n";
    exit;
}

echo "Found " . $result->num_rows . " transactions to inspect.\n";

$methodMap = [
    'dutch bangla bank' => 'dbbl',
    'dutch-bangla'      => 'dbbl',
    'dbbl'              => 'dbbl',
    'bkash'             => 'bkash',
    'nagad'             => 'nagad',
    'rocket'            => 'rocket'
];

while ($trx = $result->fetch_assoc()) {
    $trx_id = $trx['id'];
    $ids = $trx['ids'];
    echo "\nChecking Transaction ID: $trx_id (Ref: $ids)\n";

    $api_sql = "SELECT payment_method, provider_response FROM api_payments WHERE ids = '$ids' LIMIT 1";
    $api_result = $conn->query($api_sql);
    
    $finalMethod = 'api'; // default
    
    if ($api_result && $api_result->num_rows > 0) {
        $api_data = $api_result->fetch_assoc();
        $rawMethod = trim($api_data['payment_method'] ?? '');
        $providerResponse = $api_data['provider_response'] ?? '';

        echo "  - Raw method in DB: '" . ($rawMethod ?: "[EMPTY]") . "'\n";

        if ($rawMethod && $rawMethod !== 'api') {
            $finalMethod = $methodMap[strtolower($rawMethod)] ?? $rawMethod;
            echo "  - Found method in column: $finalMethod\n";
        } else {
            // Try to guess from provider response
            echo "  - Column is empty. Inspecting Provider Response JSON...\n";
            if (stripos($providerResponse, 'nagad') !== false) {
                $finalMethod = 'nagad';
                echo "  - Guessed 'nagad' from response content.\n";
            } elseif (stripos($providerResponse, 'bkash') !== false) {
                $finalMethod = 'bkash';
                echo "  - Guessed 'bkash' from response content.\n";
            } elseif (stripos($providerResponse, 'dbbl') !== false || stripos($providerResponse, 'dutch') !== false) {
                $finalMethod = 'dbbl';
                echo "  - Guessed 'dbbl' from response content.\n";
            } else {
                echo "  - Could not guess. Defaulting to 'api'.\n";
            }
        }

        // Update the record
        $update_sql = "UPDATE transactions SET type = '" . $conn->real_escape_string($finalMethod) . "', currency = 'BDT' WHERE id = $trx_id";
        if ($conn->query($update_sql)) {
            echo "  [SUCCESS] Updated to: $finalMethod\n";
        } else {
            echo "  [ERROR] Update failed: " . $conn->error . "\n";
        }
    } else {
        echo "  [SKIP] No matching record in api_payments table.\n";
    }
}

echo "\nDone. Please check your dashboard.\n";
$conn->close();

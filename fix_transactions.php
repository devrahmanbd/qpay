<?php

/**
 * Production Maintenance Script: fix_transactions.php
 * 
 * Purpose: This script resolves the "Api" naming issue in the dashboard by 
 * looking up which wallet is actually enabled for the specific brand.
 */

// --- CONFIGURATION (Production) ---
$host     = 'localhost';
$db_user  = 'clou_qpay1';
$db_pass  = 'harry71Nahid920*';
$db_name  = 'clou_qpay1';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "--- QPay Dashboard Wallet Detection Sync ---\n";

// 1. Establish Database Connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error . "\n");

echo "Connected successfully to: $db_name\n";

// 2. Find transactions that need repair (either missing or generic 'api' type)
$sql = "SELECT id, ids, type, uid FROM transactions 
        WHERE status = 2 
        AND (type = 'api' OR type IS NULL OR type = '')";

$result = $conn->query($sql);

if (!$result || $result->num_rows === 0) {
    echo "No transactions found requiring repair.\n";
    $conn->close();
    exit;
}

echo "Inspecting " . $result->num_rows . " transactions...\n";

$fixed_count = 0;
$methodMap = [
    'dutch bangla bank' => 'dbbl',
    'dutch-bangla'      => 'dbbl',
    'dbbl'              => 'dbbl',
    'bkash'             => 'bkash',
    'nagad'             => 'nagad',
    'rocket'            => 'rocket'
];

// 3. Process each transaction with database-driven lookup
while ($trx = $result->fetch_assoc()) {
    $trx_id = $trx['id'];
    $ids = $trx['ids'];
    $merchant_id = $trx['uid'];
    
    echo "\nProcessing Transaction ID #$trx_id (Ref: $ids)\n";
    
    // 3.1. Get brand_id from api_payments
    $safe_ids = $conn->real_escape_string($ids);
    $api_sql = "SELECT brand_id, merchant_id, payment_method FROM api_payments WHERE ids = '$safe_ids' LIMIT 1";
    $api_result = $conn->query($api_sql);
    
    if ($api_result && $api_record = $api_result->fetch_assoc()) {
        $brand_id = $api_record['brand_id'];
        $m_id = $api_record['merchant_id'];
        $rawMethod = trim($api_record['payment_method'] ?? '');

        echo "  - Brand ID: $brand_id, Merchant ID: $m_id\n";

        // 3.2. If method is already known in api_payments, just use it
        if (!empty($rawMethod) && $rawMethod !== 'api') {
            $finalType = $methodMap[strtolower($rawMethod)] ?? $rawMethod;
            echo "  - Found method in api_payments: $finalType\n";
        } else {
            // 3.3. LOOKUP ACTIVE WALLET: Find which wallet is actually ENABLED for this brand
            echo "  - Method missing. Checking active wallets for Brand #$brand_id...\n";
            $wallet_sql = "SELECT g_type FROM user_payment_settings WHERE brand_id = '$brand_id' AND status = 1 LIMIT 1";
            $wallet_result = $conn->query($wallet_sql);
            
            if ($wallet_result && $wallet = $wallet_result->fetch_assoc()) {
                $finalType = $wallet['g_type'];
                echo "  - Detected Active Wallet: $finalType\n";
            } else {
                $finalType = 'api';
                echo "  - No active wallet found in settings. Staying as 'api'.\n";
            }
        }

        // 3.4. Final Update
        if ($finalType !== 'api') {
            $update_sql = "UPDATE transactions SET type = '" . $conn->real_escape_string($finalType) . "' WHERE id = $trx_id";
            if ($conn->query($update_sql)) {
                echo "  [SUCCESS] Transaction type updated to: $finalType\n";
                $fixed_count++;
            } else {
                echo "  [ERROR] Update failed: " . $conn->error . "\n";
            }
        }
    } else {
        echo "  [SKIP] No matching API payment record found.\n";
    }
}

echo "\n--- Summary ---\n";
echo "Total Records Fixed: $fixed_count\n";
echo "Done. Please check your Dashboard.\n";

$conn->close();

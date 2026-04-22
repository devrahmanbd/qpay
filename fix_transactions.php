<?php

/**
 * Standalone Maintenance Script: fix_transactions.php
 * 
 * This script fixes transactions that are missing metadata (type, currency) 
 * required for the Merchant Dashboard counters.
 * 
 * It uses direct MySQLi to avoid CodeIgniter routing issues (404 errors) 
 * when run from the command line.
 */

// --- CONFIGURATION (Based on your .env) ---
$host     = 'localhost';
$db_user  = 'root';
$db_pass  = 'harry71Nahid920*';
$db_name  = 'main';

// Set error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "--- QPay Dashboard Metadata Repair ---\n";

// 1. Establish Database Connection
$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error . "\n");
}

echo "Connected to database: $db_name\n";

// 2. Find transactions that need fixing
// We look for 'Success' status (2) where type or currency is blank
$sql = "SELECT id, ids, type, currency FROM transactions 
        WHERE status = 2 
        AND (type IS NULL OR type = '' OR currency IS NULL OR currency = '')";

$result = $conn->query($sql);

if (!$result) {
    die("Query error: " . $conn->error . "\n");
}

$total_found = $result->num_rows;
echo "Found $total_found transactions requiring metadata repair.\n";

if ($total_found === 0) {
    echo "Nothing to fix. Your dashboard should be up to date.\n";
    $conn->close();
    exit;
}

$fixed_count = 0;

// 3. Process each transaction
while ($trx = $result->fetch_assoc()) {
    $trx_id = $trx['id'];
    $ids = $trx['ids'];
    
    echo "Processing Transaction ID: $trx_id (Ref: $ids)...\n";
    
    // Find matching API payment to recover metadata
    $safe_ids = $conn->real_escape_string($ids);
    $api_sql = "SELECT payment_method, currency, brand_id FROM api_payments WHERE ids = '$safe_ids' LIMIT 1";
    $api_result = $conn->query($api_sql);
    
    $updateData = [];
    
    if ($api_result && $api_result->num_rows > 0) {
        $api_data = $api_result->fetch_assoc();
        
        if (empty($trx['type'])) {
            $updateData[] = "type = '" . $conn->real_escape_string(!empty($api_data['payment_method']) ? $api_data['payment_method'] : 'api') . "'";
        }
        if (empty($trx['currency'])) {
            $updateData[] = "currency = '" . $conn->real_escape_string(!empty($api_data['currency']) ? $api_data['currency'] : 'BDT') . "'";
        }
        // Force update brand_id if missing
        $updateData[] = "brand_id = '" . $conn->real_escape_string(!empty($api_data['brand_id']) ? $api_data['brand_id'] : '0') . "'";
    } else {
        // Fallback for orphaned transactions
        if (empty($trx['type'])) $updateData[] = "type = 'api'";
        if (empty($trx['currency'])) $updateData[] = "currency = 'BDT'";
    }

    if (!empty($updateData)) {
        $update_sql = "UPDATE transactions SET " . implode(", ", $updateData) . " WHERE id = $trx_id";
        if ($conn->query($update_sql)) {
            echo "   [SUCCESS] Updated metadata.\n";
            $fixed_count++;
        } else {
            echo "   [ERROR] Failed to update: " . $conn->error . "\n";
        }
    }
}

echo "\n--- Summary ---\n";
echo "Total Fixed: $fixed_count\n";
echo "Done. Please refresh your Merchant Dashboard.\n";

$conn->close();

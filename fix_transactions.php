<?php

// Maintenance Script: fix_transactions.php
// Purpose: Fixes synced transactions that are missing metadata required for dashboard counters.
// Usage: php fix_transactions.php

require_once __DIR__ . '/index.php'; // Assuming this is placed in the project root

$db = \Config\Database::connect();

echo "Starting Transaction Metadata Fix...\n";

// Find all successful transactions that might be missing type or currency
$transactions = $db->table('transactions')
    ->where('status', 2)
    ->groupStart()
        ->where('currency', '')
        ->orWhere('currency', null)
        ->orWhere('type', '')
        ->orWhere('type', null)
    ->groupEnd()
    ->get()
    ->getResult();

echo "Found " . count($transactions) . " records to inspect.\n";

$count = 0;
foreach ($transactions as $trx) {
    if (empty($trx->ids)) {
        continue;
    }

    // Attempt to recover metadata from the API payments table
    $apiPayment = $db->table('api_payments')->where('ids', $trx->ids)->get()->getRow();
    
    $updateData = [];
    if ($apiPayment) {
        if (empty($trx->currency)) {
            $updateData['currency'] = !empty($apiPayment->currency) ? $apiPayment->currency : 'BDT';
        }
        if (empty($trx->type)) {
            $updateData['type'] = !empty($apiPayment->payment_method) ? $apiPayment->payment_method : 'api';
        }
        if (empty($trx->brand_id)) {
            $updateData['brand_id'] = $apiPayment->brand_id;
        }
    } else {
        // Fallback for transactions without an API record
        if (empty($trx->currency)) $updateData['currency'] = 'BDT';
        if (empty($trx->type)) $updateData['type'] = 'api';
    }

    if (!empty($updateData)) {
        $db->table('transactions')->where('id', $trx->id)->update($updateData);
        echo "Updated Transaction #{$trx->id} (IDS: {$trx->ids}) - Type: " . ($updateData['type'] ?? 'unchanged') . ", Cur: " . ($updateData['currency'] ?? 'unchanged') . "\n";
        $count++;
    }
}

echo "Maintenance complete. Fixed $count records.\n";
echo "Please refresh your dashboard to see the updated counters.\n";

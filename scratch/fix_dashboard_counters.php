<?php

// Fix script to update existing transactions that are missing dashboard metadata
require_once __DIR__ . '/../index.php';

$db = \Config\Database::connect();

echo "Starting fix script...\n";

// 1. Find transactions with missing type or currency
$transactions = $db->table('transactions')
    ->where('currency', '')
    ->orWhere('currency', null)
    ->orWhere('type', '')
    ->orWhere('type', null)
    ->get()
    ->getResult();

echo "Found " . count($transactions) . " records to check.\n";

$count = 0;
foreach ($transactions as $trx) {
    if (empty($trx->ids)) continue;

    // Find the source API payment
    $apiPayment = $db->table('api_payments')->where('ids', $trx->ids)->get()->getRow();
    
    if ($apiPayment) {
        $updateData = [];
        if (empty($trx->currency)) {
            $updateData['currency'] = !empty($apiPayment->currency) ? $apiPayment->currency : 'BDT';
        }
        if (empty($trx->type)) {
            $updateData['type'] = !empty($apiPayment->payment_method) ? $apiPayment->payment_method : 'api';
        }
        if (empty($trx->brand_id)) {
            $updateData['brand_id'] = $apiPayment->brand_id;
        }

        if (!empty($updateData)) {
            $db->table('transactions')->where('id', $trx->id)->update($updateData);
            echo "Fixed Transaction ID: {$trx->transaction_id} (Internal ID: {$trx->id})\n";
            $count++;
        }
    } else {
        // If not found in api_payments, maybe it's a test one. 
        // We'll just give it defaults to make the dashboard happy.
        $db->table('transactions')->where('id', $trx->id)->update([
            'currency' => 'BDT',
            'type' => 'api'
        ]);
        echo "Fixed Transaction ID: {$trx->transaction_id} with defaults.\n";
        $count++;
    }
}

echo "Finished. Total records fixed: $count\n";

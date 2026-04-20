<?php
/**
 * QPay Checkout Test Script
 * This script demonstrates the full flow of creating a payment and getting a checkout URL.
 */

// 1. Configuration
$apiUrl = 'https://qpay.cloudman.one/api/v1/payment/create';
$apiKey = 'qp_live_30...9726'; // Please replace with your actual API key

echo "--- QPay Checkout Integration Test ---\n";

// 2. Prepare Payment Data
$data = [
    'amount' => 10,
    'currency' => 'BDT',
    'customer_name' => 'Test Customer',
    'customer_email' => 'test@example.com',
    'success_url' => 'https://qpay.cloudman.one/success',
    'cancel_url' => 'https://qpay.cloudman.one/cancel',
    'metadata' => [
        'order_id' => 'TEST_'.time(),
        'source' => 'manual_test'
    ]
];

echo "Step 1: Creating payment with amount: {$data['amount']} {$data['currency']}...\n";

// 3. API Call
$ch = curl_init($apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'API-KEY: ' . $apiKey
]);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

// 4. Handle Response
if ($httpCode === 201) {
    $result = json_decode($response, true);
    echo "SUCCESS: Payment created!\n";
    echo "Payment ID: " . $result['id'] . "\n";
    echo "\n--- ACTION REQUIRED ---\n";
    echo "Open this link in your browser to test the checkout:\n";
    echo $result['checkout_url'] . "\n";
    echo "------------------------\n";
    echo "Note: If you have configured the subdomain correctly, this URL should point to 'checkout.qpay.cloudman.one'.\n";
} else {
    echo "FAILED: HTTP Code {$httpCode}\n";
    echo "Response: " . $response . "\n";
}

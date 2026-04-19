<?php
$url = 'https://qpay.cloudman.one/api/v1/payment/create';
$apiKey = 'qp_test_b88ca455b4529a1394d86ec858a22d80c0aac096a38a23ff';

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'API-KEY: ' . $apiKey,
    'Content-Type: application/json'
]);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
    'amount' => 10,
    'currency' => 'BDT',
    'customer_email' => 'test@example.com'
]));
// Include headers in output
curl_setopt($ch, CURLOPT_HEADER, true);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP CODE: $httpCode\n";
echo "RESPONSE:\n$response\n";

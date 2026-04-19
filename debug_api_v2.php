<?php
$apiKey = 'qp_test_5431627cde97fd0c07ba69c4951bbdafb8bb0bf57ecc162a'; // I generated this locally earlier, but I need the user's fresh key.
// Actually, I will use a dummy key to see if I get a 401 JSON or a Redirect HTML.

$url = 'https://qpay.cloudman.one/api/v1/payment/create';
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['amount' => 100]));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'API-KEY: ' . $apiKey,
    'Content-Type: application/json',
    'Accept: application/json'
]);
curl_setopt($ch, CURLOPT_HEADER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, false); // IMPORTANT: Don't follow redirects to see if it happens

$response = curl_exec($ch);
$info = curl_getinfo($ch);

echo "HTTP CODE: " . $info['http_code'] . "\n";
echo "RESPONSE:\n" . $response . "\n";
curl_close($ch);

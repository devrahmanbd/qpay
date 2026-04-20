<style>
    .transaction,
    .payment_submit_done {
        display: none;
    }
</style>

<?php
if (!empty($_GET['binance'])) {
    if ($all_info['tmp_ids'] == $this->custom_encryption->decrypt($_GET['binance'])) {
        $redi = base_url("api/checkout/binance/" . encrypt($data['all_info']['tmp_ids']) . '/' . encodeParams('2'));
        header("Location: " . $redi);
        exit();
    }
}

function generate_random_string() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < 32; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

$rate = 1;
if (get_option('currency_code') != 'USD') {
    $new_currency_rate = get_option('new_currecry_rate');
    if ($new_currency_rate !== null && $new_currency_rate != 0) {
        $rate = 1 / $new_currency_rate;
    }

    if (!empty(get_value($setting['params'], 'dollar_rate'))) {
        $rate = 1 / get_value($setting['params'], 'dollar_rate');
    }
}

$amount = ($all_info['total_amount'] * $rate);

$req = array(
    'env' => array('terminalType' => 'WEB'),
    'merchantTradeNo' => generate_random_string()
);

$req['orderAmount'] = $amount;
$req['currency'] = 'USDT';

$req['goods'] = array();
$req['passThroughInfo'] = "trustpaybd";
$req['goods']['goodsType'] = "02";
$req['goods']['goodsCategory'] = "Z000";

$req['goods']['referenceGoodsId'] = "trustpaybd";
$req['goods']['goodsName'] = "trustpaybd";
$req['returnUrl'] = current_url() . '?binance=' . encrypt($all_info['tmp_ids']);
$req['cancelUrl'] = base_url("api/execute/" . session('tmp_ids'));
$req['webhookUrl'] = base_url("callback/binance/" . encrypt($all_info['tmp_ids']));
$nonce = generate_random_string();
$body = json_encode($req);
$microtime = microtime(true);
$seconds = floor($microtime);
$milliseconds = sprintf('%03d', ($microtime - $seconds) * 1000);
$timestamp = $seconds . $milliseconds;
$payload = $timestamp . "\n" . $nonce . "\n" . $body . "\n";
$secretKey = get_value($setting['params'], 'secret_key');
$signature = strtoupper(hash_hmac('sha512', $payload, $secretKey));
$apiKey = get_value($setting['params'], 'api_key');

$headers = array(
    'Content-Type' => 'application/json',
    "BinancePay-Timestamp" => $timestamp,
    "BinancePay-Nonce" => $nonce,
    "BinancePay-Certificate-SN" => $apiKey,
    "BinancePay-Signature" => $signature
);
$args = array(
    'body' => json_encode($req),
    'timeout' => '60',
    'redirection' => '8',
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => $headers,
    'cookies' => array(),
);

// Initialize cURL session
$apiUrl = get_value($setting['params'], 'api_url');

$curl = curl_init($apiUrl . 'v2/order');

// Set cURL options
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($req));
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'BinancePay-Timestamp: ' . $timestamp,
    'BinancePay-Nonce: ' . $nonce,
    'BinancePay-Certificate-SN: ' . $apiKey,
    'BinancePay-Signature: ' . $signature
));
curl_setopt($curl, CURLOPT_TIMEOUT, 60);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // Adjust as needed

// Execute the cURL request
$response = curl_exec($curl);
$error = curl_error($curl);
$result = json_decode($response, true);

if ($result['code'] != '000000') {
    echo "<div>" . $result['errorMessage'] . "</div>";
} else {
    $detail = $result['data'];
?>
    <script type="text/javascript">
        document.write("Redirecting to Payment Page...");
        setTimeout(function() {
            window.location.href = "<?php echo $detail['universalUrl']; ?>";
        }, 2000); // Wait for 2 seconds before redirecting
    </script>

<?php
}
?>
<span>if the page doesn't redirect automatically, click the following link:</span>
<div class="bottom" style="color: blue;"><a href="<?= base_url("api/checkout/binance/" . encrypt($all_info['tmp_ids']) . '/' . encodeParams('2')); ?>">Proceed to complete the payment process</a></div>

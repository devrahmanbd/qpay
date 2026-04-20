<?php

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;

class BinanceAdapter implements PaymentProviderInterface
{
    protected $db;
    protected $merchantId;
    protected $brandId;
    protected $config;

    public function __construct(int $merchantId, int $brandId, array $config = [])
    {
        $this->db = db_connect();
        $this->merchantId = $merchantId;
        $this->brandId = $brandId;
        $this->config = $config;
    }

    public function initiatePayment(array $paymentData): array
    {
        $wallet = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', 'binance')
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$wallet) {
            return ['success' => false, 'message' => 'Binance Pay not configured.'];
        }

        $params = json_decode($wallet->params, true) ?: [];
        $apiKey = $params['api_key'] ?? '';
        $secretKey = $params['secret_key'] ?? '';
        $apiUrl = rtrim($params['api_url'] ?? 'https://bpay.binanceapi.com/binancepay/openapi/', '/') . '/';
        $dollarRate = (float)($params['dollar_rate'] ?? 1);

        $amount = $paymentData['amount'];
        if ($dollarRate > 0) {
            $amount = $amount / $dollarRate;
        }

        $nonce = $this->generateRandomString(32);
        $timestamp = round(microtime(true) * 1000);

        $req = [
            'env' => ['terminalType' => 'WEB'],
            'merchantTradeNo' => $this->generateRandomString(32),
            'orderAmount' => number_format($amount, 2, '.', ''),
            'currency' => 'USDT',
            'goods' => [
                'goodsType' => '02',
                'goodsCategory' => 'Z000',
                'referenceGoodsId' => 'qpay_payment',
                'goodsName' => 'Payment for services'
            ],
            'returnUrl' => base_url("api/v1/payment/checkout/" . $paymentData['ids'] . "?status=success"),
            'cancelUrl' => base_url("api/v1/payment/checkout/" . $paymentData['ids'] . "?status=cancel"),
            'webhookUrl' => base_url("callback/binance/" . $paymentData['ids'])
        ];

        $body = json_encode($req);
        $payload = $timestamp . "\n" . $nonce . "\n" . $body . "\n";
        $signature = strtoupper(hash_hmac('sha512', $payload, $secretKey));

        $ch = curl_init($apiUrl . 'v2/order');
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'BinancePay-Timestamp: ' . $timestamp,
                'BinancePay-Nonce: ' . $nonce,
                'BinancePay-Certificate-SN: ' . $apiKey,
                'BinancePay-Signature: ' . $signature
            ],
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $body,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30
        ]);

        $response = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($response, true);

        if ($result && isset($result['code']) && $result['code'] === '000000') {
            return [
                'success' => true,
                'provider' => $this->getProviderName(),
                'payment_id' => $paymentData['ids'],
                'redirect_url' => $result['data']['universalUrl'],
                'status' => 'processing'
            ];
        }

        return [
            'success' => false,
            'message' => 'Binance Error: ' . ($result['errorMessage'] ?? 'Unknown Error'),
            'raw' => $result
        ];
    }

    public function verifyPayment(string $transactionId, array $context = []): array
    {
        return [
            'success' => false,
            'verified' => false,
            'message' => 'Binance verification handled via webhook.'
        ];
    }

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
         return ['success' => false, 'message' => 'Binance refund not implemented yet.'];
    }

    public function getProviderName(): string
    {
        return 'binance_pay';
    }

    public function isAvailable(): bool
    {
        return true;
    }

    protected function generateRandomString($length = 32)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $str;
    }
}

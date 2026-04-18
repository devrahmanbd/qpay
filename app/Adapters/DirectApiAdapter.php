<?php

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;

class DirectApiAdapter implements PaymentProviderInterface
{
    protected $db;
    protected $brandId;
    protected $merchantId;
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
        $providerType = $paymentData['payment_method'] ?? 'bkash';

        $walletConfig = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', $providerType)
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$walletConfig) {
            return [
                'success' => false,
                'code' => 'PROVIDER_NOT_CONFIGURED',
                'message' => "Payment method '{$providerType}' is not configured for this brand.",
            ];
        }

        $params = json_decode($walletConfig->params, true) ?: [];

        $apiUrl = $params['api_url'] ?? null;
        $apiKey = $params['api_key'] ?? null;
        $apiSecret = $params['api_secret'] ?? null;

        if (empty($apiUrl) || empty($apiKey)) {
            return [
                'success' => false,
                'code' => 'INCOMPLETE_CONFIG',
                'message' => "API credentials for '{$providerType}' are incomplete.",
            ];
        }

        $requestBody = [
            'amount' => $paymentData['amount'],
            'currency' => $paymentData['currency'] ?? 'BDT',
            'reference' => $paymentData['ids'],
            'callback_url' => $paymentData['callback_url'] ?? null,
        ];

        $headers = [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $apiKey,
        ];
        if ($apiSecret) {
            $headers[] = 'X-API-Secret: ' . $apiSecret;
        }

        if (!$this->isUrlSafe($apiUrl)) {
            return [
                'success' => false,
                'code' => 'UNSAFE_URL',
                'message' => 'The configured API URL is not allowed (internal/private addresses are blocked).',
            ];
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($requestBody),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_CONNECTTIMEOUT => 10,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            return [
                'success' => false,
                'code' => 'PROVIDER_CONNECTION_ERROR',
                'message' => 'Failed to connect to payment provider: ' . $curlError,
            ];
        }

        $decoded = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && $decoded) {
            return [
                'success' => true,
                'provider' => $this->getProviderName(),
                'payment_id' => $paymentData['ids'],
                'provider_payment_id' => $decoded['payment_id'] ?? $decoded['id'] ?? null,
                'redirect_url' => $decoded['redirect_url'] ?? $decoded['payment_url'] ?? null,
                'status' => 'processing',
                'raw_response' => $decoded,
            ];
        }

        return [
            'success' => false,
            'code' => 'PROVIDER_ERROR',
            'message' => $decoded['message'] ?? 'Payment provider returned an error.',
            'http_code' => $httpCode,
            'raw_response' => $decoded,
        ];
    }

    public function verifyPayment(string $transactionId, array $context = []): array
    {
        $providerType = $context['payment_method'] ?? 'bkash';

        $walletConfig = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', $providerType)
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$walletConfig) {
            return [
                'success' => false,
                'verified' => false,
                'code' => 'PROVIDER_NOT_CONFIGURED',
                'message' => "Payment method '{$providerType}' is not configured.",
            ];
        }

        $params = json_decode($walletConfig->params, true) ?: [];
        $apiUrl = rtrim($params['api_url'] ?? '', '/') . '/verify';
        $apiKey = $params['api_key'] ?? null;

        if (empty($apiUrl) || empty($apiKey)) {
            return [
                'success' => false,
                'verified' => false,
                'code' => 'INCOMPLETE_CONFIG',
                'message' => 'API credentials are incomplete for verification.',
            ];
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl . '?transaction_id=' . urlencode($transactionId),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ],
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && $decoded) {
            $verified = ($decoded['status'] ?? '') === 'completed'
                     || ($decoded['verified'] ?? false) === true;

            return [
                'success' => true,
                'verified' => $verified,
                'provider' => $this->getProviderName(),
                'transaction_id' => $transactionId,
                'provider_status' => $decoded['status'] ?? 'unknown',
                'raw_response' => $decoded,
            ];
        }

        return [
            'success' => false,
            'verified' => false,
            'code' => 'VERIFICATION_FAILED',
            'message' => 'Unable to verify payment with provider.',
        ];
    }

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
        $providerType = $this->config['payment_method'] ?? 'bkash';

        $walletConfig = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', $providerType)
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$walletConfig) {
            return [
                'success' => false,
                'code' => 'PROVIDER_NOT_CONFIGURED',
                'message' => "Refund not possible: provider '{$providerType}' not configured.",
            ];
        }

        $params = json_decode($walletConfig->params, true) ?: [];
        $apiUrl = rtrim($params['api_url'] ?? '', '/') . '/refund';
        $apiKey = $params['api_key'] ?? null;

        if (empty($apiUrl) || empty($apiKey)) {
            return [
                'success' => false,
                'code' => 'INCOMPLETE_CONFIG',
                'message' => 'API credentials incomplete for refund.',
            ];
        }

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $apiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode([
                'transaction_id' => $transactionId,
                'amount' => $amount,
                'reason' => $reason,
            ]),
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Authorization: Bearer ' . $apiKey,
            ],
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $decoded = json_decode($response, true);

        if ($httpCode >= 200 && $httpCode < 300 && $decoded) {
            return [
                'success' => true,
                'provider' => $this->getProviderName(),
                'refund_id' => $decoded['refund_id'] ?? null,
                'status' => $decoded['status'] ?? 'initiated',
                'raw_response' => $decoded,
            ];
        }

        return [
            'success' => false,
            'code' => 'REFUND_FAILED',
            'message' => $decoded['message'] ?? 'Refund request failed.',
        ];
    }

    public function getProviderName(): string
    {
        return 'direct_api';
    }

    protected function isUrlSafe(string $url): bool
    {
        $parsed = parse_url($url);
        if (!$parsed || empty($parsed['host'])) {
            return false;
        }

        $scheme = strtolower($parsed['scheme'] ?? '');
        if (!in_array($scheme, ['http', 'https'])) {
            return false;
        }

        $host = $parsed['host'];
        $ip = filter_var($host, FILTER_VALIDATE_IP) ? $host : gethostbyname($host);

        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        $blocked = [
            '10.0.0.0/8',
            '172.16.0.0/12',
            '192.168.0.0/16',
            '127.0.0.0/8',
            '169.254.0.0/16',
            '0.0.0.0/8',
            '100.64.0.0/10',
        ];

        $ipLong = ip2long($ip);
        foreach ($blocked as $cidr) {
            [$subnet, $mask] = explode('/', $cidr);
            $subnetLong = ip2long($subnet);
            $maskLong = ~((1 << (32 - (int)$mask)) - 1);
            if (($ipLong & $maskLong) === ($subnetLong & $maskLong)) {
                return false;
            }
        }

        return true;
    }

    public function isAvailable(): bool
    {
        $wallet = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$wallet) {
            return false;
        }

        $params = json_decode($wallet->params, true) ?: [];
        return !empty($params['api_url']) && !empty($params['api_key']);
    }
}

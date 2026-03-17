<?php

namespace WHMCS\Module\Gateway\QPay;

class QPayClient
{
    const VERSION = '1.0.0';

    protected $apiKey;
    protected $baseUrl;
    protected $timeout = 30;

    public function __construct(string $apiKey, string $baseUrl)
    {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('QPay API key is required.');
        }
        if (empty($baseUrl)) {
            throw new \InvalidArgumentException('QPay API URL is required.');
        }

        $this->apiKey  = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    public function createPayment(array $params): array
    {
        return $this->request('POST', '/api/v1/payment/create', $params);
    }

    public function verifyPayment(string $paymentId): array
    {
        return $this->request('GET', "/api/v1/payment/verify/{$paymentId}");
    }

    public function getPaymentStatus(string $paymentId): array
    {
        return $this->request('GET', "/api/v1/payment/status/{$paymentId}");
    }

    public function refund(string $paymentId, string $reason = ''): array
    {
        $data = ['payment_id' => $paymentId];
        if (!empty($reason)) {
            $data['reason'] = $reason;
        }
        return $this->request('POST', '/api/v1/refunds', $data);
    }

    public function getBalance(): array
    {
        return $this->request('GET', '/api/v1/balance');
    }

    public static function verifyWebhookSignature(string $payload, string $signatureHeader, string $secret, int $tolerance = 300): bool
    {
        $parts = [];
        foreach (explode(',', $signatureHeader) as $part) {
            $kv = explode('=', trim($part), 2);
            if (count($kv) === 2) {
                $parts[$kv[0]] = $kv[1];
            }
        }

        if (empty($parts['t']) || empty($parts['v1'])) {
            return false;
        }

        $timestamp = (int) $parts['t'];
        if ($tolerance > 0 && abs(time() - $timestamp) > $tolerance) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);

        return hash_equals($expected, $parts['v1']);
    }

    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . $endpoint;

        $headers = [
            'API-KEY: ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
            'X-QPay-Client: whmcs/' . self::VERSION,
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        } elseif ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
            curl_setopt($ch, CURLOPT_URL, $url);
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error    = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException('QPay API request failed: ' . $error);
        }

        $decoded = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException('QPay API returned invalid JSON (HTTP ' . $httpCode . ')');
        }

        return $decoded;
    }
}

<?php

defined('ABSPATH') || exit;

class QPay_SDK
{
    protected $apiKey;
    protected $baseUrl;
    protected $timeout = 30;

    public function __construct(string $apiKey, string $baseUrl)
    {
        $this->apiKey = $apiKey;
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

    public function listPayments(array $params = []): array
    {
        return $this->request('GET', '/api/v1/payments', $params);
    }

    public function createRefund(string $paymentId, string $reason = ''): array
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

    public function getPaymentMethods(): array
    {
        return $this->request('GET', '/api/v1/payment/methods');
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

        $args = [
            'method' => $method,
            'timeout' => $this->timeout,
            'headers' => [
                'API-KEY' => $this->apiKey,
                'Authorization' => 'Bearer ' . $this->apiKey, // Support both for maximum compatibility
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-QPay-Client-User-Agent' => wp_json_encode([
                    'lang' => 'php',
                    'lang_version' => PHP_VERSION,
                    'publisher' => 'qpay',
                    'sdk_version' => QPAY_VERSION,
                    'plugin_version' => QPAY_VERSION,
                ]),
            ],
        ];

        if ($method === 'POST' && !empty($data)) {
            $args['body'] = wp_json_encode($data);
        } elseif ($method === 'GET' && !empty($data)) {
            $url = add_query_arg($data, $url);
        }

        $response = wp_remote_request($url, $args);

        // DEBUG LOGGING
        $masked_key = substr($this->apiKey, 0, 10) . '...' . substr($this->apiKey, -4);
        error_log(sprintf('[QPAY_DEBUG] Request: %s %s | Key: %s (Len: %d)', $method, $url, $masked_key, strlen($this->apiKey)));
        
        if (is_wp_error($response)) {
            error_log('[QPAY_DEBUG] Request failed: ' . $response->get_error_message());
            throw new RuntimeException('QPay API error: ' . $response->get_error_message());
        }

        $body_text = wp_remote_retrieve_body($response);
        $code = wp_remote_retrieve_response_code($response);
        error_log(sprintf('[QPAY_DEBUG] Response Code: %d | Body: %s', $code, substr($body_text, 0, 500)));
        $body = json_decode($body_text, true);
        $code = wp_remote_retrieve_response_code($response);

        if ($code >= 400) {
            throw new RuntimeException($body['message'] ?? "QPay API HTTP {$code} error", $code);
        }

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new RuntimeException(__('Invalid JSON response from QPay API. Raw response: ', 'qpay') . substr($body_text, 0, 200));
        }

        return $body ?: [];
    }
}

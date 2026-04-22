<?php

/**
 * QPay PHP SDK
 * 
 * A simple, powerful client for the QPay Payment Gateway API.
 * 
 * @version 1.1.0
 * @author QPay
 */

class QPay
{
    const VERSION = '1.1.0';
    const API_VERSION = 'v1';

    protected $apiKey;
    protected $baseUrl;
    protected $timeout = 30;
    protected $lastResponse;
    protected $lastHttpCode;

    /**
     * Initialize the QPay Client
     * 
     * @param string $apiKey Your secret API key (qp_live_... or qp_test_...)
     * @param string $baseUrl The base URL of your QPay instances (e.g. https://qpay.cloudman.one)
     */
    public function __construct(string $apiKey, string $baseUrl)
    {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('API key is required.');
        }

        if (empty($baseUrl)) {
            throw new \InvalidArgumentException('Base URL is required (e.g., https://qpay.cloudman.one).');
        }

        $this->apiKey = $apiKey;
        $this->baseUrl = rtrim($baseUrl, '/');
    }

    /**
     * Set cURL timeout in seconds
     */
    public function setTimeout(int $seconds): self
    {
        $this->timeout = $seconds;
        return $this;
    }

    /**
     * Check if using a test key
     */
    public function isTestMode(): bool
    {
        return strpos($this->apiKey, '_test_') !== false;
    }

    /**
     * Create a new payment
     * 
     * @param array $params [amount, currency, customer_name, customer_email, customer_ip, etc.]
     */
    public function createPayment(array $params): array
    {
        if (empty($params['amount'])) {
            throw new \InvalidArgumentException("'amount' is required.");
        }

        return $this->request('POST', '/payment/create', $params);
    }

    /**
     * Verify a payment status with the provider
     */
    public function verifyPayment(string $paymentId): array
    {
        if (empty($paymentId)) {
            throw new \InvalidArgumentException('Payment ID is required.');
        }

        return $this->request('GET', "/payment/verify/{$paymentId}");
    }

    /**
     * Get details of a payment
     */
    public function getPaymentStatus(string $paymentId): array
    {
        if (empty($paymentId)) {
            throw new \InvalidArgumentException('Payment ID is required.');
        }

        return $this->request('GET', "/payment/status/{$paymentId}");
    }

    /**
     * List payment methods available for the merchant
     */
    public function getPaymentMethods(): array
    {
        return $this->request('GET', '/payment/methods');
    }

    /**
     * Get merchant account balance
     */
    public function getBalance(): array
    {
        return $this->request('GET', '/balance');
    }

    /**
     * Create a refund for a successful payment
     */
    public function createRefund(array $params): array
    {
        if (empty($params['payment_id'])) {
            throw new \InvalidArgumentException("'payment_id' is required.");
        }

        return $this->request('POST', '/refunds', $params);
    }

    /**
     * Verify a webhook signature
     */
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

    /**
     * Internal request handler
     */
    protected function request(string $method, string $endpoint, array $data = []): array
    {
        $url = $this->baseUrl . '/api/' . self::API_VERSION . $endpoint;

        if ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        $ch = curl_init();

        $headers = [
            'API-KEY: ' . $this->apiKey,
            'Content-Type: application/json',
            'Accept: application/json',
            'User-Agent: QPay-PHP-SDK/' . self::VERSION,
        ];

        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => $this->timeout,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        if ($method === 'POST') {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new \RuntimeException("QPay API request failed: {$error}");
        }

        $this->lastHttpCode = $httpCode;
        $this->lastResponse = json_decode($response, true) ?: [];

        if ($httpCode >= 400) {
            $message = $this->lastResponse['message'] ?? "HTTP {$httpCode} error";
            throw new QPayException($message, $httpCode, $this->lastResponse);
        }

        return $this->lastResponse;
    }

    public function getLastResponse(): ?array { return $this->lastResponse; }
    public function getLastHttpCode(): ?int { return $this->lastHttpCode; }
}

/**
 * Custom Exception for API errors
 */
class QPayException extends \Exception
{
    protected $response;

    public function __construct(string $message, int $code, array $response = [])
    {
        parent::__construct($message, $code);
        $this->response = $response;
    }

    public function getResponse(): array { return $this->response; }
}

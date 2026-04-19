<?php

class QPay
{
    const VERSION = '1.1.0';
    const API_VERSION = 'v1';

    protected $apiKey;
    protected $baseUrl;
    protected $timeout = 30;
    protected $lastResponse;
    protected $lastHttpCode;

    public function __construct(string $apiKey, string $baseUrl = '')
    {
        if (empty($apiKey)) {
            throw new \InvalidArgumentException('API key is required.');
        }

        $this->apiKey = $apiKey;

        if (!empty($baseUrl)) {
            $this->baseUrl = rtrim($baseUrl, '/');
        } else {
            $this->baseUrl = $this->detectBaseUrl();
        }
    }

    protected function detectBaseUrl(): string
    {
        throw new QPayException("'baseUrl' is required. Pass it as the second constructor argument (e.g. 'https://pay.yourdomain.com').");
    }

    public function setTimeout(int $seconds): self
    {
        $this->timeout = $seconds;
        return $this;
    }

    public function isTestMode(): bool
    {
        return strpos($this->apiKey, '_test_') !== false;
    }

    public function createPayment(array $params): array
    {
        $required = ['amount'];
        foreach ($required as $field) {
            if (empty($params[$field])) {
                throw new \InvalidArgumentException("'{$field}' is required.");
            }
        }

        return $this->request('POST', '/payments', $params);
    }

    public function verifyPayment(string $paymentId): array
    {
        if (empty($paymentId)) {
            throw new \InvalidArgumentException('Payment ID is required.');
        }

        return $this->request('POST', "/payments/{$paymentId}/verify");
    }

    public function getPaymentStatus(string $paymentId): array
    {
        if (empty($paymentId)) {
            throw new \InvalidArgumentException('Payment ID is required.');
        }

        return $this->request('GET', "/payments/{$paymentId}");
    }

    public function listPayments(array $params = []): array
    {
        return $this->request('GET', '/payments', $params);
    }

    public function createRefund(string $paymentId, string $reason = ''): array
    {
        if (empty($paymentId)) {
            throw new \InvalidArgumentException('Payment ID is required.');
        }

        $data = ['payment_id' => $paymentId];
        if (!empty($reason)) {
            $data['reason'] = $reason;
        }

        return $this->request('POST', '/refunds', $data);
    }

    public function getBalance(): array
    {
        return $this->request('GET', '/balance');
    }

    public function getPaymentMethods(): array
    {
        return $this->request('GET', '/payment/methods');
    }

    public function getLastResponse(): ?array
    {
        return $this->lastResponse;
    }

    public function getLastHttpCode(): ?int
    {
        return $this->lastHttpCode;
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
        $url = $this->baseUrl . '/api/' . self::API_VERSION . $endpoint;

        if ($method === 'GET' && !empty($data)) {
            $url .= '?' . http_build_query($data);
        }

        $ch = curl_init();

        $headers = [
            'API-KEY: ' . $this->apiKey,
            'Authorization: Bearer ' . $this->apiKey,
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
            $code = $this->lastResponse['code'] ?? 'API_ERROR';
            throw new QPayException($message, $httpCode, $code, $this->lastResponse);
        }

        return $this->lastResponse;
    }
}

class QPayException extends \Exception
{
    protected $errorCode;
    protected $responseBody;

    public function __construct(string $message, int $httpCode, string $errorCode, array $responseBody)
    {
        parent::__construct($message, $httpCode);
        $this->errorCode = $errorCode;
        $this->responseBody = $responseBody;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public function getResponseBody(): array
    {
        return $this->responseBody;
    }

    public function getHttpCode(): int
    {
        return $this->getCode();
    }
}

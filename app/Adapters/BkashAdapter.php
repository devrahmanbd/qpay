<?php

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;
use Exception;

class BkashAdapter implements PaymentProviderInterface
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
        $wallet = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', 'bkash')
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$wallet) {
            return ['success' => false, 'message' => 'bKash wallet not configured.'];
        }

        $params = json_decode($wallet->params, true) ?: [];
        $username = $params['username'] ?? '';
        $password = $params['password'] ?? '';
        $appKey = $params['app_key'] ?? '';
        $appSecret = $params['app_secret'] ?? '';
        $isSandbox = (bool)($params['sandbox'] ?? false);
        
        $baseUrl = $isSandbox ? 'https://tokenized.sandbox.bka.sh' : 'https://tokenized.pay.bka.sh';

        try {
            // 1. Grant Token
            $idToken = $this->grantToken($baseUrl, $username, $password, $appKey, $appSecret);
            
            // Store token in session for execution phase
            session()->set('bkash_token', $idToken);

            // 2. Create Payment
            $createResponse = $this->createBkashPayment($baseUrl, $idToken, $appKey, [
                'amount' => number_format($paymentData['amount'], 2, '.', ''),
                'currency' => 'BDT',
                'intent' => 'sale',
                'merchantInvoiceNumber' => $paymentData['transaction_id'] ?? 'INV'.time(),
                'callbackURL' => base_url('api/v1/payment/verify/' . $paymentData['ids']),
            ]);

            if (isset($createResponse['bkashURL'])) {
                return [
                    'success' => true,
                    'provider' => $this->getProviderName(),
                    'payment_id' => $paymentData['ids'],
                    'provider_payment_id' => $createResponse['paymentID'],
                    'redirect_url' => $createResponse['bkashURL'],
                    'status' => 'processing'
                ];
            }

            return [
                'success' => false,
                'message' => 'Failed to create bKash payment: ' . ($createResponse['statusMessage'] ?? 'Unknown error')
            ];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'bKash Error: ' . $e->getMessage()];
        }
    }

    public function verifyPayment(string $transactionId, array $context = []): array
    {
        // This is where we "Execute" the payment after redirect
        $payment = $context['payment'] ?? null;
        if (!$payment) {
            return ['success' => false, 'message' => 'Missing payment context'];
        }

        $wallet = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', 'bkash')
            ->get()
            ->getRow();

        $params = json_decode($wallet->params, true) ?: [];
        $isSandbox = (bool)($params['sandbox'] ?? false);
        $baseUrl = $isSandbox ? 'https://tokenized.sandbox.bka.sh' : 'https://tokenized.pay.bka.sh';
        $appKey = $params['app_key'] ?? '';
        
        $idToken = session()->get('bkash_token');
        $paymentID = $context['provider_payment_id'] ?? $_GET['paymentID'] ?? null;

        if (!$idToken || !$paymentID) {
            return ['success' => false, 'verified' => false, 'message' => 'Missing bKash paymentID or Token'];
        }

        try {
            $response = $this->executeBkashPayment($baseUrl, $idToken, $appKey, $paymentID);

            if (($response['statusCode'] ?? '') === '0000' && ($response['transactionStatus'] ?? '') === 'Completed') {
                return [
                    'success' => true,
                    'verified' => true,
                    'provider' => $this->getProviderName(),
                    'transaction_id' => $response['trxID'],
                    'raw_response' => $response
                ];
            }

            return [
                'success' => true,
                'verified' => false,
                'message' => $response['statusMessage'] ?? 'bKash payment failed'
            ];
        } catch (Exception $e) {
            return ['success' => false, 'verified' => false, 'message' => $e->getMessage()];
        }
    }

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
        // Implementation for bKash refund can be added here using tokenized refund API
        return ['success' => false, 'message' => 'Refund not implemented for bKash specialized adapter yet.'];
    }

    public function getProviderName(): string
    {
        return 'bkash_tokenized';
    }

    public function isAvailable(): bool
    {
        $wallet = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', 'bkash')
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$wallet) return false;

        $params = json_decode($wallet->params, true) ?: [];
        return !empty($params['app_key']) && !empty($params['app_secret']);
    }

    protected function grantToken($baseUrl, $user, $pass, $key, $secret)
    {
        $ch = curl_init($baseUrl . '/v1.2.0-beta/tokenized/checkout/token/grant');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "username: $user",
                "password: $pass"
            ],
            CURLOPT_POSTFIELDS => json_encode(['app_key' => $key, 'app_secret' => $secret]),
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        
        $data = json_decode($response, true);
        if (isset($data['id_token'])) return $data['id_token'];
        
        throw new Exception($data['statusMessage'] ?? 'Failed to get bKash access token');
    }

    protected function createBkashPayment($baseUrl, $token, $key, $data)
    {
        $ch = curl_init($baseUrl . '/v1.2.0-beta/tokenized/checkout/create');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: Bearer $token",
                "X-APP-Key: $key"
            ],
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }

    protected function executeBkashPayment($baseUrl, $token, $key, $paymentID)
    {
        $ch = curl_init($baseUrl . '/v1.2.0-beta/tokenized/checkout/execute');
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                "Authorization: Bearer $token",
                "X-APP-Key: $key"
            ],
            CURLOPT_POSTFIELDS => json_encode(['paymentID' => $paymentID]),
            CURLOPT_SSL_VERIFYPEER => false
        ]);
        $response = curl_exec($ch);
        curl_close($ch);
        return json_decode($response, true);
    }
}

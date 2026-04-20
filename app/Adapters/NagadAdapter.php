<?php

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;
use Exception;
use DateTime;
use DateTimeZone;

class NagadAdapter implements PaymentProviderInterface
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
            ->where('g_type', 'nagad')
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$wallet) {
            return ['success' => false, 'message' => 'Nagad wallet not configured.'];
        }

        $params = json_decode($wallet->params, true) ?: [];
        $merchantId = $params['merchant_id'] ?? '';
        $publicKey = $params['public_key'] ?? '';
        $privateKey = $params['private_key'] ?? '';
        $mode = $params['nagad_mode'] ?? 'sandbox';

        $baseUrl = ($mode === 'sandbox') 
            ? "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/"
            : "https://api.mynagad.com/api/dfs/";

        $orderId = 'ORD' . time() . rand(100, 999);
        
        try {
            // 1. Initialize
            $initResponse = $this->initialize($baseUrl, $merchantId, $orderId, $publicKey, $privateKey);
            
            if (isset($initResponse['sensitiveData']) && isset($initResponse['signature'])) {
                // 2. Complete/Create
                $completeResponse = $this->complete(
                    $baseUrl, 
                    $initResponse['sensitiveData'], 
                    $orderId, 
                    $paymentData['amount'], 
                    $merchantId, 
                    $publicKey, 
                    $privateKey,
                    $paymentData['ids']
                );

                if ($completeResponse && $completeResponse['status'] === 'Success') {
                    return [
                        'success' => true,
                        'provider' => $this->getProviderName(),
                        'payment_id' => $paymentData['ids'],
                        'redirect_url' => $completeResponse['callBackUrl'],
                        'status' => 'processing'
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Nagad Complete Error: ' . ($completeResponse['statusMessage'] ?? 'Unknown error')
                ];
            }

            return [
                'success' => false,
                'message' => 'Nagad Initialization Error: ' . ($initResponse['statusMessage'] ?? 'Unknown error')
            ];

        } catch (Exception $e) {
            return ['success' => false, 'message' => 'Nagad Error: ' . $e->getMessage()];
        }
    }

    public function verifyPayment(string $transactionId, array $context = []): array
    {
        // For Nagad Direct API, the verification actually happens in callback/nagad
        // but this method can be used for manual verification if needed.
        return [
            'success' => false,
            'message' => 'Nagad API verification should be handled via callback.'
        ];
    }

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
        return ['success' => false, 'message' => 'Refund not implemented for Nagad yet.'];
    }

    public function getProviderName(): string
    {
        return 'nagad_direct';
    }

    public function isAvailable(): bool
    {
        $wallet = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', 'nagad')
            ->where('status', 1)
            ->get()
            ->getRow();

        if (!$wallet) return false;

        $params = json_decode($wallet->params, true) ?: [];
        return !empty($params['merchant_id']) && !empty($params['private_key']);
    }

    protected function initialize($baseUrl, $merchantId, $orderId, $publicKey, $privateKey)
    {
        $sensitiveData = [
            'merchantId' => $merchantId,
            'datetime'   => $this->getCurrentBDtime(),
            'orderId'    => $orderId,
            'challenge'  => $this->randomString(40),
        ];

        $postData = [
            'dateTime'      => $this->getCurrentBDtime(),
            'sensitiveData' => $this->encryptWithPublicKey($sensitiveData, $publicKey),
            'signature'     => $this->generateSignature($sensitiveData, $privateKey),
        ];

        $url = $baseUrl . "check-out/initialize/" . $merchantId . "/" . $orderId . "?locale=EN";
        return $this->httpRequest($url, $postData);
    }

    protected function complete($baseUrl, $initSensitiveData, $orderId, $amount, $merchantId, $publicKey, $privateKey, $paymentId)
    {
        // 1. Decrypt Challenge
        $decrypted = json_decode($this->decryptWithPrivateKey($initSensitiveData, $privateKey), true);
        
        if (!isset($decrypted['paymentReferenceId'])) return false;

        $paymentRef = $decrypted['paymentReferenceId'];
        $challenge = $decrypted['challenge'];

        $sensitiveData = [
            'merchantId'   => $merchantId,
            'orderId'      => $orderId,
            'currencyCode' => '050',
            'amount'       => number_format($amount, 2, '.', ''),
            'challenge'    => $challenge
        ];

        $postData = [
            'sensitiveData'       => $this->encryptWithPublicKey($sensitiveData, $publicKey),
            'signature'           => $this->generateSignature($sensitiveData, $privateKey),
            'merchantCallbackURL' => base_url('api/v1/payment/verify/' . $paymentId),
            'additionalMerchantInfo' => [
                'order_no' => $orderId,
            ],
        ];

        $url = $baseUrl . "check-out/complete/" . $paymentRef;
        return $this->httpRequest($url, $postData);
    }

    protected function encryptWithPublicKey($data, $publicKey)
    {
        if (is_array($data)) $data = json_encode($data);
        $key = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($publicKey, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        openssl_public_encrypt($data, $encrypted, $key);
        return base64_encode($encrypted);
    }

    protected function decryptWithPrivateKey($data, $privateKey)
    {
        $key = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
        openssl_private_decrypt(base64_decode($data), $decrypted, $key);
        return $decrypted;
    }

    protected function generateSignature($data, $privateKey)
    {
        if (is_array($data)) $data = json_encode($data);
        $key = "-----BEGIN RSA PRIVATE KEY-----\n" . wordwrap($privateKey, 64, "\n", true) . "\n-----END RSA PRIVATE KEY-----";
        openssl_sign($data, $signature, $key, OPENSSL_ALGO_SHA256);
        return base64_encode($signature);
    }

    protected function httpRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'X-KM-Api-Version: v-0.2.0',
                'X-KM-IP-V4: ' . ($_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'),
                'X-KM-Client-Type: PC_WEB'
            ],
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_FOLLOWLOCATION => true
        ]);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    protected function getCurrentBDtime()
    {
        $dt = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        return $dt->format('YmdHis');
    }

    protected function randomString($length = 40)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        for ($i = 0; $i < $length; $i++) {
            $str .= $chars[rand(0, strlen($chars) - 1)];
        }
        return $str;
    }
}

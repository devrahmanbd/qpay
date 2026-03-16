<?php

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;

class SmsVerificationAdapter implements PaymentProviderInterface
{
    protected $db;
    protected $brandId;
    protected $merchantId;

    public function __construct(int $merchantId, int $brandId)
    {
        $this->db = db_connect();
        $this->merchantId = $merchantId;
        $this->brandId = $brandId;
    }

    public function initiatePayment(array $paymentData): array
    {
        $wallets = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('status', 1)
            ->get()
            ->getResult();

        if (empty($wallets)) {
            return [
                'success' => false,
                'code' => 'NO_WALLETS_CONFIGURED',
                'message' => 'No payment wallets are configured for this brand.',
            ];
        }

        $methods = [];
        foreach ($wallets as $wallet) {
            $params = json_decode($wallet->params, true) ?: [];
            $methods[] = [
                'type' => $wallet->g_type,
                'channel' => $wallet->t_type,
                'account' => $params['account_number'] ?? $params['number'] ?? null,
            ];
        }

        return [
            'success' => true,
            'provider' => $this->getProviderName(),
            'payment_id' => $paymentData['ids'],
            'status' => 'pending',
            'methods' => $methods,
            'instructions' => 'Send the exact amount to one of the provided wallet numbers. Include the payment ID in the reference.',
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
        ];
    }

    public function verifyPayment(string $transactionId, array $context = []): array
    {
        $moduleData = $this->db->table('module_data')
            ->where('uid', $this->merchantId)
            ->like('message', $transactionId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getRow();

        if (!$moduleData) {
            return [
                'success' => false,
                'verified' => false,
                'code' => 'NOT_FOUND',
                'message' => 'No matching SMS transaction found for this payment.',
            ];
        }

        return [
            'success' => true,
            'verified' => true,
            'provider' => $this->getProviderName(),
            'transaction_id' => $transactionId,
            'raw_message' => $moduleData->message,
            'received_at' => $moduleData->created_at,
        ];
    }

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
        return [
            'success' => false,
            'code' => 'REFUND_NOT_SUPPORTED',
            'message' => 'Automatic refunds are not supported via SMS verification. Manual refund required.',
            'provider' => $this->getProviderName(),
        ];
    }

    public function getProviderName(): string
    {
        return 'sms_verification';
    }

    public function isAvailable(): bool
    {
        $count = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('status', 1)
            ->countAllResults();

        return $count > 0;
    }
}

<?php

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;

class ManualBankAdapter implements PaymentProviderInterface
{
    protected $db;
    protected $merchantId;
    protected $brandId;
    protected $bankType;

    public function __construct(int $merchantId, int $brandId, array $config = [])
    {
        $this->db = db_connect();
        $this->merchantId = $merchantId;
        $this->brandId = $brandId;
        $this->bankType = $config['payment_method'] ?? 'bank';
    }

    public function initiatePayment(array $paymentData): array
    {
        return [
            'success' => true,
            'provider' => $this->getProviderName(),
            'payment_id' => $paymentData['ids'],
            'status' => 'pending',
            'instructions' => 'Please transfer the funds to our bank account and provide the transaction reference.',
            'manual_verification' => true
        ];
    }

    public function verifyPayment(string $transactionId, array $context = []): array
    {
        $paymentId = $context['payment_id'] ?? null;
        
        if (!$paymentId) {
            return ['success' => false, 'message' => 'Payment ID missing.'];
        }

        // 1. Log the submission for Admin Review
        $data = [
            'ids'        => $paymentId,
            'uid'        => $this->merchantId,
            'brand_id'   => $this->brandId,
            'files'      => $transactionId, 
            'status'     => '1', // Pending Review
            'type'       => $this->bankType,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->table('bank_transaction_logs')->insert($data);

        // 2. Update the main payment status to "Processing/Review"
        $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->update([
                'status' => 1, // Processing
                'transaction_id' => $transactionId,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

        return [
            'success' => true,
            'verified' => false, // Requires admin approval
            'message' => 'Your payment reference has been submitted for review.',
            'status' => 'pending_review'
        ];
    }

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
        return [
            'success' => false,
            'message' => 'Manual bank refunds must be handled manually by the administrator.'
        ];
    }

    public function getProviderName(): string
    {
        return 'manual_bank';
    }

    public function isAvailable(): bool
    {
        // Check if merchant has any bank settings configured
        $count = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('t_type', 'bank')
            ->where('status', 1)
            ->countAllResults();

        return $count > 0;
    }
}

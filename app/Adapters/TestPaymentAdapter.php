<?php

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;

class TestPaymentAdapter implements PaymentProviderInterface
{
    protected int $merchantId;
    protected int $brandId;

    public function __construct(int $merchantId, int $brandId, array $config = [])
    {
        $this->merchantId = $merchantId;
        $this->brandId = $brandId;
    }

    public function initiatePayment(array $paymentData): array
    {
        $amount = (float) $paymentData['amount'];

        if ($amount == 2.00) {
            return [
                'success' => false,
                'provider' => 'test',
                'error' => 'Card declined (test mode)',
                'error_code' => 'card_declined',
            ];
        }

        if ($amount == 3.00) {
            return [
                'success' => false,
                'provider' => 'test',
                'error' => 'Insufficient funds (test mode)',
                'error_code' => 'insufficient_funds',
            ];
        }

        return [
            'success' => true,
            'provider' => 'test',
            'transaction_id' => 'test_txn_' . bin2hex(random_bytes(8)),
            'redirect_url' => null,
            'methods' => ['bKash', 'Nagad', 'Rocket'],
            'expires_at' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
        ];
    }

    public function verifyPayment(string $paymentId, array $params = []): array
    {
        return [
            'success' => true,
            'verified' => true,
            'provider' => 'test',
            'transaction_id' => 'test_txn_' . bin2hex(random_bytes(8)),
            'status' => 'completed',
        ];
    }

    public function getProviderName(): string
    {
        return 'Test Mode';
    }

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
        return [
            'success' => true,
            'provider' => 'test',
            'refund_id' => 'test_rfnd_' . bin2hex(random_bytes(8)),
            'transaction_id' => $transactionId,
            'amount' => $amount,
            'reason' => $reason,
            'status' => 'refunded',
        ];
    }

    public function isAvailable(): bool
    {
        return true;
    }
}

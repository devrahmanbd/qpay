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


    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array
    {
        return [
            'success' => false,
            'code' => 'REFUND_NOT_SUPPORTED',
            'message' => 'Automatic refunds are not supported via SMS verification. Manual refund required.',
            'provider' => $this->getProviderName(),
        ];
    }

    public function verifyPayment(string $transactionId, array $context = []): array
    {
        $paymentId = $context['payment_id'] ?? null;
        if (!$paymentId) {
            return ['success' => false, 'message' => 'Payment ID is missing in context.'];
        }

        // 1. Get Payment Details
        $payment = $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->where('merchant_id', $this->merchantId)
            ->get()
            ->getRow();

        if (!$payment) {
            return ['success' => false, 'message' => 'Invalid payment record.'];
        }

        $expectedAmount = (float)$payment->amount;

        // 2. Double-Spending Check
        $alreadyUsed = $this->db->table('api_payments')
            ->where('transaction_id', $transactionId)
            ->where('status', 'completed')
            ->countAllResults();

        if ($alreadyUsed > 0) {
            return [
                'success' => false,
                'code' => 'ALREADY_USED',
                'message' => 'This Transaction ID has already been used for another payment.'
            ];
        }

        // 3. Search module_data for the un-used SMS
        // We match by UID to ensure it landed on ONE of the merchant's devices
        $smsRecord = $this->db->table('module_data')
            ->where('uid', $this->merchantId)
            ->where('status', 0)
            ->like('message', $transactionId)
            ->orderBy('id', 'DESC')
            ->get()
            ->getRow();

        if (!$smsRecord) {
            // Check Heartbeat to see if phone is even online
            $device = $this->db->table('devices')
                ->where('uid', $this->merchantId)
                ->orderBy('last_sync_at', 'DESC')
                ->get()
                ->getRow();
            
            $statusMsg = "Transaction ID not found yet.";
            if ($device && (time() - strtotime($device->last_sync_at) > 300)) {
                $statusMsg .= " Warning: Merchant phone was last seen " . floor((time() - strtotime($device->last_sync_at)) / 60) . " minutes ago.";
            }

            return [
                'success' => false,
                'code' => 'NOT_FOUND',
                'message' => $statusMsg,
                'is_pending' => true // Hint to the UI to keep polling
            ];
        }

        // 4. Strict Amount Extraction via Regex
        $message = $smsRecord->message;
        $pattern = '/\b(?:Tk|TK|tk|Rs|RS|rs)\s*([\d,.]+)/'; // Support for multi-region if needed
        
        if (preg_match($pattern, $message, $matches)) {
            $receivedAmount = (float)str_replace(',', '', $matches[1]);
            
            if ($receivedAmount !== $expectedAmount) {
                return [
                    'success' => false,
                    'code' => 'AMOUNT_MISMATCH',
                    'message' => "Amount mismatch. Expected: {$expectedAmount}, Received: {$receivedAmount}."
                ];
            }
        } else {
            return [
                'success' => false,
                'code' => 'PARSE_ERROR',
                'message' => 'Could not verify amount from the confirmation message.'
            ];
        }

        // 5. Finalize Verification
        $this->db->transStart();
        
        // Mark SMS as used
        $this->db->table('module_data')
            ->where('id', $smsRecord->id)
            ->update(['status' => 1, 'tmp_id' => $paymentId]);

        // Update Payment status
        $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->update([
                'status' => 'completed',
                'transaction_id' => $transactionId,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return ['success' => false, 'message' => 'Failed to finalize transaction in database.'];
        }

        return [
            'success' => true,
            'message' => 'Payment verified successfully.',
            'amount' => $receivedAmount,
            'transaction_id' => $transactionId
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

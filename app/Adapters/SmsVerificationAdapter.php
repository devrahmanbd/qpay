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

        // 2. Brute-Force / Cooldown Check
        $cache = \Config\Services::cache();
        $failKey = 'verify_fails_' . $paymentId;
        $fails = $cache->get($failKey) ?: 0;
        if ($fails >= 5) {
            return [
                'success' => false,
                'code' => 'THROTTLED',
                'message' => 'Too many failed attempts. Please try again in 5 minutes.',
            ];
        }

        // 3. Double-Spending Check (Global Scoping)
        // Check if this Transaction ID has been used by ANYONE to prevent recycled screenshots
        $alreadyUsed = $this->db->table('api_payments')
            ->where('transaction_id', $transactionId)
            ->where('status', 'completed')
            ->countAllResults();

        if ($alreadyUsed > 0) {
            return [
                'success' => false,
                'code' => 'ALREADY_USED',
                'message' => 'This Transaction ID has already been used on our platform.'
            ];
        }

        // 4. Fetch Brand Specific Expected Number
        // We look for the sender's account number in this brand's settings
        $wallet = $this->db->table('user_payment_settings')
            ->where('uid', $this->merchantId)
            ->where('brand_id', $this->brandId)
            ->where('g_type', ($context['payment_method'] ?? ''))
            ->get()
            ->getRow();
        
        $expectedRecipient = null;
        if ($wallet) {
            $params = json_decode($wallet->params, true) ?: [];
            $expectedRecipient = $params['personal_number'] ?? $params['agent_number'] ?? $params['number'] ?? null;
        }

        // 5. Search module_data for the un-used SMS
        $smsQuery = $this->db->table('module_data')
            ->where('uid', $this->merchantId)
            ->where('status', 0)
            ->like('message', $transactionId);
        
        // Loophole Block: Match the recipient number if we know which one this brand uses
        if ($expectedRecipient) {
            $smsQuery->where('recipient_number', $expectedRecipient);
        }

        $smsRecord = $smsQuery->orderBy('id', 'DESC')
            ->get()
            ->getRow();

        if (!$smsRecord) {
            // Increment fail count
            $cache->save($failKey, $fails + 1, 300); // 5 minute cooldown
            
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
        // Refined pattern to catch "Tk 500", "Tk.500", "Received 500", "credited by Tk 500" etc.
        $pattern = '/(?:Tk|TK|tk|Rs|RS|rs|Received|credited by Tk|Cash Out Tk)\.?\s*([\d,.]+)/i';
        
        if (preg_match($pattern, $message, $matches)) {
            $receivedAmount = (float)str_replace(',', '', $matches[1]);
            
            // Allow for minor float precision differences
                log_device_event(
                    $smsRecord->device_id ?? null,
                    'verification_failed',
                    "Amount mismatch for payment {$paymentId}",
                    "Expected: {$expectedAmount}, Received: {$receivedAmount}\nSMS ID: {$smsRecord->id}\nMessage: {$message}",
                    'warning'
                );
                return [
                    'success' => false,
                    'code' => 'AMOUNT_MISMATCH',
                    'message' => "Amount mismatch. Expected: {$expectedAmount}, Received: {$receivedAmount}."
                ];
            }
        } else {
            log_device_event(
                $smsRecord->device_id ?? null,
                'verification_failed',
                "Amount parsing error for payment {$paymentId}",
                "Could not extract amount from message.\nSMS ID: {$smsRecord->id}\nMessage: {$message}",
                'error'
            );
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
            log_device_event(
                $smsRecord->device_id ?? null,
                'verification_failed',
                "Database error during verification finalize",
                "Payment ID: {$paymentId}\nSMS ID: {$smsRecord->id}",
                'error'
            );
            return ['success' => false, 'message' => 'Failed to finalize transaction in database.'];
        }

        log_device_event(
            $smsRecord->device_id ?? null,
            'payment_verified',
            "Payment verified! Amount: {$receivedAmount}",
            "Payment ID: {$paymentId}\nTransaction ID: {$transactionId}\nSMS ID: {$smsRecord->id}",
            'success'
        );

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

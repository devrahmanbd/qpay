<?php declare(strict_types=1);

namespace App\Adapters;

use App\Interfaces\PaymentProviderInterface;

class SmsVerificationAdapter implements PaymentProviderInterface
{
    protected \CodeIgniter\Database\BaseConnection $db;
    protected int $brandId;
    protected int $merchantId;

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

        // 1. Get Payment & Brand Details
        $payment = $this->db->table('api_payments')->where('ids', $paymentId)->get()->getRow();
        if (!$payment) {
            return ['success' => false, 'message' => 'Payment record not found.'];
        }

        $brand = $this->db->table('brands')->where('id', $this->brandId)->get()->getRow();
        $expectedAmount = (float)$payment->amount;

        // 2. Map Legacy Detection Patterns
        $method = strtolower($payment->payment_method ?? '');
        $idPrefix = '';
        $bodySnippets = [];
        $requiredAddress = '';

        switch ($method) {
            case 'bkash':
                $requiredAddress = 'bkash';
                $idPrefix = 'TrxID ';
                $bodySnippets = ['You have received Tk', 'Cash Out Tk', 'received payment Tk'];
                break;
            case 'nagad':
                $requiredAddress = 'nagad';
                $idPrefix = 'TxnID: ';
                $bodySnippets = ['Money Received', 'Cash Out Received', 'Amount: Tk'];
                break;
            case 'rocket':
                $requiredAddress = '16216';
                $idPrefix = 'TxnID:';
                $bodySnippets = ['credited by Tk.', 'received', 'Amount: Tk'];
                break;
            case 'surecash':
                $requiredAddress = '16495';
                $idPrefix = 'TxnID: ';
                $bodySnippets = ['Amount: Tk'];
                break;
            case 'upay':
                $requiredAddress = 'upay';
                $idPrefix = 'TrxID ';
                $bodySnippets = ['credited by Tk.', 'has been received'];
                break;
            case 'cellfin':
                $requiredAddress = 'Islami.Bank';
                $idPrefix = 'TrxId: ';
                $bodySnippets = ['Received'];
                break;
            case 'tap':
                $requiredAddress = 'tap';
                $idPrefix = 'TrxID ';
                $bodySnippets = ['received Tk', 'Cash out of Tk'];
                break;
            default:
                $idPrefix = ''; 
                $bodySnippets = ['Tk', 'Amount'];
        }

        // 3. Search for matching SMS in the Global Pool
        $builder = $this->db->table('module_data')
            ->where('uid', $this->merchantId)
            ->where('status', 0); // Only unused SMS

        if ($requiredAddress) {
            $builder->where('LOWER(address)', strtolower($requiredAddress));
        }

        // Broad search for Transaction ID anywhere in the message content
        // This handles "TrxID: 123", "TrxID 123", "123", etc.
        $builder->groupStart()
            ->like('message', $transactionId) 
            ->orLike('message', strtoupper($transactionId))
            ->groupEnd();

        // Additionally confirm the body looks like a payment SMS
        if (!empty($bodySnippets)) {
            $builder->groupStart();
            foreach ($bodySnippets as $snippet) {
                $builder->orLike('message', $snippet);
            }
            $builder->groupEnd();
        }

        $smsRecord = $builder->get()->getRow();

        // 4. Device and Throttling Awareness
        $device = $this->db->table('devices')
            ->where('uid', $this->merchantId)
            ->orderBy('last_sync_at', 'DESC')
            ->get()->getRow();

        $isDeviceOnline = $device && $device->last_sync_at && (time() - strtotime($device->last_sync_at) <= 600);
        $cache = \Config\Services::cache();
        $failKey = "verify_fails_{$paymentId}";
        $fails = (int)$cache->get($failKey) ?: 0;

        // Pre-verification Duplicate Check
        $alreadyUsed = $this->db->table('api_payments')
            ->where('transaction_id', $transactionId)
            ->where('merchant_id', $this->merchantId)
            ->whereIn('status', [0, 1, 2, 6])
            ->get()->getRow();

        if ($alreadyUsed) {
            return [
                'success' => false,
                'code' => 'DUPLICATE_TRANSACTION',
                'message' => 'This Transaction ID has already been used for another payment.'
            ];
        }

        if (!$smsRecord) {
            // Only increment failure count if device is online (user error vs system delay)
            if ($isDeviceOnline) {
                $fails++;
                $cache->save($failKey, $fails, 300); // 5 minute cooldown
            }

            if ($fails >= 20) {
                return [
                    'success' => false,
                    'code' => 'TOO_MANY_ATTEMPTS',
                    'message' => 'Too many failed attempts. Please try again in 5 minutes.',
                    'retry_after' => 300
                ];
            }

            $statusMsg = "Transaction ID not found yet.";
            if ($device) {
                if ($isDeviceOnline) {
                    $statusMsg .= " Please wait a moment and try again.";
                } else {
                    $lastSeenStr = $device->last_sync_at ? floor((time() - strtotime($device->last_sync_at)) / 60) . " mins ago" : "never";
                    $statusMsg .= " Warning: Merchant phone is currently offline (last seen {$lastSeenStr}).";
                }
            } else {
                $statusMsg = "Merchant phone has never synced. Please contact support.";
            }

            return [
                'success' => false,
                'code' => 'NOT_FOUND',
                'message' => $statusMsg,
                'is_pending' => true,
                'device_online' => $isDeviceOnline
            ];
        }

        // 5. Strict Amount Extraction via Regex
        $message = $smsRecord->message;
        // Refined pattern to prioritize "Amount: Tk" or "Tk" followed by digits
        $pattern = '/(?:Amount: Tk|Tk|TK|tk|Rs|RS|rs|credited by Tk|Cash Out Tk)\.?\s*([\d,]+\.?\d*)/i';
        
        if (preg_match($pattern, $message, $matches)) {
            $receivedAmount = (float)str_replace(',', '', $matches[1]);
            
            // Allow for minor float precision differences
            if (abs($receivedAmount - $expectedAmount) > 0.01) {
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

        // 6. Finalize Verification
        $this->db->transStart();
        
        // Mark SMS as used
        $this->db->table('module_data')
            ->where('id', $smsRecord->id)
            ->update(['status' => 1, 'tmp_id' => $paymentId]);
            
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
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
            'verified' => true,
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

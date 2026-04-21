<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\PaymentProviderFactory;
use App\Libraries\WebhookService;

class PaymentController extends ResourceController
{
    protected $format = 'json';
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function create()
    {
        try {
            $auth = $this->getAuthData();
            $brand = $auth['brand'];
            $merchant = $auth['merchant'];
            $isTest = $auth['isTest'];

            q_debug("Starting payment creation for Merchant: {$merchant->id}, Brand: {$brand->id}, Test: " . ($isTest ? 'Yes' : 'No'), 'PAYMENT_CREATE');

            if ($auth['keyType'] === 'publishable') {
                return $this->respondError('FORBIDDEN', 'Publishable keys cannot create payments. Use a secret key (qp_*).', 403);
            }

            $request = service('request');
            $rules = [
                'amount' => 'required|numeric|greater_than[0]',
                'currency' => 'permit_empty|alpha|max_length[5]',
                'payment_method' => 'permit_empty|alpha_dash|max_length[50]',
                'callback_url' => 'permit_empty|valid_url_strict',
                'success_url' => 'permit_empty|valid_url_strict',
                'cancel_url' => 'permit_empty|valid_url_strict',
                'customer_email' => 'permit_empty|valid_email|max_length[255]',
                'customer_name' => 'permit_empty|string|max_length[255]',
                'metadata' => 'permit_empty',
            ];

            if (!$this->validate($rules)) {
                return $this->respondError('VALIDATION_ERROR', 'Invalid request parameters.', 422, $this->validator->getErrors());
            }

            $idempotencyKey = $request->getHeaderLine('Idempotency-Key');
            if (!empty($idempotencyKey)) {
                $existing = $this->db->table('api_payments')
                    ->where('idempotency_key', $idempotencyKey)
                    ->where('merchant_id', $merchant->id)
                    ->where('brand_id', $brand->id)
                    ->where('test_mode', $isTest ? 1 : 0)
                    ->get()
                    ->getRow();

                if ($existing) {
                    return $this->respond($this->formatPayment($existing), 200);
                }
            }

            $amount = (float) $request->getVar('amount');
            $currency = strtoupper($request->getVar('currency') ?? $brand->currency ?? 'BDT');
            $paymentMethod = $request->getVar('payment_method');
            $allowedMethods = $request->getVar('allowed_methods');
            $metadata = $request->getVar('metadata');

            if (empty($paymentMethod) && !empty($allowedMethods) && is_array($allowedMethods)) {
                $paymentMethod = $allowedMethods[0];
            }

            $fees = (float) $brand->fees;
            if ($brand->fees_type == 1) {
                $fees = $amount * ($brand->fees / 100);
            }

            $paymentIds = $this->generatePaymentId();

            $paymentData = [
                'ids' => $paymentIds,
                'merchant_id' => $merchant->id,
                'brand_id' => $brand->id,
                'idempotency_key' => !empty($idempotencyKey) ? $idempotencyKey : null,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 0,
                'test_mode' => $isTest ? 1 : 0,
                'payment_method' => $paymentMethod,
                'callback_url' => $request->getVar('callback_url'),
                'success_url' => $request->getVar('success_url'),
                'cancel_url' => $request->getVar('cancel_url'),
                'customer_email' => $request->getVar('customer_email'),
                'customer_name' => $request->getVar('customer_name'),
                'metadata' => (is_array($metadata) || is_object($metadata)) ? json_encode($metadata) : $metadata,
                'ip_address' => $request->getIPAddress(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('api_payments')->insert($paymentData);

            if ($this->db->affectedRows() === 0) {
                return $this->respondError('PAYMENT_CREATION_FAILED', 'Failed to create payment record.', 500);
            }

            if ($isTest) {
                $provider = new \App\Adapters\TestPaymentAdapter($merchant->id, $brand->id);
            } else {
                $provider = PaymentProviderFactory::create($merchant->id, $brand->id, ['payment_method' => $paymentMethod]);
            }

            $providerResult = $provider->initiatePayment($paymentData);

            if ($providerResult['success']) {
                $this->db->table('api_payments')
                    ->where('ids', $paymentIds)
                    ->update([
                        'status' => 1,
                        'transaction_id' => $providerResult['transaction_id'] ?? null,
                        'provider_response' => json_encode($providerResult),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                $paymentData['status'] = 1;
                $paymentData['transaction_id'] = $providerResult['transaction_id'] ?? null;
            } else {
                $this->db->table('api_payments')
                    ->where('ids', $paymentIds)
                    ->update([
                        'status' => 3,
                        'provider_response' => json_encode($providerResult),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                $paymentData['status'] = 3;
            }

            $webhookService = new WebhookService();
            $eventType = $providerResult['success'] ? 'payment.created' : 'payment.failed';
            $webhookService->dispatch($brand->id, $merchant->id, $eventType, [
                'id' => $paymentIds,
                'object' => 'payment',
                'amount' => $amount,
                'currency' => $currency,
                'status' => $providerResult['success'] ? 'processing' : 'failed',
                'test_mode' => $isTest,
                'error' => $providerResult['error'] ?? null,
                'error_code' => $providerResult['error_code'] ?? null,
            ]);

            $payment = $this->db->table('api_payments')->where('ids', $paymentIds)->get()->getRow();

            q_debug($providerResult, 'PROVIDER_RESPONSE');

            return $this->respond($this->formatPayment($payment, [
                'fees' => round($fees, 3),
                'net_amount' => round($amount - $fees, 3),
                'checkout_url' => base_url("api/v1/payment/checkout/{$paymentIds}"),
                'redirect_url' => $providerResult['redirect_url'] ?? null,
            ]), 201);
        } catch (\Throwable $e) {
            log_message('critical', $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->respondError('INTERNAL_SERVER_ERROR', 'An unexpected error occurred: ' . $e->getMessage(), 500);
        }
    }

    protected function getAuthData(): array
    {
        $request = service('request');
        $keyService = new \App\Libraries\ApiKeyService();
        
        $apiKey = $request->getHeaderLine('API-KEY');
        if (empty($apiKey)) {
            $apiKey = $request->getHeaderLine('Authorization');
            if (strpos($apiKey, 'Bearer ') === 0) {
                $apiKey = substr($apiKey, 7);
            }
        }

        if (empty($apiKey)) {
            $apiKey = (string) $request->getVar('api_key');
        }
        $apiKey = trim($apiKey);

        $keyRecord = $keyService->validate($apiKey);
        if (!$keyRecord) {
            throw new \RuntimeException('Authentication failure: Key validation failed inside controller.');
        }

        $brand = $this->db->table('brands')->where('id', $keyRecord->brand_id)->get()->getRow();
        $merchant = $this->db->table('users')->where('id', $keyRecord->merchant_id)->get()->getRow();

        return [
            'brand' => $brand,
            'merchant' => $merchant,
            'isTest' => ($keyRecord->environment === 'test'),
            'keyType' => $keyRecord->key_type,
            'apiKey' => $apiKey
        ];
    }

    public function verify($paymentId = null)
    {
        try {
            $auth = $this->getAuthData();
            $brand = $auth['brand'];
            $merchant = $auth['merchant'];
            $isTest = $auth['isTest'];

            if ($auth['keyType'] === 'publishable') {
                return $this->respondError('FORBIDDEN', 'Publishable keys cannot verify payments. Use a secret key (qp_*).', 403);
            }

            $request = service('request');
            if (empty($paymentId)) {
                $paymentId = $request->getVar('payment_id');
            }

            if (empty($paymentId)) {
                return $this->respondError('MISSING_PAYMENT_ID', 'Payment ID is required.', 400);
            }

            $payment = $this->findPayment($paymentId, $merchant->id, $brand->id, $isTest);

            if (!$payment) {
                return $this->respondError('PAYMENT_NOT_FOUND', 'No payment found with the provided ID.', 404);
            }

            if ((int) $payment->status === 3) {
                $formatted = $this->formatPayment($payment);
                $formatted['verified'] = false;
                $formatted['failure_reason'] = 'Payment has already failed and cannot be verified.';
                return $this->respond($formatted);
            }

            if ($isTest) {
                $provider = new \App\Adapters\TestPaymentAdapter($merchant->id, $brand->id);
            } else {
                $provider = PaymentProviderFactory::create($merchant->id, $brand->id, ['payment_method' => $payment->payment_method]);
            }

            $verifyResult = $provider->verifyPayment($paymentId, ['payment_method' => $payment->payment_method]);

            if ($verifyResult['success'] && ($verifyResult['verified'] ?? false) && $payment->status < 2) {
                $this->db->table('api_payments')
                    ->where('ids', $paymentId)
                    ->update([
                        'status' => 2,
                        'transaction_id' => $verifyResult['transaction_id'] ?? $paymentId,
                        'provider_response' => json_encode($verifyResult),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
                $payment->status = 2;

                // Dispatch Webhook
                $webhookService = new WebhookService();
                $webhookService->dispatch($brand->id, $merchant->id, 'payment.completed', $this->formatPayment($payment));

                // Send SMS/Email Alerts to Merchant if configured
                $smsSender = new \App\Libraries\Smssender();
                $smsParams = [
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'payment_id' => $payment->ids,
                    'method' => $payment->payment_method
                ];
                $smsSender->send_sms('payment_completed', $smsParams, null, $merchant->phone, $merchant->id);
            }

            $formatted = $this->formatPayment($payment);
            $formatted['verified'] = $verifyResult['verified'] ?? false;

            return $this->respond($formatted);
        } catch (\Throwable $e) {
            log_message('critical', $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->respondError('INTERNAL_SERVER_ERROR', 'An unexpected error occurred during verification.', 500);
        }
    }

    public function status($paymentId = null)
    {
        try {
            $auth = $this->getAuthData();
            $brand = $auth['brand'];
            $merchant = $auth['merchant'];
            $isTest = $auth['isTest'];

            if (empty($paymentId)) {
                return $this->respondError('MISSING_PAYMENT_ID', 'Payment ID is required.', 400);
            }

            $payment = $this->findPayment($paymentId, $merchant->id, $brand->id, $isTest);

            if (!$payment) {
                return $this->respondError('PAYMENT_NOT_FOUND', 'No payment found with the provided ID.', 404);
            }

            return $this->respond($this->formatPayment($payment));
        } catch (\Throwable $e) {
            log_message('critical', $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->respondError('INTERNAL_SERVER_ERROR', 'An unexpected error occurred while fetching status.', 500);
        }
    }

    public function listPayments()
    {
        try {
            $auth = $this->getAuthData();
            $brand = $auth['brand'];
            $merchant = $auth['merchant'];
            $isTest = $auth['isTest'];

            $request = service('request');
            $limit = min((int) ($request->getVar('limit') ?: 10), 100);
            $offset = max((int) ($request->getVar('offset') ?: 0), 0);
            $status = $request->getVar('status');

            $builder = $this->db->table('api_payments')
                ->where('merchant_id', $merchant->id)
                ->where('brand_id', $brand->id)
                ->where('test_mode', $isTest ? 1 : 0);

            if ($status !== null) {
                $statusMap = ['pending' => 0, 'processing' => 1, 'completed' => 2, 'failed' => 3, 'refunded' => 4];
                if (isset($statusMap[$status])) {
                    $builder->where('status', $statusMap[$status]);
                }
            }

            $total = (clone $builder)->countAllResults(false);

            $payments = $builder
                ->orderBy('created_at', 'DESC')
                ->limit($limit, $offset)
                ->get()
                ->getResult();

            $data = [];
            foreach ($payments as $payment) {
                $data[] = $this->formatPayment($payment);
            }

            return $this->respond([
                'object' => 'list',
                'data' => $data,
                'has_more' => ($offset + $limit) < $total,
                'total_count' => $total,
                'url' => '/api/v1/payments',
            ]);
        } catch (\Throwable $e) {
            log_message('critical', $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->respondError('INTERNAL_SERVER_ERROR', 'An unexpected error occurred while listing payments.', 500);
        }
    }

    public function refund()
    {
        try {
            $auth = $this->getAuthData();
            $brand = $auth['brand'];
            $merchant = $auth['merchant'];
            $isTest = $auth['isTest'];

            $request = service('request');
            if ($auth['keyType'] === 'publishable') {
                return $this->respondError('FORBIDDEN', 'Publishable keys cannot create refunds. Use a secret key (qp_*).', 403);
            }

            $paymentId = $request->getVar('payment_id');
            $reason = $request->getVar('reason');

            if (empty($paymentId)) {
                return $this->respondError('MISSING_PAYMENT_ID', 'Payment ID is required.', 400);
            }

            $payment = $this->findPayment($paymentId, $merchant->id, $brand->id, $isTest);

            if (!$payment) {
                return $this->respondError('PAYMENT_NOT_FOUND', 'No payment found with the provided ID.', 404);
            }

            if ($payment->status != 2) {
                return $this->respondError('PAYMENT_NOT_REFUNDABLE', 'Only completed payments can be refunded.', 400);
            }

            $this->db->table('api_payments')
                ->where('ids', $paymentId)
                ->update([
                    'status' => 4,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            $payment->status = 4;

            $refundId = 'ref_' . bin2hex(random_bytes(12));

            $webhookService = new WebhookService();
            $webhookService->dispatch($brand->id, $merchant->id, 'refund.created', [
                'id' => $refundId,
                'object' => 'refund',
                'payment' => $payment->ids,
                'amount' => (float) $payment->amount,
                'currency' => $payment->currency,
                'reason' => $reason,
                'status' => 'succeeded',
                'test_mode' => $isTest,
            ]);

            q_debug($refundId, 'REFUND_CREATED');

            return $this->respond([
                'id' => $refundId,
                'object' => 'refund',
                'amount' => (float) $payment->amount,
                'currency' => strtolower($payment->currency),
                'payment' => $payment->ids,
                'reason' => $reason,
                'status' => 'succeeded',
                'test_mode' => $isTest,
                'created' => time(),
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('critical', $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->respondError('INTERNAL_SERVER_ERROR', 'An unexpected error occurred during refund processing.', 500);
        }
    }

    public function balance()
    {
        try {
            $auth = $this->getAuthData();
            $brand = $auth['brand'];
            $merchant = $auth['merchant'];
            $isTest = $auth['isTest'];

            $completedSum = $this->db->table('api_payments')
                ->selectSum('amount')
                ->where('merchant_id', $merchant->id)
                ->where('brand_id', $brand->id)
                ->where('status', 2)
                ->where('test_mode', $isTest ? 1 : 0)
                ->get()
                ->getRow();

            $pendingSum = $this->db->table('api_payments')
                ->selectSum('amount')
                ->where('merchant_id', $merchant->id)
                ->where('brand_id', $brand->id)
                ->whereIn('status', [0, 1])
                ->where('test_mode', $isTest ? 1 : 0)
                ->get()
                ->getRow();

            $refundedSum = $this->db->table('api_payments')
                ->selectSum('amount')
                ->where('merchant_id', $merchant->id)
                ->where('brand_id', $brand->id)
                ->where('status', 4)
                ->where('test_mode', $isTest ? 1 : 0)
                ->get()
                ->getRow();

            return $this->respond([
                'object' => 'balance',
                'available' => (float) ($completedSum->amount ?? 0),
                'pending' => (float) ($pendingSum->amount ?? 0),
                'refunded' => (float) ($refundedSum->amount ?? 0),
                'currency' => $brand->currency ?? 'BDT',
                'test_mode' => $isTest,
            ]);
        } catch (\Throwable $e) {
            log_message('critical', $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->respondError('INTERNAL_SERVER_ERROR', 'An unexpected error occurred while fetching balance.', 500);
        }
    }

    public function getMethods()
    {
        try {
            $auth = $this->getAuthData();
            $brand = $auth['brand'];
            $merchant = $auth['merchant'];

            $wallets = $this->db->table('user_payment_settings')
                ->where('uid', $merchant->id)
                ->where('brand_id', $brand->id)
                ->where('status', 1)
                ->get()
                ->getResult();

            $methods = [];
            foreach ($wallets as $wallet) {
                $params = json_decode($wallet->params, true) ?: [];
                $methods[] = [
                    'id' => $wallet->g_type,
                    'name' => ucfirst($wallet->g_type),
                    'type' => $wallet->t_type,
                    'available' => true,
                    'has_direct_api' => !empty($params['api_url']),
                ];
            }

            $providers = PaymentProviderFactory::getAvailableProviders($merchant->id, $brand->id);

            return $this->respond([
                'object' => 'list',
                'data' => [
                    'methods' => $methods,
                    'providers' => $providers,
                    'brand' => [
                        'name' => $brand->brand_name,
                        'currency' => $brand->currency ?? 'BDT',
                        'fees' => (float) $brand->fees,
                        'fees_type' => $brand->fees_type == 1 ? 'percentage' : 'flat',
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            log_message('critical', $e->getMessage() . "\n" . $e->getTraceAsString());
            return $this->respondError('INTERNAL_SERVER_ERROR', 'An unexpected error occurred while fetching payment methods.', 500);
        }
    }

    protected function findPayment(string $paymentId, int $merchantId, int $brandId, bool $isTest): ?object
    {
        return $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->where('merchant_id', $merchantId)
            ->where('brand_id', $brandId)
            ->where('test_mode', $isTest ? 1 : 0)
            ->get()
            ->getRow();
    }

    protected function formatPayment(object $payment, array $extra = []): array
    {
        $data = [
            'id' => $payment->ids,
            'object' => 'payment',
            'amount' => (float) $payment->amount,
            'currency' => strtolower($payment->currency),
            'status' => $this->statusLabel((int) $payment->status),
            'payment_method' => $payment->payment_method,
            'transaction_id' => $payment->transaction_id ?? null,
            'customer_email' => $payment->customer_email ?? null,
            'customer_name' => $payment->customer_name ?? null,
            'metadata' => ($payment->metadata !== null ? (json_decode($payment->metadata, true) ?? $payment->metadata) : null),
            'test_mode' => (bool) ($payment->test_mode ?? false),
            'created' => strtotime($payment->created_at),
            'created_at' => $payment->created_at,
            'updated_at' => $payment->updated_at ?? null,
        ];

        return array_merge($data, $extra);
    }

    protected function respondError(string $code, string $message, int $httpCode, $errors = null): \CodeIgniter\HTTP\ResponseInterface
    {
        $body = [
            'status' => 'error',
            'code' => $code,
            'message' => $message,
        ];
        if ($errors) {
            $body['errors'] = $errors;
        }
        return $this->respond($body, $httpCode);
    }

    public function checkout($paymentId = null)
    {
        if (empty($paymentId)) {
            return $this->respondError('MISSING_PAYMENT_ID', 'Payment ID is required.', 400);
        }

        $payment = $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->get()
            ->getRow();

        if (!$payment) {
            return $this->respondError('PAYMENT_NOT_FOUND', 'No payment found with the provided ID.', 404);
        }

        $providerResponse = json_decode($payment->provider_response ?? '{}', true);
        $redirectUrl = $providerResponse['redirect_url'] ?? null;
        $successUrl = $payment->success_url ?? null;

        if ($redirectUrl && (int) $payment->status === 1) {
            return redirect()->to($redirectUrl);
        }

        // Fetch Brand and Merchant data
        $brand = $this->db->table('brands')->where('id', $payment->brand_id)->get()->getRow();
        $merchant = $this->db->table('users')->where('id', $payment->merchant_id)->get()->getRow();
        
        $isTestMode = (bool)($payment->test_mode ?? false);
        $status = $this->statusLabel((int)$payment->status);

        $theme = ($brand && $brand->meta) ? (json_decode($brand->meta, true)['theme'] ?? 'nago') : 'nago';
        $themePath = "themes/{$theme}/";

        // If the theme exists, use its modular structure
        if (is_dir(APPPATH . "Views/{$themePath}")) {
            return view("{$themePath}execute", [
                'payment_id' => $paymentId,
                'payment' => $payment,
                'brand' => $brand,
                'all_info' => $this->prepareLegacyInfo($payment, $brand),
                'mobile_s' => $this->getLegacyWallets($merchant->id, $brand->id, 'mobile'),
                'bank_s' => $this->getLegacyWallets($merchant->id, $brand->id, 'bank'),
                'int_b_s' => $this->getLegacyWallets($merchant->id, $brand->id, 'int_b'),
            ]);
        }

        // Prepare payment methods for the view
        $methodList = [];
        $wallets = $this->db->table('user_payment_settings')
            ->where('uid', $payment->merchant_id)
            ->where('brand_id', $payment->brand_id)
            ->where('status', 1)
            ->get()->getResult();

        foreach ($wallets as $wallet) {
            $methodList[] = [
                'id' => $wallet->g_type,
                'name' => ucfirst($wallet->g_type),
                'type' => $wallet->t_type
            ];
        }

        $selectedMethod = $payment->payment_method ?? ($methodList[0]['id'] ?? null);

        return view('api/checkout', [
            'payment_id' => $paymentId,
            'amount' => (float) $payment->amount,
            'currency' => $payment->currency ?? 'BDT',
            'status' => $status,
            'customer_email' => $payment->customer_email ?? '',
            'transaction_id' => $payment->transaction_id ?? '',
            'brand' => $brand,
            'brand_name' => $brand->brand_name ?? 'QPay',
            'cancel_url' => $payment->cancel_url ?? '',
            'success_url' => $successUrl ?? '',
            'methods' => $methodList,
            'test_mode' => $isTestMode,
            'payment_method' => $payment->payment_method,
            'selected_method' => $selectedMethod,
        ]);
    }

    /**
     * Legacy Theme Support: Execute Payment Page
     */
    public function executePayment($method, $paymentId)
    {
        $payment = $this->db->table('api_payments')->where('ids', $paymentId)->get()->getRow();
        if (!$payment) return redirect()->to(base_url());

        $brand = $this->db->table('brands')->where('id', $payment->brand_id)->get()->getRow();
        $theme = $brand->meta ? (json_decode($brand->meta, true)['theme'] ?? 'nago') : 'nago';
        
        $setting = $this->db->table('user_payment_settings')
            ->where('uid', $payment->merchant_id)
            ->where('brand_id', $payment->brand_id)
            ->where('g_type', $method)
            ->where('status', 1)
            ->get()->getRow();

        if ($setting) {
            $setting->params = json_decode($setting->params, true);
        }

        return view("themes/{$theme}/execute_payment", [
            'all_info' => $this->prepareLegacyInfo($payment, $brand),
            'setting' => (array)$setting,
            'payment' => $payment,
        ]);
    }

    /**
     * Legacy Theme Support: Save/Verify Payment Action
     */
    public function savePayment($method)
    {
        try {
            $paymentId = $this->request->getPost('tmp_id');
            $transactionId = $this->request->getPost('transaction_id');
            
            if (empty($paymentId) || empty($transactionId)) {
                return $this->respond(['status' => 'error', 'message' => 'Missing ID or Transaction ID'], 400);
            }

            $payment = $this->db->table('api_payments')->where('ids', $paymentId)->get()->getRow();
            if (!$payment) return $this->respond(['status' => 'error', 'message' => 'Payment not found'], 404);

            $provider = PaymentProviderFactory::create((int)$payment->merchant_id, (int)$payment->brand_id, ['payment_method' => $method]);
            $verifyResult = $provider->verifyPayment($transactionId, [
                'payment_id' => $paymentId,
                'payment_method' => $method
            ]);

            // 1. Success Flow
            if (isset($verifyResult['success']) && $verifyResult['success']) {
                try {
                    $webhookService = new WebhookService();
                    $webhookService->dispatch($payment->brand_id, $payment->merchant_id, 'payment.completed', [
                        'id' => $paymentId,
                        'status' => 'completed',
                        'amount' => (float)$payment->amount,
                        'transaction_id' => $transactionId
                    ]);
                } catch (\Exception $e) {
                    q_debug("Webhook failed but payment was verified: " . $e->getMessage(), 'PAYMENT_VERIFY_WARNING');
                }

                $redirect = base_url("api/v1/payment/checkout/{$paymentId}?status=success");
                if (!empty($payment->success_url)) {
                    $separator = str_contains($payment->success_url, '?') ? '&' : '?';
                    $redirect = $payment->success_url . $separator . "payment_id={$paymentId}&status=completed";
                }

                return $this->respond([
                    'status' => 'success',
                    'message' => 'Payment Verified Successfully!',
                    'redirect' => $redirect
                ]);
            }

            return $this->respond([
                'status' => 'error', 
                'message' => $verifyResult['message'] ?? 'Verification failed'
            ]);

        } catch (\Exception $e) {
            return $this->respond([
                'status' => 'error',
                'message' => 'Internal Error: ' . $e->getMessage()
            ], 500);
        }

        // 2. Pending/Polling Flow (High Latency)
        if (!empty($verifyResult['is_pending'])) {
            return $this->respond([
                'status' => 'pending',
                'message' => $verifyResult['message'] ?? 'Waiting for payment confirmation from your phone...',
                'poll' => true,
                'retry_after' => 5 // Seconds
            ], 202);
        }

        // 3. Error Flow
        return $this->respond([
            'status' => 'error',
            'code' => $verifyResult['code'] ?? 'VERIFICATION_FAILED',
            'message' => $verifyResult['message'] ?? 'Verification failed. Please check your transaction ID.'
        ], 200);
    }

    /**
     * Prepare data structure expected by legacy qpay-sub views
     */
    protected function prepareLegacyInfo($payment, $brand): array
    {
        return [
            'brand_id' => $brand->id,
            'brand_logo' => $brand->brand_logo,
            'brand_name' => $brand->brand_name,
            'support_mail' => get_value($brand->meta, 'support_mail'),
            'mobile_number' => get_value($brand->meta, 'mobile_number'),
            'whatsapp_number' => get_value($brand->meta, 'whatsapp_number'),
            'amount' => (float)$payment->amount,
            'total_amount' => (float)$payment->amount, 
            'transaction_id' => $payment->ids,
            'tmp_ids' => $payment->ids,
            'currency' => $payment->currency ?? 'BDT',
            'fees_amount' => 0, // Simplified for now
            'fees_type' => '',
        ];
    }

    protected function getLegacyWallets($uid, $brandId, $type): array
    {
        $wallets = $this->db->table('user_payment_settings')
            ->where('uid', $uid)
            ->where('brand_id', $brandId)
            ->where('t_type', $type)
            ->where('status', 1)
            ->get()
            ->getResult();

        $processed = [];
        foreach ($wallets as $wallet) {
            $params = json_decode($wallet->params, true) ?: [];
            $activePayments = $params['active_payments'] ?? [];

            foreach ($activePayments as $p_type => $active) {
                if ((int)$active === 1) {
                    $newItem = clone $wallet;
                    $newItem->active_payment = $p_type;
                    $processed[] = $newItem;
                }
            }
        }
        return $processed;
    }

    public function processCheckout($paymentId = null)
    {
        if (empty($paymentId)) {
            return $this->respondError('MISSING_PAYMENT_ID', 'Payment ID is required.', 400);
        }

        // Defensive: stripe /process if it exists due to form action mismatch
        $paymentId = str_replace('/process', '', $paymentId);

        $payment = $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->get()
            ->getRow();

        if (!$payment || (int) $payment->status !== 1) {
            return redirect()->to(base_url("api/v1/payment/checkout/{$paymentId}"));
        }

        $method = $this->request->getPost('payment_method');
        if (empty($method)) {
             return redirect()->to(base_url("api/v1/payment/checkout/{$paymentId}"));
        }

        $isTestMode = !empty($payment->test_mode);

        // Update selected payment method
        $this->db->table('api_payments')->where('ids', $paymentId)->update([
            'payment_method' => $method,
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        if ($isTestMode) {
            $txnId = 'test_txn_' . bin2hex(random_bytes(8));
            $this->db->table('api_payments')
                ->where('ids', $paymentId)
                ->update([
                    'status' => 2,
                    'transaction_id' => $txnId,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);

            $webhookService = new \App\Libraries\WebhookService();
            $webhookService->dispatch(
                (int) $payment->brand_id,
                (int) $payment->merchant_id,
                'payment.completed',
                [
                    'id' => $paymentId,
                    'amount' => (float) $payment->amount,
                    'currency' => $payment->currency ?? 'BDT',
                    'status' => 'completed',
                    'payment_method' => $method,
                    'transaction_id' => $txnId,
                    'customer_email' => $payment->customer_email ?? '',
                    'test_mode' => true,
                ]
            );

            $successUrl = $payment->success_url ?? null;
            if ($successUrl) {
                $separator = str_contains($successUrl, '?') ? '&' : '?';
                return redirect()->to($successUrl . $separator . 'payment_id=' . $paymentId . '&status=completed');
            }
            return redirect()->to(base_url("api/v1/payment/checkout/{$paymentId}"));
        }

        // Live Mode Processing
        try {
            $provider = PaymentProviderFactory::create((int)$payment->merchant_id, (int)$payment->brand_id, ['payment_method' => $method]);
            $initResult = $provider->initiatePayment((array)$payment);

            if (!empty($initResult['success'])) {
                // If the provider returned a redirect URL, go there
                if (!empty($initResult['redirect_url'])) {
                     $this->db->table('api_payments')
                        ->where('ids', $paymentId)
                        ->update([
                            'provider_response' => json_encode($initResult),
                            'updated_at' => date('Y-m-d H:i:s'),
                        ]);
                     return redirect()->to($initResult['redirect_url']);
                }
                
                // If it's a manual payment (like SMS verification based), 
                // it won't have a redirect_url. We just store the result 
                // and redirect back to the checkout page which will now show instructions.
                $this->db->table('api_payments')
                    ->where('ids', $paymentId)
                    ->update([
                        'provider_response' => json_encode($initResult),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);
            }
        } catch (\Throwable $e) {
            log_message('error', 'Checkout processing error: ' . $e->getMessage());
        }

        return redirect()->to(base_url("api/v1/payment/checkout/{$paymentId}"));
    }


    protected function generatePaymentId(): string
    {
        return 'pay_' . bin2hex(random_bytes(12));
    }

    protected function statusLabel(int $status): string
    {
        $labels = [
            0 => 'pending',
            1 => 'processing',
            2 => 'completed',
            3 => 'failed',
            4 => 'refunded',
        ];
        return $labels[$status] ?? 'unknown';
    }
}

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
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;
        $isTest = $request->isTestMode ?? false;

        if (($request->keyType ?? 'secret') === 'publishable') {
            return $this->respondError('FORBIDDEN', 'Publishable keys cannot create payments. Use a secret key (sk_*).', 403);
        }

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
        $metadata = $request->getVar('metadata');

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

        return $this->respond($this->formatPayment($payment, [
            'fees' => round($fees, 3),
            'net_amount' => round($amount - $fees, 3),
            'checkout_url' => base_url("api/v1/payment/checkout/{$paymentIds}"),
            'redirect_url' => $providerResult['redirect_url'] ?? null,
        ]), 201);
    }

    public function verify($paymentId = null)
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;
        $isTest = $request->isTestMode ?? false;

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

            $webhookService = new WebhookService();
            $webhookService->dispatch($brand->id, $merchant->id, 'payment.completed', [
                'id' => $payment->ids,
                'object' => 'payment',
                'amount' => (float) $payment->amount,
                'currency' => $payment->currency,
                'status' => 'completed',
                'test_mode' => $isTest,
            ]);
        }

        $formatted = $this->formatPayment($payment);
        $formatted['verified'] = $verifyResult['verified'] ?? false;

        return $this->respond($formatted);
    }

    public function status($paymentId = null)
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;
        $isTest = $request->isTestMode ?? false;

        if (empty($paymentId)) {
            return $this->respondError('MISSING_PAYMENT_ID', 'Payment ID is required.', 400);
        }

        $payment = $this->findPayment($paymentId, $merchant->id, $brand->id, $isTest);

        if (!$payment) {
            return $this->respondError('PAYMENT_NOT_FOUND', 'No payment found with the provided ID.', 404);
        }

        return $this->respond($this->formatPayment($payment));
    }

    public function listPayments()
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;
        $isTest = $request->isTestMode ?? false;

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
    }

    public function refund()
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;
        $isTest = $request->isTestMode ?? false;

        if (($request->keyType ?? 'secret') === 'publishable') {
            return $this->respondError('FORBIDDEN', 'Publishable keys cannot create refunds. Use a secret key (sk_*).', 403);
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

        $webhookService = new WebhookService();
        $webhookService->dispatch($brand->id, $merchant->id, 'refund.created', [
            'id' => 'ref_' . bin2hex(random_bytes(12)),
            'object' => 'refund',
            'payment_id' => $payment->ids,
            'amount' => (float) $payment->amount,
            'currency' => $payment->currency,
            'reason' => $reason,
            'status' => 'refunded',
            'test_mode' => $isTest,
        ]);

        return $this->respond($this->formatPayment($payment));
    }

    public function balance()
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;
        $isTest = $request->isTestMode ?? false;

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
    }

    public function getMethods()
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;

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

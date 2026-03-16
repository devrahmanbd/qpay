<?php

namespace App\Controllers\Api\V1;

use CodeIgniter\RESTful\ResourceController;
use App\Libraries\PaymentProviderFactory;

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

        $messages = [
            'amount' => [
                'required' => 'The payment amount is required.',
                'numeric' => 'Amount must be a valid number.',
                'greater_than' => 'Amount must be greater than zero.',
            ],
            'callback_url' => [
                'valid_url_strict' => 'Callback URL must be a valid URL (e.g., https://example.com/callback).',
            ],
            'success_url' => [
                'valid_url_strict' => 'Success URL must be a valid URL.',
            ],
            'cancel_url' => [
                'valid_url_strict' => 'Cancel URL must be a valid URL.',
            ],
        ];

        if (!$this->validate($rules, $messages)) {
            return $this->respond([
                'status' => 'error',
                'code' => 'VALIDATION_ERROR',
                'errors' => $this->validator->getErrors(),
            ], 422);
        }

        $idempotencyKey = $request->getHeaderLine('Idempotency-Key');
        if (!empty($idempotencyKey)) {
            $existing = $this->db->table('api_payments')
                ->where('idempotency_key', $idempotencyKey)
                ->where('merchant_id', $merchant->id)
                ->where('brand_id', $brand->id)
                ->get()
                ->getRow();

            if ($existing) {
                return $this->respond([
                    'status' => 'success',
                    'code' => 'IDEMPOTENT_REPLAY',
                    'message' => 'This request was already processed.',
                    'data' => [
                        'payment_id' => $existing->ids,
                        'amount' => (float) $existing->amount,
                        'currency' => $existing->currency,
                        'status' => $this->statusLabel($existing->status),
                        'transaction_id' => $existing->transaction_id,
                        'payment_method' => $existing->payment_method,
                        'created_at' => $existing->created_at,
                    ],
                ], 200);
            }
        }

        $amount = (float) $request->getVar('amount');
        $currency = strtoupper($request->getVar('currency') ?? 'BDT');
        $paymentMethod = $request->getVar('payment_method');
        $callbackUrl = $request->getVar('callback_url');
        $successUrl = $request->getVar('success_url');
        $cancelUrl = $request->getVar('cancel_url');
        $customerEmail = $request->getVar('customer_email');
        $customerName = $request->getVar('customer_name');
        $metadata = $request->getVar('metadata');

        $fees = (float) $brand->fees;
        if ($brand->fees_type == 1) {
            $fees = $amount * ($brand->fees / 100);
        }
        $netAmount = $amount - $fees;

        $paymentIds = $this->generatePaymentId();

        $paymentData = [
            'ids' => $paymentIds,
            'merchant_id' => $merchant->id,
            'brand_id' => $brand->id,
            'idempotency_key' => !empty($idempotencyKey) ? $idempotencyKey : null,
            'amount' => $amount,
            'currency' => $currency,
            'status' => 0,
            'payment_method' => $paymentMethod,
            'callback_url' => $callbackUrl,
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'customer_email' => $customerEmail,
            'customer_name' => $customerName,
            'metadata' => (is_array($metadata) || is_object($metadata)) ? json_encode($metadata) : $metadata,
            'ip_address' => $request->getIPAddress(),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('api_payments')->insert($paymentData);

        if ($this->db->affectedRows() === 0) {
            return $this->respond([
                'status' => 'error',
                'code' => 'PAYMENT_CREATION_FAILED',
                'message' => 'Failed to create payment record.',
            ], 500);
        }

        $provider = PaymentProviderFactory::create(
            $merchant->id,
            $brand->id,
            ['payment_method' => $paymentMethod]
        );
        $providerResult = $provider->initiatePayment($paymentData);

        if ($providerResult['success']) {
            $this->db->table('api_payments')
                ->where('ids', $paymentIds)
                ->update([
                    'status' => 1,
                    'provider_response' => json_encode($providerResult),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
        }

        $checkoutUrl = base_url("api/v1/payment/checkout/{$paymentIds}");

        return $this->respond([
            'status' => 'success',
            'code' => 'PAYMENT_CREATED',
            'data' => [
                'payment_id' => $paymentIds,
                'amount' => $amount,
                'fees' => round($fees, 3),
                'net_amount' => round($netAmount, 3),
                'currency' => $currency,
                'status' => $providerResult['success'] ? 'processing' : 'pending',
                'payment_method' => $paymentMethod,
                'checkout_url' => $checkoutUrl,
                'provider' => $providerResult['provider'] ?? null,
                'redirect_url' => $providerResult['redirect_url'] ?? null,
                'methods' => $providerResult['methods'] ?? null,
                'expires_at' => $providerResult['expires_at'] ?? null,
                'created_at' => $paymentData['created_at'],
            ],
        ], 201);
    }

    public function verify($paymentId = null)
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;

        if (empty($paymentId)) {
            $paymentId = $request->getVar('payment_id');
        }

        if (empty($paymentId)) {
            return $this->respond([
                'status' => 'error',
                'code' => 'MISSING_PAYMENT_ID',
                'message' => 'Payment ID is required.',
            ], 400);
        }

        $payment = $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->where('merchant_id', $merchant->id)
            ->where('brand_id', $brand->id)
            ->get()
            ->getRow();

        if (!$payment) {
            return $this->respond([
                'status' => 'error',
                'code' => 'PAYMENT_NOT_FOUND',
                'message' => 'No payment found with the provided ID.',
            ], 404);
        }

        $provider = PaymentProviderFactory::create(
            $merchant->id,
            $brand->id,
            ['payment_method' => $payment->payment_method]
        );

        $verifyResult = $provider->verifyPayment($paymentId, [
            'payment_method' => $payment->payment_method,
        ]);

        if ($verifyResult['success'] && $verifyResult['verified'] && $payment->status < 2) {
            $this->db->table('api_payments')
                ->where('ids', $paymentId)
                ->update([
                    'status' => 2,
                    'transaction_id' => $verifyResult['transaction_id'] ?? $paymentId,
                    'provider_response' => json_encode($verifyResult),
                    'updated_at' => date('Y-m-d H:i:s'),
                ]);
            $payment->status = 2;
        }

        return $this->respond([
            'status' => 'success',
            'data' => [
                'payment_id' => $payment->ids,
                'amount' => (float) $payment->amount,
                'currency' => $payment->currency,
                'status' => $this->statusLabel($payment->status),
                'payment_method' => $payment->payment_method,
                'transaction_id' => $payment->transaction_id,
                'verified' => $verifyResult['verified'] ?? false,
                'provider' => $verifyResult['provider'] ?? null,
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ],
        ]);
    }

    public function status($paymentId = null)
    {
        $request = service('request');
        $brand = $request->brand;
        $merchant = $request->merchant;

        if (empty($paymentId)) {
            return $this->respond([
                'status' => 'error',
                'code' => 'MISSING_PAYMENT_ID',
                'message' => 'Payment ID is required.',
            ], 400);
        }

        $payment = $this->db->table('api_payments')
            ->where('ids', $paymentId)
            ->where('merchant_id', $merchant->id)
            ->where('brand_id', $brand->id)
            ->get()
            ->getRow();

        if (!$payment) {
            return $this->respond([
                'status' => 'error',
                'code' => 'PAYMENT_NOT_FOUND',
                'message' => 'No payment found with the provided ID.',
            ], 404);
        }

        return $this->respond([
            'status' => 'success',
            'data' => [
                'payment_id' => $payment->ids,
                'amount' => (float) $payment->amount,
                'currency' => $payment->currency,
                'status' => $this->statusLabel($payment->status),
                'payment_method' => $payment->payment_method,
                'transaction_id' => $payment->transaction_id,
                'customer_email' => $payment->customer_email,
                'fees' => null,
                'metadata' => json_decode($payment->metadata, true),
                'created_at' => $payment->created_at,
                'updated_at' => $payment->updated_at,
            ],
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
            'status' => 'success',
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

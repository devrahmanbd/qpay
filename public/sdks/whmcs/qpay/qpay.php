<?php

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

use WHMCS\Module\Gateway\QPay\QPayClient;

require_once __DIR__ . '/lib/QPayClient.php';

function qpay_MetaData()
{
    return [
        'DisplayName'                => 'QPay Payment Gateway',
        'APIVersion'                 => '1.1',
        'DisableLocalCreditCardInput' => true,
        'TokenisedStorage'           => false,
        'gatewayType'                => 'Third Party',
    ];
}

function qpay_config()
{
    return [
        'FriendlyName' => [
            'Type'  => 'System',
            'Value' => 'QPay',
        ],
        'apiUrl' => [
            'FriendlyName' => 'QPay API URL',
            'Type'         => 'text',
            'Size'         => '50',
            'Default'      => 'https://qpay.qubickle.com',
            'Description'  => 'Your QPay gateway URL (e.g. https://qpay.qubickle.com)',
        ],
        'secretKey' => [
            'FriendlyName' => 'Secret API Key',
            'Type'         => 'password',
            'Size'         => '60',
            'Description'  => 'Your QPay secret key (sk_live_... or sk_test_...)',
        ],
        'webhookSecret' => [
            'FriendlyName' => 'Webhook Secret',
            'Type'         => 'password',
            'Size'         => '60',
            'Description'  => 'Your QPay webhook signing secret for verifying callback signatures.',
        ],
        'testMode' => [
            'FriendlyName' => 'Test Mode',
            'Type'         => 'yesno',
            'Description'  => 'Enable sandbox/test mode. Use sk_test_* keys when enabled.',
        ],
    ];
}

function qpay_link($params)
{
    $invoiceId   = $params['invoiceid'];
    $description = $params['description'];
    $amount      = $params['amount'];
    $currency    = $params['currency'];

    $firstName = $params['clientdetails']['firstname'];
    $lastName  = $params['clientdetails']['lastname'];
    $email     = $params['clientdetails']['email'];
    $phone     = $params['clientdetails']['phonenumber'];

    $apiUrl     = trim($params['apiUrl']);
    $secretKey  = $params['secretKey'];

    $systemUrl  = $params['systemurl'];
    $moduleName = $params['paymentmethod'];

    $callbackUrl = $systemUrl . 'modules/gateways/callback/' . $moduleName . '.php';
    $successUrl  = $systemUrl . 'viewinvoice.php?id=' . $invoiceId . '&paymentsuccess=true';
    $cancelUrl   = $systemUrl . 'viewinvoice.php?id=' . $invoiceId . '&paymentfailed=true';

    try {
        $client = new QPayClient($secretKey, $apiUrl);

        $response = $client->createPayment([
            'amount'      => (float) $amount,
            'currency'    => $currency ?: 'BDT',
            'cus_name'    => trim($firstName . ' ' . $lastName),
            'cus_email'   => $email,
            'cus_phone'   => $phone,
            'description' => $description,
            'success_url' => $successUrl,
            'cancel_url'  => $cancelUrl,
            'webhook_url' => $callbackUrl,
            'metadata'    => json_encode([
                'invoice_id' => $invoiceId,
                'source'     => 'whmcs',
                'whmcs_url'  => $systemUrl,
            ]),
        ]);

        if (!empty($response['payment_url'])) {
            return '<form method="GET" action="' . htmlspecialchars($response['payment_url']) . '">'
                . '<button type="submit" class="btn btn-primary" '
                . 'style="background-color:#4f46e5;color:#fff;padding:10px 24px;border:none;border-radius:8px;font-size:15px;font-weight:600;cursor:pointer;">'
                . 'Pay with QPay</button></form>';
        }

        $errorMsg = $response['message'] ?? 'Unknown error creating payment.';
        logTransaction($moduleName, $response, 'Payment Creation Failed');
        return '<div class="alert alert-danger" style="color:#dc2626;padding:10px;border:1px solid #dc2626;border-radius:6px;">'
            . 'Payment gateway error: ' . htmlspecialchars($errorMsg) . '</div>';
    } catch (\Exception $e) {
        logTransaction($moduleName, ['error' => $e->getMessage()], 'Payment Creation Exception');
        return '<div class="alert alert-danger" style="color:#dc2626;padding:10px;border:1px solid #dc2626;border-radius:6px;">'
            . 'Payment gateway error: ' . htmlspecialchars($e->getMessage()) . '</div>';
    }
}

function qpay_refund($params)
{
    $transactionId = $params['transid'];
    $amount        = $params['amount'];
    $apiUrl        = trim($params['apiUrl']);
    $secretKey     = $params['secretKey'];

    try {
        $client   = new QPayClient($secretKey, $apiUrl);
        $response = $client->refund($transactionId, 'Refund from WHMCS');

        if (isset($response['status']) && in_array($response['status'], ['REFUNDED', 'PENDING'])) {
            return [
                'status'  => 'success',
                'rawdata' => $response,
                'transid' => $response['refund_id'] ?? $transactionId,
            ];
        }

        return [
            'status'  => 'declined',
            'rawdata' => $response,
        ];
    } catch (\Exception $e) {
        return [
            'status'  => 'error',
            'rawdata' => ['error' => $e->getMessage()],
        ];
    }
}

function qpay_TransactionInformation($params)
{
    $transactionId = $params['transactionId'];
    $apiUrl        = trim($params['apiUrl']);
    $secretKey     = $params['secretKey'];

    try {
        $client   = new QPayClient($secretKey, $apiUrl);
        $response = $client->getPaymentStatus($transactionId);

        if (empty($response['payment'])) {
            return new \WHMCS\Module\Gateway\TransactionInformation();
        }

        $payment = $response['payment'];

        $info = new \WHMCS\Module\Gateway\TransactionInformation();
        $info->setTransactionId($payment['transaction_id'] ?? $transactionId)
            ->setAmount($payment['amount'] ?? 0)
            ->setCurrency($payment['currency'] ?? 'BDT');

        $statusMap = [
            'COMPLETED'  => \WHMCS\Module\Gateway\TransactionInformation::STATUS_SUCCESS,
            'PROCESSING' => \WHMCS\Module\Gateway\TransactionInformation::STATUS_PENDING,
            'PENDING'    => \WHMCS\Module\Gateway\TransactionInformation::STATUS_PENDING,
            'DECLINED'   => \WHMCS\Module\Gateway\TransactionInformation::STATUS_FAILED,
            'FAILED'     => \WHMCS\Module\Gateway\TransactionInformation::STATUS_FAILED,
            'REFUNDED'   => \WHMCS\Module\Gateway\TransactionInformation::STATUS_REFUNDED,
        ];

        $status = $statusMap[$payment['status'] ?? ''] ?? \WHMCS\Module\Gateway\TransactionInformation::STATUS_PENDING;
        $info->setStatus($status);

        if (!empty($payment['created_at'])) {
            $info->setDate(\Carbon\Carbon::parse($payment['created_at']));
        }

        $additionalData = [];
        if (!empty($payment['payment_method'])) {
            $additionalData[] = new \WHMCS\Module\Gateway\TransactionInformation\AdditionalDatum('Payment Method', $payment['payment_method']);
        }
        if (!empty($payment['cus_name'])) {
            $additionalData[] = new \WHMCS\Module\Gateway\TransactionInformation\AdditionalDatum('Customer', $payment['cus_name']);
        }
        if (!empty($payment['cus_email'])) {
            $additionalData[] = new \WHMCS\Module\Gateway\TransactionInformation\AdditionalDatum('Email', $payment['cus_email']);
        }
        if (!empty($payment['test_mode'])) {
            $additionalData[] = new \WHMCS\Module\Gateway\TransactionInformation\AdditionalDatum('Mode', 'Test/Sandbox');
        }

        $info->setAdditionalData($additionalData);

        return $info;
    } catch (\Exception $e) {
        return new \WHMCS\Module\Gateway\TransactionInformation();
    }
}

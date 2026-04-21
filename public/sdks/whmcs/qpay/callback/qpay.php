<?php

require_once __DIR__ . '/../../../../init.php';
require_once __DIR__ . '/../../../../includes/gatewayfunctions.php';
require_once __DIR__ . '/../../../../includes/invoicefunctions.php';
require_once __DIR__ . '/../lib/QPayClient.php';

use WHMCS\Module\Gateway\QPay\QPayClient;

$gatewayModuleName = 'qpay';
$gatewayParams     = getGatewayVariables($gatewayModuleName);

if (!$gatewayParams['type']) {
    logTransaction($gatewayModuleName, $_REQUEST, 'Module Not Activated');
    http_response_code(500);
    die('Module not activated');
}

$webhookSecret = $gatewayParams['webhookSecret'] ?? '';
$apiUrl        = trim($gatewayParams['apiUrl']);
$secretKey     = $gatewayParams['secretKey'];

$rawPayload = file_get_contents('php://input');

if (!empty($webhookSecret)) {
    $signature = $_SERVER['HTTP_QPAY_SIGNATURE'] ?? '';
    if (empty($signature)) {
        logTransaction($gatewayModuleName, ['error' => 'Missing QPay-Signature header'], 'Signature Missing');
        http_response_code(400);
        die('Missing signature');
    }

    $valid = QPayClient::verifyWebhookSignature($rawPayload, $signature, $webhookSecret);
    if (!$valid) {
        logTransaction($gatewayModuleName, [
            'error'     => 'Invalid webhook signature',
            'signature' => $signature,
        ], 'Signature Verification Failed');
        http_response_code(401);
        die('Invalid signature');
    }
}

$data = json_decode($rawPayload, true);
if (empty($data)) {
    $data = $_REQUEST;
}

$transactionId = $data['transaction_id'] ?? $data['transactionId'] ?? '';
$paymentStatus = strtoupper($data['status'] ?? '');
$paymentAmount = $data['amount'] ?? $data['paymentAmount'] ?? 0;
$transactionId = $data['transaction_id'] ?? $data['transactionId'] ?? $data['id'] ?? '';
$invoiceId     = 0;

if (!empty($data['metadata'])) {
    $metadata = is_string($data['metadata']) ? json_decode($data['metadata'], true) : $data['metadata'];
    $invoiceId = (int) ($metadata['invoice_id'] ?? 0);
}

if (empty($invoiceId) && !empty($transactionId)) {
    try {
        $client   = new QPayClient($secretKey, $apiUrl);
        // Fallback for ID if transaction_id was QPay ID
        $response = $client->getPaymentStatus($transactionId);
        $payment = $response['payment'] ?? $response; // Handle both top-level and nested payment objects
        
        if (!empty($payment['metadata'])) {
            $meta = is_string($payment['metadata']) ? json_decode($payment['metadata'], true) : $payment['metadata'];
            $invoiceId = (int) ($meta['invoice_id'] ?? 0);
        }
        $paymentAmount = $payment['amount'] ?? $paymentAmount;
        $paymentStatus = strtoupper($payment['status'] ?? $paymentStatus);
        
        // Use the actual reference if available
        $transactionId = $payment['transaction_id'] ?? $transactionId;
    } catch (\Exception $e) {
        logTransaction($gatewayModuleName, ['error' => $e->getMessage()], 'Status Lookup Failed');
    }
}

if (empty($invoiceId)) {
    logTransaction($gatewayModuleName, $data, 'Invoice ID Not Found');
    http_response_code(400);
    die('Invoice ID not found');
}

$invoiceId = checkCbInvoiceID($invoiceId, $gatewayModuleName);
checkCbTransID($transactionId);

$logData = [
    'transaction_id' => $transactionId,
    'status'         => $paymentStatus,
    'amount'         => $paymentAmount,
    'invoice_id'     => $invoiceId,
];

$successStatuses = ['COMPLETED', 'SUCCESS', 'PAID'];
$pendingStatuses = ['PROCESSING', 'PENDING'];
$failedStatuses  = ['DECLINED', 'FAILED', 'CANCELLED', 'EXPIRED'];

if (in_array(strtoupper($paymentStatus), $successStatuses)) {
    addInvoicePayment(
        $invoiceId,
        $transactionId,
        $paymentAmount,
        0,
        $gatewayModuleName
    );
    logTransaction($gatewayModuleName, $logData, 'Payment Successful');
    http_response_code(200);
    echo json_encode(['status' => 'ok', 'message' => 'Payment recorded']);
} elseif (in_array(strtoupper($paymentStatus), $pendingStatuses)) {
    logTransaction($gatewayModuleName, $logData, 'Payment Pending');
    http_response_code(200);
    echo json_encode(['status' => 'ok', 'message' => 'Payment pending']);
} elseif (in_array(strtoupper($paymentStatus), $failedStatuses)) {
    logTransaction($gatewayModuleName, $logData, 'Payment Failed');
    http_response_code(200);
    echo json_encode(['status' => 'ok', 'message' => 'Payment failed']);
} else {
    logTransaction($gatewayModuleName, $logData, 'Unknown Status: ' . $paymentStatus);
    http_response_code(200);
    echo json_encode(['status' => 'ok', 'message' => 'Status received']);
}

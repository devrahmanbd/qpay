<?php
require 'app/Config/Paths.php';
$paths = new Config\Paths();
require $paths->systemDirectory . '/bootstrap.php';

$db = \Config\Database::connect();

$paymentId = 'pay_d80258ab00db99cc0f2a7be6';
$payment = $db->table('api_payments')->where('ids', $paymentId)->get()->getRow();

if (!$payment) {
    die("Payment not found\n");
}

$merchantSettings = $db->table('user_payment_settings')
    ->where('brand_id', $payment->brand_id)
    ->where('status', 1)
    ->get()
    ->getResult();

$configuredGateways = [];
foreach ($merchantSettings as $setting) {
    $params = json_decode($setting->params ?? '{}', true);
    $activeSubPayments = $params['active_payments'] ?? [];
    
    $hasActiveSub = false;
    foreach ($activeSubPayments as $type => $isActive) {
        if ((int)$isActive === 1) {
            $hasActiveSub = true;
            break;
        }
    }

    $hasDetails = false;
    $fieldsToCheck = ['personal_number', 'agent_number', 'payment_number', 'merchant_id', 'merchant_code'];
    foreach ($fieldsToCheck as $field) {
        if (!empty($params[$field])) {
            $hasDetails = true;
            break;
        }
    }

    if ($hasActiveSub && $hasDetails) {
        $configuredGateways[] = $setting->g_type;
    }
}

echo "Configured Gateways for Brand " . $payment->brand_id . ": " . implode(', ', $configuredGateways) . "\n";

$methods = $db->table('payments')
    ->where('status', 1)
    ->whereIn('type', $configuredGateways ?: ['none'])
    ->get()
    ->getResult();

echo "Filtered Methods:\n";
foreach ($methods as $m) {
    echo "- " . $m->name . " (" . $m->type . ")\n";
}

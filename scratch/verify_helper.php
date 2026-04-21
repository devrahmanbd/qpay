<?php
require_once 'app/Helpers/common_helper.php';

// Mock getenv
function set_env($key, $val) {
    putenv("$key=$val");
}

set_env('PAYMENT_URL', 'https://checkout.qpay.cloudman.one/');
echo "With PAYMENT_URL: " . payment_base_url('api/v1/test') . "\n";

putenv('PAYMENT_URL'); // clear it
echo "Without PAYMENT_URL (fallback to base_url): " . payment_base_url('api/v1/test') . "\n";

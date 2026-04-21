<?php
echo "Current Path: " . __DIR__ . "\n";
echo "SmsVerificationAdapter message: " . (file_exists('app/Adapters/SmsVerificationAdapter.php') ? 'exists' : 'missing') . "\n";
if (file_exists('app/Adapters/SmsVerificationAdapter.php')) {
    $content = file_get_contents('app/Adapters/SmsVerificationAdapter.php');
    if (strpos($content, 'fails >= 20') !== false) {
        echo "Code on disk IS UPDATED\n";
    } else {
        echo "Code on disk IS OLD\n";
    }
}

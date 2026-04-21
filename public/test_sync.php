<?php
echo "Current Path: " . __DIR__ . "\n";
$filePath = dirname(__DIR__) . '/app/Adapters/SmsVerificationAdapter.php';
echo "SmsVerificationAdapter path: $filePath\n";
echo "File exists: " . (file_exists($filePath) ? 'YES' : 'NO') . "\n";
if (file_exists($filePath)) {
    $content = file_get_contents($filePath);
    if (strpos($content, 'fails >= 20') !== false) {
        echo "Code on disk IS UPDATED\n";
    } else {
        echo "Code on disk IS OLD\n";
    }
}

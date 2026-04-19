<?php
require 'app/Libraries/ApiKeyService.php';
$service = new \App\Libraries\ApiKeyService();
$pair = $service->generateKey(1, 1, 'test');
echo "SECRET: " . $pair['secret'] . "\n";
echo "HASH: " . hash('sha256', $pair['secret']) . "\n";

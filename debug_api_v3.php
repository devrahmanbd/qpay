<?php
// Mock service logic locally
require_once 'app/Libraries/ApiKeyService.php';

// Simulate the validate logic with a key that has spaces
$apiKeyWithSpaces = "  qp_test_5431627cde97fd0c07ba69c4951bbdafb8bb0bf57ecc162a  ";
$cleanKey = "qp_test_5431627cde97fd0c07ba69c4951bbdafb8bb0bf57ecc162a";

echo "Original Key Hash: " . hash('sha256', $cleanKey) . "\n";
echo "Trimming logic check: " . (trim($apiKeyWithSpaces) === $cleanKey ? 'PASS' : 'FAIL') . "\n";
echo "Hash check: " . (hash('sha256', trim($apiKeyWithSpaces)) === hash('sha256', $cleanKey) ? 'PASS' : 'FAIL') . "\n";

<?php

namespace App\Interfaces;

interface PaymentProviderInterface
{
    public function initiatePayment(array $paymentData): array;

    public function verifyPayment(string $transactionId, array $context = []): array;

    public function refundPayment(string $transactionId, float $amount = 0, string $reason = ''): array;

    public function getProviderName(): string;

    public function isAvailable(): bool;
}

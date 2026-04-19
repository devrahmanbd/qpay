<?php

namespace App\Libraries;

use App\Interfaces\PaymentProviderInterface;
use App\Adapters\SmsVerificationAdapter;
use App\Adapters\DirectApiAdapter;
use App\Adapters\BkashAdapter;
use App\Adapters\TestPaymentAdapter;

class PaymentProviderFactory
{
    public static function create(int $merchantId, int $brandId, array $config = []): PaymentProviderInterface
    {
        $db = db_connect();

        $preferDirect = false;
        if (!empty($config['payment_method'])) {
            $wallet = $db->table('user_payment_settings')
                ->where('uid', $merchantId)
                ->where('brand_id', $brandId)
                ->where('g_type', $config['payment_method'])
                ->where('status', 1)
                ->get()
                ->getRow();

            if ($wallet) {
                if ($wallet->g_type === 'bkash') {
                    $bkash = new BkashAdapter($merchantId, $brandId, $config);
                    if ($bkash->isAvailable()) {
                        return $bkash;
                    }
                }

                if ($wallet->g_type === 'nagad') {
                    $nagad = new NagadAdapter($merchantId, $brandId, $config);
                    if ($nagad->isAvailable()) {
                        return $nagad;
                    }
                }

                $params = json_decode($wallet->params, true) ?: [];
                if (!empty($params['api_url']) && !empty($params['api_key'])) {
                    $preferDirect = true;
                }
            }
        }

        if ($preferDirect) {
            return new DirectApiAdapter($merchantId, $brandId, $config);
        }

        return new SmsVerificationAdapter($merchantId, $brandId);
    }

    public static function getAvailableProviders(int $merchantId, int $brandId): array
    {
        $providers = [];

        $sms = new SmsVerificationAdapter($merchantId, $brandId);
        if ($sms->isAvailable()) {
            $providers[] = [
                'name' => $sms->getProviderName(),
                'type' => 'sms_verification',
                'supports_refund' => false,
            ];
        }

        $direct = new DirectApiAdapter($merchantId, $brandId);
        if ($direct->isAvailable()) {
            $providers[] = [
                'name' => $direct->getProviderName(),
                'type' => 'direct_api',
                'supports_refund' => true,
            ];
        }

        $bkash = new BkashAdapter($merchantId, $brandId);
        if ($bkash->isAvailable()) {
            $providers[] = [
                'name' => 'bKash Tokenized',
                'type' => 'bkash_tokenized',
                'supports_refund' => true,
            ];
        }

        return $providers;
    }
}

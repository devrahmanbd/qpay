<?php

namespace App\Libraries;

class ApiLogger
{
    protected $db;
    protected $startTime;

    public function __construct()
    {
        $this->db = db_connect();
        $this->startTime = microtime(true);
    }

    public function log(array $data): void
    {
        try {
            $responseTime = round((microtime(true) - $this->startTime) * 1000);

            $this->db->table('api_logs')->insert([
                'api_key_id' => $data['api_key_id'] ?? null,
                'brand_id' => $data['brand_id'] ?? null,
                'merchant_id' => $data['merchant_id'] ?? null,
                'method' => $data['method'] ?? 'GET',
                'endpoint' => $data['endpoint'] ?? '',
                'status_code' => $data['status_code'] ?? 200,
                'ip_address' => $data['ip_address'] ?? null,
                'response_time_ms' => $responseTime,
                'environment' => $data['environment'] ?? 'live',
                'created_at' => date('Y-m-d H:i:s'),
            ]);
        } catch (\Throwable $e) {
            log_message('error', '[ApiLogger] Failed to insert log: ' . $e->getMessage());
        }
    }

    public function getStats(int $brandId, int $merchantId, string $period = '24h'): array
    {
        try {
            $since = $this->periodToDate($period);

            $total = $this->db->table('api_logs')
                ->where('brand_id', $brandId)
                ->where('merchant_id', $merchantId)
                ->where('created_at >=', $since)
                ->countAllResults(false);

            $errors = $this->db->table('api_logs')
                ->where('brand_id', $brandId)
                ->where('merchant_id', $merchantId)
                ->where('status_code >=', 400)
                ->where('created_at >=', $since)
                ->countAllResults(false);

            $avgResponse = $this->db->table('api_logs')
                ->selectAvg('response_time_ms', 'avg_ms')
                ->where('brand_id', $brandId)
                ->where('merchant_id', $merchantId)
                ->where('created_at >=', $since)
                ->get()
                ->getRow();

            return [
                'total_requests' => $total,
                'error_count' => $errors,
                'error_rate' => $total > 0 ? round($errors / $total * 100, 2) : 0,
                'avg_response_ms' => $avgResponse ? round($avgResponse->avg_ms ?? 0) : 0,
                'period' => $period,
            ];
        } catch (\Throwable $e) {
            log_message('error', '[ApiLogger] Failed to get stats: ' . $e->getMessage());
            return [
                'total_requests' => 0,
                'error_count' => 0,
                'error_rate' => 0,
                'avg_response_ms' => 0,
                'status' => 'error_recovering'
            ];
        }
    }

    public function getRecentLogs(int $brandId, int $merchantId, int $limit = 50): array
    {
        return $this->db->table('api_logs')
            ->where('brand_id', $brandId)
            ->where('merchant_id', $merchantId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }

    public function getAdminStats(string $period = '24h'): array
    {
        $since = $this->periodToDate($period);

        $total = $this->db->table('api_logs')
            ->where('created_at >=', $since)
            ->countAllResults(false);

        $errors = $this->db->table('api_logs')
            ->where('status_code >=', 400)
            ->where('created_at >=', $since)
            ->countAllResults(false);

        $activeKeys = $this->db->table('api_keys')
            ->where('revoked_at', null)
            ->countAllResults(false);

        $webhookDelivered = $this->db->table('webhook_events')
            ->where('status', 'delivered')
            ->where('created_at >=', $since)
            ->countAllResults(false);

        $webhookFailed = $this->db->table('webhook_events')
            ->where('status', 'failed')
            ->where('created_at >=', $since)
            ->countAllResults(false);

        $topMerchants = $this->db->table('api_logs')
            ->select('merchant_id, COUNT(*) as request_count')
            ->where('created_at >=', $since)
            ->groupBy('merchant_id')
            ->orderBy('request_count', 'DESC')
            ->limit(10)
            ->get()
            ->getResult();

        return [
            'total_requests' => $total,
            'error_count' => $errors,
            'error_rate' => $total > 0 ? round($errors / $total * 100, 2) : 0,
            'active_api_keys' => $activeKeys,
            'webhooks_delivered' => $webhookDelivered,
            'webhooks_failed' => $webhookFailed,
            'top_merchants' => $topMerchants,
            'period' => $period,
        ];
    }

    public function clearLogs(int $brandId, int $merchantId): bool
    {
        return $this->db->table('api_logs')
            ->where('brand_id', $brandId)
            ->where('merchant_id', $merchantId)
            ->delete();
    }

    protected function periodToDate(string $period): string
    {
        $map = [
            '1h' => '-1 hour',
            '24h' => '-24 hours',
            '7d' => '-7 days',
            '30d' => '-30 days',
        ];

        $modifier = $map[$period] ?? '-24 hours';
        return date('Y-m-d H:i:s', strtotime($modifier));
    }
}

<?php

namespace App\Libraries;

class WebhookService
{
    protected $db;
    const MAX_ATTEMPTS = 3;
    const BACKOFF_DELAYS = [60, 300, 1800];

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function registerWebhook(int $brandId, int $merchantId, string $url, array $events = ['*']): array
    {
        if (!$this->isUrlSafe($url)) {
            throw new \InvalidArgumentException('Webhook URL must use HTTPS and point to a public internet address.');
        }

        $secret = 'whsec_' . bin2hex(random_bytes(24));

        $data = [
            'brand_id' => $brandId,
            'merchant_id' => $merchantId,
            'url' => $url,
            'secret' => $secret,
            'events' => json_encode($events),
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('webhooks')->insert($data);

        return [
            'id' => $this->db->insertID(),
            'secret' => $secret,
            'url' => $url,
            'events' => $events,
        ];
    }

    public function dispatch(int $brandId, int $merchantId, string $eventType, array $payload): void
    {
        $webhooks = $this->db->table('webhooks')
            ->where('brand_id', $brandId)
            ->where('merchant_id', $merchantId)
            ->where('status', 1)
            ->get()
            ->getResult();

        $dispatched = false;

        foreach ($webhooks as $webhook) {
            $events = json_decode($webhook->events, true) ?: ['*'];
            if (!in_array('*', $events) && !in_array($eventType, $events)) {
                continue;
            }

            $wrappedPayload = json_encode([
                'event' => $eventType,
                'data' => $payload,
                'created' => time(),
            ]);

            $eventData = [
                'webhook_id' => $webhook->id,
                'event' => $eventType,
                'payload' => $wrappedPayload,
                'status' => 'pending',
                'attempts' => 0,
                'created_at' => date('Y-m-d H:i:s'),
            ];

            $this->db->table('webhook_events')->insert($eventData);
            $eventId = $this->db->insertID();

            $delivered = $this->deliver($eventId, $webhook);
            if ($delivered) {
                $dispatched = true;
            }
        }

        if ($dispatched && isset($payload['id']) && in_array($eventType, ['payment.created', 'payment.completed', 'payment.failed', 'refund.created', 'payment.canceled', 'payment.pending_review'])) {
            $this->db->table('api_payments')
                ->where('ids', $payload['id'])
                ->update(['webhook_delivered' => 1]);
        }
    }

    public function deliver(int $eventId, ?object $webhook = null): bool
    {
        $event = $this->db->table('webhook_events')
            ->where('id', $eventId)
            ->get()
            ->getRow();

        if (!$event || $event->status === 'delivered') {
            return false;
        }

        if ($event->attempts >= self::MAX_ATTEMPTS) {
            $this->db->table('webhook_events')
                ->where('id', $eventId)
                ->update(['status' => 'failed']);
            return false;
        }

        if (!$webhook) {
            $webhook = $this->db->table('webhooks')
                ->where('id', $event->webhook_id)
                ->get()
                ->getRow();
        }

        if (!$webhook) {
            return false;
        }

        $payload = $event->payload;
        $timestamp = time();
        $signature = $this->computeSignature($payload, $webhook->secret, $timestamp);

        $headers = [
            'Content-Type: application/json',
            'QPay-Signature: t=' . $timestamp . ',v1=' . $signature,
            'QPay-Event-Type: ' . $event->event,
        ];

        $ch = curl_init($webhook->url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 10,
            CURLOPT_CONNECTTIMEOUT => 5,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        $delivered = $httpCode >= 200 && $httpCode < 300;
        $newAttempts = $event->attempts + 1;

        $updateData = [
            'attempts' => $newAttempts,
            'last_attempt_at' => date('Y-m-d H:i:s'),
            'response_code' => $httpCode,
            'response_body' => substr($response ?: '', 0, 1000),
        ];

        if ($delivered) {
            $updateData['status'] = 'delivered';
        } elseif ($newAttempts >= self::MAX_ATTEMPTS) {
            $updateData['status'] = 'failed';
        } else {
            $updateData['status'] = 'pending';
            $backoffSeconds = self::BACKOFF_DELAYS[$newAttempts - 1] ?? 1800;
            $updateData['next_retry_at'] = date('Y-m-d H:i:s', time() + $backoffSeconds);
        }

        $this->db->table('webhook_events')
            ->where('id', $eventId)
            ->update($updateData);

        return $delivered;
    }

    public function computeSignature(string $payload, string $secret, int $timestamp): string
    {
        $signedPayload = $timestamp . '.' . $payload;
        return hash_hmac('sha256', $signedPayload, $secret);
    }

    public static function verifySignature(string $payload, string $signatureHeader, string $secret, int $tolerance = 300): bool
    {
        $parts = [];
        foreach (explode(',', $signatureHeader) as $item) {
            $pair = explode('=', $item, 2);
            if (count($pair) !== 2) {
                continue;
            }
            $parts[$pair[0]] = $pair[1];
        }

        if (!isset($parts['t'], $parts['v1'])) {
            return false;
        }

        $timestamp = (int) $parts['t'];
        if (abs(time() - $timestamp) > $tolerance) {
            return false;
        }

        $expected = hash_hmac('sha256', $timestamp . '.' . $payload, $secret);
        return hash_equals($expected, $parts['v1']);
    }

    public function retryFailed(): int
    {
        $now = date('Y-m-d H:i:s');

        $pending = $this->db->table('webhook_events')
            ->where('status', 'pending')
            ->where('attempts <', self::MAX_ATTEMPTS)
            ->where('attempts >', 0)
            ->groupStart()
                ->where('next_retry_at IS NULL')
                ->orWhere('next_retry_at <=', $now)
            ->groupEnd()
            ->get()
            ->getResult();

        $retried = 0;
        foreach ($pending as $event) {
            if ($this->deliver($event->id)) {
                $retried++;
            }
        }

        return $retried;
    }

    public function listWebhooks(int $brandId, int $merchantId): array
    {
        return $this->db->table('webhooks')
            ->where('brand_id', $brandId)
            ->where('merchant_id', $merchantId)
            ->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getWebhookEvents(int $webhookId, int $limit = 20): array
    {
        return $this->db->table('webhook_events')
            ->where('webhook_id', $webhookId)
            ->orderBy('created_at', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }

    protected function isUrlSafe(string $url): bool
    {
        $parsed = parse_url($url);
        if (!$parsed || empty($parsed['host'])) {
            return false;
        }

        $scheme = $parsed['scheme'] ?? '';
        $isDev = defined('ENVIRONMENT') && ENVIRONMENT === 'development';
        $globalDebug = get_option('global_debug', 0) == 1;

        if ($scheme !== 'https') {
            if (!$isDev && !$globalDebug && $scheme !== 'http') {
                return false;
            }
        }

        $host = $parsed['host'];
        $baseUrl = config('App')->baseURL ?? '';
        if (($isDev || $globalDebug || strpos($baseUrl, 'localhost') !== false) && ($host === 'localhost' || $host === '127.0.0.1')) {
            return true;
        }

        $ips = gethostbynamel($host);
        if (!$ips) {
            return false;
        }

        foreach ($ips as $ip) {
            if (
                filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false
            ) {
                // In dev, we might allow private IPs if explicitly configured, 
                // but usually localhost/127.0.0.1 is handled above.
                if (!$isDev) {
                    return false;
                }
            }
        }

        return true;
    }

    public function deleteWebhook(int $webhookId, int $merchantId): bool
    {
        return $this->db->table('webhooks')
            ->where('id', $webhookId)
            ->where('merchant_id', $merchantId)
            ->delete();
    }

    public function updateWebhook(int $webhookId, int $merchantId, array $data): bool
    {
        $allowed = ['url', 'events', 'status'];
        $update = array_intersect_key($data, array_flip($allowed));
        $update['updated_at'] = date('Y-m-d H:i:s');

        if (isset($update['url']) && !$this->isUrlSafe($update['url'])) {
            throw new \InvalidArgumentException('Webhook URL must use HTTPS and point to a public internet address.');
        }

        if (isset($update['events']) && is_array($update['events'])) {
            $update['events'] = json_encode($update['events']);
        }

        return $this->db->table('webhooks')
            ->where('id', $webhookId)
            ->where('merchant_id', $merchantId)
            ->update($update);
    }

    public function rotateSecret(int $webhookId, int $merchantId): string
    {
        $newSecret = 'whsec_' . bin2hex(random_bytes(24));
        
        $this->db->table('webhooks')
            ->where('id', $webhookId)
            ->where('merchant_id', $merchantId)
            ->update([
                'secret' => $newSecret,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
            
        return $newSecret;
    }

    public function clearEvents(int $webhookId, int $merchantId): bool
    {
        $webhook = $this->db->table('webhooks')
            ->where('id', $webhookId)
            ->where('merchant_id', $merchantId)
            ->get()
            ->getRow();

        if (!$webhook) {
            return false;
        }

        return $this->db->table('webhook_events')
            ->where('webhook_id', $webhookId)
            ->delete();
    }

    public function ping(int $webhookId, int $merchantId): bool
    {
        $webhook = $this->db->table('webhooks')
            ->where('id', $webhookId)
            ->where('merchant_id', $merchantId)
            ->get()
            ->getRow();

        if (!$webhook) {
            return false;
        }

        $eventType = 'ping';
        $payload = [
            'id' => 'ping_' . bin2hex(random_bytes(8)),
            'message' => 'Hello from ' . site_config('site_name', 'QPay') . '!',
            'timestamp' => time(),
        ];

        $wrappedPayload = json_encode([
            'event' => $eventType,
            'data' => $payload,
            'created' => time(),
        ]);

        $eventData = [
            'webhook_id' => $webhook->id,
            'event' => $eventType,
            'payload' => $wrappedPayload,
            'status' => 'pending',
            'attempts' => 0,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('webhook_events')->insert($eventData);
        $eventId = $this->db->insertID();

        return $this->deliver($eventId, $webhook);
    }
}

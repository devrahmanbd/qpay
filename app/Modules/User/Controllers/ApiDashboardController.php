<?php

namespace User\Controllers;

use App\Libraries\ApiKeyService;
use App\Libraries\WebhookService;
use App\Libraries\ApiLogger;

class ApiDashboardController extends UserController
{
    public $data = [];
    protected $keyService;
    protected $webhookService;
    protected $apiLogger;

    public function __construct()
    {
        parent::__construct();
        $this->keyService = new ApiKeyService();
        $this->webhookService = new WebhookService();
        $this->apiLogger = new ApiLogger();
    }

    public function keys()
    {
        $uid = session('uid');
        $brandId = (int) $this->request->getGet('brand_id');

        $brands = $this->db->table('brands')
            ->where('uid', $uid)
            ->where('deleted_at', null)
            ->get()
            ->getResult();

        if (!$brandId && !empty($brands)) {
            $brandId = $brands[0]->id;
        }

        $keys = [];
        if ($brandId) {
            $brand = $this->db->table('brands')->where('id', $brandId)->where('uid', $uid)->get()->getRow();
            if ($brand) {
                $keys = $this->keyService->listKeys($brandId, $uid);
            }
        }

        $data = [
            'brands' => $brands,
            'keys' => $keys,
            'selected_brand_id' => $brandId,
        ];

        $this->template->view('merchant/api/keys', $data)->render();
    }

    public function generateKeys()
    {
        _is_ajax();
        $uid = session('uid');
        $brandId = (int) post('brand_id');
        $environment = post('environment') === 'live' ? 'live' : 'test';
        $name = post('name') ?: 'Default';

        q_debug(['brand_id' => $brandId, 'environment' => $environment, 'name' => $name, 'uid' => $uid], 'API_KEY_GEN_START');

        $brand = $this->db->table('brands')
            ->where('id', $brandId)
            ->where('uid', $uid)
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$brand) {
            ms(['status' => 'error', 'message' => 'Brand not found']);
            return;
        }

        $result = $this->keyService->generateKeyPair($brandId, $uid, $environment, $name);

        ms([
            'status' => 'success',
            'message' => 'API keys generated successfully. Copy them now — the secret key will not be shown again.',
            'data' => $result,
        ]);
    }

    public function revokeKey()
    {
        _is_ajax();
        $uid = session('uid');
        $keyId = (int) post('key_id');

        $key = $this->keyService->getKeyById($keyId);
        if (!$key || $key->merchant_id != $uid) {
            ms(['status' => 'error', 'message' => 'Key not found']);
            return;
        }

        $this->keyService->revoke($keyId);
        ms(['status' => 'success', 'message' => 'API key revoked successfully']);
    }

    public function rotateKey()
    {
        _is_ajax();
        $uid = session('uid');
        $keyId = (int) post('key_id');

        $key = $this->keyService->getKeyById($keyId);
        if (!$key || $key->merchant_id != $uid) {
            ms(['status' => 'error', 'message' => 'Key not found']);
            return;
        }

        $newKey = $this->keyService->rotate($keyId);
        if (!$newKey) {
            ms(['status' => 'error', 'message' => 'Failed to rotate key']);
            return;
        }

        ms([
            'status' => 'success',
            'message' => 'Key rotated. Copy the new key — it will not be shown again.',
            'data' => ['new_key' => $newKey['key'], 'key_type' => $newKey['key_type']],
        ]);
    }

    public function webhooks()
    {
        $uid = session('uid');
        $brandId = (int) $this->request->getGet('brand_id');

        $brands = $this->db->table('brands')
            ->where('uid', $uid)
            ->where('deleted_at', null)
            ->get()
            ->getResult();

        if (!$brandId && !empty($brands)) {
            $brandId = $brands[0]->id;
        }

        $webhooks = [];
        if ($brandId) {
            $webhooks = $this->webhookService->listWebhooks($brandId, $uid);
        }

        $data = [
            'brands' => $brands,
            'webhooks' => $webhooks,
            'selected_brand_id' => $brandId,
            'event_types' => ['payment.created', 'payment.completed', 'payment.failed', 'refund.created'],
        ];

        $this->template->view('merchant/api/webhooks', $data)->render();
    }

    public function addWebhook()
    {
        _is_ajax();
        $uid = session('uid');
        $brandId = (int) post('brand_id');
        $url = post('url');
        $events = post('events') ?: ['*'];

        if (!filter_var($url, FILTER_VALIDATE_URL)) {
            ms(['status' => 'error', 'message' => 'Please enter a valid URL']);
            return;
        }

        $brand = $this->db->table('brands')
            ->where('id', $brandId)
            ->where('uid', $uid)
            ->get()
            ->getRow();

        if (!$brand) {
            ms(['status' => 'error', 'message' => 'Brand not found']);
            return;
        }

        try {
            $result = $this->webhookService->registerWebhook($brandId, $uid, $url, is_array($events) ? $events : [$events]);

            ms([
                'status' => 'success',
                'message' => 'Webhook registered. Copy your signing secret — it will not be shown again.',
                'data' => ['secret' => $result['secret']],
            ]);
        } catch (\InvalidArgumentException $e) {
            ms(['status' => 'error', 'message' => $e->getMessage()]);
        } catch (\Exception $e) {
            ms(['status' => 'error', 'message' => 'An unexpected error occurred while saving the webhook.']);
        }
    }

    public function deleteWebhook()
    {
        _is_ajax();
        $uid = session('uid');
        $webhookId = (int) post('webhook_id');

        $this->webhookService->deleteWebhook($webhookId, $uid);
        ms(['status' => 'success', 'message' => 'Webhook deleted']);
    }

    public function webhookEvents()
    {
        _is_ajax();
        $uid = session('uid');
        $webhookId = (int) $this->request->getGet('webhook_id');

        $webhook = $this->db->table('webhooks')
            ->where('id', $webhookId)
            ->where('merchant_id', $uid)
            ->get()
            ->getRow();

        if (!$webhook) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Not found']);
        }

        $events = $this->webhookService->getWebhookEvents($webhookId);

        return $this->response->setJSON(['status' => 'success', 'data' => $events]);
    }

    public function logs()
    {
        $uid = session('uid');
        $brandId = (int) $this->request->getGet('brand_id');

        $brands = $this->db->table('brands')
            ->where('uid', $uid)
            ->where('deleted_at', null)
            ->get()
            ->getResult();

        if (!$brandId && !empty($brands)) {
            $brandId = $brands[0]->id;
        }

        $logs = [];
        $stats = [];
        if ($brandId) {
            $logs = $this->apiLogger->getRecentLogs($brandId, $uid, 50);
            $stats = $this->apiLogger->getStats($brandId, $uid, '24h');
        }

        $data = [
            'brands' => $brands,
            'logs' => $logs,
            'stats' => $stats,
            'selected_brand_id' => $brandId,
        ];

        $this->template->view('merchant/api/logs', $data)->render();
    }

    public function clearLogs()
    {
        _is_ajax();
        $uid = session('uid');
        $brandId = (int) post('brand_id');

        $this->apiLogger->clearLogs($brandId, $uid);
        ms(['status' => 'success', 'message' => 'API logs cleared successfully']);
    }

    public function clearWebhookEvents()
    {
        _is_ajax();
        $uid = session('uid');
        $webhookId = (int) post('webhook_id');

        if ($this->webhookService->clearEvents($webhookId, $uid)) {
            ms(['status' => 'success', 'message' => 'Webhook events cleared successfully']);
        } else {
            ms(['status' => 'error', 'message' => 'Failed to clear webhook events']);
        }
    }

    public function pingWebhook()
    {
        _is_ajax();
        $uid = session('uid');
        $webhookId = (int) post('webhook_id');

        if ($this->webhookService->ping($webhookId, $uid)) {
            ms(['status' => 'success', 'message' => 'Test ping sent successfully!']);
        } else {
            ms(['status' => 'error', 'message' => 'Failed to send test ping. Please check your URL.']);
        }
    }

    public function sdks()
    {
        $data = [
            'api_base_url' => rtrim(base_url(), '/'),
        ];

        $this->template->view('merchant/api/sdks', $data)->render();
    }
}

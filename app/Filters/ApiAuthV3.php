<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use App\Libraries\ApiKeyService;

class ApiAuthV3 implements FilterInterface
{
    protected $rateLimits = [
        'live' => 100,
        'test' => 200,
    ];

    protected bool $allowLegacyKeys = false;

    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = $request->getHeaderLine('API-KEY');
        if (empty($apiKey)) {
            $apiKey = $request->getHeaderLine('Authorization');
            if (!empty($apiKey) && stripos($apiKey, 'Bearer ') === 0) {
                $apiKey = substr($apiKey, 7);
            }
        }
        if (empty($apiKey)) {
            $apiKey = $request->getVar('api_key');
        }

        if (empty($apiKey)) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'MISSING_API_KEY',
                    'message' => 'API key is required. Pass it via API-KEY header, Authorization: Bearer header, or api_key parameter.',
                ]);
        }

        $keyService = new ApiKeyService();
        $isNewFormat = (bool) $keyService->isSecretKey($apiKey) || $keyService->isPublishableKey($apiKey);

        // Debug log
        log_message('error', 'Incoming API Key Received (truncated): ' . substr($apiKey, 0, 15) . '...');
        
        if ($isNewFormat) {
            return $this->authenticateNewKey($request, $apiKey, $keyService);
        }

        if (!$this->allowLegacyKeys) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'INVALID_API_KEY',
                    'message' => 'Invalid API key format. Use keys generated from the API Dashboard (pk_live_*, qp_live_*, pk_test_*, qp_test_*).',
                ]);
        }

        return $this->authenticateLegacyKey($request, $apiKey);
    }

    protected function authenticateNewKey(RequestInterface $request, string $apiKey, ApiKeyService $keyService)
    {
        $keyRecord = $keyService->validate($apiKey);

        if (!$keyRecord) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'INVALID_API_KEY',
                    'message' => 'The provided API key is invalid, expired, or has been revoked.',
                ]);
        }

        $db = db_connect();

        $brand = $db->table('brands')
            ->where('id', $keyRecord->brand_id)
            ->where('status', 1)
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$brand) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'BRAND_INACTIVE',
                    'message' => 'The brand associated with this API key is inactive or deleted.',
                ]);
        }

        $user = $db->table('users')
            ->where('id', $keyRecord->merchant_id)
            ->where('status', 1)
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$user) {
            return service('response')
                ->setStatusCode(403)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'MERCHANT_INACTIVE',
                    'message' => 'The merchant account associated with this API key is inactive.',
                ]);
        }

        $rateLimitResult = $this->checkRateLimit($keyRecord);
        if ($rateLimitResult !== true) {
            return $rateLimitResult;
        }

        return;
    }

    protected function authenticateLegacyKey(RequestInterface $request, string $apiKey)
    {
        $db = db_connect();
        $brand = $db->table('brands')
            ->where('brand_key', $apiKey)
            ->where('status', 1)
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$brand) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'INVALID_API_KEY',
                    'message' => 'The provided API key is invalid or the brand is inactive.',
                ]);
        }

        $user = $db->table('users')
            ->where('id', $brand->uid)
            ->where('status', 1)
            ->where('deleted_at', null)
            ->get()
            ->getRow();

        if (!$user) {
            return service('response')
                ->setStatusCode(403)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'MERCHANT_INACTIVE',
                    'message' => 'The merchant account associated with this API key is inactive.',
                ]);
        }

        $rateLimitResult = $this->checkRateLimitByBrand($brand->id);
        if ($rateLimitResult !== true) {
            return $rateLimitResult;
        }

        $request->brand = $brand;
        $request->merchant = $user;
        $request->apiKey = null;
        $request->isTestMode = false;
        $request->keyType = 'secret';
    }

    protected function checkRateLimit(object $keyRecord)
    {
        $db = db_connect();
        $limit = $this->rateLimits[$keyRecord->environment] ?? 100;
        $windowStart = date('Y-m-d H:i:s', strtotime('-1 minute'));

        $count = $db->table('api_logs')
            ->where('api_key_id', $keyRecord->id)
            ->where('created_at >=', $windowStart)
            ->countAllResults();

        if ($count >= $limit) {
            return $this->rateLimitResponse($limit);
        }

        return true;
    }

    protected function checkRateLimitByBrand(int $brandId)
    {
        $db = db_connect();
        $limit = $this->rateLimits['live'];
        $windowStart = date('Y-m-d H:i:s', strtotime('-1 minute'));

        $count = $db->table('api_logs')
            ->where('brand_id', $brandId)
            ->where('created_at >=', $windowStart)
            ->countAllResults();

        if ($count >= $limit) {
            return $this->rateLimitResponse($limit);
        }

        return true;
    }

    protected function rateLimitResponse(int $limit)
    {
        return service('response')
            ->setStatusCode(429)
            ->setHeader('Retry-After', '60')
            ->setJSON([
                'status' => 'error',
                'code' => 'RATE_LIMIT_EXCEEDED',
                'message' => "Rate limit of {$limit} requests per minute exceeded. Please retry after 60 seconds.",
            ]);
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if (!isset($request->brand)) {
            return;
        }

        $logger = new \App\Libraries\ApiLogger();
        $logger->log([
            'api_key_id' => isset($request->apiKey) ? ($request->apiKey->id ?? null) : null,
            'brand_id' => $request->brand->id ?? null,
            'merchant_id' => $request->merchant->id ?? null,
            'method' => $request->getMethod(),
            'endpoint' => $request->getPath(),
            'status_code' => $response->getStatusCode(),
            'ip_address' => $request->getIPAddress(),
            'environment' => ($request->isTestMode ?? false) ? 'test' : 'live',
        ]);
    }
}

<?php

namespace App\Libraries;

class ApiKeyService
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    public function generate(int $brandId, int $merchantId, string $keyType, string $environment, string $name = 'Default'): array
    {
        $prefix = $this->buildPrefix($keyType, $environment);
        $randomPart = bin2hex(random_bytes(24));
        $fullKey = $prefix . $randomPart;
        $hash = hash('sha256', $fullKey);
        $last4 = substr($randomPart, -4);

        $data = [
            'brand_id' => $brandId,
            'merchant_id' => $merchantId,
            'name' => $name,
            'key_type' => $keyType,
            'key_prefix' => $prefix,
            'key_hash' => $hash,
            'key_last4' => $last4,
            'environment' => $environment,
            'created_at' => date('Y-m-d H:i:s'),
        ];

        $this->db->table('api_keys')->insert($data);

        return [
            'id' => $this->db->insertID(),
            'key' => $fullKey,
            'key_type' => $keyType,
            'environment' => $environment,
            'prefix' => $prefix,
            'last4' => $last4,
            'name' => $name,
        ];
    }

    public function generateKeyPair(int $brandId, int $merchantId, string $environment, string $name = 'Default'): array
    {
        $publishable = $this->generate($brandId, $merchantId, 'publishable', $environment, $name);
        $secret = $this->generate($brandId, $merchantId, 'secret', $environment, $name);

        return [
            'publishable_key' => $publishable['key'],
            'secret_key' => $secret['key'],
            'publishable_id' => $publishable['id'],
            'secret_id' => $secret['id'],
            'environment' => $environment,
        ];
    }

    public function validate(string $apiKey): ?object
    {
        $apiKey = trim($apiKey);
        $hash = hash('sha256', $apiKey);
        $prefix = $this->extractPrefix($apiKey);

        if (!$prefix) {
            return null;
        }

        $key = $this->db->table('api_keys')
            ->where('key_hash', $hash)
            ->where('key_prefix', $prefix)
            ->where('revoked_at', null)
            ->get()
            ->getRow();

        if (!$key) {
            return null;
        }

        if ($key->expires_at && strtotime($key->expires_at) < time()) {
            return null;
        }

        $this->db->table('api_keys')
            ->where('id', $key->id)
            ->update(['last_used_at' => date('Y-m-d H:i:s')]);

        return $key;
    }

    public function revoke(int $keyId): bool
    {
        return $this->db->table('api_keys')
            ->where('id', $keyId)
            ->where('revoked_at', null)
            ->update(['revoked_at' => date('Y-m-d H:i:s')]);
    }

    public function rotate(int $keyId): ?array
    {
        $existing = $this->db->table('api_keys')
            ->where('id', $keyId)
            ->where('revoked_at', null)
            ->get()
            ->getRow();

        if (!$existing) {
            return null;
        }

        $this->revoke($keyId);

        return $this->generate(
            $existing->brand_id,
            $existing->merchant_id,
            $existing->key_type,
            $existing->environment,
            $existing->name
        );
    }

    public function listKeys(int $brandId, int $merchantId, bool $includeRevoked = false): array
    {
        $builder = $this->db->table('api_keys')
            ->where('brand_id', $brandId)
            ->where('merchant_id', $merchantId);

        if (!$includeRevoked) {
            $builder->where('revoked_at', null);
        }

        return $builder->orderBy('created_at', 'DESC')
            ->get()
            ->getResult();
    }

    public function getKeyById(int $keyId): ?object
    {
        return $this->db->table('api_keys')
            ->where('id', $keyId)
            ->get()
            ->getRow();
    }

    protected function buildPrefix(string $keyType, string $environment): string
    {
        $typePrefix = $keyType === 'publishable' ? 'pk' : 'qp';
        $envPrefix = $environment === 'live' ? 'live' : 'test';
        return $typePrefix . '_' . $envPrefix . '_';
    }

    protected function extractPrefix(string $apiKey): ?string
    {
        $apiKey = trim($apiKey);
        if (preg_match('/^((?:pk|qp)_(?:live|test)_)/', $apiKey, $matches)) {
            return $matches[1];
        }
        return null;
    }

    public function isSecretKey(string $apiKey): bool
    {
        return strpos($apiKey, 'qp_') === 0;
    }

    public function isPublishableKey(string $apiKey): bool
    {
        return strpos($apiKey, 'pk_') === 0;
    }

    public function isTestKey(string $apiKey): bool
    {
        return strpos($apiKey, '_test_') !== false;
    }

    public function isLiveKey(string $apiKey): bool
    {
        return strpos($apiKey, '_live_') !== false;
    }
}

<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $apiKey = $request->getHeaderLine('API-KEY');
        if (empty($apiKey)) {
            $apiKey = $request->getVar('api_key');
        }

        if (empty($apiKey)) {
            return service('response')
                ->setStatusCode(401)
                ->setJSON([
                    'status' => 'error',
                    'code' => 'MISSING_API_KEY',
                    'message' => 'API-KEY header is required.',
                ]);
        }

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

        $request->brand = $brand;
        $request->merchant = $user;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}

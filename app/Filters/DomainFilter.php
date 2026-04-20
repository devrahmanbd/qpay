<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DomainFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $currentHost = $request->getServer('HTTP_HOST');
        $paymentUrl = getenv('PAYMENT_URL');
        $baseUrl = getenv('app.baseURL');

        if (empty($paymentUrl) || empty($baseUrl)) {
            return;
        }

        $paymentHost = parse_url($paymentUrl, PHP_URL_HOST);
        $mainHost = parse_url($baseUrl, PHP_URL_HOST);

        // Remove ports from currentHost for comparison if needed, 
        // or just compare hostnames. CodeIgniter's getUri()->getHost() is safer.
        $currentHost = $request->getUri()->getHost();

        if ($currentHost === $paymentHost) {
            $path = $request->getUri()->getPath();
            if (!str_starts_with($path, 'api/v1/payment/checkout')) {
                // Redirect to main domain
                return redirect()->to(rtrim($baseUrl, '/') . '/' . ltrim($path, '/'));
            }
        }

        // If on main domain but accessing checkout routes
        if ($currentHost === $mainHost) {
            $path = $request->getUri()->getPath();
            if (str_starts_with($path, 'api/v1/payment/checkout')) {
                // Redirect to checkout domain
                return redirect()->to(rtrim($paymentUrl, '/') . '/' . ltrim($path, '/'));
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class DomainFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Use raw server host for reliable detection across subdomains
        $currentHost = $request->getServer('HTTP_HOST');
        $paymentUrl = getenv('PAYMENT_URL');
        $baseUrl = getenv('app.baseURL');

        if (empty($paymentUrl) || empty($baseUrl)) {
            return;
        }

        // Normalize hosts by removing 'www.' for accurate comparisons
        $paymentHostParts = parse_url($paymentUrl, PHP_URL_HOST);
        $mainHostParts = parse_url($baseUrl, PHP_URL_HOST);

        if (!$paymentHostParts || !$mainHostParts) {
            return;
        }

        $paymentHost = str_replace('www.', '', $paymentHostParts);
        $mainHost = str_replace('www.', '', $mainHostParts);
        $normalizedCurrentHost = str_replace('www.', '', $currentHost);

        $uri = $request->getUri();
        $path = $uri->getPath();
        $cleanPath = ltrim($path, '/');
        $query = $uri->getQuery();
        $queryString = $query ? '?' . $query : '';

        // Identify if the request path belongs on the Checkout subdomain
        $isCheckoutPath = str_starts_with($cleanPath, 'api/v1/payment/checkout') || 
                          str_starts_with($cleanPath, 'api/execute') || 
                          str_starts_with($cleanPath, 'api/save_payment');

        // Logic: On checkout domain but accessing main site content -> Redirect to main
        if ($normalizedCurrentHost === $paymentHost) {
            // Allow checkout paths, assets, and themes to stay on the checkout subdomain
            $isPublicAsset = str_starts_with($cleanPath, 'assets/') || str_starts_with($cleanPath, 'themes/');
            
            if (!$isCheckoutPath && !$isPublicAsset) {
                return redirect()->to(rtrim($baseUrl, '/') . '/' . $cleanPath . $queryString);
            }
        }

        // Logic: On main domain but accessing checkout content -> Redirect to Checkout Subdomain
        if ($normalizedCurrentHost === $mainHost) {
            if ($isCheckoutPath) {
                return redirect()->to(rtrim($paymentUrl, '/') . '/' . $cleanPath . $queryString);
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

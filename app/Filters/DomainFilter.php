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
        $paymentHost = str_replace('www.', '', parse_url($paymentUrl, PHP_URL_HOST));
        $mainHost = str_replace('www.', '', parse_url($baseUrl, PHP_URL_HOST));
        $normalizedCurrentHost = str_replace('www.', '', $currentHost);

        $path = $request->getUri()->getPath();
        $cleanPath = ltrim($path, '/');

        // Logic: On checkout domain but accessing main site content -> Redirect to main
        if ($normalizedCurrentHost === $paymentHost) {
            if (!str_starts_with($cleanPath, 'api/v1/payment/checkout') && !str_starts_with($cleanPath, 'assets/') && !str_starts_with($cleanPath, 'themes/')) {
                return redirect()->to(rtrim($baseUrl, '/') . '/' . $cleanPath);
            }
        }

        // Logic: On main domain but accessing checkout content -> Redirect to checkout
        if ($normalizedCurrentHost === $mainHost) {
            if (str_starts_with($cleanPath, 'api/v1/payment/checkout')) {
                $target = rtrim($paymentUrl, '/') . '/' . $cleanPath;
                
                // Prevent self-redirection loops
                if ($target !== (string)$request->getUri()) {
                    return redirect()->to($target);
                }
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}

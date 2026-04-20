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
        $forwardedHost = $request->getServer('HTTP_X_FORWARDED_HOST');
        $paymentUrl = getenv('PAYMENT_URL');
        $baseUrl = getenv('app.baseURL');

        if (empty($paymentUrl) || empty($baseUrl)) {
            return;
        }

        log_message('critical', "[DomainFilter] Host: {$currentHost} | Forwarded: {$forwardedHost} | URL: " . (string)$request->getUri());

        // Normalize hosts by removing 'www.' for comparison
        $paymentHost = str_replace('www.', '', parse_url($paymentUrl, PHP_URL_HOST));
        $mainHost = str_replace('www.', '', parse_url($baseUrl, PHP_URL_HOST));
        $normalizedCurrentHost = str_replace('www.', '', $currentHost);

        $path = $request->getUri()->getPath();
        $cleanPath = ltrim($path, '/');

        // If on checkout host but accessing main site content
        if ($normalizedCurrentHost === $paymentHost) {
            if (!str_starts_with($cleanPath, 'api/v1/payment/checkout')) {
                // Redirect back to main domain
                $target = rtrim($baseUrl, '/') . '/' . $cleanPath;
                return redirect()->to($target);
            }
        }

        // If on main host but accessing checkout content
        if ($normalizedCurrentHost === $mainHost) {
            if (str_starts_with($cleanPath, 'api/v1/payment/checkout')) {
                // Redirect to checkout domain
                $target = rtrim($paymentUrl, '/') . '/' . $cleanPath;
                
                // Safety check: Don't redirect to the same URL
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

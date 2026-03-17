<?php

if (!defined('WHMCS')) {
    die('This file cannot be accessed directly');
}

add_hook('AdminAreaHeaderOutput', 1, function ($vars) {
    if ($vars['filename'] !== 'configgateways') {
        return '';
    }

    return <<<HTML
<style>
.qpay-badge {
    display: inline-block;
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    color: #fff;
    font-size: 11px;
    font-weight: 600;
    padding: 2px 8px;
    border-radius: 4px;
    margin-left: 6px;
    vertical-align: middle;
}
</style>
HTML;
});

add_hook('InvoicePaid', 1, function ($vars) {
    $invoiceId = $vars['invoiceid'];
    logActivity("QPay: Invoice #{$invoiceId} has been paid.");
});

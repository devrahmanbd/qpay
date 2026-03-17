<?php
define("PAYMENT_URL", rtrim(base_url(), '/') . '/');
?>
<style>
  .docs-table { width:100%; border-collapse:collapse; }
  .docs-table th, .docs-table td { border:1px solid #e5e7eb; padding:12px 16px; text-align:left; font-size:14px; }
  .docs-table th { background-color:#f9fafb; font-weight:600; white-space:nowrap; }
  .docs-table tr:nth-child(even) { background-color:#f9fafb; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="flex flex-col lg:flex-row gap-8">

    <nav class="lg:w-64 flex-shrink-0">
      <div class="lg:sticky lg:top-24 bg-white rounded-xl border border-gray-200 p-4 space-y-1">
        <a href="#section-1" class="block px-3 py-2 text-sm font-semibold text-primary-600 bg-primary-50 rounded-lg">Introduction</a>
        <a href="#section-2" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">APIs</a>
        <a href="#item-2-1" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">API Operation</a>
        <a href="#item-2-2" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">Parameter Details</a>
        <a href="#section-3" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Integration</a>
        <a href="#item-3-1" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">Sample Request</a>
        <a href="#item-3-2" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">Verify Request</a>
        <a href="#item-3-4" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">WordPress Plugin</a>
        <a href="#item-3-5" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">WHMCS Module</a>
        <a href="#item-3-6" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">SMM Panel Module</a>
        <a href="#item-3-7" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">Mobile App</a>
      </div>
    </nav>

    <div class="flex-1 min-w-0 space-y-12">

      <article id="section-1">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Welcome To <?= site_config("site_name") ?> Docs</h1>
        <p class="text-xs text-gray-500 mb-4">Last updated: 2024-06-06</p>
        <p class="text-gray-600"><?= site_config("site_name") ?> is a simple and Secure payment automation tool which is designed to use personal account as a payment gateway so that you can accept payments from your customer through your website where you will find a complete overview on how <?= site_config("site_name") ?> works and how you can integrate <?= site_config("site_name") ?> API in your website</p>
      </article>

      <article id="section-2">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">API Introduction</h1>
        <p class="text-gray-600 mb-6"><?= site_config("site_name") ?> Payment Gateway enables Merchants to receive money from their customers by temporarily redirecting them to www.<?= site_config("site_name") ?>.com. The gateway is connecting multiple payment terminal including card system, mobile financial system, local and International wallet. After the payment is complete, the customer is returned to the merchant's site and seconds later the Merchant receives notification about the payment along with the details of the transaction. This document is intended to be utilized by technical personnel supporting the online Merchant's website. Working knowledge of HTML forms or cURL is required.</p>

        <div id="item-2-1" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">API Operation</h2>
          <p class="text-gray-600 mb-4">REST APIs are supported in two environments. Use the Sandbox environment for testing purposes, then move to the live environment for production processing.</p>

          <div class="space-y-3">
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-semibold text-gray-900 mb-1">Live API End Point (Create Payment URL):</h3>
              <code class="text-sm text-primary-600 break-all"><?= PAYMENT_URL ?>api/v1/payment/create</code>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-semibold text-gray-900 mb-1">Payment Verify API:</h3>
              <code class="text-sm text-primary-600 break-all"><?= PAYMENT_URL ?>api/v1/payment/verify/{payment_id}</code>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-semibold text-gray-900 mb-1">Payment Status API:</h3>
              <code class="text-sm text-primary-600 break-all"><?= PAYMENT_URL ?>api/v1/payment/status/{payment_id}</code>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
              <h3 class="text-sm font-semibold text-gray-900 mb-1">Payment Methods API:</h3>
              <code class="text-sm text-primary-600 break-all"><?= PAYMENT_URL ?>api/v1/payment/methods</code>
            </div>
          </div>
        </div>

        <div id="item-2-2">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">Parameter Details</h2>
          <p class="text-sm text-blue-600 mb-4">Variables Need to POST to Initialize Payment Process in gateway URL</p>

          <div class="overflow-x-auto mb-6">
            <table class="docs-table">
              <thead>
                <tr>
                  <th>Field Name</th>
                  <th>Description</th>
                  <th>Required</th>
                  <th>Example Values</th>
                </tr>
              </thead>
              <tbody>
                <tr><th>amount</th><td>The total amount payable (must be greater than zero).</td><td>Yes</td><td>500 or 10.50</td></tr>
                <tr><th>currency</th><td>ISO currency code. Defaults to BDT if not provided.</td><td>No</td><td>BDT</td></tr>
                <tr><th>payment_method</th><td>Preferred payment method (e.g., bkash, nagad, rocket). If omitted, all available methods are shown at checkout.</td><td>No</td><td>bkash</td></tr>
                <tr><th>customer_name</th><td>Full name of the customer.</td><td>No</td><td>John Doe</td></tr>
                <tr><th>customer_email</th><td>Email address of the customer.</td><td>No</td><td>john@gmail.com</td></tr>
                <tr><th>callback_url</th><td>Server-to-server webhook URL for payment status notifications.</td><td>No</td><td>https://yourdomain.com/webhook</td></tr>
                <tr><th>success_url</th><td>URL to redirect customer after successful payment.</td><td>No</td><td>https://yourdomain.com/success</td></tr>
                <tr><th>cancel_url</th><td>URL to redirect customer if they cancel the payment.</td><td>No</td><td>https://yourdomain.com/cancel</td></tr>
                <tr><th>metadata</th><td>Any JSON-formatted data to attach to the payment (e.g., order IDs, notes).</td><td>No</td><td>{"order_id": "12345"}</td></tr>
              </tbody>
            </table>
          </div>

          <p class="text-sm text-amber-600 font-medium mb-2">Payment Verify Endpoint</p>
          <p class="text-gray-600 mb-4">To verify a payment, send a POST or GET request to <code class="text-primary-600 bg-primary-50 px-1 rounded">api/v1/payment/verify/{payment_id}</code> with your API-KEY header.</p>

          <p class="text-sm text-amber-600 font-medium mb-2">Payment Status Endpoint</p>
          <p class="text-gray-600 mb-4">To check payment status without triggering verification, send a GET request to <code class="text-primary-600 bg-primary-50 px-1 rounded">api/v1/payment/status/{payment_id}</code> with your API-KEY header.</p>

          <p class="text-sm text-amber-600 font-medium mb-2">Available Payment Methods</p>
          <p class="text-gray-600 mb-6">To list available payment methods for your brand, send a GET request to <code class="text-primary-600 bg-primary-50 px-1 rounded">api/v1/payment/methods</code> with your API-KEY header.</p>

          <h2 class="text-xl font-semibold text-gray-900 mb-3">Headers Details</h2>
          <div class="overflow-x-auto">
            <table class="docs-table">
              <thead>
                <tr>
                  <th>Header Name</th>
                  <th>Value</th>
                </tr>
              </thead>
              <tbody>
                <tr><th>Content-Type</th><td>application/json</td></tr>
                <tr><th>API-KEY</th><td>Your unified API key (from Brand settings). This single key authenticates all requests.</td></tr>
                <tr><th>Idempotency-Key</th><td>(Optional) A unique key to prevent duplicate payment creation. Recommended for production use.</td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </article>

      <article id="section-3">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Integration</h1>
        <p class="text-gray-600 mb-6">You can integrate our payment gateway into your PHP Laravel WordPress WooCommerce sites.</p>

        <div id="item-3-1" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">Sample Request</h2>
          <?= view('Home\Views\developers\integration'); ?>
        </div>

        <div id="item-3-2" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">Verify Request</h2>
          <?= view('Home\Views\developers\integration2'); ?>
        </div>

        <div id="item-3-4" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">WordPress Module</h2>
          <p class="text-gray-600 mb-4">Integrate our payment gateway into your WordPress website effortlessly. Whether you run an e-commerce store, a membership site, or a donation platform, our WordPress module makes it easy to accept payments online.</p>
          <a href="/public/assets/downloads/WP.zip" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download Now
          </a>
        </div>

        <div id="item-3-5" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">WHMCS Module</h2>
          <p class="text-gray-600 mb-4">Integrate our payment gateway seamlessly into your WHMCS setup. With our module, you can easily accept payments from your customers, manage invoices, and track transactions effortlessly.</p>
          <a href="/public/assets/downloads/WHMCS.zip" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download Now
          </a>
        </div>

        <div id="item-3-6" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">SMM Panel Module</h2>
          <p class="text-gray-600 mb-4">Enhance your SMM panel with our payment gateway integration module. Streamline the payment process for your social media marketing services and provide a seamless experience for your clients.</p>
          <a href="/public/assets/downloads/SMM.zip" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download Now
          </a>
        </div>

        <div id="item-3-7" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">Mobile App</h2>
          <p class="text-gray-600 mb-4">See Setup Video: <a href="#" class="text-primary-600 hover:text-primary-700">Video here</a></p>
          <a href="/public/assets/downloads/jonotapay.apk" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download Mobile App Now
          </a>
        </div>
      </article>

    </div>
  </div>
</div>

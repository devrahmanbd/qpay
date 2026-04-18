<?php
define("PAYMENT_URL", rtrim(base_url(), '/') . '/');
$siteName = site_config("site_name", "QPay");
?>
<style>
  .docs-table { width:100%; border-collapse:collapse; }
  .docs-table th, .docs-table td { border:1px solid #e5e7eb; padding:12px 16px; text-align:left; font-size:14px; }
  .docs-table th { background-color:#f9fafb; font-weight:600; white-space:nowrap; }
  .docs-table tr:nth-child(even) { background-color:#f9fafb; }
  .method-badge { display:inline-block; padding:2px 8px; border-radius:4px; font-size:12px; font-weight:700; font-family:monospace; }
  .method-post { background:#dcfce7; color:#166534; }
  .method-get { background:#dbeafe; color:#1e40af; }
  .code-container { position: relative; }
  .copy-btn { position:absolute; top:8px; right:8px; opacity:0; transition:opacity .2s; }
  .code-container:hover .copy-btn { opacity:1; }
</style>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
  <div class="flex flex-col lg:flex-row gap-8">

    <nav class="lg:w-64 flex-shrink-0">
      <div class="lg:sticky lg:top-24 bg-white rounded-xl border border-gray-200 p-4 space-y-1 max-h-[85vh] overflow-y-auto">
        <p class="px-3 py-1 text-xs font-bold text-gray-400 uppercase tracking-wider">Getting Started</p>
        <a href="#section-intro" class="block px-3 py-2 text-sm font-semibold text-primary-600 bg-primary-50 rounded-lg">Introduction</a>
        <a href="#section-auth" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Authentication</a>
        <a href="#section-keys" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">API Key Types</a>
        <a href="#section-test-mode" class="block pl-8 py-1.5 text-sm text-gray-500 hover:text-gray-700">Test Mode</a>
        <p class="px-3 py-1 pt-3 text-xs font-bold text-gray-400 uppercase tracking-wider">API Reference</p>
        <a href="#ep-create" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Create Payment</a>
        <a href="#ep-verify" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Verify Payment</a>
        <a href="#ep-status" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Payment Status</a>
        <a href="#ep-list" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">List Payments</a>
        <a href="#ep-refund" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Create Refund</a>
        <a href="#ep-balance" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Get Balance</a>
        <a href="#ep-methods" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Payment Methods</a>
        <p class="px-3 py-1 pt-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Webhooks</p>
        <a href="#section-webhooks" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Webhook Events</a>
        <a href="#section-webhook-verify" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Signature Verification</a>
        <a href="#ep-checkout" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Checkout Page</a>
        <p class="px-3 py-1 pt-3 text-xs font-bold text-gray-400 uppercase tracking-wider">SDKs & Plugins</p>
        <a href="#section-php-sdk" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">PHP SDK</a>
        <a href="#section-node-sdk" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Node.js SDK</a>
        <a href="#section-woocommerce" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">WooCommerce Plugin</a>
        <a href="#section-wordpress" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">WordPress Plugin</a>
        <p class="px-3 py-1 pt-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Testing</p>
        <a href="#section-quickstart" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Quick Start Guide</a>
        <a href="#section-testing-guide" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Testing Guide</a>
        <a href="#section-sandbox" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Sandbox Reference</a>
        <a href="#section-going-live" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Going Live Checklist</a>
        <p class="px-3 py-1 pt-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Reference</p>
        <a href="#section-errors" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Error Codes</a>
        <a href="#section-rate-limits" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Rate Limits</a>
        <a href="#section-best-practices" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Best Practices</a>
        <a href="#section-changelog" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Changelog</a>
      </div>
    </nav>

    <div class="flex-1 min-w-0 space-y-12">

      <article id="section-intro">
        <h1 class="text-2xl font-bold text-gray-900 mb-2"><?= $siteName ?> API Documentation</h1>
        <p class="text-xs text-gray-500 mb-4">API Version: v1 &mdash; Last updated: <?= date('Y-m-d') ?></p>
        <p class="text-gray-600 mb-4"><?= $siteName ?> provides a Stripe-style REST API for accepting payments in Bangladesh and South Asia. Use the API to create payments, verify transactions, manage refunds, and monitor your balance programmatically.</p>
        <div class="bg-gray-50 rounded-lg p-4 mb-4">
          <p class="text-sm font-semibold text-gray-900 mb-1">Base URL</p>
          <code class="text-sm text-primary-600"><?= PAYMENT_URL ?>api/v1/</code>
        </div>
      </article>

      <article id="section-auth">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Authentication</h1>
        <p class="text-gray-600 mb-4">All API requests require authentication. You can provide your API key in either the <code class="bg-gray-100 px-1 rounded text-sm">API-KEY</code> header or as a <code class="bg-gray-100 px-1 rounded text-sm">Bearer</code> token in the <code class="bg-gray-100 px-1 rounded text-sm">Authorization</code> header.</p>

        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-6">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl -X POST <?= PAYMENT_URL ?>api/v1/payment/create \
  -H "API-KEY: qp_test_your_secret_key_here" \
  -H "Content-Type: application/json" \
  -d '{"amount": 500}'</code></pre>
        </div>

        <div id="section-keys" class="mb-8">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">API Key Types</h2>
          <div class="overflow-x-auto">
            <table class="docs-table">
              <thead><tr><th>Key Prefix</th><th>Type</th><th>Environment</th><th>Usage</th></tr></thead>
              <tbody>
                <tr><td><code>pk_live_</code></td><td>Publishable</td><td>Live</td><td>Client-side only (payment methods, checkout)</td></tr>
                <tr><td><code>qp_live_</code></td><td>Secret</td><td>Live</td><td>Server-side only (create, verify, refund)</td></tr>
                <tr><td><code>pk_test_</code></td><td>Publishable</td><td>Test</td><td>Client-side testing</td></tr>
                <tr><td><code>qp_test_</code></td><td>Secret</td><td>Test</td><td>Server-side testing (mock payments)</td></tr>
              </tbody>
            </table>
          </div>
          <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
            <p class="text-sm text-amber-800"><strong>Important:</strong> Secret keys (<code>qp_</code>) must never be exposed in client-side code, public repositories, or browser JavaScript. Only use publishable keys (<code>pk_</code>) on the client side.</p>
          </div>
        </div>

        <div id="section-test-mode">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">Test Mode</h2>
          <p class="text-gray-600 mb-4">Use test keys (<code>qp_test_</code> / <code>pk_test_</code>) for safe testing. Test mode simulates payment outcomes based on amount:</p>
          <div class="overflow-x-auto">
            <table class="docs-table">
              <thead><tr><th>Amount</th><th>Result</th><th>Description</th></tr></thead>
              <tbody>
                <tr><td><code>2.00</code></td><td class="text-red-600">Declined</td><td>Simulates a card/wallet decline</td></tr>
                <tr><td><code>3.00</code></td><td class="text-red-600">Insufficient Funds</td><td>Simulates insufficient balance</td></tr>
                <tr><td>Any other</td><td class="text-green-600">Success</td><td>Payment is created with status <code>processing</code></td></tr>
              </tbody>
            </table>
          </div>
        </div>
      </article>

      <article id="ep-create">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-post">POST</span>
          <h2 class="text-xl font-bold text-gray-900">/payment/create</h2>
        </div>
        <p class="text-gray-600 mb-4">Create a new payment. Returns a payment object with a <code>checkout_url</code> to redirect the customer.</p>
        <p class="text-sm text-gray-500 mb-4"><strong>Required key:</strong> Secret key (<code>qp_</code>)</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Request Parameters</h3>
        <div class="overflow-x-auto mb-6">
          <table class="docs-table">
            <thead><tr><th>Parameter</th><th>Type</th><th>Required</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td><code>amount</code></td><td>number</td><td>Yes</td><td>Payment amount (must be > 0)</td></tr>
              <tr><td><code>currency</code></td><td>string</td><td>No</td><td>ISO currency code (default: BDT)</td></tr>
              <tr><td><code>payment_method</code></td><td>string</td><td>No</td><td>Preferred method: <code>bkash</code>, <code>nagad</code>, <code>rocket</code>, etc.</td></tr>
              <tr><td><code>customer_email</code></td><td>string</td><td>No</td><td>Customer email address</td></tr>
              <tr><td><code>customer_name</code></td><td>string</td><td>No</td><td>Customer full name</td></tr>
              <tr><td><code>callback_url</code></td><td>string</td><td>No</td><td>Webhook URL for payment notifications</td></tr>
              <tr><td><code>success_url</code></td><td>string</td><td>No</td><td>Redirect URL after successful payment</td></tr>
              <tr><td><code>cancel_url</code></td><td>string</td><td>No</td><td>Redirect URL on cancellation</td></tr>
              <tr><td><code>metadata</code></td><td>object</td><td>No</td><td>Custom key-value data (e.g. order ID)</td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Headers</h3>
        <div class="overflow-x-auto mb-6">
          <table class="docs-table">
            <thead><tr><th>Header</th><th>Required</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td><code>API-KEY</code> / <code>Authorization</code></td><td>Yes</td><td>Your secret API key (qp_...) or Bearer token</td></tr>
              <tr><td><code>Content-Type</code></td><td>Yes</td><td><code>application/json</code></td></tr>
              <tr><td><code>Idempotency-Key</code></td><td>No</td><td>Unique key to prevent duplicate payments</td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Example Request</h3>
        <?= view('Home\Views\developers\integration'); ?>

        <h3 class="text-lg font-semibold text-gray-900 mt-6 mb-2">Response (201 Created)</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
<pre class="text-sm leading-relaxed"><code class="language-json">{
  "id": "pay_a1b2c3d4e5f6a1b2c3d4e5f6",
  "object": "payment",
  "amount": 500,
  "currency": "bdt",
  "status": "processing",
  "payment_method": null,
  "transaction_id": "txn_abc123",
  "customer_email": "john@gmail.com",
  "customer_name": "John Doe",
  "metadata": {"order_id": "12345"},
  "test_mode": false,
  "created": 1717675200,
  "created_at": "2024-06-06 12:00:00",
  "updated_at": "2024-06-06 12:00:00",
  "fees": 10,
  "net_amount": 490,
  "checkout_url": "<?= PAYMENT_URL ?>api/v1/payment/checkout/pay_a1b2c3d4e5f6a1b2c3d4e5f6",
  "redirect_url": null
}</code></pre>
        </div>
      </article>

      <article id="ep-verify">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-get">GET</span>
          <h2 class="text-xl font-bold text-gray-900">/payment/verify/{payment_id}</h2>
        </div>
        <p class="text-gray-600 mb-4">Verify a payment and trigger completion if the provider confirms it. Returns the payment object with a <code>verified</code> field.</p>
        <p class="text-sm text-gray-500 mb-4"><strong>Required key:</strong> Secret key (<code>qp_</code>) only</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Example Request</h3>
        <?= view('Home\Views\developers\integration2'); ?>
      </article>

      <article id="ep-status">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-get">GET</span>
          <h2 class="text-xl font-bold text-gray-900">/payment/status/{payment_id}</h2>
        </div>
        <p class="text-gray-600 mb-4">Get the current status of a payment without triggering verification. Works with both publishable and secret keys.</p>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl <?= PAYMENT_URL ?>api/v1/payment/status/pay_PAYMENT_ID \
  -H "Authorization: Bearer qp_test_your_key"</code></pre>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Payment Statuses</h3>
        <div class="overflow-x-auto mb-4">
          <table class="docs-table">
            <thead><tr><th>Status</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td><code>pending</code></td><td>Payment created, awaiting provider</td></tr>
              <tr><td><code>processing</code></td><td>Payment initiated with provider</td></tr>
              <tr><td><code>completed</code></td><td>Payment verified and completed</td></tr>
              <tr><td><code>failed</code></td><td>Payment failed or declined</td></tr>
              <tr><td><code>refunded</code></td><td>Payment has been refunded</td></tr>
            </tbody>
          </table>
        </div>
      </article>

      <article id="ep-list">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-get">GET</span>
          <h2 class="text-xl font-bold text-gray-900">/payments</h2>
        </div>
        <p class="text-gray-600 mb-4">List all payments for your brand with pagination support.</p>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Query Parameters</h3>
        <div class="overflow-x-auto mb-4">
          <table class="docs-table">
            <thead><tr><th>Parameter</th><th>Type</th><th>Default</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td><code>limit</code></td><td>integer</td><td>10</td><td>Number of results (max 100)</td></tr>
              <tr><td><code>offset</code></td><td>integer</td><td>0</td><td>Pagination offset</td></tr>
              <tr><td><code>status</code></td><td>string</td><td>&mdash;</td><td>Filter: pending, processing, completed, failed, refunded</td></tr>
            </tbody>
          </table>
        </div>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl "<?= PAYMENT_URL ?>api/v1/payments?limit=10&status=completed" \
  -H "API-KEY: qp_test_your_key"</code></pre>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Response</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
<pre class="text-sm leading-relaxed"><code class="language-json">{
  "object": "list",
  "data": [
    {"id": "pay_...", "object": "payment", "amount": 500, "status": "completed", ...}
  ],
  "has_more": false,
  "total_count": 1,
  "url": "/api/v1/payments"
}</code></pre>
        </div>
      </article>

      <article id="ep-refund">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-post">POST</span>
          <h2 class="text-xl font-bold text-gray-900">/refunds</h2>
        </div>
        <p class="text-gray-600 mb-4">Create a refund for a completed payment. Only completed payments can be refunded.</p>
        <p class="text-sm text-gray-500 mb-4"><strong>Required key:</strong> Secret key (<code>qp_</code>) only</p>
        <div class="overflow-x-auto mb-4">
          <table class="docs-table">
            <thead><tr><th>Parameter</th><th>Type</th><th>Required</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td><code>payment_id</code></td><td>string</td><td>Yes</td><td>ID of the payment to refund</td></tr>
              <tr><td><code>reason</code></td><td>string</td><td>No</td><td>Reason for the refund</td></tr>
            </tbody>
          </table>
        </div>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl -X POST <?= PAYMENT_URL ?>api/v1/refunds \
  -H "API-KEY: qp_live_your_key" \
  -H "Content-Type: application/json" \
  -d '{"payment_id": "pay_abc123", "reason": "Customer requested"}'</code></pre>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Response</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
<pre class="text-sm leading-relaxed"><code class="language-json">{
  "id": "ref_a1b2c3d4e5f6a1b2c3d4e5f6",
  "object": "refund",
  "amount": 500,
  "currency": "bdt",
  "payment": "pay_abc123",
  "reason": "Customer requested",
  "status": "succeeded",
  "test_mode": false,
  "created": 1717675200,
  "created_at": "2024-06-06 12:00:00"
}</code></pre>
        </div>
      </article>

      <article id="ep-balance">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-get">GET</span>
          <h2 class="text-xl font-bold text-gray-900">/balance</h2>
        </div>
        <p class="text-gray-600 mb-4">Get your current balance summary.</p>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl <?= PAYMENT_URL ?>api/v1/balance \
  -H "API-KEY: qp_test_your_key"</code></pre>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Response</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
<pre class="text-sm leading-relaxed"><code class="language-json">{
  "object": "balance",
  "available": 5000,
  "pending": 1200,
  "refunded": 300,
  "currency": "BDT",
  "test_mode": false
}</code></pre>
        </div>
      </article>

      <article id="ep-methods">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-get">GET</span>
          <h2 class="text-xl font-bold text-gray-900">/payment/methods</h2>
        </div>
        <p class="text-gray-600 mb-4">List available payment methods for your brand. Works with both publishable and secret keys.</p>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl <?= PAYMENT_URL ?>api/v1/payment/methods \
  -H "API-KEY: pk_test_your_key"</code></pre>
        </div>
      </article>

      <article id="ep-checkout">
        <div class="flex items-center gap-3 mb-4">
          <span class="method-badge method-get">GET</span>
          <h2 class="text-xl font-bold text-gray-900">/payment/checkout/{payment_id}</h2>
        </div>
        <p class="text-gray-600 mb-4">The hosted checkout page is a customer-facing payment page that displays available payment methods and lets the customer complete their payment. It is automatically generated when you create a payment.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">How It Works</h3>
        <ol class="list-decimal list-inside text-gray-600 space-y-2 mb-6">
          <li>Create a payment via the API and receive a <code class="bg-gray-100 px-1 rounded text-sm">checkout_url</code></li>
          <li>Redirect your customer to the <code class="bg-gray-100 px-1 rounded text-sm">checkout_url</code></li>
          <li>Customer selects a payment method and confirms payment</li>
          <li>In <strong>test mode</strong>: payment is instantly marked as completed</li>
          <li>In <strong>live mode</strong>: customer is redirected to the payment provider (bKash, Nagad, etc.)</li>
          <li>After payment, customer is redirected to your <code class="bg-gray-100 px-1 rounded text-sm">success_url</code> or <code class="bg-gray-100 px-1 rounded text-sm">cancel_url</code></li>
        </ol>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Checkout Page States</h3>
        <div class="overflow-x-auto mb-6">
          <table class="docs-table">
            <thead><tr><th>Payment Status</th><th>Page Shows</th></tr></thead>
            <tbody>
              <tr><td><code>processing</code></td><td>Payment method selection form with "Pay" button</td></tr>
              <tr><td><code>completed</code></td><td>Success confirmation with transaction ID</td></tr>
              <tr><td><code>failed</code></td><td>Failure message with return link</td></tr>
              <tr><td><code>refunded</code></td><td>Refund confirmation message</td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Test Mode Behavior</h3>
        <p class="text-gray-600 mb-4">When using test keys (<code>qp_test_</code>), the checkout page displays a yellow "Test Mode" banner. Clicking "Pay" immediately completes the payment without contacting any real provider. The customer is redirected to your <code>success_url</code> with query parameters:</p>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
<pre class="text-sm leading-relaxed"><code class="language-bash">https://yoursite.com/success?payment_id=pay_abc123&status=completed</code></pre>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Integration Example</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-php">&lt;?php
// 1. Create a payment on your server
$payment = $qpay->createPayment([
    'amount' => 500,
    'customer_email' => $customer_email,
    'success_url' => 'https://yoursite.com/order/success',
    'cancel_url' => 'https://yoursite.com/order/cancel',
]);

// 2. Redirect customer to the checkout page
header("Location: " . $payment['checkout_url']);
exit;

// 3. On your success page, verify the payment
$verified = $qpay->verifyPayment($_GET['payment_id']);
if ($verified['status'] === 'completed') {
    // Mark order as paid
}
?&gt;</code></pre>
        </div>
      </article>

      <article id="section-webhooks">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Webhooks</h1>
        <p class="text-gray-600 mb-4">Webhooks notify your server when events happen in your account. Configure webhook endpoints in your <a href="<?= base_url('user/api/webhooks') ?>" class="text-primary-600 hover:underline">merchant dashboard</a>.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Event Types</h3>
        <div class="overflow-x-auto mb-6">
          <table class="docs-table">
            <thead><tr><th>Event</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td><code>payment.created</code></td><td>A new payment has been created and is processing</td></tr>
              <tr><td><code>payment.completed</code></td><td>A payment has been verified and completed</td></tr>
              <tr><td><code>payment.failed</code></td><td>A payment has failed or was declined</td></tr>
              <tr><td><code>refund.created</code></td><td>A refund has been created for a payment</td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Webhook Payload</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
<pre class="text-sm leading-relaxed"><code class="language-json">{
  "event": "payment.completed",
  "data": {
    "id": "pay_a1b2c3d4e5f6a1b2c3d4e5f6",
    "object": "payment",
    "amount": 500,
    "currency": "bdt",
    "status": "completed",
    "test_mode": false,
    "transaction_id": "txn_abc123"
  },
  "created": 1717675200
}</code></pre>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Webhook Headers</h3>
        <div class="overflow-x-auto mb-4">
          <table class="docs-table">
            <thead><tr><th>Header</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td><code>QPay-Signature</code></td><td>Signature in format: <code>t={timestamp},v1={hmac_sha256_hash}</code></td></tr>
              <tr><td><code>Content-Type</code></td><td><code>application/json</code></td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Retry Policy</h3>
        <p class="text-gray-600 mb-4">If your endpoint returns a non-2xx status code, <?= $siteName ?> retries up to 3 times with exponential backoff: 1 minute, 5 minutes, 30 minutes.</p>
      </article>

      <article id="section-webhook-verify">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Webhook Signature Verification</h2>
        <p class="text-gray-600 mb-4">Always verify webhook signatures to ensure requests are from <?= $siteName ?>. The signature uses HMAC-SHA256.</p>

        <div x-data="{ tab: 'php' }" class="mt-4">
          <div class="flex flex-wrap gap-1 border-b border-gray-200 mb-0">
            <button @click="tab='php'" :class="tab==='php' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">PHP</button>
            <button @click="tab='node'" :class="tab==='node' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">Node.js</button>
            <button @click="tab='python'" :class="tab==='python' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">Python</button>
          </div>

          <div x-show="tab==='php'" class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
            <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-php">&lt;?php
// Using the QPay PHP SDK
require_once 'QPay.php';

$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_QPAY_SIGNATURE'] ?? '';
$secret = 'whsec_your_webhook_secret';

$valid = QPay::verifyWebhookSignature($payload, $signature, $secret);

if (!$valid) {
    http_response_code(401);
    exit('Invalid signature');
}

$event = json_decode($payload, true);

switch ($event['event']) {
    case 'payment.completed':
        // Update order status to paid
        $paymentId = $event['data']['id'];
        // your_update_order_function($paymentId, 'paid');
        break;
    case 'payment.failed':
        // Handle failed payment
        break;
    case 'refund.created':
        // Handle refund
        break;
}

http_response_code(200);
echo json_encode(['received' => true]);
?&gt;</code></pre>
          </div>

          <div x-show="tab==='node'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
            <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-javascript">const { QPay } = require('qpay-sdk');
const express = require('express');
const app = express();

app.post('/webhook', express.raw({type: 'application/json'}), (req, res) => {
  const payload = req.body.toString();
  const signature = req.headers['qpay-signature'];
  const secret = 'whsec_your_webhook_secret';

  const valid = QPay.verifyWebhookSignature(payload, signature, secret);

  if (!valid) {
    return res.status(401).send('Invalid signature');
  }

  const event = JSON.parse(payload);

  switch (event.event) {
    case 'payment.completed':
      // Update order status
      console.log('Payment completed:', event.data.id);
      break;
    case 'payment.failed':
      console.log('Payment failed:', event.data.id);
      break;
  }

  res.json({ received: true });
});</code></pre>
          </div>

          <div x-show="tab==='python'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
            <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-python">import hmac, hashlib, time, json

def verify_qpay_signature(payload, signature_header, secret, tolerance=300):
    parts = {}
    for part in signature_header.split(','):
        key, value = part.strip().split('=', 1)
        parts[key] = value

    timestamp = int(parts.get('t', 0))
    if abs(time.time() - timestamp) > tolerance:
        return False

    expected = hmac.new(
        secret.encode(),
        f"{timestamp}.{payload}".encode(),
        hashlib.sha256
    ).hexdigest()

    return hmac.compare_digest(expected, parts.get('v1', ''))

# Flask example
from flask import Flask, request
app = Flask(__name__)

@app.route('/webhook', methods=['POST'])
def webhook():
    payload = request.get_data(as_text=True)
    signature = request.headers.get('QPay-Signature', '')
    secret = 'whsec_your_webhook_secret'

    if not verify_qpay_signature(payload, signature, secret):
        return 'Invalid signature', 401

    event = json.loads(payload)

    if event['event'] == 'payment.completed':
        # Handle completed payment
        pass

    return {'received': True}, 200</code></pre>
          </div>
        </div>
      </article>

      <article id="section-php-sdk">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">PHP SDK</h1>
        <p class="text-gray-600 mb-4">A lightweight PHP SDK for integrating <?= $siteName ?> into any PHP application.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Installation</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash"># Download QPay.php and include it in your project
curl -o QPay.php <?= PAYMENT_URL ?>sdks/php/QPay.php</code></pre>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Usage</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-php">&lt;?php
require_once 'QPay.php';

$qpay = new QPay('qp_test_your_secret_key', '<?= rtrim(base_url(), '/') ?>');

// Create a payment
try {
    $payment = $qpay->createPayment([
        'amount' => 500,
        'currency' => 'BDT',
        'customer_email' => 'customer@example.com',
        'customer_name' => 'John Doe',
        'success_url' => 'https://yoursite.com/success',
        'cancel_url' => 'https://yoursite.com/cancel',
        'metadata' => ['order_id' => '12345'],
    ]);

    echo "Payment ID: " . $payment['id'];
    echo "Checkout URL: " . $payment['checkout_url'];
    // Redirect customer: header("Location: " . $payment['checkout_url']);

} catch (QPayException $e) {
    echo "Error: " . $e->getMessage();
    echo "Code: " . $e->getErrorCode();
}

// Verify a payment
$result = $qpay->verifyPayment('pay_abc123');

// Get payment status
$status = $qpay->getPaymentStatus('pay_abc123');

// List payments
$payments = $qpay->listPayments(['limit' => 20, 'status' => 'completed']);

// Create a refund
$refund = $qpay->createRefund('pay_abc123', 'Customer requested');

// Get balance
$balance = $qpay->getBalance();

// Get payment methods
$methods = $qpay->getPaymentMethods();
?&gt;</code></pre>
        </div>
        <a href="<?= base_url('sdks/php/QPay.php') ?>" download class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Download PHP SDK
        </a>
      </article>

      <article id="section-node-sdk">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Node.js SDK</h1>
        <p class="text-gray-600 mb-4">A lightweight JavaScript SDK for Node.js applications. Includes TypeScript declarations and supports both CommonJS and ES module imports.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Installation</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash"># Download the SDK files into your project
curl -o qpay.js <?= PAYMENT_URL ?>sdks/nodejs/qpay.js
curl -o qpay.mjs <?= PAYMENT_URL ?>sdks/nodejs/qpay.mjs
curl -o qpay.d.ts <?= PAYMENT_URL ?>sdks/nodejs/qpay.d.ts</code></pre>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Usage</h3>
        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-4">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-javascript">// CommonJS
const { QPay } = require('./qpay');

// ES Modules
// import QPay from './qpay.mjs';

const qpay = new QPay('qp_test_your_secret_key', {
  baseUrl: '<?= rtrim(base_url(), '/') ?>'
});

// Create a payment
async function createOrder() {
  try {
    const payment = await qpay.createPayment({
      amount: 500,
      currency: 'BDT',
      customer_email: 'customer@example.com',
      metadata: { order_id: '12345' }
    });

    console.log('Payment ID:', payment.id);
    console.log('Checkout URL:', payment.checkout_url);
    // Redirect customer to payment.checkout_url

  } catch (err) {
    console.error('Error:', err.message);
    console.error('Code:', err.errorCode);
  }
}

// Verify a payment
const result = await qpay.verifyPayment('pay_abc123');

// List payments
const payments = await qpay.listPayments({ limit: 20 });

// Create a refund
const refund = await qpay.createRefund('pay_abc123', 'Customer requested');

// Get balance
const balance = await qpay.getBalance();

// Verify webhook signature
const valid = QPay.verifyWebhookSignature(payload, signatureHeader, secret);</code></pre>
        </div>
        <a href="<?= base_url('sdks/nodejs/qpay.js') ?>" download class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Download Node.js SDK
        </a>
      </article>

      <article id="section-woocommerce">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">WooCommerce Plugin</h1>
        <p class="text-gray-600 mb-4">Accept <?= $siteName ?> payments on your WooCommerce store. Supports bKash, Nagad, Rocket, bank transfer and more.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Installation</h3>
        <ol class="list-decimal list-inside text-gray-600 space-y-2 mb-6">
          <li>Download the plugin ZIP file below</li>
          <li>Go to <strong>WordPress Admin &rarr; Plugins &rarr; Add New &rarr; Upload Plugin</strong></li>
          <li>Upload the ZIP and click <strong>Install Now</strong>, then <strong>Activate</strong></li>
          <li>Go to <strong>WooCommerce &rarr; Settings &rarr; Payments &rarr; QPay</strong></li>
          <li>Enter your <?= $siteName ?> API URL and API keys</li>
          <li>Configure your webhook URL in the <?= $siteName ?> dashboard: <code>https://yoursite.com/wp-json/qpay/v1/webhook</code></li>
          <li>Enter the webhook signing secret and save</li>
        </ol>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Features</h3>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
          <li>Seamless WooCommerce checkout integration</li>
          <li>Test and live mode support</li>
          <li>Automatic order status updates via webhooks</li>
          <li>Refund processing from WooCommerce admin</li>
          <li>Webhook signature verification for security</li>
          <li>Supports all <?= $siteName ?> payment methods</li>
        </ul>

        <a href="<?= base_url('sdks/woocommerce/qpay-woocommercev1.1.zip') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Download WooCommerce Plugin (ZIP)
        </a>
      </article>

      <article id="section-wordpress">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">QPay for WordPress</h1>
        <p class="text-gray-600 mb-4">The unified WordPress plugin lets you accept <?= $siteName ?> payments on any WordPress site &mdash; no WooCommerce required. Use simple shortcodes to add payment buttons, customizable forms, and donation widgets anywhere on your site.</p>

        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
          <p class="text-sm text-green-800"><strong>Recommended:</strong> This is the easiest way to integrate <?= $siteName ?> with WordPress. It includes WooCommerce support as an optional add-on.</p>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Installation</h3>
        <ol class="list-decimal list-inside text-gray-600 space-y-2 mb-6">
          <li>Download the plugin ZIP file below</li>
          <li>Go to <strong>WordPress Admin &rarr; Plugins &rarr; Add New &rarr; Upload Plugin</strong></li>
          <li>Upload the ZIP and click <strong>Install Now</strong>, then <strong>Activate</strong></li>
          <li>Go to <strong>QPay &rarr; Settings</strong> in your WordPress admin menu</li>
          <li>Enter your API URL (<code><?= rtrim(base_url(), '/') ?></code>) and API keys</li>
          <li>Configure your webhook URL in the <?= $siteName ?> dashboard: <code>https://yoursite.com/?qpay_webhook=1</code></li>
          <li>Save settings and start using shortcodes</li>
        </ol>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Shortcodes</h3>

        <div class="space-y-6 mb-6">
          <div class="border border-gray-200 rounded-xl p-5">
            <h4 class="font-semibold text-gray-900 mb-2"><code class="bg-primary-50 text-primary-700 px-2 py-0.5 rounded">[qpay_button]</code> &mdash; Payment Button</h4>
            <p class="text-gray-600 text-sm mb-3">Renders a styled payment button that redirects to the <?= $siteName ?> checkout page.</p>
            <div class="overflow-x-auto mb-3">
              <table class="docs-table">
                <thead><tr><th>Attribute</th><th>Default</th><th>Description</th></tr></thead>
                <tbody>
                  <tr><td><code>amount</code></td><td>100</td><td>Payment amount</td></tr>
                  <tr><td><code>currency</code></td><td>BDT</td><td>Currency code</td></tr>
                  <tr><td><code>label</code></td><td>Pay Now</td><td>Button text</td></tr>
                  <tr><td><code>description</code></td><td>&mdash;</td><td>Payment description</td></tr>
                  <tr><td><code>method</code></td><td>&mdash;</td><td>Preferred payment method (e.g. <code>bkash</code>)</td></tr>
                  <tr><td><code>success_url</code></td><td>&mdash;</td><td>Redirect URL after payment</td></tr>
                  <tr><td><code>cancel_url</code></td><td>&mdash;</td><td>Redirect URL on cancel</td></tr>
                </tbody>
              </table>
            </div>
            <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto">
              <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-html">[qpay_button amount="500" label="Pay BDT 500" description="Premium Plan"]

[qpay_button amount="1000" method="bkash" label="Pay with bKash"]

[qpay_button amount="250" success_url="https://yoursite.com/thank-you"]</code></pre>
            </div>
          </div>

          <div class="border border-gray-200 rounded-xl p-5">
            <h4 class="font-semibold text-gray-900 mb-2"><code class="bg-primary-50 text-primary-700 px-2 py-0.5 rounded">[qpay_form]</code> &mdash; Payment Form</h4>
            <p class="text-gray-600 text-sm mb-3">Displays a full payment form with fields for name, email, phone, amount, and description. Supports saved form templates via the admin Form Builder.</p>
            <div class="overflow-x-auto mb-3">
              <table class="docs-table">
                <thead><tr><th>Attribute</th><th>Default</th><th>Description</th></tr></thead>
                <tbody>
                  <tr><td><code>id</code></td><td>&mdash;</td><td>Load a saved form template by ID (from Form Builder)</td></tr>
                  <tr><td><code>amount</code></td><td>&mdash;</td><td>Fixed amount (hides amount field if set)</td></tr>
                  <tr><td><code>title</code></td><td>Payment Form</td><td>Form heading</td></tr>
                  <tr><td><code>fields</code></td><td>name,email,amount</td><td>Comma-separated fields to show: <code>name</code>, <code>email</code>, <code>phone</code>, <code>amount</code>, <code>description</code></td></tr>
                  <tr><td><code>button_text</code></td><td>Proceed to Payment</td><td>Submit button label</td></tr>
                  <tr><td><code>success_url</code></td><td>&mdash;</td><td>Redirect URL after payment</td></tr>
                </tbody>
              </table>
            </div>
            <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto">
              <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-html">[qpay_form title="Course Registration" amount="2500" fields="name,email,phone"]

[qpay_form fields="name,email,amount,description" button_text="Submit Payment"]

[qpay_form id="3"]  &lt;!-- Load saved form template #3 --&gt;</code></pre>
            </div>
          </div>

          <div class="border border-gray-200 rounded-xl p-5">
            <h4 class="font-semibold text-gray-900 mb-2"><code class="bg-primary-50 text-primary-700 px-2 py-0.5 rounded">[qpay_donate]</code> &mdash; Donation Widget</h4>
            <p class="text-gray-600 text-sm mb-3">A donation widget with preset amounts, custom amount input, and optional donor information fields.</p>
            <div class="overflow-x-auto mb-3">
              <table class="docs-table">
                <thead><tr><th>Attribute</th><th>Default</th><th>Description</th></tr></thead>
                <tbody>
                  <tr><td><code>amounts</code></td><td>100,500,1000,5000</td><td>Comma-separated preset amounts</td></tr>
                  <tr><td><code>title</code></td><td>Make a Donation</td><td>Widget heading</td></tr>
                  <tr><td><code>currency</code></td><td>BDT</td><td>Currency code</td></tr>
                  <tr><td><code>custom_amount</code></td><td>yes</td><td>Allow custom amount input (<code>yes</code>/<code>no</code>)</td></tr>
                  <tr><td><code>fields</code></td><td>name,email</td><td>Donor info fields to collect</td></tr>
                  <tr><td><code>success_url</code></td><td>&mdash;</td><td>Redirect URL after donation</td></tr>
                </tbody>
              </table>
            </div>
            <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto">
              <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-html">[qpay_donate title="Support Our Cause" amounts="200,500,1000,2000"]

[qpay_donate amounts="50,100,250" custom_amount="yes" fields="name,email"]

[qpay_donate title="Zakat" amounts="1000,5000,10000" currency="BDT"]</code></pre>
            </div>
          </div>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-2">Features</h3>
        <ul class="list-disc list-inside text-gray-600 space-y-1 mb-6">
          <li>Works with any WordPress theme (no WooCommerce required)</li>
          <li>Test and live mode support with visual badge</li>
          <li>Admin Form Builder for reusable payment form templates</li>
          <li>Transaction management dashboard in WordPress admin</li>
          <li>Email notifications for admin and customers</li>
          <li>Webhook handling with signature verification</li>
          <li>QPay Merchant role with custom capabilities</li>
          <li>Optional WooCommerce gateway integration (auto-detected)</li>
        </ul>

        <div class="flex flex-wrap gap-3">
          <a href="<?= base_url('sdks/wordpress/qpay-wordpress.zip') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
            Download WordPress Plugin (ZIP)
          </a>
        </div>
      </article>

      <article id="section-quickstart">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Quick Start Guide</h1>
        <p class="text-gray-600 mb-6">Get up and running with <?= $siteName ?> in 5 minutes. This guide walks you through your first test payment.</p>

        <div class="space-y-6">
          <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-bold">1</div>
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900 mb-1">Create an Account</h3>
              <p class="text-gray-600 text-sm">Register at <a href="<?= base_url('register') ?>" class="text-primary-600 hover:underline"><?= base_url('register') ?></a> and complete your merchant profile.</p>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-bold">2</div>
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900 mb-1">Generate API Keys</h3>
              <p class="text-gray-600 text-sm mb-2">Go to <a href="<?= base_url('user/api/keys') ?>" class="text-primary-600 hover:underline">Dashboard &rarr; API Keys</a> and generate a test key pair. You will receive a <code class="bg-gray-100 px-1 rounded text-sm">qp_test_</code> secret key and a <code class="bg-gray-100 px-1 rounded text-sm">pk_test_</code> publishable key.</p>
              <div class="bg-amber-50 border border-amber-200 rounded-lg p-3">
                <p class="text-xs text-amber-800"><strong>Save your secret key immediately.</strong> It is only shown once. You can always generate a new one if lost.</p>
              </div>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-bold">3</div>
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900 mb-1">Create Your First Test Payment</h3>
              <p class="text-gray-600 text-sm mb-2">Run this command in your terminal:</p>
              <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl -X POST <?= PAYMENT_URL ?>api/v1/payment/create \
  -H "API-KEY: qp_test_YOUR_KEY_HERE" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 500,
    "customer_email": "test@example.com",
    "success_url": "https://example.com/success",
    "cancel_url": "https://example.com/cancel"
  }'</code></pre>
              </div>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-bold">4</div>
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900 mb-1">Open the Checkout Page</h3>
              <p class="text-gray-600 text-sm">Copy the <code class="bg-gray-100 px-1 rounded text-sm">checkout_url</code> from the response and open it in your browser. You will see the payment method selection page with a "Test Mode" banner.</p>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-bold">5</div>
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900 mb-1">Complete the Test Payment</h3>
              <p class="text-gray-600 text-sm">Select any payment method and click "Pay". In test mode, the payment is instantly marked as completed. You are redirected to your <code class="bg-gray-100 px-1 rounded text-sm">success_url</code>.</p>
            </div>
          </div>

          <div class="flex gap-4">
            <div class="flex-shrink-0 w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-bold">6</div>
            <div class="flex-1">
              <h3 class="font-semibold text-gray-900 mb-1">Verify the Payment</h3>
              <p class="text-gray-600 text-sm mb-2">Always verify payments server-side before fulfilling orders:</p>
              <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto">
                <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl <?= PAYMENT_URL ?>api/v1/payment/verify/pay_YOUR_PAYMENT_ID \
  -H "API-KEY: qp_test_YOUR_KEY_HERE"</code></pre>
              </div>
            </div>
          </div>
        </div>
      </article>

      <article id="section-testing-guide">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Testing Guide</h1>
        <p class="text-gray-600 mb-6">This guide covers how to thoroughly test your <?= $siteName ?> integration before going live.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">1. Payment Lifecycle Testing</h3>
        <p class="text-gray-600 mb-4">Test every payment state by varying the amount:</p>
        <div class="overflow-x-auto mb-6">
          <table class="docs-table">
            <thead><tr><th>Test Scenario</th><th>Amount</th><th>Expected Result</th><th>Status</th></tr></thead>
            <tbody>
              <tr><td>Successful payment</td><td><code>500</code> (or any amount except 2/3)</td><td>Payment created with status <code>processing</code></td><td class="text-green-600">processing &rarr; completed</td></tr>
              <tr><td>Declined payment</td><td><code>2.00</code></td><td>Payment immediately fails with decline reason</td><td class="text-red-600">failed</td></tr>
              <tr><td>Insufficient funds</td><td><code>3.00</code></td><td>Payment fails with insufficient funds</td><td class="text-red-600">failed</td></tr>
              <tr><td>Refund flow</td><td>Create a successful payment, then refund</td><td>Payment status changes to <code>refunded</code></td><td class="text-yellow-600">refunded</td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">2. Checkout Page Testing</h3>
        <div class="bg-gray-50 rounded-xl p-5 mb-6">
          <ol class="list-decimal list-inside text-gray-600 space-y-2 text-sm">
            <li>Create a test payment and open the <code>checkout_url</code> in your browser</li>
            <li>Verify the "Test Mode" banner is visible</li>
            <li>Confirm the correct amount, currency, and customer email are displayed</li>
            <li>Select a payment method and click "Pay"</li>
            <li>Verify you are redirected to your <code>success_url</code> with correct query parameters</li>
            <li>Open the checkout URL again &mdash; it should show "Payment Completed"</li>
            <li>Refund the payment and revisit the checkout URL &mdash; it should show "Payment Refunded"</li>
            <li>Create a payment with amount <code>2.00</code> and check checkout shows "Payment Failed"</li>
          </ol>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">3. Webhook Testing</h3>
        <div class="bg-gray-50 rounded-xl p-5 mb-6">
          <ol class="list-decimal list-inside text-gray-600 space-y-2 text-sm">
            <li>Set up a webhook endpoint in your <a href="<?= base_url('user/api/webhooks') ?>" class="text-primary-600 hover:underline">merchant dashboard</a></li>
            <li>Use a tool like <a href="https://webhook.site" target="_blank" class="text-primary-600 hover:underline">webhook.site</a> or <a href="https://requestbin.com" target="_blank" class="text-primary-600 hover:underline">RequestBin</a> to capture webhook payloads</li>
            <li>Create a test payment and verify the <code>payment.created</code> event is delivered</li>
            <li>Complete a checkout and verify the <code>payment.completed</code> event fires</li>
            <li>Create a refund and verify the <code>refund.created</code> event fires</li>
            <li>Verify the <code>QPay-Signature</code> header matches when computed with your webhook secret</li>
          </ol>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">4. Error Handling Testing</h3>
        <div class="bg-gray-50 rounded-xl p-5 mb-6">
          <div class="space-y-3 text-sm text-gray-600">
            <div>
              <strong class="text-gray-900">Missing API key:</strong>
              <div class="code-container bg-gray-900 rounded-lg p-3 overflow-x-auto mt-1">
<pre class="text-sm leading-relaxed"><code class="language-bash">curl <?= PAYMENT_URL ?>api/v1/payments
# Expected: 401 MISSING_API_KEY</code></pre>
              </div>
            </div>
            <div>
              <strong class="text-gray-900">Invalid API key:</strong>
              <div class="code-container bg-gray-900 rounded-lg p-3 overflow-x-auto mt-1">
<pre class="text-sm leading-relaxed"><code class="language-bash">curl <?= PAYMENT_URL ?>api/v1/payments -H "API-KEY: invalid_key"
# Expected: 401 INVALID_API_KEY</code></pre>
              </div>
            </div>
            <div>
              <strong class="text-gray-900">Invalid payment ID:</strong>
              <div class="code-container bg-gray-900 rounded-lg p-3 overflow-x-auto mt-1">
<pre class="text-sm leading-relaxed"><code class="language-bash">curl <?= PAYMENT_URL ?>api/v1/payment/verify/pay_nonexistent -H "API-KEY: qp_test_YOUR_KEY"
# Expected: 404 PAYMENT_NOT_FOUND</code></pre>
              </div>
            </div>
            <div>
              <strong class="text-gray-900">Missing required fields:</strong>
              <div class="code-container bg-gray-900 rounded-lg p-3 overflow-x-auto mt-1">
<pre class="text-sm leading-relaxed"><code class="language-bash">curl -X POST <?= PAYMENT_URL ?>api/v1/payment/create \
  -H "API-KEY: qp_test_YOUR_KEY" \
  -H "Content-Type: application/json" \
  -d '{}'
# Expected: 422 VALIDATION_ERROR (amount is required)</code></pre>
              </div>
            </div>
            <div>
              <strong class="text-gray-900">Duplicate payment (idempotency):</strong>
              <div class="code-container bg-gray-900 rounded-lg p-3 overflow-x-auto mt-1">
<pre class="text-sm leading-relaxed"><code class="language-bash"># Send the same Idempotency-Key twice
curl -X POST <?= PAYMENT_URL ?>api/v1/payment/create \
  -H "API-KEY: qp_test_YOUR_KEY" \
  -H "Idempotency-Key: order_12345" \
  -H "Content-Type: application/json" \
  -d '{"amount": 500}'
# Second request returns the original payment (not a duplicate)</code></pre>
              </div>
            </div>
          </div>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">5. SDK Integration Testing</h3>
        <div x-data="{ tab: 'php' }" class="mb-6">
          <div class="flex flex-wrap gap-1 border-b border-gray-200 mb-0">
            <button @click="tab='php'" :class="tab==='php' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">PHP</button>
            <button @click="tab='node'" :class="tab==='node' ? 'border-b-2 border-primary-600 text-primary-600' : 'text-gray-500 hover:text-gray-700'" class="px-4 py-2 text-sm font-medium">Node.js</button>
          </div>
          <div x-show="tab==='php'" class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
            <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-php">&lt;?php
require_once 'QPay.php';

$qpay = new QPay('qp_test_YOUR_KEY', '<?= rtrim(base_url(), '/') ?>');

// Test 1: Create a successful payment
$payment = $qpay->createPayment(['amount' => 500, 'customer_email' => 'test@test.com']);
assert($payment['status'] === 'processing', 'Payment should be processing');
echo "PASS: Payment created - {$payment['id']}\n";

// Test 2: Verify payment
$verified = $qpay->verifyPayment($payment['id']);
assert($verified['status'] === 'completed', 'Payment should be completed after verify');
assert($verified['verified'] === true, 'verified flag should be true');
echo "PASS: Payment verified\n";

// Test 3: List payments
$list = $qpay->listPayments(['limit' => 5]);
assert(count($list['data']) > 0, 'Should have at least 1 payment');
echo "PASS: Listed " . count($list['data']) . " payments\n";

// Test 4: Create and refund
$refund = $qpay->createRefund($payment['id'], 'Test refund');
assert($refund['status'] === 'succeeded', 'Refund should succeed');
echo "PASS: Refund created - {$refund['id']}\n";

// Test 5: Check balance
$balance = $qpay->getBalance();
assert(isset($balance['available']), 'Balance should have available field');
echo "PASS: Balance retrieved\n";

// Test 6: Create declined payment
try {
    $declined = $qpay->createPayment(['amount' => 2]);
    assert($declined['status'] === 'failed', 'Amount 2 should be declined');
    echo "PASS: Decline simulated correctly\n";
} catch (QPayException $e) {
    echo "PASS: Decline threw exception - {$e->getMessage()}\n";
}

// Test 7: Get payment methods
$methods = $qpay->getPaymentMethods();
assert(!empty($methods['data']['methods']), 'Should have payment methods');
echo "PASS: Retrieved " . count($methods['data']['methods']) . " methods\n";

echo "\nAll tests passed!\n";
?&gt;</code></pre>
          </div>
          <div x-show="tab==='node'" x-cloak class="code-container bg-gray-900 rounded-b-lg p-4 overflow-x-auto">
            <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-javascript">const { QPay } = require('./qpay');

const qpay = new QPay('qp_test_YOUR_KEY', {
  baseUrl: '<?= rtrim(base_url(), '/') ?>'
});

async function runTests() {
  // Test 1: Create a successful payment
  const payment = await qpay.createPayment({
    amount: 500,
    customer_email: 'test@test.com'
  });
  console.assert(payment.status === 'processing', 'Should be processing');
  console.log('PASS: Payment created -', payment.id);

  // Test 2: Verify payment
  const verified = await qpay.verifyPayment(payment.id);
  console.assert(verified.status === 'completed', 'Should be completed');
  console.log('PASS: Payment verified');

  // Test 3: List payments
  const list = await qpay.listPayments({ limit: 5 });
  console.assert(list.data.length > 0, 'Should have payments');
  console.log('PASS: Listed', list.data.length, 'payments');

  // Test 4: Refund
  const refund = await qpay.createRefund(payment.id, 'Test refund');
  console.assert(refund.status === 'succeeded', 'Refund should succeed');
  console.log('PASS: Refund created -', refund.id);

  // Test 5: Check balance
  const balance = await qpay.getBalance();
  console.assert('available' in balance, 'Should have available');
  console.log('PASS: Balance retrieved');

  // Test 6: Declined payment
  const declined = await qpay.createPayment({ amount: 2 });
  console.assert(declined.status === 'failed', 'Should be declined');
  console.log('PASS: Decline simulated');

  // Test 7: Payment methods
  const methods = await qpay.getPaymentMethods();
  console.assert(methods.data.methods.length > 0, 'Should have methods');
  console.log('PASS:', methods.data.methods.length, 'methods');

  console.log('\nAll tests passed!');
}

runTests().catch(console.error);</code></pre>
          </div>
        </div>
      </article>

      <article id="section-sandbox">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Sandbox Reference</h1>
        <p class="text-gray-600 mb-6">The sandbox (test mode) provides a safe environment to develop and test your integration without processing real payments.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">Test vs Live Environment</h3>
        <div class="overflow-x-auto mb-6">
          <table class="docs-table">
            <thead><tr><th>Feature</th><th>Test Mode</th><th>Live Mode</th></tr></thead>
            <tbody>
              <tr><td>API keys</td><td><code>qp_test_*</code> / <code>pk_test_*</code></td><td><code>qp_live_*</code> / <code>pk_live_*</code></td></tr>
              <tr><td>Real charges</td><td>No</td><td>Yes</td></tr>
              <tr><td>Payment providers</td><td>Simulated</td><td>Real (bKash, Nagad, etc.)</td></tr>
              <tr><td>Checkout page</td><td>Instant completion on "Pay"</td><td>Redirect to provider</td></tr>
              <tr><td>Webhooks</td><td>Delivered (same as live)</td><td>Delivered</td></tr>
              <tr><td>Rate limits</td><td>200 req/min</td><td>100 req/min</td></tr>
              <tr><td>Data visibility</td><td>Separate from live data</td><td>Production data</td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">Test Amount Behaviors</h3>
        <div class="overflow-x-auto mb-6">
          <table class="docs-table">
            <thead><tr><th>Amount (BDT)</th><th>Behavior</th><th>Use Case</th></tr></thead>
            <tbody>
              <tr><td><code>2.00</code></td><td class="text-red-600">Payment declined</td><td>Test decline handling and error UI</td></tr>
              <tr><td><code>3.00</code></td><td class="text-red-600">Insufficient funds</td><td>Test specific failure reason handling</td></tr>
              <tr><td>Any other amount</td><td class="text-green-600">Success (processing)</td><td>Test normal payment flow</td></tr>
            </tbody>
          </table>
        </div>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">Test Payment IDs</h3>
        <p class="text-gray-600 mb-4">All test payments use real-looking IDs (e.g. <code>pay_a1b2c3d4...</code>) and test transaction IDs prefixed with <code>test_txn_</code>. These can be used with all API endpoints (verify, status, refund, etc.) exactly like live payments.</p>

        <h3 class="text-lg font-semibold text-gray-900 mb-3">Idempotency in Test Mode</h3>
        <p class="text-gray-600 mb-4">Idempotency keys work the same way in test and live mode. If you send the same <code>Idempotency-Key</code> header twice, you get back the original payment object rather than creating a duplicate.</p>
      </article>

      <article id="section-going-live">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Going Live Checklist</h1>
        <p class="text-gray-600 mb-6">Before switching to live mode, ensure you have completed the following:</p>

        <div class="space-y-3 mb-6">
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Generate live API keys</p>
              <p class="text-sm text-gray-500">Create <code>qp_live_</code> and <code>pk_live_</code> keys in your merchant dashboard. Store the secret key securely.</p>
            </div>
          </label>
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Replace test keys with live keys</p>
              <p class="text-sm text-gray-500">Update your server-side code to use <code>qp_live_</code> keys. Use environment variables, never hardcode keys.</p>
            </div>
          </label>
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Set up webhook endpoint</p>
              <p class="text-sm text-gray-500">Configure a production webhook URL with HTTPS. Verify signature validation is working.</p>
            </div>
          </label>
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Implement server-side verification</p>
              <p class="text-sm text-gray-500">Always verify payments server-side using <code>/payment/verify</code> before fulfilling orders. Never trust client-side redirects alone.</p>
            </div>
          </label>
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Handle all payment states</p>
              <p class="text-sm text-gray-500">Your integration should handle: <code>processing</code>, <code>completed</code>, <code>failed</code>, and <code>refunded</code> statuses gracefully.</p>
            </div>
          </label>
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Implement error handling</p>
              <p class="text-sm text-gray-500">Handle API errors (4xx, 5xx) with appropriate user-facing messages. Implement retry logic for network failures.</p>
            </div>
          </label>
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Use idempotency keys</p>
              <p class="text-sm text-gray-500">Send a unique <code>Idempotency-Key</code> header with payment creation requests to prevent duplicates from retries.</p>
            </div>
          </label>
          <label class="flex items-start gap-3 p-4 border border-gray-200 rounded-xl hover:border-primary-300 transition-colors">
            <input type="checkbox" class="mt-1 text-primary-600 rounded">
            <div>
              <p class="font-semibold text-gray-900">Test with a real payment</p>
              <p class="text-sm text-gray-500">Make a small live payment (e.g. BDT 10) to verify the complete flow end-to-end, then refund it.</p>
            </div>
          </label>
        </div>
      </article>

      <article id="section-errors">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Error Codes</h1>
        <div class="overflow-x-auto">
          <table class="docs-table">
            <thead><tr><th>HTTP Code</th><th>Error Code</th><th>Description</th></tr></thead>
            <tbody>
              <tr><td>400</td><td><code>MISSING_PAYMENT_ID</code></td><td>Payment ID was not provided</td></tr>
              <tr><td>401</td><td><code>MISSING_API_KEY</code></td><td>No API-KEY header sent</td></tr>
              <tr><td>401</td><td><code>INVALID_API_KEY</code></td><td>API key is invalid, expired, or revoked</td></tr>
              <tr><td>403</td><td><code>FORBIDDEN</code></td><td>Key type not allowed for this endpoint</td></tr>
              <tr><td>404</td><td><code>PAYMENT_NOT_FOUND</code></td><td>No payment found with the given ID</td></tr>
              <tr><td>422</td><td><code>VALIDATION_ERROR</code></td><td>Invalid request parameters</td></tr>
              <tr><td>429</td><td><code>RATE_LIMIT_EXCEEDED</code></td><td>Too many requests (see Rate Limits)</td></tr>
              <tr><td>500</td><td><code>PAYMENT_CREATION_FAILED</code></td><td>Server error creating payment</td></tr>
            </tbody>
          </table>
        </div>
      </article>

      <article id="section-rate-limits">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Rate Limits</h1>
        <div class="overflow-x-auto">
          <table class="docs-table">
            <thead><tr><th>Key Type</th><th>Limit</th><th>Window</th></tr></thead>
            <tbody>
              <tr><td>Live keys (<code>qp_live_</code>, <code>pk_live_</code>)</td><td>100 requests</td><td>per minute</td></tr>
              <tr><td>Test keys (<code>qp_test_</code>, <code>pk_test_</code>)</td><td>200 requests</td><td>per minute</td></tr>
            </tbody>
          </table>
        </div>
        <p class="text-gray-600 mt-4">When rate limited, the API returns HTTP 429 with a <code>Retry-After</code> header indicating seconds to wait.</p>
      </article>

      <article id="section-best-practices">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Best Practices</h1>

        <div class="space-y-6">
          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Always verify payments server-side</h3>
            <p class="text-gray-600 text-sm">Never trust the <code>success_url</code> redirect alone. A customer could manually navigate to your success URL. Always call <code>/payment/verify</code> or <code>/payment/status</code> from your server before fulfilling orders.</p>
          </div>

          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Use idempotency keys for payment creation</h3>
            <p class="text-gray-600 text-sm">Include an <code>Idempotency-Key</code> header with a unique value (e.g. your order ID) when creating payments. This prevents duplicate charges if a network error causes a retry.</p>
          </div>

          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Verify webhook signatures</h3>
            <p class="text-gray-600 text-sm">Always validate the <code>QPay-Signature</code> header using HMAC-SHA256 before processing webhook events. This prevents attackers from sending fake webhook requests to your endpoint.</p>
          </div>

          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Store API keys securely</h3>
            <p class="text-gray-600 text-sm">Keep secret keys (<code>qp_</code>) in environment variables or a secrets manager. Never commit them to version control, embed them in client-side code, or log them in application logs.</p>
          </div>

          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Handle webhook delivery failures</h3>
            <p class="text-gray-600 text-sm">Return a 2xx status code quickly from your webhook handler. If you need to perform long-running work, acknowledge the webhook first, then process asynchronously. <?= $siteName ?> retries failed deliveries up to 3 times.</p>
          </div>

          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Make webhooks idempotent</h3>
            <p class="text-gray-600 text-sm">Your webhook handler may receive the same event multiple times due to retries. Use the payment ID to check if you have already processed the event before taking action.</p>
          </div>

          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Use appropriate key types</h3>
            <p class="text-gray-600 text-sm">Use <code>pk_</code> publishable keys for client-side operations (fetching payment methods, checking status). Use <code>qp_</code> secret keys for server-side operations (creating payments, refunds, verification).</p>
          </div>

          <div class="border-l-4 border-primary-500 pl-4">
            <h3 class="font-semibold text-gray-900 mb-1">Implement proper error handling</h3>
            <p class="text-gray-600 text-sm">Handle all HTTP error codes (400, 401, 403, 404, 422, 429, 500). Show user-friendly messages for expected errors and log unexpected errors for debugging. Implement exponential backoff for 429 rate limit responses.</p>
          </div>
        </div>
      </article>

      <article id="section-changelog">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">Changelog</h1>
        <div class="space-y-6">
          <div>
            <div class="flex items-center gap-3 mb-2">
              <span class="px-2.5 py-0.5 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Latest</span>
              <h3 class="font-semibold text-gray-900">v1.4.0 &mdash; <?= date('F Y') ?></h3>
            </div>
            <ul class="list-disc list-inside text-gray-600 text-sm space-y-1 ml-4">
              <li>Added hosted checkout page with payment method selection UI</li>
              <li>Test mode checkout instantly completes payments</li>
              <li>Added QPay for WordPress plugin with shortcodes (<code>[qpay_button]</code>, <code>[qpay_form]</code>, <code>[qpay_donate]</code>)</li>
              <li>Added comprehensive testing guide and sandbox reference documentation</li>
              <li>Added Going Live checklist and Best Practices guide</li>
              <li>Fixed dashboard data endpoint JSON response format</li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 mb-2">v1.3.0</h3>
            <ul class="list-disc list-inside text-gray-600 text-sm space-y-1 ml-4">
              <li>Added unified WordPress plugin with WooCommerce support</li>
              <li>Added Form Builder for reusable payment forms</li>
              <li>Webhook idempotency and improved event delivery</li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 mb-2">v1.2.0</h3>
            <ul class="list-disc list-inside text-gray-600 text-sm space-y-1 ml-4">
              <li>PHP SDK and Node.js SDK released</li>
              <li>WooCommerce gateway plugin</li>
              <li>API documentation page</li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 mb-2">v1.1.0</h3>
            <ul class="list-disc list-inside text-gray-600 text-sm space-y-1 ml-4">
              <li>Stripe-style API key system (pk_/qp_ with live/test modes)</li>
              <li>Webhook signing with HMAC-SHA256</li>
              <li>Rate limiting and API logging</li>
              <li>Test mode with simulated payment adapter</li>
            </ul>
          </div>
          <div>
            <h3 class="font-semibold text-gray-900 mb-2">v1.0.0</h3>
            <ul class="list-disc list-inside text-gray-600 text-sm space-y-1 ml-4">
              <li>Initial API release with payment creation, verification, and status</li>
              <li>Support for bKash, Nagad, Rocket and other MFS providers</li>
              <li>Idempotency key support</li>
            </ul>
          </div>
        </div>
      </article>

    </div>
  </div>
</div>

<script>
function copyCode(btn) {
  const code = btn.parentElement.querySelector('code');
  navigator.clipboard.writeText(code.textContent).then(() => {
    btn.textContent = 'Copied!';
    setTimeout(() => btn.textContent = 'Copy', 2000);
  });
}
</script>

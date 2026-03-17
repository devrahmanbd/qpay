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
        <p class="px-3 py-1 pt-3 text-xs font-bold text-gray-400 uppercase tracking-wider">SDKs & Plugins</p>
        <a href="#section-php-sdk" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">PHP SDK</a>
        <a href="#section-node-sdk" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Node.js SDK</a>
        <a href="#section-woocommerce" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">WooCommerce Plugin</a>
        <p class="px-3 py-1 pt-3 text-xs font-bold text-gray-400 uppercase tracking-wider">Other</p>
        <a href="#section-errors" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Error Codes</a>
        <a href="#section-rate-limits" class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 rounded-lg">Rate Limits</a>
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
        <p class="text-gray-600 mb-4">All API requests require an <code class="bg-gray-100 px-1 rounded text-sm">API-KEY</code> header containing your secret or publishable key.</p>

        <div class="code-container bg-gray-900 rounded-lg p-4 overflow-x-auto mb-6">
          <button class="copy-btn px-2 py-1 text-xs bg-gray-700 text-gray-300 rounded hover:bg-gray-600" onclick="copyCode(this)">Copy</button>
<pre class="text-sm leading-relaxed"><code class="language-bash">curl -X POST <?= PAYMENT_URL ?>api/v1/payment/create \
  -H "API-KEY: sk_test_your_secret_key_here" \
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
                <tr><td><code>sk_live_</code></td><td>Secret</td><td>Live</td><td>Server-side only (create, verify, refund)</td></tr>
                <tr><td><code>pk_test_</code></td><td>Publishable</td><td>Test</td><td>Client-side testing</td></tr>
                <tr><td><code>sk_test_</code></td><td>Secret</td><td>Test</td><td>Server-side testing (mock payments)</td></tr>
              </tbody>
            </table>
          </div>
          <div class="mt-4 bg-amber-50 border border-amber-200 rounded-lg p-4">
            <p class="text-sm text-amber-800"><strong>Important:</strong> Secret keys (<code>sk_</code>) must never be exposed in client-side code, public repositories, or browser JavaScript. Only use publishable keys (<code>pk_</code>) on the client side.</p>
          </div>
        </div>

        <div id="section-test-mode">
          <h2 class="text-xl font-semibold text-gray-900 mb-3">Test Mode</h2>
          <p class="text-gray-600 mb-4">Use test keys (<code>sk_test_</code> / <code>pk_test_</code>) for safe testing. Test mode simulates payment outcomes based on amount:</p>
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
        <p class="text-sm text-gray-500 mb-4"><strong>Required key:</strong> Secret key (<code>sk_</code>)</p>

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
              <tr><td><code>API-KEY</code></td><td>Yes</td><td>Your secret API key</td></tr>
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
        <p class="text-sm text-gray-500 mb-4"><strong>Required key:</strong> Secret key (<code>sk_</code>) only</p>

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
  -H "API-KEY: sk_test_your_key"</code></pre>
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
  -H "API-KEY: sk_test_your_key"</code></pre>
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
        <p class="text-sm text-gray-500 mb-4"><strong>Required key:</strong> Secret key (<code>sk_</code>) only</p>
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
  -H "API-KEY: sk_live_your_key" \
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
  -H "API-KEY: sk_test_your_key"</code></pre>
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

$qpay = new QPay('sk_test_your_secret_key', '<?= rtrim(base_url(), '/') ?>');

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

const qpay = new QPay('sk_test_your_secret_key', {
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

        <a href="<?= base_url('sdks/woocommerce/qpay-woocommerce.zip') ?>" class="inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
          Download WooCommerce Plugin (ZIP)
        </a>
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
              <tr><td>Live keys (<code>sk_live_</code>, <code>pk_live_</code>)</td><td>100 requests</td><td>per minute</td></tr>
              <tr><td>Test keys (<code>sk_test_</code>, <code>pk_test_</code>)</td><td>200 requests</td><td>per minute</td></tr>
            </tbody>
          </table>
        </div>
        <p class="text-gray-600 mt-4">When rate limited, the API returns HTTP 429 with a <code>Retry-After</code> header indicating seconds to wait.</p>
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

<div class="space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-900">SDKs & Plugins</h1>
        <p class="text-sm text-gray-500 mt-1">Download integration packages to quickly connect your application with <?= site_config('site_name', 'QPay') ?></p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <div class="bg-white rounded-xl shadow-sm border-2 border-primary-200 p-6 relative">
            <span class="absolute -top-2.5 left-4 px-2 py-0.5 bg-primary-600 text-white text-xs font-bold rounded-full uppercase tracking-wide">Recommended</span>
            <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v18"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">QPay for WordPress</h3>
                    <p class="text-sm text-gray-500">Any WordPress Site</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-3">Accept payments on any WordPress site using shortcodes for buttons, custom forms, and donation forms. Easy installation and automatic updates.</p>
            <div class="flex flex-wrap gap-1.5 mb-4">
                <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded">[qpay_button]</span>
                <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded">[qpay_form]</span>
                <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded">[qpay_donate]</span>
                <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 text-xs font-medium rounded">Webhooks</span>
            </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">PHP SDK</h3>
                    <p class="text-sm text-gray-500">Any PHP Application</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">A single-file PHP SDK for integrating payments into any PHP project. Includes payment creation, verification, refunds, balance, and webhook signature verification.</p>
            <div class="space-y-3">
                <a href="<?= base_url('sdks/php/QPay.php') ?>" download class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download QPay.php
                </a>
                <details class="mt-3">
                    <summary class="text-sm font-medium text-primary-600 cursor-pointer hover:text-primary-700">Quick Start</summary>
                    <div class="mt-2 bg-gray-900 rounded-lg p-4 overflow-x-auto">
<pre class="text-sm leading-relaxed text-gray-100"><code>&lt;?php
require_once 'QPay.php';

$qpay = new QPay('qp_test_your_secret_key', '<?= $api_base_url ?>');

$payment = $qpay->createPayment([
    'amount' => 500,
    'customer_email' => 'customer@example.com',
]);

// Redirect to checkout
header("Location: " . $payment['checkout_url']);

// Verify a payment
$result = $qpay->verifyPayment('pay_abc123');

// Create a refund
$refund = $qpay->createRefund('pay_abc123');
?&gt;</code></pre>
                    </div>
                </details>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Node.js SDK</h3>
                    <p class="text-sm text-gray-500">JavaScript / Node.js</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">A lightweight JavaScript SDK for Node.js applications. Supports async/await, webhook signature verification, and all API endpoints.</p>
            <div class="space-y-3">
                <a href="<?= base_url('sdks/nodejs/qpay.js') ?>" download class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                    Download qpay.js
                </a>
                <details class="mt-3">
                    <summary class="text-sm font-medium text-primary-600 cursor-pointer hover:text-primary-700">Quick Start</summary>
                    <div class="mt-2 bg-gray-900 rounded-lg p-4 overflow-x-auto">
<pre class="text-sm leading-relaxed text-gray-100"><code>const { QPay } = require('./qpay');

const qpay = new QPay('qp_test_your_secret_key', {
  baseUrl: '<?= $api_base_url ?>'
});

// Create a payment
const payment = await qpay.createPayment({
  amount: 500,
  customer_email: 'customer@example.com'
});

console.log('Checkout:', payment.checkout_url);

// Verify a payment
const result = await qpay.verifyPayment('pay_abc123');

// Verify webhook signature
const valid = QPay.verifyWebhookSignature(
  payload, signatureHeader, secret
);</code></pre>
                    </div>
                </details>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-start gap-4 mb-4">
                <div class="w-12 h-12 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">API Documentation</h3>
                    <p class="text-sm text-gray-500">Full Reference</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mb-4">Complete API reference with endpoint documentation, request/response examples, webhook integration guide, error codes, and rate limit information.</p>
            <a href="<?= base_url('developers/docs') ?>" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                View API Docs
            </a>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-sm text-blue-700">
                <p class="font-medium">Your API URL</p>
                <p class="mt-1">Use this URL when configuring SDKs and plugins: <code class="bg-blue-100 px-1 rounded"><?= $api_base_url ?></code></p>
                <p class="mt-1">Get your API keys from the <a href="<?= user_url('api/keys') ?>" class="font-medium underline">API Keys</a> page. Set up webhooks on the <a href="<?= user_url('api/webhooks') ?>" class="font-medium underline">Webhooks</a> page.</p>
            </div>
        </div>
    </div>
</div>

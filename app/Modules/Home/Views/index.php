<section class="relative bg-gradient-to-br from-gray-900 via-indigo-900 to-purple-900 text-white overflow-hidden">
  <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiNmZmYiIGZpbGwtb3BhY2l0eT0iMC4wMyI+PHBhdGggZD0iTTM2IDM0aDR2MWgtNHoiLz48L2c+PC9nPjwvc3ZnPg==')] opacity-50"></div>
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28 relative">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
      <div class="fade-in">
        <h1 class="text-4xl lg:text-5xl font-bold leading-tight mb-6">Payment Infrastructure for South Asia</h1>
        <p class="text-lg text-gray-300 mb-8 max-w-xl">A unified API to accept, process, and orchestrate payments across bKash, Nagad, Rocket, bank transfers, and more. Built for developers, trusted by businesses.</p>
        <div class="flex flex-col sm:flex-row gap-4">
          <a href="<?= base_url('sign-up') ?>" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition-colors">
            Get API Keys
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </a>
          <a href="<?= base_url('developers') ?>" class="inline-flex items-center justify-center gap-2 px-6 py-3 border-2 border-white/30 text-white font-semibold rounded-lg hover:bg-white/10 transition-colors">
            Read the Docs
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          </a>
        </div>
      </div>
      <div class="fade-in" style="animation-delay:.2s">
        <div class="p-5 rounded-xl bg-white/5 backdrop-blur-sm border border-white/10">
<pre class="text-green-300 text-sm leading-relaxed overflow-x-auto"><code>curl -X POST <?= base_url('api/v1/payment/create') ?> \
  -H "API-KEY: your_api_key_here" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 500,
    "currency": "BDT",
    "customer_name": "John Doe",
    "customer_email": "john@example.com",
    "success_url": "https://yoursite.com/success",
    "cancel_url": "https://yoursite.com/cancel"
  }'</code></pre>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="py-16 lg:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900">Why <?= site_config('site_name', 'QPay') ?>?</h2>
      <p class="mt-3 text-gray-500">Everything you need to accept payments at scale</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow fade-in" style="animation-delay:.1s">
        <div class="w-12 h-12 rounded-lg bg-primary-100 text-primary-600 flex items-center justify-center mb-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Single API Integration</h4>
        <p class="text-sm text-gray-600">One REST API to connect bKash, Nagad, Rocket, bank transfers, and card payments. No provider-specific code required.</p>
      </div>
      <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow fade-in" style="animation-delay:.2s">
        <div class="w-12 h-12 rounded-lg bg-green-100 text-green-600 flex items-center justify-center mb-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Idempotent & Secure</h4>
        <p class="text-sm text-gray-600">Built-in idempotency keys prevent duplicate charges. API-key authentication, IP whitelisting, and rate limiting protect every request.</p>
      </div>
      <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow fade-in" style="animation-delay:.3s">
        <div class="w-12 h-12 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center mb-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Real-Time Verification</h4>
        <p class="text-sm text-gray-600">Automatic SMS-based payment verification with instant callback notifications. Know the status of every transaction in real time.</p>
      </div>
      <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow fade-in" style="animation-delay:.4s">
        <div class="w-12 h-12 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center mb-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Developer-First</h4>
        <p class="text-sm text-gray-600">Comprehensive API docs with code samples in PHP, Node.js, Python, and Go. SDKs and plugins for WordPress, WooCommerce, and WHMCS.</p>
      </div>
      <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow fade-in" style="animation-delay:.5s">
        <div class="w-12 h-12 rounded-lg bg-red-100 text-red-600 flex items-center justify-center mb-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Multi-Brand Support</h4>
        <p class="text-sm text-gray-600">Run multiple brands from a single merchant account. Separate API keys, payment methods, and fee structures per brand.</p>
      </div>
      <div class="bg-gray-50 rounded-xl p-6 hover:shadow-md transition-shadow fade-in" style="animation-delay:.6s">
        <div class="w-12 h-12 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center mb-4">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <h4 class="text-lg font-semibold text-gray-900 mb-2">Invoice & Billing</h4>
        <p class="text-sm text-gray-600">Generate payment links and invoices. Send them via email for quick collection without needing a website or online store.</p>
      </div>
    </div>
  </div>
</section>

<section class="py-16 bg-gray-50" x-data="{ counts: [
  { value: 1963, label: 'Merchants', color: 'text-primary-600' },
  { value: 12, label: 'Payment Methods', color: 'text-amber-600' },
  { value: 3287490, label: 'Total Volume (BDT)', color: 'text-green-600' },
  { value: 99, label: 'Uptime %', color: 'text-pink-600' }
] }">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
      <template x-for="(item, i) in counts" :key="i">
        <div class="text-center fade-in">
          <div class="text-3xl lg:text-4xl font-bold text-gray-900" x-text="item.value.toLocaleString()"></div>
          <p class="mt-1 text-sm font-medium text-gray-500" x-text="item.label"></p>
        </div>
      </template>
    </div>
  </div>
</section>

<section class="py-16 lg:py-24 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900">How It Works</h2>
      <p class="mt-3 text-gray-500">Three steps to start accepting payments</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="relative fade-in" style="animation-delay:.1s">
        <div class="bg-white rounded-xl border-2 border-primary-100 p-6">
          <div class="w-10 h-10 rounded-full bg-primary-600 text-white flex items-center justify-center text-lg font-bold mb-4">1</div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Create Payment</h3>
          <p class="text-sm text-gray-600">POST to <code class="text-primary-600 bg-primary-50 px-1 rounded">/api/v1/payment/create</code> with amount, currency, and callback URLs. Receive a payment ID and checkout URL instantly.</p>
        </div>
      </div>
      <div class="relative fade-in" style="animation-delay:.2s">
        <div class="bg-white rounded-xl border-2 border-amber-100 p-6">
          <div class="w-10 h-10 rounded-full bg-amber-500 text-white flex items-center justify-center text-lg font-bold mb-4">2</div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Customer Pays</h3>
          <p class="text-sm text-gray-600">Redirect your customer to the checkout URL. They choose their preferred payment method and complete the transaction securely.</p>
        </div>
      </div>
      <div class="relative fade-in" style="animation-delay:.3s">
        <div class="bg-white rounded-xl border-2 border-green-100 p-6">
          <div class="w-10 h-10 rounded-full bg-green-500 text-white flex items-center justify-center text-lg font-bold mb-4">3</div>
          <h3 class="text-lg font-semibold text-gray-900 mb-2">Verify & Settle</h3>
          <p class="text-sm text-gray-600">Call <code class="text-primary-600 bg-primary-50 px-1 rounded">/api/v1/payment/verify</code> to confirm the transaction. Funds settle to your account automatically after verification.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($plans)) : ?>
<section class="py-16 lg:py-24 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900">Pricing</h2>
      <p class="mt-3 text-gray-500">Transparent plans for every stage of growth</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ($plans as $plan) : ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-lg transition-shadow fade-in">
          <h3 class="text-lg font-semibold text-primary-600 mb-2"><?= $plan['name'] ?></h3>
          <div class="text-3xl font-bold text-gray-900 mb-1"><?= currency_format($plan['final_price']) ?></div>
          <p class="text-sm text-gray-500 mb-4">/ <?= duration_type($plan['name'], $plan['duration_type'], $plan['duration'], false) ?></p>
          <p class="text-sm text-gray-600 mb-5"><?= $plan['description'] ?></p>
          <ul class="space-y-2 text-sm text-gray-600 mb-6">
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <?= plan_message('brand', $plan['brand']) ?>
            </li>
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <?= plan_message('device', $plan['device']) ?>
            </li>
            <li class="flex items-center gap-2">
              <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
              <?= plan_message('transaction', $plan['transaction']) ?>
            </li>
          </ul>
          <a href="<?= user_url('plans') ?>" class="block w-full text-center py-2.5 px-4 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">Get Started</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="py-16 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-10">
      <h2 class="text-3xl font-bold text-gray-900">Supported Platforms & Gateways</h2>
      <p class="mt-3 text-gray-500">Integrate with the tools you already use</p>
    </div>
    <div class="overflow-hidden">
      <div class="logo-marquee">
        <?php
        $platLogos = [
          ['src' => 'public/assets/plat/smm.png', 'alt' => 'SMM'],
          ['src' => 'public/assets/plat/php.png', 'alt' => 'PHP'],
          ['src' => 'public/assets/plat/javascript.png', 'alt' => 'JavaScript'],
          ['src' => 'public/assets/plat/jquery.png', 'alt' => 'jQuery'],
          ['src' => 'public/assets/plat/nodejs.png', 'alt' => 'Node.js'],
          ['src' => 'public/assets/plat/whmcs-logo.png', 'alt' => 'WHMCS'],
          ['src' => 'public/assets/plat/woocommerce-logo-transparent.png', 'alt' => 'WooCommerce'],
          ['src' => 'public/assets/plat/wordpress-logo-stacked-rgb.png', 'alt' => 'WordPress'],
        ];
        for ($i = 0; $i < 2; $i++) :
          foreach ($platLogos as $logo) : ?>
            <img src="<?= $logo['src'] ?>" alt="<?= $logo['alt'] ?>" class="h-10 lg:h-12 object-contain grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100 flex-shrink-0">
          <?php endforeach;
        endfor; ?>
      </div>
    </div>

    <?php if (!empty($payments)) : ?>
    <div class="overflow-hidden mt-6">
      <div class="logo-marquee" style="animation-direction:reverse;">
        <?php for ($i = 0; $i < 2; $i++) :
          foreach ($payments as $payment) : ?>
            <img src="<?= base_url() . @get_value(get_value($payment['params'], 'option'), 'logo'); ?>" class="h-10 lg:h-12 object-contain grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100 flex-shrink-0" alt="">
          <?php endforeach;
        endfor; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php if (!empty($items)) : ?>
<section class="py-16 lg:py-24 bg-gray-50" x-data>
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-12">
      <h2 class="text-3xl font-bold text-gray-900">Frequently Asked Questions</h2>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
      <?php
      $firstCol = array_slice($items, 0, ceil(count($items) / 2));
      $secondCol = array_slice($items, ceil(count($items) / 2));
      ?>
      <div class="space-y-4">
        <?php foreach ($firstCol as $key => $item) : ?>
          <div x-data="{ open: <?= $key === 0 ? 'true' : 'false' ?> }" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-4 text-left">
              <span class="text-sm font-medium text-gray-900"><?= $item['question'] ?></span>
              <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 transition-transform flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse>
              <div class="px-5 pb-4 text-sm text-gray-600"><?= $item['answer'] ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="space-y-4">
        <?php foreach ($secondCol as $item) : ?>
          <div x-data="{ open: false }" class="bg-white rounded-xl border border-gray-200 overflow-hidden">
            <button @click="open = !open" class="flex items-center justify-between w-full px-5 py-4 text-left">
              <span class="text-sm font-medium text-gray-900"><?= $item['question'] ?></span>
              <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 transition-transform flex-shrink-0 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse>
              <div class="px-5 pb-4 text-sm text-gray-600"><?= $item['answer'] ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="relative bg-gradient-to-br from-primary-600 to-indigo-800 text-white py-16">
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    <h2 class="text-3xl font-bold mb-4 fade-in">Ready to Accept Payments?</h2>
    <p class="text-lg text-white/80 mb-8 fade-in" style="animation-delay:.1s">Create your free account and start integrating in minutes.</p>
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 fade-in" style="animation-delay:.2s">
      <a href="<?= base_url('sign-up') ?>" class="inline-flex items-center px-6 py-3 bg-white text-gray-900 font-semibold rounded-lg hover:bg-gray-100 transition-colors">Create Free Account</a>
      <a href="<?= base_url('developers') ?>" class="inline-flex items-center px-6 py-3 border-2 border-white/30 text-white font-semibold rounded-lg hover:bg-white/10 transition-colors">View API Docs</a>
    </div>
  </div>
</section>

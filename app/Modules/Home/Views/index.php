<?php $siteName = site_config('site_name', 'QPay'); ?>

<section class="relative min-h-[90vh] flex items-center overflow-hidden bg-[#0a0a1a]">
  <div class="absolute inset-0">
    <div class="absolute top-[-20%] left-[-10%] w-[600px] h-[600px] rounded-full bg-gradient-to-br from-indigo-600/30 to-purple-600/20 blur-[120px] animate-pulse-slow"></div>
    <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] rounded-full bg-gradient-to-tl from-blue-600/20 to-cyan-400/10 blur-[120px] animate-pulse-slow" style="animation-delay:2s"></div>
    <div class="absolute top-[30%] right-[20%] w-[300px] h-[300px] rounded-full bg-gradient-to-bl from-violet-500/15 to-pink-500/10 blur-[100px] animate-pulse-slow" style="animation-delay:4s"></div>
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMSIgY3k9IjEiIHI9IjAuNSIgZmlsbD0icmdiYSgyNTUsMjU1LDI1NSwwLjAzKSIvPjwvc3ZnPg==')] opacity-60"></div>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
      <div>
        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/5 border border-white/10 text-sm text-indigo-300 mb-6 reveal-up">
          <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
          Trusted by 1,900+ merchants in Bangladesh
        </div>
        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-white leading-[1.1] tracking-tight mb-6 reveal-up" style="animation-delay:.1s">
          The Payment
          <span class="bg-gradient-to-r from-indigo-400 via-purple-400 to-cyan-400 bg-clip-text text-transparent"> Infrastructure </span>
          for South Asia
        </h1>
        <p class="text-lg text-gray-400 leading-relaxed mb-8 max-w-lg reveal-up" style="animation-delay:.2s">
          One API to accept bKash, Nagad, Rocket, bank transfers, and cards. Built for developers who need reliability at scale.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 reveal-up" style="animation-delay:.3s">
          <a href="<?= base_url('sign-up') ?>" class="group inline-flex items-center justify-center gap-2 px-7 py-3.5 bg-white text-gray-900 font-semibold rounded-xl hover:shadow-lg hover:shadow-white/10 transition-all duration-300 hover:-translate-y-0.5">
            Start Integrating
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
          </a>
          <a href="#contact-sales" class="inline-flex items-center justify-center gap-2 px-7 py-3.5 border border-white/20 text-white font-semibold rounded-xl hover:bg-white/5 transition-all duration-300">
            Contact Sales
          </a>
        </div>
        <div class="flex items-center gap-6 mt-10 reveal-up" style="animation-delay:.4s">
          <div class="flex -space-x-2">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 border-2 border-[#0a0a1a] flex items-center justify-center text-white text-xs font-bold">R</div>
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-500 to-emerald-600 border-2 border-[#0a0a1a] flex items-center justify-center text-white text-xs font-bold">P</div>
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-amber-500 to-orange-600 border-2 border-[#0a0a1a] flex items-center justify-center text-white text-xs font-bold">A</div>
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-600 border-2 border-[#0a0a1a] flex items-center justify-center text-white text-xs font-bold">S</div>
          </div>
          <p class="text-sm text-gray-500"><span class="text-white font-medium">4.9/5</span> from 200+ reviews</p>
        </div>
      </div>

      <div class="reveal-up hidden lg:block" style="animation-delay:.3s">
        <div class="relative">
          <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500/20 via-purple-500/20 to-cyan-500/20 rounded-2xl blur-xl"></div>
          <div class="relative bg-[#111827]/80 backdrop-blur-xl rounded-2xl border border-white/10 overflow-hidden">
            <div class="flex items-center gap-2 px-4 py-3 border-b border-white/5">
              <div class="w-3 h-3 rounded-full bg-red-500/80"></div>
              <div class="w-3 h-3 rounded-full bg-yellow-500/80"></div>
              <div class="w-3 h-3 rounded-full bg-green-500/80"></div>
              <span class="ml-2 text-xs text-gray-500 font-mono">payment.js</span>
            </div>
            <div class="p-5">
<pre class="text-sm leading-relaxed font-mono overflow-x-auto"><code><span class="text-purple-400">const</span> <span class="text-blue-300">payment</span> <span class="text-white">=</span> <span class="text-purple-400">await</span> <span class="text-yellow-300">qpay</span><span class="text-white">.</span><span class="text-green-300">createPayment</span><span class="text-white">({</span>
  <span class="text-cyan-300">amount</span><span class="text-white">:</span> <span class="text-orange-300">500</span><span class="text-white">,</span>
  <span class="text-cyan-300">currency</span><span class="text-white">:</span> <span class="text-green-300">'BDT'</span><span class="text-white">,</span>
  <span class="text-cyan-300">customer_email</span><span class="text-white">:</span> <span class="text-green-300">'john@example.com'</span><span class="text-white">,</span>
  <span class="text-cyan-300">success_url</span><span class="text-white">:</span> <span class="text-green-300">'https://shop.com/success'</span><span class="text-white">,</span>
<span class="text-white">});</span>

<span class="text-gray-500">// Redirect to hosted checkout</span>
<span class="text-yellow-300">window</span><span class="text-white">.</span><span class="text-cyan-300">location</span> <span class="text-white">=</span> <span class="text-blue-300">payment</span><span class="text-white">.</span><span class="text-cyan-300">checkout_url</span><span class="text-white">;</span></code></pre>
            </div>
            <div class="px-5 pb-5">
              <div class="bg-green-500/10 border border-green-500/20 rounded-lg px-4 py-3">
                <div class="flex items-center gap-2">
                  <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  <span class="text-green-400 text-sm font-medium">Payment created successfully</span>
                </div>
                <p class="text-green-400/70 text-xs mt-1 font-mono">pay_a1b2c3d4e5f6 &middot; BDT 500.00</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="relative py-2 bg-[#0a0a1a] overflow-hidden">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex items-center justify-center gap-8 flex-wrap opacity-40">
      <p class="text-xs text-gray-500 uppercase tracking-widest font-medium">Integrated with</p>
      <?php
      $platLogos = [
        ['src' => 'public/assets/plat/php.png', 'alt' => 'PHP'],
        ['src' => 'public/assets/plat/nodejs.png', 'alt' => 'Node.js'],
        ['src' => 'public/assets/plat/woocommerce-logo-transparent.png', 'alt' => 'WooCommerce'],
        ['src' => 'public/assets/plat/wordpress-logo-stacked-rgb.png', 'alt' => 'WordPress'],
        ['src' => 'public/assets/plat/whmcs-logo.png', 'alt' => 'WHMCS'],
      ];
      foreach ($platLogos as $logo) : ?>
        <img src="<?= $logo['src'] ?>" alt="<?= $logo['alt'] ?>" class="h-7 lg:h-8 object-contain grayscale invert opacity-70" loading="lazy">
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-24 lg:py-32 bg-white relative overflow-hidden" x-data="{ counts: { merchants: 0, methods: 0, volume: 0, uptime: 0 }, started: false }"
  x-intersect.once="started = true;
    let m = setInterval(() => { counts.merchants = Math.min(counts.merchants + 37, 1963); if(counts.merchants >= 1963) clearInterval(m); }, 30);
    let p = setInterval(() => { counts.methods = Math.min(counts.methods + 1, 12); if(counts.methods >= 12) clearInterval(p); }, 80);
    let v = setInterval(() => { counts.volume = Math.min(counts.volume + 61234, 3287490); if(counts.volume >= 3287490) clearInterval(v); }, 20);
    let u = setInterval(() => { counts.uptime = Math.min(+(counts.uptime + 1.8).toFixed(1), 99.9); if(counts.uptime >= 99.9) clearInterval(u); }, 30);
  ">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8 mb-20">
      <div class="text-center scroll-reveal">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 tabular-nums" x-text="counts.merchants.toLocaleString() + '+'">0</div>
        <p class="mt-2 text-sm font-medium text-gray-500">Active Merchants</p>
      </div>
      <div class="text-center scroll-reveal">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 tabular-nums" x-text="counts.methods">0</div>
        <p class="mt-2 text-sm font-medium text-gray-500">Payment Methods</p>
      </div>
      <div class="text-center scroll-reveal">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 tabular-nums" x-text="'BDT ' + counts.volume.toLocaleString()">0</div>
        <p class="mt-2 text-sm font-medium text-gray-500">Total Volume Processed</p>
      </div>
      <div class="text-center scroll-reveal">
        <div class="text-4xl lg:text-5xl font-bold text-gray-900 tabular-nums" x-text="counts.uptime + '%'">0</div>
        <p class="mt-2 text-sm font-medium text-gray-500">Uptime SLA</p>
      </div>
    </div>

    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 scroll-reveal">Why businesses choose <?= $siteName ?></h2>
      <p class="mt-4 text-lg text-gray-500 max-w-2xl mx-auto scroll-reveal">Everything you need to accept payments at scale in South Asia</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
      <div class="group relative bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl hover:shadow-gray-100/50 transition-all duration-500 scroll-reveal border border-transparent hover:border-gray-100">
        <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Single API Integration</h3>
        <p class="text-gray-600 text-sm leading-relaxed">One REST API to connect bKash, Nagad, Rocket, bank transfers, and card payments. No provider-specific code required.</p>
      </div>

      <div class="group relative bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl hover:shadow-gray-100/50 transition-all duration-500 scroll-reveal border border-transparent hover:border-gray-100">
        <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Bank-Grade Security</h3>
        <p class="text-gray-600 text-sm leading-relaxed">HMAC-SHA256 webhook signatures, API key authentication, IP whitelisting, and built-in rate limiting protect every transaction.</p>
      </div>

      <div class="group relative bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl hover:shadow-gray-100/50 transition-all duration-500 scroll-reveal border border-transparent hover:border-gray-100">
        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Real-Time Verification</h3>
        <p class="text-gray-600 text-sm leading-relaxed">Automatic SMS-based payment verification with instant webhook callbacks. Know the status of every transaction in real time.</p>
      </div>

      <div class="group relative bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl hover:shadow-gray-100/50 transition-all duration-500 scroll-reveal border border-transparent hover:border-gray-100">
        <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Developer-First</h3>
        <p class="text-gray-600 text-sm leading-relaxed">Comprehensive docs with code samples in PHP, Node.js, Python, and Go. SDKs and plugins for WordPress, WooCommerce, and WHMCS.</p>
      </div>

      <div class="group relative bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl hover:shadow-gray-100/50 transition-all duration-500 scroll-reveal border border-transparent hover:border-gray-100">
        <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Multi-Brand Support</h3>
        <p class="text-gray-600 text-sm leading-relaxed">Run multiple brands from a single account. Separate API keys, payment methods, and fee structures per brand.</p>
      </div>

      <div class="group relative bg-gray-50 rounded-2xl p-8 hover:bg-white hover:shadow-xl hover:shadow-gray-100/50 transition-all duration-500 scroll-reveal border border-transparent hover:border-gray-100">
        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Invoice & Payment Links</h3>
        <p class="text-gray-600 text-sm leading-relaxed">Generate and share payment links and invoices via email. Collect payments without needing a website or online store.</p>
      </div>
    </div>
  </div>
</section>

<section class="py-24 lg:py-32 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 scroll-reveal">Accept payments in three steps</h2>
      <p class="mt-4 text-lg text-gray-500 scroll-reveal">Go from zero to accepting payments in minutes, not weeks</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
      <div class="relative scroll-reveal">
        <div class="bg-white rounded-2xl p-8 border border-gray-100 h-full">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 text-white flex items-center justify-center text-lg font-bold mb-5 shadow-lg shadow-indigo-500/25">1</div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Create Payment</h3>
          <p class="text-gray-600 mb-5">POST to <code class="text-indigo-600 bg-indigo-50 px-1.5 py-0.5 rounded text-sm font-medium">/api/v1/payment/create</code> with amount, currency, and callback URLs.</p>
          <div class="bg-gray-900 rounded-xl p-4 overflow-x-auto">
<pre class="text-xs leading-relaxed"><code><span class="text-green-400">curl</span> <span class="text-cyan-300">-X POST</span> <span class="text-yellow-300">/api/v1/payment/create</span> \
  <span class="text-cyan-300">-H</span> <span class="text-green-300">"API-KEY: sk_live_***"</span> \
  <span class="text-cyan-300">-d</span> <span class="text-green-300">'{"amount": 500}'</span></code></pre>
          </div>
        </div>
        <div class="hidden lg:block absolute top-1/2 -right-4 z-10">
          <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </div>
      </div>

      <div class="relative scroll-reveal">
        <div class="bg-white rounded-2xl p-8 border border-gray-100 h-full">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-amber-500 to-orange-500 text-white flex items-center justify-center text-lg font-bold mb-5 shadow-lg shadow-amber-500/25">2</div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Customer Pays</h3>
          <p class="text-gray-600 mb-5">Redirect to the hosted checkout page. Customers choose bKash, Nagad, Rocket, or cards and pay securely.</p>
          <div class="bg-gray-50 rounded-xl p-4 border border-gray-200">
            <div class="flex items-center gap-3 mb-3">
              <div class="w-8 h-8 rounded bg-pink-500 flex items-center justify-center text-white text-xs font-bold">b</div>
              <span class="text-sm font-medium text-gray-700">bKash</span>
              <div class="ml-auto w-4 h-4 rounded-full border-2 border-indigo-500 flex items-center justify-center"><div class="w-2 h-2 rounded-full bg-indigo-500"></div></div>
            </div>
            <div class="flex items-center gap-3 mb-3 opacity-50">
              <div class="w-8 h-8 rounded bg-orange-500 flex items-center justify-center text-white text-xs font-bold">N</div>
              <span class="text-sm font-medium text-gray-700">Nagad</span>
            </div>
            <div class="flex items-center gap-3 opacity-50">
              <div class="w-8 h-8 rounded bg-purple-600 flex items-center justify-center text-white text-xs font-bold">R</div>
              <span class="text-sm font-medium text-gray-700">Rocket</span>
            </div>
          </div>
        </div>
        <div class="hidden lg:block absolute top-1/2 -right-4 z-10">
          <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5l7 7-7 7"/></svg>
        </div>
      </div>

      <div class="scroll-reveal">
        <div class="bg-white rounded-2xl p-8 border border-gray-100 h-full">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-500 to-emerald-500 text-white flex items-center justify-center text-lg font-bold mb-5 shadow-lg shadow-green-500/25">3</div>
          <h3 class="text-xl font-semibold text-gray-900 mb-3">Verify & Settle</h3>
          <p class="text-gray-600 mb-5">Verify via API or receive a webhook. Funds settle to your account automatically after verification.</p>
          <div class="bg-green-50 border border-green-200 rounded-xl p-4">
            <div class="flex items-center gap-2 mb-2">
              <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"/></svg>
              <span class="text-sm font-semibold text-green-800">Payment Completed</span>
            </div>
            <p class="text-xs text-green-700 font-mono">BDT 500.00 &middot; bKash &middot; pay_a1b2c3d4</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($plans)) : ?>
<section class="py-24 lg:py-32 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 scroll-reveal">Transparent pricing</h2>
      <p class="mt-4 text-lg text-gray-500 scroll-reveal">Plans that scale with your business. No hidden fees.</p>
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
      <?php foreach ($plans as $i => $plan) : ?>
        <div class="relative bg-white rounded-2xl border border-gray-200 p-7 hover:border-indigo-200 hover:shadow-xl hover:shadow-indigo-100/30 transition-all duration-500 scroll-reveal <?= $i === 1 ? 'ring-2 ring-indigo-500 ring-offset-2' : '' ?>">
          <?php if ($i === 1) : ?>
            <div class="absolute -top-3 left-1/2 -translate-x-1/2 px-3 py-0.5 bg-indigo-600 text-white text-xs font-semibold rounded-full">Popular</div>
          <?php endif; ?>
          <h3 class="text-lg font-semibold text-indigo-600 mb-2"><?= $plan['name'] ?></h3>
          <div class="text-3xl font-bold text-gray-900 mb-1"><?= currency_format($plan['final_price']) ?></div>
          <p class="text-sm text-gray-500 mb-5">/ <?= duration_type($plan['name'], $plan['duration_type'], $plan['duration'], false) ?></p>
          <p class="text-sm text-gray-600 mb-5"><?= $plan['description'] ?></p>
          <ul class="space-y-3 text-sm text-gray-600 mb-7">
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
          <a href="<?= user_url('plans') ?>" class="block w-full text-center py-2.5 px-4 <?= $i === 1 ? 'bg-indigo-600 text-white hover:bg-indigo-700' : 'bg-gray-100 text-gray-900 hover:bg-gray-200' ?> text-sm font-semibold rounded-xl transition-colors">Get Started</a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="py-24 lg:py-32 bg-gray-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 scroll-reveal">Supported platforms &amp; gateways</h2>
      <p class="mt-4 text-lg text-gray-500 scroll-reveal">Integrate with the tools you already use</p>
    </div>
    <div class="overflow-hidden">
      <div class="logo-marquee">
        <?php
        $platLogos = [
          ['src' => 'public/assets/plat/smm.png', 'alt' => 'SMM Panel'],
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
            <img src="<?= $logo['src'] ?>" alt="<?= $logo['alt'] ?>" class="h-10 lg:h-12 object-contain grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100 flex-shrink-0" loading="lazy">
          <?php endforeach;
        endfor; ?>
      </div>
    </div>
    <?php if (!empty($payments)) : ?>
    <div class="overflow-hidden mt-6">
      <div class="logo-marquee" style="animation-direction:reverse;">
        <?php for ($i = 0; $i < 2; $i++) :
          foreach ($payments as $payment) : ?>
            <img src="<?= base_url() . @get_value(get_value($payment['params'], 'option'), 'logo'); ?>" class="h-10 lg:h-12 object-contain grayscale hover:grayscale-0 transition-all opacity-60 hover:opacity-100 flex-shrink-0" alt="" loading="lazy">
          <?php endforeach;
        endfor; ?>
      </div>
    </div>
    <?php endif; ?>
  </div>
</section>

<section class="py-24 lg:py-32 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 scroll-reveal">What our merchants say</h2>
      <p class="mt-4 text-lg text-gray-500 scroll-reveal">Trusted by businesses across South Asia</p>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
      <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 scroll-reveal">
        <div class="flex items-center gap-1 mb-5">
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        </div>
        <p class="text-gray-700 mb-6 leading-relaxed">"<?= $siteName ?> simplified our payment integration. We went live with bKash and Nagad in under a day. The API documentation is excellent."</p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-bold text-sm">RH</div>
          <div>
            <p class="font-semibold text-gray-900 text-sm">Rakib Hasan</p>
            <p class="text-xs text-gray-500">E-commerce Owner</p>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 scroll-reveal">
        <div class="flex items-center gap-1 mb-5">
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        </div>
        <p class="text-gray-700 mb-6 leading-relaxed">"The unified API is a game-changer. One integration handles all local payment methods. Our checkout conversion improved significantly."</p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-pink-500 to-rose-600 flex items-center justify-center text-white font-bold text-sm">PS</div>
          <div>
            <p class="font-semibold text-gray-900 text-sm">Priya Sharma</p>
            <p class="text-xs text-gray-500">SaaS Founder</p>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 rounded-2xl p-8 border border-gray-100 scroll-reveal">
        <div class="flex items-center gap-1 mb-5">
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
          <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        </div>
        <p class="text-gray-700 mb-6 leading-relaxed">"Reliable, fast settlements and great support. <?= $siteName ?> handles thousands of our daily transactions without any issues."</p>
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center text-white font-bold text-sm">AR</div>
          <div>
            <p class="font-semibold text-gray-900 text-sm">Arif Rahman</p>
            <p class="text-xs text-gray-500">SMM Panel Operator</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php if (!empty($items)) : ?>
<section class="py-24 lg:py-32 bg-gray-50" x-data>
  <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="text-center mb-16">
      <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 scroll-reveal">Frequently asked questions</h2>
      <p class="mt-4 text-lg text-gray-500 scroll-reveal">Everything you need to know about <?= $siteName ?></p>
    </div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
      <?php
      $firstCol = array_slice($items, 0, ceil(count($items) / 2));
      $secondCol = array_slice($items, ceil(count($items) / 2));
      ?>
      <div class="space-y-4">
        <?php foreach ($firstCol as $key => $item) : ?>
          <div x-data="{ open: <?= $key === 0 ? 'true' : 'false' ?> }" class="bg-white rounded-2xl border border-gray-200 overflow-hidden scroll-reveal">
            <button @click="open = !open" class="flex items-center justify-between w-full px-6 py-5 text-left">
              <span class="text-sm font-semibold text-gray-900 pr-4"><?= $item['question'] ?></span>
              <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse>
              <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed"><?= $item['answer'] ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
      <div class="space-y-4">
        <?php foreach ($secondCol as $item) : ?>
          <div x-data="{ open: false }" class="bg-white rounded-2xl border border-gray-200 overflow-hidden scroll-reveal">
            <button @click="open = !open" class="flex items-center justify-between w-full px-6 py-5 text-left">
              <span class="text-sm font-semibold text-gray-900 pr-4"><?= $item['question'] ?></span>
              <svg :class="open ? 'rotate-180' : ''" class="w-5 h-5 text-gray-400 transition-transform duration-300 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse>
              <div class="px-6 pb-5 text-sm text-gray-600 leading-relaxed"><?= $item['answer'] ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section id="contact-sales" class="py-24 lg:py-32 bg-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
      <div class="scroll-reveal">
        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-6">Talk to our sales team</h2>
        <p class="text-lg text-gray-600 mb-8">Whether you're a startup or an enterprise, we'll help you find the right plan and get integrated fast.</p>
        <div class="space-y-6">
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Quick setup</h4>
              <p class="text-sm text-gray-600">Most merchants go live within 24 hours of signing up.</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-green-100 text-green-600 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Dedicated support</h4>
              <p class="text-sm text-gray-600">Get a dedicated account manager for enterprise plans.</p>
            </div>
          </div>
          <div class="flex items-start gap-4">
            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center flex-shrink-0">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
            </div>
            <div>
              <h4 class="font-semibold text-gray-900">Custom pricing</h4>
              <p class="text-sm text-gray-600">Volume-based pricing for high-transaction businesses.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="scroll-reveal">
        <?php if (session()->getFlashdata('sales_success')) : ?>
          <div class="bg-green-50 border border-green-200 rounded-2xl p-8 text-center">
            <svg class="w-16 h-16 text-green-500 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Thank you!</h3>
            <p class="text-gray-600">We've received your message and will get back to you within 24 hours.</p>
          </div>
        <?php else : ?>
          <?php if (session()->getFlashdata('sales_error')) : ?>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 text-sm text-red-700">
              <?= session()->getFlashdata('sales_error') ?>
            </div>
          <?php endif; ?>
          <?php if (session()->getFlashdata('errors')) : ?>
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4 text-sm text-red-700">
              <ul class="list-disc list-inside space-y-1">
                <?php foreach (session()->getFlashdata('errors') as $err) : ?>
                  <li><?= esc($err) ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>
          <form action="<?= base_url('contact-sales') ?>" method="POST" class="bg-gray-50 rounded-2xl border border-gray-200 p-8">
            <?= csrf_field() ?>
            <div class="space-y-5">
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                  <label for="sales_name" class="block text-sm font-medium text-gray-700 mb-1.5">Full Name</label>
                  <input type="text" id="sales_name" name="name" required class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="Your name">
                </div>
                <div>
                  <label for="sales_company" class="block text-sm font-medium text-gray-700 mb-1.5">Company</label>
                  <input type="text" id="sales_company" name="company" class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="Company name">
                </div>
              </div>
              <div>
                <label for="sales_email" class="block text-sm font-medium text-gray-700 mb-1.5">Work Email</label>
                <input type="email" id="sales_email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="you@company.com">
              </div>
              <div>
                <label for="sales_phone" class="block text-sm font-medium text-gray-700 mb-1.5">Phone Number</label>
                <input type="tel" id="sales_phone" name="phone" class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all" placeholder="+880 1XXX XXXXXX">
              </div>
              <div>
                <label for="sales_volume" class="block text-sm font-medium text-gray-700 mb-1.5">Monthly Transaction Volume</label>
                <select id="sales_volume" name="volume" class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all bg-white">
                  <option value="">Select range</option>
                  <option value="under_10k">Under BDT 10,000</option>
                  <option value="10k_100k">BDT 10,000 - 100,000</option>
                  <option value="100k_1m">BDT 100,000 - 1,000,000</option>
                  <option value="1m_plus">Over BDT 1,000,000</option>
                </select>
              </div>
              <div>
                <label for="sales_message" class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                <textarea id="sales_message" name="message" rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-300 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all resize-none" placeholder="Tell us about your business and what you need..."></textarea>
              </div>
              <button type="submit" class="w-full py-3.5 bg-indigo-600 text-white font-semibold rounded-xl hover:bg-indigo-700 transition-colors text-sm">Send Message</button>
              <p class="text-xs text-gray-500 text-center">We'll respond within 24 hours. No spam, ever.</p>
            </div>
          </form>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>

<section class="relative py-24 bg-[#0a0a1a] overflow-hidden">
  <div class="absolute inset-0">
    <div class="absolute top-[-20%] right-[-10%] w-[500px] h-[500px] rounded-full bg-gradient-to-br from-indigo-600/20 to-purple-600/10 blur-[120px]"></div>
    <div class="absolute bottom-[-20%] left-[-10%] w-[400px] h-[400px] rounded-full bg-gradient-to-tl from-cyan-500/15 to-blue-500/10 blur-[100px]"></div>
  </div>
  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
    <h2 class="text-3xl lg:text-4xl font-bold text-white mb-5 scroll-reveal">Ready to accept payments?</h2>
    <p class="text-lg text-gray-400 mb-10 max-w-xl mx-auto scroll-reveal">Create your free account and start integrating in minutes. No setup fees, no monthly minimums.</p>
    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 scroll-reveal">
      <a href="<?= base_url('sign-up') ?>" class="group inline-flex items-center gap-2 px-8 py-4 bg-white text-gray-900 font-semibold rounded-xl hover:shadow-lg hover:shadow-white/10 transition-all duration-300 hover:-translate-y-0.5">
        Create Free Account
        <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
      </a>
      <a href="<?= base_url('developers') ?>" class="inline-flex items-center gap-2 px-8 py-4 border border-white/20 text-white font-semibold rounded-xl hover:bg-white/5 transition-all duration-300">
        View API Docs
      </a>
    </div>
  </div>
</section>

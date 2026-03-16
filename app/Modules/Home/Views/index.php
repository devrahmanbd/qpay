<section id="hero" class="hero section dark-background">
  <div class="container">
    <div class="row gy-4 d-flex justify-content-between">
      <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
        <h1 data-aos="fade-up">Payment Infrastructure for South Asia</h1>
        <p data-aos="fade-up" data-aos-delay="100">A unified API to accept, process, and orchestrate payments across bKash, Nagad, Rocket, bank transfers, and more. Built for developers, trusted by businesses.</p>
        <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
          <a href="<?= base_url('sign-up') ?>" class="btn-get-started">Get API Keys <i class="bi bi-arrow-right"></i></a>
          <a href="<?= base_url('developers') ?>" class="btn-get-started ms-md-3 mt-3 mt-md-0" style="background:transparent;border:2px solid #fff;">Read the Docs <i class="bi bi-book"></i></a>
        </div>
      </div>
      <div class="col-lg-5 order-1 order-lg-2 hero-img" data-aos="zoom-out">
        <div class="p-4 rounded-4" style="background:rgba(255,255,255,0.08);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.15);">
<pre class="mb-0" style="color:#a5d6a7;font-size:13px;line-height:1.7;overflow-x:auto;"><code>curl -X POST <?= base_url('api/v1/payment/create') ?> \
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

<section id="values" class="values section">
  <div class="container" data-aos="fade-up">
    <div class="row gy-4">
      <div class="col-12 text-center mb-4">
        <h2 class="fw-bold">Why <?= site_config('site_name', 'QPay') ?>?</h2>
        <p class="text-muted">Everything you need to accept payments at scale</p>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 border-0 shadow-sm p-4">
          <div class="mb-3"><i class="bi bi-lightning-charge-fill fs-1 text-primary"></i></div>
          <h4>Single API Integration</h4>
          <p class="text-muted">One REST API to connect bKash, Nagad, Rocket, bank transfers, and card payments. No provider-specific code required.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 border-0 shadow-sm p-4">
          <div class="mb-3"><i class="bi bi-shield-lock-fill fs-1 text-success"></i></div>
          <h4>Idempotent & Secure</h4>
          <p class="text-muted">Built-in idempotency keys prevent duplicate charges. API-key authentication, IP whitelisting, and rate limiting protect every request.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
        <div class="card h-100 border-0 shadow-sm p-4">
          <div class="mb-3"><i class="bi bi-graph-up-arrow fs-1 text-warning"></i></div>
          <h4>Real-Time Verification</h4>
          <p class="text-muted">Automatic SMS-based payment verification with instant callback notifications. Know the status of every transaction in real time.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="400">
        <div class="card h-100 border-0 shadow-sm p-4">
          <div class="mb-3"><i class="bi bi-code-square fs-1 text-info"></i></div>
          <h4>Developer-First</h4>
          <p class="text-muted">Comprehensive API docs with code samples in PHP, Node.js, Python, and Go. SDKs and plugins for WordPress, WooCommerce, and WHMCS.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="500">
        <div class="card h-100 border-0 shadow-sm p-4">
          <div class="mb-3"><i class="bi bi-building fs-1 text-danger"></i></div>
          <h4>Multi-Brand Support</h4>
          <p class="text-muted">Run multiple brands from a single merchant account. Separate API keys, payment methods, and fee structures per brand.</p>
        </div>
      </div>

      <div class="col-lg-4" data-aos="fade-up" data-aos-delay="600">
        <div class="card h-100 border-0 shadow-sm p-4">
          <div class="mb-3"><i class="bi bi-receipt-cutoff fs-1 text-secondary"></i></div>
          <h4>Invoice & Billing</h4>
          <p class="text-muted">Generate payment links and invoices. Send them via email for quick collection without needing a website or online store.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="counts" class="counts section">
  <div class="container" data-aos="fade-up">
    <div class="row gy-4">
      <div class="col-lg-3 col-md-6">
        <div class="count-box">
          <i class="bi bi-people-fill"></i>
          <div>
            <span data-purecounter-start="0" data-purecounter-end="1963" data-purecounter-duration="1" class="purecounter"></span>
            <p>Merchants</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="count-box">
          <i class="bi bi-credit-card" style="color: #ee6c20;"></i>
          <div>
            <span data-purecounter-start="0" data-purecounter-end="12" data-purecounter-duration="1" class="purecounter"></span>
            <p>Payment Methods</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="count-box">
          <i class="bi bi-graph-up" style="color: #15be56;"></i>
          <div>
            <span data-purecounter-start="0" data-purecounter-end="3287490" data-purecounter-duration="1" class="purecounter"></span>
            <p>Total Volume (BDT)</p>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6">
        <div class="count-box">
          <i class="bi bi-clock-history" style="color: #bb0852;"></i>
          <div>
            <span data-purecounter-start="0" data-purecounter-end="99" data-purecounter-duration="1" class="purecounter"></span>
            <p>Uptime %</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="how-it-works" class="services section">
  <div class="container" data-aos="fade-up">
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h2 class="fw-bold">How It Works</h2>
        <p class="text-muted">Three steps to start accepting payments</p>
      </div>
    </div>
    <div class="row gy-4">
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="service-box blue">
          <div class="d-flex align-items-center mb-3">
            <span class="badge bg-primary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:18px;">1</span>
            <h3 class="mb-0">Create Payment</h3>
          </div>
          <p>POST to <code>/api/v1/payment/create</code> with amount, currency, and callback URLs. Receive a payment ID and checkout URL instantly.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="service-box orange">
          <div class="d-flex align-items-center mb-3">
            <span class="badge bg-warning text-dark rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:18px;">2</span>
            <h3 class="mb-0">Customer Pays</h3>
          </div>
          <p>Redirect your customer to the checkout URL. They choose their preferred payment method and complete the transaction securely.</p>
        </div>
      </div>
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
        <div class="service-box green">
          <div class="d-flex align-items-center mb-3">
            <span class="badge bg-success rounded-circle me-3 d-flex align-items-center justify-content-center" style="width:40px;height:40px;font-size:18px;">3</span>
            <h3 class="mb-0">Verify & Settle</h3>
          </div>
          <p>Call <code>/api/v1/payment/verify</code> to confirm the transaction. Funds settle to your account automatically after verification.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="pricing" class="pricing section">
  <div class="container" data-aos="fade-up">
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h2 class="fw-bold">Pricing</h2>
        <p class="text-muted">Transparent plans for every stage of growth</p>
      </div>
    </div>
    <div class="row gy-4" data-aos="fade-left">
      <?php if (!empty($plans)) : foreach ($plans as $plan) : ?>
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
          <div class="box">
            <h3 style="color: #07d5c0;"><?= $plan['name'] ?></h3>
            <div class="price"><sup></sup><?= currency_format($plan['final_price']) ?><span> / <?= duration_type($plan['name'], $plan['duration_type'], $plan['duration'], false) ?></span></div>
            <p class="text-center"><?= $plan['description'] ?></p>
            <ul>
              <li><?= plan_message('brand', $plan['brand']) ?></li>
              <li><?= plan_message('device', $plan['device']) ?></li>
              <li><?= plan_message('transaction', $plan['transaction']) ?></li>
            </ul>
            <a href="<?= user_url('plans') ?>" class="btn-buy">Get Started</a>
          </div>
        </div>
      <?php endforeach; endif; ?>
    </div>
  </div>
</section>

<section id="platforms" class="clients section">
  <div class="container" data-aos="fade-up">
    <div class="row mb-4">
      <div class="col-12 text-center">
        <h2 class="fw-bold">Supported Platforms & Gateways</h2>
        <p class="text-muted">Integrate with the tools you already use</p>
      </div>
    </div>
    <div class="clients-slider swiper">
      <div class="swiper-wrapper align-items-center">
        <div class="swiper-slide"><img src="public/assets/plat/smm.png" class="img-fluid" alt="SMM"></div>
        <div class="swiper-slide"><img src="public/assets/plat/php.png" class="img-fluid" alt="PHP"></div>
        <div class="swiper-slide"><img src="public/assets/plat/javascript.png" class="img-fluid" alt="JavaScript"></div>
        <div class="swiper-slide"><img src="public/assets/plat/jquery.png" class="img-fluid" alt="jQuery"></div>
        <div class="swiper-slide"><img src="public/assets/plat/nodejs.png" class="img-fluid" alt="Node.js"></div>
        <div class="swiper-slide"><img src="public/assets/plat/whmcs-logo.png" class="img-fluid" alt="WHMCS"></div>
        <div class="swiper-slide"><img src="public/assets/plat/woocommerce-logo-transparent.png" class="img-fluid" alt="WooCommerce"></div>
        <div class="swiper-slide"><img src="public/assets/plat/wordpress-logo-stacked-rgb.png" class="img-fluid" alt="WordPress"></div>
      </div>
      <div class="swiper-pagination"></div>
    </div>

    <?php if (!empty($payments)) : ?>
    <div class="clients-slider swiper mt-4">
      <div class="swiper-wrapper align-items-center">
        <?php foreach ($payments as $payment) : ?>
          <div class="swiper-slide"><img src="<?= base_url() . @get_value(get_value($payment['params'], 'option'), 'logo'); ?>" class="img-fluid" alt=""></div>
        <?php endforeach; ?>
      </div>
      <div class="swiper-pagination"></div>
    </div>
    <?php endif; ?>
  </div>
</section>

<?php if (!empty($items)) : ?>
<section id="faq" class="faq section">
  <div class="container" data-aos="fade-up">
    <div class="row mb-5">
      <div class="col-12 text-center">
        <h2 class="fw-bold">Frequently Asked Questions</h2>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="accordion accordion-flush" id="faqlist1">
          <?php
          $firstColumnItems = array_slice($items, 0, ceil(count($items) / 2));
          foreach ($firstColumnItems as $key => $item) : ?>
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
              <h2 class="accordion-header" id="m<?= $item['id'] ?>">
                <button class="accordion-button <?= $key == 0 ? '' : 'collapsed' ?>" type="button" data-bs-toggle="collapse" data-bs-target="#kkk<?= $item['id'] ?>" aria-expanded="<?= $key == 0 ? 'true' : 'false' ?>">
                  <?= $item['question'] ?>
                </button>
              </h2>
              <div id="kkk<?= $item['id'] ?>" class="accordion-collapse collapse <?= $key == 0 ? 'show' : '' ?>" data-bs-parent="#faqlist1">
                <div class="accordion-body"><?= $item['answer'] ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="accordion accordion-flush" id="faqlist2">
          <?php
          $secondColumnItems = array_slice($items, ceil(count($items) / 2));
          foreach ($secondColumnItems as $key => $item) : ?>
            <div class="accordion-item" data-aos="fade-up" data-aos-delay="100">
              <h2 class="accordion-header" id="m<?= $item['id'] ?>">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#kkk<?= $item['id'] ?>" aria-expanded="false">
                  <?= $item['question'] ?>
                </button>
              </h2>
              <div id="kkk<?= $item['id'] ?>" class="accordion-collapse collapse" data-bs-parent="#faqlist2">
                <div class="accordion-body"><?= $item['answer'] ?></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php endif; ?>

<section id="cta" class="section" style="background:linear-gradient(135deg,#0d6efd 0%,#6610f2 100%);padding:60px 0;">
  <div class="container text-center text-white">
    <h2 class="fw-bold mb-3" data-aos="fade-up">Ready to Accept Payments?</h2>
    <p class="mb-4" data-aos="fade-up" data-aos-delay="100">Create your free account and start integrating in minutes.</p>
    <div data-aos="fade-up" data-aos-delay="200">
      <a href="<?= base_url('sign-up') ?>" class="btn btn-light btn-lg me-2">Create Free Account</a>
      <a href="<?= base_url('developers') ?>" class="btn btn-outline-light btn-lg">View API Docs</a>
    </div>
  </div>
</section>

# QPay Development Roadmap

## Completed Tasks

### Task #1: Stripe-like API Key & Secret System ✅ COMPLETED
- [x] API key generation (pk_test_, sk_test_, pk_live_, sk_live_)
- [x] Key hashing and validation
- [x] Rate limiting (100 req/min live, 200 req/min test)
- [x] Webhook signing with HMAC-SHA256
- [x] Test mode with simulated payment adapter
- [x] Merchant API dashboard (keys, webhooks, logs)
- [x] Admin analytics dashboard

### Task #2: WordPress Plugin & Integration SDKs ✅ COMPLETED
- [x] PHP SDK (single-file, all methods, webhook verification)
- [x] Node.js SDK (CJS + ESM + TypeScript types)
- [x] WooCommerce plugin (gateway, settings, webhook handler, refunds)
- [x] API documentation page (Stripe-style reference)
- [x] Merchant dashboard SDK download page

### Sprint 1: API Resuscitation ✅ COMPLETED
- [x] Micro-Task 1.1: createPayment logic and route
- [x] Micro-Task 1.2: getMethods endpoint
- [x] Micro-Task 1.3: api_payments table migration

### Sprint 2: Security & Reliability ✅ COMPLETED
- [x] Micro-Task 2.1: Idempotency-Key support
- [x] Micro-Task 2.2: Validation rules for endpoints
- [x] Micro-Task 2.3: ApiAuth filter with database lookup

### Sprint 3: Adapter Pattern ✅ COMPLETED
- [x] Micro-Task 3.1: PaymentProviderInterface
- [x] Micro-Task 3.2: SmsVerificationAdapter, DirectApiAdapter
- [x] Micro-Task 3.3: PaymentProviderFactory pattern

### Sprint 4: Developer Experience ✅ COMPLETED
- [x] Micro-Task 4.1: Webhooks table and UI
- [x] Micro-Task 4.2: WebhookService with retry logic
- [x] Micro-Task 4.3: Test mode with TestPaymentAdapter

---

## Pending Tasks

### Task #3: Unified WordPress Plugin (Payment Buttons & Forms + Optional WooCommerce)
**Status**: NOT STARTED
**Priority**: HIGH
**Description**: Create a single "QPay for WordPress" plugin that works on any WordPress site with optional WooCommerce integration

#### 3.1: Core Plugin Setup
- [ ] Create `public/sdks/wordpress/qpay-payment/` directory structure
- [ ] Main plugin file with unified setup detection (WooCommerce optional)
- [ ] Settings page for API keys, webhook secret, test/live mode
- [ ] Feature toggle UI: enable/disable WooCommerce integration, payment forms, buttons

#### 3.2: Payment Buttons & Shortcodes
- [ ] `[qpay_button]` shortcode for quick payment buttons
- [ ] Shortcode attributes: amount, description, payment_method, success_url, cancel_url
- [ ] Button styling with inline CSS (Tailwind-compatible)
- [ ] AJAX payment creation via jQuery/Alpine.js

#### 3.3: Payment Forms
- [ ] `[qpay_form]` shortcode for full checkout forms
- [ ] Form fields: amount, customer name, email, phone, custom fields
- [ ] Form validation (client + server-side)
- [ ] Order storage in WordPress posts/custom tables

#### 3.4: Webhook Handling
- [ ] Unified webhook endpoint at `/wp-json/qpay/v1/webhook`
- [ ] Payment status update logic (pending, completed, failed)
- [ ] Email notifications on payment completion
- [ ] Webhook signature verification

#### 3.5: WooCommerce Integration (Conditional)
- [ ] Detect if WooCommerce is active
- [ ] Register WC_Payment_Gateway only if WooCommerce exists
- [ ] Reuse existing WooCommerce gateway code from Task #2
- [ ] Settings: merge WooCommerce options into unified settings page
- [ ] Order status mapping: payment.created → on-hold, completed → completed, failed → failed

#### 3.6: Admin Dashboard
- [ ] Transactions list (all payments from buttons, forms, WooCommerce)
- [ ] Transaction detail view (amount, status, customer, timestamp)
- [ ] Manual refund interface
- [ ] Test mode indicator on all pages

#### 3.7: Documentation & Downloads
- [ ] Plugin ZIP file for distribution
- [ ] Installation guide (manual upload + WordPress.org steps)
- [ ] Shortcode documentation on SDK dashboard
- [ ] Code examples for payment buttons and forms

---

### Sprint 5: Financial Integrity (The Double-Entry Ledger)
**Status**: NOT STARTED
**Priority**: MEDIUM
**Description**: Implement ledger-based accounting for merchant balances

- [ ] Micro-Task 5.1: Create ledger_entries table migration
  - Columns: id, merchant_id, account_type (merchant/system), amount, type (credit/debit), transaction_ref, created_at
- [ ] Micro-Task 5.2: Create LedgerService class
  - recordCredit($merchant_id, $amount, $transaction_id)
  - recordDebit($merchant_id, $amount, $transaction_id)
  - Atomically insert credit/debit on payment success
- [ ] Micro-Task 5.3: Update balance calculation
  - Create getMerchantBalance($merchant_id) helper
  - Calculate via ledger: SUM(credits) - SUM(debits)
  - Cache for performance (Redis or DB)

---

### Sprint 6: Infrastructure Separation (Zero-Downtime Migration)
**Status**: NOT STARTED
**Priority**: LOW
**Description**: Containerize and scale the payment API independently

- [ ] Micro-Task 6.1: Docker setup
  - Dockerfile for CodeIgniter 4 + PHP 8.2 FPM
  - docker-compose.yml with services: app, mariadb, redis
  - Build and push to container registry
  
- [ ] Micro-Task 6.2: Redis integration
  - Configure CI4 session handler: Redis
  - Configure caching backend: Redis
  - Update .env for REDIS_HOST, REDIS_PASSWORD
  
- [ ] Micro-Task 6.3: Queue system for background jobs
  - Set up Redis-backed queue (e.g., Bull/BullMQ for Node, or custom PHP queue)
  - Move webhook delivery to async queue
  - Move email notifications to queue
  - Add queue monitor/dashboard (optional)

---

## Summary

**Completed**: 6/12 major components (50%)
**In Progress**: Task #3 (WordPress unified plugin)
**Pending**: Sprint 5 (ledger), Sprint 6 (infrastructure)

**Next Step**: Build Task #3 (unified WordPress plugin with optional WooCommerce)

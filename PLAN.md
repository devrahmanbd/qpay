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

### Task #3: Unified WordPress Plugin ✅ COMPLETED
- [x] Core plugin setup (`public/sdks/wordpress/qpay-wordpress/`)
- [x] QPay SDK class for API communication
- [x] Custom DB tables (qpay_transactions, qpay_forms)
- [x] Admin settings page with API keys, test mode, feature toggles
- [x] `[qpay_button]` shortcode (amount, currency, label, description, method, success/cancel URLs)
- [x] `[qpay_form]` shortcode (name, email, phone, amount, description fields + saved forms by ID)
- [x] `[qpay_donate]` shortcode (preset amounts, custom amount, donor info)
- [x] Form builder admin page (create/edit/delete reusable forms)
- [x] AJAX payment creation with checkout redirect
- [x] Unified webhook handler (signature verification, transaction + WooCommerce support)
- [x] Email notifications (admin + customer on payment completion/failure/refund)
- [x] Transaction management admin page (list, filter, search, detail view, refund)
- [x] WooCommerce gateway (optional, auto-detected, shared API keys from QPay settings)
- [x] QPay Merchant role with custom capabilities
- [x] Frontend CSS (buttons, forms, donation presets, test badges)
- [x] Frontend JS (AJAX handlers, form validation, preset amount selection)
- [x] Admin CSS (settings cards, stats row, transaction badges, detail grid)
- [x] Plugin ZIP package for distribution
- [x] Merchant dashboard SDK page updated (WordPress plugin featured as recommended)

---

### Task #4: Testing & Sandboxing ✅ COMPLETED
**Status**: COMPLETED
**Priority**: HIGH
**Description**: Systematic testing of all platform features, bug fixes, and sandbox validation

#### 4.1: Sandbox Environment Validation ✅
- [x] Test mode API key authentication (sk_test_*, pk_test_*)
- [x] Test payment creation (processing, declined, insufficient funds)
- [x] Test payment verification and status endpoints
- [x] Test refund flow in sandbox mode
- [x] Test balance endpoint with test transactions
- [x] Checkout page renders proper payment UI (was returning raw JSON — fixed)
- [x] Checkout process flow works for test mode payments
- [x] Test mode banner displays on checkout page

#### 4.2: API Endpoint Testing ✅
- [x] POST /api/v1/payment/create — correct response format
- [x] GET /api/v1/payment/verify/:id — returns verified status
- [x] GET /api/v1/payment/status/:id — returns current status
- [x] GET /api/v1/payments — lists payments with pagination
- [x] POST /api/v1/refunds — processes refund correctly
- [x] GET /api/v1/balance — returns available/pending/refunded
- [x] GET /api/v1/payment/methods — lists all payment methods with brand info
- [x] Invalid/missing API key returns proper error responses

#### 4.3: Frontend & Dashboard Bug Fixes ✅
- [x] Dashboard JSON parse error fixed (used CI4 Response object instead of echo)
- [x] Admin dashboard same JSON fix applied
- [x] Checkout page built with proper payment method UI, status views
- [x] Checkout process endpoint added for test mode payments
- [x] Webhook firing on checkout completion

#### 4.4: Public Pages Validation ✅
- [x] Homepage (/) — 200 OK
- [x] Sign-in (/sign-in) — 200 OK, form renders correctly
- [x] Register (/register) — 200 OK
- [x] Blog (/blog) — 200 OK
- [x] Developers hub (/developers) — 200 OK
- [x] API Docs (/developers/docs) — 200 OK with full Stripe-style reference
- [x] SDK download (WordPress ZIP) — 200 OK

#### 4.5: Known Non-Issues (Cosmetic)
- Alpine.js x-collapse plugin warning — harmless, FAQ accordion cosmetic
- Tailwind CDN warning — expected in development, not production

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

**Completed**: 8/10 major components (80%)
**Pending**: Sprint 5 (ledger), Sprint 6 (infrastructure)

**Next Step**: Sprint 5 (double-entry ledger for merchant balances)

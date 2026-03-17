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

**Completed**: 7/9 major components (78%)
**Pending**: Sprint 5 (ledger), Sprint 6 (infrastructure)

**Next Step**: Sprint 5 (double-entry ledger for merchant balances)

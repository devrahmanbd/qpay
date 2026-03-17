# QPay - Payment Gateway Platform

## Overview
QPay is a payment gateway/orchestrator for South Asian markets (Bangladesh). It provides unified checkout for MFS providers (bKash, Nagad, Rocket) and banks.

## Architecture
- **Framework**: CodeIgniter 4 (PHP 8.2)
- **Database**: MariaDB 10.11 (socket: `/tmp/mysql.sock`, db: `main`, user: `root`, pass: see start.sh)
- **Server**: PHP built-in server on port 5000 with `router.php` for static file serving
- **Startup**: `start.sh` handles MariaDB init, table creation, migrations, and PHP server launch

## Frontend Architecture (Tailwind CSS + Alpine.js)

### Layout System
The template system (`app/Libraries/Template.php`) routes through `app/Views/layouts/template.php`:
- **`general.php`** — Public pages (home, blogs, terms, privacy, developers, docs). Pure Tailwind CSS + Alpine.js.
- **`auth.php`** — Sign-in, sign-up, password reset, activation, change password (user + admin). Pure Tailwind + Alpine.js.
- **`user/main.blade.php`** — User dashboard. Tailwind CDN + Alpine.js + qpay-alpine.js. No Bootstrap/jQuery.
- **`admin/main.blade.php`** — Admin dashboard. Tailwind CDN + Alpine.js + qpay-alpine.js. No Bootstrap/jQuery.
- **`docs.php`** — Developer API documentation layout (separate from dashboards, retains its own CSS/JS).

### JavaScript Stack
- **`public/assets/js/qpay-alpine.js`** — Unified vanilla JS + Alpine.js utility layer for both dashboards. Replaces all legacy jQuery scripts (process.js, process2.js, general.js, admin.js, blithe.js). Provides:
  - `qpost()` — fetch-based AJAX helper with auto CSRF token injection
  - `notify()` — Toast notification system (pure CSS/JS, XSS-safe via textContent)
  - `pageOverlay` — Loading overlay component
  - Form handlers: `actionForm`, file upload, clipboard copy
  - Click handlers: `ajaxDeleteItem`, `ajaxToggleItemStatus`, `ajaxModal` (modal system)
  - Search, bulk actions, notification polling
  - Sortable table rows (vanilla JS drag-and-drop)
- Auth pages (`auth.php` layout) use inline Alpine.js — no external JS file needed.

### Modal System
- `openModal(url)` / `closeModal()` functions in qpay-alpine.js
- `.ajaxModal` class on links triggers modal open on click
- Modal templates: `app/Views/layouts/common/modal/modal_top.php` and `modal_bottom.php`
- Update/edit views use `modal_buttons()` helper for consistent submit/cancel buttons

### CDN Dependencies
- Tailwind CSS: `https://cdn.tailwindcss.com` (dev CDN, production should use build step)
- Alpine.js: `https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js`
- Alpine Collapse plugin: `https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js` (for FAQ accordions)

### Tailwind Config
Custom colors used across layouts:
```js
primary: { 50-900 indigo shades from #eef2ff to #312e81 }
sidebar: { bg: '#1e293b', hover: '#334155', active: '#4f46e5' }
```

### Helper Functions (Tailwind)
- `partials_helper.php` — `show_page_header`, `show_page_header_filter`, `show_item_status` (Tailwind toggle switches), `render_table_thead`, `show_item_button_action`, `show_pagination`, `show_empty_item`, `show_bulk_btn_action`
- `form_template_helper.php` — `modal_buttons()` (Tailwind submit/cancel), `render_element_form()` / `render_elements_form()` with Tailwind classes (`w-full`, `w-full md:w-1/2 px-2`)
- `app_helper.php` — General application helpers including `plan_message()` and `duration_type()`

### View Patterns
- **Table index views**: Wrap in `bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden`
- **Settings elements**: Same card pattern with `content` class
- **Update/modal views**: Use `flex flex-wrap -mx-2` for form element containers
- **Toggle switches**: SR-only peer pattern (no jQuery)
- **Alpine.js data**: Used for interactive UI (e.g., `x-data="{protocol:...}"` in email settings)

## Key Directories
```
app/
├── Adapters/
│   ├── DirectApiAdapter.php      # Direct API payment adapter
│   ├── SmsVerificationAdapter.php # SMS-based payment verification
│   └── TestPaymentAdapter.php    # Test mode payment adapter (simulates success/decline)
├── Config/
│   ├── App.php            # Auto-detects base_url from HTTP_HOST (forces HTTPS for .replit.dev proxy)
│   ├── Database.php       # DB credentials
│   ├── Filters.php        # Includes api_auth filter
│   ├── Routes.php         # Legacy + API v1 routes
│   └── Site_config.php    # HTTPS redirect config
├── Controllers/
│   ├── ApiController.php  # Legacy device/SMS endpoints
│   └── Api/V1/
│       └── PaymentController.php  # Stripe-style REST API
├── Database/Migrations/   # CI4 migrations for api_keys, webhooks, webhook_events, api_logs, api_payments alterations
├── Filters/
│   └── ApiAuth.php        # API authentication filter (new pk/sk keys + legacy fallback, rate limiting)
├── Helpers/
│   ├── app_helper.php     # General helpers
│   ├── partials_helper.php # UI component helpers (Tailwind)
│   └── form_template_helper.php # Form helpers (Tailwind)
├── Libraries/
│   ├── ApiKeyService.php  # Stripe-style key generation, validation, rotation, revocation
│   ├── ApiLogger.php      # API request logging and stats (merchant + admin)
│   ├── WebhookService.php # Webhook event dispatch, HMAC-SHA256 signing, retry logic
│   ├── PaymentProviderFactory.php # Payment provider selection
│   └── Template.php       # View templating engine
├── Modules/
│   ├── Admin/
│   │   ├── Controllers/ApiAnalyticsController.php  # Admin API usage analytics
│   │   └── Views/api/index.php                     # Admin API analytics dashboard view
│   ├── Blocks/Views/      # Ticket/queue views (Tailwind + Alpine.js)
│   ├── Home/              # Public pages, migrations
│   └── User/
│       ├── Controllers/ApiDashboardController.php  # Merchant API dashboard (keys, webhooks, logs)
│       └── Views/merchant/api/                     # Merchant API management views (keys, webhooks, logs)
└── Views/
    ├── api/
    │   └── checkout.php       # Customer-facing checkout page (payment method selection, status views)
    └── layouts/
        ├── template.php   # Router
        ├── general.php    # Public layout
        ├── auth.php       # Auth layout
        ├── user/main.blade.php   # User dashboard (Tailwind + Alpine.js)
        ├── admin/main.blade.php  # Admin dashboard (Tailwind + Alpine.js)
        └── common/modal/  # Modal templates

public/assets/js/
└── qpay-alpine.js  # Dashboard utility layer (vanilla JS + Alpine.js)
```

## API Key System (Stripe-style)
- **Key formats**: `pk_live_`, `sk_live_`, `pk_test_`, `sk_test_` + 48 hex chars
- **Storage**: SHA-256 hash stored in `api_keys` table; plaintext shown once on creation
- **Key types**: `publishable` (read-only, safe for frontend) and `secret` (full access)
- **Legacy fallback**: Old `brand_key` from `brands` table still works via `ApiAuth` filter
- **Rate limiting**: 100 req/min (live), 200 req/min (test); enforced via `api_logs` window count
- **Webhook signing**: `QPay-Signature: t={timestamp},v1={hmac_sha256}` header format
- **Test mode**: `sk_test_*` keys auto-use `TestPaymentAdapter`; amount=2.00 declines, amount=3.00 insufficient funds, all others succeed

## API v1 Endpoints
All v1 routes require `API-KEY` header (new pk/sk key or legacy brand_key).

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/v1/payment/create` | Create a payment (supports Idempotency-Key header) |
| GET | `/api/v1/payment/verify/{id}` | Verify a payment with provider |
| GET | `/api/v1/payment/status/{id}` | Get payment status |
| GET | `/api/v1/payment/methods` | List available payment methods |
| GET | `/api/v1/payments` | List payments (paginated, Stripe-style) |
| POST | `/api/v1/refunds` | Create a refund |
| GET | `/api/v1/balance` | Get merchant balance |

## Legacy API Endpoints (preserved)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET/POST | `/api/device-connect` | Device authentication |
| GET/POST | `/api/add-data` | SMS data ingestion |
| GET | `/cron` | Background task processing |

## Key Database Tables
- `api_payments` - Payment records (with idempotency, test_mode, webhook_delivered columns)
- `api_keys` - Stripe-style API keys (hashed, with environment/type)
- `api_logs` - API request logs (method, endpoint, status, response time)
- `webhooks` - Registered webhook endpoints per merchant
- `webhook_events` - Webhook delivery log (status, attempts, response)
- `transactions` / `temp_transactions` - Legacy transaction records
- `brands` - Merchant brands with legacy API keys
- `user_payment_settings` - Merchant wallet configurations
- `module_data` - Raw SMS data from devices
- `payments` - System payment gateway configs
- `users` / `staffs` - User and admin accounts

## CSRF Configuration
- `tokenName = 'token'` and `cookieName = 'token'` in `app/Config/Security.php`
- All forms use `form_open()` / `form_close()` which auto-insert CSRF hidden field
- CSRF is cookie-based with `regenerate = false`
- API routes (`api/*`) are CSRF-exempt via `app/Config/Filters.php`
- `qpay-alpine.js` auto-injects CSRF token into all `qpost()` calls

## Cookie Configuration
- `SameSite=Lax`, `secure=false`, `httponly=true` in `app/Config/Cookie.php`
- For production/iframe deployment: change to `SameSite=None` and `secure=true`

## Login Routes
- User login: `/sign-in` (not `/login`)
- Admin login: `/admin/sign-in`
- Both use AJAX POST with CSRF `token` field via `actionForm` class
- User accounts stored in `users` table, admin accounts in `staffs` table

## Admin Credentials
- Email: `admin@qpay.qubickle.com`
- Password: stored in environment / secrets

## Merchant API Dashboard
- `/user/api/keys` — Manage API keys (generate, rotate, revoke)
- `/user/api/webhooks` — Configure webhook endpoints
- `/user/api/logs` — View API request logs with filtering
- `/user/api/sdks` — SDK downloads, plugin ZIP, code snippets, integration instructions

## Admin API Analytics
- `/admin/api-analytics` — Platform-wide API usage stats, top merchants, error rates

## Developer Docs
- `/developers` - Overview landing page
- `/developers/docs` - Full API documentation with code samples (authentication, all endpoints, webhooks, SDKs, error codes, rate limits)
- Docs use `base_url()` for PAYMENT_URL
- Docs layout uses `general.php` layout (Tailwind CSS + Alpine.js)

## Integration SDKs & Plugins
- **PHP SDK** (`public/sdks/php/QPay.php`) — Single-file SDK with all API methods + webhook signature verification
- **Node.js SDK** (`public/sdks/nodejs/qpay.js`) — CommonJS module with async/await, error class, webhook verification
- **QPay for WordPress** (`public/sdks/wordpress/qpay-wordpress/`) — Unified WordPress plugin with payment buttons, forms, donations, webhooks, transaction management, refunds, roles, and optional WooCommerce checkout integration. ZIP at `/sdks/wordpress/qpay-wordpress.zip`
  - Shortcodes: `[qpay_button]`, `[qpay_form]`, `[qpay_donate]`
  - Admin pages: QPay > Transactions, QPay > Forms, QPay > Settings
  - WooCommerce: auto-detected, loads gateway only if WC active + enabled in settings
  - Webhook: `/wp-json/qpay/v1/webhook` (handles both standalone + WooCommerce orders)
  - Custom role: `qpay_merchant` with `manage_qpay`, `qpay_view_transactions`, `qpay_refund` capabilities
- **WooCommerce Plugin (Legacy)** (`public/sdks/woocommerce/qpay-payment-gateway/`) — Standalone WooCommerce-only gateway. Replaced by unified QPay for WordPress plugin above.

## Landing Page & SEO
- **Landing page**: Mercury/Airwallex-style dark hero at `app/Modules/Home/Views/index.php` with gradient mesh backgrounds, animated stats (Alpine.js x-intersect), feature cards, how-it-works steps, testimonials, and sales contact form
- **Contact form**: POSTs to `/contact-sales` → `HomeController::contactSales()` with validation, DB insert to `sales_leads` table, error handling with try/catch
- **SEO**: Open Graph meta, Twitter cards, JSON-LD Organization schema, canonical URLs in `general.php` layout
- **Security headers**: `app/Filters/SecurityHeaders.php` — X-Content-Type-Options, X-Frame-Options, XSS-Protection, HSTS, Referrer-Policy, Permissions-Policy (registered as global after-filter)
- **robots.txt**: At workspace root (served by `router.php`), allows crawling of public pages, disallows admin/user/api paths
- **Scroll animations**: `.scroll-reveal` class triggered by IntersectionObserver in layout JS
- **Speed**: preconnect hints for CDN, lazy loading on images

## Environment Notes
- `APP_STATUS=installed` and `CI_ENVIRONMENT=development` set via putenv() in index.php
- CSRF is disabled for `api/*` routes
- `router.php` serves static files from workspace root; all other requests go through CodeIgniter
- MariaDB data persists in `/home/runner/mysql_data` across restarts
- Known harmless warnings: Tailwind CDN production warning

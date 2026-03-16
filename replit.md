# QPay - Payment Gateway Platform

## Overview
QPay is a payment gateway/orchestrator for South Asian markets (Bangladesh). It provides unified checkout for MFS providers (bKash, Nagad, Rocket) and banks.

## Architecture
- **Framework**: CodeIgniter 4 (PHP 8.2)
- **Database**: MariaDB 10.11 (socket: `/tmp/mysql.sock`, db: `main`, user: `root`, pass: see start.sh)
- **Server**: PHP built-in server on port 5000 with `router.php` for static file serving
- **Startup**: `start.sh` handles MariaDB init, table creation, migrations, and PHP server launch

## Frontend Architecture (Alpine.js + Tailwind Migration)

### Layout System
The template system (`app/Libraries/Template.php`) routes through `app/Views/layouts/template.php`:
- **`general.php`** — Public pages (home, blogs, terms, privacy). Uses Tailwind CDN navbar/footer + legacy Bootstrap/AOS/Swiper vendor CSS/JS for inner view compatibility.
- **`auth.php`** — Sign-in, sign-up, password reset (user + admin). Pure Tailwind + Alpine.js, no Bootstrap/jQuery.
- **`user/main.blade.php`** — User dashboard. Tailwind CDN + Alpine.js layered on top of legacy Blithe/jQuery for inner view backward compatibility.
- **`admin/main.blade.php`** — Admin dashboard. Same hybrid approach as user dashboard.
- **`docs.php`** — API documentation pages.

### JavaScript Stack
- **`public/assets/js/app.js`** — Vanilla JS replacement for jQuery patterns. Provides:
  - `qpost()` — fetch-based AJAX helper with auto CSRF token injection
  - `notify()` — Toast notification system (pure CSS/JS, XSS-safe via textContent)
  - `pageOverlay` — Loading overlay component
  - `alertMessage` — Inline alert component
  - Form handlers: `actionForm`, `actionFormWithoutToast`, `actionAddFundsForm`, `ajaxSearchItem`
  - Click handlers: `ajaxDeleteItem`, `ajaxActionOptions`, `ajaxToggleItemStatus`, `ajaxViewUser`
  - Change handlers: `ajaxChangeLanguage`, `ajaxChangeSort`, `ajaxChangeCurrencyCode`, `ajaxChangeTicketSubject`
  - Utilities: `is_json`, `reloadPage`, `confirm_notice`, `callPostAjax`, `copyToClipBoard`, `preparePrice`
  - Notification polling (15s interval)
  - Search area button handlers
- **Legacy JS (dashboard only)**: `process.js`/`process2.js`, `general.js`, `admin.js`, `blithe.js` — still loaded in dashboard layouts as compatibility shim until inner views are migrated.

### CDN Dependencies
- Tailwind CSS: `https://cdn.tailwindcss.com` (dev CDN, production should use build step)
- Alpine.js: `https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js`

### Tailwind Config
Custom colors used across layouts:
```js
primary: { 50-900 indigo shades from #eef2ff to #312e81 }
sidebar: { bg: '#1e293b', hover: '#334155', active: '#4f46e5' }
```

## Key Directories
```
app/
├── Adapters/              # Payment provider adapters (Sprint 3)
│   ├── SmsVerificationAdapter.php   (legacy SMS-based verification)
│   └── DirectApiAdapter.php         (new direct API integration)
├── Config/
│   ├── App.php            # Auto-detects base_url from HTTP_HOST for proxy env
│   ├── Database.php       # Hardcoded DB credentials in constructor
│   ├── Filters.php        # Includes api_auth filter for API routes
│   ├── Routes.php         # Legacy + API v1 routes
│   └── Site_config.php    # HTTPS redirect disabled (enable_https='0')
├── Controllers/
│   ├── ApiController.php  # Legacy device/SMS endpoints
│   └── Api/V1/
│       └── PaymentController.php  # New REST API (Sprint 1-2)
├── Filters/
│   ├── ApiAuth.php        # API key auth via brands table (Sprint 2)
│   ├── Auth.php           # Session-based auth redirect
│   └── IPBlocker.php      # Rate limiting
├── Interfaces/
│   └── PaymentProviderInterface.php  # Provider contract (Sprint 3)
├── Libraries/
│   ├── GatewayApi.php     # Legacy cURL payment library
│   ├── Template.php       # Template engine — layout routing via set_layout()
│   └── PaymentProviderFactory.php  # Factory pattern for adapters
├── Modules/
│   ├── Admin/             # Admin panel (staff management, txn views)
│   ├── Blocks/            # Queue/background tasks
│   ├── Home/              # Public pages, migrations
│   └── User/              # Merchant dashboard, wallets, transactions
└── Views/
    └── layouts/
        ├── template.php   # Router: admin → admin/main, user → user/main, default → general
        ├── general.php    # Public layout (Tailwind nav/footer + legacy vendor CSS/JS)
        ├── auth.php       # Auth layout (pure Tailwind + Alpine.js)
        ├── user/main.blade.php   # User dashboard (hybrid Tailwind + legacy)
        └── admin/main.blade.php  # Admin dashboard (hybrid Tailwind + legacy)

public/assets/js/
├── app.js          # New vanilla JS utilities (replaces jQuery patterns)
├── process.js      # Legacy jQuery utilities (loaded in admin dashboard)
├── process2.js     # Legacy jQuery utilities (loaded in user dashboard)
├── general.js      # Legacy jQuery event handlers (loaded in dashboards)
├── admin.js        # Legacy admin jQuery handlers (loaded in dashboards)
└── blithe.js       # Legacy sidebar/sortable (loaded in dashboards)
```

## API v1 Endpoints
All v1 routes require `API-KEY` header (brand_key from brands table).

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/v1/payment/create` | Create a payment (supports Idempotency-Key header) |
| GET | `/api/v1/payment/verify/{id}` | Verify a payment with provider |
| GET | `/api/v1/payment/status/{id}` | Get payment status |
| GET | `/api/v1/payment/methods` | List available payment methods |

## Legacy API Endpoints (preserved)
| Method | Endpoint | Description |
|--------|----------|-------------|
| GET/POST | `/api/device-connect` | Device authentication |
| GET/POST | `/api/add-data` | SMS data ingestion |
| GET | `/cron` | Background task processing |

## Key Database Tables
- `api_payments` - New v1 payment records (with idempotency)
- `transactions` / `temp_transactions` - Legacy transaction records
- `brands` - Merchant brands with API keys
- `user_payment_settings` - Merchant wallet configurations
- `module_data` - Raw SMS data from devices
- `payments` - System payment gateway configs
- `users` / `staffs` - User and admin accounts

## CSRF Configuration
- `tokenName = 'token'` and `cookieName = 'token'` in `app/Config/Security.php`
- All forms use `form_open()` / `form_close()` which auto-insert CSRF hidden field
- CSRF is cookie-based with `regenerate = false` (prevents token mismatch on sequential AJAX calls)
- API routes (`api/*`) are CSRF-exempt via `app/Config/Filters.php`
- `app.js` auto-injects CSRF token into all `qpost()` calls

## Cookie Configuration
- `SameSite=Lax`, `secure=false`, `httponly=true` in `app/Config/Cookie.php`
- For production/iframe deployment: change to `SameSite=None` and `secure=true`

## JS Stability
- All `JSON.parse` calls in `blithe.js`, `process.js`, `process2.js` are wrapped in try/catch
- `general.js` notification polling handles HTML responses gracefully (server returns HTML not JSON)
- Auth layout defines `var token`, `PATH`, `user=''` globals for JS
- Known harmless warnings: Swiper loop warning (cosmetic), Tailwind CDN production warning

## Login Routes
- User login: `/sign-in` (not `/login`)
- Admin login: `/admin/sign-in`
- Both use AJAX POST with CSRF `token` field via `actionForm` class
- User accounts stored in `users` table, admin accounts in `staffs` table

## Admin Credentials
- Email: `admin@cloudman.one`
- Password: stored in environment / secrets

## Developer Docs
- `/developers` - Overview landing page (developers/index.php via DocController)
- `/developers/docs` - Full API documentation (developers/docs.php) with code samples in PHP, Node.js, Python, Go
- Docs use `base_url()` for PAYMENT_URL (not env var)
- All code samples reference v1 API endpoints with single API-KEY header

## Environment Notes
- `APP_STATUS=installed` and `CI_ENVIRONMENT=development` set via putenv() in index.php
- CSRF is disabled for `api/*` routes
- `router.php` serves static files from workspace root; all other requests go through CodeIgniter
- MariaDB data persists in `/home/runner/mysql_data` across restarts

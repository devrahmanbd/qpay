# QPay - Payment Gateway Platform

## Overview
QPay is a payment gateway/orchestrator for South Asian markets (Bangladesh). It provides unified checkout for MFS providers (bKash, Nagad, Rocket) and banks.

## Architecture
- **Framework**: CodeIgniter 4 (PHP 8.2)
- **Database**: MariaDB 10.11 (socket: `/tmp/mysql.sock`, db: `main`, user: `root`, pass: see start.sh)
- **Server**: PHP built-in server on port 5000 with `router.php` for static file serving
- **Startup**: `start.sh` handles MariaDB init, table creation, migrations, and PHP server launch

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
│   └── PaymentProviderFactory.php  # Factory pattern for adapters
├── Modules/
│   ├── Admin/             # Admin panel (staff management, txn views)
│   ├── Blocks/            # Queue/background tasks
│   ├── Home/              # Public pages, migrations
│   └── User/              # Merchant dashboard, wallets, transactions
└── Views/
    └── layouts/general.php  # Bootstrap 5 frontend layout
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

## JS Stability
- All `JSON.parse` calls in `blithe.js`, `process.js`, `process2.js` are wrapped in try/catch
- `general.js` notification polling handles HTML responses gracefully (server returns HTML not JSON)
- Auth layout (`app/Views/layouts/auth.php`) defines `var token`, `PATH`, `user=''` globals for JS
- Known harmless warnings: Swiper loop warning (cosmetic), DOM autocomplete suggestion

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

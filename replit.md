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
- **`public/assets/js/app.js`** — Vanilla JS for auth pages (loaded only in `auth.php` layout).

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
- `app_helper.php` — General application helpers

### View Patterns
- **Table index views**: Wrap in `bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden`
- **Settings elements**: Same card pattern with `content` class
- **Update/modal views**: Use `flex flex-wrap -mx-2` for form element containers
- **Toggle switches**: SR-only peer pattern (no jQuery)
- **Alpine.js data**: Used for interactive UI (e.g., `x-data="{protocol:...}"` in email settings)

## Key Directories
```
app/
├── Adapters/              # Payment provider adapters
├── Config/
│   ├── App.php            # Auto-detects base_url from HTTP_HOST
│   ├── Database.php       # DB credentials
│   ├── Filters.php        # Includes api_auth filter
│   ├── Routes.php         # Legacy + API v1 routes
│   └── Site_config.php    # HTTPS redirect config
├── Controllers/
│   ├── ApiController.php  # Legacy device/SMS endpoints
│   └── Api/V1/
│       └── PaymentController.php  # REST API
├── Helpers/
│   ├── app_helper.php     # General helpers
│   ├── partials_helper.php # UI component helpers (Tailwind)
│   └── form_template_helper.php # Form helpers (Tailwind)
├── Modules/
│   ├── Admin/Views/       # All admin views (Tailwind + Alpine.js)
│   ├── Blocks/Views/      # Ticket/queue views (Tailwind + Alpine.js)
│   ├── Home/              # Public pages, migrations
│   └── User/Views/        # All user views (Tailwind + Alpine.js)
└── Views/
    └── layouts/
        ├── template.php   # Router
        ├── general.php    # Public layout
        ├── auth.php       # Auth layout
        ├── user/main.blade.php   # User dashboard (Tailwind + Alpine.js)
        ├── admin/main.blade.php  # Admin dashboard (Tailwind + Alpine.js)
        └── common/modal/  # Modal templates

public/assets/js/
├── qpay-alpine.js  # Dashboard utility layer (vanilla JS + Alpine.js)
└── app.js          # Auth page utilities
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
- Email: `admin@cloudman.one`
- Password: stored in environment / secrets

## Developer Docs
- `/developers` - Overview landing page
- `/developers/docs` - Full API documentation with code samples
- Docs use `base_url()` for PAYMENT_URL
- Docs layout (`docs.php`) retains its own separate CSS/JS (not part of dashboard migration)

## Environment Notes
- `APP_STATUS=installed` and `CI_ENVIRONMENT=development` set via putenv() in index.php
- CSRF is disabled for `api/*` routes
- `router.php` serves static files from workspace root; all other requests go through CodeIgniter
- MariaDB data persists in `/home/runner/mysql_data` across restarts
- Known harmless warnings: Tailwind CDN production warning

# QPay - Payment Gateway Platform

QPay is a payment gateway and orchestrator for South Asian markets (Bangladesh). It provides a unified checkout experience for MFS providers (bKash, Nagad, Rocket) and bank transfers through a single API.

**Live URL**: [qpay.qubickle.com](https://qpay.qubickle.com)

---

## Features

- **Unified Checkout**: Accept bKash, Nagad, Rocket, bank transfers, and cards through one API
- **Stripe-style API Keys**: Publishable (`pk_live_`, `pk_test_`) and secret (`sk_live_`, `sk_test_`) key pairs
- **Test/Sandbox Mode**: Full sandbox environment with simulated payments using test keys
- **Webhook System**: HMAC-SHA256 signed webhooks with retry logic
- **Merchant Dashboard**: API key management, webhook configuration, transaction logs, analytics
- **Admin Dashboard**: Platform-wide analytics, merchant management, API usage stats
- **WordPress Plugin**: Shortcodes for payment buttons, forms, and donations, plus WooCommerce integration
- **PHP & Node.js SDKs**: Drop-in libraries for quick integration
- **Developer Documentation**: Comprehensive Stripe-style API reference at `/developers/docs`

---

## Tech Stack

| Component | Technology |
|-----------|-----------|
| Framework | CodeIgniter 4 (PHP 8.2) |
| Database | MariaDB 10.11 |
| Frontend | Tailwind CSS + Alpine.js |
| Server | PHP built-in server (dev) / PHP-FPM (production) |

---

## Quick Start (Development)

### Prerequisites

- PHP 8.2+
- MariaDB 10.11+
- Composer

### Setup

1. Clone the repository:
   ```bash
   git clone <repo-url>
   cd qpay
   ```

2. Install dependencies:
   ```bash
   composer install
   ```

3. Start the application (MariaDB + PHP server):
   ```bash
   bash start.sh
   ```

   This script will:
   - Initialize MariaDB data directory (first run)
   - Start MariaDB on socket `/tmp/mysql.sock`
   - Create the `main` database and seed admin user
   - Run CodeIgniter migrations
   - Start PHP dev server on port 5000

4. Access the application:
   - **Homepage**: `http://localhost:5000`
   - **Admin login**: `http://localhost:5000/admin/sign-in`
   - **User login**: `http://localhost:5000/sign-in`

### Default Admin Credentials

- **Email**: `admin@qpay.qubickle.com`
- **Password**: `harry71Nahid`

---

## Deployment (Production)

### On Replit

1. The app runs automatically via the `Start application` workflow
2. Use the **Deploy** button in Replit to publish
3. The app auto-detects its domain and configures HTTPS

### On a VPS / Server

1. Set up PHP 8.2 with required extensions:
   ```bash
   apt install php8.2-fpm php8.2-mysql php8.2-mbstring php8.2-xml php8.2-curl
   ```

2. Set up MariaDB:
   ```bash
   apt install mariadb-server
   mysql -u root -e "CREATE DATABASE qpay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
   ```

3. Import the database schema:
   ```bash
   mysql -u root qpay < db_schema.sql
   ```

4. Configure your web server (Nginx example):
   ```nginx
   server {
       listen 80;
       server_name qpay.qubickle.com;
       root /var/www/qpay;
       index index.php;

       location / {
           try_files $uri $uri/ /index.php?$query_string;
       }

       location ~ \.php$ {
           fastcgi_pass unix:/run/php/php8.2-fpm.sock;
           fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
           include fastcgi_params;
       }
   }
   ```

5. Set environment variables in `.env`:
   ```env
   CI_ENVIRONMENT = production
   database.default.hostname = localhost
   database.default.database = qpay
   database.default.username = root
   database.default.password = your_password
   database.default.DBDriver = MySQLi
   ```

6. Run migrations:
   ```bash
   php spark migrate --all
   ```

7. Set proper permissions:
   ```bash
   chmod -R 777 writable/
   ```

---

## API Overview

All API endpoints require an `API-KEY` header with a valid secret key.

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/v1/payment/create` | Create a payment |
| GET | `/api/v1/payment/verify/{id}` | Verify payment with provider |
| GET | `/api/v1/payment/status/{id}` | Get payment status |
| GET | `/api/v1/payment/methods` | List payment methods |
| GET | `/api/v1/payments` | List payments (paginated) |
| POST | `/api/v1/refunds` | Create a refund |
| GET | `/api/v1/balance` | Get merchant balance |

### Example: Create a Payment

```bash
curl -X POST https://qpay.qubickle.com/api/v1/payment/create \
  -H "API-KEY: sk_live_your_secret_key" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 500,
    "currency": "BDT",
    "success_url": "https://yoursite.com/success",
    "cancel_url": "https://yoursite.com/cancel",
    "webhook_url": "https://yoursite.com/webhook",
    "cus_name": "John Doe",
    "cus_email": "john@example.com"
  }'
```

### Test Mode

Use test keys (`sk_test_*`) for sandbox testing:
- Amount `2.00` returns **declined**
- Amount `3.00` returns **insufficient funds**
- All other amounts return **processing** (success)

Full API documentation: [qpay.qubickle.com/developers/docs](https://qpay.qubickle.com/developers/docs)

---

## WordPress Plugin

The QPay WordPress plugin is located at:

```
public/sdks/wordpress/qpay-wordpress/
```

**Download ZIP**: `public/sdks/wordpress/qpay-wordpress.zip`

Or download from the merchant dashboard at: **Dashboard > API & SDKs > WordPress Plugin**

### Installation

1. Download `qpay-wordpress.zip`
2. In WordPress admin, go to **Plugins > Add New > Upload Plugin**
3. Upload the ZIP file and activate
4. Go to **QPay > Settings** and enter your API keys and gateway URL (`https://qpay.qubickle.com`)

### Shortcodes

```
[qpay_button amount="500" label="Pay Now" currency="BDT"]
[qpay_form]
[qpay_donate preset_amounts="100,500,1000"]
```

### WooCommerce Integration

If WooCommerce is installed, the plugin automatically adds QPay as a payment gateway. Enable it in **WooCommerce > Settings > Payments > QPay**.

### Webhook Endpoint

The plugin registers a webhook endpoint at:
```
https://yoursite.com/wp-json/qpay/v1/webhook
```

Set this URL in your QPay merchant dashboard webhook settings.

---

## SDKs

### PHP SDK

Location: `public/sdks/php/QPay.php`

```php
require_once 'QPay.php';
$qpay = new QPay('sk_live_your_key', 'https://qpay.qubickle.com');
$payment = $qpay->createPayment([
    'amount' => 500,
    'currency' => 'BDT',
    'success_url' => 'https://yoursite.com/success',
    'cancel_url' => 'https://yoursite.com/cancel'
]);
```

### Node.js SDK

Location: `public/sdks/nodejs/qpay.js`

```javascript
const QPay = require('./qpay');
const qpay = new QPay({ secretKey: 'sk_live_your_key', baseUrl: 'https://qpay.qubickle.com' });
const payment = await qpay.createPayment({
    amount: 500,
    currency: 'BDT',
    success_url: 'https://yoursite.com/success',
    cancel_url: 'https://yoursite.com/cancel'
});
```

---

## Project Structure

```
app/
├── Adapters/              # Payment provider adapters (SMS, Direct API, Test)
├── Config/                # App config, routes, filters, site settings
├── Controllers/Api/V1/    # REST API controllers
├── Database/Migrations/   # Database migrations
├── Filters/               # Auth, CSRF, security header filters
├── Helpers/               # App, form, and partial helpers
├── Interfaces/            # PaymentProviderInterface
├── Libraries/             # ApiKeyService, WebhookService, Template, etc.
├── Modules/
│   ├── Admin/             # Admin dashboard (controllers, views)
│   ├── Home/              # Public pages (landing, blog, docs, invoice)
│   └── User/              # Merchant dashboard (API keys, webhooks, logs)
└── Views/
    ├── api/checkout.php   # Customer checkout page
    └── layouts/           # Layout templates (general, auth, admin, user)

public/
├── assets/                # CSS, JS, images
└── sdks/
    ├── php/QPay.php       # PHP SDK
    ├── nodejs/qpay.js     # Node.js SDK
    ├── wordpress/         # WordPress plugin (folder + ZIP)
    └── woocommerce/       # Legacy WooCommerce-only plugin

robots.txt                 # SEO crawl rules
start.sh                   # Startup script (MariaDB + PHP server)
```

---

## License

Proprietary. All rights reserved by QPay / Qubickle.

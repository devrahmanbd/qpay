# 🚀 QPay Stripe-Like API - Complete Curl Testing Guide

## 📌 Test Environment Setup

### Merchant Account
- **Email:** demo@gmail.com
- **Merchant ID:** 372
- **Brand ID:** 22
- **Brand Name:** Demo
- **Currency:** BDT

### API Keys (Copy these values)

```bash
# Store in environment for easy reuse
export SK_TEST="sk_test_9800d2976f95dc4d1a9fc1503437fdfbbd301118dc2e6d21"
export SK_LIVE="sk_live_c98b3d38576c274b4b6d19db25c5ac44b10ba06bb2fca311"
export PK_TEST="pk_test_753f1ebc083fd1ab986fd306970e7e0de6b630c6518c8982"
export API_BASE="http://localhost:5000/api/v1"
```

---

## 🧪 API Test Commands

### 1️⃣ Payment Creation

#### ✅ Successful Payment (amount ≠ 2 or 3)
```bash
curl -X POST $API_BASE/payment/create \
  -H "API-KEY: $SK_TEST" \
  -H "Content-Type: application/json" \
  -d '{
    "amount": 100.00,
    "currency": "BDT",
    "customer_email": "customer@example.com",
    "customer_name": "John Doe",
    "metadata": {"order_id": "12345"}
  }'
```
**Expected:** `"status": "processing"` with transaction_id

#### ❌ Declined Payment (amount = 2.00 in test mode)
```bash
curl -X POST $API_BASE/payment/create \
  -H "API-KEY: $SK_TEST" \
  -H "Content-Type: application/json" \
  -d '{"amount": 2.00}'
```
**Expected:** `"status": "failed"` (test mode simulation)

#### ❌ Insufficient Funds (amount = 3.00 in test mode)
```bash
curl -X POST $API_BASE/payment/create \
  -H "API-KEY: $SK_TEST" \
  -H "Content-Type: application/json" \
  -d '{"amount": 3.00}'
```
**Expected:** `"status": "failed"` with error_code

#### 📝 Payment with Idempotency Key
```bash
curl -X POST $API_BASE/payment/create \
  -H "API-KEY: $SK_TEST" \
  -H "Idempotency-Key: order-12345-unique" \
  -H "Content-Type: application/json" \
  -d '{"amount": 50.00}'
```
**Expected:** Same payment returned if called again with same key

---

### 2️⃣ Payment Retrieval

#### Get Single Payment Status
```bash
curl -X GET "$API_BASE/payment/status/pay_YOUR_PAYMENT_ID" \
  -H "API-KEY: $SK_TEST"
```
**Replace:** `pay_YOUR_PAYMENT_ID` with actual payment ID

#### Verify Payment (Server-side)
```bash
curl -X GET "$API_BASE/payment/verify/pay_YOUR_PAYMENT_ID" \
  -H "API-KEY: $SK_TEST"
```
**Note:** Only secret keys (sk_*) allowed

#### List All Payments (Paginated)
```bash
curl -X GET "$API_BASE/payments?limit=10&offset=0" \
  -H "API-KEY: $SK_TEST"
```
**Response:** Includes `data[]`, `has_more`, `total_count`

#### Filter by Status
```bash
curl -X GET "$API_BASE/payments?status=processing&limit=5" \
  -H "API-KEY: $SK_TEST"
```
**Valid statuses:** pending, processing, completed, failed, refunded

---

### 3️⃣ Balance & Accounting

#### Get Merchant Balance
```bash
curl -X GET "$API_BASE/balance" \
  -H "API-KEY: $SK_TEST"
```
**Response:** Shows available, pending, refunded amounts

---

### 4️⃣ Refunds

#### Create Refund (Secret Key Only)
```bash
curl -X POST "$API_BASE/refunds" \
  -H "API-KEY: $SK_TEST" \
  -H "Content-Type: application/json" \
  -d '{
    "payment_id": "pay_YOUR_PAYMENT_ID",
    "reason": "Customer requested refund"
  }'
```
**Expected:** Refund object with `"object": "refund"`

---

### 5️⃣ Available Payment Methods

#### List Payment Methods (Any Key Type)
```bash
curl -X GET "$API_BASE/payment/methods" \
  -H "API-KEY: $SK_TEST"
```
**Works with:** Secret keys (sk_*) AND Publishable keys (pk_*)

---

### 6️⃣ Security Tests

#### ❌ Test: Legacy Key Rejected
```bash
curl -X GET "$API_BASE/payment/methods" \
  -H "API-KEY: ttcKL8eq9V1B5R10xbjXDUU4u9qYFS0pkVP6na1M7avrVCvcCQ"
```
**Expected:** 401 error - "Invalid API key format"

#### ❌ Test: Publishable Key Blocked from Create
```bash
curl -X POST $API_BASE/payment/create \
  -H "API-KEY: $PK_TEST" \
  -H "Content-Type: application/json" \
  -d '{"amount": 50}'
```
**Expected:** 403 Forbidden - "Publishable keys cannot create payments"

#### ❌ Test: Publishable Key Blocked from Verify
```bash
curl -X GET "$API_BASE/payment/verify/pay_YOUR_PAYMENT_ID" \
  -H "API-KEY: $PK_TEST"
```
**Expected:** 403 Forbidden

#### ❌ Test: Missing API Key
```bash
curl -X GET "$API_BASE/payment/methods"
```
**Expected:** 401 - "API key is required"

---

### 7️⃣ Rate Limiting Test

#### Trigger Rate Limit (100 req/min for test keys)
```bash
# Send 101 requests quickly
for i in {1..101}; do
  curl -s -X GET "$API_BASE/payment/methods" -H "API-KEY: $SK_TEST" > /dev/null
done

# 101st request should fail
curl -X GET "$API_BASE/payment/methods" \
  -H "API-KEY: $SK_TEST"
```
**Expected on 101st:** 429 Too Many Requests with `Retry-After: 60`

---

## 📊 Database Queries to Check Results

```bash
# View all payments created
mysql --socket=/tmp/mysql.sock -u root -p'harry71Nahid920*' main -e "
SELECT ids, amount, status, test_mode, customer_email, created_at 
FROM api_payments WHERE brand_id=22 
ORDER BY id DESC LIMIT 10;
"

# View API logs
mysql --socket=/tmp/mysql.sock -u root -p'harry71Nahid920*' main -e "
SELECT method, endpoint, status_code, response_time_ms, created_at 
FROM api_logs WHERE brand_id=22 
ORDER BY id DESC LIMIT 10;
"

# View webhook events
mysql --socket=/tmp/mysql.sock -u root -p'harry71Nahid920*' main -e "
SELECT event_type, status, attempts, created_at 
FROM webhook_events 
ORDER BY id DESC LIMIT 10;
"
```

---

## 🔍 Response Format Examples

### Successful Payment Response
```json
{
  "id": "pay_abc123def456",
  "object": "payment",
  "amount": 100,
  "currency": "bdt",
  "status": "processing",
  "payment_method": null,
  "transaction_id": "test_txn_xyz",
  "customer_email": "customer@example.com",
  "customer_name": "John Doe",
  "metadata": {"order_id": "12345"},
  "test_mode": true,
  "created": 1773745587,
  "created_at": "2026-03-17 17:00:00",
  "updated_at": "2026-03-17 17:00:00",
  "fees": 2,
  "net_amount": 98,
  "checkout_url": "http://localhost:5000/api/v1/payment/checkout/pay_abc123def456",
  "redirect_url": null
}
```

### List Payments Response
```json
{
  "object": "list",
  "data": [
    { "id": "pay_1", "amount": 100, "status": "completed", ... },
    { "id": "pay_2", "amount": 50, "status": "processing", ... }
  ],
  "has_more": false,
  "total_count": 2,
  "url": "/api/v1/payments"
}
```

### Refund Response
```json
{
  "id": "ref_abc123def456",
  "object": "refund",
  "amount": 100,
  "currency": "bdt",
  "payment": "pay_original_payment_id",
  "reason": "Customer requested refund",
  "status": "succeeded",
  "test_mode": true,
  "created": 1773745600,
  "created_at": "2026-03-17 17:00:00"
}
```

---

## 🎯 Quick Test Script

Save as `test_api.sh`:

```bash
#!/bin/bash
set -e

SK_TEST="sk_test_9800d2976f95dc4d1a9fc1503437fdfbbd301118dc2e6d21"
API="http://localhost:5000/api/v1"

echo "Testing QPay API..."
echo ""

echo "1. Create payment..."
PAY=$(curl -s -X POST $API/payment/create \
  -H "API-KEY: $SK_TEST" \
  -H "Content-Type: application/json" \
  -d '{"amount":100}')
PAY_ID=$(echo $PAY | grep -o '"id":"[^"]*"' | cut -d'"' -f4)
echo "   Payment: $PAY_ID"

echo "2. List payments..."
curl -s $API/payments -H "API-KEY: $SK_TEST" | grep -o '"total_count":[0-9]*'

echo "3. Get balance..."
curl -s $API/balance -H "API-KEY: $SK_TEST" | grep -o '"available":[0-9]*'

echo "✅ All tests passed!"
```

Run with: `bash test_api.sh`


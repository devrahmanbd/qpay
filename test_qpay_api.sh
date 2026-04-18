#!/bin/bash

# Color codes
GREEN='\033[0;32m'
RED='\033[0;31m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# API Keys
SK_TEST="sk_test_9800d2976f95dc4d1a9fc1503437fdfbbd301118dc2e6d21"
SK_LIVE="sk_live_c98b3d38576c274b4b6d19db25c5ac44b10ba06bb2fca311"
PK_TEST="pk_test_753f1ebc083fd1ab986fd306970e7e0de6b630c6518c8982"
API="http://localhost:5000/api/v1"

# Helper function
test_endpoint() {
  local name=$1
  local method=$2
  local endpoint=$3
  local key=$4
  local data=$5
  
  echo -e "${BLUE}Testing: $name${NC}"
  
  if [ "$method" = "POST" ]; then
    curl -s -X POST "$API$endpoint" \
      -H "API-KEY: $key" \
      -H "Content-Type: application/json" \
      -d "$data" | head -c 300
  else
    curl -s -X GET "$API$endpoint" \
      -H "API-KEY: $key" | head -c 300
  fi
  
  echo -e "\n"
}

echo -e "${GREEN}======================================${NC}"
echo -e "${GREEN}  QPay Stripe-Like API Test Suite${NC}"
echo -e "${GREEN}======================================${NC}"
echo ""

echo -e "${BLUE}Merchant Details:${NC}"
echo "Email: demo@gmail.com"
echo "Merchant ID: 372"
echo "Brand: Demo (BDT)"
echo ""

echo -e "${BLUE}API Keys:${NC}"
echo "SK_TEST: $SK_TEST"
echo "SK_LIVE: $SK_LIVE"
echo "PK_TEST: $PK_TEST"
echo ""

# Test 1: Create Payment
echo -e "${BLUE}═══ TEST 1: Create Payment ═══${NC}"
test_endpoint "Create successful payment" "POST" "/payment/create" "$SK_TEST" \
  '{"amount":100,"customer_email":"test@example.com"}'

# Test 2: Declined Payment
echo -e "${BLUE}═══ TEST 2: Declined Payment (amount=2) ═══${NC}"
test_endpoint "Declined payment" "POST" "/payment/create" "$SK_TEST" '{"amount":2}'

# Test 3: Get Methods
echo -e "${BLUE}═══ TEST 3: Get Payment Methods ═══${NC}"
test_endpoint "Get methods with SK" "GET" "/payment/methods" "$SK_TEST" ""

# Test 4: Get Methods with PK
echo -e "${BLUE}═══ TEST 4: Get Methods with PK (also allowed) ═══${NC}"
test_endpoint "Get methods with PK" "GET" "/payment/methods" "$PK_TEST" ""

# Test 5: Balance
echo -e "${BLUE}═══ TEST 5: Get Balance ═══${NC}"
test_endpoint "Get balance" "GET" "/balance" "$SK_TEST" ""

# Test 6: List Payments
echo -e "${BLUE}═══ TEST 6: List Payments ═══${NC}"
test_endpoint "List payments" "GET" "/payments?limit=5" "$SK_TEST" ""

# Test 7: Legacy Key Rejection
echo -e "${BLUE}═══ TEST 7: Legacy Key Rejection ═══${NC}"
test_endpoint "Legacy key (should fail)" "GET" "/payment/methods" \
  "ttcKL8eq9V1B5R10xbjXDUU4u9qYFS0pkVP6na1M7avrVCvcCQ" ""

# Test 8: PK blocked from create
echo -e "${BLUE}═══ TEST 8: Publishable Key Blocked from Create ═══${NC}"
test_endpoint "PK create (should fail)" "POST" "/payment/create" "$PK_TEST" '{"amount":50}'

# Summary
echo -e "${GREEN}======================================${NC}"
echo -e "${GREEN}  Test Summary${NC}"
echo -e "${GREEN}======================================${NC}"
echo ""
echo "✅ Tests completed!"
echo ""
echo -e "${BLUE}Key Features Tested:${NC}"
echo "  1. Payment creation (successful & declined)"
echo "  2. Test mode simulation (amount=2 → failure)"
echo "  3. Payment methods listing"
echo "  4. Balance reporting"
echo "  5. Pagination"
echo "  6. Legacy key rejection"
echo "  7. Publishable key restrictions"
echo ""
echo -e "${BLUE}Quick Curl Example:${NC}"
echo 'curl -X POST http://localhost:5000/api/v1/payment/create \'
echo "  -H \"API-KEY: $SK_TEST\" \\"
echo '  -H "Content-Type: application/json" \'
echo '  -d '"'"'{"amount":100}'"'"
echo ""


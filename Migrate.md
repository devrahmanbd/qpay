# [Strengthening & Migration Plan: QPay Checkout & Verification]

This document outlines the plan to migrate and integrate robust payment verification and checkout features from the `Original-Code/qpay-sub` codebase into the current modernized `qpay-main` project.

## Migration Task List

### Phase 1: Payment Verification Strengthening
- [x] **Task 1.1: Refactor `SmsVerificationAdapter`**
   - Ported amount verification logic and strict regex patterns.
- [x] **Task 1.2: Consolidate Provider Verification**
   - Ensured `DirectApiAdapter` handles verification callbacks robustly.

### Phase 2: Payment Provider Specialization
- [x] **Task 2.1: Port bKash Tokenized Checkout**
   - Implemented `BkashAdapter.php` with `v1.2.0-beta` tokenized API flow.
- [x] **Task 2.2: Port Nagad Direct API**
   - Integrated Nagad RSA-signed direct API in `NagadAdapter.php`.
- [x] **Task 2.3: Port Binance Pay API**
   - Centralized Binance Pay signature logic into `BinanceAdapter.php`.

### Phase 3: Checkout System Enhancement
- [x] **Task 3.1: Multi-Theme Support**
   - Ported `nago`, `uddok`, `unique`, and `wall` themes.
   - Implemented theme selection logic in `PaymentController`.
- [x] **Task 3.2: Checkout UI Polish**
   - Added recursive polling (60s) for high-latency SMS verification across all themes.
- [x] **Task 3.3: Manual Bank Support**
   - Implemented `ManualBankAdapter.php` for all internal bank transfers.

### Phase 4: Core Helper & Data Porting
- [x] **Task 4.1: Helper Synchronization**
   - Ported and cleaned up utility functions (`ms()`, `trxId()`) and fixed legacy URL constants.
- [x] **Task 4.2: Database Unification**
   - Migrated legacy `transactions` to modern `api_payments`.
   - Updated `AdminModel` and `PaymentController` to use unified data.

---

## Technical Details

### SMS Matching Logic (from `qpay-sub/app/Models/Api.php`)
The system will now verify:
1. **Address**: Matches the sender (e.g., `bkash`, `nagad`, `16216`).
2. **Transaction ID**: Extracts using provider-specific prefixes (`TrxID`, `TxnID`).
3. **Amount**: Uses regex to find `Tk [amount]` and compares it with the expected payment amount.
4. **Status**: Updates `module_data` to mark the SMS as "used".

### Branded Views
The system will support a `theme` parameter:
- `default`: The current premium checkout.
- `nago`: Ported from `Viewsnago`.
- `uddok`: Ported from `Viewsuddok`.

---

## Verification Plan
1. **Unit Test**: Test the regex patterns against real-world SMS samples.
2. **Integration Test**: Use `test_checkout.php` to initiate a payment and verify with a mock `module_data` entry.
3. **UI Walkthrough**: Verify each ported theme renders correctly.

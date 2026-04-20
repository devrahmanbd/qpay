# QPay Security & Migration Analysis (fix.md)

This document provides a comprehensive overview of the modernized QPay platform, addresses security vulnerabilities discovered during the migration, and provides a walkthrough for external integrations (e.g., WordPress).

---

## 1. Gap Analysis: qpay-sub vs. qpay-main

The original `qpay-sub` was a monolithic gateway script. Our modernized `qpay-main` provides several critical architectural improvements:

| Feature | qpay-sub (Original) | qpay-main (Modern) |
| :--- | :--- | :--- |
| **Architecture** | Monolithic Procedural/MVC | Modular Domain-Driven Design |
| **Payment Logic** | Hardcoded in Controllers | Pluggable Adapters (`Manual`, `API`, `Tokenized`) |
| **Multi-Tenancy** | Basic UID scoping | Strict Brand-level isolation and API key scoping |
| **Database** | Multiple disparate tables | Unified `api_payments` schema with historical migration |
| **Verification** | Single attempt matching | Robust polling, brute-force protection, and double-spending checks |

---

## 2. Walkthrough: WordPress User Payment Flow

How a WordPress user makes a Mobile Banking or Bank payment:

1. **Initiation**: The WordPress plugin redirects the customer to: `https://qpay.cloudman.one/api/v1/payment/checkout/{payment_id}`.
2. **Method Selection**: The customer chooses a method (e.g., Rocket).
3. **Instruction Phase**: The "nago" theme displays provider-specific instructions:
   - "Dial *322# and 'Send Money' to 01XXXXXXXXX".
   - "Enter Amount: 500 BDT".
4. **Payment**: The customer performs the transaction on their own mobile device/app.
5. **Submission**: The customer returns to the QPay checkout page and enters the **Transaction ID** (e.g., `8X9Y7Z`) received via SMS.
6. **Backend Verification**:
   - `PaymentController` calls `SmsVerificationAdapter->verifyPayment('8X9Y7Z')`.
   - The adapter checks `module_data` (SMS messages synced from the merchant's Android device).
   - If a match is found and the amount is correct, the transaction is marked as `completed`.
7. **Callback**: QPay sends an asynchronous Webhook (POST) to the WordPress `callback_url` to confirm the order.

---

## 3. Scam Prevention & Loophole Closures

### Loophole A: Double-Spending / Recycled IDs
- **Risk**: A scammer uses a valid Transaction ID from a previous order (or a public screenshot).
- **Block**: We've implemented a **Global ID Block**. Once a Transaction ID is successfully verified, it is blacklisted system-wide in `api_payments`. Attempts to reuse it will fail with `ALREADY_USED`.

### Loophole B: Brute-Force Guessing
- **Risk**: A scammer writes a script to guess IDs (e.g., trying `8X9Y70`, `8X9Y71`...) until a match is found on the merchant's device.
- **Block**: We implemented **Verification Throttling**. If a user fails to verify a payment more than 5 times, that Payment ID is locked for 5 minutes.

### Loophole C: Social Engineering (Fake SMS)
- **Risk**: A scammer sends a fake SMS to the merchant's phone from a regular number.
- **Block**: Our Android app and parser only process SMS from **Authorized Shortcodes** (e.g., `bkash`, `16216`, `nagad`). Messages from regular mobile numbers are ignored by the verification adapter.

### Loophole D: Cross-Brand Stealing
- **Risk**: A merchant has two brands (Brand A and Brand B). A payment for Brand A is "stolen" by one intended for Brand B.
- **Block**: We added **Recipient Number Matching**. Every verification attempt now ensures the SMS was received on the specific number configured for that Brand/Method.

---

## 4. Final Parity Audit: Resolved Gaps

During the final deep-dive comparison with the legacy `qpay-sub` infrastructure, we identified and resolved the last remaining gaps:

| Feature | Legacy Status | Modern Fix | Status |
| :--- | :--- | :--- | :--- |
| **SMS Library** | Broken (CI3) | Re-written for CI4 (Async Support) | ✅ Fixed |
| **ID Encryption** | Custom Map | Ported to `legacy_helper.php` | ✅ Restored |
| **Merchant Alerts** | Manual Trigger | Automated Hook in `PaymentController` | ✅ Integrated |
| **Balance Charging** | Procedural | Unified `decrement('balance')` service | ✅ Enforced |

---

## 5. Summary of 25+ Payment Methods

All methods from the original system are now supported via specialized adapters or manual review flows:
- **API Integrated**: Nagad (Direct), Binance (API), bKash (Tokenized).
- **SMS/Verification Flow**: Bkash (Personal), Rocket, Upay, Cellfin, Tap, Ipay, Ok Wallet, Sure Cash, MCash, myCash.
- **Manual Bank Flow**: Sonali Bank, DBBL, Islamic Bank, AB Bank, City Bank, Basic Bank, EBL Bank, Brac Bank, Bank Asia, Agrani Bank, Jamuna Bank, IFIC Bank, Payeer.


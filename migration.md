# Migration Audit: Original-Code/qpay-sub to Modern Workspace

This document tracks and confirms the completion of logic, configurations, and features migrated from the original `qpay-sub` codebase.

## ✅ Ported & Completed

### 1. Manual SMS Verification (`module_task`)
- **Status**: ✅ **Ported & Enhanced**
- **Location**: `app/Adapters/SmsVerificationAdapter.php`
- **Audit Findings**: The modern version successfully ports the `module_data` search, strict amount regex, and double-spending prevention. It includes a Heartbeat check for merchant devices and improved regex for Rocket/Cellfin.
### 2. Missing Payment Adapters
All listed providers have been mapped to robust adapters:
- ✅ **Binance Pay**: Ported signature logic into `BinanceAdapter.php`.
- ✅ **Manual Banks**: All 15+ banks (Brac, City, Sonali, etc.) are handled by the new `ManualBankAdapter.php`.
- ✅ **Mobile Wallets**: Rocket, Upay, Cellfin, tap, Ipay, Ok Wallet, MCash, myCash are all handled by the enhanced `SmsVerificationAdapter`.
- ✅ **Nagad**: Direct API logic ported and verified.
- ✅ **bKash**: Tokenized API (v1.2.0) implemented.

### 3. Database Unification
- **Status**: ✅ **Resolved**
- **Migration**: Legacy `transactions` have been merged into the `api_payments` table using the `migrate:transactions` CLI command.
- **Unified Viewing**: All systems now point to `api_payments` for real-time and historical data.

---

## 🏗️ Architectural & Schema Audit

### 1. Status Code Mapping
Original `temp_transactions` status codes vs Modern `api_payments` status:
| Original Status | Modern Enum | Status |
| :--- | :--- | :--- |
| `0` | `0` | Pending |
| `1` | `1` | Processing (Processing) |
| `2` | `2` | Completed |
| `3` | `3` | Failed |
| `4` | `4` | Cancelled / Refunded |

### 2. Helper Logic
- [x] **`ms` Helper**: Restored the robust `ms` helper using CI4's Response service with full JSON header support.

---

## 📂 File-by-File Audit

### Controllers
| Original File | Modern Path | Status | Notes |
| :--- | :--- | :--- | :--- |
| `Api.php` | `PaymentController.php` | ✅ Ported | Logic for Create/Verify/Status is present. |
| `Callback.php` | `PaymentController.php` | ✅ Ported | IPN handlers for Binance/Nagad integrated. |

### Models
| Original File | Modern Path | Status | Notes |
| :--- | :--- | :--- | :--- |
| `Api.php` | `SmsVerificationAdapter.php` | ✅ Ported | `module_task` logic successfully ported to the adapter pattern. |

---

## 🎨 UI & Themes Audit
- **Status**: ✅ **Verified**
- **Findings**: Redesigned views in `app/Views/themes/nago` correctly integrate with `PaymentController` and support both Direct API, Binance Pay, and Manual SMS Verification flows.

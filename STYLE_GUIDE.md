# QPay Unified Style Guide

This document defines the coding standards for the QPay project. Adherence to these standards is mandatory for all contributions.

---

## 🐘 PHP (Backend & SDKs)

We follow the **PSR-12** extended standard with additional strict typing requirements.

### 1. Mandatory Declarations
Every PHP file MUST begin with:
```php
<?php declare(strict_types=1);
```

### 2. Type Hinting
- **Methods**: MUST specify return types.
- **Parameters**: MUST specify types where possible.
- **Properties**: MUST specify visibility (`public`, `protected`, `private`) and types (PHP 7.4+).

### 3. Naming Conventions
- **Classes**: `PascalCase` (e.g., `PaymentController`)
- **Methods**: `camelCase` (e.g., `createPayment`)
- **Variables**: `snake_case` (e.g., `$payment_id`) - *This ensures consistency with database column names.*
- **Constants**: `UPPER_SNAKE_CASE` (e.g., `PAYMENT_STATUS_COMPLETED`)

### 4. Arrays
Use short array syntax `[]` exclusively. Avoid `array()`.

---

## ☕ Java (Android)

We follow the **Standard Android/Google Java Style**.

### 1. Naming Conventions
- **Classes**: `PascalCase`
- **Methods/Variables**: `camelCase`
- **Constants**: `UPPER_SNAKE_CASE`

### 2. Resources (XML)
- **Layouts/IDs**: `lowercase_snake_case` (e.g., `activity_main`, `btn_submit`)

---

## 🛠️ Automated Tools

### EditorConfig
A `.editorconfig` file is located in the root directory. Configure your IDE to respect these settings (Tabs -> 4 Spaces, LF line endings).

### PHP-CS-Fixer
To automatically format your PHP code, run:
```bash
./vendor/bin/php-cs-fixer fix
```
*(Configuration is located in `.php-cs-fixer.php`)*

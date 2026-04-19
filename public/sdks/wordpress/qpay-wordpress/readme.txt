=== QPay for WordPress ===
Contributors: qpay
Tags: payment, gateway, bkash, nagad, rocket, mobile banking, bangladesh, donations
Requires at least: 5.8
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.2.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Accept payments via QPay (bKash, Nagad, Rocket, bank transfer and more) on any WordPress site.

== QPay for WordPress vs QPay WooCommerce ==

Which plugin is right for you?

*   **QPay for WordPress (This Plugin)**: Use this if you need a full payment suite. It includes shortcodes for custom payment buttons, donation forms, and general payment forms. It **also includes** the WooCommerce gateway. It is best for sites that need flexible payment options across multiple pages.
*   **QPay WooCommerce Gateway**: Use the standalone [WooCommerce plugin](https://qpay.com/sdks/woocommerce) if you **only** need a payment method for your store checkout and want to keep your site lightweight. It focuses strictly on the WooCommerce experience without extra shortcodes.

== Description ==

QPay for WordPress lets you accept payments from your customers using bKash, Nagad, Rocket, bank transfer, and more — directly on your WordPress site.

**Works on any WordPress site.** No WooCommerce required.

= Features =

* **Payment Buttons** — Add a pay button anywhere with `[qpay_button]`
* **Payment Forms** — Create custom payment forms with `[qpay_form]`
* **Donation Forms** — Accept donations with preset amounts using `[qpay_donate]`
* **WooCommerce Integration** — Optional checkout integration for WooCommerce stores
* **Webhook Support** — Real-time payment status updates
* **Test Mode** — Test payments without processing real transactions
* **Email Notifications** — Automatic emails on payment completion
* **Transaction Management** — View, search, filter, and refund payments from admin
* **Role Management** — QPay Merchant role for team access
* **Form Builder** — Create reusable payment forms from the admin panel

= Shortcodes =

`[qpay_button amount="500" label="Pay Now"]`
Simple payment button with fixed amount.

`[qpay_form fields="name,email,phone,amount"]`
Payment form with customer fields.

`[qpay_donate preset="100,500,1000" custom="yes"]`
Donation form with preset and custom amounts.

= WooCommerce =

If WooCommerce is installed, QPay automatically appears as a payment method in WooCommerce checkout settings. You can enable or disable this from the QPay Settings page.

== Installation ==

1. Upload the `qpay-wordpress` folder to `/wp-content/plugins/`
2. Activate the plugin through the Plugins menu
3. Go to QPay > Settings to configure your API keys
4. Add payment buttons or forms to your pages using shortcodes

== Frequently Asked Questions ==

= Do I need WooCommerce? =
No. QPay works on any WordPress site. WooCommerce integration is optional and auto-detected.

= How do I get API keys? =
Sign up at your QPay dashboard and generate API keys from the API Keys section.

= Can I test without real payments? =
Yes. Enable Test Mode in QPay Settings to simulate payments.

== Changelog ==

= 1.2.0 =
* Fixed missing database table creation on plugin initialization
* Added GET method support to webhook endpoint with active status response
* Improved delivery resilience for various hosting environments
* Improved WooCommerce checkout compatibility

= 1.1.0 =
* Modernized security with qp_ and pk_ key prefixes
* Standardized headers (Authorization: Bearer)
* Improved WooCommerce block support
* Added setup guidance for new security architecture

= 1.0.0 =
* Initial release
* Payment buttons, forms, and donations
* WooCommerce checkout integration
* Admin transaction management
* Webhook handler with signature verification
* Email notifications
* QPay Merchant role

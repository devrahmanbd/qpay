=== QPay Payment Gateway for WooCommerce ===
Contributors: qpay
Tags: payment gateway, bkash, nagad, rocket, bangladesh, woocommerce
Requires at least: 5.8
Tested up to: 6.5
Requires PHP: 7.4
Stable tag: 1.1.0
License: GPLv2 or later

Accept payments via QPay on your WooCommerce store. Supports bKash, Nagad, Rocket, bank transfer and more.

== QPay for WordPress vs QPay WooCommerce ==

Which plugin is right for you?

*   **QPay WooCommerce Gateway (This Plugin)**: Use this if you **only** need a payment method for your store checkout and want to keep your site lightweight. It focuses strictly on the WooCommerce experience without extra shortcodes.
*   **QPay for WordPress**: Use the [full WordPress plugin](https://qpay.com/sdks/wordpress) if you need shortcodes for custom payment buttons, donation forms, and general payment forms in addition to the WooCommerce gateway.

== Description ==

QPay Payment Gateway for WooCommerce lets you accept payments from customers in Bangladesh and South Asia using popular mobile wallets and bank transfers.

**Supported Payment Methods:**
* bKash
* Nagad
* Rocket
* Bank Transfer
* And more...

**Features:**
* Simple setup - just enter your API keys
* Test mode for safe development
* Automatic order status updates via webhooks
* Refund support directly from WooCommerce
* Webhook signature verification for security

== Installation ==

1. Download the plugin ZIP file
2. Go to WordPress Admin > Plugins > Add New > Upload Plugin
3. Upload the ZIP file and click "Install Now"
4. Activate the plugin
5. Go to WooCommerce > Settings > Payments > QPay
6. Enter your QPay API URL and API keys
7. Set your webhook URL in QPay dashboard to: https://yoursite.com/wp-json/qpay/v1/webhook
8. Enter the webhook signing secret
9. Enable the gateway and save

== Configuration ==

= API Keys =
Get your API keys from your QPay merchant dashboard under API Keys section.
* Use test keys (qp_test_...) during development
* Switch to live keys (qp_live_...) for production

= Webhook Setup =
1. In your QPay dashboard, add a webhook endpoint
2. Set the URL to: https://yoursite.com/wp-json/qpay/v1/webhook
3. Select events: payment.created, payment.completed, payment.failed, refund.created
4. Copy the webhook signing secret to WooCommerce settings

== Changelog ==

= 1.1.0 =
* Modernized security with qp_ and pk_ key prefixes
* Standardized headers (Authorization: Bearer)
* Full compatibility with WooCommerce Blocks checkout
* Enhanced webhook validation

= 1.0.0 =
* Initial release
* Payment creation and checkout redirect
* Webhook handling for automatic order updates
* Refund support
* Test mode support

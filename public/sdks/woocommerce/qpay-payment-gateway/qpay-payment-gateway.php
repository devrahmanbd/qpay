<?php
/**
 * Plugin Name: QPay Payment Gateway for WooCommerce
 * Description: Accept payments via QPay (bKash, Nagad, Rocket, bank transfer and more) on your WooCommerce store.
 * Version: 1.0.0
 * Author: QPay
 * Text Domain: qpay-wc
 * Requires Plugins: woocommerce
 * Requires at least: 5.8
 * Requires PHP: 7.4
 */

defined('ABSPATH') || exit;

define('QPAY_WC_VERSION', '1.0.0');
define('QPAY_WC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('QPAY_WC_PLUGIN_URL', plugin_dir_url(__FILE__));

add_action('plugins_loaded', 'qpay_wc_init', 11);

function qpay_wc_init()
{
    if (!class_exists('WC_Payment_Gateway')) {
        add_action('admin_notices', function () {
            echo '<div class="error"><p><strong>QPay Payment Gateway</strong> requires WooCommerce to be installed and active.</p></div>';
        });
        return;
    }

    require_once QPAY_WC_PLUGIN_DIR . 'includes/class-qpay-sdk.php';
    require_once QPAY_WC_PLUGIN_DIR . 'includes/class-qpay-gateway.php';

    add_filter('woocommerce_payment_gateways', function ($gateways) {
        $gateways[] = 'WC_QPay_Gateway';
        return $gateways;
    });
}

add_action('rest_api_init', function () {
    register_rest_route('qpay/v1', '/webhook', [
        'methods' => 'POST',
        'callback' => 'qpay_wc_handle_webhook',
        'permission_callback' => '__return_true',
    ]);
});

function qpay_wc_handle_webhook(WP_REST_Request $request)
{
    $payload = $request->get_body();
    $signature = $request->get_header('QPay-Signature');

    $settings = get_option('woocommerce_qpay_settings', []);
    $secret = $settings['webhook_secret'] ?? '';

    if (empty($secret) || empty($signature)) {
        return new WP_REST_Response(['error' => 'Missing signature'], 400);
    }

    require_once QPAY_WC_PLUGIN_DIR . 'includes/class-qpay-sdk.php';

    if (!WC_QPay_SDK::verifyWebhookSignature($payload, $signature, $secret)) {
        return new WP_REST_Response(['error' => 'Invalid signature'], 401);
    }

    $data = json_decode($payload, true);
    $event = $data['event'] ?? '';
    $paymentData = $data['data'] ?? [];
    $paymentId = $paymentData['id'] ?? '';

    if (empty($paymentId)) {
        return new WP_REST_Response(['error' => 'Missing payment ID'], 400);
    }

    $orders = wc_get_orders([
        'meta_key' => '_qpay_payment_id',
        'meta_value' => $paymentId,
        'limit' => 1,
    ]);

    if (empty($orders)) {
        return new WP_REST_Response(['error' => 'Order not found'], 404);
    }

    $order = $orders[0];

    switch ($event) {
        case 'payment.completed':
            if (!$order->is_paid()) {
                $order->payment_complete($paymentData['transaction_id'] ?? $paymentId);
                $order->add_order_note(sprintf('QPay payment completed. Transaction ID: %s', $paymentData['transaction_id'] ?? $paymentId));
            }
            break;

        case 'payment.failed':
            $order->update_status('failed', sprintf('QPay payment failed. Reason: %s', $paymentData['error'] ?? 'Unknown'));
            break;

        case 'refund.created':
            $order->update_status('refunded', sprintf('QPay refund processed. Refund ID: %s', $paymentData['id'] ?? ''));
            break;

        case 'payment.created':
            if ($order->get_status() === 'pending') {
                $order->update_status('on-hold', 'QPay payment initiated, waiting for completion.');
            }
            break;
    }

    return new WP_REST_Response(['success' => true], 200);
}

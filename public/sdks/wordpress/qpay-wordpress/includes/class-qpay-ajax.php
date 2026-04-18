<?php

defined('ABSPATH') || exit;

class QPay_Ajax
{
    public static function init(): void
    {
        add_action('wp_ajax_qpay_create_payment', [__CLASS__, 'create_payment']);
        add_action('wp_ajax_nopriv_qpay_create_payment', [__CLASS__, 'create_payment']);
    }

    public static function create_payment(): void
    {
        check_ajax_referer('qpay_nonce', 'nonce');

        $amount = (float) ($_POST['amount'] ?? 0);
        $currency = sanitize_text_field($_POST['currency'] ?? 'BDT');
        $description = sanitize_text_field(wp_unslash($_POST['description'] ?? ''));
        $name = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
        $email = sanitize_email($_POST['email'] ?? '');
        $phone = sanitize_text_field($_POST['phone'] ?? '');
        $source = sanitize_text_field($_POST['source'] ?? 'button');
        $success_url = esc_url_raw($_POST['success_url'] ?? get_option('qpay_success_page', ''));
        $cancel_url = esc_url_raw($_POST['cancel_url'] ?? get_option('qpay_cancel_page', ''));
        $method = sanitize_text_field($_POST['method'] ?? '');

        if ($amount <= 0) {
            wp_send_json_error(['message' => __('Please enter a valid amount.', 'qpay')]);
        }

        try {
            $sdk = QPay_Plugin::get_sdk();

            $params = [
                'amount' => $amount,
                'currency' => $currency,
                'success_url' => $success_url ?: home_url('/'),
                'cancel_url' => $cancel_url ?: home_url('/'),
                'callback_url' => rest_url('qpay/v1/webhook'),
                'metadata' => [
                    'source' => $source,
                    'site_url' => get_site_url(),
                    'wp_user_id' => get_current_user_id(),
                ],
            ];

            if (!empty($description)) $params['description'] = $description;
            if (!empty($email)) $params['customer_email'] = $email;
            if (!empty($name)) $params['customer_name'] = $name;
            if (!empty($phone)) $params['customer_phone'] = $phone;
            if (!empty($method)) $params['payment_method'] = $method;

            $result = $sdk->createPayment($params);

            $payment_id = $result['id'] ?? '';
            if (empty($payment_id)) {
                throw new RuntimeException('No payment ID received from QPay.');
            }

            QPay_DB::insert_transaction([
                'payment_id' => $payment_id,
                'source' => $source,
                'amount' => $amount,
                'currency' => $currency,
                'status' => 'pending',
                'customer_name' => $name ?: null,
                'customer_email' => $email ?: null,
                'customer_phone' => $phone ?: null,
                'description' => $description ?: null,
                'test_mode' => QPay_Plugin::is_test_mode() ? 1 : 0,
                'metadata' => wp_json_encode($params['metadata']),
                'ip_address' => $_SERVER['REMOTE_ADDR'] ?? null,
            ]);

            $redirect_url = $result['checkout_url'] ?? $result['redirect_url'] ?? '';

            wp_send_json_success([
                'payment_id' => $payment_id,
                'redirect_url' => $redirect_url,
            ]);

        } catch (Exception $e) {
            wp_send_json_error(['message' => $e->getMessage()]);
        }
    }
}

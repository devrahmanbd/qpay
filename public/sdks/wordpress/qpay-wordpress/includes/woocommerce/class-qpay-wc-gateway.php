<?php

defined('ABSPATH') || exit;

class QPay_WC_Gateway extends WC_Payment_Gateway
{
    protected $test_mode;

    public function __construct()
    {
        $this->id = 'qpay';
        $this->icon = '';
        $this->has_fields = false;
        $this->method_title = 'QPay';
        $this->method_description = 'Accept payments via QPay (bKash, Nagad, Rocket, bank transfer and more).';
        $this->supports = ['products', 'refunds'];

        $this->init_form_fields();
        $this->init_settings();

        $this->title = $this->get_option('title', 'QPay');
        $this->description = $this->get_option('description', 'Pay securely using bKash, Nagad, Rocket or bank transfer.');
        $this->enabled = $this->get_option('enabled', 'no');
        $this->test_mode = QPay_Plugin::is_test_mode();

        if ($this->test_mode) {
            $this->description .= ' <strong>(TEST MODE)</strong>';
        }

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
        add_action('woocommerce_api_qpay_callback', [$this, 'handle_callback']);
    }

    public function init_form_fields()
    {
        $this->form_fields = [
            'enabled' => [
                'title' => __('Enable/Disable', 'qpay'),
                'type' => 'checkbox',
                'label' => __('Enable QPay Payment Gateway', 'qpay'),
                'default' => 'no',
            ],
            'title' => [
                'title' => __('Title', 'qpay'),
                'type' => 'text',
                'description' => __('Payment method title shown at checkout.', 'qpay'),
                'default' => 'QPay',
                'desc_tip' => true,
            ],
            'description' => [
                'title' => __('Description', 'qpay'),
                'type' => 'textarea',
                'description' => __('Payment method description shown at checkout.', 'qpay'),
                'default' => 'Pay securely using bKash, Nagad, Rocket or bank transfer.',
            ],
            'enabled_methods' => [
                'title' => __('Payment Methods', 'qpay'),
                'type' => 'multiselect',
                'description' => __('Select which QPay payment methods to offer. Leave empty for all.', 'qpay'),
                'default' => '',
                'options' => [
                    'bkash' => 'bKash',
                    'nagad' => 'Nagad',
                    'rocket' => 'Rocket',
                    'upay' => 'Upay',
                    'bank' => 'Bank Transfer',
                    'card' => 'Card Payment',
                ],
                'class' => 'wc-enhanced-select',
                'css' => 'width: 400px;',
            ],
            'info' => [
                'title' => __('Configuration', 'qpay'),
                'type' => 'title',
                'description' => sprintf(
                    __('API keys and webhook settings are managed in the <a href="%s">QPay Settings</a> page.', 'qpay'),
                    admin_url('admin.php?page=qpay-settings')
                ),
            ],
        ];
    }

    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);

        if (!$order) {
            wc_add_notice(__('Order not found.', 'qpay'), 'error');
            return ['result' => 'failure'];
        }

        try {
            $sdk = QPay_Plugin::get_sdk();

            $params = [
                'amount' => (float) $order->get_total(),
                'currency' => $order->get_currency(),
                'customer_email' => $order->get_billing_email(),
                'customer_name' => trim($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()),
                'callback_url' => rest_url('qpay/v1/webhook'),
                'success_url' => $this->get_return_url($order),
                'cancel_url' => $order->get_cancel_order_url_raw(),
                'metadata' => [
                    'order_id' => $order_id,
                    'order_key' => $order->get_order_key(),
                    'site_url' => get_site_url(),
                    'source' => 'woocommerce',
                ],
            ];

            $enabledMethods = $this->get_option('enabled_methods', []);
            if (!empty($enabledMethods) && is_array($enabledMethods)) {
                $params['allowed_methods'] = $enabledMethods;
            }

            $result = $sdk->createPayment($params);

            $paymentId = $result['id'] ?? '';
            $checkoutUrl = $result['checkout_url'] ?? '';

            if (empty($paymentId)) {
                throw new RuntimeException(__('No payment ID received from QPay.', 'qpay'));
            }

            $order->update_meta_data('_qpay_payment_id', $paymentId);
            $order->update_meta_data('_qpay_test_mode', $this->test_mode ? 'yes' : 'no');
            $order->save();

            QPay_DB::insert_transaction([
                'payment_id' => $paymentId,
                'source' => 'woocommerce',
                'wc_order_id' => $order_id,
                'amount' => (float) $order->get_total(),
                'currency' => $order->get_currency(),
                'status' => 'pending',
                'customer_name' => trim($order->get_billing_first_name() . ' ' . $order->get_billing_last_name()),
                'customer_email' => $order->get_billing_email(),
                'customer_phone' => $order->get_billing_phone(),
                'description' => sprintf(__('WooCommerce Order #%d', 'qpay'), $order_id),
                'test_mode' => $this->test_mode ? 1 : 0,
                'metadata' => wp_json_encode($params['metadata']),
                'ip_address' => $order->get_customer_ip_address(),
            ]);

            $order->update_status('pending', sprintf(__('QPay payment initiated. Payment ID: %s', 'qpay'), $paymentId));

            WC()->cart->empty_cart();

            if (!empty($checkoutUrl)) {
                return ['result' => 'success', 'redirect' => $checkoutUrl];
            }

            return ['result' => 'success', 'redirect' => $this->get_return_url($order)];

        } catch (Exception $e) {
            wc_add_notice(__('Payment error: ', 'qpay') . $e->getMessage(), 'error');
            $order->add_order_note('QPay payment error: ' . $e->getMessage());
            return ['result' => 'failure'];
        }
    }

    public function handle_callback()
    {
        $paymentId = sanitize_text_field($_GET['payment_id'] ?? '');
        $orderKey = sanitize_text_field($_GET['order_key'] ?? '');

        if (empty($paymentId) || empty($orderKey)) {
            wp_die(__('Invalid callback parameters.', 'qpay'), 'QPay Error', ['response' => 400]);
        }

        $orderId = wc_get_order_id_by_order_key($orderKey);
        $order = wc_get_order($orderId);

        if (!$order) {
            wp_die(__('Order not found.', 'qpay'), 'QPay Error', ['response' => 404]);
        }

        try {
            $sdk = QPay_Plugin::get_sdk();
            $status = $sdk->verifyPayment($paymentId);

            $verified = $status['verified'] ?? false;
            $paymentStatus = $status['status'] ?? '';

            if ($verified && $paymentStatus === 'completed') {
                $order->payment_complete($status['transaction_id'] ?? $paymentId);
                $order->add_order_note(__('QPay payment verified and completed.', 'qpay'));
                wp_redirect($this->get_return_url($order));
                exit;
            }

            if ($paymentStatus === 'processing') {
                $order->update_status('on-hold', __('QPay payment is processing.', 'qpay'));
                wp_redirect($this->get_return_url($order));
                exit;
            }

            $order->update_status('failed', __('QPay payment verification failed.', 'qpay'));
            wp_redirect($order->get_cancel_order_url_raw());
            exit;
        } catch (Exception $e) {
            $order->add_order_note('QPay verification error: ' . $e->getMessage());
            wp_redirect($order->get_cancel_order_url_raw());
            exit;
        }
    }

    public function process_refund($order_id, $amount = null, $reason = '')
    {
        $order = wc_get_order($order_id);
        $paymentId = $order->get_meta('_qpay_payment_id');

        if (empty($paymentId)) {
            return new WP_Error('qpay_refund_error', __('No QPay payment ID found for this order.', 'qpay'));
        }

        try {
            $sdk = QPay_Plugin::get_sdk();
            $result = $sdk->createRefund($paymentId, $reason ?: sprintf(__('Refund for order #%d', 'qpay'), $order_id));

            $order->add_order_note(sprintf(
                __('QPay refund processed. Refund ID: %s, Amount: %s', 'qpay'),
                $result['id'] ?? 'N/A',
                wc_price($amount)
            ));

            return true;
        } catch (Exception $e) {
            return new WP_Error('qpay_refund_error', __('QPay refund failed: ', 'qpay') . $e->getMessage());
        }
    }
}

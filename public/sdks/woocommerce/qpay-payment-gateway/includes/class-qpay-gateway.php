<?php

defined('ABSPATH') || exit;

class WC_QPay_Gateway extends WC_Payment_Gateway
{
    protected $api_key;
    protected $api_url;
    protected $webhook_secret;
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
        $this->test_mode = $this->get_option('test_mode', 'yes') === 'yes';
        $this->api_url = rtrim($this->get_option('api_url', ''), '/');
        $this->webhook_secret = $this->get_option('webhook_secret', '');

        if ($this->test_mode) {
            $this->api_key = $this->get_option('test_secret_key', '');
            $this->description .= ' <strong>(TEST MODE)</strong>';
        } else {
            $this->api_key = $this->get_option('live_secret_key', '');
        }

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
        add_action('woocommerce_api_qpay_callback', [$this, 'handle_callback']);
    }

    public function init_form_fields()
    {
        $webhook_url = rest_url('qpay/v1/webhook');

        $this->form_fields = [
            'enabled' => [
                'title' => 'Enable/Disable',
                'type' => 'checkbox',
                'label' => 'Enable QPay Payment Gateway',
                'default' => 'no',
            ],
            'title' => [
                'title' => 'Title',
                'type' => 'text',
                'description' => 'Payment method title shown at checkout.',
                'default' => 'QPay',
                'desc_tip' => true,
            ],
            'description' => [
                'title' => 'Description',
                'type' => 'textarea',
                'description' => 'Payment method description shown at checkout.',
                'default' => 'Pay securely using bKash, Nagad, Rocket or bank transfer.',
            ],
            'api_url' => [
                'title' => 'QPay API URL',
                'type' => 'url',
                'description' => 'Your QPay gateway URL (e.g. https://pay.yourdomain.com).',
                'default' => '',
            ],
            'test_mode' => [
                'title' => 'Test Mode',
                'type' => 'checkbox',
                'label' => 'Enable test mode (uses test API keys)',
                'default' => 'yes',
                'description' => 'In test mode, no real payments are processed.',
            ],
            'test_secret_key' => [
                'title' => 'Test Secret Key',
                'type' => 'password',
                'description' => 'Your QPay test secret key (sk_test_...).',
                'default' => '',
            ],
            'test_publishable_key' => [
                'title' => 'Test Publishable Key',
                'type' => 'password',
                'description' => 'Your QPay test publishable key (pk_test_...).',
                'default' => '',
            ],
            'live_secret_key' => [
                'title' => 'Live Secret Key',
                'type' => 'password',
                'description' => 'Your QPay live secret key (sk_live_...).',
                'default' => '',
            ],
            'live_publishable_key' => [
                'title' => 'Live Publishable Key',
                'type' => 'password',
                'description' => 'Your QPay live publishable key (pk_live_...).',
                'default' => '',
            ],
            'webhook_secret' => [
                'title' => 'Webhook Signing Secret',
                'type' => 'password',
                'description' => 'Your QPay webhook signing secret (whsec_...). <br>Webhook URL: <code>' . esc_html($webhook_url) . '</code>',
                'default' => '',
            ],
            'enabled_methods' => [
                'title' => 'Payment Methods',
                'type' => 'multiselect',
                'description' => 'Select which QPay payment methods to offer at checkout. Leave empty to show all available methods.',
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
        ];
    }

    public function process_payment($order_id)
    {
        $order = wc_get_order($order_id);

        if (!$order) {
            wc_add_notice('Order not found.', 'error');
            return ['result' => 'failure'];
        }

        try {
            $sdk = new WC_QPay_SDK($this->api_key, $this->api_url);

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
                throw new \RuntimeException('No payment ID received from QPay.');
            }

            $order->update_meta_data('_qpay_payment_id', $paymentId);
            $order->update_meta_data('_qpay_test_mode', $this->test_mode ? 'yes' : 'no');
            $order->save();

            $order->update_status('pending', sprintf('QPay payment initiated. Payment ID: %s', $paymentId));

            WC()->cart->empty_cart();

            if (!empty($checkoutUrl)) {
                return [
                    'result' => 'success',
                    'redirect' => $checkoutUrl,
                ];
            }

            return [
                'result' => 'success',
                'redirect' => $this->get_return_url($order),
            ];
        } catch (\Exception $e) {
            wc_add_notice('Payment error: ' . $e->getMessage(), 'error');
            $order->add_order_note('QPay payment error: ' . $e->getMessage());
            return ['result' => 'failure'];
        }
    }

    public function handle_callback()
    {
        $paymentId = sanitize_text_field($_GET['payment_id'] ?? '');
        $orderKey = sanitize_text_field($_GET['order_key'] ?? '');

        if (empty($paymentId) || empty($orderKey)) {
            wp_die('Invalid callback parameters.', 'QPay Error', ['response' => 400]);
        }

        $orderId = wc_get_order_id_by_order_key($orderKey);
        $order = wc_get_order($orderId);

        if (!$order) {
            wp_die('Order not found.', 'QPay Error', ['response' => 404]);
        }

        try {
            $sdk = new WC_QPay_SDK($this->api_key, $this->api_url);
            $status = $sdk->verifyPayment($paymentId);

            $verified = $status['verified'] ?? false;
            $paymentStatus = $status['status'] ?? '';

            if ($verified && $paymentStatus === 'completed') {
                $order->payment_complete($status['transaction_id'] ?? $paymentId);
                $order->add_order_note('QPay payment verified and completed.');
                wp_redirect($this->get_return_url($order));
                exit;
            }

            if ($paymentStatus === 'processing') {
                $order->update_status('on-hold', 'QPay payment is processing.');
                wp_redirect($this->get_return_url($order));
                exit;
            }

            $order->update_status('failed', 'QPay payment verification failed.');
            wp_redirect($order->get_cancel_order_url_raw());
            exit;
        } catch (\Exception $e) {
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
            return new WP_Error('qpay_refund_error', 'No QPay payment ID found for this order.');
        }

        try {
            $sdk = new WC_QPay_SDK($this->api_key, $this->api_url);
            $result = $sdk->createRefund($paymentId, $reason ?: "Refund for order #{$order_id}");

            $order->add_order_note(sprintf(
                'QPay refund processed. Refund ID: %s, Amount: %s',
                $result['id'] ?? 'N/A',
                wc_price($amount)
            ));

            return true;
        } catch (\Exception $e) {
            return new WP_Error('qpay_refund_error', 'QPay refund failed: ' . $e->getMessage());
        }
    }

}

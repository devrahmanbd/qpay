<?php

defined('ABSPATH') || exit;

class QPay_WC_Gateway extends WC_Payment_Gateway
{
    public function __construct()
    {
        $this->id = 'qpay';
        $this->icon = QPAY_PLUGIN_URL . 'assets/images/qpay-icon.png';
        $this->has_fields = false;
        $this->method_title = __('QPay', 'qpay');
        $this->method_description = __('Accept payments via bKash, Nagad, Rocket, and more using QPay.', 'qpay');

        $this->init_form_fields();
        $this->init_settings();

        $this->title = $this->get_option('title', __('QPay (Mobile Banking / Cards)', 'qpay'));
        $this->description = $this->get_option('description', __('Pay securely via bKash, Nagad, Rocket, or Bank Transfer.', 'qpay'));
        
        $global_enabled = get_option('qpay_enable_woocommerce', 'yes') === 'yes';
        $this->enabled = ($global_enabled) ? $this->get_option('enabled', 'yes') : 'no';

        add_action('woocommerce_update_options_payment_gateways_' . $this->id, [$this, 'process_admin_options']);
    }

    public function init_form_fields(): void
    {
        $this->form_fields = [
            'enabled' => [
                'title' => __('Enable/Disable', 'qpay'),
                'type' => 'checkbox',
                'label' => __('Enable QPay Payment', 'qpay'),
                'default' => 'yes',
            ],
            'title' => [
                'title' => __('Title', 'qpay'),
                'type' => 'text',
                'description' => __('This controls the title which the user sees during checkout.', 'qpay'),
                'default' => __('QPay (Mobile Banking / Cards)', 'qpay'),
                'desc_tip' => true,
            ],
            'description' => [
                'title' => __('Description', 'qpay'),
                'type' => 'textarea',
                'description' => __('This controls the description which the user sees during checkout.', 'qpay'),
                'default' => __('Pay securely via bKash, Nagad, Rocket, or Bank Transfer.', 'qpay'),
            ],
        ];
    }

    public function is_available(): bool
    {
        return get_option('qpay_enable_woocommerce', 'yes') === 'yes';
    }

    public function process_payment($order_id): array
    {
        $order = wc_get_order($order_id);

        try {
            $sdk = QPay_Plugin::get_sdk();

            $params = [
                'amount' => $order->get_total(),
                'currency' => $order->get_currency(),
                'success_url' => $this->get_return_url($order),
                'cancel_url' => $order->get_cancel_order_url(),
                'customer_name' => $order->get_billing_first_name() . ' ' . $order->get_billing_last_name(),
                'customer_email' => $order->get_billing_email(),
                'customer_phone' => $order->get_billing_phone(),
                'description' => sprintf(__('Order #%s at %s', 'qpay'), $order->get_order_number(), get_bloginfo('name')),
                'metadata' => [
                    'order_id' => $order_id,
                    'source' => 'woocommerce',
                ],
            ];

            $result = $sdk->createPayment($params);

            if (empty($result['id'])) {
                throw new Exception(__('Failed to create payment on QPay server.', 'qpay'));
            }

            // Store QPay Payment ID in Order Metadata
            $order->update_meta_data('_qpay_payment_id', $result['id']);
            $order->save();

            $redirect_url = $result['checkout_url'] ?? $result['redirect_url'] ?? '';

            return [
                'result' => 'success',
                'redirect' => $redirect_url,
            ];

        } catch (Exception $e) {
            wc_add_notice('QPay Error: ' . $e->getMessage(), 'error');
            return [
                'result' => 'fail',
                'redirect' => '',
            ];
        }
    }
}

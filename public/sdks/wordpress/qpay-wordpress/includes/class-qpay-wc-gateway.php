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
        add_action('woocommerce_thankyou_' . $this->id, [$this, 'check_payment_response']);
    }

    /**
     * Verify payment when customer returns to site (Synchronous fallback)
     */
    public function check_payment_response($order_id)
    {
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }

        // Only process if it's currently pending or failed (to allow retry)
        if (!$order->has_status(['pending', 'failed', 'on-hold'])) {
            return;
        }

        $payment_id = isset($_GET['payment_id']) ? sanitize_text_field($_GET['payment_id']) : '';
        
        if (empty($payment_id)) {
            $payment_id = $order->get_meta('_qpay_payment_id');
        }

        if (empty($payment_id)) {
            return;
        }

        try {
            $sdk = QPay_Plugin::get_sdk();
            $result = $sdk->verifyPayment($payment_id);

            if (!empty($result['status']) && $result['status'] === 'COMPLETED') {
                $order->payment_complete($result['transaction_id'] ?? '');
                $order->add_order_note(sprintf(__('QPay Payment Verified via Return Callback. Transaction ID: %s', 'qpay'), $result['transaction_id'] ?? 'N/A'));
                
                // Update local DB status if not already updated by webhook
                QPay_DB::update_transaction($payment_id, [
                    'status' => 'completed',
                    'transaction_id' => $result['transaction_id'] ?? null,
                    'updated_at' => current_time('mysql')
                ]);
            } elseif (!empty($result['status']) && $result['status'] === 'PENDING_REVIEW') {
                $order->update_status('on-hold', __('QPay: Payment currently under review (IP/Session mismatch).', 'qpay'));
            }
        } catch (Exception $e) {
            error_log('QPay Return Verification Error: ' . $e->getMessage());
        }
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
                'customer_ip' => $order->get_customer_ip_address(),
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

            // Register transaction in QPay Local Table for sync/webhooks
            QPay_DB::insert_transaction([
                'payment_id'     => $result['id'],
                'source'         => 'woocommerce',
                'wc_order_id'    => $order_id,
                'amount'         => $order->get_total(),
                'currency'       => $order->get_currency(),
                'status'         => 'pending',
                'customer_name'  => $params['customer_name'],
                'customer_email' => $params['customer_email'],
                'customer_phone' => $params['customer_phone'],
                'description'    => $params['description'],
                'test_mode'      => QPay_Plugin::is_test_mode() ? 1 : 0,
                'ip_address'     => $params['customer_ip'] ?? '',
                'created_at'     => current_time('mysql'),
                'updated_at'     => current_time('mysql'),
            ]);

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

<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

defined('ABSPATH') || exit;

/**
 * QPay Blocks Support
 * Enables QPay to show up in the modern WooCommerce Checkout Block.
 */
class QPay_Blocks_Support extends AbstractPaymentMethodType
{
    protected $name = 'qpay';

    public function initialize()
    {
        $this->settings = get_option('woocommerce_qpay_settings', []);
    }

    public function is_active()
    {
        return !empty($this->settings['enabled']) && 'yes' === $this->settings['enabled'];
    }

    public function get_payment_method_script_handles()
    {
        wp_register_script(
            'qpay-blocks-integration',
            QPAY_PLUGIN_URL . 'assets/js/qpay-blocks.js',
            ['wp-blocks', 'wp-element', 'wp-data', 'wp-i18n', 'wp-components'],
            QPAY_VERSION,
            true
        );

        return ['qpay-blocks-integration'];
    }

    public function get_payment_method_data()
    {
        return [
            'title' => $this->settings['title'] ?? __('QPay', 'qpay'),
            'description' => $this->settings['description'] ?? __('Pay securely via bKash, Nagad, Rocket, or Bank Transfer.', 'qpay'),
            'icon' => QPAY_PLUGIN_URL . 'assets/images/qpay-icon.png',
            'supports' => $this->get_supported_features(),
        ];
    }

    public function get_supported_features()
    {
        return ['products'];
    }
}

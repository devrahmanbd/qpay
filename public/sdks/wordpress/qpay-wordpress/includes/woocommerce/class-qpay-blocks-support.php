<?php

use Automattic\WooCommerce\Blocks\Payments\Integrations\AbstractPaymentMethodType;

defined('ABSPATH') || exit;

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
            ['wc-blocks-registry', 'wc-settings', 'wp-element', 'wp-html-entities', 'wp-i18n'],
            QPAY_VERSION,
            true
        );

        return ['qpay-blocks-integration'];
    }

    public function get_payment_method_data()
    {
        return [
            'title' => $this->get_setting('title', 'QPay'),
            'description' => $this->get_setting('description', 'Pay securely via qpay.'),
            'supports' => array_filter($this->get_supported_features()),
            'logo_url' => QPAY_PLUGIN_URL . 'assets/images/qpay-logo.png', // Fallback if exists
            'test_mode' => QPay_Plugin::is_test_mode(),
        ];
    }

    protected function get_setting($key, $default = '')
    {
        return $this->settings[$key] ?? $default;
    }

    public function get_supported_features()
    {
        return ['products', 'refunds'];
    }
}

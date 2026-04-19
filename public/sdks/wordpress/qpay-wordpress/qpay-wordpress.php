<?php
/**
 * Plugin Name: QPay for WordPress
 * Description: Accept payments via QPay (bKash, Nagad, Rocket, bank transfer and more) on any WordPress site. Includes payment buttons, forms, donations, and optional WooCommerce checkout integration.
 * Version: 1.3.1
 * Author: QPay
 * Text Domain: qpay
 * Requires at least: 5.8
 * Requires PHP: 7.4
 * License: GPL v2 or later
 */

defined('ABSPATH') || exit;

define('QPAY_VERSION', '1.3.1');
define('QPAY_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('QPAY_PLUGIN_URL', plugin_dir_url(__FILE__));
define('QPAY_PLUGIN_BASE', plugin_basename(__FILE__));

final class QPay_Plugin
{
    private static $instance = null;

    public static function instance(): self
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->includes();
        $this->hooks();
    }

    private function includes(): void
    {
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-sdk.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-db.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-admin.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-shortcodes.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-forms.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-webhooks.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-transactions.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-roles.php';
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-ajax.php';
    }

    private function hooks(): void
    {
        register_activation_hook(__FILE__, [$this, 'activate']);
        register_deactivation_hook(__FILE__, [$this, 'deactivate']);

        add_action('init', [$this, 'init']);
        add_action('plugins_loaded', [$this, 'load_woocommerce'], 20);
        add_action('wp_enqueue_scripts', [$this, 'frontend_assets']);
        add_action('rest_api_init', [$this, 'register_rest_routes']);

        QPay_Admin::init();
        QPay_Shortcodes::init();
        QPay_Forms::init();
        QPay_Ajax::init();
    }

    public function activate(): void
    {
        QPay_DB::create_tables();
        QPay_Roles::create_roles();

        $defaults = [
            'api_url' => '',
            'test_mode' => 'yes',
            'test_secret_key' => '',
            'test_publishable_key' => '',
            'live_secret_key' => '',
            'live_publishable_key' => '',
            'webhook_secret' => '',
            'enable_woocommerce' => 'yes',
            'enable_buttons' => 'yes',
            'enable_forms' => 'yes',
            'enable_donations' => 'yes',
            'success_page' => '',
            'cancel_page' => '',
            'email_notifications' => 'yes',
            'admin_email' => get_option('admin_email'),
        ];

        foreach ($defaults as $key => $value) {
            if (get_option("qpay_{$key}") === false) {
                add_option("qpay_{$key}", $value);
            }
        }

        flush_rewrite_rules();
    }

    public function deactivate(): void
    {
        flush_rewrite_rules();
    }

    public function init(): void
    {
        load_plugin_textdomain('qpay', false, dirname(QPAY_PLUGIN_BASE) . '/languages');

        // Ensure tables exist on every load for resilience
        if (get_option('qpay_db_version') !== QPAY_VERSION) {
            QPay_DB::create_tables();
        }
    }

    public function load_woocommerce(): void
    {
        if (class_exists('WC_Payment_Gateway') && get_option('qpay_enable_woocommerce', 'yes') === 'yes') {
            require_once QPAY_PLUGIN_DIR . 'includes/woocommerce/class-qpay-wc-gateway.php';
            add_filter('woocommerce_payment_gateways', function ($gateways) {
                $gateways[] = 'QPay_WC_Gateway';
                return $gateways;
            });

            // Add support for WooCommerce Checkout Blocks
            add_action('woocommerce_blocks_payment_method_type_registration', function ($payment_method_registry) {
                require_once QPAY_PLUGIN_DIR . 'includes/woocommerce/class-qpay-blocks-support.php';
                $payment_method_registry->register(new QPay_Blocks_Support());
            });
        }
    }

    public function frontend_assets(): void
    {
        wp_register_style('qpay-frontend', QPAY_PLUGIN_URL . 'assets/css/qpay-frontend.css', [], QPAY_VERSION);
        wp_register_script('qpay-frontend', QPAY_PLUGIN_URL . 'assets/js/qpay-frontend.js', [], QPAY_VERSION, true);
        wp_localize_script('qpay-frontend', 'qpay_vars', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'rest_url' => rest_url('qpay/v1/'),
            'nonce' => wp_create_nonce('qpay_nonce'),
            'test_mode' => get_option('qpay_test_mode', 'yes'),
            'currency' => 'BDT',
            'i18n' => [
                'processing' => __('Processing...', 'qpay'),
                'error' => __('An error occurred. Please try again.', 'qpay'),
                'success' => __('Payment successful!', 'qpay'),
                'invalid_amount' => __('Please enter a valid amount.', 'qpay'),
                'required_field' => __('This field is required.', 'qpay'),
            ],
        ]);
    }

    public function register_rest_routes(): void
    {
        QPay_Webhooks::register_routes();
    }

    public static function get_sdk(): QPay_SDK
    {
        $test_mode = get_option('qpay_test_mode', 'yes') === 'yes';
        $api_key = $test_mode
            ? get_option('qpay_test_secret_key', '')
            : get_option('qpay_live_secret_key', '');
        $api_url = get_option('qpay_api_url', '');

        return new QPay_SDK($api_key, $api_url);
    }

    public static function is_test_mode(): bool
    {
        return get_option('qpay_test_mode', 'yes') === 'yes';
    }
}

function qpay(): QPay_Plugin
{
    return QPay_Plugin::instance();
}

qpay();

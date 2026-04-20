<?php

defined('ABSPATH') || exit;

class QPay_Editor
{
    public static function init(): void
    {
        // Gutenberg support
        add_action('init', [__CLASS__, 'register_block']);
        
        // Classic Editor support
        if (is_admin()) {
            add_action('admin_head', [__CLASS__, 'add_mce_button']);
        }

        // Elementor support
        add_action('elementor/widgets/register', [__CLASS__, 'register_elementor_widget']);
    }

    public static function register_block(): void
    {
        if (!function_exists('register_block_type')) {
            return;
        }

        wp_register_script(
            'qpay-block-editor',
            QPAY_PLUGIN_URL . 'assets/js/qpay-editor.js',
            ['wp-blocks', 'wp-element', 'wp-editor', 'wp-components'],
            QPAY_VERSION
        );

        register_block_type('qpay/payment-button', [
            'editor_script' => 'qpay-block-editor',
            'render_callback' => [__CLASS__, 'render_block'],
            'attributes' => [
                'amount' => ['type' => 'string', 'default' => '100'],
                'label' => ['type' => 'string', 'default' => 'Pay Now'],
                'description' => ['type' => 'string', 'default' => ''],
            ],
        ]);
    }

    public static function render_block($attributes): string
    {
        $amount = esc_attr($attributes['amount'] ?? '100');
        $label = esc_attr($attributes['label'] ?? 'Pay Now');
        $desc = esc_attr($attributes['description'] ?? '');

        return do_shortcode("[qpay_button amount='{$amount}' label='{$label}' description='{$desc}']");
    }

    public static function add_mce_button(): void
    {
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        if (get_user_option('rich_editing') !== 'true') {
            return;
        }

        add_filter('mce_external_plugins', [__CLASS__, 'add_mce_plugin']);
        add_filter('mce_buttons', [__CLASS__, 'register_mce_button']);
    }

    public static function add_mce_plugin($plugin_array): array
    {
        $plugin_array['qpay_mce_button'] = QPAY_PLUGIN_URL . 'assets/js/qpay-editor.js';
        return $plugin_array;
    }

    public static function register_mce_button($buttons): array
    {
        array_push($buttons, 'qpay_mce_button');
        return $buttons;
    }

    public static function register_elementor_widget($widgets_manager): void
    {
        require_once QPAY_PLUGIN_DIR . 'includes/class-qpay-elementor-widget.php';
        $widgets_manager->register(new \QPay_Elementor_Widget());
    }
}

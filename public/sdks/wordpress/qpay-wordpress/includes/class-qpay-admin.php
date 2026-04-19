<?php

defined('ABSPATH') || exit;

class QPay_Admin
{
    public static function init(): void
    {
        add_action('admin_menu', [__CLASS__, 'add_menu']);
        add_action('admin_init', [__CLASS__, 'register_settings']);
        add_action('admin_enqueue_scripts', [__CLASS__, 'admin_assets']);
        add_filter('plugin_action_links_' . QPAY_PLUGIN_BASE, [__CLASS__, 'action_links']);
    }

    public static function action_links(array $links): array
    {
        $settings_link = '<a href="' . admin_url('admin.php?page=qpay-settings') . '">' . __('Settings', 'qpay') . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }

    public static function add_menu(): void
    {
        $capability = 'manage_qpay';
        if (!current_user_can($capability)) {
            $capability = 'manage_options';
        }

        add_menu_page(
            __('QPay', 'qpay'),
            __('QPay', 'qpay'),
            $capability,
            'qpay',
            [__CLASS__, 'page_transactions'],
            'dashicons-money-alt',
            56
        );

        add_submenu_page('qpay', __('Transactions', 'qpay'), __('Transactions', 'qpay'), $capability, 'qpay', [__CLASS__, 'page_transactions']);
        add_submenu_page('qpay', __('Forms', 'qpay'), __('Forms', 'qpay'), $capability, 'qpay-forms', [__CLASS__, 'page_forms']);
        add_submenu_page('qpay', __('Settings', 'qpay'), __('Settings', 'qpay'), 'manage_options', 'qpay-settings', [__CLASS__, 'page_settings']);
    }

    public static function register_settings(): void
    {
        $settings = [
            'qpay_api_url', 'qpay_test_mode',
            'qpay_test_secret_key', 'qpay_test_publishable_key',
            'qpay_live_secret_key', 'qpay_live_publishable_key',
            'qpay_webhook_secret',
            'qpay_enable_woocommerce', 'qpay_enable_buttons',
            'qpay_enable_forms', 'qpay_enable_donations',
            'qpay_success_page', 'qpay_cancel_page',
            'qpay_email_notifications', 'qpay_admin_email',
        ];

        foreach ($settings as $setting) {
            register_setting('qpay_settings', $setting, ['sanitize_callback' => 'sanitize_text_field']);
        }
    }

    public static function admin_assets($hook): void
    {
        if (strpos($hook, 'qpay') === false) {
            return;
        }
        wp_enqueue_style('qpay-admin', QPAY_PLUGIN_URL . 'assets/css/qpay-admin.css', [], QPAY_VERSION);
    }

    public static function page_settings(): void
    {
        if (isset($_POST['qpay_save_settings']) && check_admin_referer('qpay_settings_nonce')) {
            $fields = [
                'qpay_api_url', 'qpay_test_secret_key', 'qpay_test_publishable_key',
                'qpay_live_secret_key', 'qpay_live_publishable_key', 'qpay_webhook_secret',
                'qpay_success_page', 'qpay_cancel_page', 'qpay_admin_email',
            ];
            foreach ($fields as $field) {
                if (isset($_POST[$field])) {
                    update_option($field, sanitize_text_field(wp_unslash($_POST[$field])));
                }
            }

            $checkboxes = ['qpay_test_mode', 'qpay_enable_woocommerce', 'qpay_enable_buttons', 'qpay_enable_forms', 'qpay_enable_donations', 'qpay_email_notifications'];
            foreach ($checkboxes as $cb) {
                update_option($cb, isset($_POST[$cb]) ? 'yes' : 'no');
            }

            echo '<div class="notice notice-success"><p>' . esc_html__('Settings saved.', 'qpay') . '</p></div>';
        }

        $woo_active = class_exists('WooCommerce');
        if ($woo_active && get_option('qpay_enable_woocommerce', 'yes') === 'yes') {
            $wc_settings = get_option('woocommerce_qpay_settings', []);
            if (empty($wc_settings['enabled']) || 'yes' !== $wc_settings['enabled']) {
                echo '<div class="notice notice-warning is-dismissible"><p><strong>' . esc_html__('Action Required:', 'qpay') . '</strong> ' . sprintf(
                    __('QPay is enabled but the payment gateway is currently disabled in WooCommerce. Please <a href="%s">enable it here</a> to show it at checkout.', 'qpay'),
                    admin_url('admin.php?page=wc-settings&tab=checkout&section=qpay')
                ) . '</p></div>';
            }
        }

        $webhook_url = rest_url('qpay/v1/webhook');
        ?>
        <div class="wrap qpay-admin">
            <h1><?php esc_html_e('QPay Settings', 'qpay'); ?></h1>

            <?php if (get_option('qpay_test_mode', 'yes') === 'yes'): ?>
                <div class="notice notice-warning"><p><strong><?php esc_html_e('Test Mode is active.', 'qpay'); ?></strong> <?php esc_html_e('No real payments will be processed.', 'qpay'); ?></p></div>
            <?php endif; ?>

            <form method="post">
                <?php wp_nonce_field('qpay_settings_nonce'); ?>

                <div class="qpay-settings-grid">

                    <div class="qpay-card">
                        <h2><?php esc_html_e('API Connection', 'qpay'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><label for="qpay_api_url"><?php esc_html_e('QPay API URL', 'qpay'); ?></label></th>
                                <td><input type="url" id="qpay_api_url" name="qpay_api_url" value="<?php echo esc_attr(get_option('qpay_api_url')); ?>" class="regular-text" placeholder="https://pay.yourdomain.com"></td>
                            </tr>
                            <tr>
                                <th><label for="qpay_test_mode"><?php esc_html_e('Test Mode', 'qpay'); ?></label></th>
                                <td><label><input type="checkbox" id="qpay_test_mode" name="qpay_test_mode" value="yes" <?php checked(get_option('qpay_test_mode', 'yes'), 'yes'); ?>> <?php esc_html_e('Enable test mode (no real payments)', 'qpay'); ?></label></td>
                            </tr>
                        </table>
                    </div>

                    <div class="qpay-card">
                        <h2><?php esc_html_e('API Keys', 'qpay'); ?></h2>
                        <p class="description"><?php esc_html_e('You can find your keys in the Brand Settings -> API Keys section of your QPay dashboard.', 'qpay'); ?></p>
                        <table class="form-table">
                            <tr>
                                <th><label for="qpay_test_secret_key"><?php esc_html_e('Test Secret Key', 'qpay'); ?></label></th>
                                <td><input type="password" id="qpay_test_secret_key" name="qpay_test_secret_key" value="<?php echo esc_attr(get_option('qpay_test_secret_key')); ?>" class="regular-text" placeholder="qp_test_..."></td>
                            </tr>
                            <tr>
                                <th><label for="qpay_test_publishable_key"><?php esc_html_e('Test Publishable Key', 'qpay'); ?></label></th>
                                <td><input type="password" id="qpay_test_publishable_key" name="qpay_test_publishable_key" value="<?php echo esc_attr(get_option('qpay_test_publishable_key')); ?>" class="regular-text" placeholder="pk_test_..."></td>
                            </tr>
                            <tr>
                                <th><label for="qpay_live_secret_key"><?php esc_html_e('Live Secret Key', 'qpay'); ?></label></th>
                                <td><input type="password" id="qpay_live_secret_key" name="qpay_live_secret_key" value="<?php echo esc_attr(get_option('qpay_live_secret_key')); ?>" class="regular-text" placeholder="qp_live_..."></td>
                            </tr>
                            <tr>
                                <th><label for="qpay_live_publishable_key"><?php esc_html_e('Live Publishable Key', 'qpay'); ?></label></th>
                                <td><input type="password" id="qpay_live_publishable_key" name="qpay_live_publishable_key" value="<?php echo esc_attr(get_option('qpay_live_publishable_key')); ?>" class="regular-text" placeholder="pk_live_..."></td>
                            </tr>
                        </table>
                    </div>

                    <div class="qpay-card">
                        <h2><?php esc_html_e('Webhooks', 'qpay'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><label for="qpay_webhook_secret"><?php esc_html_e('Webhook Secret', 'qpay'); ?></label></th>
                                <td>
                                    <input type="password" id="qpay_webhook_secret" name="qpay_webhook_secret" value="<?php echo esc_attr(get_option('qpay_webhook_secret')); ?>" class="regular-text" placeholder="whsec_...">
                                    <p class="description"><?php esc_html_e('Webhook URL:', 'qpay'); ?> <code><?php echo esc_html($webhook_url); ?></code></p>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="qpay-card">
                        <h2><?php esc_html_e('Features', 'qpay'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><?php esc_html_e('Payment Buttons', 'qpay'); ?></th>
                                <td><label><input type="checkbox" name="qpay_enable_buttons" value="yes" <?php checked(get_option('qpay_enable_buttons', 'yes'), 'yes'); ?>> <?php esc_html_e('Enable [qpay_button] shortcode', 'qpay'); ?></label></td>
                            </tr>
                            <tr>
                                <th><?php esc_html_e('Payment Forms', 'qpay'); ?></th>
                                <td><label><input type="checkbox" name="qpay_enable_forms" value="yes" <?php checked(get_option('qpay_enable_forms', 'yes'), 'yes'); ?>> <?php esc_html_e('Enable [qpay_form] shortcode', 'qpay'); ?></label></td>
                            </tr>
                            <tr>
                                <th><?php esc_html_e('Donation Forms', 'qpay'); ?></th>
                                <td><label><input type="checkbox" name="qpay_enable_donations" value="yes" <?php checked(get_option('qpay_enable_donations', 'yes'), 'yes'); ?>> <?php esc_html_e('Enable [qpay_donate] shortcode', 'qpay'); ?></label></td>
                            </tr>
                            <tr>
                                <th><?php esc_html_e('WooCommerce', 'qpay'); ?></th>
                                <td>
                                    <label><input type="checkbox" name="qpay_enable_woocommerce" value="yes" <?php checked(get_option('qpay_enable_woocommerce', 'yes'), 'yes'); ?> <?php echo $woo_active ? '' : 'disabled'; ?>> <?php esc_html_e('Enable WooCommerce checkout integration', 'qpay'); ?></label>
                                    <?php if (!$woo_active): ?>
                                        <p class="description"><?php esc_html_e('WooCommerce is not installed. Install WooCommerce to enable this feature.', 'qpay'); ?></p>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div class="qpay-card">
                        <h2><?php esc_html_e('Notifications & Redirects', 'qpay'); ?></h2>
                        <table class="form-table">
                            <tr>
                                <th><?php esc_html_e('Email Notifications', 'qpay'); ?></th>
                                <td><label><input type="checkbox" name="qpay_email_notifications" value="yes" <?php checked(get_option('qpay_email_notifications', 'yes'), 'yes'); ?>> <?php esc_html_e('Send email on payment completion', 'qpay'); ?></label></td>
                            </tr>
                            <tr>
                                <th><label for="qpay_admin_email"><?php esc_html_e('Admin Email', 'qpay'); ?></label></th>
                                <td><input type="email" id="qpay_admin_email" name="qpay_admin_email" value="<?php echo esc_attr(get_option('qpay_admin_email', get_option('admin_email'))); ?>" class="regular-text"></td>
                            </tr>
                            <tr>
                                <th><label for="qpay_success_page"><?php esc_html_e('Success Page URL', 'qpay'); ?></label></th>
                                <td><input type="url" id="qpay_success_page" name="qpay_success_page" value="<?php echo esc_attr(get_option('qpay_success_page')); ?>" class="regular-text" placeholder="https://yoursite.com/thank-you"></td>
                            </tr>
                            <tr>
                                <th><label for="qpay_cancel_page"><?php esc_html_e('Cancel Page URL', 'qpay'); ?></label></th>
                                <td><input type="url" id="qpay_cancel_page" name="qpay_cancel_page" value="<?php echo esc_attr(get_option('qpay_cancel_page')); ?>" class="regular-text" placeholder="https://yoursite.com/payment-cancelled"></td>
                            </tr>
                        </table>
                    </div>

                    <div class="qpay-card">
                        <h2><?php esc_html_e('Shortcode Reference', 'qpay'); ?></h2>
                        <table class="widefat">
                            <thead><tr><th><?php esc_html_e('Shortcode', 'qpay'); ?></th><th><?php esc_html_e('Description', 'qpay'); ?></th></tr></thead>
                            <tbody>
                                <tr><td><code>[qpay_button amount="500" label="Pay Now"]</code></td><td><?php esc_html_e('Simple payment button with fixed amount', 'qpay'); ?></td></tr>
                                <tr><td><code>[qpay_button amount="500" description="Course Fee" class="my-btn"]</code></td><td><?php esc_html_e('Button with description and custom CSS class', 'qpay'); ?></td></tr>
                                <tr><td><code>[qpay_form id="1"]</code></td><td><?php esc_html_e('Render a saved payment form by ID', 'qpay'); ?></td></tr>
                                <tr><td><code>[qpay_form fields="name,email,phone,amount"]</code></td><td><?php esc_html_e('Inline payment form with specified fields', 'qpay'); ?></td></tr>
                                <tr><td><code>[qpay_donate preset="100,500,1000" label="Donate"]</code></td><td><?php esc_html_e('Donation form with preset amounts', 'qpay'); ?></td></tr>
                                <tr><td><code>[qpay_donate preset="100,500,1000" custom="yes"]</code></td><td><?php esc_html_e('Donation form with custom amount option', 'qpay'); ?></td></tr>
                            </tbody>
                        </table>
                    </div>

                </div>

                <p class="submit">
                    <input type="submit" name="qpay_save_settings" class="button-primary" value="<?php esc_attr_e('Save Settings', 'qpay'); ?>">
                </p>
            </form>
        </div>
        <?php
    }

    public static function page_transactions(): void
    {
        QPay_Transactions::render_admin_page();
    }

    public static function page_forms(): void
    {
        QPay_Forms::render_admin_page();
    }
}

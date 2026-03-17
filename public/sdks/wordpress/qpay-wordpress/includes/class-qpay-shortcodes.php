<?php

defined('ABSPATH') || exit;

class QPay_Shortcodes
{
    public static function init(): void
    {
        add_shortcode('qpay_button', [__CLASS__, 'button_shortcode']);
        add_shortcode('qpay_form', [__CLASS__, 'form_shortcode']);
        add_shortcode('qpay_donate', [__CLASS__, 'donate_shortcode']);
    }

    public static function button_shortcode($atts): string
    {
        if (get_option('qpay_enable_buttons', 'yes') !== 'yes') {
            return '';
        }

        $atts = shortcode_atts([
            'amount' => '',
            'currency' => 'BDT',
            'label' => __('Pay Now', 'qpay'),
            'description' => '',
            'class' => '',
            'success_url' => get_option('qpay_success_page', ''),
            'cancel_url' => get_option('qpay_cancel_page', ''),
            'method' => '',
        ], $atts, 'qpay_button');

        if (empty($atts['amount']) || !is_numeric($atts['amount'])) {
            return '<p class="qpay-error">' . esc_html__('QPay Button: amount is required.', 'qpay') . '</p>';
        }

        wp_enqueue_style('qpay-frontend');
        wp_enqueue_script('qpay-frontend');

        $btn_class = 'qpay-btn qpay-btn-pay';
        if (!empty($atts['class'])) {
            $btn_class .= ' ' . esc_attr($atts['class']);
        }

        $test_badge = '';
        if (QPay_Plugin::is_test_mode()) {
            $test_badge = '<span class="qpay-test-badge">' . esc_html__('TEST', 'qpay') . '</span>';
        }

        $data_attrs = sprintf(
            'data-amount="%s" data-currency="%s" data-description="%s" data-success-url="%s" data-cancel-url="%s" data-method="%s"',
            esc_attr($atts['amount']),
            esc_attr($atts['currency']),
            esc_attr($atts['description']),
            esc_attr($atts['success_url']),
            esc_attr($atts['cancel_url']),
            esc_attr($atts['method'])
        );

        return sprintf(
            '<div class="qpay-button-wrap">%s<button type="button" class="%s" %s>%s <span class="qpay-amount">%s %s</span></button></div>',
            $test_badge,
            esc_attr($btn_class),
            $data_attrs,
            esc_html($atts['label']),
            esc_html($atts['currency']),
            esc_html(number_format((float) $atts['amount'], 2))
        );
    }

    public static function form_shortcode($atts): string
    {
        if (get_option('qpay_enable_forms', 'yes') !== 'yes') {
            return '';
        }

        $atts = shortcode_atts([
            'id' => '',
            'fields' => 'name,email,amount',
            'title' => __('Make a Payment', 'qpay'),
            'description' => '',
            'amount' => '',
            'currency' => 'BDT',
            'submit_label' => __('Pay Now', 'qpay'),
            'success_url' => get_option('qpay_success_page', ''),
            'cancel_url' => get_option('qpay_cancel_page', ''),
            'class' => '',
        ], $atts, 'qpay_form');

        wp_enqueue_style('qpay-frontend');
        wp_enqueue_script('qpay-frontend');

        if (!empty($atts['id'])) {
            $form = QPay_DB::get_form((int) $atts['id']);
            if (!$form) {
                return '<p class="qpay-error">' . esc_html__('Form not found.', 'qpay') . '</p>';
            }
            $fields = json_decode($form->fields, true) ?: [];
            $settings = json_decode($form->settings, true) ?: [];
            $atts['title'] = $form->title;
            $atts['fields'] = implode(',', array_column($fields, 'name'));
            if (!empty($settings['amount'])) {
                $atts['amount'] = $settings['amount'];
            }
            if (!empty($settings['submit_label'])) {
                $atts['submit_label'] = $settings['submit_label'];
            }
        }

        $field_list = array_map('trim', explode(',', $atts['fields']));

        $test_badge = '';
        if (QPay_Plugin::is_test_mode()) {
            $test_badge = '<span class="qpay-test-badge">' . esc_html__('TEST MODE', 'qpay') . '</span>';
        }

        $html = '<div class="qpay-form-wrap ' . esc_attr($atts['class']) . '">';
        $html .= $test_badge;
        $html .= '<form class="qpay-payment-form" data-success-url="' . esc_attr($atts['success_url']) . '" data-cancel-url="' . esc_attr($atts['cancel_url']) . '">';

        if (!empty($atts['title'])) {
            $html .= '<h3 class="qpay-form-title">' . esc_html($atts['title']) . '</h3>';
        }
        if (!empty($atts['description'])) {
            $html .= '<p class="qpay-form-desc">' . esc_html($atts['description']) . '</p>';
        }

        foreach ($field_list as $field) {
            $html .= self::render_field($field, $atts);
        }

        $html .= '<input type="hidden" name="qpay_currency" value="' . esc_attr($atts['currency']) . '">';
        $html .= wp_nonce_field('qpay_payment', 'qpay_nonce', true, false);
        $html .= '<button type="submit" class="qpay-btn qpay-btn-submit">' . esc_html($atts['submit_label']) . '</button>';
        $html .= '<div class="qpay-form-message" style="display:none;"></div>';
        $html .= '</form></div>';

        return $html;
    }

    public static function donate_shortcode($atts): string
    {
        if (get_option('qpay_enable_donations', 'yes') !== 'yes') {
            return '';
        }

        $atts = shortcode_atts([
            'preset' => '100,500,1000,5000',
            'custom' => 'yes',
            'currency' => 'BDT',
            'title' => __('Make a Donation', 'qpay'),
            'description' => '',
            'label' => __('Donate', 'qpay'),
            'success_url' => get_option('qpay_success_page', ''),
            'cancel_url' => get_option('qpay_cancel_page', ''),
            'class' => '',
        ], $atts, 'qpay_donate');

        wp_enqueue_style('qpay-frontend');
        wp_enqueue_script('qpay-frontend');

        $presets = array_filter(array_map('trim', explode(',', $atts['preset'])));

        $test_badge = '';
        if (QPay_Plugin::is_test_mode()) {
            $test_badge = '<span class="qpay-test-badge">' . esc_html__('TEST MODE', 'qpay') . '</span>';
        }

        $html = '<div class="qpay-donate-wrap ' . esc_attr($atts['class']) . '">';
        $html .= $test_badge;
        $html .= '<form class="qpay-donate-form" data-success-url="' . esc_attr($atts['success_url']) . '" data-cancel-url="' . esc_attr($atts['cancel_url']) . '">';

        if (!empty($atts['title'])) {
            $html .= '<h3 class="qpay-form-title">' . esc_html($atts['title']) . '</h3>';
        }
        if (!empty($atts['description'])) {
            $html .= '<p class="qpay-form-desc">' . esc_html($atts['description']) . '</p>';
        }

        $html .= '<div class="qpay-preset-amounts">';
        foreach ($presets as $amount) {
            $html .= '<button type="button" class="qpay-preset-btn" data-amount="' . esc_attr($amount) . '">';
            $html .= esc_html($atts['currency']) . ' ' . esc_html(number_format((float) $amount, 0));
            $html .= '</button>';
        }
        $html .= '</div>';

        if ($atts['custom'] === 'yes') {
            $html .= '<div class="qpay-field">';
            $html .= '<label class="qpay-label">' . esc_html__('Or enter custom amount', 'qpay') . '</label>';
            $html .= '<div class="qpay-input-group"><span class="qpay-currency-prefix">' . esc_html($atts['currency']) . '</span>';
            $html .= '<input type="number" name="qpay_amount" class="qpay-input qpay-donate-amount" min="1" step="any" placeholder="0.00"></div>';
            $html .= '</div>';
        } else {
            $html .= '<input type="hidden" name="qpay_amount" class="qpay-donate-amount">';
        }

        $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Name (optional)', 'qpay') . '</label>';
        $html .= '<input type="text" name="qpay_name" class="qpay-input" placeholder="' . esc_attr__('Your name', 'qpay') . '"></div>';

        $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Email (optional)', 'qpay') . '</label>';
        $html .= '<input type="email" name="qpay_email" class="qpay-input" placeholder="' . esc_attr__('your@email.com', 'qpay') . '"></div>';

        $html .= '<input type="hidden" name="qpay_currency" value="' . esc_attr($atts['currency']) . '">';
        $html .= '<input type="hidden" name="qpay_description" value="Donation">';
        $html .= wp_nonce_field('qpay_payment', 'qpay_nonce', true, false);

        $html .= '<button type="submit" class="qpay-btn qpay-btn-donate">' . esc_html($atts['label']) . '</button>';
        $html .= '<div class="qpay-form-message" style="display:none;"></div>';
        $html .= '</form></div>';

        return $html;
    }

    private static function render_field(string $field, array $atts): string
    {
        $html = '';
        switch ($field) {
            case 'name':
                $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Full Name', 'qpay') . ' <span class="required">*</span></label>';
                $html .= '<input type="text" name="qpay_name" class="qpay-input" required placeholder="' . esc_attr__('John Doe', 'qpay') . '"></div>';
                break;
            case 'email':
                $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Email', 'qpay') . ' <span class="required">*</span></label>';
                $html .= '<input type="email" name="qpay_email" class="qpay-input" required placeholder="' . esc_attr__('john@example.com', 'qpay') . '"></div>';
                break;
            case 'phone':
                $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Phone', 'qpay') . '</label>';
                $html .= '<input type="tel" name="qpay_phone" class="qpay-input" placeholder="' . esc_attr__('+880 1XXXXXXXXX', 'qpay') . '"></div>';
                break;
            case 'amount':
                if (!empty($atts['amount'])) {
                    $html .= '<input type="hidden" name="qpay_amount" value="' . esc_attr($atts['amount']) . '">';
                    $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Amount', 'qpay') . '</label>';
                    $html .= '<p class="qpay-fixed-amount">' . esc_html($atts['currency'] . ' ' . number_format((float) $atts['amount'], 2)) . '</p></div>';
                } else {
                    $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Amount', 'qpay') . ' <span class="required">*</span></label>';
                    $html .= '<div class="qpay-input-group"><span class="qpay-currency-prefix">' . esc_html($atts['currency']) . '</span>';
                    $html .= '<input type="number" name="qpay_amount" class="qpay-input" min="1" step="any" required placeholder="0.00"></div></div>';
                }
                break;
            case 'description':
                $html .= '<div class="qpay-field"><label class="qpay-label">' . esc_html__('Description', 'qpay') . '</label>';
                $html .= '<textarea name="qpay_description" class="qpay-input qpay-textarea" rows="3" placeholder="' . esc_attr__('Payment description...', 'qpay') . '"></textarea></div>';
                break;
        }
        return $html;
    }
}

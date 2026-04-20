<?php

class QPay_Elementor_Widget extends \Elementor\Widget_Base
{
    public function get_name() {
        return 'qpay_button';
    }

    public function get_title() {
        return esc_html__('QPay Button', 'qpay');
    }

    public function get_icon() {
        return 'eicon-button';
    }

    public function get_categories() {
        return ['general'];
    }

    public function get_keywords() {
        return ['payment', 'qpay', 'button', 'mobile banking'];
    }

    protected function register_controls() {

        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'qpay'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'amount',
            [
                'label' => esc_html__('Amount (BDT)', 'qpay'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
            ]
        );

        $this->add_control(
            'label',
            [
                'label' => esc_html__('Button Label', 'qpay'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Pay Now', 'qpay'),
            ]
        );

        $this->add_control(
            'description',
            [
                'label' => esc_html__('Description', 'qpay'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'rows' => 2,
                'placeholder' => esc_html__('Enter payment description', 'qpay'),
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        echo do_shortcode(sprintf(
            '[qpay_button amount="%s" label="%s" description="%s"]',
            esc_attr($settings['amount']),
            esc_attr($settings['label']),
            esc_attr($settings['description'])
        ));
    }
}

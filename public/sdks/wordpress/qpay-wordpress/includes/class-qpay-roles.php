<?php

defined('ABSPATH') || exit;

class QPay_Roles
{
    public static function create_roles(): void
    {
        add_role('qpay_merchant', __('QPay Merchant', 'qpay'), [
            'read' => true,
            'manage_qpay' => true,
            'qpay_view_transactions' => true,
            'qpay_refund' => true,
        ]);

        $admin = get_role('administrator');
        if ($admin) {
            $admin->add_cap('manage_qpay');
            $admin->add_cap('qpay_view_transactions');
            $admin->add_cap('qpay_refund');
            $admin->add_cap('qpay_manage_settings');
        }

        $editor = get_role('editor');
        if ($editor) {
            $editor->add_cap('manage_qpay');
            $editor->add_cap('qpay_view_transactions');
        }
    }

    public static function remove_roles(): void
    {
        remove_role('qpay_merchant');

        $admin = get_role('administrator');
        if ($admin) {
            $admin->remove_cap('manage_qpay');
            $admin->remove_cap('qpay_view_transactions');
            $admin->remove_cap('qpay_refund');
            $admin->remove_cap('qpay_manage_settings');
        }

        $editor = get_role('editor');
        if ($editor) {
            $editor->remove_cap('manage_qpay');
            $editor->remove_cap('qpay_view_transactions');
        }
    }
}

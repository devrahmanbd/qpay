<?php

defined('ABSPATH') || exit;

class QPay_Transactions
{
    public static function render_admin_page(): void
    {
        $action = sanitize_text_field($_GET['action'] ?? 'list');

        if ($action === 'view') {
            self::render_detail_page();
            return;
        }

        if ($action === 'refund' && isset($_POST['qpay_refund_submit']) && check_admin_referer('qpay_refund_nonce')) {
            self::handle_refund();
        }

        $status_filter = sanitize_text_field($_GET['status'] ?? '');
        $source_filter = sanitize_text_field($_GET['source'] ?? '');
        $search = sanitize_text_field($_GET['s'] ?? '');
        $paged = max(1, (int) ($_GET['paged'] ?? 1));
        $per_page = 20;

        $args = [
            'status' => $status_filter,
            'source' => $source_filter,
            'search' => $search,
            'per_page' => $per_page,
            'offset' => ($paged - 1) * $per_page,
        ];

        $transactions = QPay_DB::get_transactions($args);
        $total = QPay_DB::count_transactions($args);
        $total_pages = ceil($total / $per_page);

        $stats = [
            'total' => QPay_DB::count_transactions(),
            'completed' => QPay_DB::count_transactions(['status' => 'completed']),
            'pending' => QPay_DB::count_transactions(['status' => 'pending']),
            'failed' => QPay_DB::count_transactions(['status' => 'failed']),
        ];
        ?>
        <div class="wrap qpay-admin">
            <h1><?php esc_html_e('QPay Transactions', 'qpay'); ?></h1>

            <?php if (isset($_GET['refunded'])): ?>
                <div class="notice notice-success"><p><?php esc_html_e('Refund initiated successfully.', 'qpay'); ?></p></div>
            <?php endif; ?>

            <div class="qpay-stats-row">
                <div class="qpay-stat"><span class="qpay-stat-num"><?php echo (int) $stats['total']; ?></span><span class="qpay-stat-label"><?php esc_html_e('Total', 'qpay'); ?></span></div>
                <div class="qpay-stat qpay-stat-success"><span class="qpay-stat-num"><?php echo (int) $stats['completed']; ?></span><span class="qpay-stat-label"><?php esc_html_e('Completed', 'qpay'); ?></span></div>
                <div class="qpay-stat qpay-stat-warning"><span class="qpay-stat-num"><?php echo (int) $stats['pending']; ?></span><span class="qpay-stat-label"><?php esc_html_e('Pending', 'qpay'); ?></span></div>
                <div class="qpay-stat qpay-stat-danger"><span class="qpay-stat-num"><?php echo (int) $stats['failed']; ?></span><span class="qpay-stat-label"><?php esc_html_e('Failed', 'qpay'); ?></span></div>
            </div>

            <div class="tablenav top">
                <form method="get" class="qpay-filters">
                    <input type="hidden" name="page" value="qpay">
                    <select name="status">
                        <option value=""><?php esc_html_e('All statuses', 'qpay'); ?></option>
                        <?php foreach (['pending', 'processing', 'completed', 'failed', 'refunded'] as $s): ?>
                            <option value="<?php echo esc_attr($s); ?>" <?php selected($status_filter, $s); ?>><?php echo esc_html(ucfirst($s)); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <select name="source">
                        <option value=""><?php esc_html_e('All sources', 'qpay'); ?></option>
                        <?php foreach (['button', 'form', 'donation', 'woocommerce'] as $src): ?>
                            <option value="<?php echo esc_attr($src); ?>" <?php selected($source_filter, $src); ?>><?php echo esc_html(ucfirst($src)); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <input type="search" name="s" value="<?php echo esc_attr($search); ?>" placeholder="<?php esc_attr_e('Search...', 'qpay'); ?>">
                    <input type="submit" class="button" value="<?php esc_attr_e('Filter', 'qpay'); ?>">
                </form>
            </div>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('Payment ID', 'qpay'); ?></th>
                        <th><?php esc_html_e('Amount', 'qpay'); ?></th>
                        <th><?php esc_html_e('Status', 'qpay'); ?></th>
                        <th><?php esc_html_e('Customer', 'qpay'); ?></th>
                        <th><?php esc_html_e('Source', 'qpay'); ?></th>
                        <th><?php esc_html_e('Date', 'qpay'); ?></th>
                        <th><?php esc_html_e('Actions', 'qpay'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($transactions)): ?>
                        <tr><td colspan="7"><?php esc_html_e('No transactions found.', 'qpay'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($transactions as $txn): ?>
                            <tr>
                                <td>
                                    <code><?php echo esc_html($txn->payment_id); ?></code>
                                    <?php if ($txn->test_mode): ?><span class="qpay-badge qpay-badge-test">TEST</span><?php endif; ?>
                                </td>
                                <td><?php echo esc_html($txn->currency . ' ' . number_format((float) $txn->amount, 2)); ?></td>
                                <td><span class="qpay-badge qpay-badge-<?php echo esc_attr($txn->status); ?>"><?php echo esc_html(ucfirst($txn->status)); ?></span></td>
                                <td><?php echo esc_html($txn->customer_name ?: $txn->customer_email ?: '-'); ?></td>
                                <td><?php echo esc_html(ucfirst($txn->source)); ?></td>
                                <td><?php echo esc_html(date('M j, Y g:i A', strtotime($txn->created_at))); ?></td>
                                <td>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=qpay&action=view&payment_id=' . $txn->payment_id)); ?>"><?php esc_html_e('View', 'qpay'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if ($total_pages > 1): ?>
                <div class="tablenav bottom">
                    <div class="tablenav-pages">
                        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                            <?php if ($i === $paged): ?>
                                <span class="tablenav-pages-navspan button disabled"><?php echo $i; ?></span>
                            <?php else: ?>
                                <a class="button" href="<?php echo esc_url(add_query_arg('paged', $i)); ?>"><?php echo $i; ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <?php
    }

    private static function render_detail_page(): void
    {
        $payment_id = sanitize_text_field($_GET['payment_id'] ?? '');
        $txn = QPay_DB::get_transaction($payment_id);

        if (!$txn) {
            echo '<div class="wrap"><h1>' . esc_html__('Transaction Not Found', 'qpay') . '</h1></div>';
            return;
        }

        $metadata = json_decode($txn->metadata ?? '{}', true);
        ?>
        <div class="wrap qpay-admin">
            <h1>
                <?php esc_html_e('Transaction Detail', 'qpay'); ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=qpay')); ?>" class="page-title-action"><?php esc_html_e('Back to List', 'qpay'); ?></a>
            </h1>

            <div class="qpay-detail-grid">
                <div class="qpay-card">
                    <h3><?php esc_html_e('Payment Info', 'qpay'); ?></h3>
                    <table class="form-table">
                        <tr><th><?php esc_html_e('Payment ID', 'qpay'); ?></th><td><code><?php echo esc_html($txn->payment_id); ?></code></td></tr>
                        <tr><th><?php esc_html_e('Amount', 'qpay'); ?></th><td><strong><?php echo esc_html($txn->currency . ' ' . number_format((float) $txn->amount, 2)); ?></strong></td></tr>
                        <tr><th><?php esc_html_e('Status', 'qpay'); ?></th><td><span class="qpay-badge qpay-badge-<?php echo esc_attr($txn->status); ?>"><?php echo esc_html(ucfirst($txn->status)); ?></span></td></tr>
                        <tr><th><?php esc_html_e('Source', 'qpay'); ?></th><td><?php echo esc_html(ucfirst($txn->source)); ?></td></tr>
                        <tr><th><?php esc_html_e('Test Mode', 'qpay'); ?></th><td><?php echo $txn->test_mode ? esc_html__('Yes', 'qpay') : esc_html__('No', 'qpay'); ?></td></tr>
                        <?php if ($txn->transaction_id): ?><tr><th><?php esc_html_e('Transaction ID', 'qpay'); ?></th><td><code><?php echo esc_html($txn->transaction_id); ?></code></td></tr><?php endif; ?>
                        <?php if ($txn->description): ?><tr><th><?php esc_html_e('Description', 'qpay'); ?></th><td><?php echo esc_html($txn->description); ?></td></tr><?php endif; ?>
                        <tr><th><?php esc_html_e('Created', 'qpay'); ?></th><td><?php echo esc_html(date('M j, Y g:i:s A', strtotime($txn->created_at))); ?></td></tr>
                    </table>
                </div>

                <div class="qpay-card">
                    <h3><?php esc_html_e('Customer Info', 'qpay'); ?></h3>
                    <table class="form-table">
                        <tr><th><?php esc_html_e('Name', 'qpay'); ?></th><td><?php echo esc_html($txn->customer_name ?: '-'); ?></td></tr>
                        <tr><th><?php esc_html_e('Email', 'qpay'); ?></th><td><?php echo esc_html($txn->customer_email ?: '-'); ?></td></tr>
                        <tr><th><?php esc_html_e('Phone', 'qpay'); ?></th><td><?php echo esc_html($txn->customer_phone ?: '-'); ?></td></tr>
                        <tr><th><?php esc_html_e('IP Address', 'qpay'); ?></th><td><?php echo esc_html($txn->ip_address ?: '-'); ?></td></tr>
                    </table>
                </div>

                <?php if ($txn->status === 'completed'): ?>
                    <div class="qpay-card">
                        <h3><?php esc_html_e('Refund', 'qpay'); ?></h3>
                        <?php if ($txn->refund_id): ?>
                            <p><?php esc_html_e('This payment has been refunded.', 'qpay'); ?></p>
                            <p><strong><?php esc_html_e('Refund ID:', 'qpay'); ?></strong> <code><?php echo esc_html($txn->refund_id); ?></code></p>
                            <?php if ($txn->refund_reason): ?>
                                <p><strong><?php esc_html_e('Reason:', 'qpay'); ?></strong> <?php echo esc_html($txn->refund_reason); ?></p>
                            <?php endif; ?>
                        <?php else: ?>
                            <form method="post" action="<?php echo esc_url(admin_url('admin.php?page=qpay&action=refund')); ?>">
                                <?php wp_nonce_field('qpay_refund_nonce'); ?>
                                <input type="hidden" name="payment_id" value="<?php echo esc_attr($txn->payment_id); ?>">
                                <p>
                                    <label for="refund_reason"><?php esc_html_e('Reason (optional):', 'qpay'); ?></label><br>
                                    <input type="text" name="refund_reason" id="refund_reason" class="regular-text" placeholder="<?php esc_attr_e('Customer requested', 'qpay'); ?>">
                                </p>
                                <p>
                                    <input type="submit" name="qpay_refund_submit" class="button button-secondary" value="<?php esc_attr_e('Issue Refund', 'qpay'); ?>" onclick="return confirm('<?php esc_attr_e('Are you sure you want to refund this payment?', 'qpay'); ?>')">
                                </p>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }

    private static function handle_refund(): void
    {
        if (!current_user_can('qpay_refund') && !current_user_can('manage_options')) {
            wp_die(__('You do not have permission to issue refunds.', 'qpay'));
        }

        $payment_id = sanitize_text_field(wp_unslash($_POST['payment_id'] ?? ''));
        $reason = sanitize_text_field(wp_unslash($_POST['refund_reason'] ?? ''));

        if (empty($payment_id)) {
            return;
        }

        try {
            $sdk = QPay_Plugin::get_sdk();
            $result = $sdk->createRefund($payment_id, $reason ?: 'Admin refund');

            QPay_DB::update_transaction($payment_id, [
                'status' => 'refunded',
                'refund_id' => $result['id'] ?? null,
                'refund_reason' => $reason,
            ]);

            wp_redirect(admin_url('admin.php?page=qpay&refunded=1'));
            exit;
        } catch (Exception $e) {
            echo '<div class="notice notice-error"><p>' . esc_html(sprintf(__('Refund failed: %s', 'qpay'), $e->getMessage())) . '</p></div>';
        }
    }
}

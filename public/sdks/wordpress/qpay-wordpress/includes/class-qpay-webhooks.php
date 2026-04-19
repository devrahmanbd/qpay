<?php

defined('ABSPATH') || exit;

class QPay_Webhooks
{
    public static function register_routes(): void
    {
        register_rest_route('qpay/v1', '/webhook', [
            'methods' => ['GET', 'POST'],
            'callback' => [__CLASS__, 'webhook_callback'],
            'permission_callback' => '__return_true',
        ]);
    }

    public static function webhook_callback(WP_REST_Request $request): WP_REST_Response
    {
        if ($request->get_method() === 'GET') {
            return new WP_REST_Response([
                'status' => 'active',
                'message' => 'QPay Webhook endpoint is active and ready for POST requests.',
                'timestamp' => current_time('mysql'),
            ], 200);
        }

        return self::handle_webhook($request);
    }

    public static function handle_webhook(WP_REST_Request $request): WP_REST_Response
    {
        $payload = $request->get_body();
        $signature = $request->get_header('QPay-Signature');
        $secret = get_option('qpay_webhook_secret', '');

        if (empty($secret) || empty($signature)) {
            return new WP_REST_Response(['error' => 'Missing signature or secret'], 400);
        }

        if (!QPay_SDK::verifyWebhookSignature($payload, $signature, $secret)) {
            return new WP_REST_Response(['error' => 'Invalid signature'], 401);
        }

        $data = json_decode($payload, true);
        $event = $data['event'] ?? '';
        $paymentData = $data['data'] ?? [];

        $paymentId = $paymentData['id'] ?? '';
        if ($event === 'refund.created') {
            $paymentId = $paymentData['payment_id'] ?? $paymentData['payment'] ?? $paymentId;
        }

        if (empty($paymentId)) {
            return new WP_REST_Response(['error' => 'Missing payment ID'], 400);
        }

        $transaction = QPay_DB::get_transaction($paymentId);

        if ($transaction) {
            self::handle_transaction_webhook($event, $paymentData, $transaction);
        }

        if (class_exists('WooCommerce') && get_option('qpay_enable_woocommerce', 'yes') === 'yes') {
            self::handle_woocommerce_webhook($event, $paymentData, $paymentId);
        }

        return new WP_REST_Response(['success' => true], 200);
    }

    private static function handle_transaction_webhook(string $event, array $paymentData, object $transaction): void
    {
        switch ($event) {
            case 'payment.completed':
                if ($transaction->status === 'completed') {
                    return;
                }
                QPay_DB::update_transaction($transaction->payment_id, [
                    'status' => 'completed',
                    'transaction_id' => $paymentData['transaction_id'] ?? null,
                ]);
                self::send_notification($transaction, 'completed');
                break;

            case 'payment.failed':
                if ($transaction->status === 'failed') {
                    return;
                }
                QPay_DB::update_transaction($transaction->payment_id, [
                    'status' => 'failed',
                ]);
                self::send_notification($transaction, 'failed');
                break;

            case 'payment.created':
                if ($transaction->status === 'pending') {
                    QPay_DB::update_transaction($transaction->payment_id, [
                        'status' => 'processing',
                    ]);
                }
                break;

            case 'refund.created':
                if ($transaction->status === 'refunded') {
                    return;
                }
                QPay_DB::update_transaction($transaction->payment_id, [
                    'status' => 'refunded',
                    'refund_id' => $paymentData['id'] ?? null,
                ]);
                self::send_notification($transaction, 'refunded');
                break;
        }
    }

    private static function handle_woocommerce_webhook(string $event, array $paymentData, string $paymentId): void
    {
        $orders = wc_get_orders([
            'meta_key' => '_qpay_payment_id',
            'meta_value' => $paymentId,
            'limit' => 1,
        ]);

        if (empty($orders)) {
            return;
        }

        $order = $orders[0];

        switch ($event) {
            case 'payment.completed':
                if (!$order->is_paid()) {
                    $order->payment_complete($paymentData['transaction_id'] ?? $paymentId);
                    $order->add_order_note(sprintf('QPay payment completed. Transaction ID: %s', $paymentData['transaction_id'] ?? $paymentId));
                }
                break;

            case 'payment.failed':
                $order->update_status('failed', sprintf('QPay payment failed. Reason: %s', $paymentData['error'] ?? 'Unknown'));
                break;

            case 'refund.created':
                $order->update_status('refunded', sprintf('QPay refund processed. Refund ID: %s', $paymentData['id'] ?? ''));
                break;

            case 'payment.created':
                if ($order->get_status() === 'pending') {
                    $order->update_status('on-hold', 'QPay payment initiated, waiting for completion.');
                }
                break;
        }
    }

    private static function send_notification(object $transaction, string $status): void
    {
        if (get_option('qpay_email_notifications', 'yes') !== 'yes') {
            return;
        }

        $admin_email = get_option('qpay_admin_email', get_option('admin_email'));
        $site_name = get_bloginfo('name');

        $subject_map = [
            'completed' => sprintf('[%s] Payment Completed - %s', $site_name, $transaction->payment_id),
            'failed' => sprintf('[%s] Payment Failed - %s', $site_name, $transaction->payment_id),
            'refunded' => sprintf('[%s] Payment Refunded - %s', $site_name, $transaction->payment_id),
        ];

        $subject = $subject_map[$status] ?? sprintf('[%s] Payment Update', $site_name);

        $message = sprintf("Payment ID: %s\n", $transaction->payment_id);
        $message .= sprintf("Status: %s\n", ucfirst($status));
        $message .= sprintf("Amount: %s %s\n", $transaction->currency, number_format((float) $transaction->amount, 2));
        if ($transaction->customer_name) {
            $message .= sprintf("Customer: %s\n", $transaction->customer_name);
        }
        if ($transaction->customer_email) {
            $message .= sprintf("Email: %s\n", $transaction->customer_email);
        }
        $message .= sprintf("Source: %s\n", ucfirst($transaction->source));
        $message .= sprintf("Date: %s\n", $transaction->created_at);

        wp_mail($admin_email, $subject, $message);

        if ($transaction->customer_email && $status === 'completed') {
            $customer_subject = sprintf('Payment Confirmation - %s', $site_name);
            $customer_message = sprintf("Thank you for your payment!\n\n");
            $customer_message .= sprintf("Payment ID: %s\n", $transaction->payment_id);
            $customer_message .= sprintf("Amount: %s %s\n", $transaction->currency, number_format((float) $transaction->amount, 2));
            $customer_message .= sprintf("Status: Completed\n\n");
            $customer_message .= sprintf("- %s", $site_name);

            wp_mail($transaction->customer_email, $customer_subject, $customer_message);
        }
    }
}

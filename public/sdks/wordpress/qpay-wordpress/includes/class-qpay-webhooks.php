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

        // WooCommerce support removed in v1.4.0
        return new WP_REST_Response(['success' => true], 200);
    }

    private static function handle_transaction_webhook(string $event, array $paymentData, object $transaction): void
    {
        $status_map = [
            'payment.completed'      => 'completed',
            'payment.pending_review' => 'on-hold',
            'payment.failed'         => 'failed',
            'payment.canceled'       => 'cancelled',
            'refund.created'         => 'refunded',
        ];

        $new_status = $status_map[$event] ?? null;
        if (!$new_status || $transaction->status === $new_status) {
            return;
        }

        // Update local transaction record
        $update_data = ['status' => $new_status];
        if ($event === 'payment.completed') {
            $update_data['transaction_id'] = $paymentData['transaction_id'] ?? null;
        }
        
        QPay_DB::update_transaction($transaction->payment_id, $update_data);
        self::send_notification($transaction, $new_status);

        // Standardized WooCommerce Integration support
        if (class_exists('WooCommerce')) {
            $order_id = $transaction->wc_order_id;
            if (empty($order_id)) {
                // Fallback: Try to find order by meta if not in our table
                $orders = wc_get_orders([
                    'meta_key'   => '_qpay_payment_id',
                    'meta_value' => $transaction->payment_id,
                    'limit'      => 1,
                ]);
                $order = !empty($orders) ? reset($orders) : null;
            } else {
                $order = wc_get_order($order_id);
            }

            if ($order) {
                switch ($event) {
                    case 'payment.completed':
                        $order->payment_complete($paymentData['transaction_id'] ?? '');
                        $order->add_order_note(sprintf(__('QPay Payment Completed. Transaction ID: %s', 'qpay'), $paymentData['transaction_id'] ?? 'N/A'));
                        break;
                    case 'payment.pending_review':
                        $order->update_status('on-hold', __('QPay: Payment found but security check (IP/Session) mismatched. Flagged for Manual Review.', 'qpay'));
                        break;
                    case 'payment.failed':
                        $order->update_status('failed', __('QPay Payment Failed.', 'qpay'));
                        break;
                    case 'payment.canceled':
                        $order->update_status('cancelled', __('QPay Payment Canceled by user.', 'qpay'));
                        break;
                    case 'refund.created':
                        $order->add_order_note(sprintf(__('QPay Refund Created. Refund ID: %s', 'qpay'), $paymentData['id'] ?? 'N/A'));
                        break;
                }
            }
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

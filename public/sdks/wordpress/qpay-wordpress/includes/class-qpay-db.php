<?php

defined('ABSPATH') || exit;

class QPay_DB
{
    public static function create_tables(): void
    {
        global $wpdb;
        $charset = $wpdb->get_charset_collate();

        $transactions_table = $wpdb->prefix . 'qpay_transactions';
        $forms_table = $wpdb->prefix . 'qpay_forms';

        $sql = "CREATE TABLE IF NOT EXISTS {$transactions_table} (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            payment_id varchar(64) NOT NULL,
            source varchar(32) NOT NULL DEFAULT 'button',
            form_id bigint(20) UNSIGNED DEFAULT NULL,
            wc_order_id bigint(20) UNSIGNED DEFAULT NULL,
            amount decimal(12,2) NOT NULL,
            currency varchar(10) NOT NULL DEFAULT 'BDT',
            status varchar(20) NOT NULL DEFAULT 'pending',
            customer_name varchar(255) DEFAULT NULL,
            customer_email varchar(255) DEFAULT NULL,
            customer_phone varchar(50) DEFAULT NULL,
            description text DEFAULT NULL,
            transaction_id varchar(255) DEFAULT NULL,
            refund_id varchar(64) DEFAULT NULL,
            refund_reason text DEFAULT NULL,
            test_mode tinyint(1) NOT NULL DEFAULT 0,
            metadata text DEFAULT NULL,
            ip_address varchar(45) DEFAULT NULL,
            created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id),
            UNIQUE KEY payment_id (payment_id),
            KEY source (source),
            KEY status (status),
            KEY customer_email (customer_email),
            KEY created_at (created_at)
        ) {$charset};

        CREATE TABLE IF NOT EXISTS {$forms_table} (
            id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
            title varchar(255) NOT NULL,
            type varchar(20) NOT NULL DEFAULT 'payment',
            fields text NOT NULL,
            settings text DEFAULT NULL,
            status varchar(20) NOT NULL DEFAULT 'active',
            created_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
            updated_at datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) {$charset};";

        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        dbDelta($sql);

        update_option('qpay_db_version', QPAY_VERSION);
    }

    public static function insert_transaction(array $data): int
    {
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'qpay_transactions', $data);
        return (int) $wpdb->insert_id;
    }

    public static function update_transaction(string $payment_id, array $data): bool
    {
        global $wpdb;
        return (bool) $wpdb->update(
            $wpdb->prefix . 'qpay_transactions',
            $data,
            ['payment_id' => $payment_id]
        );
    }

    public static function get_transaction(string $payment_id): ?object
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}qpay_transactions WHERE payment_id = %s",
            $payment_id
        ));
    }

    public static function get_transactions(array $args = []): array
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qpay_transactions';

        $where = '1=1';
        $params = [];

        if (!empty($args['status'])) {
            $where .= ' AND status = %s';
            $params[] = $args['status'];
        }
        if (!empty($args['source'])) {
            $where .= ' AND source = %s';
            $params[] = $args['source'];
        }
        if (!empty($args['search'])) {
            $where .= ' AND (customer_name LIKE %s OR customer_email LIKE %s OR payment_id LIKE %s)';
            $search = '%' . $wpdb->esc_like($args['search']) . '%';
            $params[] = $search;
            $params[] = $search;
            $params[] = $search;
        }

        $limit = (int) ($args['per_page'] ?? 20);
        $offset = (int) ($args['offset'] ?? 0);

        $query = "SELECT * FROM {$table} WHERE {$where} ORDER BY created_at DESC LIMIT %d OFFSET %d";
        $params[] = $limit;
        $params[] = $offset;

        $results = $wpdb->get_results($wpdb->prepare($query, $params));
        return $results ?: [];
    }

    public static function count_transactions(array $args = []): int
    {
        global $wpdb;
        $table = $wpdb->prefix . 'qpay_transactions';

        $where = '1=1';
        $params = [];

        if (!empty($args['status'])) {
            $where .= ' AND status = %s';
            $params[] = $args['status'];
        }
        if (!empty($args['source'])) {
            $where .= ' AND source = %s';
            $params[] = $args['source'];
        }

        if (!empty($params)) {
            return (int) $wpdb->get_var($wpdb->prepare(
                "SELECT COUNT(*) FROM {$table} WHERE {$where}",
                $params
            ));
        }

        return (int) $wpdb->get_var("SELECT COUNT(*) FROM {$table} WHERE {$where}");
    }

    public static function insert_form(array $data): int
    {
        global $wpdb;
        $wpdb->insert($wpdb->prefix . 'qpay_forms', $data);
        return (int) $wpdb->insert_id;
    }

    public static function get_form(int $id): ?object
    {
        global $wpdb;
        return $wpdb->get_row($wpdb->prepare(
            "SELECT * FROM {$wpdb->prefix}qpay_forms WHERE id = %d",
            $id
        ));
    }

    public static function get_forms(): array
    {
        global $wpdb;
        return $wpdb->get_results(
            "SELECT * FROM {$wpdb->prefix}qpay_forms ORDER BY created_at DESC"
        ) ?: [];
    }

    public static function update_form(int $id, array $data): bool
    {
        global $wpdb;
        return (bool) $wpdb->update(
            $wpdb->prefix . 'qpay_forms',
            $data,
            ['id' => $id]
        );
    }

    public static function delete_form(int $id): bool
    {
        global $wpdb;
        return (bool) $wpdb->delete($wpdb->prefix . 'qpay_forms', ['id' => $id]);
    }
}

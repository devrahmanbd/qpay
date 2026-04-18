<?php

defined('ABSPATH') || exit;

class QPay_Forms
{
    public static function init(): void
    {
        add_action('admin_post_qpay_save_form', [__CLASS__, 'handle_save_form']);
        add_action('admin_post_qpay_delete_form', [__CLASS__, 'handle_delete_form']);
    }

    public static function handle_save_form(): void
    {
        if (!current_user_can('manage_options') || !check_admin_referer('qpay_form_nonce')) {
            wp_die(__('Unauthorized', 'qpay'));
        }

        $title = sanitize_text_field(wp_unslash($_POST['form_title'] ?? ''));
        $type = sanitize_text_field(wp_unslash($_POST['form_type'] ?? 'payment'));
        $field_names = array_map('sanitize_text_field', $_POST['field_name'] ?? []);
        $field_types = array_map('sanitize_text_field', $_POST['field_type'] ?? []);
        $field_required = $_POST['field_required'] ?? [];

        $fields = [];
        foreach ($field_names as $i => $name) {
            if (empty($name)) continue;
            $fields[] = [
                'name' => $name,
                'type' => $field_types[$i] ?? 'text',
                'required' => in_array($i, $field_required),
            ];
        }

        $settings = [
            'amount' => sanitize_text_field($_POST['form_amount'] ?? ''),
            'currency' => sanitize_text_field($_POST['form_currency'] ?? 'BDT'),
            'submit_label' => sanitize_text_field($_POST['form_submit_label'] ?? 'Pay Now'),
            'success_url' => esc_url_raw($_POST['form_success_url'] ?? ''),
        ];

        $data = [
            'title' => $title,
            'type' => $type,
            'fields' => wp_json_encode($fields),
            'settings' => wp_json_encode($settings),
        ];

        $form_id = (int) ($_POST['form_id'] ?? 0);
        if ($form_id > 0) {
            $data['updated_at'] = current_time('mysql');
            QPay_DB::update_form($form_id, $data);
        } else {
            QPay_DB::insert_form($data);
        }

        wp_redirect(admin_url('admin.php?page=qpay-forms&saved=1'));
        exit;
    }

    public static function handle_delete_form(): void
    {
        if (!current_user_can('manage_options') || !check_admin_referer('qpay_delete_form')) {
            wp_die(__('Unauthorized', 'qpay'));
        }
        $id = (int) ($_GET['form_id'] ?? 0);
        if ($id > 0) {
            QPay_DB::delete_form($id);
        }
        wp_redirect(admin_url('admin.php?page=qpay-forms&deleted=1'));
        exit;
    }

    public static function render_admin_page(): void
    {
        $action = sanitize_text_field($_GET['action'] ?? 'list');
        $form_id = (int) ($_GET['form_id'] ?? 0);

        if ($action === 'edit' || $action === 'new') {
            self::render_form_editor($form_id);
            return;
        }

        $forms = QPay_DB::get_forms();
        ?>
        <div class="wrap qpay-admin">
            <h1>
                <?php esc_html_e('Payment Forms', 'qpay'); ?>
                <a href="<?php echo esc_url(admin_url('admin.php?page=qpay-forms&action=new')); ?>" class="page-title-action"><?php esc_html_e('Add New', 'qpay'); ?></a>
            </h1>

            <?php if (isset($_GET['saved'])): ?>
                <div class="notice notice-success"><p><?php esc_html_e('Form saved.', 'qpay'); ?></p></div>
            <?php endif; ?>
            <?php if (isset($_GET['deleted'])): ?>
                <div class="notice notice-success"><p><?php esc_html_e('Form deleted.', 'qpay'); ?></p></div>
            <?php endif; ?>

            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th><?php esc_html_e('ID', 'qpay'); ?></th>
                        <th><?php esc_html_e('Title', 'qpay'); ?></th>
                        <th><?php esc_html_e('Type', 'qpay'); ?></th>
                        <th><?php esc_html_e('Shortcode', 'qpay'); ?></th>
                        <th><?php esc_html_e('Status', 'qpay'); ?></th>
                        <th><?php esc_html_e('Created', 'qpay'); ?></th>
                        <th><?php esc_html_e('Actions', 'qpay'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($forms)): ?>
                        <tr><td colspan="7"><?php esc_html_e('No forms found. Create your first form to get started.', 'qpay'); ?></td></tr>
                    <?php else: ?>
                        <?php foreach ($forms as $form): ?>
                            <tr>
                                <td><?php echo (int) $form->id; ?></td>
                                <td><strong><?php echo esc_html($form->title); ?></strong></td>
                                <td><?php echo esc_html(ucfirst($form->type)); ?></td>
                                <td><code>[qpay_form id="<?php echo (int) $form->id; ?>"]</code></td>
                                <td><?php echo esc_html(ucfirst($form->status)); ?></td>
                                <td><?php echo esc_html(date('M j, Y', strtotime($form->created_at))); ?></td>
                                <td>
                                    <a href="<?php echo esc_url(admin_url('admin.php?page=qpay-forms&action=edit&form_id=' . $form->id)); ?>"><?php esc_html_e('Edit', 'qpay'); ?></a>
                                    |
                                    <a href="<?php echo esc_url(wp_nonce_url(admin_url('admin-post.php?action=qpay_delete_form&form_id=' . $form->id), 'qpay_delete_form')); ?>" onclick="return confirm('<?php esc_attr_e('Delete this form?', 'qpay'); ?>')" class="qpay-text-danger"><?php esc_html_e('Delete', 'qpay'); ?></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php
    }

    private static function render_form_editor(int $form_id): void
    {
        $form = $form_id > 0 ? QPay_DB::get_form($form_id) : null;
        $fields = $form ? (json_decode($form->fields, true) ?: []) : [
            ['name' => 'name', 'type' => 'text', 'required' => true],
            ['name' => 'email', 'type' => 'email', 'required' => true],
            ['name' => 'amount', 'type' => 'number', 'required' => true],
        ];
        $settings = $form ? (json_decode($form->settings, true) ?: []) : [];
        ?>
        <div class="wrap qpay-admin">
            <h1><?php echo $form ? esc_html__('Edit Form', 'qpay') : esc_html__('New Form', 'qpay'); ?></h1>

            <form method="post" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">
                <input type="hidden" name="action" value="qpay_save_form">
                <input type="hidden" name="form_id" value="<?php echo (int) $form_id; ?>">
                <?php wp_nonce_field('qpay_form_nonce'); ?>

                <table class="form-table">
                    <tr>
                        <th><label for="form_title"><?php esc_html_e('Form Title', 'qpay'); ?></label></th>
                        <td><input type="text" id="form_title" name="form_title" value="<?php echo esc_attr($form->title ?? ''); ?>" class="regular-text" required></td>
                    </tr>
                    <tr>
                        <th><label for="form_type"><?php esc_html_e('Type', 'qpay'); ?></label></th>
                        <td>
                            <select id="form_type" name="form_type">
                                <option value="payment" <?php selected($form->type ?? 'payment', 'payment'); ?>><?php esc_html_e('Payment', 'qpay'); ?></option>
                                <option value="donation" <?php selected($form->type ?? '', 'donation'); ?>><?php esc_html_e('Donation', 'qpay'); ?></option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th><label for="form_amount"><?php esc_html_e('Fixed Amount (optional)', 'qpay'); ?></label></th>
                        <td><input type="number" id="form_amount" name="form_amount" value="<?php echo esc_attr($settings['amount'] ?? ''); ?>" step="any" min="0" class="small-text">
                        <p class="description"><?php esc_html_e('Leave empty to let the customer enter the amount.', 'qpay'); ?></p></td>
                    </tr>
                    <tr>
                        <th><label for="form_currency"><?php esc_html_e('Currency', 'qpay'); ?></label></th>
                        <td><input type="text" id="form_currency" name="form_currency" value="<?php echo esc_attr($settings['currency'] ?? 'BDT'); ?>" class="small-text"></td>
                    </tr>
                    <tr>
                        <th><label for="form_submit_label"><?php esc_html_e('Submit Button Label', 'qpay'); ?></label></th>
                        <td><input type="text" id="form_submit_label" name="form_submit_label" value="<?php echo esc_attr($settings['submit_label'] ?? 'Pay Now'); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="form_success_url"><?php esc_html_e('Success URL', 'qpay'); ?></label></th>
                        <td><input type="url" id="form_success_url" name="form_success_url" value="<?php echo esc_attr($settings['success_url'] ?? ''); ?>" class="regular-text"></td>
                    </tr>
                </table>

                <h3><?php esc_html_e('Form Fields', 'qpay'); ?></h3>
                <table class="wp-list-table widefat" id="qpay-form-fields">
                    <thead>
                        <tr>
                            <th><?php esc_html_e('Field Name', 'qpay'); ?></th>
                            <th><?php esc_html_e('Type', 'qpay'); ?></th>
                            <th><?php esc_html_e('Required', 'qpay'); ?></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fields as $i => $field): ?>
                            <tr>
                                <td><input type="text" name="field_name[]" value="<?php echo esc_attr($field['name']); ?>"></td>
                                <td>
                                    <select name="field_type[]">
                                        <option value="text" <?php selected($field['type'], 'text'); ?>>Text</option>
                                        <option value="email" <?php selected($field['type'], 'email'); ?>>Email</option>
                                        <option value="tel" <?php selected($field['type'], 'tel'); ?>>Phone</option>
                                        <option value="number" <?php selected($field['type'], 'number'); ?>>Number</option>
                                        <option value="textarea" <?php selected($field['type'], 'textarea'); ?>>Textarea</option>
                                    </select>
                                </td>
                                <td><input type="checkbox" name="field_required[]" value="<?php echo $i; ?>" <?php checked(!empty($field['required'])); ?>></td>
                                <td><button type="button" class="button qpay-remove-field">&times;</button></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p><button type="button" class="button" id="qpay-add-field"><?php esc_html_e('+ Add Field', 'qpay'); ?></button></p>

                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php esc_attr_e('Save Form', 'qpay'); ?>">
                    <a href="<?php echo esc_url(admin_url('admin.php?page=qpay-forms')); ?>" class="button"><?php esc_html_e('Cancel', 'qpay'); ?></a>
                </p>
            </form>

            <?php if ($form): ?>
                <div class="qpay-card" style="margin-top:20px;">
                    <h3><?php esc_html_e('Embed Code', 'qpay'); ?></h3>
                    <p><code>[qpay_form id="<?php echo (int) $form->id; ?>"]</code></p>
                </div>
            <?php endif; ?>
        </div>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('qpay-add-field').addEventListener('click', function() {
                var tbody = document.querySelector('#qpay-form-fields tbody');
                var idx = tbody.children.length;
                var row = document.createElement('tr');
                row.innerHTML = '<td><input type="text" name="field_name[]" value=""></td>' +
                    '<td><select name="field_type[]"><option value="text">Text</option><option value="email">Email</option><option value="tel">Phone</option><option value="number">Number</option><option value="textarea">Textarea</option></select></td>' +
                    '<td><input type="checkbox" name="field_required[]" value="' + idx + '"></td>' +
                    '<td><button type="button" class="button qpay-remove-field">&times;</button></td>';
                tbody.appendChild(row);
            });
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('qpay-remove-field')) {
                    e.target.closest('tr').remove();
                }
            });
        });
        </script>
        <?php
    }
}

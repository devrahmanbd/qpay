<div class="flex justify-end mb-4">
    <a href="<?= user_url('transactions/add-data'); ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors ajaxModal">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        ADD Data
    </a>
</div>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <?php echo render_table_thead($columns, false, false, false); ?>
            <tbody class="divide-y divide-gray-100">
                <?php
                if (!empty($items)) {
                    $i = 0;
                    foreach ($items as $item) {
                        $item_status = show_item_status('store_data', $item['id'], $item['status'], '');
                        $show_item_buttons = show_item_button_action('store_data', $item['id'], 'btn-group', '', 'user');
                        $i++;
                ?>
                        <tr class="tr_<?php echo $item['id']; ?> hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-gray-500"><?= $i ?></td>
                            <td class="px-4 py-3"><?= $item['address']; ?></td>
                            <td class="px-4 py-3"><?= $item['message']; ?></td>
                            <td class="px-4 py-3"><?= $item_status; ?></td>
                            <td class="px-4 py-3 text-gray-500"><?= time_ago($item['created_at']); ?></td>
                            <td class="px-4 py-3"><?= $show_item_buttons; ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    <?php if (empty($items)) echo show_empty_item(); ?>
</div>

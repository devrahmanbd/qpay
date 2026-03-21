<?php
echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>
<?php if (!empty($items)) { ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
    <div class="px-5 py-4 border-b border-gray-100">
        <h3 class="text-base font-semibold text-gray-800"><?= lang("Transactions") ?></h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <?php echo render_table_thead($columns, false, false, false); ?>
            <tbody class="divide-y divide-gray-100">
                <?php if (!empty($items)) {
                    $i = $from;
                    foreach ($items as $key => $item) {
                        $i++;
                        $item_payment_type = show_item_transaction_type($item['type']);
                        $created = time_format($item['created_at']);
                        $item_status = show_item_status($controller_name, $item['id'], $item['status'], '');
                ?>
                        <tr class="tr_<?php echo $item['id']; ?> hover:bg-gray-50 transition-colors">
                            <td class="px-4 py-3 text-center text-gray-500"><?= $i ?></td>
                            <td class="px-4 py-3 text-center"><?= @current_user('email', $item['uid']) ?></td>
                            <td class="px-4 py-3 text-center"><?php echo get_value($item['params'], 'cus_email'); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo $item_payment_type; ?></td>
                            <td class="px-4 py-3 text-center">
                                <?php echo $item['transaction_id']; ?>
                                <a href="<?= admin_url('view-transaction/' . $controller_name . '/' . $item['ids']) ?>" class="ajaxModal inline-flex items-center ml-1 text-gray-400 hover:text-primary-600">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                            </td>
                            <td class="px-4 py-3 text-center"><?php echo currency_format($item['amount']); ?></td>
                            <td class="px-4 py-3 text-center"><?php echo $item_status; ?></td>
                            <td class="px-4 py-3 text-center text-gray-500"><?php echo $created; ?></td>
                        </tr>
                <?php }
                } ?>
            </tbody>
        </table>
    </div>
</div>
<?php echo show_pagination($pagination); ?>
<?php } else {
    echo show_empty_item();
} ?>

<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold text-gray-800">Payments</h1>
  <a href="<?= admin_url('payments/update') ?>" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors ajaxModal">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Add new
  </a>
</div>
<?php echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]); ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><?= lang("Lists") ?></h3>
    <div><?php echo show_bulk_btn_action($controller_name); ?></div>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <?php echo render_table_thead($columns, true, false); ?>
      <tbody class="divide-y divide-gray-100 sortable" data-action="<?= admin_url('payments/sortpayments') ?>">
        <?php if (!empty($items)) {
          foreach ($items as $key => $item) {
            $item_checkbox = show_item_check_box('check_item', $item['id']);
            $item_status = show_item_status($controller_name, $item['id'], $item['status'], 'switch');
            $show_item_buttons = show_item_button_action($controller_name, $item['id']);
            $item_sort = show_item_sort($controller_name, $item['id'], $item['sort']);
        ?>
            <tr class="tr_<?php echo esc($item['id']); ?> hover:bg-gray-50 transition-colors" data-code="<?php echo esc($item['id']); ?>">
              <td class="px-4 py-3 text-center"><?php echo $item_checkbox; ?></td>
              <td class="px-4 py-3 text-gray-500"><?php echo str_replace('_', " ", $item['type']) ?></td>
              <td class="px-4 py-3 font-medium"><?php echo show_high_light(esc($item['name']), $params['search'], 'name'); ?></td>
              <td class="px-4 py-3 text-center"><?php echo $item_sort; ?></td>
              <td class="px-4 py-3 text-center"><?php echo $item_status; ?></td>
              <td class="px-4 py-3 text-center"><?php echo $show_item_buttons; ?></td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>
<?php echo show_pagination($pagination); ?>
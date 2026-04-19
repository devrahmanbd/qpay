<?php
echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

<?php if (!empty($items)) { ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><?= lang("Lists") ?></h3>
    <div><?php echo show_bulk_btn_action($controller_name, '', $trash); ?></div>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <?php echo render_table_thead($columns); ?>
      <tbody class="divide-y divide-gray-100">
        <?php if (!empty($items)) {
          $i = $from;
          foreach ($items as $key => $item) {
            $i++;
            $item_checkbox = show_item_check_box('check_item', $item['id']);
            $item_status = show_item_status($controller_name, $item['id'], $item['status'], 'switch');
            $show_item_buttons = show_item_button_action($controller_name, $item['id']);
        ?>
            <tr class="tr_<?= $item['id'] ?> hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-center"><?php echo $item_checkbox; ?></td>
              <td class="px-4 py-3 text-center text-gray-500"><?= $i ?></td>
              <td class="px-4 py-3 text-center"><?= current_user('email', $item['uid']) ?></td>
              <td class="px-4 py-3 text-center"><?= get_value($item['meta'], 'support_mail'); ?></td>
              <td class="px-4 py-3 text-center"><?= $item['domain'] . show_brand_status($item['brand_key'], $item['uid']); ?></td>
              <td class="px-4 py-3 text-center"><?= $item['ip']; ?></td>
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
<?php } else {
  echo show_empty_item();
} ?>
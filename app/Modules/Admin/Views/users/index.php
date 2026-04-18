<?php
use CodeIgniter\Model;
echo show_page_header($controller_name, ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal']);
echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

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
            $item_checkbox = show_item_check_box('check_item', $item['ids']);
            $full_name = show_high_light(esc($item['first_name']), $params['search'], 'first_name') . ' ' . show_high_light(esc($item['last_name']), $params['search'], 'last_name');
            $email = show_high_light(esc($item['email']), $params['search'], 'email');
            $item_status = show_item_status($controller_name, $item['ids'], $item['status'], 'switch');
            $created = show_item_datetime($item['created_at'], 'long');
            $show_item_buttons = show_item_button_action($controller_name, $item['ids']);
        ?>
            <tr class="tr_<?php echo esc($item['ids']); ?> hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-center"><?php echo $item_checkbox; ?></td>
              <td class="px-4 py-3 text-center text-gray-500"><?= $i ?></td>
              <td class="px-4 py-3">
                <a href="<?= admin_url("users-timeline/" . $item['ids']) ?>" class="flex items-center gap-3">
                  <img src="<?= get_avatar('user', $item['id']) ?>" class="w-8 h-8 rounded-full object-cover">
                  <div>
                    <div class="font-medium text-gray-800"><?php echo $full_name; ?></div>
                    <div class="text-xs text-gray-400"><?php echo $email; ?></div>
                  </div>
                </a>
              </td>
              <td class="px-4 py-3 text-center"><?php echo currency_format($item['balance']); ?></td>
              <td class="px-4 py-3 text-center text-gray-500"><?php echo $created; ?></td>
              <td class="px-4 py-3 text-center"><?php echo $item_status; ?></td>
              <td class="px-4 py-3 text-center"><?php echo $show_item_buttons; ?></td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>
<?= show_pagination($pagination); ?>

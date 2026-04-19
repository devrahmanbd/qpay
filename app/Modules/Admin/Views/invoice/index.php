<?php
  if (array_key_exists('invoice_add_invoice', PERMISSIONS)) {
    echo show_page_header($controller_name, ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal']);
  }
  echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

<?php if(!empty($items)){ ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><?=lang("Lists")?></h3>
    <div><?php echo show_bulk_btn_action($controller_name); ?></div>
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
            $item_status = show_item_status($controller_name, $item['id'], $item['status'], 'switch');
            $show_item_buttons = show_item_button_action($controller_name, $item['id']);
        ?>
          <tr class="tr_<?=$item['ids']?> hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-center"><?php echo $item_checkbox; ?></td>
            <td class="px-4 py-3 text-center text-gray-500"><?=$i?></td>
            <td class="px-4 py-3 text-center"><?= $item['customer_name']?></td>
            <td class="px-4 py-3 text-center"><?= $item['customer_email']; ?></td>
            <td class="px-4 py-3 text-center"><?= $item['email'];?></td>
            <td class="px-4 py-3 text-center"><?= $item['customer_amount']; ?></td>
            <td class="px-4 py-3 text-center"><?= $item['domain']; ?></td>
            <td class="px-4 py-3 text-center text-gray-500"><?= $item['created']; ?></td>
            <td class="px-4 py-3 text-center"><?php echo $item_status; ?></td>
            <td class="px-4 py-3 text-center"><?=$item['pay_status']==1?'Paid':'Unpaid'?></td>
            <td class="px-4 py-3 text-center"><?php echo $show_item_buttons; ?></td>
          </tr>
        <?php }}?>
      </tbody>
    </table>
  </div>
</div>
<?php echo show_pagination($pagination); ?>
<?php }else{
  echo show_empty_item();
}?>
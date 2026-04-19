<?php
  echo show_page_header($controller_name, ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal']);
  echo show_page_header_filter($controller_name, ['items_status_count' => $items_status_count, 'params' => $params]);
?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><?=lang("Lists")?></h3>
    <div><?php echo show_bulk_btn_action($controller_name,'admin',$trash); ?></div>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <?php echo render_table_thead($columns); ?>
      <tbody class="divide-y divide-gray-100 sortable" data-action="<?=admin_url('faqs/sortfaqs')?>">
        <?php if (!empty($items)) {
          $i = $from;
          foreach ($items as $key => $item) {
            $i++;
            $item_checkbox = show_item_check_box('check_item', $item['id']);
            $item_sort = show_item_sort($controller_name, $item['id'], $item['sort']);
            $item_status = show_item_status($controller_name, $item['id'], $item['status'], 'switch');
            $show_item_buttons = show_item_button_action($controller_name, $item['id']);
            $answer = show_high_light(shorten_string(html_entity_decode($item['answer'], ENT_QUOTES), 100), $params['search'], 'answer');
        ?>
          <tr class="tr_<?php echo esc($item['id']); ?> hover:bg-gray-50 transition-colors" data-code="<?php echo esc($item['id']); ?>">
            <td class="px-4 py-3 text-center"><?php echo $item_checkbox; ?></td>
            <td class="px-4 py-3 text-center text-gray-500"><?=$i?></td>
            <td class="px-4 py-3">
              <h6 class="text-sm font-medium text-gray-800">Q: <?php echo show_high_light(esc($item['question']), $params['search'], 'question'); ?></h6>
              <p class="text-xs text-gray-500 mt-1"><strong>Answer:</strong> <?php echo $answer; ?></p>
            </td>
            <td class="px-4 py-3 text-center"><?php echo $item_sort;?></td>
            <td class="px-4 py-3 text-center"><?php echo $item_status; ?></td>
            <td class="px-4 py-3 text-center text-gray-500"><?php echo $item['updated_at'] ?></td>
            <td class="px-4 py-3 text-center"><?php echo $show_item_buttons; ?></td>
          </tr>
        <?php }}?>
      </tbody>
    </table>
  </div>
</div>
<?php echo show_pagination($pagination); ?>
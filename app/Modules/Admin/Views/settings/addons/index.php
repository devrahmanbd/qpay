<div class="mb-4">
  <h4 class="text-lg font-semibold text-gray-800">User Addons</h4>
</div>
<?php
  echo show_page_header('addons', ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal']);
  if(!empty($items)){
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
  <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><?=lang("Lists")?></h3>
    <div><?php echo show_bulk_btn_action('user-addon'); ?></div>
  </div>
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <?php echo render_table_thead($columns); ?>
      <tbody class="divide-y divide-gray-100 sortable">
        <?php if (!empty($items)) {
          $i = 0;
          foreach ($items as $key => $item) {
            $item = (array)$item;
            $i++;
            $item_checkbox = show_item_check_box('check_item', $item['id']);
            $show_item_buttons = show_item_button_action('user-addon', $item['id']);
        ?>
          <tr class="tr_<?php echo esc($item['id']); ?> hover:bg-gray-50 transition-colors" data-code="<?php echo esc($item['id']); ?>">
            <td class="px-4 py-3 text-center"><?php echo $item_checkbox; ?></td>
            <td class="px-4 py-3 text-center text-gray-500"><?=$i?></td>
            <td class="px-4 py-3"><?= $item['name']; ?></td>
            <td class="px-4 py-3 text-center"><?= currency_format($item['price']); ?></td>
            <td class="px-4 py-3 text-center"><?php echo $item['version']; ?></td>
            <td class="px-4 py-3 text-center"><?php echo $show_item_buttons; ?></td>
          </tr>
        <?php }}?>
      </tbody>
    </table>
  </div>
</div>
<?php }?>

<?=form_open('','class="actionForm" data-redirect="'.admin_url('addons').'" ')?>
<div class="mb-6">
  <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-primary-400 transition-colors">
    <div class="settings">
      <input type="text" name="file" class="hidden" value="">
      <div class="flex flex-col items-center gap-3">
        <label for="file-input" class="cursor-pointer px-4 py-2 border border-primary-500 text-primary-600 rounded-lg text-sm font-medium hover:bg-primary-50 transition-colors">Upload a ZIP File</label>
        <input class="settings_fileupload hidden" id="file-input" data-type="zip" type="file" name="files[]" onchange="document.getElementById('upload-btn').style.display='inline'">
        <button id="upload-btn" class="hidden px-4 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition-colors" type="submit">Extract File</button>
      </div>
    </div>
  </div>
</div>
<?=form_close();?>

<div class="bg-gray-800 rounded-xl p-4">
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <?php foreach($addons as $addon): ?>
      <div class="bg-gray-900 rounded-lg p-4">
        <div class="flex items-center gap-2 mb-3">
          <span class="text-sm text-gray-300">Status</span>
          <?php
           $id = get_option('enable_'.lcfirst($addon), '0');
           $item_status = show_item_status('addons', $addon, $id, 'switch');
           echo $item_status;
          ?>
        </div>
        <div class="text-gray-300 text-sm">
          <?php echo get_addon_details($addon); ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

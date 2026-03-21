<?= canAddBrand($items) ? show_page_header('brands', ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal'], 'user') : ''; ?>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-200 bg-gray-50">
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Brand Key</th>
          <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Brand Name</th>
          <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php
        if (!empty($items)) {
          $i = 0;
          foreach ($items as $item) {
            $item_status = show_item_status('brands', $item['id'], $item['status'], 'switch', '', 'user');
            $show_item_buttons = show_item_button_action('brands', $item['id'], '', '', 'user');
            $i++;
        ?>
            <tr class="tr_<?= $item['id'] ?> hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-gray-500"><?= $i ?></td>
              <td class="px-4 py-3">
                <div class="flex items-center gap-2">
                  <input readonly type="text" class="flex-1 border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-gray-50 text-to-cliboard" value="<?= $item['brand_key'] ?>">
                  <button class="my-copy-btn p-1.5 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors cursor-pointer"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg></button>
                  <a href="<?= user_url('brands/reset-key/' . $item['id']) ?>" class="ajaxDeleteItem p-1.5 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition-colors" data-confirm_ms="reset the brand key" title="Reset Brand Key"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg></a>
                  <?= show_brand_status($item['brand_key'], session('uid')) ?>
                </div>
              </td>
              <td class="px-4 py-3 text-center"><?= $item['brand_name']; ?></td>
              <td class="px-4 py-3 text-center"><?php echo $item_status; ?></td>
              <td class="px-4 py-3 text-center"><?php echo $show_item_buttons; ?></td>
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

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-200 bg-gray-50">
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Customer Email</th>
          <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
          <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
          <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
          <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php
        if (!empty($items)) {
          $i = 0;
          foreach ($items as $item) {
            $item_status = show_item_status($controller_name, $item['ids'], $item['status'], 'switch', '', 'user');
            $show_item_buttons = show_item_button_action($controller_name, $item['ids'], '', '', 'user');
            $i++;
        ?>
            <tr class="tr_<?= $item['ids'] ?> hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-gray-500">
                <?= $i ?>
                <button class="group-text ml-1 text-gray-400 hover:text-primary-600 cursor-pointer" data-value="<?= base_url('invoice/' . $item['ids']) ?>" onclick="copyToClipBoard({type:'text',value:this.dataset.value},true,'Invoice Link Copied')">
                  <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                </button>
              </td>
              <td class="px-4 py-3"><?= $item['customer_email'] ?></td>
              <td class="px-4 py-3">
                <?= $item['customer_amount'] ?>
                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700 ml-1">
                  <?= $item['pay_status'] == 1 ? 'Pending' : ($item['pay_status'] == 2 ? 'Paid' : 'Unpaid') ?>
                  <?php if (!empty($item['transaction_id'])) { ?> <span class="ml-1 text-gray-500"><?= $item['transaction_id'] ?></span> <?php } ?>
                </span>
              </td>
              <td class="px-4 py-3 text-center"><?= $item_status ?></td>
              <td class="px-4 py-3 text-center text-gray-500"><?= show_item_datetime($item['created_at'], 'short'); ?></td>
              <td class="px-4 py-3 text-center"><?= $show_item_buttons ?></td>
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

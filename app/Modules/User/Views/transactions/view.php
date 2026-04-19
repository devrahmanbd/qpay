<?= view('layouts/common/modal/modal_top'); ?>

<div class="overflow-x-auto mb-4">
  <table class="w-full text-sm">
    <tbody class="divide-y divide-gray-100">
      <tr><td class="px-4 py-2.5 font-medium text-gray-700 w-40">Transaction ID</td><td class="px-4 py-2.5 text-gray-600"><?= @$item->transaction_id ?></td></tr>
      <tr class="bg-gray-50"><td class="px-4 py-2.5 font-medium text-gray-700">Customer Name</td><td class="px-4 py-2.5 text-gray-600"><?= @get_value($item->params, 'cus_name') ?></td></tr>
      <tr><td class="px-4 py-2.5 font-medium text-gray-700">Customer Email</td><td class="px-4 py-2.5 text-gray-600"><?= @get_value($item->params, 'cus_email') ?></td></tr>
      <tr class="bg-gray-50"><td class="px-4 py-2.5 font-medium text-gray-700">Amount</td><td class="px-4 py-2.5 text-gray-600"><?= @$item->amount ?></td></tr>
      <tr><td class="px-4 py-2.5 font-medium text-gray-700">Status</td><td class="px-4 py-2.5"><?= show_item_status('transactions', $item->id, $item->status, '', 'user'); ?></td></tr>
      <tr class="bg-gray-50"><td class="px-4 py-2.5 font-medium text-gray-700">Message</td><td class="px-4 py-2.5 text-gray-600"><?= @$item->message ?></td></tr>
    </tbody>
  </table>
</div>
<?php if (!empty($item->files)) : ?>
  <iframe src="<?= getenv('PAYMENT_URL') . ($item->files) ?>" class="w-full h-[50vh] border-0 rounded-lg mb-4"></iframe>
<?php endif; ?>
<div class="flex flex-wrap items-center gap-2 pt-4 border-t border-gray-100">
  <?= form_open('', ['class' => 'form actionForm flex flex-wrap gap-2']); ?>
  <input type="hidden" name="type" value="<?= (!empty($item->files)) ? 'bank' : 'manual'; ?>">
  <input type="hidden" name="k_status" value="">
  <?php if ($item->status != 2) : ?>
    <button type="submit" onclick="this.form.k_status.value=this.value" class="px-3 py-1.5 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 transition-colors" value="2">Complete</button>
  <?php endif; ?>
  <?php if ($item->status != 0) : ?>
    <button type="submit" onclick="this.form.k_status.value=this.value" class="px-3 py-1.5 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition-colors" value="0">Pending</button>
  <?php endif; ?>
  <?php if ($item->status != 1) : ?>
    <button type="submit" onclick="this.form.k_status.value=this.value" class="px-3 py-1.5 bg-yellow-500 text-white text-sm rounded-lg hover:bg-yellow-600 transition-colors" value="1">Initiate</button>
  <?php endif; ?>
  <?php if ($item->status != 3) : ?>
    <button type="submit" onclick="this.form.k_status.value=this.value" class="px-3 py-1.5 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 transition-colors" value="3">Cancel Now</button>
  <?php endif; ?>
  <button type="button" onclick="closeModal()" class="px-3 py-1.5 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition-colors">Close</button>
  <?= form_close(); ?>
</div>

<?= view('layouts/common/modal/modal_bottom'); ?>
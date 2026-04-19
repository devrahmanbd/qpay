<?php if (!empty($items)) { ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
  <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Customer Name</label>
      <input type="text" value="<?= $items['customer_name'] ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Customer Number</label>
      <input type="text" value="<?= $items['customer_number'] ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Customer Email</label>
      <input type="text" value="<?= $items['customer_email'] ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Brand Name</label>
      <input type="text" value="<?= @$items['brand_name'] ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50" readonly>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Customer Address</label>
      <textarea readonly class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50"><?= $items['customer_address'] ?></textarea>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
      <textarea readonly class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50"><?= $items['customer_description'] ?></textarea>
    </div>
  </div>
  <div>
    <label class="block text-sm font-medium text-gray-700 mb-1">Your Invoice URL</label>
    <div class="flex items-center gap-2">
      <input type="text" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 text-to-cliboard" readonly value="<?= base_url('invoice/' . $items['ids']) ?>">
      <button class="my-copy-btn p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors cursor-pointer">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
      </button>
    </div>
  </div>
</div>
<?php } else {
    echo show_empty_item();
} ?>
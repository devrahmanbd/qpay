<?= canAddDevice($items) ? show_page_header('devices', ['page-options' => 'add-new', 'page-options-type' => 'ajax-modal'], 'user') : ''; ?>
<div class="space-y-3">
  <?php if (!empty($items)) :
    foreach ($items as $item) :
  ?>
      <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
        <div class="flex items-center gap-2 mb-3">
            <span class="text-sm font-medium text-primary-600"><?= $item->device_name; ?></span>
            <?= show_device_status($item->device_key, session('uid')) ?>
        </div>
        <div class="flex items-center gap-2 mb-3">
          <input readonly type="text" class="flex-1 border border-gray-300 rounded-lg px-3 py-1.5 text-sm bg-gray-50 text-to-cliboard" value="<?= $item->device_key; ?>">
          <button class="my-copy-btn p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
          </button>
        </div>
        <div class="text-sm">
          <?php if (!empty($item->device_ip)) : ?>
            <span class="text-primary-600">You connected your device on <?= time_format($item->updated_at) ?></span>
          <?php else : ?>
            <span class="text-gray-400">You didn't connect any device</span>
          <?php endif; ?>
        </div>
      </div>
  <?php endforeach;
  else : echo show_empty_item();
  endif; ?>
</div>

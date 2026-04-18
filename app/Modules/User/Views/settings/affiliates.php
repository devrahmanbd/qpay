<?php
$qr_content = base_url('affiliates/' . current_user('ref_key'));
?>
<div class="space-y-4">
  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <h3 class="text-base font-semibold text-primary-600 mb-4">Referral Programs</h3>
    <div class="mb-4">
      <label class="block text-sm font-medium text-gray-700 mb-1">Your Referral Link</label>
      <div class="flex items-center gap-2">
        <input readonly type="text" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm bg-gray-50 text-to-cliboard" value="<?= base_url('affiliates/' . current_user('ref_key')) ?>">
        <button class="my-copy-btn p-2 text-gray-400 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors cursor-pointer">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
        </button>
      </div>
    </div>
    <p class="text-sm text-gray-600">Your Parent User: <span class="font-medium"><?= current_user('ref_id') ? current_user('email', current_user('ref_id')) : 'No Parent User Found' ?></span></p>
  </div>

  <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
    <div class="text-center overflow-x-auto">
      <?= render_user_tree_table(session('uid'), get_option('affiliate_level', 4)); ?>
    </div>
  </div>
</div>

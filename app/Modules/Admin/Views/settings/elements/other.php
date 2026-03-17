<?php
$form_url = admin_url($controller_name . "/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-cog text-gray-400 mr-1"></i> <?= lan("other_settings") ?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-4">
    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-1"><i class="fa fa-link mr-1"></i> <?= lan("homepage_code") ?></h5>
      <p class="text-xs text-red-500 mb-2">Put in the homepage code</p>
      <textarea rows="5" name="embed_head_javascript" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono embed_head_javascript"><?= get_option('embed_head_javascript', '') ?></textarea>
      <p class="text-xs text-red-500 mt-1"><?= lan("note:_homepage_code") ?></p>
    </div>
    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-1"><i class="fa fa-link mr-1"></i> <?= lan("logged_in_code") ?></h5>
      <p class="text-xs text-red-500 mb-2">Put in the logged in code</p>
      <textarea rows="5" name="embed_javascript" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono embed_head_javascript"><?= get_option('embed_javascript', '') ?></textarea>
      <p class="text-xs text-red-500 mt-1"><?= lan("note:_logged_in_code") ?></p>
    </div>
  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?= lan("Save") ?></button>
  </div>
  <?php echo form_close(); ?>
</div>

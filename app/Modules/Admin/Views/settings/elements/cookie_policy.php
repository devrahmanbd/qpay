<?php
$form_url = admin_url($controller_name."/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-bookmark text-gray-400 mr-1"></i> <?php echo lan("cookie_policy_page"); ?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-4">
    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?=lan("Status")?></h5>
      <label class="relative inline-flex items-center cursor-pointer">
        <input type="hidden" name="is_cookie_policy_page" value="0">
        <input type="checkbox" name="is_cookie_policy_page" class="sr-only peer" <?=(get_option("is_cookie_policy_page", 0) == 1) ? "checked" : ""?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600"><?=lan("Active")?></span>
      </label>
    </div>
    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?php echo lan("Content"); ?></h5>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("Content")?></label>
      <textarea rows="3" name="cookies_policy_page" id="cookies_policy_page" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm plugin_editor"><?=get_option('cookies_policy_page', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet.</p>")?></textarea>
    </div>
  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?=lan("Save")?></button>
  </div>
  <?php echo form_close(); ?>
</div>

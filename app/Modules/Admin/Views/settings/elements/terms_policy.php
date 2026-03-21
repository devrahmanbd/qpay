<?php
$form_url = admin_url($controller_name."/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-award text-gray-400 mr-1"></i> <?=lan("terms__policy")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-4">
    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?=lan("content_of_terms")?></h5>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("Content")?></label>
      <textarea rows="3" name="terms_content" id="terms_content" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm plugin_editor"><?=get_option('terms_content', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet.</p>")?></textarea>
    </div>
    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?=lan("content_of_policy")?></h5>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("Content")?></label>
      <textarea rows="3" name="policy_content" id="policy_content" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm plugin_editor"><?=get_option('policy_content', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet.</p>")?></textarea>
    </div>
  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?=lan("Save")?></button>
  </div>
  <?php echo form_close(); ?>
</div>

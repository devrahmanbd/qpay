<?php
$form_url = admin_url($controller_name . "/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-code text-gray-400 mr-1"></i> <?= lan("dev_page_design") ?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5">
    <input type="hidden" name="dev_page" value="1">
    <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?= lan("edit_devpage_code") ?></h5>
    <textarea id="devpage_code" name="devpage_code" rows="30" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono"><?= htmlspecialchars(file_get_contents(APPPATH . "Modules/Home/Views/developers/docs.php")) ?></textarea>
  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button type="submit" class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?= lan("Save") ?></button>
  </div>
  <?php echo form_close(); ?>
</div>

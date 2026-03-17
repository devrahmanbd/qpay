<?php
$form_url = admin_url($controller_name."/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-image text-gray-400 mr-1"></i> <?=lan("site_logo")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <input type="hidden" name="update_file" value="1">
  <div class="p-5 space-y-4">

    <div class="settings">
      <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("site_icon")?></label>
      <div class="flex items-center gap-2">
        <input type="text" name="site_icon" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm" value="<?=(get_option('site_icon'))?>">
        <label class="cursor-pointer px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
          <i class="fa fa-image text-gray-400"></i>
          <input class="settings_fileupload hidden" type="file" name="files[]" data-type="image" multiple="">
        </label>
      </div>
    </div>

    <div class="settings">
      <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("site_logo")?></label>
      <div class="flex items-center gap-2">
        <input type="text" name="site_logo" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm" value="<?=(get_option('site_logo'))?>">
        <label class="cursor-pointer px-3 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
          <i class="fa fa-image text-gray-400"></i>
          <input class="settings_fileupload hidden" type="file" name="files[]" data-type="image" multiple="">
        </label>
      </div>
    </div>

  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?=lan("Save")?></button>
  </div>
  <?php echo form_close(); ?>
</div>

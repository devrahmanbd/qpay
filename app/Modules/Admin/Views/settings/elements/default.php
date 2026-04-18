<?php
$form_url = admin_url($controller_name . "/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-cog text-gray-400 mr-1"></i> Default Setting</h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-6">

    <div class="max-w-md">
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?= lan("Pagination") ?></h5>
      <div class="mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("limit_the_maximum_number_of_rows_per_page") ?></label>
        <select name="default_limit_per_page" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
          <?php for ($i = 1; $i <= 100; $i++) { if ($i % 5 == 0) { ?>
            <option value="<?= $i ?>" <?= (get_option("default_limit_per_page", 10) == $i) ? "selected" : '' ?>><?= $i ?></option>
          <?php } } ?>
        </select>
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"><i class="fa fa-link mr-1"></i> Tickets log (Auto clear ticket lists)</label>
      <label class="relative inline-flex items-center cursor-pointer">
        <input type="hidden" name="is_clear_ticket" value="0">
        <input type="checkbox" name="is_clear_ticket" class="sr-only peer" <?= (get_option("is_clear_ticket", 0) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600">Active</span>
      </label>
    </div>

    <div class="max-w-md">
      <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("clear_ticket_lists_after_x_days_without_any_response_from_user") ?></label>
      <select name="default_clear_ticket_days" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <?php $default_clear_ticket_days = get_option('default_clear_ticket_days', 30);
        for ($i = 1; $i <= 90; $i++) { ?>
          <option value="<?= $i ?>" <?= ($default_clear_ticket_days == $i) ? 'selected' : '' ?>> <?= $i ?></option>
        <?php } ?>
      </select>
    </div>

    <div class="max-w-md">
      <label class="block text-sm font-medium text-gray-700 mb-1">Max pending tickets per user</label>
      <select name="default_pending_ticket_per_user" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
        <?php $default_pending_ticket_per_user = get_option('default_pending_ticket_per_user', 2);
        for ($i = 1; $i <= 9; $i++) {
          $number_ticket_title = $i . ' ticket' . ($i > 1 ? 's' : ''); ?>
          <option value="<?= $i ?>" <?= ($default_pending_ticket_per_user == $i) ? 'selected' : '' ?>> <?= $number_ticket_title ?></option>
        <?php } ?>
        <option value="0" <?= ($default_pending_ticket_per_user == 0) ? 'selected' : '' ?>> Unlimited</option>
      </select>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fa fa-link mr-1"></i> <?= lan("notification_popup_at_home_page") ?></h5>
      <label class="relative inline-flex items-center cursor-pointer mb-3">
        <input type="hidden" name="enable_notification_popup" value="0">
        <input type="checkbox" name="enable_notification_popup" class="sr-only peer" <?= (get_option("enable_notification_popup", 0) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600">Active</span>
      </label>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("Content") ?></label>
        <textarea rows="2" name="notification_popup_content" id="notification_popup_content" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm plugin_editor"><?= get_option('notification_popup_content', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer.</p>") ?></textarea>
      </div>
    </div>

    <div>
      <h5 class="text-sm font-semibold text-primary-600 mb-2"><i class="fas fa-link mr-1"></i> <?= lan("notification_popup_at_panel") ?></h5>
      <label class="relative inline-flex items-center cursor-pointer mb-3">
        <input type="hidden" name="enable_panel_notification_popup" value="0">
        <input type="checkbox" name="enable_panel_notification_popup" class="sr-only peer" <?= (get_option("enable_panel_notification_popup", 0) == 1) ? "checked" : "" ?> value="1">
        <div class="w-9 h-5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600"></div>
        <span class="ml-2 text-sm text-gray-600">Active</span>
      </label>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?= lan("Content") ?></label>
        <textarea rows="2" name="notification_popup_panel_content" id="notification_popup_panel_content" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm plugin_editor"><?= get_option('notification_popup_panel_content', "<p><strong>Lorem Ipsum</strong></p><p>Lorem ipsum dolor sit amet, in eam consetetur consectetuer.</p>") ?></textarea>
      </div>
    </div>

  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?= lan("Save") ?></button>
  </div>
  <?php echo form_close(); ?>
</div>

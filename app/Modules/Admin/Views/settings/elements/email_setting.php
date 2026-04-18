<?php
$form_url = admin_url($controller_name."/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content" x-data="{ protocol: '<?=get_option('email_protocol_type','php_mail')?>' }">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-envelope text-gray-400 mr-1"></i> <?=lan("email_setting")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-4">

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-3"><?=lan("email_notifications_or_notification")?></label>
      <div class="space-y-2">
        <?php
        $email_toggles = [
          ['enable_notification', 'Notifications (*If not enabled no notification will work)', 0],
          ['is_verification_new_account', 'Email verification for new user accounts (Preventing Spam Account)', 0],
          ['is_welcome_email', 'New User Welcome Email', 0],
          ['is_new_user_email', 'New User Notification Email <small class="text-gray-400">(Receive notification when a new user registers)</small>', 0],
          ['is_payment_notice_email', 'Payments Notification Email <small class="text-gray-400">(Send notification when user adds funds)</small>', 0],
          ['is_ticket_notice_email', 'Ticket Notification Email <small class="text-gray-400">(Send notification to user when Admin replies)</small>', 0],
          ['is_ticket_notice_email_admin', 'Ticket Notification Email <small class="text-gray-400">(Send notification to Admin when user opens ticket)</small>', 0],
          ['is_order_notice_email', 'Order Notification Email <small class="text-gray-400">(Receive notification when user places order)</small>', 0],
        ];
        foreach ($email_toggles as $et): ?>
        <label class="relative inline-flex items-start cursor-pointer">
          <input type="hidden" name="<?=$et[0]?>" value="0">
          <input type="checkbox" name="<?=$et[0]?>" class="sr-only peer" <?=(get_option($et[0], $et[2]) == 1) ? "checked" : ""?> value="1">
          <div class="w-9 h-5 mt-0.5 bg-gray-200 peer-focus:ring-2 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-primary-600 flex-shrink-0"></div>
          <span class="ml-2 text-sm text-gray-600"><?=$et[1]?></span>
        </label><br>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="space-y-3">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">From (Email Format)</label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="email_from" value="<?=get_option('email_from',"")?>">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("your_name")?></label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="email_name" value="<?=get_option('email_name',"")?>">
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2"><?=lan("email_protocol")?></label>
      <div class="space-y-2">
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="email_protocol_type" value="php_mail" class="text-primary-600" <?=(get_option('email_protocol_type',"php_mail") == 'php_mail')? "checked" : ''?> @change="protocol = 'php_mail'">
          <span class="text-sm text-gray-600"><?=lan("php_mail_function")?></span>
        </label>
        <label class="flex items-center gap-2 cursor-pointer">
          <input type="radio" name="email_protocol_type" value="smtp" class="text-primary-600" <?=(get_option('email_protocol_type',"php_mail") == 'smtp')? "checked" : ''?> @change="protocol = 'smtp'">
          <span class="text-sm text-gray-600"><?=lan("SMTP")?> <small class="text-gray-400"><?=lan("recommended")?></small></span>
        </label>
      </div>
      <p class="text-xs text-gray-500 mt-1"><strong><?=lan("note")?></strong> <?=lan("sometime_email_is_going_into__recipients_spam_folders_if_php_mail_function_is_enabled")?></p>
    </div>

    <div x-show="protocol === 'smtp'" x-transition class="grid grid-cols-1 md:grid-cols-2 gap-4 border border-gray-200 rounded-lg p-4">
      <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("smtp_server")?></label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="smtp_server" value="<?=get_option('smtp_server',"")?>">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("smtp_port")?> <small class="text-gray-400">(25, 465, 587, 2525)</small></label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="smtp_port" value="<?=get_option('smtp_port',"")?>">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("smtp_encryption")?></label>
        <select name="smtp_encryption" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm">
          <option value="none" <?=(get_option('smtp_encryption',"") == 'none')? "selected" : ''?>>None</option>
          <option value="ssl" <?=(get_option('smtp_encryption',"") == 'ssl')? "selected" : ''?>>SSL</option>
          <option value="tls" <?=(get_option('smtp_encryption',"") == 'tls')? "selected" : ''?>>TLS</option>
        </select>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("smtp_username")?></label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="smtp_username" value="<?=get_option('smtp_username',"")?>">
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("smtp_password")?></label>
        <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="smtp_password" value="<?=get_option('smtp_password',"")?>">
      </div>
    </div>

  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?=lan("Save")?></button>
  </div>
  <?php echo form_close(); ?>
</div>

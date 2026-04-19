<?php
$form_url = admin_url($controller_name."/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => current_url(), 'method' => "POST");

$templates = [
  ['title' => 'email_verification_for_new_user_accounts', 'key' => 'verify', 'subject_field' => 'verification_email_subject', 'content_field' => 'verification_email_content'],
  ['title' => 'new_user_welcome_email', 'key' => 'welcome', 'subject_field' => 'email_welcome_email_subject', 'content_field' => 'email_welcome_email_content'],
  ['title' => 'new_user_notification_email', 'key' => 'new_user', 'subject_field' => 'email_new_registration_subject', 'content_field' => 'email_new_registration_content'],
  ['title' => 'password_recovery', 'key' => 'forgot_password', 'subject_field' => 'email_password_recovery_subject', 'content_field' => 'email_password_recovery_content'],
  ['title' => 'admin_password_recovery', 'key' => 'admin_forgot_password', 'subject_field' => 'admin_email_password_recovery_subject', 'content_field' => 'admin_email_password_recovery_content'],
  ['title' => 'payment_notification_email', 'key' => 'payment', 'subject_field' => 'email_payment_notice_subject', 'content_field' => 'email_payment_notice_content'],
];
?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden content">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa fa-edit text-gray-400 mr-1"></i> <?=lan("email_template")?></h3>
  </div>
  <?php echo form_open($form_url, $form_attributes); ?>
  <div class="p-5 space-y-6">
    <?php foreach ($templates as $tpl):
      $tmplObj = getEmailTemplate($tpl['key']);
    ?>
    <div class="border border-gray-200 rounded-lg p-4">
      <h5 class="text-sm font-semibold text-primary-600 mb-3"><i class="fa fa-link mr-1"></i> <?=lan($tpl['title'])?></h5>
      <div class="space-y-3">
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("Subject")?></label>
          <input class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm" name="<?=$tpl['subject_field']?>" value="<?=get_option($tpl['subject_field'], $tmplObj->subject)?>">
        </div>
        <div>
          <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("Content")?></label>
          <textarea rows="3" name="<?=$tpl['content_field']?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm plugin_editor"><?=get_option($tpl['content_field'], $tmplObj->content)?></textarea>
        </div>
        <?php if (!empty($tmplObj->short_keys)):
          $contens = json_decode($tmplObj->short_keys); ?>
        <div class="text-xs text-gray-500">
          <strong><?=lan("note")?></strong> <?=lan("you_can_use_following_template_tags_within_the_message_template")?>
          <ul class="mt-1 list-disc list-inside">
            <?php foreach($contens as $key => $val): ?>
            <li>{{<?=$key?>}} - <?=lang($val);?></li>
            <?php endforeach; ?>
          </ul>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="px-5 py-4 border-t border-gray-100 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?=lan("Save")?></button>
  </div>
  <?php echo form_close(); ?>
</div>

<?php if(get_option('enable_all_user')==1){ ?>
<div class="bg-blue-50 rounded-xl shadow-sm border border-blue-200 overflow-hidden mt-4">
  <?=form_open(admin_url("users/sendEmailsToAllUsers"), $form_attributes); ?>
  <div class="p-5 space-y-3">
    <h5 class="text-sm font-semibold text-primary-600"><i class="fa fa-link mr-1"></i> <?=lan("Send mail to all user")?></h5>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("Subject")?></label>
      <textarea rows="2" name="mail_subject" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm"></textarea>
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1"><?=lan("Content")?></label>
      <textarea rows="3" name="mail_body" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm plugin_editor"></textarea>
    </div>
    <?php if (!empty(getEmailTemplate("user_message")->short_keys)):
      $contens = json_decode(getEmailTemplate("user_message")->short_keys); ?>
    <div class="text-xs text-gray-500">
      <strong><?=lan("note")?></strong> <?=lan("you_can_use_following_template_tags_within_the_message_template")?>
      <ul class="mt-1 list-disc list-inside">
        <?php foreach($contens as $key => $val): ?>
        <li>{{<?=$key?>}} - <?=lang($val);?></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <?php endif; ?>
  </div>
  <div class="px-5 py-4 border-t border-blue-200 text-right">
    <button class="px-6 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors uppercase"><?=lan("Send mail")?></button>
  </div>
  <?php echo form_close(); ?>
</div>
<?php } ?>
<?php
$controller_name = "staffs/role_permision";
$form_url = admin_url($controller_name."/store");
$redirect_url = admin_url("staffs-roles");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
$form_hidden = ['id' => @$item['id'],'name'=>'kkkk'];
$permissions = !empty($item['permissions'])?json_decode($item['permissions'],true):[];
$data['modal_title'] = !empty($item['id'])?"Edit Role-".@$item['name']:"Add User Role";

$sections = [
  'Dashboard' => [
    'dashboard_statistics' => ['dashboard.statistics', 'Statistics'],
    'dashboard_bar_chart' => ['dashboard.bar_chart', 'Bar Chart'],
    'dashboard_latest_transactions' => ['dashboard.latest_transactions', 'Latest Transactions'],
  ],
  'Users' => [
    'user_access_user' => ['user.access_user', 'Access to User Manage'],
    'user_add_user' => ['user.add_user', 'Add User'],
    'user_edit_user' => ['user.edit_user', 'Edit User'],
    'user_delete_user' => ['user.delete_user', 'Delete User'],
    'user_view_user' => ['user.view_user', 'View User'],
    'user_add_fund_user' => ['user.add_fund_user', 'Add Fund User'],
    'user_send_mail_user' => ['user.send_mail_user', 'Send mail to user'],
    'user_set_password_user' => ['user.set_password_user', 'Set Password User'],
    'user_detail_user' => ['user.detail_user', 'More Detail User'],
    'user_access_transaction' => ['user.access_transaction', 'Access to User Transactions'],
  ],
  'Invoices' => [
    'invoice_access_invoice' => ['invoice.access_invoice', 'Access to invoices'],
    'invoice_view_invoice' => ['invoice.view_invoice', 'View Invoice'],
    'invoice_add_invoice' => ['invoice.add_invoice', 'Add Invoice'],
    'invoice_edit_invoice' => ['invoice.edit_invoice', 'Edit Invoice'],
    'invoice_delete_invoice' => ['invoice.delete_invoice', 'Delete Invoice'],
  ],
  'Domains' => [
    'domain_access_domain' => ['domain.access_domain', 'Access to domains'],
    'domain_edit_domain' => ['domain.edit_domain', 'Edit Domain'],
    'domain_delete_domain' => ['domain.delete_domain', 'Delete Domain'],
  ],
  'Devices' => [
    'device_access_device' => ['device.access_device', 'Access to devices'],
    'device_edit_device' => ['device.edit_device', 'Edit device'],
    'device_delete_device' => ['device.delete_device', 'Delete device'],
  ],
  'Plans' => [
    'plan_access_plan' => ['plan.access_plan', 'Access to Plan'],
    'plan_access_user_plan' => ['plan.access_user_plan', 'Access to Users Plan'],
    'plan_add_plan' => ['plan.add_plan', 'Add Plan'],
    'plan_edit_plan' => ['plan.edit_plan', 'Edit Plan'],
    'plan_delete_plan' => ['plan.delete_plan', 'Delete Plan'],
  ],
  'Settings' => [
    'setting_access_setting' => ['setting.access_setting', 'Access to settings'],
    'setting_access_payment_setting' => ['setting.access_payment_setting', 'Access to Payment settings'],
    'setting_access_staff' => ['setting.access_staff', 'Access to Staffs'],
    'setting_access_role' => ['setting.access_role', 'Access to Roles & Permissions'],
    'setting_acess_activity' => ['setting.acess_activity', 'Access to Activity Logs'],
    'setting_access_faq' => ['setting.access_faq', 'Access to FAQs'],
    'setting_access_coupon' => ['setting.access_coupon', 'Access to Coupon'],
    'setting_add_coupon' => ['setting.add_coupon', 'Add Coupon'],
    'setting_edit_coupon' => ['setting.edit_coupon', 'Edit Coupon'],
    'setting_delete_coupon' => ['setting.delete_coupon', 'Delete Coupon'],
    'setting_access_blog' => ['setting.access_blog', 'Access to Blogs'],
    'setting_developer' => ['setting.developer', 'Developers Page Edit'],
    'setting_access_tickets' => ['setting.access_tickets', 'Access to Tickets'],
    'setting_databackup' => ['setting.databackup', 'DataBackup'],
  ],
];
?>

<?=view('layouts/common/modal/modal_top',$data); ?>
<?=form_open($form_url, $form_attributes, $form_hidden);?>

<div class="mb-4">
  <label class="block text-sm font-medium text-gray-700 mb-1">Role Name</label>
  <input type="text" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" name="name" value="<?=@$item['name']?>">
</div>

<div class="space-y-4">
  <?php foreach ($sections as $sectionName => $perms): ?>
  <div class="border border-gray-200 rounded-lg p-4">
    <h6 class="text-sm font-semibold text-gray-800 mb-3"><?= $sectionName ?></h6>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
      <?php foreach ($perms as $key => $info): ?>
      <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer hover:text-gray-800">
        <input type="checkbox" class="rounded border-gray-300 text-primary-600 focus:ring-primary-500" <?=array_key_exists($key, $permissions)?'checked':'';?> name="<?= $info[0] ?>">
        <?= $info[1] ?>
      </label>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endforeach; ?>
</div>

<?=modal_buttons()?>
<?=form_close();?>
<?=view('layouts/common/modal/modal_bottom'); ?>
<?php
$form_url = user_url($controller_name . "/store/" . $tab);
$form_attributes = array('class' => 'form actionForm row', 'data-redirect' => current_url(), 'method' => "POST");
$class_element = app_config('template')['form']['class_element'];
$class_element_select = app_config('template')['form']['class_element_select'];

$active = [
  'personal' => 'Personal',
  'agent' => 'Agent',
  // 'merchant' => 'Merchant'
];

$status = [
  '0' => 'Inactive',
  '1' => 'Active'
];

$general_elements = [
  [
    'label'      => form_label('Status'),
    'element'    => form_dropdown('status', $status, @$payment_settings->status, ['class' => $class_element_select]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],

];
include 'common.php';

?>

<div class="">
  <div class="px-4 py-3 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa-brands fa-square-reddit"></i> <?= lang("Tap Setup for-" . $brand->brand_name) ?></h3>
  </div>
  <div class="">
    <div class="">
      <?php echo form_open($form_url, $form_attributes); ?>
      <?php echo render_elements_form($general_elements); ?>
      <div id="personal<?= $brand->id ?>" class="type-class">
        <label>Tap Personal number</label>
        <input type="text" name="personal_number" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" value="<?= @get_value($payment_settings->params, 'personal_number') ?>" placeholder="Enter your Tap number">
      </div>
      <div id="agent<?= $brand->id ?>" class="type-class">
        <label>Tap Agent number</label>
        <input type="text" name="agent_number" value="<?= @get_value($payment_settings->params, 'agent_number') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" placeholder="Enter your agent number">
      </div>
      <div id="merchant<?= $brand->id ?>" class="type-class d-none">
        <label>Tap Merchant Payment URL</label>
        <input type="text" name="merchant_url" value="<?= @get_value($payment_settings->params, 'merchant_url') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" placeholder="Tap Payment URL">
      </div>
      <?= modal_buttons2('Save Tap Setting', ''); ?>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<?php
$form_url = '';
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => previous_url(), 'method' => "POST");
$form_hidden = ['type' => 'plan_edit', 'id' => @$item['id'], 'expire' => $item['expire']];
$class_element = app_config('template')['form']['class_element'];

$general_elements = [
  ['label' => form_label('Maximum device (* keep -1 for unlimited device) '), 'element' => form_input(['name' => 'device', 'value' => @$item['device'], 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
  ['label' => form_label('Brand'), 'element' => form_input(['name' => 'brand', 'value' => @$item['brand'], 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
  ['label' => form_label('Number of Expiry Day to be increased from ' . $item['expire'] . ' (NB: Use 0 when you do not need to increase)'), 'element' => form_input(['name' => 'duration', 'type' => 'number', 'class' => $class_element]), 'class_main' => "w-full"],
];
$data['modal_title'] = 'Edit User Plan';
?>
<?= view('layouts/common/modal/modal_top', $data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div>
  <?php echo render_elements_form($general_elements); ?>
</div>
<?= modal_buttons(); ?>
<?php echo form_close(); ?>
<?= view('layouts/common/modal/modal_bottom'); ?>

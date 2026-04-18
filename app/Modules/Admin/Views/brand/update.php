<?php
$form_url = '';
$redirect_url = previous_url();
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
$form_hidden = ['id' => @$item['id']];
$config_status = app_config('config')['status'];
$class_element = app_config('template')['form']['class_element'];
$class_element_select = app_config('template')['form']['class_element_select'];
$current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
$form_status = array_intersect_key(app_config('template')['status'], $current_config_status);
$form_status = array_combine(array_keys($form_status), array_column($form_status, 'name'));

$general_elements = [
  [
    'label'      => form_label('Domain Name'),
    'element'    => form_input(['name' => 'domain', 'value' => @$item['domain'], 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full",
  ],
  [
    'label'      => form_label('Domain IP'),
    'element'    => form_input(['name' => 'ip', 'value' => @$item['ip'], 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full",
  ],
  [
    'label'      => form_label('Status'),
    'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
];
$modal_title = !empty($item['id']) ? 'Edit Brand' : 'Add Brand';
$data['modal_title'] = $modal_title;
?>
<?= view('layouts/common/modal/modal_top', $data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div>
  <?php echo render_elements_form($general_elements); ?>
</div>
<?= modal_buttons(); ?>
<?php echo form_close(); ?>
<?= view('layouts/common/modal/modal_bottom', $data); ?>

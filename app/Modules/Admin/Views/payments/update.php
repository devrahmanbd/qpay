<?php
$form_url = admin_url($controller_name . "/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => admin_url($controller_name), 'method' => "POST");
$form_hidden = ['id' => @$item['id'], 'type' => @$item['type'], 'payment_params[type]' => @$item['type']];
$class_element_select = app_config('template')['form']['class_element_select'];
$class_element = app_config('template')['form']['class_element'];
$config_status = app_config('config')['status'];
$payment_params = json_decode(@$item['params']);
$payment_option = @$payment_params->option;

$current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
$form_status = array_intersect_key(app_config('template')['status'], $current_config_status);
$form_status = array_combine(array_keys($form_status), array_column($form_status, 'name'));

$general_elements = [
  ['label' => form_label('Method name'), 'element' => form_input(['name' => "payment_params[name]", 'value' => @$item['name'], 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
  ['label' => form_label('Method Type(Use one word)'), 'element' => form_input(['name' => "payment_params[type]", 'value' => @$item['type'], 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
  ['label' => form_label('Sort'), 'element' => form_input(['name' => 'sort', 'value' => @$item['sort'], 'type' => 'number', 'class' => $class_element]), 'class_main' => "w-full"],
  ['label' => form_label('Status'), 'element' => form_dropdown('payment_params[status]', $form_status, @$item['status'], ['class' => $class_element_select]), 'class_main' => "w-full"],
];
$modal_title = !empty($item['id']) ? 'Edit ' . ucfirst($item['type']) : 'Add A new Payment method';
$data['modal_title'] = $modal_title;
?>
<?= view('layouts/common/modal/modal_top', $data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700 mb-2">Gateway Logo</label>
    <div class="flex items-center gap-3">
        <input type="text" name="payment_params[option][logo]" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm" value="<?= isset($payment_option->logo) ? $payment_option->logo : '' ?>">
        <label for="img" class="cursor-pointer">
            <img src="<?= isset($payment_option->logo) ? base_url($payment_option->logo) : '' ?>" class="h-10 rounded" alt="Add an image">
        </label>
        <input id="img" class="settings_fileupload hidden" data-type="image" type="file" name="files[]">
    </div>
</div>
<div>
    <?php echo render_elements_form($general_elements); ?>
</div>
<?= modal_buttons2() ?>
<?php echo form_close(); ?>
<?= view('layouts/common/modal/modal_bottom', $data); ?>

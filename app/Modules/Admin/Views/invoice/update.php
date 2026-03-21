<?php
  $form_url = admin_url($controller_name."/store/");
  $redirect_url = admin_url($controller_name);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['id' => @$item['id']];
  $config_status = app_config('config')['status'];
  $class_element = app_config('template')['form']['class_element'];
  $class_element_editor = app_config('template')['form']['class_element_editor'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status);
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name'));

  if ($users) {
    $form_items = array_merge(['' => 'Select Users Email'],array_combine(array_column($users, 'email'), array_column($users, 'email')));
  }else{
    $form_items = ['' => 'No Users'];
  }

  $form_items2 = ['' => 'Select User First'];
  if (!empty($item['id'])) {
    $form_items2 = [@$item['domain']];
  }

  $general_elements = [
    [
      'label'      => form_label('Customer Name'),
      'element'    => form_input(['name' => 'customer_name', 'value' => @$item['customer_name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Customer Email'),
      'element'    => form_input(['name' => 'customer_email', 'value' => @$item['customer_email'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Customer Number'),
      'element'    => form_input(['name' => 'customer_number', 'value' => @$item['customer_number'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Customer Address'),
      'element'    => form_textarea(['name' => 'customer_address','rows'=>'3', 'value' => @$item['customer_address'], 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Description'),
      'element'    => form_textarea(['name' => 'customer_description','rows'=>'3', 'value' => @$item['customer_description'], 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Merchant Email'),
      'element'    => form_dropdown('user_id', $form_items, @$item['user_email'], ['class' => $class_element_select. ' merchant']),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Merchant Brand'),
      'element'    => form_dropdown('domain', $form_items2, @$item['domain'], ['class' => $class_element_select. ' brand']),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Amount'),
      'element'    => form_input(['name' => 'customer_amount', 'value' => @$item['customer_amount'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
  ];
  $modal_title = !empty($item['id']) ? 'Edit Invoice' : 'Add Invoice';
  $data['modal_title'] = $modal_title;
?>
<?= view('layouts/common/modal/modal_top', $data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div class="flex flex-wrap -mx-2 mb-4">
  <?php echo render_elements_form($general_elements); ?>
</div>
<?=modal_buttons();?>
<?php echo form_close(); ?>
<?= view('layouts/common/modal/modal_bottom'); ?>

<script>
document.querySelector('.merchant')?.addEventListener('change', function() {
  var user_id = this.value;
  fetch('<?=admin_url("invoice/get_brand")?>', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: 'token=' + encodeURIComponent(token) + '&user_id=' + encodeURIComponent(user_id)
  })
  .then(function(r) { return r.text(); })
  .then(function(data) { document.querySelector('.brand').innerHTML = data; });
});
</script>

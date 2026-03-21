<?php
  $form_url = admin_url($controller_name."/store");
  $redirect_url = previous_url();
  $user = fetch_user();
  $plan = fetch_plan();

  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['id' => @$item['id']];
  $config_status = app_config('config')['status'];
  $class_element = app_config('template')['form']['class_element'];
  $class_element_editor = app_config('template')['form']['class_element_editor'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status);
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name'));
  $form_user = array_combine(array_column($user, 'id'), array_column($user, 'email'));
  $form_plan = array_combine(array_column($plan, 'id'), array_column($plan, 'name'));
  $coupon_type = ['0' => 'Fixed', '1' => 'Percent'];

  $general_elements = [
    [
      'label'      => form_label('Code'),
      'element'    => form_input(['name' => 'code', 'value' => @$item['code'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full md:w-2/3 px-2",
    ],
    [
      'label'      => form_label(''),
      'element'    => '<button type="button" class="px-3 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 transition-colors" id="generate_coupon_code">Generate</button>',
      'class_main' => "w-full md:w-1/3 px-2",
    ],
    [
      'label'      => form_label('Limit'),
      'element'    => form_input(['name' => 'times', 'value' => @$item['times'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Price'),
      'element'    => form_input(['name' => 'price', 'value' => @$item['price'], 'type' => 'number', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Start Date'),
      'element'    => form_input(['name' => 'start_date', 'value' => @$item['start_date'], 'type' => 'date', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('End Date'),
      'element'    => form_input(['name' => 'end_date', 'value' => @$item['end_date'], 'type' => 'date', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Type'),
      'element'    => form_dropdown('type', $coupon_type, @$item['type'], ['class' => $class_element_select]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Coupon(User specific)'),
      'element'    => form_dropdown('coupon_user[]', $form_user, @get_value($item['param'],'coupon_user'), ['multiple'=>'multiple','class' => 'coupon_user '.$class_element_select]),
      'class_main' => "w-full px-2",
    ],
    [
      'label'      => form_label('Coupon(Plan specific)'),
      'element'    => form_dropdown('coupon_plan[]', $form_plan, @get_value($item['param'],'coupon_plan'), ['multiple'=>'multiple','class' => 'coupon_user '.$class_element_select]),
      'class_main' => "w-full px-2",
    ],
    [
      'label'      => form_label('Description'),
      'element'    => form_textarea(['name' => 'description', 'value' => @$item['description'], 'class' => $class_element_editor]),
      'class_main' => "w-full px-2",
    ],
  ];
  $modal_title = !empty($item['id']) ? 'Edit Coupon' : 'Add Coupon';
  $data['modal_title'] = $modal_title;
?>
<?=view('layouts/common/modal/modal_top',$data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div class="flex flex-wrap -mx-2 mb-4">
  <?php echo render_elements_form($general_elements); ?>
</div>
<?=modal_buttons();?>
<?php echo form_close(); ?>
<?=view('layouts/common/modal/modal_bottom'); ?>

<script>
document.getElementById('generate_coupon_code')?.addEventListener('click', function() {
    var chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    var code = '';
    for (var i = 0; i < 8; i++) { code += chars.charAt(Math.floor(Math.random() * chars.length)); }
    document.querySelector('input[name="code"]').value = code;
});
</script>

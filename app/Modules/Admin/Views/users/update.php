<?php
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];
  $config_status = app_config('config')['status'];
  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status);
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name'));
  $timezone_list = tz_list();
  $form_timezone = array_combine(array_column($timezone_list, 'zone'), array_column($timezone_list, 'time'));

  $elements = [
    [
      'label'      => form_label('First name'),
      'element'    => form_input(['name' => 'first_name', 'value' => @$item['first_name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Last name'),
      'element'    => form_input(['name' => 'last_name', 'value' => @$item['last_name'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Email'),
      'element'    => form_input(['name' => 'email', 'value' => @$item['email'], 'type' => 'email', 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Phone'),
      'element'    => form_input(['name' => 'phone', 'value' => @$item['phone'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full",
    ],
    [
      'label'      => form_label('Password'),
      'element'    => form_input(['name' => 'password', 'value' => @$item['password'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full",
      'type'       => 'password',
    ],
    [
      'label'      => form_label('Timezone'),
      'element'    => form_dropdown('timezone', $form_timezone, $item['timezone']??'Asia/Dhaka', ['class' => $class_element_select]),
      'class_main' => "w-full md:w-2/3 px-2",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "w-full md:w-1/3 px-2",
    ]
  ];

  if (!empty($item['ids'])) {
    $ids = $item['ids'];
    $modal_title = 'Edit (' . $item['email'] . ')';
    $elements = array_filter($elements, function($value) {
      if (isset($value['type'])) { return $value['type'] !== 'password'; }
      return $value;
    });
  } else {
    $ids = null;
    $modal_title = 'Add User';
  }

  $form_url = admin_url($controller_name."/store");
  $redirect_url = admin_url($controller_name);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['ids' => @$item['ids']];

  $data['modal_title'] = $modal_title;
?>
<?=view('layouts/common/modal/modal_top',$data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div class="flex flex-wrap -mx-2">
  <?php echo render_elements_form($elements); ?>
</div>
<?=modal_buttons()?>
<?php echo form_close(); ?>
<?=view('layouts/common/modal/modal_bottom'); ?>

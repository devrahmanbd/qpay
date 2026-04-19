<?php
  $class_element = app_config('template')['form']['class_element'];
  $class_element_editor = app_config('template')['form']['class_element_editor'];
  $elements = [
    ['label' => form_label('To'), 'element' => form_input(['name' => 'balance', 'value' => $item['email'], 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]), 'class_main' => "w-full"],
    ['label' => form_label('Subject'), 'element' => form_input(['name' => 'subject', 'value' => '', 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
    ['label' => form_label('Message'), 'element' => form_textarea(['name' => 'message','id'=>'ckeditor', 'value' => '', 'class' => $class_element_editor]), 'class_main' => "w-full"],
  ];
  if (!empty($item['ids'])) {
    $ids = $item['ids'];
    $modal_title = 'Send Mail (' . $item['email'] . ')';
  }
  $redirect_url = admin_url($controller_name) . '?' . http_build_query(['field' => 'email','query' => $item['email']]);
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['ids' => @$item['ids'], 'email_to' => @$item['email']];
  $data['modal_title'] = $modal_title;
?>
<?php echo view('layouts/common/modal/modal_top',$data); ?>
<?php echo form_open('', $form_attributes, $form_hidden); ?>
<div>
  <?php echo render_elements_form($elements); ?>
</div>
<?=modal_buttons()?>
<?php echo form_close(); ?>
<?php echo view('layouts/common/modal/modal_bottom'); ?>
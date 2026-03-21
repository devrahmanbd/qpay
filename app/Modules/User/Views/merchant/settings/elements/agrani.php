<?php
  $form_url = user_url($controller_name."/store/".$tab);
  $form_attributes = array('class' => 'form actionForm row', 'data-redirect' => current_url(), 'method' => "POST");
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];


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
    [
      'label'      => form_label('Agrani Bank Account Name'),
      'element'    => form_input(['name' => 'bank_account_name', 'value' =>  @get_value($payment_settings->params,'bank_account_name'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Agrani Bank Account Number'),
      'element'    => form_input(['name' => 'bank_account_number', 'value' =>  @get_value($payment_settings->params,'bank_account_number'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Agrani Bank Branch Name'),
      'element'    => form_input(['name' => 'bank_account_branch_name', 'value' =>  @get_value($payment_settings->params,'bank_account_branch_name'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Agrani Bank Routing Number'),
      'element'    => form_input(['name' => 'bank_account_routing_number', 'value' =>  @get_value($payment_settings->params,'bank_account_routing_number'), 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    
  ];
  include 'common.php';

?>

<div class="content">
  <div class="px-4 py-3 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa-brands fa-square-reddit"></i> <?=lang("Agrani Bank Setup for-".$brand->brand_name)?></h3>
  </div>
  <div class="">
    <div class="">
      <?php echo form_open($form_url, $form_attributes); ?>
        <?php echo render_elements_form($general_elements); ?>
        
        <?=modal_buttons2('Save Setting','');?>

      <?php echo form_close(); ?>
  </div>
</div>
</div>
<?php
$form_url = user_url($controller_name . "/store/" . $tab);
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
    'label'      => form_label('API URL(Leave as it is if don\'t need)'),
    'element'    => form_input(['name' => 'api_url', 'value' => @get_value($payment_settings->params, 'api_url') ?? 'https://bpay.binanceapi.com/binancepay/openapi/', 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('API KEY'),
    'element'    => form_input(['name' => 'api_key', 'value' =>  @get_value($payment_settings->params, 'api_key'), 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('Secret KEY'),
    'element'    => form_input(['name' => 'secret_key', 'value' =>  @get_value($payment_settings->params, 'secret_key'), 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('Dollar Rate'),
    'element'    => form_input(['name' => 'dollar_rate', 'value' =>  @get_value($payment_settings->params, 'dollar_rate'), 'required' => 'required', 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],


];
include 'common.php';
?>

<div class="">
  <div class="px-4 py-3 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa-brands fa-square-reddit"></i> <?= lang("Binance Setup") ?></h3>
  </div>
  <div class="">
    <div class="">
      <?php echo form_open($form_url, $form_attributes); ?>
      <?php echo render_elements_form($general_elements); ?>
      <input type="hidden" name="active_payments[personal]" value="1">

      <?= modal_buttons2('Save Setting', ''); ?>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>
<?php
$form_url = user_url($controller_name . "/store/" . $tab);
$form_attributes = array('class' => 'form actionForm row', 'data-redirect' => current_url(), 'method' => "POST");
$class_element = app_config('template')['form']['class_element'];
$class_element_select = app_config('template')['form']['class_element_select'];

$active = [
  'personal'        => 'Personal',
  'agent'           => 'Agent',
  'merchant'        => 'Merchant',
  'payment'  => 'Payment',
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
$sandbox = [
  '0' => 'No',
  '1' => 'Yes'
];

$logs = [
  '0' => 'No',
  '1' => 'Yes',
];

$m_elements = [
  [
    'label'      => form_label('Is Sandbox?'),
    'element'    => form_dropdown('sandbox', $sandbox, @get_value($payment_settings->params, 'sandbox'), ['class' => $class_element_select]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('Show Logs?'),
    'element'    => form_dropdown('logs', $logs, @get_value($payment_settings->params, 'logs'), ['class' => $class_element_select]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('Username'),
    'element'    => form_input(['name' => 'username', 'value' =>  @get_value($payment_settings->params, 'username'), 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('Password'),
    'element'    => form_input(['name' => 'password', 'value' =>  @get_value($payment_settings->params, 'password'), 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('APP KEY'),
    'element'    => form_input(['name' => 'app_key', 'value' =>  @get_value($payment_settings->params, 'app_key'), 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('APP SECRET KEY'),
    'element'    => form_input(['name' => 'app_secret', 'value' =>  @get_value($payment_settings->params, 'app_secret'), 'type' => 'text', 'class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],

];
include 'common.php';


?>

<div class="">
  <div class="px-4 py-3 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800"><i class="fa-brands fa-square-reddit"></i> <?= lang("Bkash Setup for-" . $brand->brand_name) ?></h3>
  </div>
  <div class="">
    <div class="">
      <?php echo form_open($form_url, $form_attributes); ?>
      <?php echo render_elements_form($general_elements); ?>
      <div id="personal<?= $brand->id ?>" class="type-class">
        <label>Bkash Personal number</label>
        <input type="text" name="personal_number" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" value="<?= @get_value($payment_settings->params, 'personal_number') ?>" placeholder="Enter your personal bkash number">
      </div>
      <div id="payment<?= $brand->id ?>" class="type-class">
        <label>Bkash Merchant Payment number</label>
        <input type="text" name="payment_number" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" value="<?= @get_value($payment_settings->params, 'payment_number') ?>" placeholder="Enter your Merchant Payment number">
      </div>


      <div id="agent<?= $brand->id ?>" class="type-class">
        <label>Bkash Agent number</label>
        <input type="text" name="agent_number" value="<?= @get_value($payment_settings->params, 'agent_number') ?>" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" placeholder="Enter your agent number">
      </div>
      <div id="merchant<?= $brand->id ?>" class="type-class">
        <div class="row bg-gray-50 rounded-lg p-3">
          <?php echo render_elements_form($m_elements); ?>
        </div>
      </div>


      <?= modal_buttons2('Save Bkash Setting', ''); ?>

      <?php echo form_close(); ?>
    </div>
  </div>
</div>
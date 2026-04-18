<?php
$redirect_url = user_url('plans');
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
$form_hidden = [
  'id'   => @$item->id,
];
$class_element = app_config('template')['form']['class_element'];
$class_element_editor = app_config('template')['form']['class_element_editor'];
$class_element_select = app_config('template')['form']['class_element_select'];

$general_elements = [
  [
    'label'      => form_label('Plan Name'),
    'element'    => form_input(['name' => 'name', 'value' => @$item->name, 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
    'class_main' => "w-full",
  ],
  [
    'label'      => form_label('Plan Price'),
    'element'    => form_input(['name' => 'price', 'value' => @$item->final_price, 'type' => 'text', 'readonly' => 'readonly', 'class' => $class_element]),
    'class_main' => "w-full",
  ],
];

$data['modal_title'] = 'Buy this Plan';
?>

<?= view('layouts/common/modal/modal_top', $data); ?>
<?php echo form_open('', $form_attributes, $form_hidden); ?>
<div class="mb-4" x-data="{ showCoupon: false }">
  <?php echo render_elements_form($general_elements); ?>

  <div x-show="showCoupon" x-cloak class="mt-3">
    <div class="flex items-center gap-2">
      <input type="text" name="coupon" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm coupon-code focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none" placeholder="Enter coupon code">
      <button class="px-3 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700 transition-colors" type="button" id="apply-coupon-btn">Apply</button>
    </div>
    <span id="coupon-result" class="text-xs text-red-500 mt-1 block"></span>
  </div>

  <button type="button" @click="showCoupon = !showCoupon" class="text-sm text-gray-500 mt-2">Have a coupon? <span class="text-primary-600 hover:text-primary-700">Click to enter your code</span></button>
</div>
<?= modal_buttons2('BUY NOW'); ?>
<?php echo form_close(); ?>
<?= view('layouts/common/modal/modal_bottom', $data); ?>

<script>
document.addEventListener('click', function(e) {
  if (e.target.id === 'apply-coupon-btn') {
    var coupon = document.querySelector('.coupon-code').value;
    var id = "<?= $item->id ?>";
    fetch('<?= user_url("buy-plan/apply_coupon"); ?>', {
      method: 'POST',
      headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
      body: 'token=' + encodeURIComponent(token) + '&coupon=' + encodeURIComponent(coupon) + '&id=' + id
    })
    .then(function(r) { return r.json(); })
    .then(function(response) {
      if (response.status === 'success') {
        document.getElementById('apply-coupon-btn').classList.add('hidden');
      }
      notify(response.message, response.status);
      document.getElementById('coupon-result').textContent = response.message;
    });
  }
});
</script>

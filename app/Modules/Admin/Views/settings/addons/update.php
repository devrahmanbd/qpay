<?php
  $form_url = admin_url("addons/store");
  $redirect_url = previous_url();
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = ['id' => @$item['id'], 'type' =>'edit'];
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  $status = ['' => 'Select one...', '1' => 'Active', '2' => 'Coming soon...', '0' => 'Deactive'];
  $general_elements = [
    ['label' => form_label('Addon name'), 'element' => form_input(['name' => 'name', 'value' => @$item['name'], 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
    ['label' => form_label('Price'), 'element' => form_input(['name' => 'price', 'value' => @$item['price'], 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full"],
    ['label' => form_label('Version'), 'element' => form_input(['name' => 'version', 'value' => @$item['version'], 'type' => 'text', 'class' => $class_element]), 'class_main' => "w-full md:w-1/2 px-2"],
    ['label' => form_label('Status'), 'element' => form_dropdown('status', $status, @$item['status'], ['class' => $class_element_select]), 'class_main' => "w-full md:w-1/2 px-2"],
  ];
  $data['modal_title'] = 'Edit Addon';
?>
<?=view('layouts/common/modal/modal_top',$data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div class="mb-4">
  <label class="block text-sm font-medium text-gray-700 mb-2">Addon Image</label>
  <div class="settings">
    <input type="text" name="image" class="hidden" value="<?=@$item['image']?>">
    <label for="img" class="cursor-pointer inline-block">
      <img src="<?=!empty($item['image'])?base_url($item['image']):'';?>" class="w-24 h-24 rounded-full object-cover border-2 border-gray-200" alt="Addon">
    </label>
    <input id="img" class="settings_fileupload hidden" data-type="image" type="file" name="files[]">
  </div>
</div>
<div class="flex flex-wrap -mx-2">
  <?php echo render_elements_form($general_elements); ?>
</div>
<?=modal_buttons();?>
<?php echo form_close(); ?>
<?=view('layouts/common/modal/modal_bottom',$data); ?>
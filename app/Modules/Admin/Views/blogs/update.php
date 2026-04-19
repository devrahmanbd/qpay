<?php
$ids = (!empty($item['id'])) ? $item['id'] : '';
$form_url = admin_url($controller_name . "/store");
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => admin_url($controller_name), 'method' => "POST");
$form_hidden = ['id' => @$item['id']];

$class_element = app_config('template')['form']['class_element'];
$class_element_editor = app_config('template')['form']['class_element_editor'];
$class_element_datepicker = app_config('template')['form']['class_element_datepicker'];
$config_status = app_config('config')['status'];

$current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
$form_status = array_intersect_key(app_config('template')['status'], $current_config_status);
$form_status = array_combine(array_keys($form_status), array_column($form_status, 'name'));

$elements = [
  [
    'label'      => form_label('Title'),
    'element'    => form_input(['name' => 'title', 'value' => @$item['title'], 'class' => $class_element]),
    'class_main' => "w-full",
  ],
  [
    'label'      => form_label('Start'),
    'element'    => form_input(['name' => 'start', 'value' => @$item['created_at'], 'type' => 'datetime-local', 'class' => $class_element_datepicker]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('Status'),
    'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element]),
    'class_main' => "w-full md:w-1/2 px-2",
  ],
  [
    'label'      => form_label('Description'),
    'element'    => form_textarea(['name' => 'description', 'value' => htmlspecialchars_decode(@$item['description'], ENT_QUOTES), 'class' => $class_element_editor]),
    'class_main' => "w-full",
  ],
];

$data['modal_title'] = '';
?>

<?= view('layouts/common/modal/modal_top', $data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div class="flex flex-wrap -mx-2">
    <div class="w-full px-2 mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Thumbnail Image</label>
        <div class="flex items-center gap-3">
            <input type="text" name="thumbnail" class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm" value="<?= @$item['thumbnail'] ?>">
            <label for="img" class="cursor-pointer">
                <img src="<?= isset($item['thumbnail']) ? base_url($item['thumbnail']) : '' ?>" class="h-10 rounded" alt="Add an image">
            </label>
            <input id="img" class="settings_fileupload hidden" data-type="image" type="file" name="files[]">
        </div>
    </div>
    <?php echo render_elements_form($elements); ?>
</div>
<?= modal_buttons2(); ?>
<?php echo form_close(); ?>
<?= view('layouts/common/modal/modal_bottom'); ?>
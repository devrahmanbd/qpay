<?php
  $form_url = user_url($controller_name."/store/");
  $redirect_url = user_url('settings/domain_whitelist');
  $form_attributes = array('class' => 'form actionForm', 'data-redirect' => $redirect_url, 'method' => "POST");
  $form_hidden = [
    'id'   => @$item['id'],
    'type'   => 'domain_whitelist',
  ];
  $config_status = app_config('config')['status'];
  $class_element = app_config('template')['form']['class_element'];
  $class_element_select = app_config('template')['form']['class_element_select'];

  $current_config_status = (in_array($controller_name, $config_status)) ? $config_status[$controller_name] : $config_status['default'];
  $form_status = array_intersect_key(app_config('template')['status'], $current_config_status);
  $form_status = array_combine(array_keys($form_status), array_column($form_status, 'name'));

  $general_elements = [
    [
      'label'      => form_label('Domain Name'),
      'element'    => form_input(['name' => 'domain', 'value' => @$item['domain'], 'type' => 'text', 'class' => $class_element]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
    [
      'label'      => form_label('Status'),
      'element'    => form_dropdown('status', $form_status, @$item['status'], ['class' => $class_element_select]),
      'class_main' => "w-full md:w-1/2 px-2",
    ],
  ];
    $modal_title = 'Add Domain';
    $fees_type = [
      '0'=>'Flat',
      '1'=>'Percent',
    ];

    $general_elements2 = [
      [
        'label'      => form_label('Brand Name'),
        'element'    => form_input(['name' => 'brand_name', 'value' => @$item['brand_name'], 'type' => 'text', 'class' => $class_element]),
        'class_main' => "w-full md:w-1/2 px-2",
      ],
      [
        'label'      => form_label('Mobile Number'),
        'element'    => form_input(['name' => 'mobile_number', 'value' => @$item['mobile_number'], 'type' => 'text', 'class' => $class_element]),
        'class_main' => "w-full md:w-1/2 px-2",
      ],
      [
        'label'      => form_label('WhatsApp Number'),
        'element'    => form_input(['name' => 'whatsapp_number', 'value' => @$item['whatsapp_number'], 'type' => 'text', 'class' => $class_element]),
        'class_main' => "w-full md:w-1/2 px-2",
      ],
      [
        'label'      => form_label('Support Mail'),
        'element'    => form_input(['name' => 'support_mail', 'value' => @$item['support_mail'], 'type' => 'email', 'class' => $class_element]),
        'class_main' => "w-full md:w-1/2 px-2",
      ],
      [
        'label'      => form_label('Fees type'),
        'element'    => form_dropdown('fees_type', $fees_type, @$item['fees_type'], ['class' => $class_element_select]),
        'class_main' => "w-full md:w-1/2 px-2",
      ],
      [
        'label'      => form_label('Fees amount'),
        'element'    => form_input(['name' => 'fees_amount', 'value' => @$item['fees_amount'], 'type' => 'number', 'class' => $class_element]),
        'class_main' => "w-full md:w-1/2 px-2",
      ],
    ];

  $general_elements = array_merge($general_elements,$general_elements2);

  $data['modal_title']=$modal_title;
?>
<?= view('layouts/common/modal/modal_top', $data); ?>
<?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
<div class="flex flex-wrap -mx-2">
    <?php echo render_elements_form($general_elements); ?>
    <div class="w-full px-2 mb-4">
        <label class="block text-sm font-medium text-gray-700 mb-2">Brand logo</label>
        <input type="hidden" name="brand_logo" value="<?=@$item['brand_logo']?>">
        <label for="img2" class="cursor-pointer inline-block">
            <div class="relative w-24 h-24 rounded-full overflow-hidden border-2 border-gray-200 hover:border-primary-400 transition-colors">
                <img src="<?=base_url(@$item['brand_logo'])?>" class="w-full h-full object-cover" alt="No Image">
                <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><circle cx="12" cy="13" r="3"/></svg>
                </div>
            </div>
        </label>
        <input id="img2" class="settings_fileupload hidden" type="file" name="files[]" multiple="">
    </div>
</div>
<?=modal_buttons();?>
<?php echo form_close(); ?>
<?= view('layouts/common/modal/modal_bottom'); ?>

<?php

  $brand_elements = [];
  $active_elements = [];
    $active_payments = [];
    if (!empty($payment_settings->id)) {
      $settings = json_decode($payment_settings->params);

      if (isset($settings->active_payments)) {
        $active_payments = (array)$settings->active_payments;
      }
    } 
      $brand_elements[] = [
        'label'      => '',
        'element'    => form_hidden(["brand_id" => $brand->id]),
        'class_main' => "w-full px-2",
      ];
    if (!empty($active)) {
      $brand_elements[] = [
        'label'      => 'Active Payment Type',
        'element'    => '',
        'class_main' => "w-full px-2",
      ];
      foreach ($active as $key => $act) {
        $active_value = (isset($active_payments[$key]) && $active_payments[$key]) ? 1 : 0;
        $active_check = ($active_value) ? TRUE : FALSE;
        $hidden_value = form_hidden(["active_payments[$key]" => 0]);

        $active_elements[] = [
          'label'      => $act,
          'element'    => $hidden_value . form_checkbox(['name' => "active_payments[$key]", 'value' => 1, 'checked' => $active_check, 'class' => 'custom-switch-input my','data-id'=>$key.$brand->id]),
          'class_main' => "w-1/4 px-2",
          'type'       => "switch",
        ];
      }
    }

  $general_elements = array_merge($general_elements, $brand_elements);
  $general_elements = array_merge($general_elements, $active_elements);

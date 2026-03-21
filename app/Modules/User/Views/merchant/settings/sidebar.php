<div class="flex flex-wrap gap-2 mb-4">
<?php
  $xhtml = '';
  $form_items_payment = [
    'other' => 'Payment Settings',
  ];
  $items_payment = array_combine(array_column($items_payment, 'type'), array_column($items_payment, 'name'));

    if (!empty($items_payment)) {
      foreach ($items_payment as $key => $item) {
        $link = user_url('user-settings/' . $key);
        $class_active = ($key == $tab ) ? 'bg-primary-600 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200';
        $xhtml .= sprintf(
          '<a href="%s" class="px-4 py-2 text-sm font-medium rounded-lg transition-colors %s">%s</a>', $link, $class_active, $item
        );
      }
    }
  echo $xhtml;
?>
</div>

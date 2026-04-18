<div class="flex items-center gap-2 p-1 bg-gray-100/50 rounded-xl w-fit overflow-x-auto no-scrollbar border border-gray-200/50">
<?php
  $xhtml = '';
  // Combine items into a cleaner list
  $combined_items = [];
  if (!empty($items_payment)) {
    foreach ($items_payment as $item) {
      $combined_items[$item->type] = $item->name;
    }
  }

  foreach ($combined_items as $key => $name) {
    if (empty($name)) continue;
    $link = user_url('user-settings/' . $key);
    $isActive = ($key == $tab);
    $activeClass = $isActive ? 'bg-white text-primary-600 shadow-sm ring-1 ring-black/5' : 'text-gray-500 hover:text-gray-700 hover:bg-gray-200/50';
    
    $xhtml .= sprintf(
      '<a href="%s" class="px-4 py-2 text-sm font-semibold rounded-lg transition-all duration-200 whitespace-nowrap %s">%s</a>', 
      $link, $activeClass, esc($name)
    );
  }
  echo $xhtml;
?>
</div>


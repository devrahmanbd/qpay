<?php if(!empty($items)){ ?>
<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">SL</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Email</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">IP</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Task</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Created</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php if (!empty($items)) {
          $i = $from;
          foreach ($items as $key => $item) {
            $i++;
            $created = show_item_datetime($item['created'], 'long');
        ?>
          <tr class="hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-center text-gray-500"><?=$i?></td>
            <td class="px-4 py-3">
              <div class="flex items-center gap-2">
                <img src="<?=get_avatar('','admin',$item['sid'])?>" class="w-6 h-6 rounded-full">
                <span class="text-gray-600"><?php echo $item['email']; ?></span>
              </div>
            </td>
            <td class="px-4 py-3 text-center"><?php echo $item['ip']; ?></td>
            <td class="px-4 py-3 text-center"><?php echo $item['task']; ?></td>
            <td class="px-4 py-3 text-center text-gray-500"><?php echo $created; ?></td>
          </tr>
        <?php }}?>
      </tbody>
    </table>
  </div>
</div>
<?php echo show_pagination($pagination); ?>
<?php }else{
  echo show_empty_item();
}?>

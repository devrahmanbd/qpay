<div class="flex items-center justify-between mb-4">
  <h1 class="text-xl font-semibold text-gray-800">Roles & Permission</h1>
  <a href="<?=admin_url('staffs/role_permision/add');?>" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors ajaxModal">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
    Add new
  </a>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">SL</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Name</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php if (!empty($items)) {
          $i = 0;
          foreach ($items as $key => $item) {
            $i++;
        ?>
          <tr class="tr_<?php echo esc($item->id); ?> hover:bg-gray-50 transition-colors">
            <td class="px-4 py-3 text-gray-500"><?php echo $i; ?></td>
            <td class="px-4 py-3 font-medium"><?php echo $item->name; ?></td>
            <td class="px-4 py-3">
              <div class="flex items-center gap-3">
                <a href="<?=admin_url('staffs/role_permision/update/'.$item->id);?>" class="ajaxModal text-primary-600 hover:text-primary-700 text-sm">
                  <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  Edit
                </a>
                <a href="<?=admin_url('staffs/role_permision/delete/'.$item->id);?>" class="ajaxDeleteItem text-red-600 hover:text-red-700 text-sm" data-confirm_ms="delete this item">
                  <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                  Delete
                </a>
              </div>
            </td>
          </tr>
        <?php }}?>
      </tbody>
    </table>
  </div>
</div>

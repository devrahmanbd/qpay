<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead class="bg-gray-50 border-b border-gray-200">
        <tr>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">#</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">User</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Plan Name</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Plan DES.</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Price</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Expiry Date</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Days Left</th>
          <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php if (!empty($items)) {
          $i = 0;
          foreach ($items as $item) {
            $i++;
        ?>
            <tr class="hover:bg-gray-50 transition-colors">
              <td class="px-4 py-3 text-gray-500"><?= $i ?></td>
              <td class="px-4 py-3"><?= $item['email'] ?></td>
              <td class="px-4 py-3"><?= $item['name'] ?></td>
              <td class="px-4 py-3">
                <p class="text-xs text-gray-500">Max Brands: <?= $item['brand'] ?></p>
                <p class="text-xs text-gray-500">Max Device: <?= $item['device'] == -1 ? '∞' : $item['device'] ?></p>
              </td>
              <td class="px-4 py-3"><?= $item['price'] ?><?= get_option('currency_symbol') ?></td>
              <td class="px-4 py-3 text-gray-500"><?= show_item_datetime($item['expire']); ?></td>
              <td class="px-4 py-3">
                <div class="countdown inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold transition-all">
                  <span class="q-loader-sm mr-1"></span> Loading...
                </div>
              </td>
              <td class="px-4 py-3">
                <a href="<?= admin_url('plans/edit_user_plan/' . $item['id']) ?>" class="ajaxModal text-primary-600 hover:text-primary-700 text-sm">
                  <svg class="w-4 h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                  Edit
                </a>
              </td>
            </tr>
        <?php }
        } ?>
      </tbody>
    </table>
  </div>
</div>

<script>
function updateCountdown(targetTime, el) {
    var diff = targetTime - new Date();
    if (diff <= 0) {
        el.textContent = "Expired";
        el.className = "countdown inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-red-100 text-red-700 border border-red-200";
        return;
    }
    var d = Math.floor(diff / 86400000), h = Math.floor((diff % 86400000) / 3600000);
    el.textContent = d + 'd ' + h + 'h left';
    
    if (d < 3) {
        el.className = "countdown inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-orange-100 text-orange-700 border border-orange-200";
    } else {
        el.className = "countdown inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-bold bg-green-100 text-green-700 border border-green-200";
    }
}
function updateAllCountdowns() {
    document.querySelectorAll('.countdown').forEach(function(el) {
        var dateCell = el.parentElement.parentElement.querySelector('td:nth-child(6)');
        if (dateCell) {
            var dateStr = dateCell.textContent.trim();
            updateCountdown(new Date(dateStr), el);
        }
    });
}
setInterval(updateAllCountdowns, 1000);
updateAllCountdowns();
</script>

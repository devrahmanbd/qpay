<div class="py-6">
  <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    <?php if (!empty($items)) :
      foreach ($items as $item) :
        $isActive = get_active_plan() && get_active_plan()->plan_id == $item['id'];
    ?>
        <div class="bg-white rounded-xl shadow-sm border-2 <?= $isActive ? 'border-green-500 ring-2 ring-green-100' : 'border-gray-200' ?> overflow-hidden">
          <div class="p-6">
            <h3 class="text-xl font-bold text-center text-gray-800 mb-1"><?= $item['name'] ?></h3>
            <p class="text-sm text-gray-500 text-center mb-4"><?= $item['description'] ?></p>
            <div class="text-center mb-6">
              <div class="flex items-start justify-center">
                <span class="text-sm text-gray-500 mt-2 mr-1"><?= get_option('currency_symbol') ?></span>
                <span class="text-4xl font-bold text-gray-900"><?= currency_format($item['final_price']) ?></span>
              </div>
              <span class="text-xs text-gray-400">/ <?= duration_type($item['name'], $item['duration_type'], $item['duration']) ?></span>
            </div>
            <ul class="space-y-3 mb-6">
              <li class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?= plan_message('brand', $item['brand']) ?>
              </li>
              <li class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?= plan_message('device', $item['device']) ?>
              </li>
              <li class="flex items-center gap-2 text-sm text-gray-600">
                <svg class="w-4 h-4 text-primary-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                <?= plan_message('transaction', $item['transaction']) ?>
              </li>
            </ul>
            <?= plan_button($item['id']); ?>
          </div>
        </div>
    <?php
      endforeach;
    endif;
    ?>
  </div>
</div>

<script>
function updateCountdown(targetTime, el) {
    const diff = targetTime - new Date();
    if (diff <= 0) { el.textContent = "Expired"; return; }
    const d = Math.floor(diff / 86400000);
    const h = Math.floor((diff % 86400000) / 3600000);
    const m = Math.floor((diff % 3600000) / 60000);
    const s = Math.floor((diff % 60000) / 1000);
    el.textContent = d + 'd ' + h + 'h ' + m + 'm ' + s + 's';
}
function updateCountdowns() {
    document.querySelectorAll('.countdown').forEach(function(el) {
        var t = el.parentElement.querySelector('.getExpire');
        if (t) updateCountdown(new Date(t.textContent), el);
    });
}
setInterval(updateCountdowns, 1000);
updateCountdowns();
</script>

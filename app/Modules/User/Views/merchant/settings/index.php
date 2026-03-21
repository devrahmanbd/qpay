<?php
use User\Models\Merchant;
$model = new Merchant();
?>
<div>
  <?php include "sidebar.php"; ?>

  <?php if(!empty($brands)): ?>
    <div x-data="{ activeTab: '<?= key($brands) ?>' }" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
      <div class="flex flex-wrap gap-1 p-3 border-b border-gray-100 bg-gray-50">
        <?php foreach($brands as $key => $brand): ?>
          <button type="button"
            @click="activeTab = '<?= $key ?>'"
            :class="activeTab === '<?= $key ?>' ? 'bg-primary-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-100'"
            class="px-4 py-2 text-sm font-medium rounded-lg transition-colors">
            <?= $brand->brand_name ?>
          </button>
        <?php endforeach; ?>
      </div>

      <div class="p-5">
        <?php foreach($brands as $key => $brand): ?>
          <div x-show="activeTab === '<?= $key ?>'" x-cloak>
            <?php
              $payment_settings = $model->get('*','user_payment_settings',['uid'=>session('uid'), 'g_type'=>$tab,'brand_id'=>$brand->id]);
              include "elements/$tab.php";
            ?>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  <?php else: ?>
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 text-center">
      <h4 class="text-lg font-medium text-gray-600">You need to Activate Brand First</h4>
    </div>
  <?php endif; ?>
</div>

<script>
document.querySelectorAll('.my').forEach(function(el) {
  el.addEventListener('change', function() {
    var dataId = this.dataset.id;
    var contentDiv = document.getElementById(dataId);
    if (contentDiv) {
      contentDiv.style.display = this.checked ? '' : 'none';
    }
  });
  el.dispatchEvent(new Event('change'));
});
</script>

<div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
  <div class="px-5 py-4 border-b border-gray-100">
    <h3 class="text-base font-semibold text-gray-800">Manage Addons</h3>
  </div>
  <div class="p-5">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <?php
      if (!empty($items)) {
       foreach($items as $item){
     ?>
          <div class="bg-gray-50 rounded-xl p-4 border border-gray-100">
            <img src="<?=base_url($item->image)?>" alt="" class="rounded-lg w-full h-32 object-cover mb-3">
            <div class="flex items-center justify-between mb-2">
              <strong class="text-sm text-gray-800"><?=$item->name?></strong>
              <span class="text-xs text-gray-400">v <?=$item->version?></span>
            </div>
            <div class="flex items-center justify-between">
              <span class="text-sm font-medium text-gray-700">Price: <?=currency_format($item->price)?></span>
              <div>
                <?php
                  if ($item->status !=1) {
                    echo "<span class='text-xs text-red-500'>Unavailable</span>";
                  }else{
                    $active = get_value(current_user()->addons,$item->unique_identifier);
                    if ($active==1) {?>
                      <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Activated</span>
                    <?php }else{?>
                      <?=form_open(user_url('addons/store'), 'class="form actionForm inline"');?>
                      <input type="hidden" name="id" value="<?=$item->unique_identifier;?>">
                      <button type="submit" class="px-3 py-1 bg-primary-600 text-white text-xs font-medium rounded-full hover:bg-primary-700 transition-colors">Activate</button>
                      <?= form_close();?>
                    <?php } }
                ?>
              </div>
            </div>
          </div>
    <?php
      }
      }else{
        echo show_empty_item();
      }
     ?>
    </div>
  </div>
</div>

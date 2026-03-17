<div class="flex flex-col lg:flex-row gap-6">
  <div class="lg:w-1/3">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
      <div class="flex flex-col items-center mb-6">
        <img class="w-24 h-24 rounded-full object-cover mb-3" src="<?=get_avatar('admin',$item->id);?>" alt="User avatar">
        <h4 class="text-lg font-semibold text-gray-800"><?=$item->first_name?></h4>
      </div>
      <h5 class="text-sm font-semibold text-gray-700 pb-2 border-b border-gray-200 mb-4">Details</h5>
      <ul class="space-y-3 text-sm">
        <li><span class="font-medium text-gray-600">Name:</span> <span class="text-gray-800"><?=$item->first_name.' '.$item->last_name;?></span></li>
        <li><span class="font-medium text-gray-600">Email:</span> <span class="text-gray-800"><?=$item->email?></span></li>
        <li><span class="font-medium text-gray-600">Status:</span> <?=show_item_status('','',$item->status)?></li>
        <li><span class="font-medium text-gray-600">Role:</span> <span class="text-gray-800"><?=$item->name??'Not Detected';?></span></li>
      </ul>
    </div>
  </div>

  <div class="lg:w-2/3">
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
      <div class="px-5 py-4 border-b border-gray-100">
        <?=form_open('',['class'=>"flex items-center gap-2"])?>
          <input type="date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" name="start_date" value="<?=post('start_date')??'';?>">
          <span class="text-sm text-gray-500">To</span>
          <input type="date" class="border border-gray-300 rounded-lg px-3 py-2 text-sm" name="end_date" value="<?=post('end_date')??'';?>">
          <input type="submit" class="px-4 py-2 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600 transition-colors cursor-pointer" value="Search">
        <?=form_close()?>
      </div>
      <div class="p-5">
        <div class="relative border-l-2 border-gray-200 ml-3 space-y-6">
          <?php foreach($items as $logs){ ?>
          <div class="relative pl-6">
            <div class="absolute -left-[9px] top-1.5 w-4 h-4 rounded-full bg-primary-500 border-2 border-white"></div>
            <div class="border border-gray-100 rounded-lg p-4">
              <div class="flex items-center justify-between mb-2">
                <h6 class="text-sm font-medium text-gray-800"><?=shorten_string($logs->activity)?></h6>
                <span class="text-xs text-gray-400"><?=show_item_datetime($logs->created_at,'short')?></span>
              </div>
              <div class="flex items-center justify-between text-sm text-gray-500">
                <div>
                  <span>User Activity:</span>
                  <span class="mx-2">&rarr;</span>
                  <span><?=$logs->activity;?></span>
                </div>
                <span class="text-xs text-gray-400"><?= date("h:i A", strtotime($logs->created_at)) ?></span>
              </div>
              <?=getAnchor($logs->activity);?>
            </div>
          </div>
          <?php } ?>
          <div class="absolute -left-[9px] bottom-0 w-4 h-4 rounded-full bg-green-500 border-2 border-white flex items-center justify-center">
            <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

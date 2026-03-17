<?php if(!empty($denied)){ ?>
<?=view('layouts/common/modal/modal_top'); ?>
    <div class="p-6 text-center">
      <svg class="mx-auto w-12 h-12 text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
      <h3 class="text-lg font-semibold text-red-600">Permission Denied!</h3>
    </div>
<?=view('layouts/common/modal/modal_bottom'); ?>
<?php exit;}?>

<div x-data="{ show: true }" x-show="show" x-transition class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
  <div class="bg-white rounded-xl shadow-xl max-w-sm w-full mx-4">
    <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
      <span></span>
      <button @click="show = false" class="text-gray-400 hover:text-gray-600">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    </div>
    <div class="p-6 text-center">
      <svg class="mx-auto w-12 h-12 text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
      <h3 class="text-lg font-semibold text-red-600">Permission Denied!</h3>
    </div>
    <div class="flex justify-end px-5 py-3 border-t border-gray-100">
      <button @click="show = false" class="px-4 py-2 bg-gray-200 text-gray-700 text-sm rounded-lg hover:bg-gray-300 transition-colors">Close</button>
    </div>
  </div>
</div>

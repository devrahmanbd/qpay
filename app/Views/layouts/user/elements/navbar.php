<nav class="bg-white border-b border-gray-200 fixed top-0 inset-x-0 z-40 h-16" x-data="{ notifOpen: false, profileOpen: false }">
   <div class="flex items-center justify-between h-full px-4 lg:px-6">
      <div class="flex items-center gap-3">
         <button @click="$dispatch('toggle-sidebar')" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg lg:hidden">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
         </button>
      </div>
      <div class="flex items-center gap-2">
         <button @click="if(document.fullscreenElement){document.exitFullscreen()}else{document.documentElement.requestFullscreen()}" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg hidden sm:block">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4"/></svg>
         </button>

         <div class="relative">
            <button @click="notifOpen = !notifOpen" @click.outside="notifOpen = false" class="p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg relative">
               <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
               <span class="total_notification absolute -top-0.5 -right-0.5 bg-red-500 text-white text-xs rounded-full w-4 h-4 flex items-center justify-center" data-url="<?= user_url('get_user_notifications') ?>" style="font-size:10px"></span>
            </button>
            <div x-show="notifOpen" x-cloak x-transition class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 overflow-hidden">
               <div class="px-4 py-3 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
                  <span class="text-sm font-semibold text-gray-700">Notifications</span>
                  <a href="#" class="text-xs text-primary-600 hover:text-primary-700">Mark All As Read</a>
               </div>
               <div class="notification_data max-h-64 overflow-y-auto p-2">
                  <p class="text-sm text-gray-500 text-center py-4">No notifications found</p>
               </div>
            </div>
         </div>

         <div class="relative">
            <button @click="profileOpen = !profileOpen" @click.outside="profileOpen = false" class="flex items-center gap-2 p-1.5 hover:bg-gray-100 rounded-lg">
               <img alt="avatar" src="<?= get_avatar('user') ?>" class="w-8 h-8 rounded-full object-cover">
            </button>
            <div x-show="profileOpen" x-cloak x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1">
               <div class="px-4 py-2 border-b border-gray-100">
                  <p class="text-sm font-medium text-gray-700">Hello <?= current_user('first_name'); ?></p>
               </div>
               <a href="<?= user_url('profile') ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  Profile
               </a>
               <a href="<?= user_url('affiliates') ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                  Affiliates
               </a>
               <div class="border-t border-gray-100 my-1"></div>
               <a href="<?= user_url('logout') ?>" class="flex items-center gap-2 px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                  Logout
               </a>
            </div>
         </div>
      </div>
   </div>
</nav>

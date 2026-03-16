<div x-data="{ sidebarOpen: true }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen" class="relative">
   <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak x-transition.opacity></div>
   <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 z-40 w-64 h-screen bg-sidebar-bg text-gray-300 transition-transform duration-200 lg:translate-x-0 lg:z-20 overflow-y-auto">
      <div class="flex items-center gap-3 px-5 h-16 border-b border-gray-700/50">
         <a href="<?= admin_url(); ?>" class="flex items-center gap-2">
            <img alt="logo" src="<?= get_logo() ?>" class="h-8">
         </a>
      </div>

      <nav class="px-3 py-4 space-y-1" x-data="{ openMenu: '' }">
         <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Main</p>

         <a href="<?= admin_url('dashboard') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors <?= segment(2) == 'dashboard' ? 'bg-sidebar-active text-white' : '' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            <span>Dashboard</span>
         </a>

         <div x-data="{ open: <?= in_array(segment(2), ['transactions', 'bank_transactions']) ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"/><path d="M16 21V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v16"/></svg>
                  <span>Transactions</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= admin_url('transactions') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Transactions</a>
               <a href="<?= admin_url('bank_transactions') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Bank Transactions</a>
            </div>
         </div>

         <div x-data="{ open: <?= segment(2) == 'users' || segment(2) == 'user-plan' ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                  <span>Users</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= admin_url('users') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Users</a>
               <a href="<?= admin_url('users/update') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white ajaxModal">Add user</a>
               <a href="<?= admin_url('user-plan') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">User Plans</a>
            </div>
         </div>

         <div x-data="{ open: <?= segment(2) == 'staffs' ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87"/><path d="M16 3.13a4 4 0 010 7.75"/></svg>
                  <span>Staffs</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= admin_url('staffs') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Staffs</a>
               <a href="<?= admin_url('staffs/update') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white ajaxModal">Add staff</a>
            </div>
         </div>

         <a href="<?= admin_url('devices') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors <?= segment(2) == 'devices' ? 'bg-sidebar-active text-white' : '' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
            <span>Devices</span>
         </a>

         <a href="<?= admin_url('brands') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors <?= segment(2) == 'brands' ? 'bg-sidebar-active text-white' : '' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
            <span>Brands</span>
         </a>

         <div x-data="{ open: <?= in_array(segment(2), ['settings', 'blogs', 'faqs', 'plans', 'coupon']) ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21.21 15.89A10 10 0 118 2.83"/><path d="M22 12A10 10 0 0012 2v10z"/></svg>
                  <span>Settings</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= admin_url('settings') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Settings</a>
               <a href="<?= admin_url('blogs') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Blogs</a>
               <a href="<?= admin_url('faqs') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Faqs</a>
               <a href="<?= admin_url('plans') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Plans</a>
               <a href="<?= admin_url('coupon') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Coupons</a>
            </div>
         </div>

         <p class="px-3 mt-6 mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Others</p>

         <a href="<?= admin_url('payments') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors <?= segment(2) == 'payments' ? 'bg-sidebar-active text-white' : '' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            <span>Payment Methods</span>
         </a>
         <a href="<?= admin_url('tickets') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors <?= segment(2) == 'tickets' ? 'bg-sidebar-active text-white' : '' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span>Tickets</span>
         </a>
         <a href="<?= admin_url('addons') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors <?= segment(2) == 'addons' ? 'bg-sidebar-active text-white' : '' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
            <span>Addons</span>
         </a>
         <a href="<?= admin_url('cache-clean') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"/></svg>
            <span>Cache Clean</span>
         </a>
         <a href="<?= base_url() ?>" target="_blank" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
            <span>Main Site</span>
         </a>
      </nav>
   </aside>
</div>

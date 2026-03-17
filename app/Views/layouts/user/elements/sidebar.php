<div x-data="{ sidebarOpen: true }" @toggle-sidebar.window="sidebarOpen = !sidebarOpen" class="relative">
   <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-30 lg:hidden" x-cloak x-transition.opacity></div>
   <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed top-0 left-0 z-40 w-64 h-screen bg-sidebar-bg text-gray-300 transition-transform duration-200 lg:translate-x-0 lg:z-20 overflow-y-auto">
      <div class="flex items-center gap-3 px-5 h-16 border-b border-gray-700/50">
         <a href="<?= user_url(); ?>" class="flex items-center gap-2">
            <img alt="logo" src="<?= get_logo() ?>" class="h-8">
         </a>
      </div>

      <div class="px-4 py-4 border-b border-gray-700/50">
         <div class="flex items-center gap-3">
            <img alt="avatar" src="<?= get_avatar('user') ?>" class="w-10 h-10 rounded-full">
            <div>
               <p class="text-sm font-medium text-white"><?= current_user('first_name') ?></p>
               <p class="text-xs text-gray-400">User</p>
            </div>
         </div>
      </div>

      <nav class="px-3 py-4 space-y-1" x-data="{ openMenu: '' }">
         <p class="px-3 mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Main</p>

         <a href="<?= user_url('dashboard') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors <?= segment(2) == 'dashboard' ? 'bg-sidebar-active text-white' : '' ?>">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
            <span>Dashboard</span>
         </a>

         <a href="<?= user_url('add_funds') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors ajaxModal">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            <span>Add Funds</span>
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
               <a href="<?= user_url('transactions') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white <?= segment(2) == 'transactions' && segment(3) == '' ? 'text-white' : '' ?>">Transactions</a>
               <a href="<?= user_url('bank_transactions') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white <?= segment(2) == 'bank_transactions' ? 'text-white' : '' ?>">Bank Transactions</a>
            </div>
         </div>

         <div x-data="{ open: <?= segment(2) == 'invoice' ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                  <span>Invoice</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= user_url('invoice') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Invoices</a>
               <a href="<?= user_url('invoice/update') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white ajaxModal">Add Invoice</a>
            </div>
         </div>

         <div x-data="{ open: <?= in_array(segment(2), ['stored-data']) ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>
                  <span>Data</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= user_url('stored-data') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Stored Data</a>
               <a href="<?= user_url('transactions/add-data') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white ajaxModal">Add Data</a>
            </div>
         </div>

         <div x-data="{ open: <?= in_array(segment(2), ['brands', 'devices', 'user-settings']) ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21.21 15.89A10 10 0 118 2.83"/><path d="M22 12A10 10 0 0012 2v10z"/></svg>
                  <span>Settings</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= user_url('brands') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Brands</a>
               <a href="<?= user_url('devices') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Devices</a>
               <a href="<?= user_url('user-settings/wallets') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white">Wallets</a>
            </div>
         </div>

         <div x-data="{ open: <?= segment(2) == 'api' ? 'true' : 'false' ?> }">
            <button @click="open = !open" class="flex items-center justify-between w-full px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
               <span class="flex items-center gap-3">
                  <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                  <span>API</span>
               </span>
               <svg :class="open ? 'rotate-90' : ''" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </button>
            <div x-show="open" x-cloak x-collapse class="ml-5 mt-1 space-y-1 border-l border-gray-700 pl-3">
               <a href="<?= user_url('api/keys') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white <?= segment(3) == 'keys' ? 'text-white' : '' ?>">API Keys</a>
               <a href="<?= user_url('api/webhooks') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white <?= segment(3) == 'webhooks' ? 'text-white' : '' ?>">Webhooks</a>
               <a href="<?= user_url('api/logs') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white <?= segment(3) == 'logs' ? 'text-white' : '' ?>">API Logs</a>
               <a href="<?= user_url('api/sdks') ?>" class="block px-3 py-1.5 text-sm rounded hover:bg-sidebar-hover hover:text-white <?= segment(3) == 'sdks' ? 'text-white' : '' ?>">SDKs & Plugins</a>
            </div>
         </div>

         <p class="px-3 mt-6 mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">Others</p>

         <a href="<?= user_url('affiliates') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="22" y1="2" x2="11" y2="13"/><polygon points="22 2 15 22 11 13 2 9 22 2"/></svg>
            <span>Affiliates</span>
         </a>
         <a href="<?= user_url('plans') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="20 12 20 22 4 22 4 12"/><rect x="2" y="7" width="20" height="5"/><line x1="12" y1="22" x2="12" y2="7"/><path d="M12 7H7.5a2.5 2.5 0 010-5C11 2 12 7 12 7z"/><path d="M12 7h4.5a2.5 2.5 0 000-5C13 2 12 7 12 7z"/></svg>
            <span>Plans</span>
         </a>
         <a href="<?= base_url('public/assets/downloads/nagorikpay.apk') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>
            <span>Android App</span>
         </a>
         <a href="<?= base_url() ?>" target="_blank" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 014 10 15.3 15.3 0 01-4 10 15.3 15.3 0 01-4-10 15.3 15.3 0 014-10z"/></svg>
            <span>Main Site</span>
         </a>
         <a href="<?= base_url('developers') ?>" class="flex items-center gap-3 px-3 py-2 text-sm rounded-lg hover:bg-sidebar-hover hover:text-white transition-colors mb-4">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            <span>Developer Tool</span>
         </a>
      </nav>
   </aside>
</div>

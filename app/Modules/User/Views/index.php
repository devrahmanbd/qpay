<section x-data="dashboard()" x-init="loadData(activePeriod)">
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-5 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-purple-100">Balance</p>
                    <p class="text-2xl font-bold mt-1"><?= currency_format(current_user('balance')); ?></p>
                    <p class="text-xs text-purple-200 mt-2">Deposit Your Income</p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-orange-400 to-orange-500 rounded-xl p-5 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-orange-100">Successful Transaction</p>
                    <p class="text-2xl font-bold mt-1" x-text="data.success_trx || '0'"></p>
                    <p class="text-xs text-orange-200 mt-2">Total: <span x-text="data.total_success_trx || '0'"></span></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-cyan-400 to-cyan-500 rounded-xl p-5 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-cyan-100">Pending Transaction</p>
                    <p class="text-2xl font-bold mt-1" x-text="data.pending_trx || '0'"></p>
                    <p class="text-xs text-cyan-200 mt-2">Total: <span x-text="data.total_pending_trx || '0'"></span></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>
        <div class="bg-gradient-to-br from-green-400 to-green-500 rounded-xl p-5 text-white shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-green-100">Payments</p>
                    <p class="text-2xl font-bold mt-1" x-text="data.earning || '0'"></p>
                    <p class="text-xs text-green-200 mt-2">Total: <span x-text="data.total_earning || '0'"></span></p>
                </div>
                <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
            <h3 class="text-base font-semibold text-gray-800">Transactions</h3>
            <div x-data="{ open: false }" class="relative">
                <button @click="open = !open" class="inline-flex items-center gap-1 px-3 py-1.5 text-sm bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    <span x-text="activePeriod.charAt(0).toUpperCase() + activePeriod.slice(1)"></span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="open" @click.outside="open = false" x-cloak x-transition class="absolute right-0 mt-1 w-36 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                    <p class="px-4 py-1.5 text-xs font-medium text-gray-500 uppercase">Select Period</p>
                    <template x-for="p in ['today','week','month','year']" :key="p">
                        <button @click="activePeriod = p; loadData(p); open = false" class="block w-full text-left px-4 py-1.5 text-sm hover:bg-gray-50" :class="activePeriod === p ? 'text-primary-600 font-medium' : 'text-gray-700'" x-text="p.charAt(0).toUpperCase() + p.slice(1)"></button>
                    </template>
                </div>
            </div>
        </div>
        <div class="p-5 max-h-96 overflow-y-auto" x-html="data.listItems || '<p class=\'text-sm text-gray-400 text-center py-8\'>No transactions yet</p>'">
        </div>
        <div class="flex items-center justify-center gap-6 px-5 py-3 border-t border-gray-100 text-sm text-gray-500">
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-primary-500"></span> Successful</span>
            <span class="flex items-center gap-2"><span class="w-3 h-3 rounded-full bg-red-500"></span> Pending</span>
        </div>
    </div>
</section>

<script>
function dashboard() {
    return {
        activePeriod: 'today',
        data: {},
        loadData(period) {
            fetch('<?= user_url("dashboard-data") ?>', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'token=' + encodeURIComponent(token) + '&period=' + period
            })
            .then(r => r.json())
            .then(d => { this.data = d; });
        }
    }
}
</script>

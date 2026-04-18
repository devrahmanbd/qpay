<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">API Logs</h1>
            <p class="text-sm text-gray-500 mt-1">Monitor your API request activity</p>
        </div>
        <div class="flex items-center gap-3">
            <select onchange="window.location.href='<?= user_url('api/logs') ?>?brand_id='+this.value" class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                <?php foreach ($brands as $brand) : ?>
                    <option value="<?= $brand->id ?>" <?= $brand->id == $selected_brand_id ? 'selected' : '' ?>><?= esc($brand->brand_name) ?></option>
                <?php endforeach; ?>
            </select>
            <button onclick="clearLogs()" class="inline-flex items-center gap-2 px-4 py-2 border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                Clear Logs
            </button>
        </div>
    </div>

    <script>
    async function clearLogs() {
        if (!confirm('Are you sure you want to clear all API logs for this brand? This action cannot be undone.')) return;
        
        const formData = new FormData();
        formData.append('brand_id', '<?= $selected_brand_id ?>');
        formData.append('token', token);
        
        try {
            const res = await fetch(toRelativeUrl('<?= user_url('api/clear-logs') ?>'), { 
                method: 'POST', 
                headers: { 'X-Requested-With': 'XMLHttpRequest', 'X-CSRF-TOKEN': token },
                body: formData 
            });
            const data = await res.json();
            if (data.status === 'success') {
                window.location.reload();
            } else {
                alert(data.message);
            }
        } catch (e) {
            alert('Failed to clear logs');
        }
    }
    </script>

    <?php if (!empty($stats)) : ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Total Requests (24h)</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?= number_format($stats['total_requests']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Errors (24h)</p>
            <p class="text-2xl font-bold text-red-600 mt-1"><?= number_format($stats['error_count']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Error Rate</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?= $stats['error_rate'] ?>%</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Avg Response</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?= $stats['avg_response_ms'] ?>ms</p>
        </div>
    </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <?php if (empty($logs)) : ?>
            <div class="p-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <p class="mt-4 text-gray-500">No API requests recorded yet</p>
                <p class="text-sm text-gray-400 mt-1">Requests will appear here once you start using the API</p>
            </div>
        <?php else : ?>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Method</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Endpoint</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Response</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Env</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">IP</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($logs as $log) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-3 text-sm text-gray-500 whitespace-nowrap"><?= date('M j, g:i:sa', strtotime($log->created_at)) ?></td>
                            <td class="px-6 py-3">
                                <span class="text-xs font-mono font-bold <?= $log->method === 'POST' ? 'text-green-600' : 'text-blue-600' ?>"><?= esc($log->method) ?></span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-700 font-mono"><?= esc($log->endpoint) ?></td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $log->status_code < 400 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>"><?= $log->status_code ?></span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-500"><?= $log->response_time_ms ?>ms</td>
                            <td class="px-6 py-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?= $log->environment === 'live' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' ?>"><?= $log->environment ?></span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-500 font-mono"><?= esc($log->ip_address) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</div>

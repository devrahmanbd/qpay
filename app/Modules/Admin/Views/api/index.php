<div class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">API Analytics</h1>
            <p class="text-sm text-gray-500 mt-1">Platform-wide API usage overview</p>
        </div>
        <div class="flex items-center gap-2">
            <?php
            $periods = ['1h' => '1 Hour', '24h' => '24 Hours', '7d' => '7 Days', '30d' => '30 Days'];
            foreach ($periods as $key => $label) : ?>
                <a href="<?= admin_url('api-analytics?period=' . $key) ?>"
                   class="px-3 py-1.5 text-sm rounded-lg border <?= $period === $key ? 'bg-primary-600 text-white border-primary-600' : 'border-gray-300 text-gray-600 hover:bg-gray-50' ?>">
                    <?= $label ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Total Requests</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?= number_format($stats['total_requests']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Errors</p>
            <p class="text-2xl font-bold text-red-600 mt-1"><?= number_format($stats['error_count']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Error Rate</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?= $stats['error_rate'] ?>%</p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Active API Keys</p>
            <p class="text-2xl font-bold text-gray-900 mt-1"><?= number_format($stats['active_api_keys']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Webhooks Delivered</p>
            <p class="text-2xl font-bold text-green-600 mt-1"><?= number_format($stats['webhooks_delivered']) ?></p>
        </div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
            <p class="text-sm font-medium text-gray-500">Webhooks Failed</p>
            <p class="text-2xl font-bold text-red-600 mt-1"><?= number_format($stats['webhooks_failed']) ?></p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Merchants by API Usage</h2>
            <?php if (empty($merchants)) : ?>
                <p class="text-sm text-gray-500 py-4 text-center">No API activity in this period</p>
            <?php else : ?>
                <div class="space-y-3">
                    <?php foreach ($merchants as $merchant) : ?>
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?= esc($merchant['name']) ?></p>
                                <p class="text-xs text-gray-500"><?= esc($merchant['email']) ?></p>
                            </div>
                            <span class="text-sm font-semibold text-gray-700"><?= number_format($merchant['requests']) ?> requests</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent API Requests</h2>
            <?php if (empty($recentLogs)) : ?>
                <p class="text-sm text-gray-500 py-4 text-center">No recent API requests</p>
            <?php else : ?>
                <div class="space-y-2 max-h-80 overflow-y-auto">
                    <?php foreach ($recentLogs as $log) : ?>
                        <div class="flex items-center justify-between py-1.5 text-sm">
                            <div class="flex items-center gap-2">
                                <span class="font-mono font-bold text-xs <?= $log->method === 'POST' ? 'text-green-600' : 'text-blue-600' ?>"><?= $log->method ?></span>
                                <span class="text-gray-700 font-mono text-xs"><?= esc($log->endpoint) ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs <?= $log->status_code < 400 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>"><?= $log->status_code ?></span>
                                <span class="text-xs text-gray-400"><?= $log->response_time_ms ?>ms</span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

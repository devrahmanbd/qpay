<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('webhookManager', () => ({
        showAddModal: false,
        showEventsModal: false,
        webhookSecret: null,
        webhookEvents: [],
        newWebhookUrl: '',
        newWebhookEvents: ['*'],
        selectedWebhookId: null,
        toast: {
            show: false,
            message: ''
        },
        showToast(msg) {
            this.toast.message = msg;
            this.toast.show = true;
            setTimeout(() => { this.toast.show = false; }, 3000);
        },

        async pingWebhook(id) {
            const formData = new FormData();
            formData.append('webhook_id', id);
            formData.append('token', token);
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/ping-webhook') ?>'), { 
                    method: 'POST', 
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData 
                });
                const data = await res.json();
                this.showToast(data.message);
            } catch (e) {
                this.showToast('Failed to send ping');
            }
        },

        async addWebhook() {
            const formData = new FormData();
            formData.append('brand_id', '<?= $selected_brand_id ?>');
            formData.append('url', this.newWebhookUrl);
            this.newWebhookEvents.forEach(e => formData.append('events[]', e));
            formData.append('token', token);
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/add-webhook') ?>'), { 
                    method: 'POST', 
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData 
                });
                const data = await res.json();
                if (data.status === 'success') {
                    this.showAddModal = false;
                    this.webhookSecret = data.data.secret;
                } else {
                    alert(data.message);
                }
            } catch (e) {
                alert('Failed to add webhook');
            }
        },
        async deleteWebhookAction(id) {
            if (!confirm('Delete this webhook endpoint?')) return;
            const formData = new FormData();
            formData.append('webhook_id', id);
            formData.append('token', token);
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/delete-webhook') ?>'), { 
                    method: 'POST', 
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData 
                });
                const data = await res.json();
                if (data.status === 'success') window.location.reload();
                else alert(data.message);
            } catch (e) {
                alert('Failed to delete webhook');
            }
        },
        async viewEvents(id) {
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/webhook-events') ?>') + '?webhook_id=' + id, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                });
                const data = await res.json();
                this.webhookEvents = data.data || [];
                this.selectedWebhookId = id;
                this.showEventsModal = true;
            } catch (e) {
                alert('Failed to load events');
            }
        },
        async clearWebhookEvents() {
            if (!confirm('Clear all delivery records for this endpoint?')) return;
            const formData = new FormData();
            formData.append('webhook_id', this.selectedWebhookId);
            formData.append('token', token);
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/clear-webhook-events') ?>'), { 
                    method: 'POST', 
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    body: formData 
                });
                const data = await res.json();
                if (data.status === 'success') {
                    this.webhookEvents = [];
                    this.showToast('Events cleared');
                } else {
                    alert(data.message);
                }
            } catch (e) {
                alert('Failed to clear events');
            }
        }
    }));
});
</script>

<div x-data="webhookManager" x-cloak class="space-y-6 relative">
    <!-- Toast Notification -->
    <div x-show="toast.show" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform translate-y-2"
         class="fixed bottom-8 right-8 z-[100] bg-gray-900 text-white px-4 py-3 rounded-xl shadow-2xl flex items-center gap-3 border border-white/10"
         style="display: none;">
        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
        <span class="text-sm font-medium" x-text="toast.message"></span>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Webhooks</h1>
            <p class="text-sm text-gray-500 mt-1">Receive real-time event notifications at your endpoint</p>
        </div>
        <div class="flex items-center gap-3">
            <select onchange="window.location.href='<?= user_url('api/webhooks') ?>?brand_id='+this.value" class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                <?php foreach ($brands as $brand) : ?>
                    <option value="<?= $brand->id ?>" <?= $brand->id == $selected_brand_id ? 'selected' : '' ?>><?= esc($brand->brand_name) ?></option>
                <?php endforeach; ?>
            </select>
            <button @click="showAddModal = true" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Endpoint
            </button>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-sm text-blue-700">
                <p>Webhooks let your server receive real-time notifications when events happen. Events are signed with HMAC-SHA256 using the <code>QPay-Signature</code> header.</p>
            </div>
        </div>
    </div>

    <?php if (empty($webhooks)) : ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            <p class="mt-4 text-gray-500">No webhook endpoints configured</p>
            <button @click="showAddModal = true" class="mt-4 px-4 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700">Add Your First Endpoint</button>
        </div>
    <?php else : ?>
        <div class="space-y-4">
            <?php foreach ($webhooks as $webhook) : ?>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium <?= $webhook->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                                    <?= $webhook->is_active ? 'Active' : 'Disabled' ?>
                                </span>
                                <code class="text-sm text-gray-700"><?= esc($webhook->url) ?></code>
                            </div>
                            <div class="mt-2 flex flex-wrap gap-1">
                                <?php
                                $events = json_decode($webhook->events, true) ?: ['*'];
                                foreach ($events as $evt) : ?>
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-600"><?= esc($evt) ?></span>
                                <?php endforeach; ?>
                            </div>
                            <p class="mt-2 text-xs text-gray-400">Created <?= date('M j, Y', strtotime($webhook->created_at)) ?></p>
                        </div>
                        <div class="flex gap-2 ml-4">
                            <button @click="pingWebhook(<?= $webhook->id ?>)" class="text-xs px-3 py-1.5 border border-primary-300 rounded-lg hover:bg-primary-50 text-primary-600 font-medium">Send Ping</button>
                            <button @click="viewEvents(<?= $webhook->id ?>)" class="text-xs px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-600">Events</button>
                            <button @click="deleteWebhookAction(<?= $webhook->id ?>)" class="text-xs px-3 py-1.5 border border-red-300 rounded-lg hover:bg-red-50 text-red-600">Delete</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <template x-if="showAddModal">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @click.self="showAddModal = false">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Add Webhook Endpoint</h3>
                <form @submit.prevent="addWebhook">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Endpoint URL</label>
                            <input type="url" x-model="newWebhookUrl" placeholder="https://your-site.com/webhook" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Events</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" value="*" x-model="newWebhookEvents" class="rounded border-gray-300 text-primary-600">
                                    <span class="text-sm">All events</span>
                                </label>
                                <?php foreach ($event_types as $evt) : ?>
                                    <label class="flex items-center gap-2">
                                        <input type="checkbox" value="<?= $evt ?>" x-model="newWebhookEvents" class="rounded border-gray-300 text-primary-600">
                                        <span class="text-sm"><?= $evt ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showAddModal = false" class="px-4 py-2 text-sm text-gray-600">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700">Add Endpoint</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-if="showEventsModal">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @click.self="showEventsModal = false">
            <div class="bg-white rounded-xl shadow-xl max-w-2xl w-full p-6 max-h-[80vh] overflow-y-auto">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold text-gray-900">Webhook Delivery Log</h3>
                    <template x-if="webhookEvents.length > 0">
                        <button @click="clearWebhookEvents" class="text-xs text-red-600 hover:text-red-700 font-medium px-2 py-1 rounded hover:bg-red-50 transition-colors">Clear History</button>
                    </template>
                </div>
                <template x-if="webhookEvents.length === 0">
                    <p class="text-sm text-gray-500 py-4 text-center">No events delivered yet</p>
                </template>
                <div class="space-y-3">
                    <template x-for="event in webhookEvents" :key="event.id">
                        <div class="border border-gray-200 rounded-lg p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium"
                                          :class="event.status === 'delivered' ? 'bg-green-100 text-green-700' : event.status === 'failed' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700'"
                                          x-text="event.status"></span>
                                    <span class="text-sm font-medium" x-text="event.event_type"></span>
                                </div>
                                <span class="text-xs text-gray-400" x-text="event.created_at"></span>
                            </div>
                            <div class="mt-2 text-xs text-gray-500">
                                <span>Attempts: <span x-text="event.attempts"></span></span>
                                <span class="ml-3" x-show="event.response_code">HTTP <span x-text="event.response_code"></span></span>
                            </div>
                        </div>
                    </template>
                </div>
                <div class="mt-4 flex justify-end">
                    <button @click="showEventsModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Close</button>
                </div>
            </div>
        </div>
    </template>

    <template x-if="webhookSecret">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <div class="flex items-center gap-2 text-green-600 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-lg font-semibold">Webhook Created</h3>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-yellow-700 font-medium">Copy your signing secret now. It will not be shown again.</p>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-500 mb-1">Signing Secret</label>
                    <div class="flex items-center gap-2">
                        <code class="flex-1 text-sm bg-gray-100 px-3 py-2 rounded-lg break-all" x-text="webhookSecret"></code>
                        <button @click="navigator.clipboard.writeText(webhookSecret)" class="p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                        </button>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button @click="webhookSecret = null; window.location.reload()" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700">Done</button>
                </div>
            </div>
        </div>
    </template>
</div>

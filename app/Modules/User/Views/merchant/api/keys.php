<div x-data="apiKeysManager()" class="space-y-6">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">API Keys</h1>
            <p class="text-sm text-gray-500 mt-1">Manage your publishable and secret API keys</p>
        </div>
        <div class="flex items-center gap-3">
            <select onchange="window.location.href='<?= user_url('api/keys') ?>?brand_id='+this.value" class="text-sm border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                <?php foreach ($brands as $brand) : ?>
                    <option value="<?= $brand->id ?>" <?= $brand->id == $selected_brand_id ? 'selected' : '' ?>><?= esc($brand->brand_name) ?></option>
                <?php endforeach; ?>
            </select>
            <button @click="showGenerateModal = true" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Generate Key Pair
            </button>
        </div>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex gap-3">
            <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <div class="text-sm text-blue-700">
                <p class="font-medium">Key Types</p>
                <p class="mt-1"><strong>Publishable keys</strong> (<code>pk_</code>) are safe for client-side code. <strong>Secret keys</strong> (<code>sk_</code>) must only be used server-side and never exposed publicly.</p>
                <p class="mt-1"><strong>Test keys</strong> process mock payments. <strong>Live keys</strong> process real payments.</p>
            </div>
        </div>
    </div>

    <?php if (empty($keys)) : ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-12 text-center">
            <svg class="w-12 h-12 mx-auto text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/></svg>
            <p class="mt-4 text-gray-500">No API keys generated yet</p>
            <button @click="showGenerateModal = true" class="mt-4 px-4 py-2 bg-primary-600 text-white text-sm rounded-lg hover:bg-primary-700">Generate Your First Key Pair</button>
        </div>
    <?php else : ?>
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Key</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Environment</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Used</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($keys as $key) : ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900"><?= esc($key->name) ?></td>
                            <td class="px-6 py-4">
                                <code class="text-sm bg-gray-100 px-2 py-1 rounded"><?= esc($key->key_prefix) ?>...<?= esc($key->key_last4) ?></code>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $key->key_type === 'secret' ? 'bg-red-100 text-red-700' : 'bg-green-100 text-green-700' ?>">
                                    <?= ucfirst($key->key_type) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?= $key->environment === 'live' ? 'bg-orange-100 text-orange-700' : 'bg-blue-100 text-blue-700' ?>">
                                    <?= ucfirst($key->environment) ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?= $key->last_used_at ? date('M j, g:ia', strtotime($key->last_used_at)) : 'Never' ?></td>
                            <td class="px-6 py-4 text-sm text-gray-500"><?= date('M j, Y', strtotime($key->created_at)) ?></td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex justify-end gap-2">
                                    <button @click="rotateKeyAction(<?= $key->id ?>)" class="text-xs px-3 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-50 text-gray-600">Rotate</button>
                                    <button @click="revokeKeyAction(<?= $key->id ?>)" class="text-xs px-3 py-1.5 border border-red-300 rounded-lg hover:bg-red-50 text-red-600">Revoke</button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <template x-if="showGenerateModal">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" @click.self="showGenerateModal = false">
            <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Generate API Key Pair</h3>
                <form @submit.prevent="generateKeys">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Key Name</label>
                            <input type="text" x-model="newKeyName" placeholder="e.g., Production, WordPress, Mobile App" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Environment</label>
                            <select x-model="newKeyEnv" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500">
                                <option value="test">Test (mock payments)</option>
                                <option value="live">Live (real payments)</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showGenerateModal = false" class="px-4 py-2 text-sm text-gray-600 hover:text-gray-800">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700">Generate</button>
                    </div>
                </form>
            </div>
        </div>
    </template>

    <template x-if="generatedKeys">
        <div class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50">
            <div class="bg-white rounded-xl shadow-xl max-w-lg w-full p-6">
                <div class="flex items-center gap-2 text-green-600 mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <h3 class="text-lg font-semibold">Keys Generated</h3>
                </div>
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mb-4">
                    <p class="text-sm text-yellow-700 font-medium">Copy these keys now. The secret key will not be shown again.</p>
                </div>
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Publishable Key</label>
                        <div class="flex items-center gap-2">
                            <code class="flex-1 text-sm bg-gray-100 px-3 py-2 rounded-lg break-all" x-text="generatedKeys.publishable_key"></code>
                            <button @click="copyToClipboard(generatedKeys.publishable_key)" class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 mb-1">Secret Key</label>
                        <div class="flex items-center gap-2">
                            <code class="flex-1 text-sm bg-gray-100 px-3 py-2 rounded-lg break-all" x-text="generatedKeys.secret_key"></code>
                            <button @click="copyToClipboard(generatedKeys.secret_key)" class="p-2 text-gray-400 hover:text-gray-600">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2" ry="2"/><path d="M5 15H4a2 2 0 01-2-2V4a2 2 0 012-2h9a2 2 0 012 2v1"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="mt-6 flex justify-end">
                    <button @click="generatedKeys = null; window.location.reload()" class="px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700">Done</button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function apiKeysManager() {
    return {
        showGenerateModal: false,
        generatedKeys: null,
        newKeyName: 'Default',
        newKeyEnv: 'test',
        async generateKeys() {
            const formData = new FormData();
            formData.append('brand_id', '<?= $selected_brand_id ?>');
            formData.append('environment', this.newKeyEnv);
            formData.append('name', this.newKeyName);
            formData.append(TOKEN, PATH);
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/generate-keys') ?>'), { method: 'POST', body: formData });
                const data = await res.json();
                if (data.status === 'success') {
                    this.showGenerateModal = false;
                    this.generatedKeys = data.data;
                } else {
                    alert(data.message);
                }
            } catch (e) {
                alert('Failed to generate keys');
            }
        },
        async revokeKeyAction(keyId) {
            if (!confirm('Are you sure you want to revoke this key? This action cannot be undone.')) return;
            const formData = new FormData();
            formData.append('key_id', keyId);
            formData.append(TOKEN, PATH);
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/revoke-key') ?>'), { method: 'POST', body: formData });
                const data = await res.json();
                alert(data.message);
                if (data.status === 'success') window.location.reload();
            } catch (e) {
                alert('Failed to revoke key');
            }
        },
        async rotateKeyAction(keyId) {
            if (!confirm('This will revoke the current key and generate a new one. Continue?')) return;
            const formData = new FormData();
            formData.append('key_id', keyId);
            formData.append(TOKEN, PATH);
            try {
                const res = await fetch(toRelativeUrl('<?= user_url('api/rotate-key') ?>'), { method: 'POST', body: formData });
                const data = await res.json();
                if (data.status === 'success') {
                    alert('New key: ' + data.data.new_key + '\n\nCopy this now!');
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            } catch (e) {
                alert('Failed to rotate key');
            }
        },
        copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(() => {
                alert('Copied to clipboard!');
            });
        }
    }
}
</script>

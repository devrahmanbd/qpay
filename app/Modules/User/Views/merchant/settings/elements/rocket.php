<?php
$form_url = user_url($controller_name . "/store/" . $tab);
$form_attributes = array('class' => 'form actionForm space-y-8', 'data-redirect' => current_url(), 'method' => "POST");

// Extract settings safely
$params = is_string($payment_settings->params) ? json_decode($payment_settings->params) : $payment_settings->params;
$active_payments = isset($params->active_payments) ? (array)$params->active_payments : [];

$account_types = [
    'personal' => ['name' => 'Personal', 'icon' => 'fa-user', 'desc' => 'Individual account'],
    'agent'    => ['name' => 'Agent', 'icon' => 'fa-store', 'desc' => 'Business agent'],
    'merchant' => ['name' => 'Merchant', 'icon' => 'fa-briefcase', 'desc' => 'Rocket Merchant Portal']
];
?>

<div class="animate-in fade-in duration-500">
    <form action="<?= $form_url ?>" class="form actionForm space-y-8" method="POST" data-redirect="<?= current_url() ?>">
        <?= csrf_field() ?>
        <input type="hidden" name="brand_id" value="<?= $brand->id ?>">

        <!-- Status & Mode Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Gateway Status -->
            <div class="bg-gray-50/50 border border-gray-100 p-4 rounded-xl">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Gateway Status</label>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700">Enable Rocket</span>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="hidden" name="status" value="0">
                        <input type="checkbox" name="status" value="1" <?= $payment_settings->status == 1 ? 'checked' : '' ?> class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary-600"></div>
                    </label>
                </div>
            </div>

            <!-- Generic Settings (Placeholder for more) -->
            <div class="bg-gray-50/50 border border-gray-100 p-4 rounded-xl opacity-50 cursor-not-allowed">
                <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Advanced</label>
                <div class="flex items-center justify-between">
                    <span class="text-sm font-medium text-gray-700 italic">No additional settings</span>
                </div>
            </div>
        </div>

        <!-- Account Types Selection -->
        <div x-data="{ activeType: '<?= !empty($active_payments) ? array_keys(array_filter($active_payments))[0] ?? 'personal' : 'personal' ?>' }">
            <label class="block text-xs font-semibold text-gray-400 uppercase tracking-wider mb-4">Select Account Type</label>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <?php foreach($account_types as $key => $type): ?>
                    <button type="button" 
                            @click="activeType = '<?= $key ?>'"
                            :class="activeType === '<?= $key ?>' ? 'border-primary-500 ring-1 ring-primary-500 bg-primary-50/30' : 'border-gray-200 bg-white hover:border-gray-300'"
                            class="relative p-4 border rounded-xl text-left transition-all duration-200 group">
                        <input type="hidden" name="active_payments[<?= $key ?>]" :value="activeType === '<?= $key ?>' ? 1 : 0">
                        <div :class="activeType === '<?= $key ?>' ? 'text-primary-600' : 'text-gray-400 group-hover:text-gray-500'" class="mb-2">
                            <i class="fas <?= $type['icon'] ?> text-xl"></i>
                        </div>
                        <div class="font-bold text-gray-900 text-sm"><?= $type['name'] ?></div>
                        <div class="text-xs text-gray-500 mt-1"><?= $type['desc'] ?></div>
                        
                        <div x-show="activeType === '<?= $key ?>'" class="absolute top-2 right-2 text-primary-600">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Dynamic Config Sections -->
            <div class="bg-white border border-gray-100 rounded-2xl p-6 lg:p-8 shadow-sm">
                <!-- Personal / Agent Number -->
                <div x-show="['personal', 'agent'].includes(activeType)" x-cloak class="space-y-6">
                    <div x-show="activeType === 'personal'">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rocket Personal Number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-phone-alt"></i>
                            </span>
                            <input type="text" name="personal_number" value="<?= @get_value($params, 'personal_number') ?>" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all" placeholder="01XXXXXXXXX">
                        </div>
                    </div>

                    <div x-show="activeType === 'agent'">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rocket Agent Number</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-store-alt"></i>
                            </span>
                            <input type="text" name="agent_number" value="<?= @get_value($params, 'agent_number') ?>" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all" placeholder="01XXXXXXXXX">
                        </div>
                    </div>
                </div>

                <!-- Merchant Credentials -->
                <div x-show="activeType === 'merchant'" x-cloak class="space-y-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Rocket Merchant Payment URL</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                                <i class="fas fa-link"></i>
                            </span>
                            <input type="text" name="merchant_url" value="<?= @get_value($params, 'merchant_url') ?>" class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-primary-500/20 focus:border-primary-500 outline-none transition-all" placeholder="https://payment.rocket.com/...">
                        </div>
                        <p class="text-xs text-gray-500 mt-2 italic">Note: Use this if you have a custom payment portal URL for Rocket.</p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 flex justify-end">
                    <button type="submit" class="px-8 py-3 bg-primary-600 text-white font-bold rounded-xl hover:bg-primary-700 shadow-lg shadow-primary-500/30 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0">
                        Save Rocket Configuration
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
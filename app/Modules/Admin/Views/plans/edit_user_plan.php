<?php
$form_url = admin_url('plans/edit_user_plan/' . @$item['id']);
$form_attributes = array('class' => 'form actionForm', 'data-redirect' => previous_url(), 'method' => "POST");
$form_hidden = ['type' => 'plan_edit', 'id' => @$item['id'], 'expire' => $item['expire']];
$class_element = "w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent transition-all outline-none";

$data['modal_title'] = 'Upgrade/Edit User Plan';
?>

<?= view('layouts/common/modal/modal_top', $data); ?>

<div class="space-y-6">
    <!-- User Info Card -->
    <div class="bg-primary-50 border border-primary-100 rounded-2xl p-4 flex items-center gap-4">
        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-primary-600 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
        </div>
        <div>
            <h4 class="text-sm font-semibold text-gray-900"><?= esc(@$item['email']) ?></h4>
            <p class="text-xs text-gray-500 mt-0.5">Subscription ID: #<?= esc(@$item['id']) ?></p>
        </div>
        <div class="ml-auto text-right">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-white text-primary-700 border border-primary-100">
                <?= esc(@$item['name']) ?>
            </span>
        </div>
    </div>

    <?php echo form_open($form_url, $form_attributes, $form_hidden); ?>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <!-- Devices Control -->
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-700 ml-1">Maximum Devices</label>
            <div class="relative">
                <?= form_input(['name' => 'device', 'value' => @$item['device'], 'type' => 'text', 'class' => $class_element, 'placeholder' => '-1 for unlimited']) ?>
                <div class="absolute right-3 top-2.5 text-xs text-gray-400 pointer-events-none">units</div>
            </div>
            <p class="text-[10px] text-gray-400 ml-1 italic">* Use -1 for unlimited devices</p>
        </div>

        <!-- Brands Control -->
        <div class="space-y-1.5">
            <label class="block text-sm font-medium text-gray-700 ml-1">Maximum Brands</label>
            <div class="relative">
                <?= form_input(['name' => 'brand', 'value' => @$item['brand'], 'type' => 'text', 'class' => $class_element]) ?>
                <div class="absolute right-3 top-2.5 text-xs text-gray-400 pointer-events-none">slots</div>
            </div>
        </div>

        <!-- Expiry Extension -->
        <div class="md:col-span-2 space-y-1.5">
            <label class="block text-sm font-medium text-gray-700 ml-1">Extend Period (Days)</label>
            <div class="flex items-center gap-3">
                <div class="relative flex-1">
                    <?= form_input(['name' => 'duration', 'type' => 'number', 'value' => 0, 'class' => $class_element]) ?>
                    <div class="absolute right-4 top-2.5 text-xs text-gray-500 font-semibold pointer-events-none">Days</div>
                </div>
                <div class="text-xs text-gray-500 min-w-[120px]">
                    Current Expiry:<br/>
                    <span class="font-semibold text-gray-800"><?= show_item_datetime(@$item['expire']) ?></span>
                </div>
            </div>
            <p class="text-[10px] text-gray-400 ml-1 mb-4 italic">NB: Set to 0 if no extension is needed.</p>
        </div>
    </div>

    <!-- Actions -->
    <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-gray-100">
        <button type="button" onclick="closeModal()" class="px-5 py-2.5 text-sm font-medium text-gray-600 hover:text-gray-800 transition-colors">
            Cancel
        </button>
        <button type="submit" class="px-8 py-2.5 bg-primary-600 text-white text-sm font-bold rounded-xl shadow-lg shadow-primary-200 hover:bg-primary-700 transition-all transform active:scale-95">
            Save Changes
        </button>
    </div>

    <?php echo form_close(); ?>
</div>

<?= view('layouts/common/modal/modal_bottom'); ?>
<?php
use User\Models\Merchant;
$model = new Merchant();
?>

<div class="space-y-6">
    <!-- Header Section -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-bold text-gray-900"><?= lang(ucfirst($tab) . " Settings") ?></h1>
            <p class="text-sm text-gray-500 mt-1">Configure your payment gateway details for each brand</p>
        </div>
    </div>

    <?php include "sidebar.php"; ?>

    <?php if(!empty($brands)): ?>
        <div x-data="{ activeBrandId: '<?= $brands[0]->id ?>' }" class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Brand Switcher -->
            <div class="flex items-center gap-2 p-4 bg-gray-50/50 border-b border-gray-100 overflow-x-auto no-scrollbar">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider mr-2 ml-1">Brands:</span>
                <?php foreach($brands as $brand): ?>
                    <button type="button"
                        @click="activeBrandId = '<?= $brand->id ?>'"
                        :class="activeBrandId == '<?= $brand->id ?>' ? 'bg-primary-600 text-white shadow-sm ring-1 ring-primary-500' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200'"
                        class="whitespace-nowrap px-4 py-2 text-sm font-medium rounded-full transition-all duration-200">
                        <?= esc($brand->brand_name) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <!-- Settings Forms -->
            <div class="p-6 lg:p-8">
                <?php foreach($brands as $brand): ?>
                    <div x-show="activeBrandId == '<?= $brand->id ?>'" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-2"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-cloak>
                        
                        <div class="max-w-3xl">
                            <?php
                                $payment_settings = $model->get('*','user_payment_settings',['uid'=>session('uid'), 'g_type'=>$tab,'brand_id'=>$brand->id]);
                                // Ensure $payment_settings is an object even if no record exists
                                if (!$payment_settings) {
                                    $payment_settings = (object)[
                                        'status' => 0,
                                        'params' => '{}'
                                    ];
                                }
                                include "elements/$tab.php";
                            ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h4 class="text-lg font-semibold text-gray-900">No Brands Active</h4>
            <p class="text-sm text-gray-500 mt-1">You need to setup a brand before configuring payment settings.</p>
            <a href="<?= user_url('brands') ?>" class="mt-6 inline-flex items-center px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-lg hover:bg-primary-700 transition-colors">Setup Brands</a>
        </div>
    <?php endif; ?>
</div>

<style>
.no-scrollbar::-webkit-scrollbar { display: none; }
.no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>


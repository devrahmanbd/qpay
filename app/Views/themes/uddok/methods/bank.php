<?php
switch ($setting['g_type']) {
    case 'abbank':
        $bg1 = "#43A047";
        $bg2 = "#43A047";
        break;
    case 'agrani':
        $bg1 = "#FF5733";
        $bg2 = "#FF5733";
        break;
    case 'citybank':
        $bg1 = "#33FF57";
        $bg2 = "#33FF57";
        break;
    case 'basia':
        $bg1 = "#3357FF";
        $bg2 = "#3357FF";
        break;
    case 'bbrac':
        $bg1 = "#F1C40F";
        $bg2 = "#F1C40F";
        break;
    case 'ific':
        $bg1 = "#9B59B6";
        $bg2 = "#9B59B6";
        break;
    case 'jamuna':
        $bg1 = "#E74C3C";
        $bg2 = "#E74C3C";
        break;
    case 'sonali':
        $bg1 = "#2ECC71";
        $bg2 = "#2ECC71";
        break;
    case 'dbbl':
        $bg1 = "#3498DB";
        $bg2 = "#3498DB";
        break;
    case 'ebl':
        $bg1 = "#E67E22";
        $bg2 = "#E67E22";
        break;
    case 'ibl':
        $bg1 = "#1ABC9C";
        $bg2 = "#1ABC9C";
        break;
    case 'basic':
        $bg1 = "#F39C12";
        $bg2 = "#F39C12";
        break;
    default:
        $bg1 = "#F39C12";
        $bg2 = "#F39C12";
        break;
}
?>
<style>
    :root {
        --bg1: <?= $bg1 ?>;
        --bg2: <?= $bg2 ?>;
    }
</style>
<style>
        
       .copy {
    color: white;
    }
    </style>
<div class="text-center">
    <h2 class="mb-3 font-semibold text-white font-bangla">পেমেন্ট স্লিপ আপলোড করুন।</h2>
    <input type="file" id="ajaxUpload" name="payment_slip" accept="image/png, image/jpg, image/jpeg" required="">
</div>
<div class="font-bangla mb-20">
    <ul class="mt-5 text-slate-200">
        <li class="flex text-sm">
            <div><span class="bank-info-span"></span></div>
            <div class="w-full flex justify-between">
                <p>একাউন্ট নামঃ <span class="text-yellow-300 font-semibold ml-1"><?= get_value($setting['params'], 'bank_account_name') ?></span></p>
                <a href="javascript:void(0)" class="px-2 py-0.5 mx-2 rounded-md bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'bank_account_name') ?>">&#x2398;Copy</a>
            </div>
        </li>
        <hr class="brand-hr my-3">
        <li class="flex text-sm">
            <div><span class="bank-info-span"></span></div>
            <div class="w-full flex justify-between">
                <p>একাউন্ট নম্বরঃ <span class="text-yellow-300 font-semibold ml-1"><?= get_value($setting['params'], 'bank_account_number') ?></span></p>
                <a href="javascript:void(0)" class="px-2 py-0.5 mx-2 rounded-md bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'bank_account_number') ?>">&#x2398;Copy</a>
            </div>
        </li>
        <hr class="brand-hr my-3">
        <li class="flex text-sm">
            <div><span class="bank-info-span"></span></div>
            <div class="w-full flex justify-between">
                <p>ব্রাঞ্চ নামঃ <span class="text-yellow-300 font-semibold ml-1"><?= get_value($setting['params'], 'bank_account_branch_name') ?></span></p>
                <a href="javascript:void(0)" class="px-2 py-0.5 mx-2 rounded-md bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'bank_account_branch_name') ?>">&#x2398;Copy</a>
            </div>
        </li>
        <hr class="brand-hr my-3">
        <li class="flex text-sm">
            <div><span class="bank-info-span"></span></div>
            <div class="w-full flex justify-between">
                <p>রাউটিং নম্বরঃ <span class="text-yellow-300 font-semibold ml-1"><?= get_value($setting['params'], 'bank_account_routing_number') ?></span></p>
                <a href="javascript:void(0)" class="px-2 py-0.5 mx-2 rounded-md bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'bank_account_routing_number') ?>">&#x2398;Copy</a>
            </div>
        </li>

        <hr class="brand-hr my-3">
        <li class="flex text-sm">
            <div class="mr-2">
                <svg width="15" viewBox="0 0 13 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M6.5 3.64V6.72M4.08 1H8.92L12 4.08V8.92L8.92 12H4.08L1 8.92V4.08L4.08 1Z" stroke="#FFED47" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    <circle cx="6.5" cy="8.5625" r="0.6875" fill="#FFED47"></circle>
                </svg>
            </div>
            <p>উপরের উল্লেখিত তথ্য অনুযায়ী আপনার ব্যাংক ট্রান্সফার সম্পন্ন করুন। তারপর আপলোড বক্সে ব্যাংক স্লিপ অথবা ট্রান্সফার স্ক্রিনশট আপলোড করুন এবং নিচের<span class="text-yellow-300 font-semibold ml-1">VERIFY</span> বাটনে ক্লিক করুন।</p>
        </li>
    </ul>
</div>
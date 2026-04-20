<style>
    :root {
        --bg1: #43A047;
        --bg2: #43A047;
    }
</style>
<div class="text-center">
    <h2 class="mb-3 font-semibold text-white font-bangla">পেমেন্ট স্লিপ আপলোড করুন।</h2>
    <input type="file" id="ajaxUpload" name="payment_slip" class="appearance-none w-full text-[15px] rounded-[10px] bg-[#fbfcff] shadow shadow-[#0057d0]/5 px-5 py-3.5 focus:outline-none focus:ring-1 focus:ring-[#0057d0]" accept="image/png, image/jpg, image/jpeg" required="">
</div>
<div class="font-bangla">
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
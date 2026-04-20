<style>
    :root {
        --bg1: #019789;
        --bg2: #019789
    }
</style>
<style>
        .text-yellow-300 {
            color: #FFD700;
        }
        .font-bangla {
       color: white;
       }
       .copy {
    color: white;
    }
    </style>
<?php

$acc_tp = decrypt($_GET['acc_tp']);
if ($acc_tp == 'personal') :
?>
    <div class="mb-20">
        <ul class="mt-5 text-slate-200">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">প্রথমে আপনার IPAY অ্যাপে প্রবেশ করুন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">
                    <span class="text-yellow-300 font-semibold ml-1">"Send Money"</span> -এ ক্লিক করুন।
                </p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="sm:w-[90%] font-bangla">প্রাপক নম্বর হিসেবে এই নম্বরটি লিখুনঃ <span class="text-yellow-300 font-semibold ml-1 "><?= get_value($setting['params'], 'personal_number') ?></span>
                    <a href="#" class="px-2 py-0.5 mx-2 rounded-md inline-block bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'personal_number') ?>">&#x2398;Copy</a>
                </p>
            </li>


            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">টাকার পরিমাণঃ <span class="text-yellow-300 font-semibold ml-1"> <?= currency_format($all_info['total_amount']) ?></span></p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">নিশ্চিত করতে এখন আপনার IPAY মোবাইল মেনু পিন লিখুন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">সবকিছু ঠিক থাকলে, আপনি IPAY থেকে একটি নিশ্চিতকরণ বার্তা পাবেন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">এখন উপরের বক্সে আপনার<span class="text-yellow-300 font-semibold ml-1">Transaction ID</span> দিন এবং নিচের<span class="text-yellow-300 font-semibold ml-1">VERIFY</span> বাটনে ক্লিক করুন।</p>
            </li>
        </ul>
    </div>

<?php endif; ?>
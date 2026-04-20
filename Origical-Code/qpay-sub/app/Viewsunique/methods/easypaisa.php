<style>
    :root {
        --bg1: #0054a6;
        --bg2: #0054a6;
    }
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
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>First, open your EasyPaisa app on your phone.</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Tap on <span class="text-yellow-300 font-semibold ml-1">"Send Money"</span>.</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Enter Receiver’s Number as <span class="text-yellow-300 font-semibold ml-1"><?= get_value($setting['params'], 'personal_number') ?></span>
                    <a href="#" class="px-2 py-0.5 mx-2 rounded-md inline-block bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'personal_number') ?>">Copy</a>
                </p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Amount: <span class="text-yellow-300 font-semibold ml-1"><?= currency_format($all_info['total_amount']) ?></span></p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Once everything is correct, you will receive a confirmation message from EasyPaisa.</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Now enter your <span class="text-yellow-300 font-semibold ml-1">Transaction ID</span> in the box above and click <span class="text-yellow-300 font-semibold ml-1">VERIFY</span> below.</p>
            </li>
        </ul>
    </div>
<?php elseif ($acc_tp == 'agent') : ?>
    <div class="mb-20">
        <ul class="mt-5 text-slate-200">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>First, open your EasyPaisa app on your phone.</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Tap on <span class="text-yellow-300 font-semibold ml-1">"Cash Out"</span>.</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Enter Receiver’s Number as <span class="text-yellow-300 font-semibold ml-1"><?= get_value($setting['params'], 'agent_number') ?></span>
                    <a href="#" class="px-2 py-0.5 mx-2 rounded-md inline-block bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'agent_number') ?>">Copy</a>
                </p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Amount: <span class="text-yellow-300 font-semibold ml-1"><?= currency_format($all_info['total_amount']) ?></span></p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Once everything is correct, you will receive a confirmation message from EasyPaisa.</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span></div>
                <p>Now enter your <span class="text-yellow-300 font-semibold ml-1">Transaction ID</span> in the box above and click <span class="text-yellow-300 font-semibold ml-1">VERIFY</span> below.</p>
            </li>
        </ul>
    </div>
<?php endif; ?>

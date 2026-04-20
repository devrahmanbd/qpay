<style>
    :root {
        --bg1: #cf2772;
        --bg2: #cf2772
    }
</style>
<?php

use App\Libraries\Bkashapi;

$acc_tp = decrypt($_GET['acc_tp']);
if ($acc_tp == 'personal') :
?>
    <div class="">
        <ul class="mt-5 text-slate-200">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">*247# ডায়াল করে আপনার BKASH মোবাইল মেনুতে যান অথবা BKASH অ্যাপে যান।</p>
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
                <p class="font-bangla">নিশ্চিত করতে এখন আপনার BKASH মোবাইল মেনু পিন লিখুন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">সবকিছু ঠিক থাকলে, আপনি BKASH থেকে একটি নিশ্চিতকরণ বার্তা পাবেন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">এখন উপরের বক্সে আপনার<span class="text-yellow-300 font-semibold ml-1">Transaction ID</span> দিন এবং নিচের<span class="text-yellow-300 font-semibold ml-1">VERIFY</span> বাটনে ক্লিক করুন।</p>
            </li>
        </ul>
    </div>
    
<?php elseif ($acc_tp == 'agent') : ?>
    <div class="">
        <ul class="mt-5 text-slate-200">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">*247# ডায়াল করে আপনার BKASH মোবাইল মেনুতে যান অথবা BKASH অ্যাপে যান।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">
                    <span class="text-yellow-300 font-semibold ml-1">"Cash Out"</span> -এ ক্লিক করুন।
                </p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="sm:w-[90%] font-bangla">উদ্দোক্তা নম্বর হিসেবে এই নম্বরটি লিখুনঃ <span class="text-yellow-300 font-semibold ml-1 "><?= get_value($setting['params'], 'agent_number') ?></span>
                    <a href="#" class="px-2 py-0.5 mx-2 rounded-md inline-block bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'agent_number') ?>">&#x2398;Copy</a>
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
                <p class="font-bangla">নিশ্চিত করতে এখন আপনার BKASH মোবাইল মেনু পিন লিখুন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">সবকিছু ঠিক থাকলে, আপনি BKASH থেকে একটি নিশ্চিতকরণ বার্তা পাবেন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">এখন উপরের বক্সে আপনার<span class="text-yellow-300 font-semibold ml-1">Transaction ID</span> দিন এবং নিচের<span class="text-yellow-300 font-semibold ml-1">VERIFY</span> বাটনে ক্লিক করুন।</p>
            </li>
        </ul>
    </div>
    <?php elseif ($acc_tp == 'payment') : ?>
    <div class="">
        <ul class="mt-5 text-slate-200">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">*247# ডায়াল করে আপনার BKASH মোবাইল মেনুতে যান অথবা BKASH অ্যাপে যান।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">
                    <span class="text-yellow-300 font-semibold ml-1">"Make Payment"</span> -এ ক্লিক করুন।
                </p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="sm:w-[90%] font-bangla">উদ্দোক্তা নম্বর হিসেবে এই নম্বরটি লিখুনঃ <span class="text-yellow-300 font-semibold ml-1 "><?= get_value($setting['params'], 'agent_number') ?></span>
                    <a href="#" class="px-2 py-0.5 mx-2 rounded-md inline-block bg-[#00000040] copy" data-clipboard-text="<?= get_value($setting['params'], 'agent_number') ?>">&#x2398;Copy</a>
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
                <p class="font-bangla">নিশ্চিত করতে এখন আপনার BKASH মোবাইল মেনু পিন লিখুন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">সবকিছু ঠিক থাকলে, আপনি BKASH থেকে একটি নিশ্চিতকরণ বার্তা পাবেন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">এখন উপরের বক্সে আপনার<span class="text-yellow-300 font-semibold ml-1">Transaction ID</span> দিন এবং নিচের<span class="text-yellow-300 font-semibold ml-1">VERIFY</span> বাটনে ক্লিক করুন।</p>
            </li>
        </ul>
    </div>
    
<?php
elseif ($acc_tp == 'merchant') : ?>

    <style>
        .brand-bg {
            background: unset;
        }

        .transaction,
        .payment_submit_done {
            display: none;
        }
    </style>
    <?php

    $config = array(
        'username' => get_value($setting['params'], 'username'),
        'password' => get_value($setting['params'], 'password'),
        'app_key' => get_value($setting['params'], 'app_key'),
        'app_secret' => get_value($setting['params'], 'app_secret'),
    );

    $sandbox = (bool) get_value($setting['params'], 'sandbox');
    $logs = (bool) get_value($setting['params'], 'logs');

    $url = (!$sandbox) ? 'https://tokenized.pay.bka.sh' : 'https://tokenized.sandbox.bka.sh';

    $bkash = new Bkashapi($config['username'], $config['password'], $config['app_key'], $config['app_secret'], $url);

    $callbackURL = base_url('callback/bkash/' . encrypt($all_info['tmp_ids']));

    if (isset($_GET['status'])) {
        if (isset($_GET['logs'])) {
    ?>
            <textarea rows="10" cols="40"><?= session("logs_data"); ?></textarea>
            <script type="text/javascript">
                showToast('Copy Following Content to your API Dashboard', 'success')
            </script>

        <?php
        } else {
        ?>
            <div class="payment_submit_btn w-full fixed rounded-t-2xl backdrop-blur-sm py-[18px] bottom-0 left-0 sm:static sm:rounded-[10px] sm:px-4 sm:py-3.5 text-center font-semibold text-white"><a href="<?= base_url('api/execute_payment/bkash/' . $all_info['tmp_ids'] . '?acc_tp=' . $_GET['acc_tp']); ?>">Try Again!</a> </div>

            <script type="text/javascript">
                showToast('Failed to complete Payment', '<?= $_GET['status'] ?>')
            </script>

        <?php }
    } else {
        $data = array(
            'mode' => '0011',
            'amount' => $all_info['total_amount'],
            'currency' => 'BDT',
            'intent' => 'sale',
            'payerReference' => $all_info['tmp_ids'],
            'merchantInvoiceNumber' => $all_info['tmp_ids'],
            'callbackURL' => $callbackURL
        );
        $request = $bkash->create_payment($data);
        if (!empty($request['status']) && $request['status'] == 'error') { ?>
            <div class="payment_submit_btn w-full fixed rounded-t-2xl backdrop-blur-sm py-[18px] bottom-0 left-0 sm:static sm:rounded-[10px] sm:px-4 sm:py-3.5 text-center font-semibold text-white"><a href="<?= base_url('api/execute_payment/bkash/' . $all_info['tmp_ids'] . '?acc_tp=' . $_GET['acc_tp']); ?>">Try Again!</a> </div>

            <script type="text/javascript">
                showToast(<?= json_encode($request['message']); ?>, "error")
            </script>
            <?php
        } elseif (!empty($request['status']) && $request['status'] == 'success') {
            if ($logs) { ?>
                <textarea rows="10" cols="40"><?= $request['message'] ?></textarea>
                <script type="text/javascript">
                    showToast('Copy Following Content to your API Dashboard', 'success')
                </script>

                <?php
                if (isset($request['payment_link'])) {
                ?>
                    <div class="payment_submit_btn w-full fixed rounded-t-2xl backdrop-blur-sm py-[18px] bottom-0 left-0 sm:static sm:rounded-[10px] sm:px-4 sm:py-3.5 text-center font-semibold text-white"><a href="<?= $request['payment_link']; ?>">Proceed to complete the Sandbox process</a> </div>

            <?php
                }
            } else {
                header("Location: " . $request['payment_link']);
                
            }
            ?>


<?php }
    }
endif; ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>Secure Payment - <?= get_option('site_name', 'Your Site') ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_SITE . get_option('site_icon', BASE_SITE . "assets/images/favicon.png") ?>">
    <?= link_asset('css/stylev2.css') ?>
    <?= link_asset('toast/toastr.min.css') ?>
    <?= script_asset('js/jquery.js') ?>
    <?= script_asset('toast/toastr.min.js') ?>
    <style>
        :root {
            --bg1: <?= $bg ?>;
        }
    </style>
</head>


<body>
    <div class="container">
        <div class="h-full relative">
            <div class="head">
                <div class="top-bar flex items-center justify-between">
                    <div class="logo flex items-center justify-center">
                        <a href="<?= BASE_SITE; ?>">
                            <img src="<?= get_logo() ?>" alt="<?= get_option('site_name') ?>" />
                        </a>
                    </div>
                </div>
                <div class="flex-row ">
                    <div class="col-3">
                        <div class="brand-logo flex items-center justify-center m-5">
                            <img src="<?= BASE_SITE . $business_logo ?>" alt="" id="company_logo" />
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="brand-info flex items-center justify-center m-2">
                            <h3><?= $business_name ?></h3>
                        </div>
                        <div class="flex items-center justify-center m-4">
                            <div class="brand-info">
                                <p>Transaction ID : <span class="bg2-t"><?= $temp_transaction_id; ?></span></p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>


            <div class="main">
                <div class="inner-2">
                    <div class="overflow-auto p-0.5 mt-6 w-full pb-7 sm:pb-0">
                        <div id="transactionsSection" class="up-tab tab-content active">
                            <div class="bg-white rounded-lg shadow-md shadow-[#0057d0]/5">
                                <div class="px-5 py-4 sm:py-0 text-center rounded-lg bg-[#e5efff] sm:bg-transparent text-[#0057d0] font-semibold">
                                    <h2 class="font-english">Transaction Details</h2>
                                </div>
                                <ul class="py-4 px-5 sm:mb-5">
                                    <li class="flex justify-between text-sm text-[#6D7F9A] sm:text-base font-semibold">
                                        <p class="font-english">Payment Type:</p>
                                        <p><?= ucwords($temp_method); ?></p>
                                    </li>
                                    <hr class="my-3 sm:my-1.5 border-[#6D7F9A]/10">
                                    <li class="flex justify-between text-sm text-[#6D7F9A]">
                                        <p class="font-english">Transaction ID:</p>
                                        <p><?= $temp_transaction_id; ?></p>
                                    </li>
                                    <hr class="my-3 sm:my-1.5 border-[#6D7F9A]/10">
                                    <li class="flex justify-between text-sm text-[#6D7F9A]">
                                        <p class="font-english">Amount:</p>
                                        <p><?= currency_format($temp_amount); ?></p>
                                    </li>
                                    <hr class="my-3 sm:my-1.5 border-[#6D7F9A]/10">
                                    <li class="flex justify-between text-sm text-[#6D7F9A]">
                                        <p class="font-semibold font-english">Status:</p>
                                        <p class="font-semibold text-[#0057d0]"><?= strtoupper($status); ?></p>
                                    </li>
                                    <hr class="my-3 sm:my-1.5 border-[#6D7F9A]/10">
                                    <li style="color: rgb(255, 174, 0);">
                                        Please, don't Close the browser!
                                    </li>
                                    <div class="mb-1" style="font-weight: 600; color:red">
                                        You will be redirected within
                                        <span id="redirect_countdown" style="font-weight: 600;">2</span>
                                        <span>seconds</span>.
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        showToast('<?= $message ?>', '<?= $status ?>');
        var timeleft = 1; // Countdown time in seconds
        var redirectUrl = "<?= $redirect_url; ?>"; // Set the redirect URL

        var downloadTimer = setInterval(function() {
            if (timeleft <= 0) {
                clearInterval(downloadTimer);
                window.location.replace(redirectUrl);
            } else {
                document.getElementById("redirect_countdown").innerHTML = timeleft;
            }
            timeleft -= 1;
        }, 1000);
    </script>

</body>


</html>
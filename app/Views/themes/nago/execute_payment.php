<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment - QPay</title>
    <link rel="shortcut icon" type="image/x-icon" href="/public/assets/images/favicon.png">
    <?= link_asset('css/stylev2.css') ?>
    <?= link_asset('toast/toastr.min.css') ?>
    <?= script_asset('js/jquery.js') ?>
    <?= script_asset('toast/toastr.min.js') ?>
</head>
<body>
    <div id="loader">
        <div class="loader"></div>
    </div>

    <div class="container">
        <div class="h-full relative">
            <div class="head">
                <div class="top-bar flex items-center justify-between">
                    <div class="brand-logo flex items-center justify-center m-5">
                    <img src="/<?= ltrim($all_info['brand_logo'] ?? '', '/') ?>" alt="" id="company_logo" />
                </div>
                    <button onclick="window.location.href='/api/execute/<?= $all_info['tmp_ids'] ?? '' ?>'">
                        <svg width="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.5 1C4.80558 1 1 4.80558 1 9.5C1 14.1944 4.80558 18 9.5 18C14.1944 18 18 14.1944 18 9.5C18 4.80558 14.1944 1 9.5 1Z" stroke="#6D7F9A" stroke-width="1.5"></path>
                            <path d="M10.7749 12.9L7.3749 9.50002L10.7749 6.10002" stroke="#94A9C7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
                <div class="brand-logo flex items-center justify-center m-5">
                    <img src="/<?= ltrim($all_info['brand_logo'] ?? '', '/') ?>" alt="" id="company_logo" />
                </div>
                <div class="card flex items-center justify-center m-5">
                    <div class="brand-logo m-5">
                        <img src="/<?= ltrim(payment_option($setting['g_type'] ?? ''), '/') ?>" alt="<?= $setting['g_type'] ?? '' ?>" />
                    </div>
                    <div class="brand-info">
                        <h2><?= $all_info['brand_name'] ?? 'Payment' ?></h2>
                        <p>Transaction ID : <span class="bg2-t"><?= $all_info['transaction_id'] ?? '' ?></span></p>
                    </div>
                </div>

            </div>
            <div class="main">
                <div class="inner">
                    <div class="transaction">
                        <h2 class="mb-4 text-center">ট্রান্সজেকশন আইডি দিন</h2>
                        <input type="text" class="mb-5" placeholder="ট্রান্সজেকশন আইডি দিন" id="transaction_id" autocomplete="off" autofocus />
                    </div>
                    <?php
                    $methodType = $setting['t_type'] ?? '';
                    $methodName = $setting['g_type'] ?? '';
                    if ($methodType == 'bank') {
                        $file = __DIR__ . '/methods/bank.php';
                        if (file_exists($file)) include $file;
                    } else if ($methodName != '') {
                        $file = __DIR__ . '/methods/' . $methodName . '.php';
                        if (file_exists($file)) include $file;
                    }
                    ?>
                </div>
            </div>
            <button class="w-full absolute bottom-0 btn btn-bottom" id="payment_submit_done" data-tmp_id="<?= $payment->ids ?? '' ?>" data-href="/api/save_payment/<?= $setting['g_type'] ?? '' ?>?acc_tp=<?= @$_GET['acc_tp'] ?>">VERIFY</button>
        </div>
    </div>

    <script>
        (function() {
            var token = '<?= csrf_hash() ?>';
            var tmp_id = '<?= $payment->ids ?? '' ?>';
            var t_type = '<?= $setting['t_type'] ?? '' ?>';
            var acc_tp = "<?= htmlspecialchars($_GET['acc_tp'] ?? '') ?>";

            $('#payment_submit_done').on("click", function(event) {
                event.preventDefault();
                var element = $(this);
                var url = element.attr("data-href");
                var transaction_id = $('#transaction_id').val();
                
                if (!transaction_id) {
                    alert('Please enter Transaction ID');
                    return;
                }

                var data = {
                    '<?= csrf_token() ?>': token,
                    'tmp_id': tmp_id,
                    'transaction_id': transaction_id,
                    't_type': t_type,
                    'acc_tp': acc_tp
                };

                element.prop("disabled", true);
                element.html('<p style="color:blue">🕥 Verifying...</p>');
                $("#loader").css("display", "flex");

                var retryCount = 0;
                var maxRetries = 12;

                function attemptVerify() {
                    $.post(url, data, function(_result) {
                        if (_result.status === 'pending' && retryCount < maxRetries) {
                            retryCount++;
                            element.html('<p style="color:yellow">⏳ Retrying (' + retryCount + '/' + maxRetries + ')...</p>');
                            setTimeout(attemptVerify, (_result.retry_after || 5) * 1000);
                        } else if (_result.status === 'success') {
                            if (_result.redirect) {
                                window.location.replace(_result.redirect);
                            }
                        } else {
                            alert(_result.message || 'Verification failed');
                            element.prop("disabled", false);
                            element.html('VERIFY');
                            $("#loader").css("display", "none");
                        }
                    }, 'json').fail(function() {
                        alert('Server connection failed. Please try again.');
                        element.prop("disabled", false);
                        element.html('VERIFY');
                        $("#loader").css("display", "none");
                    });
                }

                attemptVerify();
            });

            $(document).on("click", ".copy", function() {
                var vl = $(this).attr('data-clipboard-text');
                if (vl && navigator.clipboard) {
                    navigator.clipboard.writeText(vl).then(() => {
                        alert('Copied to clipboard');
                    });
                }
            });
        })();
    </script>
</body>
</html>
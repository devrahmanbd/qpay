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
                    <img src="<?= BASE_SITE . $all_info['brand_logo'] ?>" alt="" id="company_logo" />
                </div>
                    <button onclick="window.location.href='<?= base_url("api/execute/" . $all_info['tmp_ids']); ?>'">
                        <svg width="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.5 1C4.80558 1 1 4.80558 1 9.5C1 14.1944 4.80558 18 9.5 18C14.1944 18 18 14.1944 18 9.5C18 4.80558 14.1944 1 9.5 1Z" stroke="#6D7F9A" stroke-width="1.5"></path>
                            <path d="M10.7749 12.9L7.3749 9.50002L10.7749 6.10002" stroke="#94A9C7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        </svg>
                    </button>
                </div>
                <div class="brand-logo flex items-center justify-center m-5">
                    <img src="<?= BASE_SITE . $all_info['brand_logo'] ?>" alt="" id="company_logo" />
                </div>
                <div class="card flex items-center justify-center m-5">
                    <div class="brand-logo m-5">
                        <img src="<?= BASE_SITE . payment_option($setting['g_type']) ?>" alt="<?= $setting['g_type'] ?>" />
                    </div>
                    <div class="brand-info">
                        <h2><?= $all_info['brand_name'] ?></h2>
                        <p>Transaction ID : <span class="bg2-t"><?= $all_info['transaction_id'] ?></span></p>
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
                    if ($setting['t_type'] == 'bank') {
                        $file = __DIR__ . '/methods/bank.php';
                        include $file;
                    } else {
                        $file = __DIR__ . '/methods/' . $setting['g_type'] . '.php';
                        if (file_exists($file)) {
                            include $file;
                        }
                    }
                    ?>

                </div>
            </div>
            <button class="w-full absolute bottom-0 btn btn-bottom" id="payment_submit_done" data-tmp_id="<?= session('tmp_ids') ?>" data-href="<?= base_url('api/save_payment/' . $setting['g_type'] . '?acc_tp=' . @$_GET['acc_tp']) ?>">VERIFY</button>
        </div>
    </div>

    <script>
        var token = '<?= csrf_hash() ?>';
        $('#payment_submit_done').on("click", function(event) {
            event.preventDefault();
            var element = $(this),
                url = element.attr("data-href"),
                tmp_id = element.attr("data-tmp_id"),
                t_type = "<?= $setting['t_type'] ?>",
                transaction_id = $('#transaction_id').val(),
                acc_tp = "<?= $_GET['acc_tp'] ?? '' ?>",
                data = $.param({
                    token: token,
                    tmp_id: tmp_id,
                    transaction_id: transaction_id,
                    t_type: t_type,
                    acc_tp: acc_tp
                });

            element.prop("disabled", true);
            element.html('<p style="color:blue">🕥 Loading...</p>');
            $("#loader").css("display", "flex");
            setTimeout(function() {
                $.post(url, data, function(_result) {
                    showToast(_result.message, _result.status);
                    if (_result.redirect) {
                        setTimeout(function() {
                            window.location.replace(_result.redirect);
                        }, 1000);
                    }
                }, 'json').always(function() {
                    element.prop("disabled", false);
                    element.html('VERIFY');
                    $("#loader").css("display", "none");
                });
            }, 1000);
        });

        $(document).on("click", ".copy", function() {
            let vl = $(this).attr('data-clipboard-text'),
                params = {
                    'type': 'text',
                    'value': vl,
                };
            copyToClipBoard(params, 'toast')
        });
    </script>

    <?php if (!empty($setting['t_type']) && $setting['t_type'] == 'bank') { ?>
        <script type="text/javascript">
            $('.transaction').css('display', 'none');
            $(document).ready(function() {
                $(document).on('change', '#ajaxUpload', function() {
                    var property = document.getElementById('ajaxUpload').files[0];
                    var _that = $(this),
                        _action = "<?= base_url('api/upload_files'); ?>";

                    var form_data = new FormData();
                    form_data.append("files[]", property);
                    $.ajax({
                        url: _action,
                        method: 'POST',
                        dataType: 'JSON',
                        data: form_data,
                        contentType: false,
                        cache: false,
                        processData: false,
                        beforeSend: function() {
                            $("#loader").css("display", "flex");
                        },
                        success: function(response) {
                            $("#loader").css("display", "none");
                            if (response.status == 'success') {
                                $('#transaction_id').val(response.link);
                            }
                            showToast(response.message, response.status);
                        }
                    });
                });
            });
        </script>
    <?php } ?>
</body>

</html>
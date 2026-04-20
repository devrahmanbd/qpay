<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment-<?= get_option('site_name', 'Your Site') ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_SITE . get_option('site_icon', BASE_SITE . "assets/images/favicon.png") ?>">
    <?= link_asset('css/style4.css') ?>
    <?= link_asset('toast/toastr.min.css') ?>
    <?= script_asset('js/jquery.js') ?>
    <?= script_asset('toast/toastr.min.js') ?>
    <style>
        :root {
            --bg1: #ED2730;
            --bg2: #F7962A;
        }
    </style>

</head>

<body class="w-full min-h-screen sm:h-auto sm:p-12 sm:flex sm:items-center sm:justify-center">
    <div id="loader">
        <div class="loader">
        </div>
    </div>
    <div class="up-container max-w-md overflow-hidden mx-auto p-8 relative sm:bg-white sm:rounded-lg sm:shadow-lg sm:shadow-[#0057d0]/10 sm:min-w-[650px] sm:flex sm:flex-wrap">
        <div class="w-full h-12 shadow-md shadow-[#0057d0]/5 rounded-lg overflow-hidden flex justify-between items-center p-5 bg-white sm:bg-[#fbfcff]  sm:shadow-none sm:ring-1 sm:ring-[#0057d0]/10">
            <div class>
                <a href="<?= BASE_SITE; ?>">
                    <svg width="16" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M6 18V10H11V18" stroke="#94A9C7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                        <path d="M1 6.95L8.5 1L16 6.95V16.3C16 16.7509 15.8244 17.1833 15.5118 17.5021C15.1993 17.8209 14.7754 18 14.3333 18H2.66667C2.22464 18 1.80072 17.8209 1.48816 17.5021C1.17559 17.1833 1 16.7509 1 16.3V6.95Z" stroke="#6D7F9A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                </a>
            </div>
            <button onclick="window.location.href='<?= base_url("api/execute/" . $all_info['tmp_ids']); ?>'">
                <svg width="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M9.5 1C4.80558 1 1 4.80558 1 9.5C1 14.1944 4.80558 18 9.5 18C14.1944 18 18 14.1944 18 9.5C18 4.80558 14.1944 1 9.5 1Z" stroke="#6D7F9A" stroke-width="1.5"></path>
                    <path d="M10.7749 12.9L7.3749 9.50002L10.7749 6.10002" stroke="#94A9C7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
            </button>
        </div>

        <div class="w-full mb-8">
            <div class="flex flex-col sm:flex-row flex-wrap mt-5 sm:justify-between sm:items-center">

                <div class="bg-white shadow shadow-[#0057d0]/5 rounded-lg px-5 py-3 sm:h-[85px] flex items-center sm:w-[70%] sm:shadow-none sm:ring-1 sm:ring-[#0057d0]/10">
                    <div class="w-[55px] h-[55px] p-1.5 flex justify-center items-center mr-4 ring-1 ring-[#0057d0]/10 rounded-full">
                        <img src="<?= BASE_SITE . $all_info['brand_logo'] ?>" alt="<?= $all_info['brand_name']  ?>" class="w-[80%]">
                    </div>
                    <div class="flex flex-col">
                        <h3 class="font-semibold text-[#6D7F9A] text-sm"><?= $all_info['brand_name'] ?></h3>
                        <span class="text-[#94a9c7] text-xs">Invoice ID :<span class="text-[#6D7F9A] text-xs"> <?= $all_info['transaction_id'] ?></span></span>
                    </div>
                </div>
                <div class="shadow shadow-[#0057d0]/5 rounded-lg py-3 px-2 sm:h-[85px] flex flex-col sm:items-center sm:justify-center sm:shadow-none sm:ring-1 sm:ring-[#0057d0]/10 mt-3 sm:w-[25%] sm:mt-0">

                    <div class="w-full h-20 mb-4 sm:mt-0 flex justify-center items-center">
                        <img src="<?= BASE_SITE . payment_option($setting['g_type']) ?>" alt="<?= $setting['g_type'] ?>" class="h-[80%]">
                    </div>
                </div>
            </div>


            <div class="method">
                <!-- Transaction Id -->
                <div class="brand-bg p-5 mt-3 rounded-lg overflow-auto">
                    <div class="text-center transaction mt-3">
                        <h2 class="mb-3 font-semibold text-white font-bangla">ট্রান্সজেকশন আইডি দিন</h2>
                        <input type="text" id="transaction_id" name="transaction_id" placeholder="ট্রান্সজেকশন আইডি দিন" class="font-bangla appearance-none w-full text-[15px] rounded-[10px] sm:bg-[#fbfcff] shadow shadow-[#0057d0]/5 px-5 py-3.5 placeholder-[#94A9C7] focus:outline-none focus:ring-1 focus:ring-[#0057d0]" maxlength="14" required="" autocomplete="off" autofocus>
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
        </div>

        <div class="w-full fixed rounded-t-2xl backdrop-blur-sm py-[18px] bottom-0 left-0 sm:static sm:rounded-[10px] sm:px-4 sm:py-3.5 text-center payment_submit_done payment_submit_btn font-semibold text-white" data-tmp_id="<?= session('tmp_ids') ?>" data-href=" <?= base_url('api/save_payment/' . $setting['g_type'] . '?acc_tp=' . @$_GET['acc_tp']) ?>"> VERIFY </div>

    </div>

    <script>
        var token = '<?= csrf_hash() ?>';
        $('.payment_submit_done').on("click", function(event) {
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
                    element.html('CONFIRM');
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
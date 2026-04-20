<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment-<?= get_option('site_name', 'Your Site') ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_SITE . get_option('site_icon', BASE_SITE . "assets/images/favicon.png") ?>">
        <?= link_asset('css/stylev2.css') ?>

</head>
<body>
    <div class="container">
        <div class="h-full relative">
            <div class="head">
                <div class="top-bar flex items-center justify-between">
                    <div class="brand-logo flex items-center justify-center m-5">
                    <img src="<?= BASE_SITE . $all_info['brand_logo'] ?>" alt="" id="company_logo" />
                </div>
                    <button class="cancel_btn flex items-center justify-center"" data-url=" <?= base_url('api/checkout/undetected/' . $all_info['tmp_ids'] . '/' . encodeParams('0')) ?>">&#x2716;</button>
                </div>
                <div class="brand-logo flex items-center justify-center m-5">
                    <img src="<?= BASE_SITE . $all_info['brand_logo'] ?>" alt="" id="company_logo" />
                </div>
                <div class="brand-info flex items-center justify-center m-2">
                    <h3><?= $all_info['brand_name'] ?></h3>
                </div>
                <div class="flex items-center justify-center m-4">
                    <div class="brand-support mbtn  btn mr-5" data-target="brand-support">
                        <div class="flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: #ff0049;transform: ;msFilter:;">
                                <path d="M12 2C6.486 2 2 6.486 2 12v4.143C2 17.167 2.897 18 4 18h1a1 1 0 0 0 1-1v-5.143a1 1 0 0 0-1-1h-.908C4.648 6.987 7.978 4 12 4s7.352 2.987 7.908 6.857H19a1 1 0 0 0-1 1V18c0 1.103-.897 2-2 2h-2v-1h-4v3h6c2.206 0 4-1.794 4-4 1.103 0 2-.833 2-1.857V12c0-5.514-4.486-10-10-10z"></path>
                            </svg>
                            <span>Support</span>
                        </div>
                    </div>
                    <div class="brand-details mbtn btn  ml-5" data-target="brand-details">
                        <div class="flex items-center justify-center">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill:#ff0049;transform: ;msFilter:;">
                                <path d="M12 6a3.939 3.939 0 0 0-3.934 3.934h2C10.066 8.867 10.934 8 12 8s1.934.867 1.934 1.934c0 .598-.481 1.032-1.216 1.626a9.208 9.208 0 0 0-.691.599c-.998.997-1.027 2.056-1.027 2.174V15h2l-.001-.633c.001-.016.033-.386.441-.793.15-.15.339-.3.535-.458.779-.631 1.958-1.584 1.958-3.182A3.937 3.937 0 0 0 12 6zm-1 10h2v2h-2z"></path>
                                <path d="M12 2C6.486 2 2 6.486 2 12s4.486 10 10 10 10-4.486 10-10S17.514 2 12 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8z"></path>
                            </svg>
                            <span>Details</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="m-4 relative">
                <div class="absolute top-0 left-0 right-0 z-100">
                    <div class="menu flex w-full items-center justify-center mt-4 mb-4">
                        <?php if (!empty($mobile_s)) { ?>
                            <div class="mbtn menu-mbtn" data-target="mobile_banking">
                                Mobile Banking
                            </div>
                        <?php }
                        if (!empty($bank_s)) { ?>
                            <div class="mbtn menu-mbtn" data-target="banking_tab">
                                Bank Transfer
                            </div>
                        <?php }
                        if (!empty($int_b_s)) { ?>
                            <div class="mbtn menu-mbtn" data-target="international_banking">
                                Others
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>

            <div class="main">
                <div class="inner-2">
                    <!-- tab_content -->
                    <?php if (!empty($mobile_s)) { ?>
                        <div class="tab-content" id="mobile_banking">
                            <div class="methods">

                                <?php foreach ($mobile_s as $mb) : ?>
                                    <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' ">
                                        <img src="<?= BASE_SITE . payment_option($mb->g_type) ?>" alt="<?= $mb->g_type ?>" />
                                        <small class="ribbon"><?= strtoupper($mb->active_payment) ?></small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php }
                    if (!empty($bank_s)) { ?>

                        <div class="tab-content" id="banking_tab">
                            <div class="methods">
                                <?php foreach ($bank_s as $mb) : ?>
                                    <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids']); ?>' ">
                                        <img src="<?= BASE_SITE . payment_option($mb->g_type) ?>" alt="<?= $mb->g_type ?>" />
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php }
                    if (!empty($int_b_s)) { ?>

                        <div class="tab-content" id="international_banking">
                            <div class="methods">
                                <?php foreach ($int_b_s as $mb) : ?>
                                    <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' ">
                                        <img src="<?= BASE_SITE . payment_option($mb->g_type) ?>" alt="<?= $mb->g_type ?>" />
                                        <small class="ribbon"><?= strtoupper($mb->active_payment) ?></small>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php } ?>

                    <div class="tab-content p-2" id="brand-support">
                        <div class="">
                            <?php if (!empty($all_info['whatsapp_number'])) : ?>
                                <div class="card support-logo  m-4 p-4">
                                    <a class="flex items-center justify-center" href="https://wa.me/<?= $all_info['whatsapp_number'] ?>" target="_blank">
                                        <img src="<?= base_url('public/assets/img/whatsapp.png') ?>" alt="Whatsapp" height="40">
                                        </span>Whatsapp</span>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <?php if (!empty($all_info['support_mail'])) : ?>
                                <div class="card support-logo m-4 p-4">
                                    <a class="flex items-center justify-center" href="mailto:<?= $all_info['support_mail'] ?>">
                                        <img src="<?= base_url('public/assets/img/email.png') ?>" alt="Email" height="40" />
                                        </span>Gmail</span>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($all_info['mobile_number'])) : ?>
                                <div class="card support-logo  m-4 p-4">
                                    <a class="flex items-center justify-center" href="tel:<?= $all_info['mobile_number'] ?>">
                                        <img src="<?= base_url('public/assets/img/phone-call.png') ?>" alt="Number" height="40" />
                                        </span>Call</span>
                                    </a>
                                </div>
                            <?php endif; ?>


                        </div>
                    </div>
                    <div class="tab-content p-3" id="brand-details">
                        <div class="card">
                            <p class="text-center">Transaction Details</p>
                            <table>
                                <tr>
                                    <th>Invoice to </th>
                                    <td><?= ucfirst($all_info['brand_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>Trx Id</th>
                                    <td><?= $all_info['transaction_id'] ?></td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td><?= $all_info['amount'] ?></td>
                                </tr>
                                <tr>
                                    <th>Charge</th>
                                    <td><?= $all_info['fees_amount'] . $all_info['fees_type'] ?></td>
                                </tr>

                            </table>
                        </div>
                    </div>
                    <!-- tab_content -->
                </div>
            </div>
            <button class="w-full absolute bottom-0 btn btn-bottom">Pay <?= currency_format($all_info['total_amount']) ?></button>
        </div>
    </div>

    <!-- java script  -->
    <?= script_asset('js/jquery.js') ?>
    <script>
        $(document).ready(function() {
            $(".tab-content:first").addClass("active");
            $(".menu .mbtn:first").addClass("active");

            $(".mbtn").click(function() {
                let id = $(this).attr("data-target");
                $(".mbtn").removeClass("active");
                $(this).addClass("active");
                $(".tab-content").removeClass("active");
                $("#" + id).addClass("active");
            });
        });
    </script>

</html>
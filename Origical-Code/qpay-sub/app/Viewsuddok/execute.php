<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Secure Payment-<?= get_option('site_name', 'Your Site') ?></title>
    <link rel="shortcut icon" type="image/x-icon" href="<?= BASE_SITE . get_option('site_icon', BASE_SITE . "assets/images/favicon.png") ?>">
    <?= link_asset('css/style4.css') ?>

    <style>
        .tab-content.active {
            position: relative;
            overflow: hidden;
        }

        .tab-content.active::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
            width: 50px;
            height: 50px;
            background-image: url('<?= BASE_SITE . get_option('site_icon') ?>');
            background-size: contain;
            background-repeat: no-repeat;
            z-index: 1;
        }

        .tab-content.active * {
            z-index: 2;
        }
    </style>

</head>

<body class="w-full min-h-screen sm:h-auto sm:p-12 sm:flex sm:items-center sm:justify-center">

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
            <button class="cancel_btn" data-url="<?= base_url('api/checkout/undetected/' . $all_info['tmp_ids'] . '/' . encodeParams('0')) ?>">&#x2716;</button>
        </div>
        <div class="flex flex-row space-evenly mt-7 mb-6 w-full">
            <div class="mb-4 mr-5 sm:mr-8">
                <img src="<?= BASE_SITE . $all_info['brand_logo'] ?>" alt="<?= $all_info['brand_name'] ?>" style="height:85px;width:85px;object-fit: contain" class="rounded-full overflow-hidden object-cover ring-1 cursor-pointer transition-all duration-300 hover:scale-105">
            </div>
            <div class="flex flex-col items-center">
                <div class="mb-4 sm:mb-3">
                    <h3 class="font-semibold text-xl text-[#6D7F9A]"><?= $all_info['brand_name'] ?></h3>
                </div>
                <div class="flex">
                    <a href="#" data-tab="supportSection" class="up-nav-tab2 section-btn myBtn active-profile">
                        <svg width="22" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.8 9.8C20.8 7.46609 19.8728 5.22778 18.2225 3.57746C16.5722 1.92714 14.3339 1 12 1C9.66605 1 7.42773 1.92714 5.77741 3.57746C4.12709 5.22778 3.19995 7.46609 3.19995 9.8" stroke="#6D7F9A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M20.8 17.5V18.05C20.8 18.6335 20.5682 19.1931 20.1556 19.6056C19.7431 20.0182 19.1835 20.25 18.6 20.25H14.75M1 14.6818V12.6182C1.00007 12.1276 1.16412 11.6511 1.46608 11.2645C1.76803 10.8778 2.19055 10.6032 2.6665 10.4842L4.5805 10.0046C4.67776 9.98039 4.77926 9.97863 4.87729 9.99948C4.97533 10.0203 5.06733 10.0632 5.14631 10.1249C5.2253 10.1866 5.28919 10.2655 5.33315 10.3556C5.3771 10.4457 5.39996 10.5446 5.4 10.6448V16.6541C5.40017 16.7546 5.37742 16.8537 5.33347 16.944C5.28953 17.0343 5.22555 17.1134 5.14641 17.1753C5.06727 17.2371 4.97506 17.2801 4.8768 17.3009C4.77854 17.3217 4.67682 17.3198 4.5794 17.2954L2.6654 16.8169C2.18966 16.6977 1.76738 16.423 1.46564 16.0364C1.1639 15.6497 1.00001 15.1734 1 14.6829V14.6818ZM23 14.6818V12.6182C22.9999 12.1276 22.8359 11.6511 22.5339 11.2645C22.232 10.8778 21.8094 10.6032 21.3335 10.4842L19.4195 10.0046C19.3222 9.98039 19.2207 9.97863 19.1227 9.99948C19.0247 10.0203 18.9327 10.0632 18.8537 10.1249C18.7747 10.1866 18.7108 10.2655 18.6669 10.3556C18.6229 10.4457 18.6 10.5446 18.6 10.6448V16.6541C18.5999 16.7544 18.6226 16.8535 18.6665 16.9437C18.7104 17.0339 18.7742 17.1129 18.8533 17.1747C18.9323 17.2366 19.0243 17.2796 19.1224 17.3005C19.2206 17.3214 19.3222 17.3197 19.4195 17.2954L21.3335 16.8169C21.8094 16.6979 22.232 16.4233 22.5339 16.0366C22.8359 15.65 22.9999 15.1735 23 14.6829V14.6818Z" stroke="#94A9C7" stroke-width="1.5"></path>
                            <path d="M13.65 21.9H10.35C9.91234 21.9 9.49266 21.7261 9.18322 21.4167C8.87379 21.1073 8.69995 20.6876 8.69995 20.25C8.69995 19.8124 8.87379 19.3927 9.18322 19.0833C9.49266 18.7738 9.91234 18.6 10.35 18.6H13.65C14.0876 18.6 14.5072 18.7738 14.8167 19.0833C15.1261 19.3927 15.3 19.8124 15.3 20.25C15.3 20.6876 15.1261 21.1073 14.8167 21.4167C14.5072 21.7261 14.0876 21.9 13.65 21.9Z" stroke="#6D7F9A" stroke-width="1.5"></path>
                        </svg>
                        <div class>
                            <span class="hidden sm:block text-[14px] text-[#879ab6] ml-3 font-english">Support</span>
                        </div>
                    </a>
                    <a href="#" data-tab="transactionsSection" class="up-nav-tab2 section-btn  mx-5 myBtn">
                        <svg width="22" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M11.5 1C5.7016 1 1 5.7016 1 11.5C1 17.2984 5.7016 22 11.5 22C17.2984 22 22 17.2984 22 11.5C22 5.7016 17.2984 1 11.5 1Z" stroke="#6D7F9A" stroke-width="1.5" stroke-miterlimit="10"></path>
                            <path d="M10 10H12V17" stroke="#94A9C7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                            <path d="M9 17H14" stroke="#94A9C7" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"></path>
                            <path d="M11.5 5C11.2033 5 10.9133 5.08797 10.6666 5.2528C10.42 5.41762 10.2277 5.65189 10.1142 5.92597C10.0006 6.20006 9.97095 6.50166 10.0288 6.79263C10.0867 7.08361 10.2296 7.35088 10.4393 7.56066C10.6491 7.77044 10.9164 7.9133 11.2074 7.97118C11.4983 8.02906 11.7999 7.99935 12.074 7.88582C12.3481 7.77229 12.5824 7.58003 12.7472 7.33335C12.912 7.08668 13 6.79667 13 6.5C13 6.10218 12.842 5.72064 12.5607 5.43934C12.2794 5.15803 11.8978 5 11.5 5Z" fill="#94A9C7"></path>
                        </svg>
                        <div class>
                            <span class="hidden sm:block text-[14px] text-[#879ab6] ml-3 font-english">Details</span>
                        </div>
                    </a>
                    

                </div>
            </div>
        </div>
        <div class="flex w-full justify-between bg-[#0057d0] text-white overflow-hidden rounded-md menu">
            <?php if (!empty($mobile_s)) { ?>
                <a href="#" data-tab="mobile_banking" class="myBtn up-nav-tab rounded-md w-[100%] py-1.5 text-center text-[10px] sm:text-[15px] h-full transition-all duration-300 leading-[23px]">Mobile Banking</a>
            <?php }
            if (!empty($bank_s)) { ?>
                <a href="#" data-tab="net_banking" class="myBtn up-nav-tab  rounded-md w-[100%] py-1.5 text-center text-[10px] sm:text-[15px] h-full transition-all duration-300 leading-[23px]">Bank Transfer</a>
            <?php }
            if (!empty($int_b_s)) { ?>
                <a href="#" data-tab="international_banking" class="myBtn up-nav-tab  rounded-md w-[100%] py-1.5 text-center text-[10px] sm:text-[15px] h-full transition-all duration-300 leading-[23px]">International Banking</a>
            <?php } ?>
        </div>
        <div class="overflow-auto p-0.5 mt-6 w-full pb-7 sm:pb-0">
            <?php if (!empty($mobile_s)) { ?>

                <div id="mobile_banking" class="up-tab tab-content">
                    <div class="grid grid-cols-2 gap-5 sm:grid-cols-4 pb-6">
                        <?php foreach ($mobile_s as $mb) : ?>
                            <a id="clickLoad" href="javascript:void(0)" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' " class="bank-img-div">
                                <div class="card-input w-full ring-1 ring-[#0057d0]/10 rounded-md flex justify-center items-center relative">
                                    <img src="<?= BASE_SITE . payment_option($mb->g_type) ?>" alt="<?= $mb->g_type ?>" class="bank-img">
                                    <small class="ribbon"><?= strtoupper($mb->active_payment) ?></small>
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php }
            if (!empty($bank_s)) { ?>
                <div id="net_banking" class="up-tab tab-content">
                    <div class="grid grid-cols-2 gap-5 sm:grid-cols-4 pb-6">
                        <?php foreach ($bank_s as $mb) : ?>
                            <a id="clickLoad" href="javascript:void(0)" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids']); ?>' " class="bank-img-div">
                                <div class="card-input w-full ring-1 ring-[#0057d0]/10 rounded-md flex justify-center items-center relative">
                                    <img src="<?= BASE_SITE . payment_option($mb->g_type) ?>" alt="<?= $mb->g_type ?>" class="bank-img">
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php }
            if (!empty($int_b_s)) { ?>
                <div id="international_banking" class="up-tab tab-content">
                    <div class="grid grid-cols-2 gap-5 sm:grid-cols-4 pb-6">
                        <?php foreach ($int_b_s as $mb) : ?>
                            <a id="clickLoad" href="javascript:void(0)" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' " class="bank-img-div">
                                <div class="card-input w-full ring-1 ring-[#0057d0]/10 rounded-md flex justify-center items-center relative">
                                    <img src="<?= BASE_SITE . payment_option($mb->g_type) ?>" alt="<?= $mb->g_type ?>" class="bank-img">
                                </div>
                            </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php } ?>

            <div id="supportSection" class="up-tab tab-content">
                <div class="flex flex-col sm:flex-row sm:flex-wrap justify-between">
                    <a href="tel:<?= $all_info['mobile_number'] ?>" class="w-full sm:w-[48%] mb-4">
                        <div class="support-div">
                            <img src="<?= base_url('public/assets/img/phone-call.png') ?>" alt="Number" class="w-7 mr-3">
                            <span class="text-sm text-[#485263] font-english">Click here to Call us for support.</span>
                        </div>
                    </a>
                    <a href="https://wa.me/<?= $all_info['whatsapp_number'] ?>" target="_Blank" class="w-full sm:w-[48%] mb-4">
                        <div class="support-div">
                            <img src="<?= base_url('public/assets/img/whatsapp.png') ?>" alt="Whatsapp" class="w-7 mr-3">
                            <span class="text-sm text-[#485263] font-english">Click here for Whatsapp chat.</span>
                        </div>
                    </a>
                    <a href="mailto:<?= $all_info['support_mail'] ?>" target="_blank" class="w-full sm:w-[48%] mb-4">
                        <div class="support-div">
                            <img src="<?= base_url('public/assets/img/email.png') ?>" alt="Email" class="w-7 mr-3">
                            <span class="text-sm text-[#485263] font-english">Click here to Email us for support.</span>
                        </div>
                    </a>
                </div>
            </div>
            
            <div id="transactionsSection" class="up-tab tab-content">
                <div class="bg-white rounded-lg shadow-md shadow-[#0057d0]/5">
                    <div class="px-5 py-4 sm:py-0 text-center rounded-lg bg-[#e5efff] sm:bg-transparent text-[#0057d0] font-semibold">
                        <h2 class="font-english">Transaction Details</h2>
                    </div>
                    <ul class="py-4 px-5 sm:mb-5">
                        <li class="flex justify-between text-sm text-[#6D7F9A] sm:text-base font-semibold">
                            <p class="font-english">Invoice To:</p>
                            <p><?= ucfirst($all_info['brand_name']); ?></p>
                        </li>
                        <hr class="my-3 sm:my-1.5 border-[#6D7F9A]/10">
                        <li class="flex justify-between text-sm text-[#6D7F9A]">
                            <p class="font-english">Trx Id:</p>
                            <p><?= $all_info['transaction_id'] ?></p>
                        </li>
                        <hr class="my-3 sm:my-1.5 border-[#6D7F9A]/10">
                        <li class="flex justify-between text-sm text-[#6D7F9A]">
                            <p class="font-english">Amount:</p>
                            <p><?= currency_format($all_info['amount']) ?></p>
                        </li>
                        <hr class="my-3 sm:my-1.5 border-[#6D7F9A]/10">
                        <li class="flex justify-between text-sm text-[#6D7F9A]">
                            <p class="font-semibold font-english">Total Payable Amount:</p>
                            <p class="font-semibold text-[#0057d0]"><?= currency_format($all_info['total_amount']) ?></p>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="w-full fixed rounded-t-2xl backdrop-blur-sm py-[18px] bottom-0 left-0 sm:static sm:rounded-[10px] sm:px-4 sm:py-3.5 text-center bg-[#cde1ff]/80 font-semibold text-[#0057D0]"> Pay <?= currency_format($all_info['total_amount']) ?> </div>
    </div>
    <?= script_asset('js/jquery.js') ?>
    <script>
        $(document).ready(function() {
            $(".tab-content:first").addClass("active");
            $(".menu .myBtn:first").addClass("active");

            $(".myBtn").click(function() {
                let id = $(this).attr("data-tab");
                $(".myBtn").removeClass("active");
                $(this).addClass("active");
                $(".tab-content").removeClass("active");
                $("#" + id).addClass("active");
            });
        });
    </script>
</body>

</html>
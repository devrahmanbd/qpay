<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Secure Checkout-<?=get_option('website_name','Your Site')?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=BASE_SITE.get_option('website_favicon')?>">
        <?=link_asset('css/style5.css')?>
        

    </head>
    <body>
        <div class="centerize">
            <div class="header">
                <div class="left">
                    <div class="btn cancel_btn" data-url="<?=$all_info['cancel_url']?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 15">
                            <path
                                fill="#7b7b7b"
                                fill-rule="evenodd"
                                d="M11.782 4.032a.575.575 0 1 0-.813-.814L7.5 6.687L4.032 3.218a.575.575 0 0 0-.814.814L6.687 7.5l-3.469 3.468a.575.575 0 0 0 .814.814L7.5 8.313l3.469 3.469a.575.575 0 0 0 .813-.814L8.313 7.5l3.469-3.468Z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <span id="cover_when_mobile">
                <img src="<?=BASE_SITE.$all_info['brand_logo']?>" alt="" id="company_logo" style="object-fit: contain;" />
                <h3 id="title"><?=$all_info['brand_name']?></h3>

                <div class="all_option">
                    <div class="btn mbtn" data-target="support">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path
                                fill="#373d41"
                                d="M12 2C6.486 2 2 6.486 2 12v4.143C2 17.167 2.897 18 4 18h1a1 1 0 0 0 1-1v-5.143a1 1 0 0 0-1-1h-.908C4.648 6.987 7.978 4 12 4s7.352 2.987 7.908 6.857H19a1 1 0 0 0-1 1V18c0 1.103-.897 2-2 2h-2v-1h-4v3h6c2.206 0 4-1.794 4-4c1.103 0 2-.833 2-1.857V12c0-5.514-4.486-10-10-10z"
                            />
                        </svg>
                        <p>Support</p>
                    </div>

                    <div class="btn mbtn" data-target="transaction_detail">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                            <path
                                fill="#373d41"
                                d="M12 17q.425 0 .713-.288Q13 16.425 13 16v-4.025q0-.425-.287-.7Q12.425 11 12 11t-.712.287Q11 11.575 11 12v4.025q0 .425.288.7q.287.275.712.275Zm0-8q.425 0 .713-.288Q13 8.425 13 8t-.287-.713Q12.425 7 12 7t-.712.287Q11 7.575 11 8t.288.712Q11.575 9 12 9Zm0 13q-2.075 0-3.9-.788q-1.825-.787-3.175-2.137q-1.35-1.35-2.137-3.175Q2 14.075 2 12t.788-3.9q.787-1.825 2.137-3.175q1.35-1.35 3.175-2.138Q9.925 2 12 2t3.9.787q1.825.788 3.175 2.138q1.35 1.35 2.137 3.175Q22 9.925 22 12t-.788 3.9q-.787 1.825-2.137 3.175q-1.35 1.35-3.175 2.137Q14.075 22 12 22Zm0-10Zm0 8q3.325 0 5.663-2.337Q20 15.325 20 12t-2.337-5.663Q15.325 4 12 4T6.338 6.337Q4 8.675 4 12t2.338 5.663Q8.675 20 12 20Z"
                            />
                        </svg>
                        <p>Details</p>
                    </div>
                </div>
            </span>

            <div class="cover_ex">
                <span id="cover_when_mobile_btn">
                    <div class="menu">
                        <?php if (!empty($mobile_s)) {?>

                        <div class="mbtn box" data-target="mobile_banking">
                            Mobile Banking
                        </div>

                        <?php }if (!empty($bank_s)) {?>

                        <div class="mbtn box" data-target="banking_tab">
                            Bank Transfer
                        </div>

                        <?php }if (!empty($int_b_s)) {?>

                        <div class="mbtn box" data-target="international_banking">
                            International
                        </div>

                        <?php } ?>
                    </div>
                </span>
                <?php if (!empty($mobile_s)) {?>
                <div class="tab_content" id="mobile_banking">
                    <div class="list_methods">
                        <?php 
                            foreach($mobile_s as $mb){
                        ?>
                        <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' ">
                            <img src="<?=BASE_SITE.payment_option($mb->g_type)?>" alt="" />
                        </div>        
                        <?php 
                            }
                        ?>
                    </div>
                </div>
                <?php }if (!empty($bank_s)) {?>

                <div class="tab_content" id="banking_tab">
                    <div class="list_methods">
                        <?php 
                            foreach($bank_s as $mb){
                        ?>
                        <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids']); ?>' ">
                            <img src="<?=BASE_SITE.payment_option($mb->g_type)?>" alt="" />
                        </div>        
                        <?php 
                            }
                        ?>
                    </div>
                </div>
                <?php }if (!empty($int_b_s)) {?>

                <div class="tab_content" id="international_banking">
                    <div class="list_methods">
                        <?php 
                            foreach($int_b_s as $mb){
                        ?>
                        <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' ">
                            <img src="<?=BASE_SITE.payment_option($mb->g_type)?>" alt="" />
                        </div>        
                        <?php 
                            }
                        ?>
                    </div>
                </div>
                <?php } ?>

                <div class="tab_content" id="transaction_detail">
                    <div class="transaction_details">
                        <p id="hd">Transaction Details</p>

                        <div class="row">
                            <p id="ques">Transaction ID:</p>
                            <p id="ans"><?=$all_info['transaction_id']?></p>
                        </div>
                        <div class="row">
                            <p id="ques">Amount:</p>
                            <p id="ans"><?=$all_info['amount']?></p>
                        </div>

                        <div class="row">
                            <p id="ques">Fees:</p>
                            <p id="ans"><?=$all_info['fees_amount'].$all_info['fees_type']?></p>
                        </div>

                        <div class="row">
                            <p id="ques">Total Amount:</p>
                            <p id="ans"><?=currency_format($all_info['total_amount'])?></p>
                        </div>
                    </div>
                </div>

                <div class="tab_content" id="support">
                    <div class="livechat">
                        <?php if(!empty($all_info['messenger_support'])){ ?>
                        <div class="row">
                            <a href="<?=$all_info['messenger_support']?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                    <path
                                        d="M12 2C6.477 2 2 6.477 2 12c0 4.708 3.41 8.61 7.898 9.384v2.616l3.02-1.75C14.432 22.354 15.195 22 16 22c5.523 0 10-4.477 10-10S21.523 2 16 2zm0 18c-4.411 0-8-3.589-8-8s3.589-8 8-8 8 3.589 8 8-3.589 8-8 8zm3-12h-2v3h-3v2h3v3h2v-3h3v-2h-3z"
                                    />
                                </svg>
                            </a>
                            <p>Click here for live chat on Messenger</p>
                        </div>
                        <?php } if(!empty($all_info['whatsapp_number'])){ ?>
                        <div class="row">
                            <a href="https://wa.me/<?=$all_info['whatsapp_number']?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                    <path
                                        d="M12 2C6.475 2 2 6.475 2 12c0 4.204 2.582 7.814 6.213 9.337L8.38 21.27c-.201.084-.468.147-.707.01-.315-.178-.561-.423-.738-.738-.137-.239-.075-.506.01-.707l1.933-3.833C7.186 14.418 6 13.282 6 12c0-4.411 3.589-8 8-8s8 3.589 8 8-3.589 8-8 8c-1.282 0-2.418-.186-3.395-.513L9.204 18.267c-.201.085-.468.147-.707.01-.314-.177-.561-.423-.738-.738-.137-.238-.075-.506.01-.707l1.754-3.475C9.225 13.38 9 12.73 9 12c0-3.86 3.14-7 7-7s7 3.14 7 7-3.14 7-7 7a6.93 6.93 0 0 1-4.971-2.064l-4.99 1.663A1.023 1.023 0 0 1 6 21.024V21a1 1 0 0 1 1-1h.024c.377 0 .735-.214.907-.579l1.612-3.224A9.033 9.033 0 0 0 12 20c4.975 0 9-4.025 9-9s-4.025-9-9-9z"
                                    />
                                </svg>
                            </a>

                            <p>Click here for live chat on Whatsapp</p>
                        </div>
                        <?php } if(!empty($all_info['support_mail'])){ ?>
                        <div class="row">
                            <a href="mailto:<?=$all_info['support_mail']?>">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="24" height="24">
                                    <path d="M21 5H3a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h18a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zM3 6h18v2l-9 6L3 8V6zm18 10H3v-2l9-6 9 6v2z" />
                                </svg>
                            </a>

                            <p>Click here for send Email On Support</p>
                        </div>
                        <?php } ?>
                    </div>
                </div>

                <div class="pay_btn">
                    Pay
                    <?=currency_format($all_info['total_amount'])?>
                    <?php echo @$user_currency_temp_text?>
                </div>
            </div>

            <!--<p id="footer_watermark">  target="blank">walletmaxpay.com</a></p>-->
        </div>


        <?=script_asset('jquery.js')?>
        <script>
            $(document).ready(function () {
                $(".tab_content:first").addClass("active");
                $(".menu .mbtn:first").attr('id',"active");

                $(".mbtn").click(function () {
                    let id = $(this).attr("data-target");
                    $(".mbtn").attr("id", "");
                    $(this).attr("id", "active");
                    $(".tab_content").removeClass("active");
                    $("#" + id).addClass("active");
                });
            });
        </script>
    </body>
</html>
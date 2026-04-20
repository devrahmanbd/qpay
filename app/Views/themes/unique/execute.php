<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Secure Payment-<?=get_option('website_name','Your Site')?></title>
        <link rel="shortcut icon" type="image/x-icon" href="<?=BASE_SITE.get_option('website_favicon', BASE_SITE."assets/images/favicon.png")?>">
        <?=link_asset('css/style.css')?>
  </head>
  <body>
    <div class="container-m">
      <div class="top d-flex-s">
        <div class="logo">
 
        </div>
        <button class="cancel_btn" data-url="<?= base_url('api/checkout/undetected/' . $all_info['tmp_ids'] . '/' . encodeParams('0')) ?>">&#x2716;</button>
      </div>
      <div class="brand">
        <div class="card d-flex">
          <div class="brand-logo">
            <img src="<?=BASE_SITE.$all_info['brand_logo']?>" alt="" id="company_logo" style="object-fit: contain;" />
          </div>
          <div class="brand-info">
            <h1><?=$all_info['brand_name']?></h1>
            <div class="d-flex">
              <div class="brand-support mbtn" data-target="brand-support">
                &#127911; Support
              </div>
              <div class="brand-details mbtn" data-target="brand-details">
                &#128200; Details
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="method">
        <h1>Payment Method</h1>
        <div class="menu">
          <?php if (!empty($mobile_s)) {?>

          <div class="mbtn menu-btn" data-target="mobile_banking">
              মোবাইল ব্যাংকিং
          </div>

          <?php }if (!empty($bank_s)) {?>

          <div class="mbtn menu-btn" data-target="banking_tab">
              ব্যাংক ট্রান্সফার
          </div>

          <?php }if (!empty($int_b_s)) {?>

          <div class="mbtn menu-btn" data-target="international_banking">
                অন্যান্য
          </div>

          <?php } ?>

        </div>
        <!-- tab_content -->
        <?php if (!empty($mobile_s)) {?>
        <div class="tab-content" id="mobile_banking">
            <div class="methods">
                <?php 
                    foreach($mobile_s as $mb){
                ?>
                <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' ">
                    <img src="<?=BASE_SITE.payment_option($mb->g_type)?>" alt="<?=$mb->g_type?>" />
                </div>        
                <?php 
                    }
                ?>
            </div>
        </div>
        <?php }if (!empty($bank_s)) {?>

        <div class="tab-content" id="banking_tab">
            <div class="methods">
                <?php 
                    foreach($bank_s as $mb){
                ?>
                <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids']); ?>' ">
                    <img src="<?=BASE_SITE.payment_option($mb->g_type)?>" alt="<?=$mb->g_type?>" />
                </div>        
                <?php 
                    }
                ?>
            </div>
        </div>
        <?php }if (!empty($int_b_s)) {?>

        <div class="tab-content" id="international_banking">
            <div class="methods">
                <?php 
                    foreach($int_b_s as $mb){
                ?>
                <div class="row" onclick="location.href='<?= base_url('api/execute_payment/' . $mb->g_type . '/' . $all_info['tmp_ids'] . '?acc_tp=' . encrypt($mb->active_payment)); ?>' ">
                    <img src="<?=BASE_SITE.payment_option($mb->g_type)?>" alt="<?=$mb->g_type?>" />
                </div>        
                <?php 
                    }
                ?>
            </div>
        </div>
        <?php } ?>

        <div class="tab-content p-2" id="brand-support">
          <div class="d-flex">
            <?php if(!empty($all_info['whatsapp_number'])){ ?>
            <div class="row m-1"><a href="https://wa.me/<?=$all_info['whatsapp_number']?>" target="_blank">&#9990; Whatsapp</a></div>
            <?php } if(!empty($all_info['support_mail'])){ ?>
            <div class="row m-1"><a href="mailto:<?=$all_info['support_mail']?>">&#9993; Gmail</a></div>
            <?php } ?>
          </div>
        </div>
        <div class="tab-content p-2" id="brand-details">
          <div class="card">
            <p>Transaction Details</p>
            <table>
              <tr>
                <th>Trx Id</th>
                <td><?=$all_info['transaction_id']?></td>
              </tr>
              <tr>
                <th>Amount</th>
                <td><?=$all_info['amount']?></td>
              </tr>
              <tr>
                <th>Charge</th>
                <td><?=$all_info['fees_amount'].$all_info['fees_type']?></td>
              </tr>
              
            </table>
          </div>
        </div>
        <!-- tab_content -->
      </div>
      <div class="bottom">Pay <?=currency_format($all_info['total_amount'])?></div>
    </div>

    <!-- java script  -->
    <?=script_asset('jquery.js')?>
    <script>
      $(document).ready(function () {
        $(".tab-content:first").addClass("active");
        $(".menu .mbtn:first").addClass("active");

        $(".mbtn").click(function () {
          let id = $(this).attr("data-target");
          $(".mbtn").removeClass("active");
          $(this).addClass("active");
          $(".tab-content").removeClass("active");
          $("#" + id).addClass("active");
        });
      });
    </script>
    <!-- java script  -->
  </body>
</html>

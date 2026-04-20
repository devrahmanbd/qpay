<style>
    :root {
        --bg1: #c90008;
        --bg2: #c90008;
    }
</style>
<style>
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
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">*167# ডায়াল করে আপনার NAGAD মোবাইল মেনুতে যান অথবা NAGAD অ্যাপে যান।</p>
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
                <p class="font-bangla">নিশ্চিত করতে এখন আপনার NAGAD মোবাইল মেনু পিন লিখুন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">সবকিছু ঠিক থাকলে, আপনি NAGAD থেকে একটি নিশ্চিতকরণ বার্তা পাবেন।</p>
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
    <div class="mb-20">
        <ul class="mt-5 text-slate-200">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">*167# ডায়াল করে আপনার NAGAD মোবাইল মেনুতে যান অথবা NAGAD অ্যাপে যান।</p>
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
                <p class="font-bangla">নিশ্চিত করতে এখন আপনার NAGAD মোবাইল মেনু পিন লিখুন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">সবকিছু ঠিক থাকলে, আপনি NAGAD থেকে একটি নিশ্চিতকরণ বার্তা পাবেন।</p>
            </li>
            <hr class="brand-hr my-3">
            <li class="flex text-sm">
                <div><span class="inline-block w-1.5 h-1.5 mr-2 bg-white rounded-full mb-0.5"></span>
                </div>
                <p class="font-bangla">এখন উপরের বক্সে আপনার<span class="text-yellow-300 font-semibold ml-1">Transaction ID</span> দিন এবং নিচের<span class="text-yellow-300 font-semibold ml-1">VERIFY</span> বাটনে ক্লিক করুন।</p>
            </li>
        </ul>
    </div>
<?php elseif ($acc_tp == 'merchant') : ?>

  $enc_ids = $this->encryption->encrypt_data($tmp['all_info']['tmp_ids']);
  

$mode = get_value($setting['params'],'nagad_mode');
$pgPublicKey =  get_value($setting['params'],'public_key');
$merchantPrivateKey = get_value($setting['params'],'private_key');
$merchant_id = get_value($setting['params'],'merchant_id');
$order_no = trxId();
$order_id = $order_no . rand(1001, 9999);
$logo = BASE_SITE.$tmp['all_info']['brand_logo'];


if ( $mode == 'sandbox' ) {
    $base = "http://sandbox.mynagad.com:10080/remote-payment-gateway-1.0/api/dfs/";
} else {
    $base = "https://api.mynagad.com/api/dfs/";
}

$checkout_initialize_api   = $base . "check-out/initialize/" . $merchant_id. "/";
$checkout_complete_api   = $base . "check-out/complete/";
$_api = $base . "verify/payment/";

function randomString($length = 40)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function EncryptDataWithPublicKey($data,$pgPublicKey)
{
    
    if ( gettype( $data ) == 'array' ) {
        $data = json_encode( $data );
    }
    
    $public_key = "-----BEGIN PUBLIC KEY-----\n" . $pgPublicKey . "\n-----END PUBLIC KEY-----";

    $key_resource = openssl_get_publickey($public_key);
    openssl_public_encrypt($data, $cryptText, $key_resource);
    return base64_encode($cryptText);
}


function generateSignature( $data ,$merchantPrivateKey) {

    if ( gettype( $data ) == 'array' ) {
        $data = json_encode( $data );
    }

    $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
    openssl_sign( $data, $signature, $private_key, OPENSSL_ALGO_SHA256 );

    return base64_encode( $signature );
}

function http_request($PostURL, $PostData)
{
    $url = curl_init($PostURL);
    $postToken = json_encode($PostData);
    $header = array(
        'Content-Type:application/json',
        'X-KM-Api-Version:v-0.2.0',
        'X-KM-IP-V4:' . get_client_ip(),
        'X-KM-Client-Type:PC_WEB'
    );
    
    curl_setopt($url, CURLOPT_HTTPHEADER, $header);
    curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($url, CURLOPT_POSTFIELDS, $postToken);
    curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false); 
    // curl_setopt($url, CURLOPT_HEADER, 1); 
    
    $resultData = curl_exec($url);
    $ResultArray = json_decode($resultData, true);
    $header_size = curl_getinfo($url, CURLINFO_HEADER_SIZE);
    curl_close($url);
        $headers = substr($resultData, 0, $header_size);
        $body = substr($resultData, $header_size);
    return $ResultArray;

}


function DecryptDataWithPrivateKey($cryptText,$merchantPrivateKey)
{
    $private_key = "-----BEGIN RSA PRIVATE KEY-----\n" . $merchantPrivateKey . "\n-----END RSA PRIVATE KEY-----";
    openssl_private_decrypt(base64_decode($cryptText), $plain_text, $private_key);
    return $plain_text;
}
function getCurrentBDtime( $format = "YmdHis", $timezone = "Asia/Dhaka" ) {
    $timezone = new DateTimeZone( $timezone );
    $datetime = new DateTime( 'now', $timezone );

    return $datetime->format( $format );
}

function checkout_initialize( $order_id ,$merchant_id,$pgPublicKey, $merchantPrivateKey,$checkout_initialize_api ) {

    $sensitive_data = [
        'merchantId' => $merchant_id,
        'datetime'   => getCurrentBDtime(),
        'orderId'    => $order_id,
        'challenge'  => randomString(),
    ];

    $checkout_init_data = [
        'dateTime'      => getCurrentBDtime(),
        'sensitiveData' => EncryptDataWithPublicKey( $sensitive_data, $pgPublicKey ),
        'signature'     => generateSignature( $sensitive_data ,$merchantPrivateKey),
    ];

    $language = 'EN'; 

    $url      = $checkout_initialize_api . $order_id. "?locale=" . $language;
    $response = http_request( $url, $checkout_init_data );

    return $response;
}
function checkout_complete( $sensitive_data, $order_id, $amount, $original_order_no,$merchant_id,$pgPublicKey,$merchantPrivateKey,$checkout_complete_api,$logo ,$enc_ids) {
    $decrypted_response = json_decode( decryptDataWithPrivateKey( $sensitive_data,$merchantPrivateKey ), true );

    if ( isset( $decrypted_response['paymentReferenceId'] ) && isset( $decrypted_response['challenge'] ) ) {
        $payment_reference_id = $decrypted_response['paymentReferenceId'];

        $order_sensitive_data = [
            'merchantId'   => $merchant_id,
            'orderId'      => $order_id,
            'currencyCode' => '050',
            'amount'       => $amount,
            'challenge'    => $decrypted_response['challenge']
        ];

        $order_post_data = [
            'sensitiveData'          => encryptDataWithPublicKey( $order_sensitive_data,$pgPublicKey ),
            'signature'              => generateSignature( $order_sensitive_data,$merchantPrivateKey ),
            'merchantCallbackURL'    => base_url( 'callback/nagad' ),
            'additionalMerchantInfo' =>  [
                'order_no' => $original_order_no,
                'serviceLogoURL' => $logo
            ],
        ];
        set_session('complete_url',base_url('request/complete/nagad/'.$enc_ids) );

        
        $url = $checkout_complete_api . $payment_reference_id;

        $response = http_request( $url, $order_post_data );

        return $response;
    }

    return false;
}

$response = checkout_initialize( $order_id ,$merchant_id,$pgPublicKey, $merchantPrivateKey,$checkout_initialize_api );

if ( isset( $response['sensitiveData'] ) && isset( $response['signature'] ) ) {
    if ( $response['sensitiveData'] != "" && $response['signature'] != "" ) {
        //execute order request
        $execute = checkout_complete( $response['sensitiveData'], $order_id, $tmp['all_info']['total_amount'], $order_no,$merchant_id,$pgPublicKey, $merchantPrivateKey,$checkout_complete_api,$logo ,$enc_ids);

        if ( $execute ) {
            if ( $execute['status'] == "Success" ) {
                $url = json_encode( $execute['callBackUrl'] );
                echo "<script>window.open($url, '_self')</script>";
            } else {
              echo "<span style='color:red'>".$execute['execute']."</span>";
            }
        }
    }
} else {
    echo "<span style='color:red'>".$response['devMessage']."</span>";
}
  

} 
<?php endif; ?>
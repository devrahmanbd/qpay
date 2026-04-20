<?php


$rate=1;
if (get_option('currency_code')!='USD') {
    $new_currency_rate = get_option('new_currecry_rate');
    if ($new_currency_rate !== null && $new_currency_rate != 0) {
        $rate = 1 / $new_currency_rate;
    }
    if (get_option('is_auto_currency_convert')=='1') {
        $rate = 1/currency_converter(get_option('currency_code'));
    }
    if (!empty( get_value($setting['params'],'dollar_rate') )) {
        $rate = 1/get_value($setting['params'],'dollar_rate');
    }
}


// $m_shop = get_value($setting['params'],'m_shop');
// $m_orderid = md5(rand(1,999999));
// $m_amount = ceil($tmp['all_info']['total_amount']*$rate);
// $m_curr = "USD";
// $m_desc = base64_encode('Payeer Orders');
// $m_key = get_value($setting['params'],'client_secret');


// $arHash = array(
//     $m_shop,
//     $m_orderid,
//     $m_amount,
//     $m_curr,
//     $m_desc
// );

// // Forming an array for additional parameters
// $arParams = array(
//     'success_url' => 'http://google.com/new_success_url',
//     'fail_url' => 'http://google.com/new_fail_url',
//     'status_url' => 'http://google.com/new_status_url',
// );
// // Forming a key for encryption
// $key = md5('Key for encrypting additional parameters'.$m_orderid);
// // Encrypting additional parameters
// $iv = substr(hash('sha256', $key), 0, 16);
// $m_params = urlencode(base64_encode(openssl_encrypt(json_encode($arParams),'AES-256-CBC', $key, OPENSSL_RAW_DATA, $iv)));
// // Adding parameters to the signature-formation array
// $arHash[] = $m_params;




// // Adding the secret key to the signature-formation array
// $arHash[] = $m_key;
// $sign = strtoupper(hash('sha256', implode(':', $arHash)));
// $arGetParams = array(
//     'm_shop' => $m_shop,
//     'm_orderid' => $m_orderid,
//     'm_amount' => $m_amount,
//     'm_curr' => $m_curr,
//     'm_desc' => $m_desc,
//     'm_sign' => $sign,
//     'm_params' => $m_params,
// );
// $url = 'https://payeer.com/merchant/?'.http_build_query($arGetParams);
// redirect($url);



//
$m_shop = get_value($setting['params'],'m_shop');
$m_orderid = md5(rand(1,999999));
$m_curr = 'USD';
$m_desc = base64_encode('Payeer Orders');
$m_key = get_value($setting['params'],'client_secret');
$m_amount = number_format($tmp['all_info']['total_amount']*$rate, 2, '.', '');

$arHash = array(
    $m_shop,
    $m_orderid,
    $m_amount,
    $m_curr,
    $m_desc
);


$arParams = array(
    'success_url' => 'http:///new_success_url',
);

$key = md5(ENCRYPTION_KEY.$m_orderid);

$m_params = @urlencode(base64_encode(openssl_encrypt(json_encode($arParams), 'AES-256-CBC', $key, OPENSSL_RAW_DATA)));

// $arHash[] = $m_params;

$arHash[] = $m_key;

$sign = strtoupper(hash('sha256', implode(':', $arHash)));

?>
<form id="payeer_payment" method="post" action="https://payeer.com/merchant/">
<input type="hidden" name="m_shop" value="<?=$m_shop?>">
<input type="hidden" name="m_orderid" value="<?=$m_orderid?>">
<input type="hidden" name="m_amount" value="<?=$m_amount?>">
<input type="hidden" name="m_curr" value="<?=$m_curr?>">
<input type="hidden" name="m_desc" value="<?=$m_desc?>">
<input type="hidden" name="m_sign" value="<?=$sign?>">
<input type="submit" style="display: none;" name="m_process" value="send" />
<script type="text/javascript" src="//code.jquery.com/jquery-3.3.1.min.js"></script>
<script>
$("form#payeer_payment").submit();
</script>
<?php

class MasterCardGateway {

    private $service_host;
    private $api_version;
    private $merchant_id;
    private $auth_pass;
    private $user_id;

    public function __construct($service_host,$api_version,$merchant_id,$auth_pass,$user_id) {
        $this->service_host = $service_host;
        $this->api_version = $api_version;
        $this->merchant_id = $merchant_id; 
        $this->auth_pass = $auth_pass; 
        $this->user_id = $user_id;
    }

    public function initiateCheckout($order_id, $amount, $currency,$enc_ids) {
        if((int) $this->api_version >= 62) {
            $session_request['initiator']['userId']     = $this->user_id;
        } else {
            $session_request['userId']                  = $this->user_id;
        }

        if((int) $this->api_version >= 63) {
            $src = $this->service_host."static/checkout/checkout.min.js";
        } else {
            $src = $this->service_host."checkout/version/".$this->api_version."/checkout.js";
        }

        $session_request['order']['id']                 = $order_id;
        $session_request['order']['amount']             = $amount;
        $session_request['order']['currency']           = $currency;
        $session_request['interaction']['returnUrl']    = base_url('callback/mastercard');

        if((int) $this->api_version >= 63) {
            $session_request['apiOperation']  = "INITIATE_CHECKOUT";
        } else {
            $session_request['apiOperation']                = "CREATE_CHECKOUT_SESSION";
        }

        if( (int) $this->api_version >= 52 ) {
            $session_request['interaction']['operation']    = "PURCHASE";
        }

        $request_url = $this->service_host . "api/rest/version/" . $this->api_version . "/merchant/" . $this->merchant_id . "/session";

        $response = $this->sendRequest($request_url, $session_request);

        if ($response && isset($response['session']['id'])) {
            set_session('complete_url',base_url('request/complete/nagad/'.$enc_ids) );

            $sessionId = $response['session']['id'];
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>MPGS Checkout</title>
            </head>
            <body>
                <h1>MPGS Checkout</h1>
                <script>
                    window.onload = function() {
                        var checkoutScript = document.createElement('script');
                        checkoutScript.src = '{$src}';
                        document.head.appendChild(checkoutScript);

                        Checkout.configure({
                            merchant: '{$this->merchant_id}',
                            session: {
                                id: '{$sessionId}'
                            },
                            interaction: {
                                merchant: {
                                    name: 'Your Merchant Name',
                                    address: {
                                        line1: 'Your Address Line 1',
                                        line2: 'Your Address Line 2'
                                    }
                                },
                                displayControl: {
                                    billingAddress: 'HIDE',
                                    customerEmail: 'HIDE',
                                    shipping: 'HIDE'
                                }
                            }
                        });

                        Checkout.showPaymentPage();
                    };
                </script>
            </body>
            </html>";
        } else {
            echo "<span style='color:red'>".$response['error']['explanation']."</span>";
        }
    }

    private function sendRequest($url, $data) {
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("merchant." . $this->merchant_id . ":" . $this->auth_pass),
        ));

        $response_body = curl_exec($ch);

        if (curl_errno($ch)) {
            curl_close($ch);
            return false;
        }

        curl_close($ch);

        $response_array = json_decode($response_body, true);

        return $response_array;
    }


}
$enc_ids = $this->encryption->encrypt_data($tmp['all_info']['tmp_ids']);

    
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
$amount = ceil($tmp['all_info']['total_amount']*$rate);

$service_host = get_value($setting['params'],'mpgs_url');
$api_version = get_value($setting['params'],'mpgs_api');
$merchant_id = get_value($setting['params'],'merchant_id');
$auth_pass = get_value($setting['params'],'merchant_password');
$user_id = $tmp['all_info']['uid'];

// Handle the form submission
$order_id = $tmp['all_info']['tmp_ids']; 
$currency = 'USD'; 

$masterCardGateway = new MasterCardGateway($service_host,$api_version,$merchant_id,$auth_pass,$user_id);
$masterCardGateway->initiateCheckout($order_id, $amount, $currency, $enc_ids);

?>

<style type="text/css">#transaction_id{display: none;}</style>
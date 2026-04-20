<?php

namespace App\Libraries;

class Bkashapi
{

    public $bkash_username;
    public $bkash_password;
    public $bkash_app_key;
    public $bkash_app_secret;
    public $bkash_charge;
    public $base_url;

    public function __construct($bkash_username = null, $bkash_password = null, $bkash_app_key = null, $bkash_app_secret = null, $base_url = null)
    {
        if ($bkash_app_key != "" && $bkash_app_secret != "") {
            $this->bkash_username = $bkash_username;
            $this->bkash_password = $bkash_password;
            $this->bkash_app_key = $bkash_app_key;
            $this->bkash_app_secret = $bkash_app_secret;
            $this->base_url = $base_url;
        }
    }

    /**
     *
     * Define Payment && Create payment.
     *
     */
    public function create_payment($datas = "")
    {
        $token_url = $this->base_url . '/v1.2.0-beta/tokenized/checkout/token/grant';

        // Set the request headers
        $headers = array(
            'accept: application/json',
            'content-type: application/json',
            'username: ' . $this->bkash_username,
            'password: ' . $this->bkash_password
        );

        // Set the request data
        $data = array(
            'app_key' => $this->bkash_app_key,
            'app_secret' => $this->bkash_app_secret
        );

        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $token_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        // Execute the cURL request
        $response = curl_exec($ch);

        // Check if the request was successful
        if ($response === false) {
            return (['status' => 'error', 'message' => 'Error: ' . curl_error($ch)]);
        } else {
            // Decode the response JSON string into an array
            $response_arr = json_decode($response, true);

            // Check if the access token was returned in the response
            if (isset($response_arr['id_token'])) {

                $access_token = $response_arr['id_token'];
                set_session("token",$access_token);
                
            } else {
                return (['status' => 'error', 'message' => 'Error: Failed to get access token']);
            }
        }

        // Close cURL
        curl_close($ch);


        // Set the URL of the payment create endpoint
        $payment_url = $this->base_url . '/v1.2.0-beta/tokenized/checkout/create';

        // Set the request headers
        $app_key = $this->bkash_app_key;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer $access_token",
            "X-APP-Key: $app_key"
        );

        // Initialize cURL
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_URL, $payment_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($datas));

        // Execute the cURL request
        $response = curl_exec($ch);


        // Check if the request was successful
        if ($response === false) {
            return (['status' => 'error', 'message' => 'Error: ' . curl_error($ch)]);
        } else {
            // Decode the response JSON string into an array
            $response_arr = json_decode($response, true);
            // Check if the payment link was returned in the response
            if (isset($response_arr['paymentID'])) {
                $payment_link = $response_arr['bkashURL'];
                return (['status' => 'success', 'message' => $response, 'payment_link' => $payment_link]);
            } else {
                return (['status' => 'error', 'message' => 'Error: Failed to create payment']);
            }
        }

        // Close cURL
        curl_close($ch);
    }

    /**
     *
     * Execute payment 
     *
     */
    public function execute_payment()
    {

        $paymentID = $_GET['paymentID'];

        $auth = @session("token");
        
        
        $post_token = array(
            'paymentID' => $paymentID
        );
        $url = curl_init($this->base_url . '/v1.2.0-beta/tokenized/checkout/execute');
        $posttoken = json_encode($post_token);
        $app_key = $this->bkash_app_key;

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $auth,
            "X-APP-Key: $app_key"
        );
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);
        curl_close($url);

        if ($resultdata === false) {
            return (['status' => 'error', 'message' => 'Error: ' . curl_error($ch)]);
        } else {
            return (['status' => 'success', 'message' => $resultdata]);
        }
    }
    public function queryPayment()
    {
        $paymentID = $_GET['paymentID'];

        $auth = @$_SESSION['token'];
        $post_token = array(
            'paymentID' => $paymentID
        );
        $url = curl_init($this->base_url . '/v1.2.0-beta/tokenized/checkout/payment/status');
        $posttoken = json_encode($post_token);
        $app_key = $this->bkash_app_key;

        $header = array(
            'Content-Type:application/json',
            'Authorization:' . $auth,
            "X-APP-Key: $app_key"
        );
        curl_setopt($url, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($url, CURLOPT_HTTPHEADER, $header);
        curl_setopt($url, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($url, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($url, CURLOPT_POSTFIELDS, $posttoken);
        curl_setopt($url, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($url, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        $resultdata = curl_exec($url);

        curl_close($url);

        $obj = json_decode($resultdata, true);
        return $obj;
    }
}

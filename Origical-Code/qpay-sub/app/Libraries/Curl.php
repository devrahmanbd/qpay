<?php

namespace App\Libraries;

class Curl
{
    public function simple_post($url, $data)
    {
        $curl = curl_init();
        $data = http_build_query($data);
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
        );
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_VERBOSE => true
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}

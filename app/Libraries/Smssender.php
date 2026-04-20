<?php

namespace App\Libraries;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\I18n\Time;

class Smssender {

    protected $db;

    public function __construct() {
        $this->db = db_connect();
    }

    /**
     * Sends an SMS using the configured SMS API
     * 
     * @param string $templateKey Key for the email_templates table
     * @param array $params Variables to replace in the template
     * @param string|null $requestMessage Direct message if no template key provided
     * @param string $number Recipient phone number
     * @param int|null $uid Merchant ID
     */
    public function send_sms($templateKey, $params, $requestMessage = null, $number, $uid = null)
    {
        $permitted = false;
        $sms_data = [
            'type'   =>  1,
            'medium' => $number,
            'status' => 0,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $charge = (double)get_option('sms_api_cost', 0);

        if (is_null($uid)) {
            $requestMessage = get_option($templateKey);
            $permitted = true;
        } else {
            $templateObj = $this->db->table('email_templates')
                ->where(['uid' => $uid, 'template_key' => $templateKey])
                ->get()
                ->getRow();

            if (empty($templateObj)) {
                log_message('error', "SMS Template not found: $templateKey for UID: $uid");
                return false;
            }

            $user = $this->db->table('users')->where('id', $uid)->get()->getRow();
            if (!$user) return false;

            $bal = (double)$user->balance;
            $sms_data['uid'] = $uid;
            
            $addons = json_decode($user->addons ?? '{}', true);
            if (($addons['sms'] ?? 0) != 1) {
                return false; // SMS Addon not enabled for this user
            }

            if (($templateObj->sms_status ?? 0) != 1) {
                return false; // SMS notification disabled for this specific template
            }
        }
        
        if (empty($templateObj) && $requestMessage == null) {
            return false;
        }

        $template = !empty($templateObj) ? $templateObj->sms_body : $requestMessage;

        foreach ($params as $code => $value) {
            $template = str_replace('{{' . $code . '}}', $value, $template);
        }

        $sms_data['message'] = $template;
        $template = strip_tags($template);

        // Basic character count for charging
        $maxChars = 160; 
        $length = strlen($template);
        $counter = ceil($length / $maxChars);
        $charge = $charge * $counter;

        $sms_data['charge'] = $charge;

        if (!empty($uid)) {
            if ($bal >= $charge) {
                $permitted = true;
            } else {
                $sms_data['charge'] = '0';
                $sms_data['status'] = '3';
                $sms_data['response'] = 'Low Balance';
                $this->db->table('user_notifier')->insert($sms_data);
                return false;
            }
        }

        // Log the message entry
        $this->db->table('user_notifier')->insert($sms_data);
        $insert_id = $this->db->insertID();

        if (!$permitted) {
            return false;
        }

        // Deduct balance
        if (!empty($uid)) {
            $this->db->table('users')
                ->where('id', $uid)
                ->decrement('balance', $charge);
        }

        // API Configuration from Global Options
        $actionUrl = get_option('sms_api_url');
        $actionMethod = get_option('sms_api_method', 'GET');
        $paramData = json_decode(get_option('sms_api_params', '[]'), true);
        $formData = json_decode(get_option('sms_api_formdata', '[]'), true);
        $headerData = json_decode(get_option('sms_api_header_data', '[]'), true);

        if ($actionMethod == 'GET') {
            $url = $actionUrl . '?' . http_build_query($paramData);
        } else {
            $url = $actionUrl;
        }

        // Replace placeholders in Form Data
        $finalFormData = $this->recursive_array_replace("[[receiver]]", $number, $this->recursive_array_replace("[[message]]", $template, $formData));
        
        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $actionMethod,
            CURLOPT_POSTFIELDS => http_build_query($finalFormData),
            CURLOPT_HTTPHEADER => $headerData,
        ]);

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);

        $successKey = get_option('sms_api_success_key');
        $successVal = get_option('sms_api_success_value');

        // Verify Success
        $isSuccess = false;
        if (!$err) {
            $respData = json_decode($response, true) ?: $response;
            if (is_array($respData)) {
                $isSuccess = ($respData[$successKey] ?? '') == $successVal;
            } else {
                $isSuccess = strpos($response, $successVal) !== false;
            }
        }

        if (!$isSuccess) {
            $updateData = [
                'response' => $err ?: $response,
                'status' => 2, // Failed
            ];
            // Refund balance
            if (!empty($uid)) {
                $this->db->table('users')
                    ->where('id', $uid)
                    ->increment('balance', $charge);
            }
        } else {
            $updateData = [
                'response' => $response,
                'status' => 1, // Sent
            ];
        }

        $this->db->table('user_notifier')->where('id', $insert_id)->update($updateData);

        return $isSuccess;
    }

    public function recursive_array_replace($search, $replace, $array) {
        if (!is_array($array)) {
            return str_replace($search, $replace, $array);
        }
        foreach ($array as $key => $value) {
            $array[$key] = $this->recursive_array_replace($search, $replace, $value);
        }
        return $array;
    }

}

<?php

use App\Models\FileManagerModel;
use Config\Services;

if (!function_exists("current_user")) {
    function current_user($record = '', $id = "")
    {
        if (empty($id)) {
            $id = session('uid');
        }

        $userModel = new FileManagerModel();
        $user = $userModel->get("*", 'users', ['id' => $id]);

        if (!empty($user)) {
            if (!empty($record)) {
                if (property_exists($user, $record)) {
                    return $user->$record;
                }
                return null;
            }
            return $user;
        }
        return null;
    }
}

if (!function_exists("fetch_user")) {
    function fetch_user($condition = [])
    {
        // Initialize the cache service
        $cache = \Config\Services::cache();

        if (empty($id)) {
            $id = session('uid');
        }

        // Check if the user data exists in cache
        $cacheKey = 'user_fetchs' . $id;
        if ($cachedData = $cache->get($cacheKey)) {
            $user = $cachedData;
        } else {
            $userModel = new FileManagerModel();
            $user = $userModel->fetch("*", 'users', $condition);
            // $cache->save($cacheKey, $user, 3600);
        }

        if (!empty($user)) {
            return $user;
        }
        return null;
    }
}
if (!function_exists("fetch_plan")) {
    function fetch_plan($condition = [])
    {
        // Initialize the cache service
        $cache = \Config\Services::cache();

        // Check if the user data exists in cache
        $cacheKey = 'plan_fetch';
        if ($cachedData = $cache->get($cacheKey)) {
            $user = $cachedData;
        } else {
            $userModel = new FileManagerModel();
            $user = $userModel->fetch("*", 'plans', $condition);
            $cache->save($cacheKey, $user, 3600);
        }

        if (!empty($user)) {
            return $user;
        }
        return null;
    }
}


if (!function_exists('get_active_plan')) {
    function get_active_plan($uid = '')
    {
        $uid = !empty($uid) ? $uid : session('uid');
        $userModel = new FileManagerModel();
        $plan = $userModel->get("*", 'user_plans', ['uid' => $uid], 'id');
        if (!empty($plan) && !hasExpired($plan->expire)) {
            return $plan;
        }
        return false;
    }
}
if (!function_exists('get_expirydate_plan')) {
    function get_expirydate_plan($id)
    {
        $userModel = new FileManagerModel();
        $plan = $userModel->get('id,expire', 'user_plans', ["plan_id" => $id, 'uid' => session('uid')], "id");
        return time_format($plan->expire);
    }
}

if (!function_exists('time_format')) {
    function time_format($dateTime)
    {
        $date = new DateTime($dateTime);
        return $date->format('j F, Y H:i:s A');
    }
}


if (!function_exists('deviceValidation')) {
    function deviceValidation($device_key, $uid = '')
    {
        if (empty($uid)) {
            $uid = session('uid');
        }
        if (!get_active_plan($uid)) {
            return false;
        }

        $userModel = new FileManagerModel();
        $available = 0;
        $plan = get_active_plan($uid);
        $devices = $userModel->fetch('*', 'devices', ['uid' => $uid], '', '', '', '', true);
        $active_device_list = [];

        $currentDate = time();

        $startDate = strtotime($plan->created_at);
        $endDate = strtotime($plan->expire);
        if ($plan->device == '-1') {
            return true;
        }

        for ($i = 0; $i < $plan->device; $i++) {
            if (!empty($devices[$i])) {
                $active_device_list[] = $devices[$i]['device_key'];
            }
        }
        $index = array_search($device_key, $active_device_list);
        if ($index !== false) {
            return true;
        }
        return false;
    }
}


if (!function_exists('brandValidation')) {
    function brandValidation($brand_key)
    {
        $userModel = new FileManagerModel();
        $user_brand = $userModel->get('uid,brand_key,id', 'brands', ['brand_key' => $brand_key]);
        if (empty($user_brand->uid)) {
            return;
        }
        if (!get_active_plan($user_brand->uid)) {
            return;
        }

        $available = 0;
        $plan = get_active_plan($user_brand->uid);
        $brands = $userModel->fetch('*', 'brands', ['uid' => $user_brand->uid], '', '', '', '', true);
        $active_brand_list = [];

        $currentDate = time();

        $startDate = strtotime($plan->created_at);
        $endDate = strtotime($plan->expire);
        if ($plan->device == '-1') {
            return ['uid' => $user_brand->uid, 'brand_id' => $user_brand->id];
        }

        for ($i = 0; $i < $plan->device; $i++) {
            if (!empty($brands[$i])) {
                $active_brand_list[] = $brands[$i]['brand_key'];
            }
        }
        $index = array_search($brand_key, $active_brand_list);
        if ($index !== false) {
            return ['uid' => $user_brand->uid, 'brand_id' => $user_brand->id];
        }
        return;
    }
}

function isJson($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}
function payment_option($method = '', $option = 'logo')
{
    $userModel = new FileManagerModel();
    $gateway = $userModel->get('*', 'payments', ['type' => $method])->params;
    $opt = get_value($gateway, 'option');
    return get_value($opt, $option);
}


if (!function_exists('get_character_map')) {
    function get_character_map()
    {
        return array(
            'a' => 'k', 'A' => 'K',
            'b' => 'l', 'B' => 'L',
            'c' => 'm', 'C' => 'M',
            'd' => 'n', 'D' => 'N',
            'e' => 'o', 'E' => 'O',
            'f' => 'p', 'F' => 'P',
            'g' => 'q', 'G' => 'Q',
            'h' => 'r', 'H' => 'R',
            'i' => 's', 'I' => 'S',
            'j' => 't', 'J' => 'T',
            'k' => 'u', 'K' => 'U',
            'l' => 'v', 'L' => 'V',
            'm' => 'w', 'M' => 'W',
            'n' => 'x', 'N' => 'X',
            'o' => 'y', 'O' => 'Y',
            'p' => 'z', 'P' => 'Z',
            'q' => 'a', 'Q' => 'A',
            'r' => 'b', 'R' => 'B',
            's' => 'c', 'S' => 'C',
            't' => 'd', 'T' => 'D',
            'u' => 'e', 'U' => 'E',
            'v' => 'f', 'V' => 'F',
            'w' => 'g', 'W' => 'G',
            'x' => 'h', 'X' => 'H',
            'y' => 'i', 'Y' => 'I',
            'z' => 'j', 'Z' => 'J',
        );
    }
}

if (!function_exists('encrypt')) {
    function encrypt($data)
    {
        $character_map = get_character_map();
        return strtr($data, $character_map);
    }
}

if (!function_exists('decrypt')) {
    function decrypt($data)
    {
        $character_map = get_character_map();
        $character_map_reverse = array_flip($character_map);
        return strtr($data, $character_map_reverse);
    }
}

if (!function_exists('amount_format')) {
    function amount_format($value)
    {
        return number_format($value, 2, '.', ',');
    }
}
if (!function_exists('url_modifier')) {
    function url_modifier($user_input_url, $additional_params)
    {
        if (filter_var($user_input_url, FILTER_VALIDATE_URL)) {
            $url_components = parse_url($user_input_url);
            $path = isset($url_components['path']) ? $url_components['path'] : '';
            $query = isset($url_components['query']) ? $url_components['query'] : '';

            parse_str($query, $existing_query_array);
            $new_query_params = array_merge($existing_query_array, $additional_params);
            $new_query = http_build_query($new_query_params);

            $modified_url = $url_components['scheme'] . '://' . $url_components['host'] . $path;
            if (!empty($new_query)) {
                $modified_url .= '?' . $new_query;
            }
            return $modified_url;
        } else {
            return $user_input_url;
        }
    }
}

if (!function_exists('simple_post')) {
    function simple_post($url, $data)
    {
        $headers = array(
            'Content-Type: application/x-www-form-urlencoded',
        );
        $curl = curl_init();
        $data = http_build_query($data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

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

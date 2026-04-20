<?php

use Config\App_config;

if (!function_exists('get_option')) {
    function get_option(string $key, string $value = ''): string
    {
        // check data from $GLOBALS
        if (isset($GLOBALS['app_settings'][$key])) {
            return $GLOBALS['app_settings'][$key];
        }

        $db = db_connect();
        $result = $db->table('options')->select('value')->where('name', $key)->get()->getRow();

        if (empty($result)) {
            $db->table('options')->insert(['name' => $key, 'value' => $value]);
            return $value;
        } else {
            return $result->value;
        }
    }
}

if (!function_exists("update_option")) {
    function update_option($key, $value)
    {
        $db = db_connect();
        $result = $db->table('options')->select('value')->where('name', $key)->get()->getRow();

        if (empty($result)) {
            $db->table('options')->insert(['name' => $key, 'value' => $value]);
        } else {
            $db->table('options')->where('name', $key)->update(['value' => $value]);
        }
    }
}



if (!function_exists('app_config')) {
    function app_config($key)
    {
        return config('App_config')->$key;
    }
}


function tz_list()
{
    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    $utcTime = new DateTime('now', new DateTimeZone('UTC'));

    $tempTimezones = array();
    foreach ($timezoneIdentifiers as $timezoneIdentifier) {
        $currentTimezone = new DateTimeZone($timezoneIdentifier);

        $tempTimezones[] = array(
            'offset' => (int) $currentTimezone->getOffset($utcTime),
            'identifier' => $timezoneIdentifier,
        );
    }

    // Sort the array by offset, identifier ascending
    usort($tempTimezones, function ($a, $b) {
        return ($a['offset'] == $b['offset'])
            ? strcmp($a['identifier'], $b['identifier'])
            : $a['offset'] - $b['offset'];
    });

    $timezoneList = array();
    foreach ($tempTimezones as $key => $tz) {
        $sign = ($tz['offset'] > 0) ? '+' : '-';
        $offset = gmdate('H:i', abs($tz['offset']));
        $timezoneList[$key]['time'] = '(UTC ' . $sign . $offset . ') ' . $tz['identifier'];
        $timezoneList[$key]['zone'] = $tz['identifier'];
    }
    return $timezoneList;
}

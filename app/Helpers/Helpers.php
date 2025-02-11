<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/*
if (!function_exists('funName')) {
    function funName()
    {
        return '';
    }
}
*/

if (!function_exists('static_asset')) {

    function static_asset($path = null, $secure = null)
    {
        return app('url')->asset('assets/'.$path, $secure);

        // if (strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC')) :
        //     return app('url')->asset($path, $secure);
        // else:
        //     return app('url')->asset($GLOBALS['prefix'] . $path, $secure);
        // endif;
    }
}

if (!function_exists('get_setting')) {

    function get_setting($setting_for)
    {
        return Config::get('setting.' . $setting_for);
    }
}
if (!function_exists('formatBytes')) {

    function formatBytes($size, $precision = 2)
    {
        $base = log($size, 1024);
        $suffixes = array('B', 'KB', 'MB', 'GB', 'TB');

        return round(pow(1024, $base - floor($base)), $precision) . ' ' . $suffixes[floor($base)];
    }
}
if (!function_exists('getImage')) {

    function getImage($image)
    {
        if($image){
            return '/storage/images/'.$image;
        }else{
            return '/assets/images/icon/document-light.png';
        }
    }
}
if (!function_exists('getFile')) {

    function getFile($image)
    {
        return '/storage/media/'.$image;
    }
}
if (!function_exists('showDate')) {
    function showDate($date)
    {
        return $date ? Carbon::parse($date)->format('d M Y') : '';
    }
}
if (!function_exists('showDateTime')) {
    function showDateTime($date)
    {
        return $date ? Carbon::parse($date)->format('d M Y, H:i') : '';
    }
}
if (!function_exists('showTime')) {
    function showTime($date)
    {
        return $date ? Carbon::parse($date)->format('H:i') : null;
    }
}

if (!function_exists('parseDate')) {
    function parseDate($isoDate)
    {
        return $isoDate ? Carbon::parse($isoDate)->setTimezone(config('app.timezone')) : null;
    }
}

if (!function_exists('userId')) {
    function userId()
    {
        return auth()->user()->id;
    }
}
if (!function_exists('userInfo')) {
    function userInfo()
    {
        $user = auth()->user();
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }
}


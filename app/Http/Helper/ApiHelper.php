<?php

namespace App\Http\Helper;

class ApiHelper
{
    protected static $baseUrl;

    public static function init()
    {
        self::$baseUrl = "http://192.168.100.104:3001/api";
    }

    public static function baseUrl()
    {
        if (!self::$baseUrl) {
            self::init();
        }

        return self::$baseUrl;
    }

    public static function apiUrl($path)
    {
        return self::baseUrl() . '/' . ltrim($path, '/');
    }
}

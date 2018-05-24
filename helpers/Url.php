<?php

namespace helpers;

class Url
{
    const PREFIX_ROUTE = '/?r=';
    const AMPERSAND = '&';

    public static function to($route, $paramsArray = [])
    {
        $params = null;
        if ($paramsArray) {
            $params = self::paramsToString($paramsArray);
        }
        return self::PREFIX_ROUTE . $route . $params;
    }

    public static function redirect($route, $paramsArray = [])
    {
        $params = null;
        if ($paramsArray) {
            $params = self::paramsToString($paramsArray);
        }
        header('location: ' . self::PREFIX_ROUTE . $route . $params);
    }

    private static function paramsToString($paramsArray)
    {
        $params = self::AMPERSAND;
        foreach ($paramsArray as $key => $param) {
            $params .= $key . '=' . $param . self::AMPERSAND;
        }
        $params = mb_substr($params, 0, -1);

        return $params;
    }
}
<?php

namespace helpers;

class Request
{
    const METHOD_GET = 'get';
    const METHOD_POST = 'post';

    public static function get($paramName = null)
    {
        if (self::hasData($paramName, self::METHOD_GET)) {
            return $_GET[$paramName];
        }

        return null;
    }

    public static function post($paramName = null)
    {
        if (self::hasData($paramName, self::METHOD_POST)) {
            return $_POST[$paramName];
        }

        return $_POST;
    }

    public static function serverName()
    {
        return $_SERVER['SERVER_NAME'];
    }

    private static function hasData($paramName, $method)
    {
        if ($paramName) {
            if ($method === self::METHOD_GET) {
                if (isset($_GET[$paramName])) {
                    return true;
                }
            } else if ($method === self::METHOD_POST) {
                if (isset($_POST[$paramName])) {
                    return true;
                }
            }
        }

        return false;
    }
}
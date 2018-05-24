<?php

namespace app;

class AccessControl
{
    public static $isGuest = true;

    public function __construct()
    {
        session_start();
        if(isset($_SESSION['user'])) {
            self::$isGuest = false;
        }
    }
}
<?php

namespace app\db;

use PDO;
use PDOException;

class Connection
{
    public static $db;

    public $dsn = 'mysql:host=localhost;dbname=test;charset=utf8';
    public $username = 'root';
    public $password;

    public function __construct($config)
    {
        $settings = $config['db'];
        $this->dsn = $settings['dsn'];
        $this->username = $settings['username'];
        $this->password = $settings['password'];
    }

    public function openConnect()
    {
        try {
            self::$db = new PDO($this->dsn, $this->username, $this->password);
            self::$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
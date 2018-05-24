<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);
require('autoload.php');

$config = require(__DIR__ . '/config/main.php');

(new app\Application($config))->run();


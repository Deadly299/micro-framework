<?php

namespace app;

class View
{

    public $folderName;
    public $layout = 'default';
    public $tile;

    public function __construct($folderName)
    {
        $this->folderName = $folderName;
    }

    public function render($action, $params = [])
    {
        extract($params);
        $path = 'views/' . $this->folderName . '/' . $action . '.php';

        if (file_exists($path)) {
            ob_start();
            require $path;
            $content = ob_get_clean();
            require 'views/layouts/' . $this->layout . '.php';
        }
    }

    public function renderPartial($route, $params = [])
    {
        extract($params);
        $path = 'views/' . $route . '.php';
        if (file_exists($path)) {
            require $path;
        }
    }

    public function renderAjax($route, $params = [])
    {
        extract($params);
        $path = 'views/' . $route . '.php';
        if (file_exists($path)) {
            ob_start();
            require $path;
            return $html = ob_get_clean();
        }
    }

    public static function errorCode($code)
    {
        http_response_code($code);
        $path = 'views/errors/' . $code . '.php';
        if (file_exists($path)) {
            require $path;
        }
        exit;
    }

    public function message($status, $message)
    {
        exit(json_encode(['status' => $status, 'message' => $message]));
    }

    public function location($url)
    {
        exit(json_encode(['url' => $url]));
    }

}	
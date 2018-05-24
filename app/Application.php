<?php

namespace app;

use app\db\Connection;
use helpers\Request;

class Application
{
    private $config;
    private $route;

    public function __construct($config)
    {
        $this->config = $config;
        $this->initConnection();
        $this->initRouting();
        new AccessControl();
    }

    private function initRouting()
    {
        if ($r = Request::get('r')) {
            $this->route = $r;
        } else {
            $config = $this->config;
            if(isset($config['basePage'])) {
                $this->route = $config['basePage'];
            }
        }
    }

    public function Run()
    {
        return new Router($this->route);
    }

    private function initConnection()
    {
        $connection = new Connection($this->config);
        $connection->openConnect();
    }
}
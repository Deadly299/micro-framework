<?php

namespace app;

class Router
{
    protected $controller;
    protected $action;
    protected $notFound = true;

    public function __construct($route)
    {
        if ($routeArray = explode('/', $route)) {
            if (count($routeArray) == 2) {
                $this->controller = $routeArray[0];
                $this->action = $routeArray[1];
                $this->notFound = false;
            }
        }

        $this->run();
    }

    public function run()
    {
        if ($this->notFound) {
            return View::errorCode(404);
        }

        $path = 'controllers\\' . ucfirst($this->controller) . 'Controller';
        if (class_exists($path)) {
            $action = 'action' . ucfirst($this->action);
            if (method_exists($path, $action)) {
                $controller = new $path($this->controller);
                return $controller->$action();

            }
        }

        return View::errorCode(404);
    }
}
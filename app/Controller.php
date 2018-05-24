<?php

namespace app;

class Controller
{
    public $view;

    public function __construct($route)
    {
        $this->view = new View($route);
    }
}
<?php

namespace app;


class Widget
{
    const METHOD_RUN = 'run';
    private $_basePath;

    public static function widget($parameters = [])
    {
        $class = get_called_class();
        $object = new $class();
        $object = self::loadParams($object, $parameters);
        $object->run();
    }

    private static function loadParams($object, $paramters)
    {
        foreach ($paramters as $field => $paramter) {
            $object->$field = $paramter;
        }

        return $object;
    }

    public function render($action, $params = [])
    {
        $this->getBasePath();
        extract($params);
        $path = $this->_basePath . '/' . $action . '.php';

        if (file_exists($path)) {
            require $path;
        }
    }

    public function getBasePath()
    {
        if ($this->_basePath === null) {
            $class = new \ReflectionClass($this);
            $this->_basePath = dirname($class->getFileName());
        }

        return $this->_basePath;
    }
}
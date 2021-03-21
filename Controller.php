<?php

namespace alucardthefish\framvcwork;

use alucardthefish\framvcwork\Application;

class Controller 
{

    public $layout = 'main';
    public $action = '';
    /**
     * @var \alucardthefish\framvcwork\middlewares\BaseMiddleware[]
     */
    protected $middlewares = [];

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function render($view, $params = []) {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware($middlewares) {
        $this->middlewares[] = $middlewares;
    }

    public function getMiddlewares() {
        return $this->middlewares;
    }
}

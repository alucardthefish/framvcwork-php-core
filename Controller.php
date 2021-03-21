<?php

namespace app\core;

use app\core\Application;

class Controller 
{

    public $layout = 'main';
    public $action = '';
    /**
     * @var \app\core\middlewares\BaseMiddleware[]
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

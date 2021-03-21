<?php
# **************************************************************************** 
# File: Router.php 
# Author: alucardthefish 
# Created: Sun Feb  7 14:07:00 2021 
# Description: Router class of our framework 
# **************************************************************************** 

namespace alucardthefish\framvcwork;

use alucardthefish\framvcwork\exception\NotFoundException;

class Router
{
    public $request;
    public $response;
    #protected array $routes = [];
    protected $routes = [];

    public function __construct($request, $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback){

        $this->routes['get'][$path] = $callback;

    }

    public function post($path, $callback){

        $this->routes['post'][$path] = $callback;

    }

    public function resolve() {

        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            throw new NotFoundException();
        }

        if (is_string($callback)) {
            
            return $this->renderView($callback);
        }

        if (is_array($callback)) {
            /** @var \alucardthefish\framvcwork\Controller $controller */
            $controller = new $callback[0]();
            Application::$app->controller = $controller;
            $controller->action = $callback[1];
            $callback[0] = $controller;
            foreach ($controller->getMiddlewares() as $middleware) {
                $middleware->execute();
            }
        }

        return call_user_func($callback, $this->request, $this->response);

    }


    public function renderView($view, $params = []) {

        return Application::$app->view->renderView($view, $params);

    }

    public function renderContent($viewContent) {

        return Application::$app->view->renderContent($viewContent);

    }

}

?>


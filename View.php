<?php

namespace alucardthefish\framvcwork;

class View
{
    public $title = '';


    public function renderView($view, $params = []) {

        $viewContent = $this->renderOnlyView($view, $params);
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    public function renderContent($viewContent) {

        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);

    }

    protected function layoutContent() {

        $layout = Application::$app->layout;
        if (Application::$app->controller) {
            $layout = Application::$app->controller->layout;
        }
        
        ob_start();
        include_once Application::$ROOT_DIR . "/views/layouts/$layout.php";
        $layCont = ob_get_contents();
        ob_get_clean();
        return $layCont;
    }

    protected function renderOnlyView($view, $params) {

        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        include_once Application::$ROOT_DIR . "/views/$view.php";
        $onlyView = ob_get_contents();
        ob_get_clean();
        return $onlyView;

    }
}

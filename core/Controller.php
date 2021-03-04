<?php

namespace app\core;

use app\core\Application;
use app\core\lang\en;
use app\core\lang\En_en;
use app\core\lang\Lang;
use app\core\middlewares\BaseMiddleware;

class Controller
{

    public string $layout = 'main';
    public string $action = '';
    public string $id = '';
    public array $params;

    public array $middlewares = [];
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
    protected function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(BaseMiddleware $middleware)
    {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array
    {
        return $this->middlewares;
    }
}

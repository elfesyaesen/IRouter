<?php 
namespace System\IRouter;
class Router {
    private $routes = [];
    private $method;
    private $path;

    public function __construct() {
        spl_autoload_register(function ($class) {
            $base_dir = __DIR__ .'/../../';
             $file =  $base_dir . str_replace('\\', '/', $class ). '.php';
             if (file_exists($file)) { require_once $file; }
         });
         
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }

    public function add($name, $route) {
        $this->routes[$name] = $route;
    }

    public function dispatch() {
        foreach ($this->routes as $route) {
            $routePath = $route[0];
            $routeMethods = $route[3];
            $pattern = $this->convertToPattern($routePath, $route[2]);
            if (preg_match($pattern, $this->path, $matches)) {
                if (in_array($this->method, $routeMethods)) {
                    array_shift($matches);
                    $data = $this->callHandler($route[1], $matches);
                    return;
                } else {
                    http_response_code(405);
                    echo "405 Method Bulunamadı...";
                    return;
                }
            }
        }
        http_response_code(404);
        echo "404 Rota Bulunamadı...";
    }

    private function convertToPattern($path, $parameters) {
        foreach ($parameters as $key => $pattern) {
            $path = str_replace("{" . $key . "}", "(" . $pattern . ")", $path);
        }
        return "#^" . $path . "$#";
    }

    private function callHandler($handler, $params) {
        $controllerName = $handler['controller'];
        $methodName = $handler['method'];

        if (!class_exists($controllerName)) {
            http_response_code(500);
            echo "Controller class '" . $controllerName . "' Bulunamadı...";
            return;
        }

        $controller = new $controllerName;

        if (!method_exists($controller, $methodName)) {
            http_response_code(500);
            echo $controllerName . "' İçinde, '" . $methodName . "' Bulunamadı...";
            return;
        }

        call_user_func_array([$controller, $methodName], $params);
    }
}
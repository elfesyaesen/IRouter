<?php
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

namespace System\IRouter;

use System\Middleware\MiddlewareAlias;

class Router
{
    private static array $routes = [];
    private static string $prefix = '';
    private static array $groupMiddleware = [];

    public static function any(string $name, array $route): Route
    {
        return self::addRoute('ANY', $name, $route);
    }

    public static function get(string $name, array $route): Route
    {
        return self::addRoute('GET', $name, $route);
    }

    public static function post(string $name, array $route): Route
    {
        return self::addRoute('POST', $name, $route);
    }

    private static function addRoute(string $method, string $name, array $route): Route
    {
        $path = self::$prefix . $route[0];
        $routeObj = new \System\IRouter\Route($method, $path, $route[1]);
        $routeObj->setMiddleware(self::$groupMiddleware);
        self::$routes[$name] = $routeObj;
        return $routeObj;
    }

    public static function prefix(string $prefix): self
    {
        $newRouter = new self();
        self::$prefix .= $prefix;
        return $newRouter;
    }

    public static function group(callable $callback): void
    {
        $oldPrefix = self::$prefix;
        $oldGroupMiddleware = self::$groupMiddleware;

        $callback();

        self::$prefix = $oldPrefix;
        self::$groupMiddleware = $oldGroupMiddleware;
    }

    public static function middleware(array $middleware): self
    {
        $newRouter = new self();
        self::$groupMiddleware = array_merge(self::$groupMiddleware, $middleware);
        return $newRouter;
    }

    public static function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    
        foreach (self::$routes as $route) {
            if ($route->match($requestMethod, $requestUri)) {
                try {
                    $route->executeMiddleware();
                    $route->execute();
                    return; // İşlem tamamlandıktan sonra fonksiyondan çık
                } catch (\Exception $e) {
                    http_response_code($e->getCode() ?: 500);
                    echo $e->getMessage();
                    return; // Hata durumunda da fonksiyondan çık
                }
            }
        }
    
        http_response_code(404);
        echo $requestUri . ": 404 Bulunamadı...";
    }
}
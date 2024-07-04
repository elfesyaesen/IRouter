<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

namespace System\IRouter;

class Router
{
    private static array $routes = [];
    private static string $currentPrefix = '';
    private static array $currentMiddleware = [];

    public static function prefix(string $prefix): self
    {
        self::$currentPrefix = '/' . trim($prefix, '/');
        return new static;
    }

    public static function middleware(array $middleware): self
    {
        self::$currentMiddleware = array_merge(self::$currentMiddleware, $middleware);

        
        return new static;
    }

    public static function group(array $routes): void
    {
        foreach ($routes as $route) {
            if ($route instanceof \System\IRouter\Route) {
                $route->setPrefix(self::$currentPrefix);
                $route->addMiddleware(self::$currentMiddleware);
            }
        }

        self::$currentPrefix = '';
        self::$currentMiddleware = [];
    }

    public static function get(string $name, array $route): Route
    {
        return self::addRoute('GET', $name, $route);
    }

    public static function post(string $name, array $route): Route
    {
        return self::addRoute('POST', $name, $route);
    }

    public static function any(string $name, array $route): Route
    {
        return self::addRoute('GET|POST', $name, $route);
    }

    private static function addRoute(string $methods, string $name, array $route): Route
    {
        [$path, $handler] = $route;
        $path = rtrim(self::$currentPrefix, '/') . '/' . ltrim($path, '/');
        $route = new Route($methods, $name, $path, $handler, self::$currentMiddleware);
        self::$routes[$name] = $route;
        return $route;
    }

    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        foreach (self::$routes as $name => $route) {
            if ($route->match($method, $uri)) {
                try {
                    $route->runMiddleware();
                    $route->call();
                    return;
                } catch (\Exception $e) {
                    http_response_code($e->getCode() ?: 500);
                    echo $e->getMessage();
                    return;
                }
            } elseif ($route->matchUri($uri)) {
                throw new \Exception("405 Metod bulunamadı: $method Bu method rotaya tanımlı değil. rota :  $uri.", 405);
                return;
            }
        }

        http_response_code(404);
        echo "404 $uri Bu rota bulunamadı...";
    }
}

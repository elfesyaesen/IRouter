<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

namespace System\IRouter;

class Route
{
    private array $methods;
    private string $name;
    private string $path;
    private array $handler;
    private array $middleware;
    private array $params = [];

    public function __construct(string $methods, string $name, string $path, array $handler, array $middleware = [])
    {
        $this->methods = explode('|', $methods);
        $this->name = $name;
        $this->path = $path;
        $this->handler = $handler;
        $this->middleware = $middleware;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function setPrefix(string $prefix): void
    {
       $this->path = '/' . ltrim($this->path, '/');
    }

    public function addMiddleware(array $middleware): void
    {
        $this->middleware = array_merge($this->middleware, $middleware);
    }

    public function params(array $params): self
    {
        $this->params = $params;
        return $this;
    }

    public function middleware(array $middleware): self
    {
        $this->middleware = array_merge($this->middleware, $middleware);
        return $this;
    }

    public function match(string $method, string $uri): bool
    {

        if (!in_array($method, $this->methods)) {
            return false;
        }

        $pattern = $this->getPattern();
        $result = preg_match($pattern, $uri, $matches);
        if ($result) {
            array_shift($matches);
            $this->params = array_combine(array_keys($this->params), $matches);
        }
        return $result;
    }

    public function matchUri(string $uri): bool
    {
        $pattern = $this->getPattern();
        return preg_match($pattern, $uri);
    }

    private function getPattern(): string
    {
        $path = preg_replace('/\/+/', '/', $this->path);
        foreach ($this->params as $key => $value) {
            $path = str_replace("{" . $key . "}", "($value)", $path);
        }
        return "#^" . $path . "$#";
    }

    public function runMiddleware(): void
    {
        foreach ($this->middleware as $middleware) {
            \System\Middleware\MiddlewareAlias::run($middleware);
        }
    }

    public function call(): void
    {
        [$controller, $method] = $this->handler;
        if (!class_exists($controller)) {
            throw new \Exception("Controller not found: $controller", 500);
        }
        $instance = new $controller();
        if (!method_exists($instance, $method)) {
            throw new \Exception("Method not found: $method in $controller", 500);
        }
        call_user_func_array([$instance, $method], array_values($this->params));
    }
}

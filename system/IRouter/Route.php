<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

namespace System\IRouter;

class Route
{
    private string $method;
    private string $path;
    private array $handler;
    private array $params = [];
    private array $middleware = [];

    public function __construct(string $method, string $path, array $handler)
    {
        $this->method = $method;
        $this->path = $path;
        $this->handler = $handler;
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

    public function setMiddleware(array $middleware): void
    {
        $this->middleware = array_merge($this->middleware, $middleware);
    }

    public function match(string $method, string $uri): bool
    {
        if ($this->method !== 'ANY' && $this->method !== $method) {
            return false;
        }

        $pattern = $this->getPattern();
        return preg_match($pattern, $uri, $this->params) === 1;
    }

    private function getPattern(): string
    {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '(?P<$1>[^/]+)', $this->path);
        foreach ($this->params as $param => $regex) {
            $pattern = str_replace("(?P<$param>[^/]+)", "(?P<$param>$regex)", $pattern);
        }
        return '#^' . $pattern . '$#';
    }

    public function executeMiddleware(): void
    {
        foreach ($this->middleware as $middleware) {
            \System\Middleware\MiddlewareAlias::run($middleware);
        }
    }

    public function execute(): void
    {
        $controller = new $this->handler[0]();
        $method = $this->handler[1];
        
        // URL'den parametreleri çıkar
        $args = array_filter($this->params, 'is_string', ARRAY_FILTER_USE_KEY);
        
        // Parametreleri controller metoduna geçir
        call_user_func_array([$controller, $method], $args);
    }
}
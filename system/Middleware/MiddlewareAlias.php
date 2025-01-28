<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@elfesyaesen
*/

namespace System\Middleware;

class MiddlewareAlias
{
    private static array $middlewareMap = [
        'role' => RoleMiddleware::class,
        'permission' => PermissionMiddleware::class,
        // Diğer middleware'leri burada tanımlayabilirsiniz
    ];

    public static function run(string $middleware): void
    {
        [$name, $parameter] = array_pad(explode(':', $middleware, 2), 2, null);
        if (isset(self::$middlewareMap[$name])) {
            $middlewareClass = self::$middlewareMap[$name];
            if (class_exists($middlewareClass)) {
                $instance = new $middlewareClass();
                if ($instance instanceof \System\Middleware\MiddlewareInterface) {
                    $instance->handle($parameter);
                } else {
                    throw new \Exception("Middleware $name, MiddlewareInterface arayüzünü uygulamıyor");
                }
            } else {
                throw new \Exception("Middleware sınıfı $middlewareClass bulunamadı");
            }
        } else {
            throw new \Exception("Middleware $name middleware haritasında bulunamadı");
        }
    }
}

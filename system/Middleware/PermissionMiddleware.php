<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

namespace System\Middleware;

class PermissionMiddleware implements MiddlewareInterface
{
    public function handle(?string $parameter): void
    {
        // if (!isset($_SESSION['user_permission']) || empty($_SESSION['user_permission']) || $_SESSION['user_permission'] != $parameter) {
        //     throw new \Exception($parameter . ' : Yetkisine Sahip Değilsiniz...', 403);
        // }
    }
}
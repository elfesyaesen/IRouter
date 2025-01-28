<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@elfesyaesen
*/

namespace System\Middleware;

class RoleMiddleware implements MiddlewareInterface
{
    public function handle(?string $parameter):void
    {
        if (!isset($_SESSION["user_role"])) {

        } else {
            throw new \Exception($parameter . ': Rolune sahip değilsiniz...', 403);
        }        
    }
}
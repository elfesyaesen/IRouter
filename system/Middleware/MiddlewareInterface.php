<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

namespace System\Middleware;

interface MiddlewareInterface
{
    public function handle(?string $parameter): void;
}
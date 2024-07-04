<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

namespace System\IRouter;

use RuntimeException;

final class Autoloader
{
    private const BASE_DIR = __DIR__ . '/../../';

    public static function register(): void
    {
        spl_autoload_register(self::loadClass(...), true, true);
    }

    private static function loadClass(string $class): void
    {
        $file = self::getFilePath($class);

        if (file_exists($file)) {
            require_once $file;
        } else {
            throw new RuntimeException("Unable to load class: $class");
        }
    }

    private static function getFilePath(string $class): string
    {
        return self::BASE_DIR . str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    }
}
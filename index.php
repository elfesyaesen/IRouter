<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/
require_once __DIR__ . '/system/IRouter/Autoloader.php';
require_once __DIR__ . '/system/IRouter/Router.php';

// Kullandığınız Class ları otomatik olarak yükler
\System\IRouter\Autoloader::register();

// index.php
use System\IRouter\Router;

Router::get('catalog', ['/', ['Catalog\Controller\HomeController', 'index']]);

Router::get('catalog-product', ['/product/{id}', ['Catalog\Controller\ProductController', 'show']])
    ->params(['id' => '[0-9]+'])
    ->middleware(['permission:product-edit']);
    
Router::prefix('/api')->group(function() {
    Router::get('users', ['/users', ['Catalog\Controller\UserController', 'index']]);

    Router::get('user', ['/user/{id}', ['Catalog\Controller\UserController', 'show']])
        ->params(['id' => '[0-9]+']);
    
    Router::prefix('/admin')->group(function() {
        Router::get('dashboard', ['/dashboard', ['Catalog\Controller\DashboardController', 'index']])
            ->middleware(['role:admin']);
    });
});

Router::dispatch();
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

// düz rota kullanımı
Router::any('catalog', ['/', ['Admin\Controller\HomeController', 'index']]);
Router::get('catalog-product', ['/product/{id}', ['Catalog\Controller\ProductController', 'show']])
        ->params(['id' => '[0-9]+']);
Router::get('catalog-products', ['/products', ['Catalog\Controller\ProductController', 'index']]);

// grup kullanımı
Router::prefix('/admin')
        ->middleware(['role:admin'])
        ->group(function() {
            Router::get('users', ['/users', ['Catalog\Controller\UserController', 'index']]);
            Router::get('user', ['/user/{id}', ['Catalog\Controller\UserController', 'show']])
                    ->params(['id' => '[0-9]+'])
                    ->middleware(['permission:user-edit']);

            //iç içe grup kullanımı
            Router::prefix('/api')
                    ->group(function(){
                        Router::get('products', ['/products', ['Catalog\Controller\ProductController', 'index']])
                        ->middleware(['permission:user-edit']);
            });
});

Router::dispatch();
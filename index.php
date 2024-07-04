<?php 
/*
    Paket adı : IRouter 
    Geliştirici : Elfesya ESEN
    Youtube Kanalı : https://www.youtube.com/@software-developers
*/

require_once __DIR__ . '/system/IRouter/Router.php';
require_once __DIR__ . '/system/IRouter/Autoloader.php';
// Kullandığınız Class ları otomatik olarak yükler
\System\IRouter\Autoloader::register();

//rota sistemi
use System\IRouter\Router;

Router::get('home', ['/', ['Catalog\Controller\HomeController', 'index']])->middleware(["role:admin"]);
Router::get('catalog-products', ['/products', ['Catalog\Controller\ProductController', 'index']]);
Router::get('catalog-product', ['/product/{id}', ['Catalog\Controller\ProductController', 'show']])
    ->params(['id' => '[0-9]+'])
    ->middleware(['permission:product-edit']);

Router::dispatch();
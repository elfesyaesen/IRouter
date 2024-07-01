<?php
require_once __DIR__ . '/system/Router/Router.php';

$router = new \System\IRouter\Router();

$router->add('catalog-index',
    array('/',
    ['controller' => 'Controller\HomeController', 'method' => 'index'],
    [],
    ['GET'])
);
$router->add('catalog-product',
    array('/product/{id}',
    ['controller' => 'Controller\ProductController', 'method' => 'show'],
    ['id' => '[0-9]+'],
    ['GET', 'POST'])
);

$router->dispatch();

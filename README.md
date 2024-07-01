# PHP Routing System

**IRouter** is a simple yet powerful routing system for managing your application's routes with ease.

## Installation

First, clone the repository and include the router in your project:

```php
require_once __DIR__ . '/system/Router/Router.php';

$router = new \System\IRouter\Router();

```php
// Adding a route for the home page
$router->add('catalog-index', // Name of the route for easy identification
    array('/', // URL pattern
    ['controller' => 'Controller\HomeController', 'method' => 'index'], // Controller and method to execute
    [], // Parameters if any
    ['GET']) // Allowed HTTP methods
);

// Adding a route for a product page with an ID parameter
$router->add('catalog-product',
    array('/product/{id}', // URL pattern with a parameter
    ['controller' => 'Controller\ProductController', 'method' => 'show'], // Controller and method to execute
    ['id' => '[0-9]+'], // Parameter pattern
    ['GET', 'POST']) // Allowed HTTP methods
);

// Dispatch the request
$router->dispatch();

Features
Easy Route Management: Easily define and manage routes with names for quick identification.
Parameter Handling: Support for URL parameters with validation.
HTTP Methods: Specify which HTTP methods (GET, POST, etc.) are accepted for each route.

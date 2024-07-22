# PHP Rota Sistemi

**IRouter**, uygulamanızın rotalarını kolaylıkla yönetmek için basit ama güçlü bir yönlendirme sistemidir.

- [Youtube Kanalım](https://www.youtube.com/@software-developers).

## Kurulum

İlk olarak, depoyu klonlayın ve projeye yönlendiriciyi dahil edin:

```php
require_once __DIR__ . '/system/IRouter/Router.php';
require_once __DIR__ . '/system/IRouter/Autoloader.php';
```
## Kullanım

```php

// Kullandığınız Class ları otomatik olarak yükler
\System\IRouter\Autoloader::register();

use System\IRouter\Router;

// düz rota kullanımı
Router::any('catalog', ['/', ['Catalog\Controller\HomeController', 'index']]);

Router::get('catalog-product', ['/product/{id}', ['Catalog\Controller\ProductController', 'show']])
        ->params(['id' => '[0-9]+']);
Router::get('catalog-products', ['/products', ['Catalog\Controller\ProductController', 'index']]);

// grup kullanımı
Router::prefix('/admin')
        ->middleware(['role:admin'])
        ->group(function () {
                Router::get('users', ['/users', ['Catalog\Controller\UserController', 'index']]);
                Router::get('user', ['/user/{id}', ['Catalog\Controller\UserController', 'show']])
                        ->params(['id' => '[0-9]+'])
                        ->middleware(['permission:user-edit']);

                //iç içe grup kullanımı
                Router::prefix('/api')
                        ->group(function () {
                                Router::get('products', ['/products', ['Catalog\Controller\ProductController', 'index']])
                                        ->middleware(['permission:user-edit']);
                        });
        });

Router::dispatch();
```

## Projeyi Başlatma
```php
    php -S 127.0.0.1:8000
```
## Özellikler
- **Kolay Rota Yönetimi**: Rotaları kolayca tanımlayın ve hızlı tanımlama için isimlendirin.
- **Parametre İşleme**: Parametre doğrulama ile URL parametrelerini destekler.
- **HTTP Metodları**: Her rota için kabul edilen HTTP metodlarını (GET, POST vb.) belirleyin.
- Katkıda Bulunun
Katkılarınızı bekliyoruz! Lütfen depoyu fork'layın ve herhangi bir iyileştirme veya hata düzeltmesi için pull request gönderin.

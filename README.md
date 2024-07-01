# PHP Rota Sistemi

**IRouter**, uygulamanızın rotalarını kolaylıkla yönetmek için basit ama güçlü bir yönlendirme sistemidir.

- [Youtube Kanalım]([https://www.youtube.com/@software-developers]).

## Kurulum

İlk olarak, depoyu klonlayın ve projeye yönlendiriciyi dahil edin:

```php
require_once __DIR__ . '/system/Router/Router.php';
```
## Kullanım

```php
$router = new \System\IRouter\Router();

// Ana sayfa için bir rota eklemek
$router->add('catalog-index', // Kolay tanımlama için rotaya isim verelim
    array('/', // URL deseni
    ['controller' => 'Controller\HomeController', 'method' => 'index'], // Çalıştırılacak controller ve metod
    [], // Varsa parametreler
    ['GET']) // Kabul edilen HTTP metodları
);

// ID parametresi içeren bir ürün sayfası rotası eklemek
$router->add('catalog-product',
    array('/product/{id}', // Parametre içeren URL deseni
    ['controller' => 'Controller\ProductController', 'method' => 'show'], // Çalıştırılacak controller ve metod
    ['id' => '[0-9]+'], // Parametre deseni
    ['GET', 'POST']) // Kabul edilen HTTP metodları
);

// İsteği yönlendir
$router->dispatch();
```
## Özellikler
- **Kolay Rota Yönetimi**: Rotaları kolayca tanımlayın ve hızlı tanımlama için isimlendirin.
- **Parametre İşleme**: Parametre doğrulama ile URL parametrelerini destekler.
- **HTTP Metodları**: Her rota için kabul edilen HTTP metodlarını (GET, POST vb.) belirleyin.
- Katkıda Bulunun
Katkılarınızı bekliyoruz! Lütfen depoyu fork'layın ve herhangi bir iyileştirme veya hata düzeltmesi için pull request gönderin.

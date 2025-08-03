# OrderController Kullanımı

## Genel Bakış
**OrderController** sınıfı, kullanıcının siparişlerini yönetmesini sağlar. Kullanıcı siparişlerini listeleyebilir ve sipariş detaylarını görüntüleyebilir.

---
## Sınıf Tanımı
```php
namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\OrderModel;
```
Bu sınıf `BaseController` sınıfından türemiştir ve `OrderModel` modelini kullanarak sipariş verilerini yönetir.

---
## Yapıcı Metot
```php
public function __construct()
{
    parent::__construct();
    $this->orderModel = new OrderModel();
}
```
Bu metot `OrderModel` sınıfının bir örneğini oluşturur ve denetleyicinin başlatılması sırasında kullanılmasını sağlar.

---
## Kullanıcının Siparişlerini Listeleme

### Açıklama
`index()` metodu, giriş yapmış kullanıcının tüm siparişlerini listeler. Eğer kullanıcı giriş yapmamışsa, onu login sayfasına yönlendirir.

### Kullanımı
```php
public function index()
{
    $userId = $this->userId;
    if ($userId) {
        $currentUrl = $_SERVER['REQUEST_URI'];
        $orders = $this->orderModel->getOrdersByUserId($userId);
        $this->render('front/auth/order', [
            'orders' => $orders,
            'currentUrl' => $currentUrl
        ]);
    } else {
        header('Location: /login');
    }
}
```
**İşleyiş:**
- Kullanıcının oturum bilgileri `BaseController` sınıfından alınır.
- Eğer kullanıcı giriş yapmışsa, kullanıcının siparişleri `OrderModel` kullanılarak veritabanından çekilir.
- Elde edilen siparişler `front/auth/order` görünümüne aktarılır.
- Eğer kullanıcı giriş yapmamışsa `/login` sayfasına yönlendirilir.

---
## Sipariş Detaylarını Getirme

### Açıklama
Belirtilen siparişin detaylarını JSON formatında döndürür. Eğer kullanıcı giriş yapmamışsa login sayfasına yönlendirir.

### Kullanımı
```php
public function detail($orderId)
{
    $userId = $this->userId;
    if ($userId) {
        $order = $this->orderModel->getOrderById($orderId);
        $orderItems = $this->orderModel->getOrderItemsByOrderId($orderId);
        $orderAddress = $this->orderModel->getOrderAddressByOrderId($orderId);
        header('Content-Type: application/json');
        echo json_encode(['status' => $order['status'], 'items' => $orderItems, 'address' => $orderAddress]);
    } else {
        header('Location: /login');
    }
}
```

**İşleyiş:**
- Kullanıcının oturum bilgileri kontrol edilir.
- Kullanıcı giriş yapmışsa:
  - `OrderModel` üzerinden sipariş bilgileri, siparişe ait öğeler ve sipariş adresi çekilir.
  - JSON formatında bir yanıt döndürülerek siparişin durumu, öğeleri ve adres bilgisi istemciye iletilir.
- Eğer kullanıcı giriş yapmamışsa, `/login` sayfasına yönlendirilir.

---
## Özet
`OrderController`, kullanıcının siparişlerini yönetmesini sağlayan bir denetleyicidir. Kullanıcı giriş yaptığında siparişlerini görüntüleyebilir ve detaylarını JSON formatında alabilir. Giriş yapmamış kullanıcılar login sayfasına yönlendirilir.

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\OrderModel;

class OrderController extends BaseController
{
    /**
     * @var OrderModel $orderModel Order model örneği
     */
    private $orderModel;

    /**
     * OrderController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve OrderModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
    }

    /**
     * Kullanıcının siparişlerini listeler.
     * Eğer kullanıcı giriş yapmamışsa login sayfasına yönlendirir.
     */
    public function index()
    {
        // BaseController'dan miras alınan userId değişkenini kullan
        $userId = $this->userId;
        if ($userId) {
            $currentUrl = $_SERVER['REQUEST_URI'];
            $orders = $this->orderModel->getOrdersByUserId($userId);
            $this->render('front/auth/order', [
                'orders' => $orders,
                'currentUrl' => $currentUrl
            ]);
        } else {
            header('Location: /login');
        }
    }

    /**
     * Belirtilen siparişin detaylarını JSON formatında döner.
     * Eğer kullanıcı giriş yapmamışsa login sayfasına yönlendirir.
     *
     * @param int $orderId Sipariş ID'si
     */
    public function detail($orderId)
    {
        // BaseController'dan miras alınan userId değişkenini kullan
        $userId = $this->userId;
        if ($userId) {
            $order = $this->orderModel->getOrderById($orderId);
            $orderItems = $this->orderModel->getOrderItemsByOrderId($orderId);
            $orderAddress = $this->orderModel->getOrderAddressByOrderId($orderId);
            header('Content-Type: application/json');
            echo json_encode(['status' => $order['status'], 'items' => $orderItems, 'address' => $orderAddress]);
        } else {
            header('Location: /login');
        }
    }
}

```
---


# Sipariş Yönetimi Dokümantasyonu

Bu doküman, **OrderController** sınıfının işleyişini, siparişlerin nasıl yönetildiğini ve kodun detaylarını açıklamaktadır.

## OrderController Nedir?

`OrderController`, yönetici panelinde siparişleri yönetmek için oluşturulmuş bir denetleyicidir. Siparişleri listeleme, sipariş detaylarını görüntüleme ve sipariş durumlarını güncelleme gibi işlemleri içerir.

## OrderController Sınıfı

```php
namespace App\Controllers\Admin;

use App\Models\OrderModel;
use App\Core\BaseController;

class OrderController extends BaseController
{
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
    }
```

### Siparişleri Listeleme (index)

Bu metod, tüm siparişleri getirir ve her sipariş için kullanıcı adını ekler.

```php
    public function index()
    {
        $orders = $this->orderModel->getAllOrders();

        foreach ($orders as &$order) {
            $user = $this->orderModel->getUserById($order['user_id']);
            $order['user_name'] = $user['name'];
        }

        if (empty($orders)) {
            $orders = [];
        }

        $this->renderAdmin(
            'admin/order/index',
            ['orders' => $orders]
        );
    }
```

**Açıklama:**
- `getAllOrders()` metodu, veritabanından tüm siparişleri çeker.
- Döngü kullanılarak her sipariş için kullanıcı bilgisi çekilir.
- Eğer sipariş bulunamazsa, boş bir dizi atanır.
- Son olarak `renderAdmin()` metodu ile siparişler **admin panelinde** görüntülenmek üzere gönderilir.

### Sipariş Detaylarını Görüntüleme (detail)

Bir siparişin detaylarını almak için kullanılan metottur.

```php
    public function detail($orderId)
    {
        $order = $this->orderModel->getOrderById($orderId);
        $items = $this->orderModel->getOrderItemsByOrderId($orderId);
        $address = $this->orderModel->getOrderAddressByOrderId($orderId);

        echo json_encode([
            'order' => $order,
            'items' => $items,
            'address' => $address
        ]);
    }
```

**Açıklama:**
- `getOrderById($orderId)`: Belirtilen sipariş ID'sine sahip siparişi getirir.
- `getOrderItemsByOrderId($orderId)`: Siparişe ait ürünleri getirir.
- `getOrderAddressByOrderId($orderId)`: Siparişin teslimat adresini getirir.
- Tüm bilgiler JSON formatında döndürülür.

### Sipariş Durumu Güncelleme (updateStatus)

Bu metod, bir siparişin durumunu değiştirmek için kullanılır.

```php
    public function updateStatus($orderId)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $newStatus = $input['status'] ?? null;

        if ($newStatus) {
            $this->orderModel->updateOrderStatus($orderId, $newStatus);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Geçersiz durum']);
        }
    }
```

**Açıklama:**
- `file_get_contents('php://input')`: JSON formatında gelen HTTP POST verisini alır.
- `json_decode()`: JSON verisini PHP dizisine çevirir.
- `$newStatus` değişkeni yeni sipariş durumunu alır.
- Eğer geçerli bir durum varsa:
  - `updateOrderStatus($orderId, $newStatus)` çağrılarak sipariş güncellenir.
  - JSON formatında başarılı dönüş yapılır.
- Geçersiz durum girildiğinde hata mesajı döndürülür.

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Admin;

use App\Models\OrderModel;
use App\Core\BaseController;

// OrderController sınıfını tanımla
class OrderController extends BaseController
{
    private $orderModel;

    public function __construct()
    {
        parent::__construct();
        $this->orderModel = new OrderModel();
    }

    /**
     * Tüm siparişleri listele.
     */
    public function index()
    {
        $orders = $this->orderModel->getAllOrders();

        foreach ($orders as &$order) {
            $user = $this->orderModel->getUserById($order['user_id']);
            $order['user_name'] = $user['name'];
        }

        if (empty($orders)) {
            $orders = [];
        }

        $this->renderAdmin(
            'admin/order/index',
            ['orders' => $orders]
        );
    }

    /**
     * Sipariş detaylarını al.
     *
     * @param int $orderId Sipariş ID'si
     * @return void
     */
    public function detail($orderId)
    {
        $order = $this->orderModel->getOrderById($orderId);
        $items = $this->orderModel->getOrderItemsByOrderId($orderId);
        $address = $this->orderModel->getOrderAddressByOrderId($orderId);

        echo json_encode([
            'order' => $order,
            'items' => $items,
            'address' => $address
        ]);
    }

    /**
     * Sipariş durumunu güncelle.
     *
     * @param int $orderId Sipariş ID'si
     * @return void
     */
    public function updateStatus($orderId)
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $newStatus = $input['status'] ?? null;

        if ($newStatus) {
            $this->orderModel->updateOrderStatus($orderId, $newStatus);
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Geçersiz durum']);
        }
    }
}

```
---

## Sonuç
Bu dokümantasyon, **OrderController** içinde sipariş yönetimi işlemlerinin nasıl yürütüldüğünü açıklamaktadır. Sipariş listeleme, detay görüntüleme ve sipariş durum güncelleme işlemleri açıklanmıştır.


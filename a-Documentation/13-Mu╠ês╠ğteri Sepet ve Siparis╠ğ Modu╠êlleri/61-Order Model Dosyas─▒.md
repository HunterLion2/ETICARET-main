# OrderModel Kullanım Kılavuzu

## Giriş
**OrderModel** sınıfı, sipariş işlemlerini yönetmek için geliştirilmiş bir modeldir. Bu model, sipariş ekleme, güncelleme ve listeleme gibi işlemleri gerçekleştirmek için veritabanı ile etkileşim sağlar.

---

## OrderModel Sınıfı

### 1. **Sınıf Tanımı ve Kullanımı**
Bu model, `Database` sınıfını kullanarak veritabanı işlemlerini gerçekleştirir.

```php
namespace App\Models;
use App\Core\Database;
```

---

### 2. **Siparişleri Listeleme**
#### getOrdersByUserId($userId)
Bir kullanıcının tüm siparişlerini almak için kullanılır.

**Parametreler:**
- `$userId` *(int)* - Kullanıcının kimlik numarası.

**Dönüş:**
- Kullanıcının siparişlerini içeren bir dizi döndürür.

**Örnek Kullanım:**
```php
$orderModel = new OrderModel();
$orders = $orderModel->getOrdersByUserId(1);
print_r($orders);
```

---

### 3. **Sipariş Detayları**
#### getOrderById($orderId)
Belirtilen siparişin detaylarını almak için kullanılır.

**Parametreler:**
- `$orderId` *(int)* - Sipariş kimlik numarası.

**Dönüş:**
- Sipariş detaylarını içeren bir dizi döndürür.

---

### 4. **Siparişe Ait Ürünleri Listeleme**
#### getOrderItemsByOrderId($orderId)
Bir siparişin içeriğindeki ürünleri listelemek için kullanılır.

**Parametreler:**
- `$orderId` *(int)* - Sipariş kimlik numarası.

**Dönüş:**
- Siparişe ait ürünlerin listesi.

---

### 5. **Yeni Sipariş Oluşturma**
#### createOrder($data)
Yeni bir sipariş kaydetmek için kullanılır.

**Parametreler:**
- `$data` *(array)* - Sipariş verilerini içeren dizi.
    - `user_id` *(int)* - Kullanıcı kimlik numarası.
    - `total_price` *(float)* - Siparişin toplam tutarı.
    - `status` *(string)* - Sipariş durumu (Varsayılan: `pending`).

**Dönüş:**
- Yeni eklenen siparişin kimlik numarası döndürülür.

**Örnek Kullanım:**
```php
$orderData = [
    'user_id' => 1,
    'total_price' => 250.00,
    'status' => 'pending'
];
$orderId = $orderModel->createOrder($orderData);
echo "Yeni sipariş ID: " . $orderId;
```

---

### 6. **Siparişe Ürün Ekleme**
#### createOrderItem($data)
Belirli bir siparişe ürün eklemek için kullanılır.

**Parametreler:**
- `$data` *(array)* - Sipariş öğesi verileri.
    - `order_id` *(int)* - Sipariş kimlik numarası.
    - `product_id` *(int)* - Ürün kimlik numarası.
    - `quantity` *(int)* - Sipariş edilen miktar.
    - `price` *(float)* - Ürün fiyatı.

---

### 7. **Ödeme İşlemlerini Kaydetme**
#### createOrderPayment($data)
Siparişe ödeme kaydı eklemek için kullanılır.

**Parametreler:**
- `$data` *(array)* - Ödeme detayları.
    - `order_id` *(int)* - Sipariş kimlik numarası.
    - `payment_status` *(string)* - Ödeme durumu (`completed`, `pending`, vb.).
    - `payment_method` *(string)* - Kullanılan ödeme yöntemi.
    - `transaction_id` *(string)* - Ödeme işlemi kimlik numarası.
    - `payment_total` *(float)* - Ödeme miktarı.

---

### 8. **Sipariş Adresi Ekleme**
#### createOrderAddress($data)
Siparişe ait teslimat veya fatura adresini eklemek için kullanılır.

**Parametreler:**
- `$data` *(array)* - Adres bilgileri.
    - `order_id` *(int)* - Sipariş kimlik numarası.
    - `address_type` *(string)* - Adres türü (`shipping`, `billing`).
    - `full_name` *(string)* - Alıcının adı.
    - `phone` *(string)* - Telefon numarası.
    - `city` *(string)* - İl.
    - `district` *(string)* - İlçe.
    - `neighborhood` *(string)* - Mahalle.
    - `address` *(string)* - Açık adres.

---

### 9. **Sipariş Güncelleme**
#### updateOrderStatus($orderId, $status)
Bir siparişin durumunu güncellemek için kullanılır.

**Parametreler:**
- `$orderId` *(int)* - Sipariş kimlik numarası.
- `$status` *(string)* - Yeni sipariş durumu (`pending`, `shipped`, `completed`, vb.).

**Örnek Kullanım:**
```php
$orderModel->updateOrderStatus(1, 'completed');
echo "Sipariş güncellendi.";
```

---
## 📌 **Tam Kod*

```php
<?php

// App\Models ad alanını kullan
namespace App\Models;

// Gerekli sınıfı içe aktar
use App\Core\Database;

// OrderModel sınıfını tanımla 
class OrderModel
{
    // Veritabanı bağlantısı
    private $db;

    // Yapıcı metot
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Kullanıcı ID'sine göre siparişleri alır.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array
     */
    public function getOrdersByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Sipariş ID'sine göre siparişi alır.
     *
     * @param int $orderId Sipariş ID'si
     * @return array|false
     */
    public function getOrderById($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM orders WHERE id = :order_id");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch();
    }

    /**
     * Sipariş ID'sine göre sipariş öğelerini alır.
     *
     * @param int $orderId Sipariş ID'si
     * @return array
     */
    public function getOrderItemsByOrderId($orderId)
    {
        $stmt = $this->db->prepare("
            SELECT oi.*, p.name as product_name 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.id 
            WHERE oi.order_id = :order_id
        ");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll();
    }

    /**
     * Yeni bir sipariş oluşturur.
     *
     * @param array $data Sipariş verileri
     * @return int
     */
    public function createOrder($data)
    {
        $stmt = $this->db->prepare("INSERT INTO orders (user_id, total_price, status) VALUES (:user_id, :total_price, :status)");
        $stmt->execute([
            'user_id' => $data['user_id'],
            'total_price' => $data['total_price'],
            'status' => $data['status'] ?? 'pending'
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Yeni bir sipariş öğesi oluşturur.
     *
     * @param array $data Sipariş öğesi verileri
     * @return void
     */
    public function createOrderItem($data)
    {
        $stmt = $this->db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
        $stmt->execute([
            'order_id' => $data['order_id'],
            'product_id' => $data['product_id'],
            'quantity' => $data['quantity'],
            'price' => $data['price']
        ]);
    }

    /**
     * Yeni bir sipariş ödemesi oluşturur.
     *
     * @param array $data Sipariş ödeme verileri
     * @return void
     */
    public function createOrderPayment($data)
    {
        $stmt = $this->db->prepare("INSERT INTO order_payments (order_id, payment_status, payment_method, transaction_id, payment_total) VALUES (:order_id, :payment_status, :payment_method, :transaction_id, :payment_total)");
        $stmt->execute([
            'order_id' => $data['order_id'],
            'payment_status' => $data['payment_status'],
            'payment_method' => $data['payment_method'],
            'transaction_id' => $data['transaction_id'],
            'payment_total' => $data['payment_total']
        ]);
    }

    /**
     * Yeni bir sipariş adresi oluşturur.
     *
     * @param array $data Sipariş adres verileri
     * @return void
     */
    public function createOrderAddress($data)
    {
        $stmt = $this->db->prepare("INSERT INTO order_addresses (order_id, address_type, full_name, phone, city, district, neighborhood, address) VALUES (:order_id, :address_type, :full_name, :phone, :city, :district, :neighborhood, :address)");
        $stmt->execute([
            'order_id' => $data['order_id'],
            'address_type' => $data['address_type'],
            'full_name' => $data['full_name'],
            'phone' => $data['phone'],
            'city' => $data['city'],
            'district' => $data['district'],
            'neighborhood' => $data['neighborhood'],
            'address' => $data['address']
        ]);
    }

    /**
     * Kullanıcı ID'sine göre kullanıcıyı alır.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array|false
     */
    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :user_id");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetch();
    }

    /**
     * Kullanıcı ID'sine göre sepet öğelerini alır.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array
     */
    public function getCartItems($userId)
    {
        $stmt = $this->db->prepare("
            SELECT ci.product_id, p.name, p.price, ci.quantity, c.category 
            FROM cart_items ci 
            JOIN products p ON ci.product_id = p.id 
            JOIN categories c ON p.category_id = c.id 
            WHERE ci.user_id = :user_id
        ");
        $stmt->execute(['user_id' => $userId]);
        return $stmt->fetchAll();
    }

    /**
     * Kullanıcı ID'sine göre sepeti temizler.
     *
     * @param int $userId Kullanıcı ID'si
     * @return void
     */
    public function clearCart($userId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart_items WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);
    }

    /**
     * Sipariş ID'sine göre sipariş adresini alır.
     *
     * @param int $orderId Sipariş ID'si
     * @return array|false
     */
    public function getOrderAddressByOrderId($orderId)
    {
        $stmt = $this->db->prepare("SELECT * FROM order_addresses WHERE order_id = :order_id AND address_type = 'shipping'");
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch();
    }

    /**
     * Tüm siparişleri alır (admin için).
     *
     * @return array
     */
    public function getAllOrders()
    {
        $stmt = $this->db->query("SELECT * FROM orders ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }

    /**
     * Sipariş durumunu günceller.
     *
     * @param int $orderId Sipariş ID'si
     * @param string $status Yeni durum
     * @return void
     */
    public function updateOrderStatus($orderId, $status)
    {
        $stmt = $this->db->prepare("UPDATE orders SET status = :status WHERE id = :order_id");
        $stmt->execute([
            'status' => $status,
            'order_id' => $orderId
        ]);
    }
}

```
---
---

## Sonuç
OrderModel, e-ticaret sistemlerinde sipariş yönetimini kolaylaştırmak için geliştirilmiş bir modeldir. Sipariş oluşturma, ödeme ekleme, sipariş detaylarını getirme ve sipariş güncelleme gibi birçok işlevi yerine getirir. Bu rehber, OrderModel sınıfını kullanarak nasıl etkin bir şekilde sipariş yönetimi yapabileceğinizi göstermektedir.


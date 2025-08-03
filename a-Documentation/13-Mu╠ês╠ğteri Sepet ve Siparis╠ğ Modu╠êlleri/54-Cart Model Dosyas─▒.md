# PHP E-Ticaret Projesi: CartModel Sınıfı 

Bu dokümanda, **CartModel** sınıfının ne işe yaradığını, hangi metodlara sahip olduğunu ve bu metodların nasıl kullanıldığını açıklayacağız.

---

## 1. CartModel Sınıfı Nedir?

CartModel sınıfı, kullanıcıların sepetlerini yönetmek için oluşturulmuş bir veritabanı modelidir. Bu model, **sepete ürün ekleme, ürün silme, miktar güncelleme ve sepeti listeleme** gibi işlemleri gerçekleştirir.

---

## 2. Sınıf Tanımı

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * CartModel sınıfı, sepet işlemlerini yönetir.
 */
class CartModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * CartModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = self::getDbInstance();
    }

    /**
     * Veritabanı bağlantısını tekil hale getirir.
     *
     * @return \PDO
     */
    private static function getDbInstance()
    {
        return Database::getInstance();
    }
```

---

## 3. Metodlar

### **a) Sepete Ürün Ekleme**

Kullanıcı, sepetine yeni bir ürün eklediğinde ürün zaten mevcutsa **miktarını artırır**, yoksa yeni bir kayıt ekler.

```php
public function addToCart($userId, $productId, $quantity = 1)
{
    $stmt = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$userId, $productId]);
    $existingItem = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($existingItem) {
        $newQuantity = $existingItem['quantity'] + $quantity;
        $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$newQuantity, $userId, $productId]);
    } else {
        $stmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $productId, $quantity]);
    }
}
```

### **b) Sepetten Ürün Silme**

Belirtilen **kullanıcı ve ürün ID'sine** göre sepetten ürün silinir.

```php
public function removeFromCart($userId, $productId)
{
    $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    return $stmt->execute([$userId, $productId]);
}
```

### **c) Kullanıcının Sepetini Listeleme**

Belirtilen kullanıcı ID'sine göre sepetteki ürünleri getirir.

```php
public function getCartItemsByUserId($userId)
{
    $stmt = $this->db->prepare("
        SELECT p.name, p.price, c.quantity, c.product_id
        FROM cart c
        JOIN products p ON c.product_id = p.id
        WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **d) Sepetteki Ürün Miktarını Artırma**

```php
public function increaseQuantity($userId, $productId)
{
    $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
    return $stmt->execute([$userId, $productId]);
}
```

### **e) Sepetteki Ürün Miktarını Azaltma**

```php
public function decreaseQuantity($userId, $productId)
{
    $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity - 1 WHERE user_id = ? AND product_id = ? AND quantity > 1");
    return $stmt->execute([$userId, $productId]);
}
```

### **f) Kullanıcının Sepetindeki Toplam Ürün Sayısını Getirme**

```php
public function getCartItemCountByUserId($userId)
{
    $stmt = $this->db->prepare("SELECT SUM(quantity) as item_count FROM cart WHERE user_id = ?");
    $stmt->execute([$userId]);
    $result = $stmt->fetch(\PDO::FETCH_ASSOC);
    return $result['item_count'] ?? 0;
}
```

---

## 4. Kullanım Senaryosu

Bu metodlar bir **controller** içerisinde aşağıdaki gibi kullanılabilir:

```php
$cartModel = new CartModel();
$cartModel->addToCart($userId, $productId, 1); // Sepete 1 adet ürün ekle
$cartItems = $cartModel->getCartItemsByUserId($userId); // Sepeti listele
$cartModel->removeFromCart($userId, $productId); // Sepetten ürün sil
```

---

## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * CartModel sınıfı, sepet işlemlerini yönetir.
 */
class CartModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * CartModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = self::getDbInstance();
    }

    /**
     * Veritabanı bağlantısını tekil hale getirir.
     *
     * @return \PDO
     */
    private static function getDbInstance()
    {
        return Database::getInstance();
    }

    /**
     * Sepete ürün ekler veya miktarını günceller.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @param int $quantity Ürün miktarı
     * @return bool
     */
    public function addToCart($userId, $productId, $quantity = 1)
    {
        // Mevcut ürün miktarını kontrol et
        $stmt = $this->db->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$userId, $productId]);
        $existingItem = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($existingItem) {
            // Mevcut ürün miktarını güncelle
            $newQuantity = $existingItem['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
            return $stmt->execute([$newQuantity, $userId, $productId]);
        } else {
            // Yeni ürün ekle
            $stmt = $this->db->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
            return $stmt->execute([$userId, $productId, $quantity]);
        }
    }

    /**
     * Sepetten ürün siler.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @return bool
     */
    public function removeFromCart($userId, $productId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Kullanıcı ID'ye göre sepet öğelerini getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array
     */
    public function getCartItemsByUserId($userId)
    {
        $stmt = $this->db->prepare("
            SELECT p.name, p.price, c.quantity, c.product_id
            FROM cart c
            JOIN products p ON c.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Sepetteki ürün miktarını arttırır.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @return bool
     */
    public function increaseQuantity($userId, $productId)
    {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND product_id = ?");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Sepetteki ürün miktarını azaltır.
     *
     * @param int $userId Kullanıcı ID'si
     * @param int $productId Ürün ID'si
     * @return bool
     */
    public function decreaseQuantity($userId, $productId)
    {
        $stmt = $this->db->prepare("UPDATE cart SET quantity = quantity - 1 WHERE user_id = ? AND product_id = ? AND quantity > 1");
        return $stmt->execute([$userId, $productId]);
    }

    /**
     * Kullanıcı ID'ye göre sepetteki ürün sayısını getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return int
     */
    public function getCartItemCountByUserId($userId)
    {
        $stmt = $this->db->prepare("SELECT SUM(quantity) as item_count FROM cart WHERE user_id = ?");
        $stmt->execute([$userId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $result['item_count'] ?? 0;
    }
}

```
---

## 5. Sonuç

Bu **CartModel** sınıfı, e-ticaret sistemlerindeki **sepet** yönetimini kolaylaştırır. 

Eğer **sepette eklemeler yapma, ürün çıkarma ve miktar güncelleme** gibi işlemler yapmak istiyorsanız, yukarıdaki metodları kullanabilirsiniz. 

**Geliştirme Tavsiyeleri:**
- Sepette **stok kontrolü** eklenebilir.
- Kullanıcı bazlı özel **indirimler** uygulanabilir.

Bu döküman, CartModel sınıfını anlamanız ve projelerinize entegre etmeniz için hazırlanmıştır. 
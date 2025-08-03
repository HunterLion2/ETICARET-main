# BuyModel Sınıfı ile E-Ticaret Sipariş Yönetimi

## Giriş
Bu dokümanda, **BuyModel** sınĿının e-ticaret sipariş yönetimiyle ilgili fonksiyonlarını ve nasıl kullanılacağını açıklayacağız. Bu model, **kullanıcı adresleri, sepet işlemleri ve sipariş yönetimi** gibi temel e-ticaret işlemlerini gerçekleştirmek için kullanılır.

---

## 1. Sınıf Tanımı
BuyModel sınĿı, **Database** sınĿını kullanarak veritabanı bağlantısını sağlar ve e-ticaret işlemlerini yönetmek için gerekli olan metodları içerir.

```php
namespace App\Models;

use App\Core\Database;

class BuyModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
```

---

## 2. Kullanıcı Adresleri
Kullanıcının adreslerini ekleme, güncelleme ve getirme fonksiyonları.

### 2.1 Kullanıcının Tüm Adreslerini Getir
```php
public function getUserAddresses($userId)
```
**Açıklama:** Kullanıcı ID'sine göre tüm adresleri getirir.

---

### 2.2 Kullanıcının Varsayılan Adresini Getir
```php
public function getUserAddress($userId)
```
**Açıklama:** Kullanıcının kayıtlı tek bir adresini getirir.

---

### 2.3 Yeni Adres Kaydetme
```php
public function saveAddress($data)
```
**Açıklama:** Yeni bir adres kayıt eder. Kullanıcı ID ve adres bilgilerini parametre olarak alır.

---

### 2.4 Adres Güncelleme
```php
public function updateAddress($data)
```
**Açıklama:** Mevcut bir adresi günceller.

---

## 3. Kullanıcı Siparişleri ve Sepet İşlemleri
Bu metodlar kullanıcı siparişlerini ve sepet verilerini yönetir.

### 3.1 Kullanıcının Sepet Verilerini Getir
```php
public function getCartItems($userId)
```
**Açıklama:** Kullanıcının sepetindeki tüm ürünleri getirir.

---

### 3.2 Yeni Sipariş Oluşturma
```php
public function createOrder($data)
```
**Açıklama:** Kullanıcının mevcut sepeti üzerinden yeni bir sipariş oluşturur.

---

### 3.3 Siparişe İlişkin Ürünleri Kaydetme
```php
public function createOrderItem($data)
```
**Açıklama:** Yeni siparişte bulunan ürünleri order_items tablosuna kaydeder.

---

### 3.4 Sipariş Ödemesi Kaydetme
```php
public function createOrderPayment($data)
```
**Açıklama:** Kullanıcının siparişi için yaptığı ödemeyi kayıt altına alır.

---

### 3.5 Sipariş Adresi Kaydetme
```php
public function createOrderAddress($data)
```
**Açıklama:** Kullanıcının sipariş için belirttiği adresi kaydeder.

---

## 4. Sepeti Temizleme
```php
public function clearCart($userId)
```
**Açıklama:** Kullanıcının sipariş oluşturduktan sonra sepetini temizler.

---

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * BuyModel sınıfı, kullanıcı adresleri, sepet ve sipariş işlemleri gibi
 * e-ticaret işlemlerini yönetmek için kullanılır.
 */
class BuyModel
{
    /**
     * @var \PDO $db Veritabanı bağlantısı
     */
    private $db;

    /**
     * BuyModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Belirtilen kullanıcıya ait tüm adresleri getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array Kullanıcı adresleri
     */
    public function getUserAddresses($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM user_addresses WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirtilen kullanıcıya ait tek bir adresi getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array Kullanıcı adresi
     */
    public function getUserAddress($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM user_addresses WHERE user_id = ? LIMIT 1");
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir adres kaydeder.
     *
     * @param array $data Adres verileri
     * @return bool İşlem sonucu
     */
    public function saveAddress($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO user_addresses (user_id, full_name, phone, city, district, neighborhood, address, invoice_type, tax_office, tax_number, company_name, is_default)
            VALUES (:user_id, :full_name, :phone, :city, :district, :neighborhood, :address, :invoice_type, :tax_office, :tax_number, :company_name, :is_default)
        ");
        return $stmt->execute($data);
    }

    /**
     * Mevcut bir adresi günceller.
     *
     * @param array $data Adres verileri
     * @return bool İşlem sonucu
     */
    public function updateAddress($data)
    {
        $stmt = $this->db->prepare("
            UPDATE user_addresses
            SET full_name = :full_name, phone = :phone, city = :city, district = :district, neighborhood = :neighborhood, address = :address, invoice_type = :invoice_type, tax_office = :tax_office, tax_number = :tax_number, company_name = :company_name
            WHERE user_id = :user_id
        ");
        return $stmt->execute([
            ':full_name' => $data['full_name'],
            ':phone' => $data['phone'],
            ':city' => $data['city'],
            ':district' => $data['district'],
            ':neighborhood' => $data['neighborhood'],
            ':address' => $data['address'],
            ':invoice_type' => $data['invoice_type'],
            ':tax_office' => $data['tax_office'],
            ':tax_number' => $data['tax_number'],
            ':company_name' => $data['company_name'],
            ':user_id' => $data['user_id']
        ]);
    }

    /**
     * Belirtilen kullanıcı ID'sine sahip kullanıcıyı getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array Kullanıcı verileri
     */
    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirtilen kullanıcıya ait sepet öğelerini getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array Sepet öğeleri
     */
    public function getCartItems($userId)
    {
        $stmt = $this->db->prepare("
            SELECT c.product_id, p.name, p.price, cat.name as category, c.quantity
            FROM cart c
            JOIN products p ON c.product_id = p.id
            JOIN categories cat ON p.category_id = cat.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir sipariş oluşturur.
     *
     * @param array $data Sipariş verileri
     * @return int Son eklenen sipariş ID'si
     */
    public function createOrder($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO orders (user_id, total_price, status)
            VALUES (:user_id, :total_price, 'paid')
        ");
        $stmt->execute([
            ':user_id' => $data['user_id'],
            ':total_price' => $data['total_price']
        ]);
        return $this->db->lastInsertId();
    }

    /**
     * Yeni bir sipariş öğesi oluşturur.
     *
     * @param array $data Sipariş öğesi verileri
     * @return bool İşlem sonucu
     */
    public function createOrderItem($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (:order_id, :product_id, :quantity, :price)
        ");
        return $stmt->execute($data);
    }

    /**
     * Yeni bir sipariş ödemesi oluşturur.
     *
     * @param array $data Ödeme verileri
     * @return bool İşlem sonucu
     */
    public function createOrderPayment($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO order_payments (order_id, payment_status, payment_method, transaction_id, payment_total)
            VALUES (:order_id, 'completed', :payment_method, :transaction_id, :payment_total)
        ");
        return $stmt->execute($data);
    }

    /**
     * Yeni bir sipariş adresi oluşturur.
     *
     * @param array $data Adres verileri
     * @return bool İşlem sonucu
     */
    public function createOrderAddress($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO order_addresses (order_id, address_type, full_name, phone, city, district, neighborhood, address)
            VALUES (:order_id, :address_type, :full_name, :phone, :city, :district, :neighborhood, :address)
        ");
        return $stmt->execute($data);
    }

    /**
     * Belirtilen kullanıcıya ait sepeti temizler.
     *
     * @param int $userId Kullanıcı ID'si
     * @return bool İşlem sonucu
     */
    public function clearCart($userId)
    {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE user_id = ?");
        return $stmt->execute([$userId]);
    }
}

```
---

## Sonuç
Bu dokümanda **BuyModel** sınĿının **kullanıcı adresleri, sepet ve sipariş yönetimi** için sunduğu metodları ele aldık. 
E-ticaret projelerinde kullanıcı sipariş süreçlerini yönetmek için bu metodlar kullanılabilir. 
Eğer bu fonksiyonları geliştirmek veya yeni özellikler eklemek isterseniz, mevcut metodları referans alabilirsiniz.
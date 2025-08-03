# DashboardModel Modeli

## Genel Bakış

`DashboardModel` sınıfı, veritabanından çeşitli istatistiksel verileri almak için kullanılır. Bu sınıf,
veritabanından toplam müşteri sayısı, sipariş sayısı ve sipariş durumları gibi önemli bilgileri sorgulamak için metotlar sunar.

---

## Kullanılan Teknolojiler
- **PHP** (Nesne Yönelimli Programlama - OOP)
- **PDO (PHP Data Objects)** (Veritabanı Bağlantısı)

---

## Sınıf Yapısı

### **1. Constructor Metodu**

```php
public function __construct()
{
    $this->db = Database::getInstance();
}
```

Bu metod, `Database::getInstance()` metodunu kullanarak veritabanı bağlantısını başlatır.

---

### **2. Müşteri Sayısını Getirme**

```php
public function getCustomerCount()
{
    $stmt = $this->db->query("SELECT COUNT(*) as count FROM users");
    return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
}
```

- `users` tablosundaki toplam kayıtlı kullanıcı sayısını getirir.
- `COUNT(*) as count` SQL sorgusu kullanılır.
- `fetch(\PDO::FETCH_ASSOC)` ile sonucu dizi olarak döndürür.

---

### **3. Sipariş Sayısını Getirme**

```php
public function getOrderCount()
{
    $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
    return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
}
```

- `orders` tablosundaki toplam sipariş sayısını getirir.
- `COUNT(*) as count` ile toplam sipariş sayısı hesaplanır.

---

### **4. Sipariş Durumlarını Gruplayarak Getirme**

```php
public function getOrderStatusCounts()
{
    $stmt = $this->db->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

- `orders` tablosundaki siparişleri `status` sütununa göre gruplayarak sayar.
- `fetchAll(\PDO::FETCH_ASSOC)` ile tüm verileri dizi halinde döndürür.

---

### **5. Bugünki Sipariş Sayısını Getirme**

```php
public function getTodayOrderCount()
{
    $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = CURDATE()");
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
}
```

- `orders` tablosunda `created_at` değeri bugün olan kayıtları sayar.
- `CURDATE()` fonksiyonu ile bugünün tarihi kullanılır.

---

### **6. Toplam Sipariş Sayısını Getirme**

```php
public function getTotalOrderCount()
{
    $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
    return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
}
```

- `orders` tablosundaki tüm siparişlerin sayısını getirir.

---

### **7. İptal Edilen Sipariş Sayısını Getirme**

```php
public function getCancelledOrderCount()
{
    $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = 'cancelled'");
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
}
```

- `orders` tablosundaki `status` sütunu `cancelled` olan siparişleri sayar.

---

### **8. Bekleyen Sipariş Sayısını Getirme**

```php
public function getPendingOrderCount()
{
    $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status NOT IN ('cancelled', 'shipped')");
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
}
```

- `cancelled` ve `shipped` haricindeki siparişleri getirir.

---

### **9. Tamamlanan Sipariş Sayısını Getirme**

```php
public function getCompletedOrderCount()
{
    $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = 'shipped'");
    $stmt->execute();
    return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
}
```

- `orders` tablosundaki `shipped` olarak işaretlenmiş siparişleri getirir.

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * DashboardModel sınıfı, veritabanından çeşitli istatistiksel verileri almak için kullanılır.
 */
class DashboardModel
{
    /**
     * @var \PDO Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * DashboardModel constructor.
     * Veritabanı bağlantısını başlatır. 
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Toplam müşteri sayısını döner.
     *
     * @return int Müşteri sayısı
     */
    public function getCustomerCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM users");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Toplam sipariş sayısını döner.
     *
     * @return int Sipariş sayısı
     */
    public function getOrderCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Sipariş durumlarına göre sipariş sayılarını döner.
     *
     * @return array Sipariş durumlarına göre sayılar
     */
    public function getOrderStatusCounts()
    {
        $stmt = $this->db->query("SELECT status, COUNT(*) as count FROM orders GROUP BY status");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Bugün oluşturulan siparişlerin sayısını döner.
     *
     * @return int Bugünkü sipariş sayısı
     */
    public function getTodayOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE DATE(created_at) = CURDATE()");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /** 
     * Toplam sipariş sayısını döner.
     *
     * @return int Toplam sipariş sayısı
     */
    public function getTotalOrderCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM orders");
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * İptal edilen siparişlerin sayısını döner.
     *
     * @return int İptal edilen sipariş sayısı
     */
    public function getCancelledOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = 'cancelled'");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Bekleyen siparişlerin sayısını döner.
     *
     * @return int Bekleyen sipariş sayısı
     */
    public function getPendingOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status NOT IN ('cancelled', 'shipped')");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }

    /**
     * Tamamlanan siparişlerin sayısını döner.
     *
     * @return int Tamamlanan sipariş sayısı
     */
    public function getCompletedOrderCount()
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM orders WHERE status = 'shipped'");
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC)['count'];
    }
}

```
---

## **Sonuç**

`DashboardModel` sınıfı, veritabanından istatistiksel verileri çekerek çeşitli dashboard uygulamaları için temel veri kaynağı olarak kullanılabilir.
Bu sınıf sayesinde veritabanına doğrudan erişim yapmadan, müşteri ve sipariş bilgilerine hızlı bir şekilde ulaşılabilir.


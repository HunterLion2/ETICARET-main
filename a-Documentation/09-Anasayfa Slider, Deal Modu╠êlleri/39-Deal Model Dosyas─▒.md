# **DealModel Kullanımı - Kampanya Yönetimi**

Bu eğitim dokümanında, **DealModel’in nasıl çalıştığını ve kampanya verilerinin nasıl yönetildiğini** öğreneceksiniz. **Bu model, kampanya verilerini veritabanından almak, oluşturmak, güncellemek ve silmek için kullanılır.**

---

## **1. DealModel Sınıfının Tanıtımı**

```php
namespace App\Models;

use App\Core\Database;
```

### **Ne İşe Yarar?**
✅ **`namespace App\Models;` → DealModel’in model katmanında olduğunu belirtir.**  
✅ **`use App\Core\Database;` → Veritabanı işlemleri için Database sınıfını dahil eder.**

---

## **2. Veritabanı Bağlantısı**

```php
private $db;

public function __construct()
{
    $this->db = Database::getInstance();
}
```

### **Ne İşe Yarar?**
✅ **Veritabanı bağlantısını başlatır.**  
✅ **`Database::getInstance();`** ile **Singleton Pattern kullanarak tekil bir veritabanı bağlantısı oluşturur.**

---

## **3. Aktif Kampanyaları Getirme**

```php
public function getActiveDeals()
{
    $stmt = $this->db->query("
        SELECT * 
        FROM deals 
        WHERE status = 1 
          AND start_date <= NOW() 
          AND end_date >= NOW() 
        ORDER BY start_date ASC
    ");

    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Şu an aktif olan kampanyaları getirir.**
✅ **`status = 1` olan (aktif) ve tarih aralığı şu anki zamana uygun olan kampanyaları filtreler.**
✅ **Sonuçları başlangıç tarihine göre sıralar.**

📌 **Örnek Kullanım:**
```php
$dealModel = new DealModel();
$activeDeals = $dealModel->getActiveDeals();
```

---

## **4. Belirli Bir Kampanyayı ID ile Getirme**

```php
public function getDealById($id)
{
    $stmt = $this->db->prepare("SELECT * FROM deals WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen `id` değerine sahip kampanyayı getirir.**
✅ **Veriyi `fetch()` ile tek bir dizi olarak döndürür.**

📌 **Örnek Kullanım:**
```php
$deal = $dealModel->getDealById(5);
```

---

## **5. Yeni Bir Kampanya Oluşturma**

```php
public function createDeal($data)
{
    $stmt = $this->db->prepare("INSERT INTO deals (title, content, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['title'],
        $data['content'],
        $data['start_date'],
        $data['end_date'],
        $data['status']
    ]);
}
```

### **Ne İşe Yarar?**
✅ **Yeni bir kampanya oluşturur.**  
✅ **Gelen `$data` dizisini veritabanına işler.**

📌 **Örnek Kullanım:**
```php
$dealModel->createDeal([
    'title' => 'Yaz İndirimleri',
    'content' => 'Tüm ürünlerde %20 indirim!',
    'start_date' => '2025-06-01',
    'end_date' => '2025-06-30',
    'status' => 1
]);
```

---

## **6. Mevcut Bir Kampanyayı Güncelleme**

```php
public function updateDeal($id, $data)
{
    $query = "UPDATE deals SET title = ?, content = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?";
    $params = [
        $data['title'],
        $data['content'],
        $data['start_date'],
        $data['end_date'],
        $data['status'],
        $id
    ];

    $stmt = $this->db->prepare($query);
    return $stmt->execute($params);
}
```

### **Ne İşe Yarar?**
✅ **Var olan kampanyayı günceller.**  
✅ **Kampanyanın başlık, içerik, tarih ve durumunu değiştirmeye olanak tanır.**

📌 **Örnek Kullanım:**
```php
$dealModel->updateDeal(5, [
    'title' => 'Kış Kampanyası',
    'content' => 'Sezon sonu indirimleri başladı!',
    'start_date' => '2025-12-01',
    'end_date' => '2025-12-31',
    'status' => 1
]);
```

---

## **7. Kampanyayı Silme**

```php
public function deleteDeal($id)
{
    $stmt = $this->db->prepare("DELETE FROM deals WHERE id = ?");
    return $stmt->execute([$id]);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen ID’ye sahip kampanyayı kalıcı olarak siler.**  
✅ **Geri alma işlemi yoktur, dikkatli kullanılmalıdır.**

📌 **Örnek Kullanım:**
```php
$dealModel->deleteDeal(3);
```

---

## **8. Tüm Kampanyaları Getirme**

```php
public function getAllDeals()
{
    $stmt = $this->db->query("SELECT * FROM deals ORDER BY start_date ASC");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Tüm kampanyaları getirir.**  
✅ **Başlangıç tarihine göre sıralama yapar.**

📌 **Örnek Kullanım:**
```php
$deals = $dealModel->getAllDeals();
```

---

## **9. Tarayıcıda Test Etme**

### **1. Mevcut kampanyaları listeleme:**
```sh
http://phpeticaretv5.test/deals
```

### **2. Belirli bir kampanyayı görüntüleme:**
```sh
http://phpeticaretv5.test/deal/5
```

### **3. Yeni bir kampanya ekleme:**
```php
$dealModel->createDeal([...]);
```

### **4. Kampanyayı güncelleme:**
```php
$dealModel->updateDeal(5, [...]);
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * DealModel sınıfı, kampanya verilerini yönetmek için kullanılır.
 */
class DealModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * DealModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm aktif kampanyaları alır.
     *
     * @return array
     */
    public function getActiveDeals()
    {
        // deals tablosundan aktif kampanyaları al
        $stmt = $this->db->query("
            SELECT * 
            FROM deals 
            WHERE status = 1 
              AND start_date <= NOW() 
              AND end_date >= NOW() 
            ORDER BY start_date ASC
        ");

        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirli bir kampanyayı ID ile alır.
     *
     * @param int $id Kampanya ID'si
     * @return array|false
     */
    public function getDealById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM deals WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir kampanya oluşturur.
     *
     * @param array $data Kampanya verileri
     * @return bool
     */
    public function createDeal($data)
    {
        $stmt = $this->db->prepare("INSERT INTO deals (title, content, start_date, end_date, status) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['title'], $data['content'], $data['start_date'], $data['end_date'], $data['status']]);
    }

    /**
     * Mevcut bir kampanyayı günceller.
     *
     * @param int $id Kampanya ID'si
     * @param array $data Kampanya verileri
     * @return bool
     */
    public function updateDeal($id, $data)
    {
        $query = "UPDATE deals SET title = ?, content = ?, start_date = ?, end_date = ?, status = ? WHERE id = ?";
        $params = [$data['title'], $data['content'], $data['start_date'], $data['end_date'], $data['status'], $id];

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Belirli bir kampanyayı siler.
     *
     * @param int $id Kampanya ID'si
     * @return bool
     */
    public function deleteDeal($id)
    {
        $stmt = $this->db->prepare("DELETE FROM deals WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Tüm kampanyaları alır.
     *
     * @return array
     */
    public function getAllDeals()
    {
        $stmt = $this->db->query("SELECT * FROM deals ORDER BY start_date ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

```
---

## **Sonuç**

Bu eğitimde, **DealModel’in nasıl çalıştığını, kampanyaların nasıl yönetildiğini ve tarayıcıda nasıl test edileceğini öğrendiniz.** **Artık, DealModel ile kampanya işlemlerini yönetebilirsiniz! 🚀**

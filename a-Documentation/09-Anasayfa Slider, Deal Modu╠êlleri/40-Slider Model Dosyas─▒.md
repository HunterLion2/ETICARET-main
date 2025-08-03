# **SliderModel Kullanımı - Slider Yönetimi**

Bu eğitim dokümanında, **SliderModel’in nasıl çalıştığını ve slider verilerinin nasıl yönetildiğini** öğreneceksiniz. **Bu model, slider verilerini veritabanından almak, oluşturmak, güncellemek ve silmek için kullanılır.**

---

## **1. SliderModel Sınıfının Tanıtımı**

```php
namespace App\Models;

use App\Core\Database;
```

### **Ne İşe Yarar?**
✅ **`namespace App\Models;` → SliderModel’in model katmanında olduğunu belirtir.**  
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

## **3. Aktif Sliderları Getirme**

```php
public function getActiveSliders()
{
    $stmt = $this->db->query("SELECT * FROM sliders WHERE status = 1 ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}
```

### **Ne İşe Yarar?**
✅ **Şu an aktif olan sliderları getirir.**
✅ **`status = 1` olan (aktif) sliderları filtreler.**
✅ **Sonuçları `sort_order` alanına göre sıralar.**

📌 **Örnek Kullanım:**
```php
$sliderModel = new SliderModel();
$activeSliders = $sliderModel->getActiveSliders();
```

---

## **4. Belirli Bir Sliderı ID ile Getirme**

```php
public function getSliderById($id)
{
    $stmt = $this->db->prepare("SELECT * FROM sliders WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen `id` değerine sahip sliderı getirir.**
✅ **Veriyi `fetch()` ile tek bir dizi olarak döndürür.**

📌 **Örnek Kullanım:**
```php
$slider = $sliderModel->getSliderById(5);
```

---

## **5. Yeni Bir Slider Oluşturma**

```php
public function createSlider($data)
{
    $stmt = $this->db->prepare("INSERT INTO sliders (image_url, title, description, link_url, status, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
    return $stmt->execute([
        $data['image_url'],
        $data['title'],
        $data['description'],
        $data['link_url'],
        $data['status'],
        $data['sort_order']
    ]);
}
```

### **Ne İşe Yarar?**
✅ **Yeni bir slider oluşturur.**  
✅ **Gelen `$data` dizisini veritabanına işler.**

📌 **Örnek Kullanım:**
```php
$sliderModel->createSlider([
    'image_url' => 'uploads/slider1.jpg',
    'title' => 'Büyük İndirimler!',
    'description' => 'Bu haftaya özel %50 indirim!',
    'link_url' => '/kampanya',
    'status' => 1,
    'sort_order' => 1
]);
```

---

## **6. Mevcut Bir Sliderı Güncelleme**

```php
public function updateSlider($id, $data)
{
    $query = "UPDATE sliders SET title = ?, description = ?, link_url = ?, status = ?, sort_order = ?";
    $params = [$data['title'], $data['description'], $data['link_url'], $data['status'], $data['sort_order']];

    if (isset($data['image_url'])) {
        $query .= ", image_url = ?";
        $params[] = $data['image_url'];
    }

    $query .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $this->db->prepare($query);
    return $stmt->execute($params);
}
```

### **Ne İşe Yarar?**
✅ **Var olan sliderı günceller.**  
✅ **Slider’ın başlık, açıklama, durum ve sıralama bilgisini değiştirmeye olanak tanır.**

📌 **Örnek Kullanım:**
```php
$sliderModel->updateSlider(5, [
    'title' => 'Yeni Kampanya!',
    'description' => 'Tüm ürünlerde büyük indirimler!',
    'link_url' => '/yeni-kampanya',
    'status' => 1,
    'sort_order' => 2
]);
```

---

## **7. Sliderı Silme**

```php
public function deleteSlider($id)
{
    $stmt = $this->db->prepare("DELETE FROM sliders WHERE id = ?");
    return $stmt->execute([$id]);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen ID’ye sahip sliderı kalıcı olarak siler.**  
✅ **Geri alma işlemi yoktur, dikkatli kullanılmalıdır.**

📌 **Örnek Kullanım:**
```php
$sliderModel->deleteSlider(3);
```

---

## **8. Tüm Sliderları Getirme**

```php
public function getAllSliders()
{
    $stmt = $this->db->query("SELECT * FROM sliders ORDER BY sort_order ASC");
    return $stmt->fetchAll();
}
```

### **Ne İşe Yarar?**
✅ **Tüm sliderları getirir.**  
✅ **Sıralama için `sort_order` alanını kullanır.**

📌 **Örnek Kullanım:**
```php
$sliders = $sliderModel->getAllSliders();
```

---

## **9. Tarayıcıda Test Etme**

### **1. Mevcut sliderları listeleme:**

HomeController ile anasayfada görüntüleme yapıldığı için Deal ve Slider modülleri için farklı herhangi bir route tanımı yapılmasına gerek yoktur.

```sh
http://phpeticaretv5.test/
```

## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * SliderModel sınıfı, slider veritabanı işlemlerini yönetir.
 */
class SliderModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * SliderModel constructor.
     * Veritabanı bağlantısını başlatır. 
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Aktif sliderları getirir.
     *
     * @return array Aktif sliderlar
     */
    public function getActiveSliders()
    {
        $stmt = $this->db->query("SELECT * FROM sliders WHERE status = 1 ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }

    /**
     * Belirli bir ID'ye sahip sliderı getirir.
     *
     * @param int $id Slider ID
     * @return array Slider verisi
     */
    public function getSliderById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM sliders WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Yeni bir slider oluşturur.
     *
     * @param array $data Slider verisi
     * @return bool İşlem sonucu
     */
    public function createSlider($data)
    {
        $stmt = $this->db->prepare("INSERT INTO sliders (image_url, title, description, link_url, status, sort_order) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$data['image_url'], $data['title'], $data['description'], $data['link_url'], $data['status'], $data['sort_order']]);
    }

    /**
     * Belirli bir ID'ye sahip sliderı günceller.
     *
     * @param int $id Slider ID
     * @param array $data Güncellenmiş slider verisi
     * @return bool İşlem sonucu
     */
    public function updateSlider($id, $data)
    {
        $query = "UPDATE sliders SET title = ?, description = ?, link_url = ?, status = ?, sort_order = ?";
        $params = [$data['title'], $data['description'], $data['link_url'], $data['status'], $data['sort_order']];

        if (isset($data['image_url'])) {
            $query .= ", image_url = ?";
            $params[] = $data['image_url'];
        }

        $query .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Belirli bir ID'ye sahip sliderı siler.
     *
     * @param int $id Slider ID
     * @return bool İşlem sonucu
     */
    public function deleteSlider($id)
    {
        $stmt = $this->db->prepare("DELETE FROM sliders WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Tüm sliderları getirir.
     *
     * @return array Tüm sliderlar
     */
    public function getAllSliders()
    {
        $stmt = $this->db->query("SELECT * FROM sliders ORDER BY sort_order ASC");
        return $stmt->fetchAll();
    }
}

```
---



Bu eğitimde, **SliderModel’in nasıl çalıştığını, sliderların nasıl yönetildiğini ve tarayıcıda nasıl test edileceğini öğrendiniz.** **Artık, SliderModel ile slider işlemlerini yönetebilirsiniz! 🚀**
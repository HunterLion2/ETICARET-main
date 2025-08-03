# **CategoryModel Kullanımı ve Kategori Yönetimi**

Bu eğitim dokümanında, **PHP ile bir model sınıfının nasıl oluşturulacağını** ve **kategori işlemlerinin nasıl yönetileceğini** öğreneceksiniz. **CategoryModel** sınıfı, `categories` tablosundaki verileri almak, eklemek, güncellemek ve silmek için geliştirilmiştir.

---

## **1. CategoryModel Sınıfının Tanıtımı**

```php
namespace App\Models;

use App\Core\Database;
```

### **Ne İşe Yarar?**
✅ `namespace App\Models;` → **Sınıfın uygulamanın Models dizinine ait olduğunu belirtir.**
✅ `use App\Core\Database;` → **Veritabanı bağlantısını sağlayan Database sınıfını dahil eder.**

---

## **2. Veritabanı Bağlantısının Başlatılması**

```php
private $db;

public function __construct()
{
    $this->db = Database::getInstance();
}
```

### **Ne İşe Yarar?**
✅ `$db` değişkeni, **veritabanı bağlantısını saklar.**
✅ `Database::getInstance();` ile **singleton tasarım deseni kullanılarak tek bir bağlantı nesnesi oluşturulur.**

---

## **3. Aktif Kategorileri Almak**

```php
public function getActiveCategories()
{
    $stmt = $this->db->query("SELECT * FROM categories WHERE status = 1 ORDER BY id ASC");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ `WHERE status = 1` → **Sadece aktif kategorileri getirir.**
✅ `ORDER BY id ASC` → **Kategori ID'ye göre sıralama yapar.**

🔹 **Örnek Kullanım:**
```php
$categoryModel = new CategoryModel();
$categories = $categoryModel->getActiveCategories();
print_r($categories);
```

---

## **4. Tüm Kategorileri Almak**

```php
public function getAllCategories()
{
    $stmt = $this->db->query("SELECT * FROM categories ORDER BY id ASC");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Tüm kategorileri veritabanından alır.**
✅ **Kategori sıralamasını ID’ye göre düzenler.**

---

## **5. Belirli Bir Kategori Bilgisini Getirme**

```php
public function getCategoryById($id)
{
    $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ `prepare()` metodu **SQL enjeksiyon saldırılarına karşı güvenli bir sorgu oluşturur.**
✅ `execute([$id])` → **Belirtilen ID’ye sahip kategoriyi döndürür.**

🔹 **Örnek Kullanım:**
```php
$categoryModel = new CategoryModel();
$category = $categoryModel->getCategoryById(3);
print_r($category);
```

---

## **6. Yeni Kategori Oluşturma**

```php
public function createCategory($data)
{
    $slug = $this->generateSlug($data['name']);
    $stmt = $this->db->prepare("INSERT INTO categories (name, icon, description, status, slug) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$data['name'], $data['icon'], $data['description'], $data['status'], $slug]);
}
```

### **Ne İşe Yarar?**
✅ `generateSlug()` metodu ile **kategori ismine uygun bir URL dostu slug oluşturur.**
✅ `INSERT INTO` ile **yeni bir kategori veritabanına eklenir.**

---

## **7. Kategori Güncelleme**

```php
public function updateCategory($id, $data)
{
    $stmt = $this->db->prepare("UPDATE categories SET name = ?, icon = ?, description = ?, status = ? WHERE id = ?");
    return $stmt->execute([$data['name'], $data['icon'], $data['description'], $data['status'], $id]);
}
```

### **Ne İşe Yarar?**
✅ `UPDATE categories SET ...` ile **kategori bilgilerini günceller.**
✅ **Kategori adı, simgesi ve açıklaması güncellenebilir.**

---

## **8. Kategori Silme**

```php
public function deleteCategory($id)
{
    $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
    return $stmt->execute([$id]);
}
```

### **Ne İşe Yarar?**
✅ `DELETE FROM categories WHERE id = ?` ile **belirtilen ID'ye sahip kategori silinir.**
✅ **Kategoriyi tamamen kaldırır, geri alma işlemi yapılamaz.**

🔹 **Örnek Kullanım:**
```php
$categoryModel = new CategoryModel();
$categoryModel->deleteCategory(5);
```

---

## **9. Kategoriye Özel URL (Slug) Oluşturma**

```php
private function generateSlug($name)
{
    $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
    $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
    $name = str_replace($turkish, $english, $name);
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
}
```

### **Ne İşe Yarar?**
✅ **Kategori ismini URL dostu hale çevirir.**
✅ **Türkçe karakterleri İngilizce karakterlere dönüştürür.**
✅ **Geçersiz karakterleri kaldırarak SEO uyumlu slug oluşturur.**

---

## **10. Bir Kategoriye Ait Ürünleri Getirme**

```php
public function getProductsByCategorySlug($categorySlug)
{
    $stmt = $this->db->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = ?");
    $stmt->execute([$categorySlug]);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen kategoriye ait ürünleri getirir.**
✅ `JOIN categories` kullanılarak **kategori adıyla ürünler ilişkilendirilir.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * CategoryModel sınıfı, kategori veritabanı işlemlerini yönetir.
 */
class CategoryModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * CategoryModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Aktif kategorileri alır.
     *
     * @return array Kategoriler dizisi
     */
    public function getActiveCategories()
    {
        // categories tablosundan aktif kategorileri al
        $stmt = $this->db->query("SELECT * FROM categories WHERE status = 1 ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Tüm kategorileri alır.
     *
     * @return array Kategoriler dizisi
     */
    public function getAllCategories()
    {
        $stmt = $this->db->query("SELECT * FROM categories ORDER BY id ASC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirli bir kategori ID'sine göre kategori bilgilerini alır.
     *
     * @param int $id Kategori ID'si
     * @return array Kategori bilgileri
     */
    public function getCategoryById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM categories WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir kategori oluşturur.
     *
     * @param array $data Kategori verileri
     * @return bool İşlem sonucu
     */
    public function createCategory($data)
    {
        $slug = $this->generateSlug($data['name']);
        $stmt = $this->db->prepare("INSERT INTO categories (name, icon, description, status, slug) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['icon'], $data['description'], $data['status'], $slug]);
    }

    /**
     * Belirli bir kategori ID'sine göre kategori bilgilerini günceller.
     *
     * @param int $id Kategori ID'si
     * @param array $data Kategori verileri
     * @return bool İşlem sonucu
     */
    public function updateCategory($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE categories SET name = ?, icon = ?, description = ?, status = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['icon'], $data['description'], $data['status'], $id]);
    }

    /**
     * Belirli bir kategori ID'sine göre kategoriyi siler.
     *
     * @param int $id Kategori ID'si
     * @return bool İşlem sonucu
     */
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM categories WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Kategori ismine göre slug oluşturur.
     *
     * @param string $name Kategori ismi
     * @return string Slug
     */
    private function generateSlug($name)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $name = str_replace($turkish, $english, $name);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    /**
     * Kategori slug'ına göre ürünleri alır.
     *
     * @param string $categorySlug Kategori slug'ı
     * @return array Ürünler dizisi
     */
    public function getProductsByCategorySlug($categorySlug)
    {
        $stmt = $this->db->prepare("SELECT p.*, c.name as category_name FROM products p JOIN categories c ON p.category_id = c.id WHERE c.slug = ?");
        $stmt->execute([$categorySlug]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

```
—

## **Sonuç**

Bu eğitimde **CategoryModel sınıfının nasıl çalıştığını, veritabanı ile nasıl iletişim kurduğunu ve kategorilerin nasıl yönetildiğini** öğrendiniz. Şimdi öğrendiklerinizi projelerinizde uygulayabilirsiniz! 🚀

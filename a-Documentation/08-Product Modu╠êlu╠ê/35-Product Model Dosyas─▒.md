# **ProductModel Kullanımı ve Ürün Yönetimi**

Bu eğitim dokümanında, **ProductModel’in nasıl çalıştığını, ürünlerin nasıl yönetileceğini ve veritabanı ile nasıl etkileşime girileceğini** öğreneceksiniz. **Bu model, ürünlerin alınması, eklenmesi, güncellenmesi ve silinmesi işlemlerini gerçekleştirmektedir.**

---

## **1. ProductModel Sınıfının Tanıtımı**

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

## **3. Tüm Ürünleri Getirme**

```php
public function getAllProducts()
{
    $stmt = $this->db->query("
        SELECT p.*, c.name AS category_name 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE c.status = 1
        ORDER BY p.created_at DESC
    ");
    return $stmt->fetchAll();
}
```

### **Ne İşe Yarar?**
✅ **Tüm aktif ürünleri getirir.**
✅ `INNER JOIN categories c ON p.category_id = c.id` → **Ürünlerin kategorileriyle ilişkisini sağlar.**
✅ `ORDER BY p.created_at DESC` → **Ürünleri en son eklenenden başlayarak sıralar.**

---

## **4. Öne Çıkan Ürünleri Getirme**

```php
public function getFeaturedProducts()
{
    $stmt = $this->db->query("
        SELECT p.*, c.name AS category_name 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE p.featured = 'featured' AND c.status = 1
        ORDER BY p.featured DESC, p.created_at DESC
    ");
    return $stmt->fetchAll();
}
```

### **Ne İşe Yarar?**
✅ **Öne çıkan ürünleri getirir.**
✅ `p.featured = 'featured'` → **Öne çıkarılmış ürünleri filtreler.**
✅ `ORDER BY p.featured DESC, p.created_at DESC` → **Öne çıkan ürünleri en yeni ürünlerden başlayarak sıralar.**

---

## **5. Slug’a Göre Ürün Getirme**

```php
public function getProductBySlug($slug)
{
    $stmt = $this->db->prepare("
        SELECT p.*, c.name AS category_name 
        FROM products p
        INNER JOIN categories c ON p.category_id = c.id
        WHERE p.slug = ? AND c.status = 1
    ");
    $stmt->execute([$slug]);
    return $stmt->fetch();
}
```

### **Ne İşe Yarar?**
✅ **Belirli bir ürünün slug değerine göre getirilmesini sağlar.**
✅ `prepare()` → **Güvenli sorgu yaparak SQL enjeksiyonunu önler.**

🔹 **Örnek Kullanım:**
```php
$productModel = new ProductModel();
$product = $productModel->getProductBySlug('iphone-13');
print_r($product);
```

---

## **6. Ürün Oluşturma**

```php
public function createProduct($data)
{
    $stmt = $this->db->prepare("
        INSERT INTO products 
        (name, slug, short_description, featured, tag, standard_image, hover_image, stock_quantity, delivery_date, long_description, category_id) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    return $stmt->execute([
        $data['name'],
        $data['slug'],
        $data['short_description'],
        $data['featured'],
        $data['tag'],
        $data['standard_image'],
        $data['hover_image'],
        $data['stock_quantity'],
        $data['delivery_date'],
        $data['long_description'],
        $data['category_id']
    ]);
}
```

### **Ne İşe Yarar?**
✅ **Yeni bir ürünü veritabanına ekler.**
✅ `slug` → **SEO uyumlu URL yapısı sağlar.**
✅ `stock_quantity` → **Ürün stok bilgisini içerir.**

---

## **7. Ürün Güncelleme**

```php
public function updateProduct($id, $data)
{
    $stmt = $this->db->prepare("
        UPDATE products SET 
            name = ?, 
            slug = ?, 
            short_description = ?, 
            featured = ?, 
            tag = ?, 
            standard_image = ?, 
            hover_image = ?, 
            stock_quantity = ?, 
            delivery_date = ?, 
            long_description = ?, 
            category_id = ?
        WHERE id = ?
    ");

    return $stmt->execute([
        $data['name'],
        $data['slug'],
        $data['short_description'],
        $data['featured'],
        $data['tag'],
        $data['standard_image'],
        $data['hover_image'],
        $data['stock_quantity'],
        $data['delivery_date'],
        $data['long_description'],
        $data['category_id'],
        $id
    ]);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen ID’ye sahip ürünü günceller.**
✅ `UPDATE products SET ... WHERE id = ?` → **Ürünü ID’ye göre günceller.**

---

## **8. Ürün Silme**

```php
public function deleteProduct($id)
{
    $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen ID’ye sahip ürünü tamamen siler.**
✅ **Geri dönüşü olmayan bir işlemdir.**

🔹 **Örnek Kullanım:**
```php
$productModel = new ProductModel();
$productModel->deleteProduct(10);
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * Ürün modeli sınıfı
 */
class ProductModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * ProductModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm aktif ürünleri alır.
     *
     * @return array
     */
    public function getAllProducts()
    {
        // products tablosundan tüm aktif ürünleri al
        $stmt = $this->db->query("
            SELECT p.*, c.name AS category_name 
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            WHERE c.status = 1
            ORDER BY p.created_at DESC
        ");
        // Sorgu sonucunu döndür
        return $stmt->fetchAll();
    }

    /**
     * Öne çıkan ürünleri alır.
     *
     * @return array
     */
    public function getFeaturedProducts()
    {
        // products tablosundan öne çıkan ürünleri al
        $stmt = $this->db->query("
            SELECT p.*, c.name AS category_name 
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            WHERE p.featured = 'featured' AND c.status = 1
            ORDER BY p.featured DESC, p.created_at DESC
        ");
        // Sorgu sonucunu döndür
        return $stmt->fetchAll();
    }

    /**
     * Slug alanına göre tek bir ürün alır.
     *
     * @param string $slug Ürünün slug değeri
     * @return array|false
     */
    public function getProductBySlug($slug)
    {
        // products tablosundan slug'a göre ürünü al
        $stmt = $this->db->prepare("
            SELECT p.*, c.name AS category_name 
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            WHERE p.slug = ? AND c.status = 1
        ");
        // Sorguyu çalıştır ve parametreyi bağla
        $stmt->execute([$slug]);
        // Sorgu sonucunu döndür
        return $stmt->fetch();
    }

    /**
     * Slug'a göre tek bir ürünü alır (ön yüz için).
     *
     * @param string $slug Ürünün slug değeri
     * @return array|false
     */
    public function getProductBySlugForFront($slug)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, c.name AS category_name 
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            WHERE p.slug = ? AND c.status = 1
        ");
        $stmt->execute([$slug]);
        return $stmt->fetch();
    }

    /**
     * Belirli bir kategoriye ait ürünleri alır.
     *
     * @param string $categorySlug Kategorinin slug değeri
     * @return array
     */
    public function getProductsByCategorySlug($categorySlug)
    {
        // products tablosundan kategori slug'a göre ürünleri al
        $stmt = $this->db->prepare("
            SELECT p.*, c.name AS category_name 
            FROM products p
            INNER JOIN categories c ON p.category_id = c.id
            WHERE c.slug = ? AND c.status = 1
        ");
        // Sorguyu çalıştır ve parametreyi bağla
        $stmt->execute([$categorySlug]);
        // Sorgu sonucunu döndür
        return $stmt->fetchAll();
    }

    // ---- Yeni Metotlar ----

    /**
     * Bir ürün oluşturur.
     *
     * @param array $data Ürün verileri
     * @return bool
     */
    public function createProduct($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO products 
            (name, slug, short_description, featured, tag, standard_image, hover_image, stock_quantity, delivery_date, long_description, category_id) 
            VALUES 
            (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['short_description'],
            $data['featured'],
            $data['tag'],
            $data['standard_image'],
            $data['hover_image'],
            $data['stock_quantity'],
            $data['delivery_date'],
            $data['long_description'],
            $data['category_id']
        ]);
    }

    /**
     * Bir ürünü günceller.
     *
     * @param int $id Ürün ID'si
     * @param array $data Ürün verileri
     * @return bool
     */
    public function updateProduct($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE products SET 
                name = ?, 
                slug = ?, 
                short_description = ?, 
                featured = ?, 
                tag = ?, 
                standard_image = ?, 
                hover_image = ?, 
                stock_quantity = ?, 
                delivery_date = ?, 
                long_description = ?, 
                category_id = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['name'],
            $data['slug'],
            $data['short_description'],
            $data['featured'],
            $data['tag'],
            $data['standard_image'],
            $data['hover_image'],
            $data['stock_quantity'],
            $data['delivery_date'],
            $data['long_description'],
            $data['category_id'],
            $id
        ]);
    }

    /**
     * Bir ürünü siler.
     *
     * @param int $id Ürün ID'si
     * @return bool
     */
    public function deleteProduct($id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * ID'ye göre tek bir ürün alır.
     *
     * @param int $id Ürünün ID'si
     * @return array|false
     */
    public function getProductById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Tüm aktif kategorileri alır.
     *
     * @return array
     */
    public function getAllCategories()
    {
        $stmt = $this->db->query("
            SELECT id, name 
            FROM categories 
            WHERE status = 1
            ORDER BY name ASC
        ");
        return $stmt->fetchAll();
    }

    /**
     * Ürüne ait galeri resimlerini alır.
     *
     * @param int $productId Ürün ID'si
     * @return array
     */
    public function getProductGalleryImages($productId)
    {
        $stmt = $this->db->prepare("
            SELECT image_path 
            FROM product_gallery 
            WHERE product_id = ?
            LIMIT 3
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll();
    }

    /**
     * Ürün galerisine resim ekler.
     *
     * @param int $productId Ürün ID'si
     * @param string $imagePath Resim yolu
     * @return bool
     */
    public function addGalleryImage($productId, $imagePath)
    {
        $stmt = $this->db->prepare("INSERT INTO product_gallery (product_id, image_path) VALUES (?, ?)");
        return $stmt->execute([$productId, $imagePath]);
    }

    /**
     * Ürün galerisinden resim siler.
     *
     * @param int $productId Ürün ID'si
     * @param string $imagePath Resim yolu
     * @return bool
     */
    public function deleteGalleryImage($productId, $imagePath)
    {
        $stmt = $this->db->prepare("DELETE FROM product_gallery WHERE product_id = ? AND image_path = ?");
        return $stmt->execute([$productId, $imagePath]);
    }

    /**
     * Toplam ürün sayısını alır.
     *
     * @return int
     */
    public function getTotalProductCount()
    {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM products");
        $result = $stmt->fetch();
        return $result['total'];
    }

    // ---- Yeni Metotlar Sonu ----
}

```
---

## **Sonuç**
Bu eğitimde, **ProductModel sınıfının nasıl çalıştığını, ürünlerin nasıl yönetileceğini ve veritabanı ile nasıl iletişim kurulacağını** öğrendiniz. **Şimdi, ProductModel’inizi kullanarak ürün yönetimini uygulamaya koyabilirsiniz!** 🚀
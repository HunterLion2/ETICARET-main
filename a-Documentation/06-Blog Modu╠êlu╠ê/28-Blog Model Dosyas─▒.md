# **BlogModel Kullanımı ve Blog Gönderilerinin Yönetimi**

Bu eğitim dokümanında, **BlogModel’in nasıl çalıştığını, blog gönderilerinin nasıl yönetileceğini ve veritabanı ile nasıl etkileşime girileceğini** öğreneceksiniz. **Bu model, blog yazılarının alınması, oluşturulması, güncellenmesi ve silinmesi işlemlerini gerçekleştirmektedir.**

---

## **1. BlogModel Sınıfının Tanıtımı**

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

## **3. Tüm Blog Gönderilerini Almak**

```php
public function getAllPosts()
{
    $stmt = $this->db->query("SELECT * FROM BlogPosts ORDER BY published_at DESC");
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Tüm blog gönderilerini tarihe göre sıralayarak getirir.**
✅ `ORDER BY published_at DESC` → **En son yayınlanan yazılar en üstte gösterilir.**

---

## **4. Belirli Bir Blog Gönderisini ID’ye Göre Getirme**

```php
public function getPostById($id)
{
    $stmt = $this->db->prepare("SELECT * FROM BlogPosts WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ `prepare()` metodu, **SQL enjeksiyon saldırılarına karşı güvenli bir sorgu oluşturur.**
✅ **Belirtilen ID’ye sahip blog gönderisini getirir.**

🔹 **Örnek Kullanım:**
```php
$blogModel = new BlogModel();
$post = $blogModel->getPostById(5);
print_r($post);
```

---

## **5. Yeni Blog Gönderisi Oluşturma**

```php
public function createPost($data)
{
    $stmt = $this->db->prepare("INSERT INTO BlogPosts (title, slug, content, thumbnail_url, published_at) VALUES (?, ?, ?, ?, ?)");
    return $stmt->execute([$data['title'], $data['slug'], $data['content'], $data['thumbnail_url'], $data['published_at']]);
}
```

### **Ne İşe Yarar?**
✅ **Yeni bir blog yazısını veritabanına ekler.**
✅ `slug` → **SEO uyumlu URL yapısı sağlar.**
✅ `thumbnail_url` → **Blog yazısına ait görsel bağlantısını saklar.**

---

## **6. Blog Gönderisini Güncelleme**

```php
public function updatePost($id, $data)
{
    $query = "UPDATE BlogPosts SET title = ?, slug = ?, content = ?, published_at = ?";
    $params = [$data['title'], $data['slug'], $data['content'], $data['published_at']];

    if (isset($data['thumbnail_url'])) {
        $query .= ", thumbnail_url = ?";
        $params[] = $data['thumbnail_url'];
    }

    $query .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $this->db->prepare($query);
    return $stmt->execute($params);
}
```

### **Ne İşe Yarar?**
✅ `UPDATE BlogPosts SET ... WHERE id = ?` → **Belirtilen ID’ye sahip blog yazısını günceller.**
✅ **Eğer yeni bir thumbnail URL'si varsa güncelleme yapılır.**

---

## **7. Blog Gönderisini Silme**

```php
public function deletePost($id)
{
    $stmt = $this->db->prepare("DELETE FROM BlogPosts WHERE id = ?");
    return $stmt->execute([$id]);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen ID’ye sahip blog gönderisini tamamen siler.**
✅ **Geri dönüşü olmayan bir işlemdir.**

🔹 **Örnek Kullanım:**
```php
$blogModel = new BlogModel();
$blogModel->deletePost(5);
```

---

## **8. Ön Yüz İçin Blog Gönderilerini Getirme**

```php
public function getAllPostsForFront()
{
    $stmt = $this->db->prepare("SELECT title, slug, content, thumbnail_url, published_at FROM BlogPosts ORDER BY published_at DESC");
    $stmt->execute();
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Ön yüzde kullanılmak üzere gereksiz alanları filtreleyerek blog gönderilerini getirir.**
✅ **Yalnızca gerekli olan başlık, içerik ve tarih gibi verileri döndürür.**

---

## **9. Ön Yüz İçin Belirli Bir Blog Gönderisini Slug’a Göre Getirme**

```php
public function getPostBySlugForFront($slug)
{
    $stmt = $this->db->prepare("SELECT title, slug, content, thumbnail_url, published_at FROM BlogPosts WHERE slug = ?");
    $stmt->execute([$slug]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
```

### **Ne İşe Yarar?**
✅ **Ön yüz için SEO dostu URL (slug) ile blog yazılarını getirir.**
✅ **Veriyi optimize edilmiş şekilde döndürerek sayfa yüklenmesini hızlandırır.**

---

```php
<?php

namespace App\Models;

use App\Core\Database;

class BlogModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * BlogModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm blog gönderilerini alır.
     *
     * @return array Blog gönderileri
     */
    public function getAllPosts()
    {
        $stmt = $this->db->query("SELECT * FROM BlogPosts ORDER BY published_at DESC");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Belirli bir ID'ye sahip blog gönderisini alır.
     *
     * @param int $id Blog gönderisi ID'si
     * @return array Blog gönderisi
     */
    public function getPostById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM BlogPosts WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Yeni bir blog gönderisi oluşturur.
     *
     * @param array $data Blog gönderisi verileri
     * @return bool İşlem sonucu
     */
    public function createPost($data)
    {
        $stmt = $this->db->prepare("INSERT INTO BlogPosts (title, slug, content, thumbnail_url, published_at) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['title'], $data['slug'], $data['content'], $data['thumbnail_url'], $data['published_at']]);
    }

    /**
     * Belirli bir ID'ye sahip blog gönderisini günceller.
     *
     * @param int $id Blog gönderisi ID'si
     * @param array $data Blog gönderisi verileri
     * @return bool İşlem sonucu
     */
    public function updatePost($id, $data)
    {
        $query = "UPDATE BlogPosts SET title = ?, slug = ?, content = ?, published_at = ?";
        $params = [$data['title'], $data['slug'], $data['content'], $data['published_at']];

        if (isset($data['thumbnail_url'])) {
            $query .= ", thumbnail_url = ?";
            $params[] = $data['thumbnail_url'];
        }

        $query .= " WHERE id = ?";
        $params[] = $id;

        $stmt = $this->db->prepare($query);
        return $stmt->execute($params);
    }

    /**
     * Belirli bir ID'ye sahip blog gönderisini siler.
     *
     * @param int $id Blog gönderisi ID'si
     * @return bool İşlem sonucu
     */
    public function deletePost($id)
    {
        $stmt = $this->db->prepare("DELETE FROM BlogPosts WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Ön yüz için tüm blog gönderilerini alır.
     *
     * @return array Blog gönderileri
     */
    public function getAllPostsForFront()
    {
        $stmt = $this->db->prepare("SELECT title, slug, content, thumbnail_url, published_at FROM BlogPosts ORDER BY published_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Ön yüz için belirli bir slug'a sahip blog gönderisini alır.
     *
     * @param string $slug Blog gönderisi slug'ı
     * @return array Blog gönderisi
     */
    public function getPostBySlugForFront($slug)
    {
        $stmt = $this->db->prepare("SELECT title, slug, content, thumbnail_url, published_at FROM BlogPosts WHERE slug = ?");
        $stmt->execute([$slug]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Verilen isimden bir slug oluşturur.
     *
     * @param string $name İsim
     * @return string Slug
     */
    private function generateSlug($name)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $name = str_replace($turkish, $english, $name);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }
}

```
---
## **Sonuç**

Bu eğitimde, **BlogModel sınıfının nasıl çalıştığını, blog gönderilerinin nasıl yönetileceğini ve veritabanı ile nasıl iletişim kurulacağını** öğrendiniz. **Şimdi öğrendiklerinizi test ederek blog modülünüzü geliştirmeye devam edebilirsiniz!** 🚀

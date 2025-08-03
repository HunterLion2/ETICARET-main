# **PageModel Kullanımı ve Sayfa Yönetimi**

Bu eğitim dokümanında, **PageModel’in nasıl çalıştığını, sayfaların nasıl yönetileceğini ve veritabanı ile nasıl etkileşime girileceğini** öğreneceksiniz. **Bu model, sayfaların alınması, oluşturulması, güncellenmesi ve silinmesi işlemlerini gerçekleştirmektedir.**

---

## **1. PageModel Sınıfının Tanıtımı**

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

## **3. Tüm Sayfaları Getirme**

```php
public function getAllPages()
{
    $query = "SELECT * FROM pages";
    return $this->db->query($query)->fetchAll();
}
```

### **Ne İşe Yarar?**
✅ **Tüm sayfaları getirir.**
✅ `fetchAll()` → **Bütün verileri bir dizi olarak döndürür.**

---

## **4. Belirli Bir Sayfayı ID’ye Göre Getirme**

```php
public function getPageById($id)
{
    $query = "SELECT * FROM pages WHERE id = :id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['id' => $id]);
    return $stmt->fetch();
}
```

### **Ne İşe Yarar?**
✅ `prepare()` metodu, **SQL enjeksiyon saldırılarına karşı güvenli bir sorgu oluşturur.**
✅ **Belirtilen ID’ye sahip sayfayı getirir.**

🔹 **Örnek Kullanım:**
```php
$pageModel = new PageModel();
$page = $pageModel->getPageById(5);
print_r($page);
```

---

## **5. Belirli Bir Sayfayı Slug’a Göre Getirme**

```php
public function getPageBySlug($slug)
{
    $query = "SELECT * FROM pages WHERE slug = :slug";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['slug' => $slug]);
    return $stmt->fetch();
}
```

### **Ne İşe Yarar?**
✅ **SEO dostu URL (slug) ile belirli bir sayfayı getirir.**
✅ **Veriyi optimize edilmiş şekilde döndürerek sayfa yüklenmesini hızlandırır.**

---

## **6. Yeni Sayfa Oluşturma**

```php
public function createPage($data)
{
    $query = "INSERT INTO pages (title, slug, content, status) VALUES (:title, :slug, :content, :status)";
    $stmt = $this->db->prepare($query);
    return $stmt->execute($data);
}
```

### **Ne İşe Yarar?**
✅ **Yeni bir sayfa veritabanına ekler.**
✅ `slug` → **SEO uyumlu URL yapısı sağlar.**
✅ `status` → **Sayfanın aktif veya pasif olduğunu belirler.**

---

## **7. Sayfa Güncelleme**

```php
public function updatePage($id, $data)
{
    $data['id'] = $id;
    $query = "UPDATE pages SET title = :title, slug = :slug, content = :content, status = :status WHERE id = :id";
    $stmt = $this->db->prepare($query);
    return $stmt->execute($data);
}
```

### **Ne İşe Yarar?**
✅ `UPDATE pages SET ... WHERE id = ?` → **Belirtilen ID’ye sahip sayfayı günceller.**
✅ **Güncellenen sayfa verilerini veritabanına kaydeder.**

---

## **8. Sayfa Silme**

```php
public function deletePage($id)
{
    $query = "DELETE FROM pages WHERE id = :id";
    $stmt = $this->db->prepare($query);
    return $stmt->execute(['id' => $id]);
}
```

### **Ne İşe Yarar?**
✅ **Belirtilen ID’ye sahip sayfayı tamamen siler.**
✅ **Geri dönüşü olmayan bir işlemdir.**

🔹 **Örnek Kullanım:**
```php
$pageModel = new PageModel();
$pageModel->deletePage(5);
```

---

## **9. Hata ve Çözüm**

🔴 Eğer aşağıdaki hata ile karşılaşıyorsanız:
```sh
Fatal error: Uncaught TypeError: PDO::query(): Argument #2 ($fetchMode) must be of type ?int, array given
```
✅ **Çözüm:** `query()` metodu yerine `prepare()` ve `execute()` metodlarını kullanın.

🔹 **Hatalı Kod:**
```php
$stmt = $this->db->query("SELECT * FROM pages WHERE slug = ?", [PDO::FETCH_ASSOC]);
```

✅ **Doğru Kullanım:**
```php
$stmt = $this->db->prepare("SELECT * FROM pages WHERE slug = ?");
$stmt->execute([$slug]);
$page = $stmt->fetch(PDO::FETCH_ASSOC);
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * PageModel sınıfı, sayfalarla ilgili veritabanı işlemlerini yönetir.
 */
class PageModel
{
    /**
     * @var Database Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * PageModel constructor.
     * Database sınıfının tekil örneğini alır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm sayfaları getirir.
     *
     * @return array Sayfaların listesi
     */
    public function getAllPages()
    {
        $query = "SELECT * FROM pages";
        return $this->db->query($query)->fetchAll();
    }

    /**
     * Belirli bir ID'ye sahip sayfayı getirir.
     *
     * @param int $id Sayfa ID'si
     * @return array Sayfa bilgileri
     */
    public function getPageById($id)
    {
        $query = "SELECT * FROM pages WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Belirli bir slug'a sahip sayfayı getirir.
     *
     * @param string $slug Sayfa slug'ı
     * @return array Sayfa bilgileri
     */
    public function getPageBySlug($slug)
    {
        $query = "SELECT * FROM pages WHERE slug = :slug";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['slug' => $slug]);
        return $stmt->fetch();
    }

    /**
     * Yeni bir sayfa oluşturur.
     *
     * @param array $data Sayfa verileri
     * @return bool İşlem sonucu
     */
    public function createPage($data)
    {
        $query = "INSERT INTO pages (title, slug, content, status) VALUES (:title, :slug, :content, :status)";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Belirli bir ID'ye sahip sayfayı günceller.
     *
     * @param int $id Sayfa ID'si
     * @param array $data Güncellenmiş sayfa verileri
     * @return bool İşlem sonucu
     */
    public function updatePage($id, $data)
    {
        $data['id'] = $id;
        $query = "UPDATE pages SET title = :title, slug = :slug, content = :content, status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute($data);
    }

    /**
     * Belirli bir ID'ye sahip sayfayı siler.
     *
     * @param int $id Sayfa ID'si
     * @return bool İşlem sonucu
     */
    public function deletePage($id)
    {
        $query = "DELETE FROM pages WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}

```
---

## **Sonuç**

Bu eğitimde, **PageModel sınıfının nasıl çalıştığını, sayfaların nasıl yönetileceğini ve veritabanı ile nasıl iletişim kurulacağını** öğrendiniz. **Şimdi öğrendiklerinizi test ederek sayfa modülünüzü geliştirmeye devam edebilirsiniz!** 🚀
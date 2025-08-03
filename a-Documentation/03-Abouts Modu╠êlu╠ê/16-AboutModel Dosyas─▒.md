# **AboutModel Sınıfının Kullanımı ve Veritabanı İşlemleri**
 
Bu eğitim dokümanında, **PHP ve PDO kullanarak bir model sınıfının nasıl oluşturulacağını** ve **veritabanı işlemlerinin nasıl yönetileceğini** öğreneceksiniz. **AboutModel** sınıfı, `about` tablosuyla ilgili işlemleri yönetmek için oluşturulmuştur.

---

## **1. Model Sınıfının Tanıtımı**

```php
namespace App\Models;

use App\Core\Database;
```

### **Ne İşe Yarar?**
✅ `namespace App\Models;` → Sınıfın uygulamanın **Models** bölümüne ait olduğunu belirtir.
✅ `use App\Core\Database;` → Veritabanı bağlantısını sağlayan **Database** sınıfını dahil eder.

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
✅ `$db` değişkeni, **veritabanı bağlantısını** saklar.
✅ `Database::getInstance();` ile **singleton tasarım deseni** kullanılarak **tek bir bağlantı nesnesi** oluşturulur.

---

## **3. 'about' Tablosundan Tek Kayıt Getirme**

```php
public function getAbout()
{
    $stmt = $this->db->query("SELECT * FROM about LIMIT 1");
    return $stmt->fetch();
}
```

### **Ne İşe Yarar?**
✅ `query("SELECT * FROM about LIMIT 1")` ile **'about' tablosundaki ilk kaydı getirir**.
✅ `fetch();` kullanılarak **tek bir kayıt döndürülür**.

🔹 **Örnek Kullanım:**
```php
$aboutModel = new AboutModel();
$aboutData = $aboutModel->getAbout();
print_r($aboutData);
```

---

## **4. 'about' Tablosundaki Kaydı Güncelleme**

```php
public function updateAbout($data)
{
    $stmt = $this->db->prepare(
        "UPDATE about SET vision = ?, mission = ?, biography = ?, image1 = ?, image2 = ?, updated_at = CURRENT_TIMESTAMP WHERE id = 1"
    );
    return $stmt->execute([
        $data['vision'],
        $data['mission'],
        $data['biography'],
        $data['image1'],
        $data['image2']
    ]);
}
```

### **Ne İşe Yarar?**
✅ `prepare()` metodu, **SQL enjeksiyon saldırılarına karşı güvenli bir şekilde sorgu hazırlar**.
✅ `execute([...])` ile **dinamik veriler veritabanına güncellenir**.
✅ `updated_at = CURRENT_TIMESTAMP` → **Son güncellenme zamanı otomatik olarak kaydedilir**.

🔹 **Örnek Kullanım:**
```php
$aboutModel = new AboutModel();
$updateData = [
    'vision' => 'Yenilikçi çözümler üretmek',
    'mission' => 'Teknoloji ile geleceği şekillendirmek',
    'biography' => 'Şirketimiz 10 yıldır sektörde faaliyet göstermektedir.',
    'image1' => 'vision.jpg',
    'image2' => 'mission.jpg'
];
$success = $aboutModel->updateAbout($updateData);
if ($success) {
    echo "Güncelleme başarılı!";
} else {
    echo "Güncelleme başarısız!";
}
```

---
## 📌 **Tam Kod**

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * AboutModel sınıfı, 'about' tablosu ile ilgili veritabanı işlemlerini yönetir.
 */
class AboutModel
{
    /**
     * @var \PDO Veritabanı bağlantısını tutar.
     */
    private $db;

    /**
     * AboutModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * 'about' tablosundan tek bir kayıt getirir.
     *
     * @return array Veritabanından getirilen kayıt.
     */
    public function getAbout()
    {
        $stmt = $this->db->query("SELECT * FROM about LIMIT 1");
        return $stmt->fetch();
    }

    /**
     * 'about' tablosundaki kaydı günceller.
     *
     * @param array $data Güncellenecek veriler.
     * @return bool Güncelleme işleminin ba��arılı olup olmadığını belirtir.
     */
    public function updateAbout($data)
    {
        $stmt = $this->db->prepare("UPDATE about SET vision = ?, mission = ?, biography = ?, image1 = ?, image2 = ?, updated_at = CURRENT_TIMESTAMP WHERE id = 1");
        return $stmt->execute([$data['vision'], $data['mission'], $data['biography'], $data['image1'], $data['image2']]);
    }
}

```
—
## **Sonuç**

Bu eğitimde **AboutModel sınıfının nasıl oluşturulacağını, veritabanı ile nasıl etkileşime geçeceğinizi** ve **verileri nasıl güvenli bir şekilde güncelleyeceğinizi** öğrendiniz. Şimdi öğrendiklerinizi projelerinize uygulayabilirsiniz! 🚀
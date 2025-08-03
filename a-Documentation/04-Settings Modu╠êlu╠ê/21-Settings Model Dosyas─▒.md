# **SettingsModel Kullanımı ve Uygulama Ayarlarının Yönetimi**

Bu eğitim dokümanında, **PHP ile bir model sınıfının nasıl oluşturulacağını** ve **uygulama ayarlarının nasıl yönetileceğini** öğreneceksiniz. **SettingsModel** sınıfı, `settings` tablosundan ayarları almak ve güncellemek için geliştirilmiştir.

---

## **1. SettingsModel Sınıfının Tanıtımı**

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

## **3. Tüm Ayarları Almak**

```php
public function getAllSettings(): array
{
    // Sadece setting_key ve setting_value sütunlarını al
    $stmt = $this->db->query("SELECT setting_key, setting_value FROM settings");

    // PDO::FETCH_KEY_PAIR ile anahtar-değer çiftleri döndür
    return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
}
```

### **Ne İşe Yarar?**
✅ `query("SELECT setting_key, setting_value FROM settings")` → **Veritabanından tüm ayarları alır.**
✅ `fetchAll(\PDO::FETCH_KEY_PAIR);` → **Sonuçları anahtar-değer çiftleri olarak döndürür.**

🔹 **Örnek Kullanım:**
```php
$settingsModel = new SettingsModel();
$settings = $settingsModel->getAllSettings();
print_r($settings);
```

---

## **4. Belirli Bir Ayarı Güncellemek**

```php
public function updateSetting(string $key, string $value): bool
{
    // Ayarı güncelle
    $stmt = $this->db->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");

    return $stmt->execute([':key' => $key, ':value' => $value]);
}
```

### **Ne İşe Yarar?**
✅ `prepare()` metodu, **SQL enjeksiyon saldırılarına karşı güvenli bir şekilde sorgu hazırlar.**
✅ `execute([...])` ile **dinamik veriler veritabanına güncellenir.**

🔹 **Örnek Kullanım:**
```php
$settingsModel = new SettingsModel();
$success = $settingsModel->updateSetting('site_title', 'Yeni Başlık');
if ($success) {
    echo "Ayar başarıyla güncellendi!";
} else {
    echo "Ayar güncellenemedi!";
}
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * SettingsModel sınıfı, uygulama ayarlarını yönetmek için kullanılır.
 */
class SettingsModel
{
    /**
     * @var \PDO Veritaban�� bağlantısı
     */
    private $db;

    /**
     * SettingsModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Tüm ayarları alır.
     *
     * @return array Ayarların anahtar-değer çiftleri olarak döner.
     */
    public function getAllSettings(): array
    {
        // Sadece setting_key ve setting_value sütunlarını al
        $stmt = $this->db->query("SELECT setting_key, setting_value FROM settings");

        // PDO::FETCH_KEY_PAIR ile anahtar-değer çiftleri döndür
        return $stmt->fetchAll(\PDO::FETCH_KEY_PAIR);
    }

    /**
     * Belirli bir ayarı günceller.
     *
     * @param string $key Ayar anahtarı
     * @param string $value Ayar değeri
     * @return bool Güncelleme başarılıysa true, aksi halde false döner
     */
    public function updateSetting(string $key, string $value): bool
    {
        // Ayarı güncelle
        $stmt = $this->db->prepare("UPDATE settings SET setting_value = :value WHERE setting_key = :key");

        return $stmt->execute([':key' => $key, ':value' => $value]);
    }
}

```
—


## **Sonuç**

Bu eğitimde **SettingsModel sınıfının nasıl çalıştığını, veritabanı ile nasıl iletişim kurduğunu ve uygulama ayarlarını nasıl yönettiğini** öğrendiniz. Şimdi öğrendiklerinizi projelerinizde uygulayabilirsiniz! 🚀
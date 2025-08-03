# Config.php Dosyası Açıklaması

## 📌 **Giriş**
Bu dosya, uygulamanın ortam değişkenlerini (`.env` dosyası) okuyarak yapılandırma ayarlarını yönetir. 
Veritabanı bağlantı bilgileri ve ödeme entegrasyon ayarları gibi hassas bilgileri güvenli bir şekilde yüklemeye olanak tanır.

---

## 📌 **Kod Açıklaması**

### **1. Namespace ve Gerekli Kütüphaneler**
```php
namespace App\Core;

use Dotenv\Dotenv;
```
**Açıklama:**
- `namespace App\Core;` → Bu sınıfın `App\Core` ad alanında olduğunu belirtir.
- `use Dotenv\Dotenv;` → Ortam değişkenlerini (`.env` dosyası) yönetmek için **Dotenv** kütüphanesini kullanır.

---

### **2. Yapılandırma Değişkenleri**
```php
private static $config = [];
```
**Açıklama:**
- `$config` değişkeni **statik** olarak tanımlanır.
- Uygulamanın yapılandırma ayarlarını bir dizi (`array`) içinde tutar.

---

### **3. Ortam Değişkenlerini Yükleme**
```php
public static function loadEnv()
```
**Açıklama:**
- `loadEnv()` fonksiyonu `.env` dosyasını okuyarak yapılandırma değişkenlerini `$config` dizisine yükler.
- Eğer `$config` zaten doluysa tekrar yüklenmez (performans optimizasyonu).

#### **Fonksiyon İçeriği:**
```php
if (empty(self::$config)) {
    $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
    $dotenv->load();
```
- **`empty(self::$config)`** → `$config` dizisi boşsa çalışır, böylece gereksiz yere `.env` dosyası tekrar yüklenmez.
- **`Dotenv::createImmutable(__DIR__ . '/../../')`** → `.env` dosyasını **proje kök dizininde** arar.
- **`$dotenv->load();`** → `.env` içindeki değişkenleri PHP ortamına yükler.

---

### **4. Yapılandırma Değişkenlerini Tanımlama**
```php
self::$config = [
    'DB_HOST' => $_ENV['DB_HOST'],
    'DB_NAME' => $_ENV['DB_NAME'],
    'DB_USER' => $_ENV['DB_USER'],
    'DB_PASSWORD' => $_ENV['DB_PASSWORD'],
    'DB_CHARSET' => $_ENV['DB_CHARSET'],
    'IYZIPAY_API_KEY' => $_ENV['IYZIPAY_API_KEY'],
    'IYZIPAY_SECRET_KEY' => $_ENV['IYZIPAY_SECRET_KEY'],
    'IYZIPAY_BASE_URL' => $_ENV['IYZIPAY_BASE_URL']
];
```
- **Veritabanı Ayarları:**
  - `DB_HOST`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `DB_CHARSET`
- **Ödeme API Ayarları:**
  - `IYZIPAY_API_KEY`, `IYZIPAY_SECRET_KEY`, `IYZIPAY_BASE_URL`
- **Güvenlik:** `.env` dosyası **.gitignore** içine alınmalı, böylece hassas bilgiler paylaşılmaz.

---

### **5. Yapılandırma Ayarlarını Alma**
```php
public static function get($key)
```
**Açıklama:**
- **Parametre:** `$key` → Alınmak istenen yapılandırma anahtarı.
- **Çalışma Mantığı:**
  - `loadEnv()` çağrılarak `$config` değişkeni doldurulur.
  - **Eğer istenen anahtar varsa** (`$config[$key]`), değeri döndürülür.
  - **Eğer anahtar yoksa** `null` döndürülür.

#### **Fonksiyon İçeriği:**
```php
$config = self::loadEnv();
return $config[$key] ?? null;
```
- **`$config = self::loadEnv();`** → Ortam değişkenleri yüklenir.
- **`$config[$key] ?? null;`** → `$key` değeri varsa döndürülür, yoksa `null` döner.

---

## 📌 **Tam Kod**

```php
<?php

namespace App\Core;

use Dotenv\Dotenv;

class Config
{
    /**
     * @var array $config Uygulama yapılandırma ayarlarını tutar
     */
    private static $config = [];

    /**
     * .env dosyasını yükler ve yapılandırma ayarlarını ayarlar
     *
     * @return array Yapılandırma ayarları
     */
    public static function loadEnv()
    {
        if (empty(self::$config)) {
            $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
            $dotenv->load();

            self::$config = [
                'DB_HOST' => $_ENV['DB_HOST'],
                'DB_NAME' => $_ENV['DB_NAME'],
                'DB_USER' => $_ENV['DB_USER'],
                'DB_PASSWORD' => $_ENV['DB_PASSWORD'],
                'DB_CHARSET' => $_ENV['DB_CHARSET'],
                'IYZIPAY_API_KEY' => $_ENV['IYZIPAY_API_KEY'],
                'IYZIPAY_SECRET_KEY' => $_ENV['IYZIPAY_SECRET_KEY'],
                'IYZIPAY_BASE_URL' => $_ENV['IYZIPAY_BASE_URL']
            ];
        }

        return self::$config;
    }

    /**
     * Belirtilen anahtara göre yapılandırma ayarını döner
     *
     * @param string $key Yapılandırma anahtarı
     * @return mixed|null Yapılandırma değeri veya null
     */
    public static function get($key)
    {
        $config = self::loadEnv();
        return $config[$key] ?? null;
    }
}

```

---

### **📌 Eğitim Yönlendirmesi**
Bu kodu **`Config.php`** dosyasına ekleyin. Ardından, `.env` dosyanızı oluşturup gerekli değişkenleri tanımlayarak projede yapılandırma işlemini tamamlayabilirsiniz. 🚀

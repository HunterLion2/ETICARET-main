# Database.php Dosyasının Açıklaması

Bu dökümanda **Database.php** dosyasının işleyişi adım adım açıklanacaktır. **Database.php**, veritabanı bağlantısını yönetmek ve veritabanı işlemlerini gerçekleştirmek için kullanılan bir sınıftır.

---

## 1. **Namespace Tanımlaması**

```php
namespace App\Core;
```
Bu satır, **Database.php** dosyasının **App\Core** isim alanı (namespace) içinde olduğunu belirtir. Böylece diğer dosyalarda **App\Core\Database** olarak çağrılabilir.

---

## 2. **Gerekli Sınıfların Dahil Edilmesi**

```php
use PDO;
use PDOException;
```
Bu satırlar **PDO** ve **PDOException** sınıflarını içeri aktarır. **PDO**, PHP'de veritabanı bağlantısı için kullanılan bir sınıftır.

---

## 3. **Database Sınıfının Tanımlanması**

```php
class Database
```
Bu kod **Database** sınıfını tanımlar. **Database** sınıfı, veritabanı bağlantısını yönetmek ve SQL sorguları çalıştırmak için oluşturulmuştur.

---

## 4. **Singleton Deseni İçin Değişkenler**

```php
private static $instance = null;
private $connection;
```
- **$instance**: **Singleton deseni**ni uygulamak için kullanılır. Böylece **Database** sınıfının yalnızca bir örneği oluşturulur.
- **$connection**: **PDO** bağlantısını tutar.

---

## 5. **Yapıcı Metot (`__construct`)**

```php
public function __construct()
```
Bu metot **Database** sınıfı çağrıldığında çalışır. Yapıcı metodun işlevleri:

1. **Veritabanı yapılandırmasını (`Config::loadEnv()`) yükler.**
2. **DSN (Data Source Name) oluşturur.**
3. **PDO kullanarak veritabanı bağlantısını oluşturur.**
4. **Bağlantı hatası oluşursa bir hata mesajı ile sonlandırır.**

```php
$dsn = "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset={$config['DB_CHARSET']}";
```
Bu satır, MySQL bağlantısı için **DSN** oluşturur.

```php
$this->connection = new PDO($dsn, $config['DB_USER'], $config['DB_PASSWORD'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
]);
```
Bu kod **PDO** sınıfını kullanarak veritabanına bağlanır ve bağlantı seçeneklerini belirler:
- **Hata modu**: `PDO::ERRMODE_EXCEPTION` (Hata durumunda istisna fırlatır.)
- **Varsayılan veri çekme modu**: `PDO::FETCH_ASSOC` (Sonuçları dizi olarak döndürür.)
- **Hazırlanan ifadeleri emüle etmeyi kapatma**: `PDO::ATTR_EMULATE_PREPARES => false`

---

## 6. **Singleton Metodu (`getInstance`)**

```php
public static function getInstance()
```
Bu metot **Database** sınıfının yalnızca bir örneğinin oluşturulmasını sağlar. Eğer sınıf zaten başlatılmışsa, mevcut bağlantıyı döndürür.

```php
if (self::$instance === null) {
    self::$instance = new self();
}
```
Eğer `$instance` değişkeni **null** ise yeni bir **Database** örneği oluşturulur.

```php
return self::$instance->connection;
```
Sonuç olarak **PDO bağlantısı** döndürülür.

---

## 7. **SQL Sorgularını Çalıştıran Metot (`query`)**

```php
public function query($query, $params = [])
```
Bu metot SQL sorgularını çalıştırmak için kullanılır.

```php
$stmt = $this->connection->prepare($query);
$stmt->execute($params);
return $stmt;
```
- **$query**: Çalıştırılacak SQL sorgusunu alır.
- **$params**: Sorguya gönderilecek parametreleri içerir.
- **prepare()**: Sorguyu hazırlar.
- **execute()**: Sorguyu çalıştırır.
- **return $stmt;**: Sorgu sonucunu döndürür.

---

## 8. **Klonlama ve Serileştirme Engelleme**

```php
private function __clone() {}
public function __wakeup() {}
```
Bu metotlar **Singleton tasarım deseni** gereği, sınıfın klonlanmasını ve serileştirilmesini engeller.

---

## **Tam Kod**

```php
<?php

namespace App\Core; // App\Core ad alanını tanımlar

use PDO; // PDO sınıfını kullanmak için içe aktarır
use PDOException; // PDOException sınıfını kullanmak için içe aktarır

class Database
{
    /**
     * Singleton deseni için tek örnek değişkeni
     *
     * @var Database|null
     */
    private static $instance = null;

    /**
     * Veritabanı bağlantısını tutacak değişken
     *
     * @var PDO
     */
    private $connection;

    /**
     * Yapıcı metod, sınıfın dışından çağrılabilir
     */
    public function __construct()
    {
        $config = Config::loadEnv(); // Ortam değişkenlerini yükler

        // DSN (Data Source Name) oluşturur
        $dsn = "mysql:host={$config['DB_HOST']};dbname={$config['DB_NAME']};charset={$config['DB_CHARSET']}";
        try {
            // PDO nesnesi oluşturur ve bağlantı kurar
            $this->connection = new PDO($dsn, $config['DB_USER'], $config['DB_PASSWORD'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Hata modunu istisna olarak ayarlar
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Varsayılan veri çekme modunu ayarlar
                PDO::ATTR_EMULATE_PREPARES => false, // Hazırlanan ifadelerin emülasyonunu devre dışı bırakır
            ]);
        } catch (PDOException $e) {
            // Bağlantı hatası durumunda hata mesajı ile sonlandırır
            die("Veritabanı bağlantı hatası: " . $e->getMessage());
        }
    }

    /**
     * Singleton deseni için örnek döndüren metod
     *
     * @return PDO
     */
    public static function getInstance()
    {
        if (self::$instance === null) { // Eğer örnek yoksa yeni bir örnek oluşturur
            self::$instance = new self();
        }
        return self::$instance->connection; // Veritabanı bağlantısını döner
    }

    /**
     * Veritabanı sorgusu çalıştırır
     *
     * @param string $query SQL sorgusu
     * @param array $params Sorgu parametreleri
     * @return \PDOStatement
     */
    public function query($query, $params = [])
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Veritabanı sorgusu hazırlar
     *
     * @param string $query SQL sorgusu
     * @return \PDOStatement
     */
    public function prepare($query)
    {
        return $this->connection->prepare($query);
    }

    /**
     * Klonlamayı devre dışı bırakır
     */
    private function __clone() {}

    /**
     * Serileştirmeyi devre dışı bırakır
     */
    public function __wakeup() {}
}

```

---

📌 **Bu kodu `Database.php` dosyanıza ekleyin ve kullanmaya başlayın!** ✅
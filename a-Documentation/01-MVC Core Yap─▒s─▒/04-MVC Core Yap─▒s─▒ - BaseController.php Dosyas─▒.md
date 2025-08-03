# BaseController.php Dosyasının Açıklaması

Bu doküman, **BaseController.php** dosyasını adım adım açıklamak için hazırlanmıştır. MVC mimarisinde temel kontrolcü olarak kullanılan bu sınıf, uygulama genelinde oturum yönetimi, ayarlar, kategoriler ve görünümlerin çağrılması gibi işlemleri yönetir.

---

## 📌 **1. Namespace ve Kullanılan Modeller**

```php
namespace App\Core;
 
use App\Models\SettingsModel;
use App\Models\CategoryModel;
use App\Models\CartModel;
```

**Açıklama:**
- `namespace App\Core;` → **BaseController** sınıfının **App\Core** isim alanında olduğunu belirtir.
- `use App\Models\SettingsModel;` → **Site ayarlarını** almak için SettingsModel sınıfını dahil eder.
- `use App\Models\CategoryModel;` → **Kategori listesini** almak için CategoryModel sınıfını dahil eder.
- `use App\Models\CartModel;` → **Kullanıcının sepetinde kaç ürün olduğunu** almak için CartModel sınıfını dahil eder.

---

## 📌 **2. Sınıf Tanımı ve Değişkenler**

```php
class BaseController
{
    protected $settings = [];
    protected $categories = [];
    protected $cartItemCount = 0;
    protected $userId;
```

**Açıklama:**
- **`$settings`** → **Site ayarlarını** tutan değişken.
- **`$categories`** → **Kategori listesini** tutan değişken.
- **`$cartItemCount`** → Kullanıcının **sepetindeki ürün sayısını** tutan değişken.
- **`$userId`** → **Oturum açan kullanıcının ID'sini** saklar.

---

## 📌 **3. Yapıcı (Constructor) Metodu**

```php
public function __construct()
{
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $this->setSessionTimeout();

    $settingsModel = new SettingsModel();
    $this->settings = $settingsModel->getAllSettings();

    $categoryModel = new CategoryModel();
    $this->categories = $categoryModel->getActiveCategories();

    if (isset($_SESSION['user_id'])) {
        $this->userId = $_SESSION['user_id'];
        $cartModel = new CartModel();
        $this->cartItemCount = $cartModel->getCartItemCountByUserId($this->userId);
    }
}
```

**Açıklama:**
- **Oturum başlatma:** `session_start();` çağrılarak PHP oturumu başlatılır.
- **Oturum süresi ayarlanır.** `setSessionTimeout()` çağrılarak zaman aşımı kontrol edilir.
- **Ayarlar yüklenir:** `SettingsModel` kullanılarak veritabanından site ayarları çekilir.
- **Kategoriler yüklenir:** `CategoryModel` ile aktif kategoriler alınır.
- **Kullanıcı giriş yaptıysa:** `CartModel` ile kullanıcının sepetindeki ürün sayısı hesaplanır.

---

## 📌 **4. Kullanıcı Giriş Kontrolü**

```php
private function checkLogin()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: /login');
        exit();
    }

    if ($_SESSION['user_role'] !== 'admin') {
        header('Location: /');
        exit();
    }
}
```

**Açıklama:**
- Kullanıcı giriş yapmamışsa, **login sayfasına yönlendirilir.**
- Kullanıcı **admin değilse**, ana sayfaya yönlendirilir.

---

## 📌 **5. Görünüm (View) Yükleme Metodu**

```php
public function render($view, $data = [], $statusCode = 200)
{
    http_response_code($statusCode);
    
    $data['settings'] = $this->settings;
    $data['categories'] = $this->categories;
    $data['cartItemCount'] = $this->cartItemCount;
    $data['session'] = $_SESSION;
    
    extract($data);

    require_once __DIR__ . "/../../views/layouts/front/header.php";
    require_once __DIR__ . "/../../views/$view.php";
    require_once __DIR__ . "/../../views/layouts/front/footer.php";
}
```

**Açıklama:**
- HTTP yanıt kodunu ayarlar.
- **Site ayarları, kategoriler ve sepet bilgileri** gibi verileri `$data` değişkenine aktarır.
- **`extract($data);`** ile `$data` dizisindeki değişkenleri doğrudan kullanılabilir hale getirir.
- Header, içerik (view) ve footer dosyalarını çağırarak **sayfa düzenini oluşturur.**

---

## 📌 **6. Admin Görünüm Yükleme Metodu**

```php
public function renderAdmin($view, $data = [])
{
    $this->checkLogin();
    $data['session'] = $_SESSION;
    extract($data);

    require_once __DIR__ . "/../../views/layouts/admin/header.php";
    require_once __DIR__ . "/../../views/$view.php";
    require_once __DIR__ . "/../../views/layouts/admin/footer.php";
}
```

**Açıklama:**
- **Admin paneline giriş kontrolü yapar.**
- Kullanıcı giriş yapmamışsa, **login sayfasına yönlendirir.**
- **Admin paneline özel header ve footer dosyaları ile** sayfa içeriğini oluşturur.

---

## 📌 **7. Tam BaseController.php Kodu**

```php
<?php

namespace App\Core;

use App\Models\SettingsModel;
use App\Models\CategoryModel;
use App\Models\CartModel;

class BaseController
{
    protected $settings = [];
    protected $categories = [];
    protected $cartItemCount = 0;
    protected $userId;

    /**
     * BaseController constructor.
     * Oturum başlatma ve oturum süresi ayarlama
     */
    public function __construct()
    {
        // Oturum başlatma ve oturum süresi ayarlama
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // SettingsModel kullanarak ayarları yükle
        $settingsModel = new SettingsModel();
        $this->settings = $settingsModel->getAllSettings();

        // CategoryModel'den kategorileri al
        $categoryModel = new CategoryModel();
        $this->categories = $categoryModel->getActiveCategories();

        // Sepetteki ürün sayısını al
        if (isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
            $cartModel = new CartModel();
            $this->cartItemCount = $cartModel->getCartItemCountByUserId($this->userId);
        }

        // checkLogin metodunu renderAdmin içinde çağıracağız
    }


    /**
     * Kullanıcı giriş kontrolü
     */
    private function checkLogin()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }

        if ($_SESSION['user_role'] !== 'admin') {
            header('Location: /');
            exit();
        }
    }

    /**
     * View render etme metodu
     *
     * @param string $view Görünüm dosyası
     * @param array $data Görünüme aktarılacak veri
     * @param int $statusCode HTTP durum kodu
     */
    public function render($view, $data = [], $statusCode = 200)
    {
        http_response_code($statusCode);

        // Settings verilerini $data içine dahil et
        $data['settings'] = $this->settings;
        $data['categories'] = $this->categories;
        $data['cartItemCount'] = $this->cartItemCount;

        $data['session'] = $_SESSION;

        // Verileri kullanılabilir hale getirme
        extract($data);

        // Layout ve view dosyalarını dahil et
        require_once __DIR__ . "/../../views/layouts/front/header.php";
        require_once __DIR__ . "/../../views/$view.php";
        require_once __DIR__ . "/../../views/layouts/front/footer.php";
    }

    /**
     * Admin view render etme metodu
     *
     * @param string $view Görünüm dosyası
     * @param array $data Görünüme aktarılacak veri
     */
    public function renderAdmin($view, $data = [])
    {
        $this->checkLogin(); // Admin sayfaları için login kontrolü

        $data['session'] = $_SESSION;

        // Verileri kullanılabilir hale getirme
        extract($data);

        // Layout ve view dosyalarını dahil et
        require_once __DIR__ . "/../../views/layouts/admin/header.php";
        require_once __DIR__ . "/../../views/$view.php";
        require_once __DIR__ . "/../../views/layouts/admin/footer.php";
    }
}

```

🎯 **Bu kodu `app/Core/BaseController.php` dosyanıza yerleştirin!** 🚀

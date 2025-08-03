# MVC Çalışma Mantığını Kafanızda Oturtmak

Bu eğitimde, **Model-View-Controller (MVC)** yapısını anlamanızı kolaylaştırmak için temel bileşenleri sadeleştirdik. Amacımız, bir modül oluştururken hangi adımları takip etmeniz gerektiğini açıklamak ve bu süreci daha anlaşılır hale getirmek.

* Aşağıda ki yöntemleri uyguladıktan sonra geri almanız gerekecek. Mevcut projenizin yedeğini almanızı öneririz. Eğer bu dökümanı eğitmeniniz ile birlikte video şeklinde uyguluyorsanız sadece mantığı anlamanız için eğitmeninizin yönergelerini takip edebilirsiniz.
---

## **1. HomeController.php'nin Sadeleştirilmesi**

HomeController, gereksiz bağımlılıklardan arındırıldı. Bu sayede **Controller** bileşeninin nasıl çalıştığını daha net görebileceksiniz. Controller, istemciden gelen isteklere yanıt veren, modeli çağıran ve sonucu görüntüye aktaran bir yapıdır.

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;


class HomeController extends BaseController
{
    public function index()
    {
        $this->render('front/home');
    }
}
```

## **2. BaseController.php Üzerinde Yapılan Düzenlemeler**
Bazı bağımlılıklar içeren fonksiyonlar **yorum satırına alındı**. Bunun nedeni, temel mantığı anlamanızı kolaylaştırmak ve ek bağımlılıkların sistemde nasıl entegre edilebileceğini daha iyi göstermek.

```php
<?php

namespace App\Core;

// use App\Models\SettingsModel;
// use App\Models\CategoryModel;
// use App\Models\CartModel;

class BaseController
{
    // protected $settings = [];
    // protected $categories = [];
    // protected $cartItemCount = 0;
    // protected $userId;

    /**
     * BaseController constructor.
     * Oturum başlatma ve oturum süresi ayarlama
     */
    public function __construct()
    {
        // Oturum başlatma ve oturum süresi ayarlama
        // if (session_status() == PHP_SESSION_NONE) {
        //     session_start();
        // }

        // SettingsModel kullanarak ayarları yükle
        // $settingsModel = new SettingsModel();
        // $this->settings = $settingsModel->getAllSettings();

        // CategoryModel'den kategorileri al
        // $categoryModel = new CategoryModel();
        // $this->categories = $categoryModel->getActiveCategories();

        // Sepetteki ürün sayısını al
        // if (isset($_SESSION['user_id'])) {
        //     $this->userId = $_SESSION['user_id'];
        //     $cartModel = new CartModel();
        //     $this->cartItemCount = $cartModel->getCartItemCountByUserId($this->userId);
        // }

        // checkLogin metodunu renderAdmin içinde çağıracağız
    }


    /**
     * Kullanıcı giriş kontrolü
     */
    // private function checkLogin()
    // {
    //     if (!isset($_SESSION['user_id'])) {
    //         header('Location: /login');
    //         exit();
    //     }

    //     if ($_SESSION['user_role'] !== 'admin') {
    //         header('Location: /');
    //         exit();
    //     }
    // }

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
        // $data['settings'] = $this->settings;
        // $data['categories'] = $this->categories;
        // $data['cartItemCount'] = $this->cartItemCount;

        // $data['session'] = $_SESSION;

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
     * @param string $view Görü11-nüm dosyası
     * @param array $data Görünüme aktarılacak veri
     */
    public function renderAdmin($view, $data = [])
    {
        // $this->checkLogin(); // Admin sayfaları için login kontrolü

        // $data['session'] = $_SESSION;

        // Verileri kullanılabilir hale getirme
        extract($data);

        // Layout ve view dosyalarını dahil et
        require_once __DIR__ . "/../../views/layouts/admin/header.php";
        require_once __DIR__ . "/../../views/$view.php";
        require_once __DIR__ . "/../../views/layouts/admin/footer.php";
    }
}

```

## **3. View/Home.php Güncellendi**
Bu dosyada **"Anasayfa Görüntülendi"** metni görüntülenecek şekilde düzenlendi. Buradaki amaç, **View (Görünüm)** bileşeninin nasıl çalıştığını ve istemciye nasıl veri sunduğunu anlamanızı sağlamak.

```text
Anasayfa Görüntülendi.
```

## **4. Public/index.php ve Yönlendirme Mekanizması**
Public/index.php içerisinde yer alan 

```php
Route::add('/', 'Front\HomeController@index');
```

kod satırı sayesinde **Anasayfa Görüntülenecek**. Bu yapı, **Routing (Yönlendirme)** mekanizmasını kavramanızı ve bir sayfanın nasıl çağrıldığını anlamanızı kolaylaştıracak.

---


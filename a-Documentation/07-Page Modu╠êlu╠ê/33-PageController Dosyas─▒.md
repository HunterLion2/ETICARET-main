# **PageController Kullanımı ve Sayfa Gösterimi**

Bu eğitim dokümanında, **PageController’ın nasıl çalıştığını, sayfaların nasıl listeleneceğini ve slug ile nasıl çağrılacağını** öğreneceksiniz. **Bu controller, belirli bir slug’a sahip sayfanın gösterilmesini sağlar.**

---

## **1. PageController Sınıfının Tanıtımı**

```php
namespace App\Controllers\Front;

use App\Models\PageModel;
use App\Core\BaseController;
```

### **Ne İşe Yarar?**
✅ `namespace App\Controllers\Front;` → **Controller’ın uygulamanın ön yüz (Front) modülüne ait olduğunu belirtir.**
✅ `use App\Models\PageModel;` → **Sayfa veritabanı işlemlerini yönetmek için PageModel’i dahil eder.**
✅ `use App\Core\BaseController;` → **Temel Controller sınıfını dahil eder.**

---

## **2. PageController İçerisinde PageModel Kullanımı**

```php
private $pageModel;

public function __construct()
{
    parent::__construct();
    $this->pageModel = new PageModel();
}
```

### **Ne İşe Yarar?**
✅ `$pageModel` değişkeni, **PageModel sınıfına erişim sağlamak için kullanılır.**
✅ `parent::__construct();` → **BaseController sınıfının constructor metodunu çağırarak temel işlemleri gerçekleştirir.**
✅ `$this->pageModel = new PageModel();` → **PageModel sınıfının bir örneği oluşturularak sayfa işlemlerine erişim sağlanır.**

---

## **3. Belirtilen Slug’a Göre Sayfa Gösterimi**

```php
public function show($slug)
{
    // Slug'a göre sayfa bilgilerini al
    $page = $this->pageModel->getPageBySlug($slug);

    // Sayfa bulunduysa sayfa görünümünü render et
    if ($page) {
        $this->render('front/page', ['page' => $page]);
    } else {
        // Sayfa bulunamadıysa 404 hata sayfasını render et
        $this->render('errors/404');
    }
}
```

### **Ne İşe Yarar?**
✅ `getPageBySlug($slug);` → **Belirtilen slug’a sahip sayfanın bilgilerini getirir.**
✅ `$this->render('front/page', ['page' => $page]);` → **Sayfa verilerini ilgili görünüm (view) dosyasına göndererek sayfanın görüntülenmesini sağlar.**
✅ **Eğer slug’a sahip bir sayfa bulunamazsa, 404 hata sayfası gösterilir.**

🔹 **Örnek Kullanım:**
```php
$pageController = new PageController();
$pageController->show('hakkimizda');
```
Bu kod, **slug’ı ‘hakkimizda’ olan sayfayı görüntüler.**

---

## **4. PageController’ın Tarayıcıda Test Edilmesi**

1. **Web tarayıcınızı açın.**
2. **Belirli bir sayfayı görmek için aşağıdaki URL’yi açın:**
   ```
   http://localhost/page/hakkimizda
   ```
3. **Eğer hata alıyorsanız, aşağıdaki kontrolleri yapın:**
   - `routes.php` içinde aşağıdaki route’un olup olmadığını kontrol edin:
     ```php
     Route::add('page/([a-zA-Z0-9_-]+)', 'Front\PageController@show');
     ```
   - **Veritabanında ilgili sayfanın olup olmadığını kontrol edin.**
   - **PageModel’in doğru şekilde yüklendiğinden emin olun.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Models\PageModel;
use App\Core\BaseController;

class PageController extends BaseController
{
    /**
     * @var PageModel $pageModel Page model örneği
     */
    private $pageModel;

    /**
     * PageController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve PageModel örneğini oluşturur.
     */
    public function __construct()
    {
        // Üst sınıfın yapıcı metodunu çağır
        parent::__construct();

        // PageModel örneğini oluştur
        $this->pageModel = new PageModel();
    }

    /**
     * Belirtilen slug'a göre sayfa gösterimini sağlar.
     *
     * @param string $slug Sayfa slug değeri
     */
    public function show($slug)
    {
        // Slug'a göre sayfa bilgilerini al
        $page = $this->pageModel->getPageBySlug($slug);

        // Sayfa bulunduysa sayfa görünümünü render et
        if ($page) {
            $this->render('front/page', ['page' => $page]);
        } else {
            // Sayfa bulunamadıysa 404 hata sayfasını render et
            $this->render('errors/404');
        }
    }
}
```
---

## **Sonuç**

Bu eğitimde, **PageController’ın nasıl çalıştığını, slug ile sayfa getirmenin nasıl yapıldığını ve hata yönetiminin nasıl sağlandığını** öğrendiniz. **Şimdi, PageController’ınızı test ederek dinamik sayfa yönetimini sağlayabilirsiniz!** 🚀
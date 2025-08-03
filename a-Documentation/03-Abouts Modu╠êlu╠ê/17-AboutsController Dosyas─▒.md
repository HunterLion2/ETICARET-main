# **AboutsController Kullanımı ve Hakkında Sayfasının Yönetimi**
 
Bu eğitim dokümanında, **PHP ile MVC yapısında bir Controller sınıfının nasıl oluşturulacağını** ve **hakkında sayfasının nasıl yönetileceğini** öğreneceksiniz. **AboutsController** sınıfı, `about` verilerini alıp kullanıcıya sunmak için geliştirilmiştir.

---

## **1. AboutsController Sınıfının Tanıtımı**

```php
namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\AboutModel;
```

### **Ne İşe Yarar?**
✅ `namespace App\Controllers\Front;` → Controller'ın **Front (ön yüz) modülüne** ait olduğunu belirtir.
✅ `use App\Core\BaseController;` → **Ana controller sınıfını** çağırır.
✅ `use App\Models\AboutModel;` → **Hakkında bilgilerini yöneten model sınıfını** projeye dahil eder.

---

## **2. Controller İçerisinde AboutModel Kullanımı**

```php
protected $aboutModel;

public function __construct()
{
    parent::__construct();
    $this->aboutModel = new AboutModel();
}
```

### **Ne İşe Yarar?**
✅ `protected $aboutModel;` → **AboutModel sınıfına erişim sağlamak için** değişken tanımlanır.
✅ `parent::__construct();` → **BaseController’ın yapıcı metodu çağrılarak** temel işlemler gerçekleştirilir.
✅ `$this->aboutModel = new AboutModel();` → **AboutModel sınıfının bir örneği oluşturulur.**

🔹 **Örnek Kullanım:**
```php
$aboutsController = new AboutsController();
```

---

## **3. Hakkında Sayfasını Görüntüleme**

```php
public function index()
{
    // AboutModel'i kullanarak verileri al
    $about = $this->aboutModel->getAbout();

    // Verileri view'a gönder
    $this->render('front/abouts', [
        'about' => $about
    ]);
}
```

### **Ne İşe Yarar?**
✅ `getAbout();` → **AboutModel kullanılarak** hakkında bilgileri veritabanından alır.
✅ `$this->render('front/abouts', [...]);` → **Görünüm dosyasına verileri göndererek sayfa oluşturur.**

🔹 **Örnek Kullanım:**
```php
$aboutsController = new AboutsController();
$aboutsController->index();
```

---

## **4. Hakkında Sayfasını Tarayıcıda Gösterme**

Controller sınıfını bir **route** ile bağlamanız gerekir. Örneğin:

```php
Route::add('abouts', 'Front\AboutsController@index');
```

Bu durumda **"/about"** adresine gidildiğinde **AboutsController’ın `index` metodu çalışacaktır.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\AboutModel;

/**
 * AboutsController sınıfı, hakkında sayfası ile ilgili işlemleri yönetir.
 */
class AboutsController extends BaseController
{
    /** 
     * @var AboutModel $aboutModel Hakkında bilgilerini yöneten model
     */
    protected $aboutModel;

    /**
     * AboutsController constructor.
     * AboutModel örneğini oluşturur ve BaseController'ın yapıcı metodunu çağırır.
     */
    public function __construct()
    {
        parent::__construct();
        $this->aboutModel = new AboutModel();
    }

    /**
     * Hakkında sayfasını görüntüler.
     */
    public function index()
    {
        // AboutModel'i kullanarak verileri al
        $about = $this->aboutModel->getAbout();

        // Verileri view'a gönder
        $this->render('front/abouts', [
            'about' => $about
        ]);
    }
}

```
—


## **Sonuç**

Bu eğitimde **AboutsController sınıfının nasıl çalıştığını, model ile nasıl iletişim kurduğunu ve verileri nasıl görüntülediğini** öğrendiniz. Şimdi öğrendiklerinizi projelerinizde uygulayabilirsiniz! 🚀

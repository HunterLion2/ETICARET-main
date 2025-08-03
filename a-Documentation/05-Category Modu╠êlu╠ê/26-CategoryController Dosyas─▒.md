# **CategoryController Kullanımı ve Kategoriye Ait Ürünlerin Gösterimi**

Bu eğitim dokümanında, **CategoryController’ın nasıl çalıştığını**, **kategoriye ait ürünlerin nasıl getirildiğini** ve **view dosyasına nasıl aktarıldığını** öğreneceksiniz. 

---

## **1. CategoryController Sınıfının Tanıtımı**

```php
namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\CategoryModel;
```

### **Ne İşe Yarar?**
✅ `namespace App\Controllers\Front;` → **Controller'ın uygulamanın ön yüz (Front) modülüne ait olduğunu belirtir.**
✅ `use App\Core\BaseController;` → **Temel Controller sınıfını dahil eder.**
✅ `use App\Models\CategoryModel;` → **Kategori veritabanı işlemlerini yönetmek için CategoryModel’i dahil eder.**

---

## **2. CategoryController İçerisinde CategoryModel Kullanımı**

```php
private $categoryModel;

public function __construct()
{
    parent::__construct(); // Üst sınıfın yapıcı metodunu çağır
    $this->categoryModel = new CategoryModel(); // CategoryModel örneğini oluştur
}
```

### **Ne İşe Yarar?**
✅ `$categoryModel` değişkeni, **CategoryModel sınıfına erişim sağlamak için** kullanılır.
✅ `parent::__construct();` → **BaseController sınıfının constructor metodunu çağırarak temel işlemleri gerçekleştirir.**
✅ `$this->categoryModel = new CategoryModel();` → **CategoryModel sınıfının bir örneği oluşturularak kategorilere ait işlemler yapılmasını sağlar.**

🔹 **Örnek Kullanım:**
```php
$categoryController = new CategoryController();
```

---

## **3. Belirtilen Kategoriye Ait Ürünleri Getirme**

```php
public function show($categorySlug)
{
    // CategoryModel'i kullanarak ürünleri al
    $products = $this->categoryModel->getProductsByCategorySlug($categorySlug);

    // Verileri view'a gönder 
    $this->render('front/category', [
        'products' => $products // Ürün verileri
    ]);
}
```

### **Ne İşe Yarar?**
✅ `getProductsByCategorySlug($categorySlug);` → **Belirtilen kategoriye ait ürünleri veritabanından çeker.**
✅ `$this->render('front/category', ['products' => $products]);` → **Verileri ilgili görünüm (view) dosyasına göndererek ürünlerin kullanıcıya gösterilmesini sağlar.**

🔹 **Örnek Kullanım:**
```php
$categoryController = new CategoryController();
$categoryController->show('elektronik');
```
Bu kod, **kategori slug’ı ‘elektronik’ olan ürünleri listeler.**

---

## **4. CategoryController’ın Tarayıcıda Test Edilmesi**

1. **Web tarayıcınızı açın.**
2. Adres çubuğuna şu URL’yi yazın:
   ```
   http://localhost/category/elektronik
   ```
3. **Eğer her şey doğru tanımlandıysa, seçilen kategoriye ait ürünler listelenecektir.**
4. **Eğer hata alıyorsanız, aşağıdaki kontrolleri yapın:**
   - `routes.php` içinde aşağıdaki route’un olup olmadığını kontrol edin:
     ```php
     Route::add('category/([a-zA-Z0-9_-]+)', 'Front\CategoryController@show');
     ```
   - **Veritabanında ilgili kategoriye ait ürünlerin olup olmadığını kontrol edin.**
   - **CategoryModel’in doğru şekilde yüklendiğinden emin olun.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    /**
     * @var CategoryModel $categoryModel Kategori modeli örneği
     */
    private $categoryModel;

    /**
     * CategoryController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve CategoryModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct(); // Üst sınıfın yapıcı metodunu çağır
        $this->categoryModel = new CategoryModel(); // CategoryModel örne��ini oluştur
    }

    /**
     * Belirtilen kategoriye ait ürünleri gösterir.
     *
     * @param string $categorySlug Kategori slug'ı
     */
    public function show($categorySlug)
    {
        // CategoryModel'i kullanarak ürünleri al
        $products = $this->categoryModel->getProductsByCategorySlug($categorySlug);

        // Verileri view'a gönder 
        $this->render('front/category', [
            'products' => $products // Ürün verileri
        ]);
    }
}

```
—--


## **Sonuç**

Bu eğitimde, **CategoryController’ın nasıl çalıştığını, model ile nasıl iletişim kurduğunu ve verileri nasıl görüntülediğini** öğrendiniz. **Şimdi, CategoryController’ınızı test ederek kategori bazlı ürünleri gösterebilirsiniz!** 🚀
# **ProductController Kullanımı ve Ürün Detay Gösterimi**

Bu eğitim dokümanında, **ProductController’ın nasıl çalıştığını, ürünlerin nasıl listelendiğini ve slug ile nasıl çağrıldığını** öğreneceksiniz. **Bu controller, belirli bir ürünün detay sayfasına yönlendirilmesini sağlar.**

---

## **1. ProductController Sınıfının Tanıtımı**

```php
namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\ProductModel;
```

### **Ne İşe Yarar?**
✅ `namespace App\Controllers\Front;` → **Controller’ın uygulamanın ön yüz (Front) modülüne ait olduğunu belirtir.**
✅ `use App\Core\BaseController;` → **Temel Controller sınıfını dahil eder.**
✅ `use App\Models\ProductModel;` → **Ürün veritabanı işlemlerini yönetmek için ProductModel’i dahil eder.**

---

## **2. ProductController İçerisinde ProductModel Kullanımı**

```php
private $productModel;

public function __construct()
{
    parent::__construct();
    $this->productModel = new ProductModel();
}
```

### **Ne İşe Yarar?**
✅ `$productModel` değişkeni, **ProductModel sınıfına erişim sağlamak için kullanılır.**
✅ `parent::__construct();` → **BaseController sınıfının constructor metodunu çağırarak temel işlemleri gerçekleştirir.**
✅ `$this->productModel = new ProductModel();` → **ProductModel sınıfının bir örneği oluşturularak ürün işlemlerine erişim sağlanır.**

---

## **3. Belirtilen Slug’a Göre Ürün Detayını Gösterme**

```php
public function detail($slug)
{
    // ProductModel'i kullanarak tek bir ürünü al
    $product = $this->productModel->getProductBySlugForFront($slug);

    // Ürüne ait galeri resimlerini al
    $galleryImages = $this->productModel->getProductGalleryImages($product['id']);

    // Verileri view'a gönder
    $this->render('front/product/detail', [
        'product' => $product, // Ürün verisi
        'galleryImages' => $galleryImages // Galeri resimleri
    ]);
}
```

### **Ne İşe Yarar?**
✅ `getProductBySlugForFront($slug);` → **Belirtilen slug’a sahip ürünün bilgilerini getirir.**
✅ `getProductGalleryImages($product['id']);` → **Ürüne ait galeri resimlerini getirir.**
✅ `$this->render('front/product/detail', [...]);` → **Ürün ve resimleri detay sayfasına gönderir.**

🔹 **Örnek Kullanım:**
```php
$productController = new ProductController();
$productController->detail('iphone-13-pro');
```
Bu kod, **slug’ı ‘iphone-13-pro’ olan ürünün detaylarını görüntüler.**

---

## **4. ProductController’ın Tarayıcıda Test Edilmesi**

1. **Web tarayıcınızı açın.**
2. **Belirli bir ürünün detaylarını görmek için aşağıdaki URL’yi açın:**
   ```
   http://localhost/product/iphone-13-pro
   ```
3. **Eğer hata alıyorsanız, aşağıdaki kontrolleri yapın:**
   - `routes.php` içinde aşağıdaki route’un olup olmadığını kontrol edin:
     ```php
     Route::add('product/([a-zA-Z0-9_-]+)', 'Front\ProductController@detail');
     ```
   - **Veritabanında ilgili slug’a sahip bir ürünün olup olmadığını doğrulayın.**
   - **ProductModel’in doğru şekilde yüklendiğinden emin olun.**

---

## **5. Güvenlik ve Veri Doğrulama**

🔹 **Ürün verisinin boş olup olmadığını kontrol etmek için şu kontrolü ekleyebilirsiniz:**
```php
if (!$product) {
    $this->render('errors/404'); // Eğer ürün bulunamazsa 404 sayfasına yönlendir
}
```
📌 **Bu, ürün bulunamazsa kullanıcıyı hata sayfasına yönlendirerek kullanıcı deneyimini iyileştirir.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\ProductModel;

class ProductController extends BaseController
{
    /**
     * @var ProductModel $productModel Ürün modeli örneği
     */
    private $productModel;

    /**
     * ProductController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve ProductModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
    }

    /**
     * Ürün detaylarını görüntüler.
     *
     * @param string $slug Ürünün slug değeri
     */
    public function detail($slug)
    {
        // ProductModel'i kullanarak tek bir ürünü al
        $product = $this->productModel->getProductBySlugForFront($slug);

        // Ürüne ait galeri resimlerini al
        $galleryImages = $this->productModel->getProductGalleryImages($product['id']);

        // Verileri view'a gönder
        $this->render('front/product/detail', [
            'product' => $product, // Ürün verisi
            'galleryImages' => $galleryImages // Galeri resimleri
        ]);
    }
}

```
---

## **Sonuç**

Bu eğitimde, **ProductController’ın nasıl çalıştığını, slug ile ürün detayının nasıl getirildiğini ve hata yönetiminin nasıl sağlandığını** öğrendiniz. **Şimdi, ProductController’ınızı test ederek ürün detay sayfasını kullanıcılarınıza sunabilirsiniz!** 🚀

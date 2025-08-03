# **HomeController Kullanımı - Anasayfa Yönetimi**

Bu eğitim dokümanında, **HomeController’in nasıl çalıştığını ve anasayfanın nasıl yönetildiğini** öğreneceksiniz. **Bu controller, sliderları, kampanyaları ve öne çıkan ürünleri alarak kullanıcıya sunmak için kullanılır.**

---

## **1. HomeController Sınıfının Tanıtımı**

```php
namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\SliderModel;
use App\Models\DealModel;
use App\Models\ProductModel;
```

### **Ne İşe Yarar?**
✅ **`namespace App\Controllers\Front;` → Controller’ın ön yüz (front) kısmında çalıştığını belirtir.**  
✅ **`use App\Models\SliderModel;` → Slider verilerini almak için SliderModel’i dahil eder.**
✅ **`use App\Models\DealModel;` → Kampanya verilerini almak için DealModel’i dahil eder.**
✅ **`use App\Models\ProductModel;` → Ürün verilerini almak için ProductModel’i dahil eder.**

---

## **2. Model Örneklerinin Tanımlanması**

```php
private $sliderModel;
private $dealModel;
private $productModel;
```

### **Ne İşe Yarar?**
✅ **SliderModel, DealModel ve ProductModel için özel değişkenler tanımlanır.**  
✅ **Bu değişkenler üzerinden modeller çağrılarak veriler alınabilir.**

---

## **3. Yapıcı Metot (Constructor)**

```php
public function __construct()
{
    parent::__construct();
    
    // Model örneklerini oluştur
    $this->sliderModel = new SliderModel();
    $this->dealModel = new DealModel();
    $this->productModel = new ProductModel();
}
```

### **Ne İşe Yarar?**
✅ **Üst sınıfın (BaseController) yapıcı metodunu çağırarak genel ayarları uygular.**  
✅ **SliderModel, DealModel ve ProductModel örneklerini oluşturur.**

📌 **Örnek Kullanım:**
```php
$homeController = new HomeController();
```

---

## **4. Anasayfa Verilerini Alma ve View’a Gönderme**

```php
public function index()
{
    // SliderModel'i kullanarak aktif slider verilerini al
    $sliders = $this->sliderModel->getActiveSliders();

    // DealModel'i kullanarak aktif kampanyaları al
    $deals = $this->dealModel->getActiveDeals();

    // ProductModel'i kullanarak öne çıkan ürünleri al
    $products = $this->productModel->getFeaturedProducts();
    $totalProductCount = $this->productModel->getTotalProductCount();

    // Verileri view'a gönder
    $this->render('front/home', [
        'sliders' => $sliders, // Slider verileri
        'deals' => $deals,     // Kampanya verileri
        'products' => $products, // Ürün verileri
        'totalProductCount' => $totalProductCount // Toplam ürün sayısı
    ]);
}
```

### **Ne İşe Yarar?**
✅ **Aktif sliderları, kampanyaları ve öne çıkan ürünleri alır.**  
✅ **Bu verileri view’a (`front/home`) göndererek anasayfada gösterilmesini sağlar.**

📌 **Örnek Kullanım:**
```php
$homeController->index();
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\SliderModel;
use App\Models\DealModel;
use App\Models\ProductModel;

class HomeController extends BaseController
{
    /**
     * @var SliderModel $sliderModel Slider model örneği
     * @var DealModel $dealModel Kampanya model örneği
     * @var ProductModel $productModel Ürün model örneği
     */
    private $sliderModel;
    private $dealModel;
    private $productModel;

    /** 
     * HomeController constructor.
     * Model örneklerini oluşturur ve üst sınıfın yapıcı metodunu çağırır.
     */
    public function __construct()
    {
        parent::__construct();

        // SliderModel örneğini oluştur
        $this->sliderModel = new SliderModel();

        // DealModel örneğini oluştur
        $this->dealModel = new DealModel();

        // ProductModel örneğini oluştur
        $this->productModel = new ProductModel();
    }

    /**
     * Anasayfa verilerini alır ve view'a gönderir.
     */
    public function index()
    {
        // SliderModel'i kullanarak aktif slider verilerini al
        $sliders = $this->sliderModel->getActiveSliders();

        // DealModel'i kullanarak aktif kampanyaları al
        $deals = $this->dealModel->getActiveDeals();

        // ProductModel'i kullanarak öne çıkan ürünleri al
        $products = $this->productModel->getFeaturedProducts();
        $totalProductCount = $this->productModel->getTotalProductCount();

        // Verileri view'a gönder
        $this->render('front/home', [
            'sliders' => $sliders, // Slider verileri
            'deals' => $deals,     // Kampanya verileri
            'products' => $products, // Ürün verileri
            'totalProductCount' => $totalProductCount // Toplam ürün sayısı
        ]);
    }
}

```
---

## **Sonuç**

Bu eğitimde, **HomeController’in nasıl çalıştığını, anasayfanın nasıl yönetildiğini ve tarayıcıda nasıl test edileceğini öğrendiniz.** **Artık, HomeController ile anasayfanın içeriğini yönetebilirsiniz! 🚀**

# SearchController Kullanımı ve Açıklaması

Bu dokümanda `SearchController` sınıfının nasıl çalıştığı ve nasıl kullanıldığı detaylı bir şekilde anlatılacaktır. Bu sınıf, kullanıcıların e-ticaret platformunda arama yapmalarını sağlayan bir kontrolör olarak görev yapar.

---

## 1. SearchController Nedir?

`SearchController`, kullanıcılardan gelen arama sorgularını işleyerek ilgili ürünleri `SearchModel` aracılığıyla veritabanında arayan bir kontrolör sınıfıdır. Kullanıcının girdiği arama kelimesine göre eşleşen ürünler ekrana getirilir.

---

## 2. SearchController Sınıfının İçeriği

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\SearchModel;

class SearchController extends BaseController
{
    /**
     * @var SearchModel $searchModel Arama işlemleri için kullanılan model
     */
    private $searchModel;

    /**
     * SearchController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve SearchModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->searchModel = new SearchModel();
    }

    /**
     * Arama sayfasını görüntüler.
     *
     * @return void
     */
    public function index()
    {
        // Kullanıcının arama sorgusunu alır, eğer sorgu yoksa boş string kullanır.
        $query = $_GET['query'] ?? '';

        // Arama modelini kullanarak ürünleri arar.
        $products = $this->searchModel->searchProducts($query);

        // Arama sonuçlarını ve sorguyu arayüze gönderir.
        $this->render('front/search', [
            'products' => $products,
            'query' => $query
        ]);
    }
}
```

---

## 3. SearchController Çalışma Mantığı

1. **Kullanıcı Arama Yapıyor:** Kullanıcı, arama formuna bir sorgu girdiğinde bu sorgu `GET` parametresi olarak `query` değişkenine atanır.
2. **Model Kullanılarak Arama Yapılıyor:** `SearchModel` sınıfı, veritabanında ilgili ürünleri arar ve sonuçları döndürür.
3. **Sonuçların Görüntülenmesi:** Bulunan ürünler `front/search` adlı görünüm dosyasına gönderilerek kullanıcıya gösterilir.

---

## 4. SearchController ile Arama İşlemi Nasıl Yapılır?

Kullanıcılar, aşağıdaki URL formatını kullanarak ürün araması yapabilir:

```
https://phpeticaretv5.test/search?query=telefon
```

Bu URL'ye girildiğinde `SearchController` şu işlemleri gerçekleştirir:

- `query` parametresini alır.
- `SearchModel` aracılığıyla veritabanında ürünleri arar.
- Elde edilen ürünleri `search` görünümüne aktarır.
- Kullanıcıya arama sonuçlarını gösterir.

---

## 5. SearchController Kullanımına Dair Notlar

- `query` parametresi boş olursa tüm ürünler getirilmez, bunun yerine boş bir liste döndürülür.
- Arama işlemi `LIKE` sorgusu ile yapıldığı için arama kelimesinin geçtiği tüm ürünler listelenir.
- Arama sonucu ürün bulunamazsa, kullanıcıya "Ürün bulunamadı" mesajı gösterilir.

---

## 6. Örnek Kullanım Senaryosu

### **1. Kullanıcı "Laptop" kelimesi ile arama yaparsa:**

Kullanıcı `https://phpeticaretv5.test/search?query=laptop` adresine giderse, `SearchController` şu işlemleri yapar:

1. `query` parametresini `$query` değişkenine atar (`laptop`).
2. `SearchModel` içinde `searchProducts($query)` metodunu çağırarak veritabanında `laptop` geçen ürünleri arar.
3. Bulunan ürünleri `front/search` görünümüne gönderir.
4. Kullanıcıya ilgili ürünleri listeler.

### **2. Kullanıcı boş bir arama yaparsa:**

- Eğer `query` parametresi boşsa (`https://phpeticaretv5.test/search`), herhangi bir ürün bulunamaz ve kullanıcıya "Ürün bulunamadı" mesajı gösterilir.

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\SearchModel;

class SearchController extends BaseController
{
    /**
     * @var SearchModel $searchModel Arama işlemleri için kullanılan model
     */
    private $searchModel;

    /**
     * SearchController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve SearchModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->searchModel = new SearchModel();
    }

    /**
     * Arama sayfasını görüntüler.
     * 
     * @return void
     */
    public function index()
    {
        // Kullanıcının arama sorgusunu alır, eğer sorgu yoksa boş string kullanır.
        $query = $_GET['query'] ?? '';

        // Arama modelini kullanarak ürünleri arar.
        $products = $this->searchModel->searchProducts($query);

        // Arama sonuçlarını ve sorguyu arayüze gönderir.
        $this->render('front/search', [
            'products' => $products,
            'query' => $query
        ]);
    }
}

```
---

## 7. Sonuç

`SearchController`, kullanıcıların kolayca arama yapmasını sağlamak için geliştirilmiştir. Model (`SearchModel`) ile etkileşime geçerek arama sonuçlarını getirir ve kullanıcıya listeler. Böylece e-ticaret platformundaki ürünleri aramak için dinamik bir çözüm sunulmuş olur.

Eğer arama ile ilgili geliştirme yapmanız gerekirse, `SearchModel` sınıfında sorgu kriterlerini değiştirebilir veya `index` metodunu özelleştirebilirsiniz.


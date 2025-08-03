# **BlogController Kullanımı ve Blog Sayfasının Yönetimi**

Bu eğitim dokümanında, **BlogController’ın nasıl çalıştığını, blog makalelerinin nasıl listeleneceğini ve detay sayfasının nasıl yönetileceğini** öğreneceksiniz. **Bu controller, blog makalelerinin listelenmesi ve belirli bir makalenin görüntülenmesini sağlar.**

---

## **1. BlogController Sınıfının Tanıtımı**

```php
namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\BlogModel;
```

### **Ne İşe Yarar?**
✅ `namespace App\Controllers\Front;` → **Controller'ın uygulamanın ön yüz (Front) modülüne ait olduğunu belirtir.**
✅ `use App\Core\BaseController;` → **Temel Controller sınıfını dahil eder.**
✅ `use App\Models\BlogModel;` → **Blog veritabanı işlemlerini yönetmek için BlogModel’i dahil eder.**

---

## **2. BlogController İçerisinde BlogModel Kullanımı**

```php
private $blogModel;

public function __construct()
{
    parent::__construct();
    $this->blogModel = new BlogModel();
}
```

### **Ne İşe Yarar?**
✅ `$blogModel` değişkeni, **BlogModel sınıfına erişim sağlamak için** kullanılır.
✅ `parent::__construct();` → **BaseController sınıfının constructor metodunu çağırarak temel işlemleri gerçekleştirir.**
✅ `$this->blogModel = new BlogModel();` → **BlogModel sınıfının bir örneği oluşturularak blog makalelerine ait işlemler yapılmasını sağlar.**

🔹 **Örnek Kullanım:**
```php
$blogController = new BlogController();
```

---

## **3. Blog Makalelerinin Listelenmesi**

```php
public function index()
{
    // BlogModel kullanarak tüm blog makalelerini al
    $posts = $this->blogModel->getAllPostsForFront();

    // Verileri view'a gönder
    $this->render('front/blog/index', [
        'posts' => $posts // Blog makaleleri
    ]);
}
```

### **Ne İşe Yarar?**
✅ `getAllPostsForFront();` → **Tüm blog gönderilerini alır ve sıralar.**
✅ `$this->render('front/blog/index', ['posts' => $posts]);` → **Verileri ilgili görünüm (view) dosyasına göndererek blog makalelerinin kullanıcıya gösterilmesini sağlar.**

🔹 **Örnek Kullanım:**
```php
$blogController = new BlogController();
$blogController->index();
```
Bu kod, **tüm blog makalelerini listeleyen sayfayı oluşturur.**

---

## **4. Belirli Bir Blog Makalesini Görüntüleme**

```php
public function detail($slug)
{
    // BlogModel kullanarak tek bir blog makalesini al
    $post = $this->blogModel->getPostBySlugForFront($slug);

    // Verileri view'a gönder
    $this->render('front/blog/detail', [
        'post' => $post // Blog makalesi
    ]);
}
```

### **Ne İşe Yarar?**
✅ `getPostBySlugForFront($slug);` → **Belirtilen slug’a sahip blog makalesini getirir.**
✅ `$this->render('front/blog/detail', ['post' => $post]);` → **Makale verilerini ilgili görünüm (view) dosyasına göndererek blog içeriğinin gösterilmesini sağlar.**

🔹 **Örnek Kullanım:**
```php
$blogController = new BlogController();
$blogController->detail('php-egitimleri');
```
Bu kod, **slug’ı ‘php-egitimleri’ olan blog makalesini görüntüler.**

---

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\BlogModel;

class BlogController extends BaseController
{
    /**
     * @var BlogModel $blogModel Blog model örneği
     */
    private $blogModel;

    /**
     * BlogController yapıcı metodu.
     * BlogModel örneğini başlatır ve üst sınıfın yapıcı metodunu çağırır.
     */
    public function __construct()
    {
        parent::__construct();
        $this->blogModel = new BlogModel();
    }

    /**
     * Blog makalelerinin listesini görüntüler.
     *
     * @return void
     */
    public function index()
    {
        // BlogModel kullanarak tüm blog makalelerini al
        $posts = $this->blogModel->getAllPostsForFront();

        // Verileri view'a gönder
        $this->render('front/blog/index', [
            'posts' => $posts // Blog makaleleri
        ]);
    }

    /**
     * Belirtilen blog makalesini görüntüler.
     *
     * @param string $slug Blog makalesinin slug'ı
     * @return void
     */
    public function detail($slug)
    {
        // BlogModel kullanarak tek bir blog makalesini al
        $post = $this->blogModel->getPostBySlugForFront($slug);

        // Verileri view'a gönder
        $this->render('front/blog/detail', [
            'post' => $post // Blog makalesi
        ]);
    }
}

```
---

## **Sonuç**

Bu eğitimde, **BlogController’ın nasıl çalıştığını, model ile nasıl iletişim kurduğunu ve verileri nasıl görüntülediğini** öğrendiniz. **Şimdi, BlogController’ınızı test ederek blog makalelerini kullanıcıya sunabilirsiniz!** 🚀

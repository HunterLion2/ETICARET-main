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

---

## **3. Blog Makalelerinin Listelenmesi (index.php)**

```html
<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Blog Makaleleri</h1>
        <i class="fas fa-blog fa-2x"></i>
    </div>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $post['thumbnail_url']; ?>" class="card-img-top" alt="<?php echo $post['title']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post['title']; ?></h5>
                        <p class="card-text"><?php echo substr($post['content'], 0, 100); ?>...</p>
                        <a href="/blog/<?php echo $post['slug']; ?>" class="btn btn-secondary">Devamını Oku</a>
                    </div>
                    <div class="card-footer text-muted">
                        Yayınlanma Tarihi: <?php echo date('d M Y', strtotime($post['published_at'])); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Blog yazılarının listesini sayfaya ekler.**
✅ `foreach ($posts as $post)` → **Tüm blog yazılarını döngü ile listeler.**
✅ `card-img-top` → **Her blog yazısı için bir görsel ekler.**
✅ `btn-secondary` → **Kullanıcıyı detay sayfasına yönlendiren buton ekler.**

---

## **4. Belirli Bir Blog Makalesini Görüntüleme (detail.php)**

```html
<div class="container my-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3"><?php echo $post['title']; ?></h1>
        <i class="fas fa-blog fa-2x"></i>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <img src="<?php echo $post['thumbnail_url']; ?>" class="img-fluid mb-4 mx-auto d-block" alt="<?php echo $post['title']; ?>">
            <p class="text-muted text-center">Yayınlanma Tarihi: <?php echo date('d M Y', strtotime($post['published_at'])); ?></p>
            <div class="content bg-light p-4 rounded">
                <?php echo $post['content']; ?>
            </div>
        </div>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Seçilen blog yazısının tüm detaylarını gösterir.**
✅ `img-fluid` → **Duyarlı (responsive) bir blog görseli ekler.**
✅ `bg-light p-4 rounded` → **İçeriği okunaklı hale getiren bir kutu tasarımı ekler.**

---

## 📌 **Tam Kod index.php*

```html
<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Blog Makaleleri</h1>
        <i class="fas fa-blog fa-2x"></i>
    </div>
    <div class="row">
        <?php foreach ($posts as $post): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="<?php echo $post['thumbnail_url']; ?>" class="card-img-tops" alt="<?php echo $post['title']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $post['title']; ?></h5>
                        <p class="card-text"><?php echo substr($post['content'], 0, 100); ?>...</p>
                        <a href="/blog/<?php echo $post['slug']; ?>" class="btn btn-secondary">Devamını Oku</a>
                    </div>
                    <div class="card-footer text-muted">
                        Yayınlanma Tarihi: <?php echo date('d M Y', strtotime($post['published_at'])); ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div> 
```
---
## 📌 **Tam Kod detail.php*

```html
<div class="container my-4">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3"><?php echo $post['title']; ?></h1>
        <i class="fas fa-blog fa-2x"></i>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-10">
            <img src="<?php echo $post['thumbnail_url']; ?>" class="img-fluid mb-4 mx-auto d-block" alt="<?php echo $post['title']; ?>">
            <p class="text-muted text-center">Yayınlanma Tarihi: <?php echo date('d M Y', strtotime($post['published_at'])); ?></p>
            <div class="content bg-light p-4 rounded">
                <?php echo $post['content']; ?>
            </div>
        </div>
    </div>
</div>
```
---

## **Sonuç**

Bu eğitimde, **BlogController’ın nasıl çalıştığını, blog yazılarının nasıl listelendiğini ve detay sayfasının nasıl yönetildiğini** öğrendiniz. **Şimdi, BlogController’ınızı test ederek blog makalelerini kullanıcıya sunabilirsiniz!** 🚀

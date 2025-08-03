# Blog Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Blog Yönetimi** sayfasının işleyişini açıklar. Yönetici, yeni blog yazıları ekleyebilir, düzenleyebilir ve silebilir. Ayrıca mevcut blog yazılarını listeleyebilir.

---

## Kullanılan Teknolojiler
- **PHP** (MVC yapısı ile)
- **MySQL** (Veritabanı işlemleri için)
- **Slug Oluşturma** (SEO dostu URL yapıları için)
- **File Upload** (Görsel yükleme işlemleri için)

---

## Sınıf Yapısı

### **1. Constructor Metodu**

```php
public function __construct()
{
    parent::__construct();
    $this->blogModel = new BlogModel();
}
```

- **Üst sınıfın (`BaseController`) constructor'ı çağrılır.**
- **BlogModel** nesnesi oluşturularak model ile iletişim sağlanır.

---

### **2. Blog Yazılarını Listeleme (`index()`)**

```php
public function index()
{
    $posts = $this->blogModel->getAllPosts();
    $this->renderAdmin('admin/blogs/index', ['posts' => $posts]);
}
```

- **getAllPosts()** metodu ile tüm blog yazıları getirilir.
- **renderAdmin()** ile veriler `admin/blogs/index` görünümüne aktarılır.

---

### **3. Yeni Blog Yazısı Ekleme (`create() & store()`)**

#### **Yeni Blog Formunu Gösterme**
```php
public function create()
{
    $this->renderAdmin('admin/blogs/create');
}
```
- Admin panelinde yeni bir blog yazısı eklemek için form gösterilir.

#### **Blog Yazısını Kaydetme**
```php
public function store()
{
    $data = [
        'title' => $_POST['title'],
        'slug' => $this->generateSlug($_POST['title']),
        'content' => $_POST['content'],
        'thumbnail_url' => $this->uploadImage(),
        'published_at' => $_POST['published_at']
    ];

    if ($this->blogModel->createPost($data)) {
        header('Location: /admin/blogs');
        exit;
    } else {
        $this->renderAdmin('admin/blogs/create', ['error' => 'Blog yazısı oluşturulamadı.']);
    }
}
```
- **POST isteği kontrol edilir.**
- **generateSlug()** ile başlıktan SEO dostu URL üretilir.
- **uploadImage()** ile blog görseli yüklenir.
- **createPost()** metodu ile veritabanına kayıt eklenir.
- **Başarı veya hata mesajı** gösterilir.

---

### **4. Blog Yazısını Güncelleme (`edit() & update()`)**

#### **Mevcut Blog Yazısını Düzenleme Formunu Gösterme**
```php
public function edit($id)
{
    $post = $this->blogModel->getPostById($id);
    $this->renderAdmin('admin/blogs/edit', ['post' => $post]);
}
```
- **Belirtilen `$id`'ye sahip blog yazısı** getirilir.
- **renderAdmin()** ile düzenleme sayfasına yönlendirilir.

#### **Blog Yazısını Güncelleme İşlemi**
```php
public function update($id)
{
    $data = [
        'title' => $_POST['title'],
        'slug' => $this->generateSlug($_POST['title']),
        'content' => $_POST['content'],
        'published_at' => $_POST['published_at']
    ];

    if (!empty($_FILES['thumbnail_url']['name'])) {
        $data['thumbnail_url'] = $this->uploadImage();
    }

    if ($this->blogModel->updatePost($id, $data)) {
        header('Location: /admin/blogs');
        exit;
    } else {
        $this->renderAdmin('admin/blogs/edit', ['error' => 'Blog yazısı güncellenemedi.', 'post' => $data]);
    }
}
```

- **POST isteği ile yeni bilgiler alınır.**
- **Görsel güncelleme kontrol edilir.**
- **updatePost()** ile değişiklikler kaydedilir.
- **Başarı veya hata mesajı gösterilir.**

---

### **5. Blog Yazısını Silme (`delete()`)**

```php
public function delete($id)
{
    $post = $this->blogModel->getPostById($id);
    if ($this->blogModel->deletePost($id)) {
        if ($post['thumbnail_url']) {
            unlink(__DIR__ . '/../../../public/uploads/blogs/' . basename($post['thumbnail_url']));
        }
        header('Location: /admin/blogs');
        exit;
    } else {
        $this->renderAdmin('admin/blogs/index', ['error' => 'Blog yazısı silinemedi.']);
    }
}
```
- **deletePost()** metodu ile blog yazısı silinir.
- **Varsa ilgili görsel de sunucudan kaldırılır.**
- **Başarı durumunda `/admin/blogs` sayfasına yönlendirilir.**

---

### **6. Slug Oluşturma (`generateSlug()`)**

```php
private function generateSlug($title)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
}
```

- **Özel karakterler kaldırılarak SEO dostu bir slug oluşturulur.**

---

### **7. Görsel Yükleme (`uploadImage()`)**

```php
private function uploadImage()
{
    $targetDir = __DIR__ . '/../../../public/uploads/blogs/';
    $fileName = uniqid() . '_' . basename($_FILES['thumbnail_url']['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES['thumbnail_url']['tmp_name'], $targetFilePath)) {
        return '/uploads/blogs/' . $fileName;
    }
    return null;
}
```

- **Görsel yüklenir ve benzersiz isimlendirilir.**
- **Başarılıysa dosya yolu döndürülür.**

---

```php
<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\BlogModel;

class BlogController extends BaseController
{
    private $blogModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->blogModel = new BlogModel();
    }

    public function index()
    {
        $posts = $this->blogModel->getAllPosts();
        $this->renderAdmin('admin/blogs/index', ['posts' => $posts]);
    }

    public function create()
    {
        $this->renderAdmin('admin/blogs/create');
    }

    public function store()
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $this->generateSlug($_POST['title']),
            'content' => $_POST['content'],
            'thumbnail_url' => $this->uploadImage(),
            'published_at' => $_POST['published_at']
        ];

        if ($this->blogModel->createPost($data)) {
            header('Location: /admin/blogs');
            exit;
        } else {
            $this->renderAdmin('admin/blogs/create', ['error' => 'Blog yazısı oluşturulamadı.']);
        }
    }

    public function edit($id)
    {
        $post = $this->blogModel->getPostById($id);
        $this->renderAdmin('admin/blogs/edit', ['post' => $post]);
    }

    public function update($id)
    {
        $data = [
            'title' => $_POST['title'],
            'slug' => $this->generateSlug($_POST['title']),
            'content' => $_POST['content'],
            'published_at' => $_POST['published_at']
        ];

        if (!empty($_FILES['thumbnail_url']['name'])) {
            $data['thumbnail_url'] = $this->uploadImage();
        }

        if ($this->blogModel->updatePost($id, $data)) {
            header('Location: /admin/blogs');
            exit;
        } else {
            $this->renderAdmin('admin/blogs/edit', ['error' => 'Blog yazısı güncellenemedi.', 'post' => $data]);
        }
    }

    public function delete($id)
    {
        $post = $this->blogModel->getPostById($id);
        if ($this->blogModel->deletePost($id)) {
            if ($post['thumbnail_url']) {
                unlink(__DIR__ . '/../../../public/uploads/blogs/' . basename($post['thumbnail_url']));
            }
            header('Location: /admin/blogs');
            exit;
        } else {
            $this->renderAdmin('admin/blogs/index', ['error' => 'Blog yazısı silinemedi.']);
        }
    }

    private function generateSlug($title)
    {
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }

    private function uploadImage()
    {
        $targetDir = __DIR__ . '/../../../public/uploads/blogs/';
        $fileName = uniqid() . '_' . basename($_FILES['thumbnail_url']['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES['thumbnail_url']['tmp_name'], $targetFilePath)) {
            return '/uploads/blogs/' . $fileName;
        }

        return null;
    }
}

```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Blog Yönetimi** sayfasının işleyişini açıklar. Yönetici, blog yazılarını **ekleyebilir, düzenleyebilir ve silebilir.** Ayrıca **slug oluşturma ve görsel yükleme desteği bulunmaktadır.** Geliştirme olarak **önizleme özelliği** veya **çoklu dil desteği** eklenebilir.


# Sayfa Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Sayfa Yönetimi** kontrolcüsünü açıklar. Yönetici, **yeni sayfalar ekleyebilir, güncelleyebilir ve silebilir.**

---

## Kullanılan Teknolojiler
- **PHP** (MVC yapısı ile)
- **MySQL** (Veritabanı işlemleri için)
- **Slug Oluşturma** (SEO dostu URL yapıları için)

---

## Sınıf Yapısı

### **1. Constructor Metodu**

```php
public function __construct()
{
    parent::__construct();
    $this->pageModel = new PageModel();
}
```

- **Üst sınıfın (`BaseController`) constructor'ı çağrılır.**
- **PageModel** nesnesi oluşturularak model ile iletişim sağlanır.

---

### **2. Sayfaları Listeleme (`index()`)**

```php
public function index()
{
    $pages = $this->pageModel->getAllPages();
    $this->renderAdmin('admin/page/index', ['pages' => $pages]);
}
```

- **getAllPages()** metodu ile tüm sayfalar getirilir.
- **renderAdmin()** ile sayfalar **`admin/page/index`** görünümüne aktarılır.

---

### **3. Yeni Sayfa Ekleme (`create() & store()`)**

#### **Yeni Sayfa Ekleme Formunu Gösterme**
```php
public function create()
{
    $this->renderAdmin('admin/page/create');
}
```
- Admin panelinde yeni bir sayfa eklemek için form gösterilir.

#### **Sayfa Kaydetme**
```php
public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $slug = $this->generateSlug($_POST['title']);

        $data = [
            'title' => $_POST['title'],
            'slug' => $slug,
            'content' => $_POST['content'],
            'status' => $_POST['status']
        ];

        $result = $this->pageModel->createPage($data);

        if ($result) {
            $this->renderAdmin('admin/page/create', ['success' => 'Sayfa başarıyla oluşturuldu.']);
        } else {
            $this->renderAdmin('admin/page/create', ['error' => 'Sayfa oluşturulurken bir hata oluştu.']);
        }
    }
}
```

- **POST isteği kontrol edilir.**
- **generateSlug()** ile sayfa başlığı SEO dostu hale getirilir.
- **createPage()** metodu ile veritabanına yeni sayfa eklenir.
- **Başarı veya hata mesajı**, sayfaya yansıtılır.

---

### **4. Sayfa Güncelleme (`edit() & update()`)**

#### **Mevcut Sayfa'yı Düzenleme Formunu Gösterme**
```php
public function edit($id)
{
    $page = $this->pageModel->getPageById($id);
    $this->renderAdmin('admin/page/edit', ['page' => $page]);
}
```
- **Belirtilen `$id`'ye sahip sayfa** çekilir.
- **renderAdmin()** ile düzenleme sayfasına yönlendirilir.

#### **Sayfa Güncelleme İşlemi**
```php
public function update($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $slug = $this->generateSlug($_POST['title']);

        $data = [
            'title' => $_POST['title'],
            'slug' => $slug,
            'content' => $_POST['content'],
            'status' => $_POST['status']
        ];

        $result = $this->pageModel->updatePage($id, $data);

        if ($result) {
            $this->renderAdmin('admin/page/edit', ['page' => $this->pageModel->getPageById($id), 'success' => 'Sayfa başarıyla güncellendi.']);
        } else {
            $this->renderAdmin('admin/page/edit', ['page' => $this->pageModel->getPageById($id), 'error' => 'Sayfa güncellenirken bir hata oluştu.']);
        }
    }
}
```

- **POST isteği ile sayfa bilgileri alınır.**
- **generateSlug()** çağrılarak SEO dostu URL üretilir.
- **updatePage()** metodu ile değişiklikler kaydedilir.

---

### **5. Sayfa Silme (`delete()`)**

```php
public function delete($id)
{
    $this->pageModel->deletePage($id);
    header('Location: /admin/pages');
}
```

- **deletePage()** ile belirtilen `$id`'ye sahip sayfa veritabanından silinir.
- **Yönetici, sayfa listesinin bulunduğu `/admin/pages` sayfasına yönlendirilir.**

---

### **6. Slug Oluşturma (`generateSlug()`)**

```php
private function generateSlug($title)
{
    $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
    $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
    $title = str_replace($turkish, $english, $title);
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
}
```

- **Türkçe karakterler İngilizce karakterlere çevrilir.**
- **Gereksiz karakterler temizlenerek SEO dostu bir slug oluşturulur.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Admin;

use App\Models\PageModel;
use App\Core\BaseController;

class PageController extends BaseController
{
    private $pageModel;

    public function __construct()
    {
        parent::__construct();
        $this->pageModel = new PageModel();
    }

    public function index()
    {
        $pages = $this->pageModel->getAllPages();
        $this->renderAdmin('admin/page/index', ['pages' => $pages]);
    }

    public function create()
    {
        $this->renderAdmin('admin/page/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['title']);

            $data = [
                'title' => $_POST['title'],
                'slug' => $slug,
                'content' => $_POST['content'],
                'status' => $_POST['status']
            ];

            $result = $this->pageModel->createPage($data);

            if ($result) {
                $this->renderAdmin('admin/page/create', ['success' => 'Sayfa başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/page/create', ['error' => 'Sayfa oluşturulurken bir hata oluştu.']);
            }
        }
    }

    public function edit($id)
    {
        $page = $this->pageModel->getPageById($id);
        $this->renderAdmin('admin/page/edit', ['page' => $page]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['title']);

            $data = [
                'title' => $_POST['title'],
                'slug' => $slug,
                'content' => $_POST['content'],
                'status' => $_POST['status']
            ];

            $result = $this->pageModel->updatePage($id, $data);

            if ($result) {
                $this->renderAdmin('admin/page/edit', ['page' => $this->pageModel->getPageById($id), 'success' => 'Sayfa başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/page/edit', ['page' => $this->pageModel->getPageById($id), 'error' => 'Sayfa güncellenirken bir hata oluştu.']);
            }
        }
    }

    public function delete($id)
    {
        $this->pageModel->deletePage($id);
        header('Location: /admin/pages');
    }

    private function generateSlug($title)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $title = str_replace($turkish, $english, $title);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $title)));
    }
}

```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Sayfa Yönetimi** kontrolcüsünün işleyişini açıklar. Yönetici, sayfaları **oluşturabilir, düzenleyebilir ve silebilir.** Slug oluşturma sayesinde **SEO uyumlu URL'ler** kullanılmaktadır. Ek geliştirmeler için **çoklu dil desteği** veya **önizleme özelliği** eklenebilir.
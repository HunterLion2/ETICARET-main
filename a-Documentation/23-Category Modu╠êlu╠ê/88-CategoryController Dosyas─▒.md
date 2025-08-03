# Kategori Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Kategori Yönetimi** sayfasının işleyişini açıklar. Yönetici, kategori ekleyebilir, düzenleyebilir ve silebilir.

---

## Kullanılan Teknolojiler
- **PHP** (Sunucu tarafı iş mantığı için)
- **HTML5 & CSS3** (Form elemanları ve listeleme için)
- **Bootstrap 5** (Responsive tasarım için)

---

## **Kategori Yönetimi Kontrolcüsü (CategoryController.php)**

Kategori yönetimi işlemlerini gerçekleştiren ana kontrolcü dosyası.

### **1. Controller Sınıfı ve Model Entegrasyonu**
```php
namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->categoryModel = new CategoryModel();
    }
```
- **BaseController** sınıfından türetilmiştir.
- **CategoryModel** sınıfı üzerinden kategori işlemleri yönetilir.

---

### **2. Kategori Listesi (index metodu)**
```php
public function index()
{
    $categories = $this->categoryModel->getAllCategories();
    $this->renderAdmin('admin/categories/index', ['categories' => $categories]);
}
```
- **getAllCategories()** fonksiyonu ile tüm kategorileri veritabanından çeker.
- **renderAdmin()** ile admin paneline kategori listesi gönderilir.

---

### **3. Yeni Kategori Ekleme (create ve store metodları)**
```php
public function create()
{
    $this->renderAdmin('admin/categories/create');
}
```
- **create()** metodu, kategori ekleme formunu render eder.

```php
public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'],
            'icon' => $_POST['icon'],
            'description' => $_POST['description'],
            'status' => $_POST['status']
        ];

        $result = $this->categoryModel->createCategory($data);

        if ($result) {
            $this->renderAdmin('admin/categories/create', ['success' => 'Kategori başarıyla oluşturuldu.']);
        } else {
            $this->renderAdmin('admin/categories/create', ['error' => 'Kategori oluşturulamadı.']);
        }
    }
}
```
- **POST isteği ile kategori eklenir.**
- **Başarı mesajı veya hata mesajı görüntülenir.**

---

### **4. Kategori Düzenleme (edit ve update metodları)**
```php
public function edit($id)
{
    $category = $this->categoryModel->getCategoryById($id);
    $this->renderAdmin('admin/categories/edit', ['category' => $category]);
}
```
- **Belirtilen ID'ye sahip kategoriyi getirir.**

```php
public function update($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'name' => $_POST['name'],
            'icon' => $_POST['icon'],
            'description' => $_POST['description'],
            'status' => $_POST['status']
        ];

        $result = $this->categoryModel->updateCategory($id, $data);

        $category = $this->categoryModel->getCategoryById($id);

        if ($result) {
            $this->renderAdmin('admin/categories/edit', ['category' => $category, 'success' => 'Kategori başarıyla güncellendi.']);
        } else {
            $this->renderAdmin('admin/categories/edit', ['category' => $category, 'error' => 'Kategori güncellenemedi.']);
        }
    }
}
```
- **Kategori güncelleme işlemi yapılır.**
- **Başarı veya hata mesajı döndürülür.**

---

### **5. Kategori Silme (delete metodu)**
```php
public function delete($id)
{
    $result = $this->categoryModel->deleteCategory($id);

    if ($result) {
        header('Location: /admin/categories');
    } else {
        $categories = $this->categoryModel->getAllCategories();
        $this->renderAdmin('admin/categories/index', ['categories' => $categories, 'error' => 'Kategori silinemedi.']);
    }
}
```
- **Kategori ID'ye göre silinir.**
- **Başarı veya hata mesajı döndürülür.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    private $categoryModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->categoryModel = new CategoryModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->getAllCategories();
        $this->renderAdmin('admin/categories/index', ['categories' => $categories]);
    }

    public function create()
    {
        $this->renderAdmin('admin/categories/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'status' => $_POST['status']
            ];

            $result = $this->categoryModel->createCategory($data);

            if ($result) {
                $this->renderAdmin('admin/categories/create', ['success' => 'Kategori başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/categories/create', ['error' => 'Kategori oluşturulamadı.']);
            }
        }
    }

    public function edit($id)
    {
        $category = $this->categoryModel->getCategoryById($id);
        $this->renderAdmin('admin/categories/edit', ['category' => $category]);
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'icon' => $_POST['icon'],
                'description' => $_POST['description'],
                'status' => $_POST['status']
            ];

            $result = $this->categoryModel->updateCategory($id, $data);

            $category = $this->categoryModel->getCategoryById($id);

            if ($result) {
                $this->renderAdmin('admin/categories/edit', ['category' => $category, 'success' => 'Kategori başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/categories/edit', ['category' => $category, 'error' => 'Kategori güncellenemedi.']);
            }
        }
    }

    public function delete($id)
    {
        $result = $this->categoryModel->deleteCategory($id);

        if ($result) {
            header('Location: /admin/categories');
        } else {
            $categories = $this->categoryModel->getAllCategories();
            $this->renderAdmin('admin/categories/index', ['categories' => $categories, 'error' => 'Kategori silinemedi.']);
        }
    }
}

```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Kategori Yönetimi** sayfasının işleyişini açıklar. Yönetici, kategorileri **listeleyebilir, ekleyebilir, düzenleyebilir ve silebilir.**

Geliştirme olarak:
- **Kategoriye görsel ekleme desteği getirilebilir.**
- **Alt kategori sistemi eklenerek kategori hiyerarşisi oluşturulabilir.**


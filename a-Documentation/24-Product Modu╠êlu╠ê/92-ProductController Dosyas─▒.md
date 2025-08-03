# Ürün Yönetimi Dokümantasyonu

Bu doküman, **ProductController** sınıfının işleyişini detaylı olarak açıklamak ve ürün yönetimi sürecinde kullanılan fonksiyonları anlatmak amacıyla hazırlanmıştır.

---

## 1. **ProductController Nedir?**

Bu kontrolcü, admin paneli üzerinden ürünlerin yönetimini sağlamak için kullanılır. Ürün ekleme, düzenleme, silme ve galeri işlemleri gibi fonksiyonları içermektedir.

---

## 2. **Fonksiyonlar ve Açıklamaları**

### 2.1 **index()** - Ürünleri Listeleme

Bu fonksiyon, mevcut tüm ürünleri getirir ve admin panelinde liste görünümüne gönderir.

```php
public function index()
{
    $products = $this->productModel->getAllProducts();
    $products = empty($products) ? [] : $products;
    $this->renderAdmin('admin/product/index', ['products' => $products]);
}
```

---

### 2.2 **create()** - Ürün Ekleme Formu

Admin panelinde yeni bir ürün eklemek için form ekranını oluşturur.

```php
public function create()
{
    $categories = $this->productModel->getAllCategories();
    $this->renderAdmin('admin/product/create', ['categories' => $categories]);
}
```

---

### 2.3 **store()** - Yeni Ürün Kaydetme

Formdan gelen verileri alarak yeni bir ürün oluşturur ve veritabanına kaydeder.

```php
public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $slug = $this->generateSlug($_POST['name']);

        $data = [
            'name' => $_POST['name'],
            'slug' => $slug,
            'short_description' => $_POST['short_description'],
            'featured' => $_POST['featured'],
            'tag' => $_POST['tag'],
            'standard_image' => $this->uploadImage('standard_image'),
            'hover_image' => $this->uploadImage('hover_image'),
            'stock_quantity' => $_POST['stock_quantity'],
            'delivery_date' => $_POST['delivery_date'],
            'long_description' => $_POST['long_description'],
            'category_id' => $_POST['category_id']
        ];

        $result = $this->productModel->createProduct($data);

        if ($result) {
            $this->renderAdmin('admin/product/create', ['success' => 'Ürün başarıyla oluşturuldu.']);
        } else {
            $this->renderAdmin('admin/product/create', ['error' => 'Ürün oluşturulurken bir hata oluştu.']);
        }
    }
}
```

---

### 2.4 **edit($id)** - Ürün Düzenleme

Mevcut bir ürünü düzenlemek için bilgileri getirir ve düzenleme formuna aktarır.

```php
public function edit($id)
{
    $product = $this->productModel->getProductById($id);
    $categories = $this->productModel->getAllCategories();

    $this->renderAdmin(
        'admin/product/edit',
        ['product' => $product, 'categories' => $categories]
    );
}
```

---

### 2.5 **update($id)** - Ürün Güncelleme

Mevcut bir ürünün bilgilerini günceller.

```php
public function update($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $slug = $this->generateSlug($_POST['name']);

        $data = [
            'name' => $_POST['name'],
            'slug' => $slug,
            'short_description' => $_POST['short_description'],
            'featured' => $_POST['featured'],
            'tag' => $_POST['tag'],
            'standard_image' => $this->uploadImage('standard_image') ?: $_POST['current_standard_image'],
            'hover_image' => $this->uploadImage('hover_image') ?: $_POST['current_hover_image'],
            'stock_quantity' => $_POST['stock_quantity'],
            'delivery_date' => $_POST['delivery_date'],
            'long_description' => $_POST['long_description'],
            'category_id' => $_POST['category_id']
        ];

        $result = $this->productModel->updateProduct($id, $data);

        if ($result) {
            $this->renderAdmin('admin/product/edit', ['product' => $this->productModel->getProductById($id), 'success' => 'Ürün başarıyla güncellendi.']);
        } else {
            $this->renderAdmin('admin/product/edit', ['product' => $this->productModel->getProductById($id), 'error' => 'Ürün güncellenirken bir hata oluştu.']);
        }
    }
}
```

---

### 2.6 **delete($id)** - Ürün Silme

Verilen ID’ye sahip ürünü veritabanından siler ve ilgili resimleri de kaldırır.

```php
public function delete($id)
{
    $product = $this->productModel->getProductById($id);
    
    if ($product) {
        if ($product['standard_image']) {
            unlink(__DIR__ . '/../../../public' . $product['standard_image']);
        }
        if ($product['hover_image']) {
            unlink(__DIR__ . '/../../../public' . $product['hover_image']);
        }
    }
    
    $this->productModel->deleteProduct($id);
    header('Location: /admin/products');
}
```

---

## 3. **Yardımcı Fonksiyonlar**

### 3.1 **uploadImage($inputName)** - Görsel Yükleme

```php
private function uploadImage($inputName)
{
    if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../../public/uploads/products/';
        $fileExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
        $randomFileName = uniqid() . '.' . $fileExtension;
        move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadDir . $randomFileName);
        return '/uploads/products/' . $randomFileName;
    }
    return null;
}
```

### 3.2 **generateSlug($name)** - URL Dostu Slug Oluşturma

```php
private function generateSlug($name)
{
    return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', str_replace(['ı', 'ğ', 'ü', 'ş', 'ö', 'ç'], ['i', 'g', 'u', 's', 'o', 'c'], $name))));
}
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Admin;

use App\Models\ProductModel;
use App\Core\BaseController;

class ProductController extends BaseController
{
    private $productModel;

    public function __construct()
    {
        parent::__construct();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $products = $this->productModel->getAllProducts();

        if (empty($products)) {
            $products = [];
        }

        $this->renderAdmin(
            'admin/product/index',
            ['products' => $products]
        );
    }

    public function create()
    {
        $categories = $this->productModel->getAllCategories();
        $this->renderAdmin('admin/product/create', ['categories' => $categories]);
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['name']);

            $data = [
                'name' => $_POST['name'],
                'slug' => $slug,
                'short_description' => $_POST['short_description'],
                'featured' => $_POST['featured'], // Enum değerine göre al
                'tag' => $_POST['tag'],
                'standard_image' => $this->uploadImage('standard_image'),
                'hover_image' => $this->uploadImage('hover_image'),
                'stock_quantity' => $_POST['stock_quantity'],
                'delivery_date' => $_POST['delivery_date'], // Gün olarak al
                'long_description' => $_POST['long_description'],
                'category_id' => $_POST['category_id']
            ];

            $result = $this->productModel->createProduct($data);

            if ($result) {
                $this->renderAdmin('admin/product/create', ['success' => 'Ürün başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/product/create', ['error' => 'Ürün oluşturulurken bir hata oluştu.']);
            }
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->getProductById($id);
        $categories = $this->productModel->getAllCategories();

        $this->renderAdmin(
            'admin/product/edit',
            ['product' => $product, 'categories' => $categories]
        );
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $slug = $this->generateSlug($_POST['name']);

            $data = [
                'name' => $_POST['name'],
                'slug' => $slug,
                'short_description' => $_POST['short_description'],
                'featured' => $_POST['featured'], // Enum değerine göre al
                'tag' => $_POST['tag'],
                'standard_image' => $this->uploadImage('standard_image') ?: $_POST['current_standard_image'],
                'hover_image' => $this->uploadImage('hover_image') ?: $_POST['current_hover_image'],
                'stock_quantity' => $_POST['stock_quantity'],
                'delivery_date' => $_POST['delivery_date'], // Gün olarak al
                'long_description' => $_POST['long_description'],
                'category_id' => $_POST['category_id']
            ];

            $result = $this->productModel->updateProduct($id, $data);

            if ($result) {
                $this->renderAdmin('admin/product/edit', ['product' => $this->productModel->getProductById($id), 'success' => 'Ürün başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/product/edit', ['product' => $this->productModel->getProductById($id), 'error' => 'Ürün güncellenirken bir hata oluştu.']);
            }
        }
    }

    public function delete($id)
    {
        $product = $this->productModel->getProductById($id);

        if ($product) {
            if ($product['standard_image']) {
                $standardImagePath = __DIR__ . '/../../../public' . $product['standard_image'];
                if (file_exists($standardImagePath)) {
                    unlink($standardImagePath);
                }
            }

            if ($product['hover_image']) {
                $hoverImagePath = __DIR__ . '/../../../public' . $product['hover_image'];
                if (file_exists($hoverImagePath)) {
                    unlink($hoverImagePath);
                }
            }
        }

        $this->productModel->deleteProduct($id);

        header('Location: /admin/products');
    }

    private function uploadImage($inputName)
    {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/products/';
            $fileExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
            $randomFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $randomFileName;
            move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadFile);
            return '/uploads/products/' . $randomFileName;
        }
        return null;
    }

    private function generateSlug($name)
    {
        $turkish = ['ı', 'ğ', 'ü', 'ş', 'ö', 'ç', 'İ', 'Ğ', 'Ü', 'Ş', 'Ö', 'Ç'];
        $english = ['i', 'g', 'u', 's', 'o', 'c', 'I', 'G', 'U', 'S', 'O', 'C'];
        $name = str_replace($turkish, $english, $name);
        return strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    }

    public function gallery($productId)
    {
        $product = $this->productModel->getProductById($productId);
        $galleryImages = $this->productModel->getProductGalleryImages($productId);
        $this->renderAdmin('admin/product/gallery', [
            'product_id' => $productId,
            'product_name' => $product['name'],
            'gallery_images' => array_slice($galleryImages, 0, 5) // Maksimum 5 görsel
        ]);
    }

    public function addGalleryImage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $imagePath = $this->uploadGalleryImage('gallery_image', $productId);

            if ($imagePath) {
                $this->productModel->addGalleryImage($productId, $imagePath);
            }

            header("Location: /admin/products/gallery/$productId");
        }
    }

    public function deleteGalleryImage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'];
            $imagePath = $_POST['image_path'];

            if ($this->productModel->deleteGalleryImage($productId, $imagePath)) {
                $fullImagePath = __DIR__ . '/../../../public' . $imagePath;
                if (file_exists($fullImagePath)) {
                    unlink($fullImagePath);
                }
            }

            header("Location: /admin/products/gallery/$productId");
        }
    }

    private function uploadGalleryImage($inputName, $productId)
    {
        if (isset($_FILES[$inputName]) && $_FILES[$inputName]['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/products/' . $productId . '/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $fileExtension = pathinfo($_FILES[$inputName]['name'], PATHINFO_EXTENSION);
            $randomFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $randomFileName;
            move_uploaded_file($_FILES[$inputName]['tmp_name'], $uploadFile);
            return '/uploads/products/' . $productId . '/' . $randomFileName;
        }
        return null;
    }
}


```
---

Bu dokümantasyon **ProductController**’ın temel işleyişini kapsamaktadır. Daha fazla detay için kodu inceleyebilir veya genişletme yapabilirsiniz. 🚀


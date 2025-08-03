# Admin Slider Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Slider Yönetimi** kontrolcüsünü açıklar. Yönetici, sliderları (banner görsellerini) ekleyebilir, düzenleyebilir ve silebilir.

---

## Kullanılan Teknolojiler
- **PHP** (Nesne Yönelimli Programlama - OOP)
- **MVC Yapısı** (Model-View-Controller)
- **File Upload** (Görsel yükleme işlemleri için)

---

## Sınıf Yapısı

### **1. Constructor Metodu**

```php
public function __construct()
{
    parent::__construct();
    $this->sliderModel = new SliderModel();
}
```

- **`parent::__construct()`** ile üst sınıfın yapıcı metodu çağrılır.
- **SliderModel** nesnesi oluşturularak model ile iletişim sağlanır.

---

### **2. Sliderları Listeleme (`index()`)**

```php
public function index()
{
    $sliders = $this->sliderModel->getAllSliders();

    $this->renderAdmin(
        'admin/slider/index',
        ['sliders' => $sliders]
    );
}
```

- **getAllSliders()** metodu ile slider kayıtları çekilir.
- **renderAdmin()** fonksiyonu ile veriler admin sayfasına aktarılır.

---

### **3. Yeni Slider Ekleme (`create() & store()`)**

#### **Yeni Slider Ekleme Formunu Gösterme**
```php
public function create()
{
    $this->renderAdmin('admin/slider/create');
}
```
- Admin panelinde yeni bir slider eklemek için form gösterilir.

#### **Slider Kaydetme**
```php
public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'image_url' => $this->uploadImage(),
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'link_url' => $_POST['link_url'],
            'status' => $_POST['status'],
            'sort_order' => $_POST['sort_order']
        ];

        $result = $this->sliderModel->createSlider($data);

        if ($result) {
            $this->renderAdmin('admin/slider/create', ['success' => 'Slider başarıyla oluşturuldu.']);
        } else {
            $this->renderAdmin('admin/slider/create', ['error' => 'Slider oluşturulurken bir hata oluştu.']);
        }
    }
}
```

- **POST isteği kontrol edilir.**
- **uploadImage()** metodu çağrılarak görsel yüklenir.
- **createSlider()** metodu ile veritabanına yeni slider eklenir.
- **Başarı veya hata mesajı**, sayfaya yansıtılır.

---

### **4. Slider Güncelleme (`edit() & update()`)**

#### **Mevcut Slider'ı Düzenleme Formunu Gösterme**
```php
public function edit($id)
{
    $slider = $this->sliderModel->getSliderById($id);
    
    $this->renderAdmin(
        'admin/slider/edit',
        ['slider' => $slider]
    );
}
```
- **Belirtilen `$id`'ye sahip slider** çekilir.
- **renderAdmin()** ile düzenleme sayfasına yönlendirilir.

#### **Slider Güncelleme İşlemi**
```php
public function update($id)
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = [
            'title' => $_POST['title'],
            'description' => $_POST['description'],
            'link_url' => $_POST['link_url'],
            'status' => $_POST['status'],
            'sort_order' => $_POST['sort_order']
        ];

        $imageUrl = $this->uploadImage();
        if ($imageUrl) {
            $data['image_url'] = $imageUrl;
        }

        $result = $this->sliderModel->updateSlider($id, $data);

        $slider = $this->sliderModel->getSliderById($id);

        if ($result) {
            $this->renderAdmin('admin/slider/edit', ['slider' => $slider, 'success' => 'Slider başarıyla güncellendi.']);
        } else {
            $this->renderAdmin('admin/slider/edit', ['slider' => $slider, 'error' => 'Slider güncellenirken bir hata oluştu.']);
        }
    }
}
```

- **POST isteği ile slider bilgileri alınır.**
- **uploadImage()** çağrılarak yeni bir görsel eklenirse güncellenir.
- **updateSlider()** metodu ile değişiklikler kaydedilir.

---

### **5. Slider Silme (`delete()`)**

```php
public function delete($id)
{
    $slider = $this->sliderModel->getSliderById($id);
    
    if ($slider && $slider['image_url']) {
        $imagePath = __DIR__ . '/../../../public' . $slider['image_url'];
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    $this->sliderModel->deleteSlider($id);

    header('Location: /admin/slider');
}
```

- **Slider görseli sunucudan silinir.**
- **deleteSlider()** ile veritabanından ilgili slider kaldırılır.
- **Yönetici, slider listesinin bulunduğu sayfaya yönlendirilir.**

---

### **6. Görsel Yükleme (`uploadImage()`)**

```php
private function uploadImage()
{
    if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../../public/uploads/sliders/';
        $fileExtension = pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION);
        $randomFileName = uniqid() . '.' . $fileExtension;
        $uploadFile = $uploadDir . $randomFileName;
        move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile);
        return '/uploads/sliders/' . $randomFileName;
    }
    return null;
}
```

- **Görsel yükleme işlemi gerçekleştirilir.**
- **Yükleme işlemi başarılı olursa dosya yolu döndürülür.**
- **Başarısız olursa `null` döndürülerek işlem iptal edilir.**

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Admin;

use App\Models\SliderModel;
use App\Core\BaseController;

class SliderController extends BaseController
{
    private $sliderModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        $sliders = $this->sliderModel->getAllSliders();

        $this->renderAdmin(
            'admin/slider/index',
            ['sliders' => $sliders]
        );
    }

    public function create()
    {
        $this->renderAdmin('admin/slider/create');
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'image_url' => $this->uploadImage(),
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'link_url' => $_POST['link_url'],
                'status' => $_POST['status'],
                'sort_order' => $_POST['sort_order']
            ];

            $result = $this->sliderModel->createSlider($data);

            if ($result) {
                $this->renderAdmin('admin/slider/create', ['success' => 'Slider başarıyla oluşturuldu.']);
            } else {
                $this->renderAdmin('admin/slider/create', ['error' => 'Slider oluşturulurken bir hata oluştu.']);
            }
        }
    }

    public function edit($id)
    {
        $slider = $this->sliderModel->getSliderById($id);

        $this->renderAdmin(
            'admin/slider/edit',
            ['slider' => $slider]
        );
    }

    public function update($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'link_url' => $_POST['link_url'],
                'status' => $_POST['status'],
                'sort_order' => $_POST['sort_order']
            ];

            $imageUrl = $this->uploadImage();
            if ($imageUrl) {
                $data['image_url'] = $imageUrl;
            }

            $result = $this->sliderModel->updateSlider($id, $data);

            $slider = $this->sliderModel->getSliderById($id);

            if ($result) {
                $this->renderAdmin('admin/slider/edit', ['slider' => $slider, 'success' => 'Slider başarıyla güncellendi.']);
            } else {
                $this->renderAdmin('admin/slider/edit', ['slider' => $slider, 'error' => 'Slider güncellenirken bir hata oluştu.']);
            }
        }
    }

    public function delete($id)
    {
        $slider = $this->sliderModel->getSliderById($id);

        if ($slider && $slider['image_url']) {
            $imagePath = __DIR__ . '/../../../public' . $slider['image_url'];
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        $this->sliderModel->deleteSlider($id);

        header('Location: /admin/slider');
    }

    private function uploadImage()
    {
        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../../public/uploads/sliders/';
            $fileExtension = pathinfo($_FILES['image_url']['name'], PATHINFO_EXTENSION);
            $randomFileName = uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $randomFileName;
            move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile);
            return '/uploads/sliders/' . $randomFileName;
        }
        return null;
    }
}

```
---
## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Slider Yönetimi** sayfasının işleyişini açıklar. Yönetici, sliderları **oluşturabilir, düzenleyebilir ve silebilir.** Görsel yükleme işlemi entegre edilmiştir. Ek güvenlik önlemleri için dosya türü doğrulama ve boyut sınırlaması eklenebilir.


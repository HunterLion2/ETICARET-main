# Admin Paneli - Hakkımızda Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Hakkımızda (About) Yönetimi** kontrolcüsünü açıklar. Yönetici, **vizyon, misyon, biyografi bilgileri ve görselleri** güncelleyebilir.

---

## Kullanılan Teknolojiler
- **PHP** (MVC yapısı ile)
- **File Upload** (Görsel yükleme işlemleri için)

---

## Sınıf Yapısı

### **1. Constructor Metodu**

```php
public function __construct()
{
    parent::__construct();
    $this->aboutModel = new AboutModel();
}
```

- **Üst sınıfın (`BaseController`) constructor'ı çağrılır.**
- **AboutModel** nesnesi oluşturularak model ile iletişim sağlanır.

---

### **2. Hakkımızda İçeriğini Getirme (`edit()`)**

```php
public function edit()
{
    $about = $this->aboutModel->getAbout();
    $this->renderAdmin('admin/about/edit', ['about' => $about]);
}
```

- **getAbout()** metodu kullanılarak mevcut **Hakkımızda bilgileri** veritabanından çekilir.
- **renderAdmin()** ile bilgiler **`admin/about/edit`** sayfasına aktarılır.

---

### **3. Hakkımızda Bilgilerini Güncelleme (`update()`)**

```php
public function update()
{
    $data = [
        'vision' => $_POST['vision'],
        'mission' => $_POST['mission'],
        'biography' => $_POST['biography']
    ];
```
- **POST isteği ile gelen yeni vizyon, misyon ve biyografi bilgileri alınır.**

#### **Görsel Güncelleme İşlemi**
```php
    if (!empty($_FILES['image1']['name'])) {
        $data['image1'] = $this->uploadImage('image1');
        $this->deleteOldImage('image1');
    } else {
        $data['image1'] = $_POST['current_image1'];
    }
```
- **Yeni bir görsel seçilmişse**, `uploadImage()` fonksiyonu çağrılarak yeni görsel yüklenir.
- **Mevcut bir görsel varsa**, eski görsel `deleteOldImage()` ile silinir.
- **Görsel güncellenmemişse, eski görsel korunur.**

#### **Verilerin Güncellenmesi**
```php
    if ($this->aboutModel->updateAbout($data)) {
        header('Location: /admin/about');
        exit;
    } else {
        $this->renderAdmin('admin/about/edit', ['error' => 'Hakkımızda bilgileri güncellenemedi.', 'about' => $data]);
    }
}
```
- **updateAbout()** metodu ile veriler veritabanına kaydedilir.
- **İşlem başarılıysa**, yönetici **/admin/about** sayfasına yönlendirilir.
- **Hata oluşursa, mevcut bilgilerle hata mesajı gösterilir.**

---

### **4. Görsel Yükleme (`uploadImage()`)**

```php
private function uploadImage($imageField)
{
    $targetDir = __DIR__ . '/../../../public/uploads/about/';
    $fileName = uniqid() . '_' . basename($_FILES[$imageField]['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($_FILES[$imageField]['tmp_name'], $targetFilePath)) {
        return '/uploads/about/' . $fileName;
    }
    return null;
}
```
- **Dosyanın benzersiz isimle kaydedilmesini sağlar.**
- **Görsel yükleme başarılı olursa, dosya yolu döndürülür.**
- **Başarısız olursa `null` döndürülerek işlem iptal edilir.**

---

### **5. Eski Görseli Silme (`deleteOldImage()`)**

```php
private function deleteOldImage($imageField)
{
    $oldImage = $_POST['current_' . $imageField];
    if ($oldImage && file_exists(__DIR__ . '/../../../public' . $oldImage)) {
        unlink(__DIR__ . '/../../../public' . $oldImage);
    }
}
```
- **Eğer eski bir görsel varsa**, `unlink()` fonksiyonu ile sunucudan silinir.
- **Silme işlemi, yalnızca yeni bir görsel yüklendiğinde gerçekleşir.**

---

```php
<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\AboutModel;

class AboutController extends BaseController
{
    private $aboutModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->aboutModel = new AboutModel();
    }

    public function edit()
    {
        $about = $this->aboutModel->getAbout();
        $this->renderAdmin('admin/about/edit', ['about' => $about]);
    }

    public function update()
    {
        $data = [
            'vision' => $_POST['vision'],
            'mission' => $_POST['mission'],
            'biography' => $_POST['biography']
        ];

        if (!empty($_FILES['image1']['name'])) {
            $data['image1'] = $this->uploadImage('image1');
            $this->deleteOldImage('image1');
        } else {
            $data['image1'] = $_POST['current_image1'];
        }

        if (!empty($_FILES['image2']['name'])) {
            $data['image2'] = $this->uploadImage('image2');
            $this->deleteOldImage('image2');
        } else {
            $data['image2'] = $_POST['current_image2'];
        }

        if ($this->aboutModel->updateAbout($data)) {
            header('Location: /admin/about');
            exit;
        } else {
            $this->renderAdmin('admin/about/edit', ['error' => 'Hakkımızda bilgileri güncellenemedi.', 'about' => $data]);
        }
    }

    private function uploadImage($imageField)
    {
        $targetDir = __DIR__ . '/../../../public/uploads/about/';
        $fileName = uniqid() . '_' . basename($_FILES[$imageField]['name']);
        $targetFilePath = $targetDir . $fileName;

        if (move_uploaded_file($_FILES[$imageField]['tmp_name'], $targetFilePath)) {
            return '/uploads/about/' . $fileName;
        }

        return null;
    }

    private function deleteOldImage($imageField)
    {
        $oldImage = $_POST['current_' . $imageField];
        if ($oldImage && file_exists(__DIR__ . '/../../../public' . $oldImage)) {
            unlink(__DIR__ . '/../../../public' . $oldImage);
        }
    }
}

```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Hakkımızda Yönetimi** sayfasının işleyişini açıklar. Yönetici, **vizyon, misyon, biyografi** ve **görselleri** güncelleyebilir. Ek geliştirmeler için **çoklu dil desteği** veya **görsel önizleme** gibi özellikler eklenebilir.
# Admin Ayarları Kontrolcüsü (SettingsController) Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **SettingsController** sınıfının işlevlerini ve kullanımını açıklar.
Bu kontrolcü, yönetici panelinde ayarları görüntüleme ve güncelleme işlevlerini yürütür.

---

## Kullanılan Teknolojiler
- **PHP** (Nesne Yönelimli Programlama - OOP)
- **MVC Yapısı** (Model-View-Controller)
- **JSON** (AJAX işlemleri için veri formatı)

---

## Sınıf Yapısı

### **1. `index()` Metodu**

```php
public function index()
{
    $settingsModel = new SettingsModel();
    $this->settings = $settingsModel->getAllSettings();

    // Verileri view'a gönder
    $this->renderAdmin(
        'admin/settings/index',
        ['settings' => $this->settings]
    );
}
```

#### **Açıklama:**
- **SettingsModel** kullanılarak tüm ayarlar veritabanından çekilir.
- **`getAllSettings()`** metoduyla ayarlar alınır.
- **`renderAdmin()`** fonksiyonu ile `'admin/settings/index'` görünümüne veri aktarılır.

---

### **2. `updateSetting()` Metodu**

```php
public function updateSetting()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $key = $_POST['key'];
        $value = $_POST['value'];

        $settingsModel = new SettingsModel();
        $result = $settingsModel->updateSetting($key, $value);

        if ($result) {
            echo json_encode(['status' => 'success', 'message' => 'Ayar başarıyla güncellendi.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ayar güncellenirken bir hata oluştu.']);
        }
    }
}
```

#### **Açıklama:**
- **POST isteği** ile ayar güncelleme işlemi gerçekleştirilir.
- **`$_POST['key']` ve `$_POST['value']`**, formdan gelen verileri alır.
- **SettingsModel** kullanılarak **`updateSetting($key, $value)`** metoduyla ayar güncellenir.
- İşlem başarılı olursa **JSON formatında başarı mesajı**, başarısız olursa hata mesajı döndürülür.

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Admin;

use App\Models\SettingsModel;
use App\Core\BaseController;


class SettingsController extends BaseController
{
    public function index()
    {

        $settingsModel = new SettingsModel();
        $this->settings = $settingsModel->getAllSettings();

        // Verileri view'a gönder
        $this->renderAdmin(
            'admin/settings/index',
            ['settings' => $this->settings]
        );
    }

    public function updateSetting()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $key = $_POST['key'];
            $value = $_POST['value'];

            $settingsModel = new SettingsModel();
            $result = $settingsModel->updateSetting($key, $value);

            if ($result) {
                echo json_encode(['status' => 'success', 'message' => 'Ayar başarıyla güncellendi.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Ayar güncellenirken bir hata oluştu.']);
            }
        }
    }
}

```
---

## **Sonuç**

Bu dokümantasyon, **SettingsController** sınıfının yönetim panelinde ayarları listeleme ve güncelleme süreçlerini açıklamaktadır.
Sistem yöneticileri, bu kontrolcü üzerinden ayarları değiştirebilir ve güncelleyebilir. API entegrasyonu için JSON formatı kullanılmıştır.
Gelecekte eklenmesi planlanan özellikler için `deleteSetting()` gibi yeni metotlar eklenebilir.


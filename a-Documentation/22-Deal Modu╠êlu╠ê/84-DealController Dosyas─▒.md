# Kampanya Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Kampanya Yönetimi** sayfasının işleyişini açıklar. Yönetici, kampanyaları listeleyebilir, yeni kampanya oluşturabilir, düzenleyebilir ve silebilir.

---

## Kullanılan Teknolojiler
- **PHP** (Sunucu tarafı iş mantığı için)
- **MVC Yapısı** (Model-View-Controller tasarım deseni kullanılmıştır)

---

## Kontrolcü (Controller) İşlevleri

### **1. Kampanya Listesi (`index()`)**
```php
public function index()
{
    $deals = $this->dealModel->getAllDeals();
    $this->renderAdmin('admin/deal/index', ['deals' => $deals]);
}
```
- **Kampanya verileri** `$this->dealModel->getAllDeals()` fonksiyonu ile veritabanından çekilir.
- **`renderAdmin()` fonksiyonu** kullanılarak **`admin/deal/index`** görünümüne yönlendirilir.

---

### **2. Yeni Kampanya Sayfası (`create()`)**
```php
public function create()
{
    $this->renderAdmin('admin/deal/create');
}
```
- **Yeni kampanya eklemek için form içeren sayfaya yönlendirme yapılır.**

---

### **3. Kampanya Kaydetme (`store()`)**
```php
public function store()
{
    $data = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status']
    ];

    if ($this->dealModel->createDeal($data)) {
        header('Location: /admin/deal');
        exit;
    } else {
        $this->renderAdmin('admin/deal/create', ['error' => 'Kampanya oluşturulamadı.']);
    }
}
```
- **Formdan gelen POST verileri alınır ve `$data` dizisine aktarılır.**
- **Kampanya başarıyla oluşturulursa `/admin/deal` sayfasına yönlendirilir.**
- **Bir hata oluşursa hata mesajı ile `admin/deal/create` sayfası tekrar yüklenir.**

---

### **4. Kampanya Düzenleme (`edit($id)`)**
```php
public function edit($id)
{
    $deal = $this->dealModel->getDealById($id);
    $this->renderAdmin('admin/deal/edit', ['deal' => $deal]);
}
```
- **Seçilen kampanyanın verisi ID’ye göre alınır.**
- **Düzenleme formunun olduğu `admin/deal/edit` sayfasına yönlendirilir.**

---

### **5. Kampanya Güncelleme (`update($id)`)**
```php
public function update($id)
{
    $data = [
        'title' => $_POST['title'],
        'content' => $_POST['content'],
        'start_date' => $_POST['start_date'],
        'end_date' => $_POST['end_date'],
        'status' => $_POST['status']
    ];

    if ($this->dealModel->updateDeal($id, $data)) {
        header('Location: /admin/deal');
        exit;
    } else {
        $this->renderAdmin('admin/deal/edit', ['error' => 'Kampanya güncellenemedi.', 'deal' => $data]);
    }
}
```
- **Formdan gelen yeni kampanya verileri `$data` dizisine aktarılır.**
- **Başarıyla güncellenirse `/admin/deal` sayfasına yönlendirilir.**
- **Başarısız olursa hata mesajı ile `admin/deal/edit` sayfası tekrar yüklenir.**

---

### **6. Kampanya Silme (`delete($id)`)**
```php
public function delete($id)
{
    if ($this->dealModel->deleteDeal($id)) {
        header('Location: /admin/deal');
        exit;
    } else {
        $this->renderAdmin('admin/deal/index', ['error' => 'Kampanya silinemedi.']);
    }
}
```
- **Kampanya ID’ye göre veritabanından silinir.**
- **Başarılı olursa `/admin/deal` sayfasına yönlendirilir.**
- **Silme işlemi başarısız olursa hata mesajı ile kampanya listesi tekrar yüklenir.**

---

```php
<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\DealModel;

class DealController extends BaseController
{
    private $dealModel;

    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
        $this->dealModel = new DealModel();
    }

    public function index()
    {
        $deals = $this->dealModel->getAllDeals();
        $this->renderAdmin('admin/deal/index', ['deals' => $deals]);
    }

    public function create()
    {
        $this->renderAdmin('admin/deal/create');
    }

    public function store()
    {
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'status' => $_POST['status']
        ];

        if ($this->dealModel->createDeal($data)) {
            header('Location: /admin/deal');
            exit;
        } else {
            $this->renderAdmin('admin/deal/create', ['error' => 'Kampanya oluşturulamadı.']);
        }
    }

    public function edit($id)
    {
        $deal = $this->dealModel->getDealById($id);
        $this->renderAdmin('admin/deal/edit', ['deal' => $deal]);
    }

    public function update($id)
    {
        $data = [
            'title' => $_POST['title'],
            'content' => $_POST['content'],
            'start_date' => $_POST['start_date'],
            'end_date' => $_POST['end_date'],
            'status' => $_POST['status']
        ];

        if ($this->dealModel->updateDeal($id, $data)) {
            header('Location: /admin/deal');
            exit;
        } else {
            $this->renderAdmin('admin/deal/edit', ['error' => 'Kampanya güncellenemedi.', 'deal' => $data]);
        }
    }

    public function delete($id)
    {
        if ($this->dealModel->deleteDeal($id)) {
            header('Location: /admin/deal');
            exit;
        } else {
            $this->renderAdmin('admin/deal/index', ['error' => 'Kampanya silinemedi.']);
        }
    }
}

```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Kampanya Yönetimi** sayfasının işleyişini açıklar. Yönetici, kampanyaları **listeleyebilir, yeni kampanya ekleyebilir, mevcut kampanyaları düzenleyebilir ve silebilir.**

Geliştirme olarak:
- **Kampanyalara görsel ekleme desteği eklenebilir.**
- **Özel indirim oranı belirleme özelliği entegre edilebilir.**


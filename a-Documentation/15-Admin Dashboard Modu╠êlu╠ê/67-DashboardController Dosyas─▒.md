# DashboardController Sınıfı 

## Genel Bakış

`DashboardController` sınıfı, admin panelindeki ana kontrolcülerden biridir. Dashboard sayfasını yönetir ve kullanıcılara gerekli istatistiksel verileri sunar.
Bu kontrolcü, `DashboardModel` sınıfından verileri alarak admin görünümüne aktarır.

---

## Kullanılan Teknolojiler
- **PHP** (Nesne Yönelimli Programlama - OOP)
- **MVC Yapısı** (Model-View-Controller)

---

## Sınıf Yapısı

### **1. Constructor Metodu**

```php
public function __construct()
{
    parent::__construct();
    $this->dashboardModel = new DashboardModel();
}
```

- `BaseController` sınıfının `__construct()` metodunu çağırarak temel başlatma işlemlerini yapar.
- `DashboardModel` sınıfından yeni bir nesne oluşturarak model ile iletişim kurar.

---

### **2. Dashboard Verilerini Getirme (index Metodu)**

```php
public function index()
{
    $data = [
        'customerCount' => $this->dashboardModel->getCustomerCount(),
        'orderCount' => $this->dashboardModel->getOrderCount(),
        'orderStatusCounts' => $this->dashboardModel->getOrderStatusCounts(),
        'todayOrderCount' => $this->dashboardModel->getTodayOrderCount(),
        'totalOrderCount' => $this->dashboardModel->getTotalOrderCount(),
        'cancelledOrderCount' => $this->dashboardModel->getCancelledOrderCount(),
        'pendingOrderCount' => $this->dashboardModel->getPendingOrderCount(),
        'completedOrderCount' => $this->dashboardModel->getCompletedOrderCount()
    ];

    $this->renderAdmin('admin/dashboard', $data);
}
```

#### **Açıklama:**

- **`getCustomerCount()`** → Toplam müşteri sayısını getirir.
- **`getOrderCount()`** → Toplam sipariş sayısını getirir.
- **`getOrderStatusCounts()`** → Sipariş durumlarına göre sipariş sayılarını getirir.
- **`getTodayOrderCount()`** → Bugün oluşturulan sipariş sayısını getirir.
- **`getTotalOrderCount()`** → Toplam sipariş sayısını getirir.
- **`getCancelledOrderCount()`** → İptal edilen sipariş sayısını getirir.
- **`getPendingOrderCount()`** → Bekleyen sipariş sayısını getirir.
- **`getCompletedOrderCount()`** → Tamamlanan sipariş sayısını getirir.

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\DashboardModel;

class DashboardController extends BaseController
{
    private $dashboardModel;

    public function __construct()
    {
        parent::__construct();
        $this->dashboardModel = new DashboardModel();
    }

    public function index()
    {
        $data = [
            'customerCount' => $this->dashboardModel->getCustomerCount(),
            'orderCount' => $this->dashboardModel->getOrderCount(),
            'orderStatusCounts' => $this->dashboardModel->getOrderStatusCounts(),
            'todayOrderCount' => $this->dashboardModel->getTodayOrderCount(),
            'totalOrderCount' => $this->dashboardModel->getTotalOrderCount(),
            'cancelledOrderCount' => $this->dashboardModel->getCancelledOrderCount(),
            'pendingOrderCount' => $this->dashboardModel->getPendingOrderCount(),
            'completedOrderCount' => $this->dashboardModel->getCompletedOrderCount()
        ];

        $this->renderAdmin('admin/dashboard', $data);
    }
}

```
---

## **Sonuç**

`DashboardController` sınıfı, admin panelindeki önemli istatistiksel bilgileri yöneten bir yapıya sahiptir. Bu kontrolcü, `DashboardModel` sınıfından verileri alıp admin paneline aktararak kullanıcı dostu bir dashboard görünümü sağlar.


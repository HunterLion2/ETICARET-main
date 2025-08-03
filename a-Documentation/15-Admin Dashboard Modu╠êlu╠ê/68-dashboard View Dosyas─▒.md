# Admin Dashboard 

## Genel Bakış

Bu dokümantasyon, **Admin Dashboard** bölümünün yapısını ve içeriğini açıklar. Yönetim paneli, site yöneticilerine günlük müşteri ve sipariş verilerini görselleştiren bir arayüz sunar.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3**
- **Bootstrap 5** (Responsive tasarım)
- **FontAwesome** (İkon setleri)
- **PHP** (Dinamik veri gösterimi)

---

## Sayfa Yapısı

### **1. Genel Yerleşim**
```html
<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="h1d-flex d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Dashboard</h1>
            </div>
        </main>
    </div>
</div>
```

- `container` ana kapsayıcıdır.
- `row` içinde **Dashboard Başlığı** bulunur.
- `h1d-flex` sınıfı başlıkları hizalar.

---

### **2. Günlük Veriler**

```html
<div class="section-title">
    Güne Özel <i class="fas fa-sun"></i>
</div>
```

#### **Yeni Müşteriler**
```html
<div class="col-md-3 col-12">
    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <h1 class="fw-bold mb-0"><?= $data['customerCount'] ?></h1>
                <p class="mb-0">Yeni Müşteriler</p>
            </div>
            <div class="ms-auto"><i class="fas fa-user-plus fa-3x"></i></div>
        </div>
    </div>
</div>
```
- Yeni müşteri sayısını gösterir.
- **FontAwesome** ikonları kullanılmıştır.
- **PHP ile `$data['customerCount']`** dinamik olarak çekilir.

#### **Günün Sipariş Sayısı**
```html
<div class="col-md-3 col-12">
    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <h1 class="fw-bold mb-0"><?= $data['todayOrderCount'] ?></h1>
                <p class="mb-0">Günün Sipariş Sayısı</p>
            </div>
            <div class="ms-auto"><i class="fas fa-shopping-cart fa-3x"></i></div>
        </div>
    </div>
</div>
```
- Gün içinde gelen sipariş sayısını gösterir.

---

### **3. Siparişler Bölümü**

```html
<div class="section-title">
    Siparişler <i class="fas fa-shopping-basket"></i>
</div>
```

#### **Bekleyen Siparişler**
```html
<div class="col-md-3 col-12">
    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <h1 class="fw-bold mb-0"><?= $data['pendingOrderCount'] ?></h1>
                <p class="mb-0">Bekleyen Siparişler</p>
            </div>
            <div class="ms-auto"><i class="fas fa-clock fa-3x"></i></div>
        </div>
    </div>
</div>
```

#### **İptal Edilen Siparişler**
```html
<div class="col-md-3 col-12">
    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <h1 class="fw-bold mb-0"><?= $data['cancelledOrderCount'] ?></h1>
                <p class="mb-0">İptal Siparişler</p>
            </div>
            <div class="ms-auto"><i class="fas fa-times-circle fa-3x"></i></div>
        </div>
    </div>
</div>
```

#### **Tamamlanan Siparişler**
```html
<div class="col-md-3 col-12">
    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <h1 class="fw-bold mb-0"><?= $data['completedOrderCount'] ?></h1>
                <p class="mb-0">Tamamlanan Siparişler</p>
            </div>
            <div class="ms-auto"><i class="fas fa-check-circle fa-3x"></i></div>
        </div>
    </div>
</div>
```

#### **Toplam Siparişler**
```html
<div class="col-md-3 col-12">
    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
        <div class="card-body d-flex align-items-center">
            <div class="me-3">
                <h1 class="fw-bold mb-0"><?= $data['totalOrderCount'] ?></h1>
                <p class="mb-0">Toplam Siparişler</p>
            </div>
            <div class="ms-auto"><i class="fas fa-shopping-bag fa-3x"></i></div>
        </div>
    </div>
</div>
```

---

```html
<div class="container">

    <!-- Admin panel içeriği buraya gelecek -->
    <div class="row">
        <main class="col-md-12 ">
            <div class="h1d-flex d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Dashboard</h1>
            </div>
            <div class="section-title">
                Güne Özel
                <i class="fas fa-sun"></i>
            </div>
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <h1 class="fw-bold mb-0"><?= $data['customerCount'] ?></h1>
                                <p class="mb-0">Yeni Müşteriler</p>
                            </div>
                            <div class="ms-auto"><i class="fas fa-user-plus fa-3x"></i></div>
                        </div>
                        <div class="card-footer bg-secondary border-0 text-end rounded-4"><a href="#" class="text-white text-decoration-none">İncele <i class="fas fa-arrow-circle-right"></i></a></div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <h1 class="fw-bold mb-0"><?= $data['todayOrderCount'] ?></h1>
                                <p class="mb-0">Günün Sipariş Sayısı</p>
                            </div>
                            <div class="ms-auto"><i class="fas fa-shopping-cart fa-3x"></i></div>
                        </div>
                        <div class="card-footer bg-secondary border-0 text-end rounded-4"><a href="#" class="text-white text-decoration-none">İncele <i class="fas fa-arrow-circle-right"></i></a></div>
                    </div>
                </div>
                <!-- ...diğer güne özel bilgiler... -->
            </div>
            <div class="section-title">
                Siparişler
                <i class="fas fa-shopping-basket"></i>
            </div>
            <div class="row">
                <div class="col-md-3 col-12">
                    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <h1 class="fw-bold mb-0"><?= $data['pendingOrderCount'] ?></h1>
                                <p class="mb-0">Bekleyen Siparişler</p>
                            </div>
                            <div class="ms-auto"><i class="fas fa-clock fa-3x"></i></div>
                        </div>
                        <div class="card-footer bg-secondary border-0 text-end rounded-4"><a href="#" class="text-white text-decoration-none">İncele <i class="fas fa-arrow-circle-right"></i></a></div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <h1 class="fw-bold mb-0"><?= $data['cancelledOrderCount'] ?></h1>
                                <p class="mb-0">İptal Siparişler</p>
                            </div>
                            <div class="ms-auto"><i class="fas fa-times-circle fa-3x"></i></div>
                        </div>
                        <div class="card-footer bg-secondary border-0 text-end rounded-4"><a href="#" class="text-white text-decoration-none">İncele <i class="fas fa-arrow-circle-right"></i></a></div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <h1 class="fw-bold mb-0"><?= $data['completedOrderCount'] ?></h1>
                                <p class="mb-0">Tamamlanan Siparişler</p>
                            </div>
                            <div class="ms-auto"><i class="fas fa-check-circle fa-3x"></i></div>
                        </div>
                        <div class="card-footer bg-secondary border-0 text-end rounded-4"><a href="#" class="text-white text-decoration-none">İncele <i class="fas fa-arrow-circle-right"></i></a></div>
                    </div>
                </div>
                <div class="col-md-3 col-12">
                    <div class="card text-white bg-secondary mb-3 shadow rounded-4">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3">
                                <h1 class="fw-bold mb-0"><?= $data['totalOrderCount'] ?></h1>
                                <p class="mb-0">Toplam Siparişler</p>
                            </div>
                            <div class="ms-auto"><i class="fas fa-shopping-bag fa-3x"></i></div>
                        </div>
                        <div class="card-footer bg-secondary border-0 text-end rounded-4"><a href="#" class="text-white text-decoration-none">İncele <i class="fas fa-arrow-circle-right"></i></a></div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Dashboard** bileşenlerinin yapısını açıklamaktadır. Bu sistem, yöneticilerin site istatistiklerini hızlıca görmesini sağlayan kullanıcı dostu bir arayüz sunmaktadır. Ekstra geliştirmeler için ilgili bölümlere daha fazla detay eklenebilir.


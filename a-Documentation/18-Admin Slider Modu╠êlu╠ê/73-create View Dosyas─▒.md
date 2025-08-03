# Yeni Slider Ekleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Yeni Slider Ekleme** sayfasının işleyişini açıklar. Yönetici, yeni bir slider (banner) ekleyerek site üzerinde gösterebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3**
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Form işleme ve dosya yükleme işlemleri için)

---

## Sayfa Yapısı

### **1. Başlık ve Geri Dön Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Yeni Slider Ekle</h1>
    <a href="/admin/slider" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Yeni Slider Ekle" başlığı gösterilir.
- **Geri Dön Butonu:** Kullanıcıyı slider listesinin bulunduğu `/admin/slider` sayfasına yönlendirir.

---

### **2. Başarı ve Hata Mesajları**
```php
<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
```
- **Başarı Mesajı (`$success`)** → Slider başarıyla eklendiğinde görüntülenir.
- **Hata Mesajı (`$error`)** → Hatalı giriş veya eksik veri girildiğinde görüntülenir.

---

### **3. Slider Ekleme Formu**
```html
<form action="/admin/slider/store" method="POST" enctype="multipart/form-data">
```
- **`action="/admin/slider/store"`** → Form, `store()` metoduna yönlendirilerek slider verisi işlenir.
- **`method="POST"`** → Form verisi `POST` ile gönderilir.
- **`enctype="multipart/form-data"`** → Dosya yükleme işlemi için gerekli.

---

### **4. Form Alanları**
#### **Slider Görseli**
```html
<div class="mb-3">
    <label for="image_url" class="form-label">Slider Görseli</label>
    <input type="file" id="image_url" name="image_url" class="form-control" required>
</div>
```
- **Görsel dosyası yükleme alanı.**
- **`required`** ile boş geçilmesi engellenir.

#### **Başlık**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" id="title" name="title" class="form-control" required>
</div>
```
- **Slider başlığını belirlemek için giriş alanı.**

#### **Açıklama**
```html
<div class="mb-3">
    <label for="description" class="form-label">Açıklama</label>
    <textarea id="description" name="description" class="form-control" required></textarea>
</div>
```
- **Slider hakkında kısa bir açıklama girişi yapılır.**

#### **Bağlantı (URL)**
```html
<div class="mb-3">
    <label for="link_url" class="form-label">URL</label>
    <input type="url" id="link_url" name="link_url" class="form-control" required>
</div>
```
- **Slider’a tıklanınca yönlendirecek URL girilir.**

#### **Durum (Aktif/Pasif)**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select id="status" name="status" class="form-control" required>
        <option value="1">Aktif</option>
        <option value="0">Pasif</option>
    </select>
</div>
```
- **Slider'ın yayın durumunu belirler.**
- **1 → Aktif, 0 → Pasif** anlamına gelir.

#### **Sıra Numarası**
```html
<div class="mb-3">
    <label for="sort_order" class="form-label">Sıra</label>
    <input type="number" id="sort_order" name="sort_order" class="form-control" required>
</div>
```
- **Slider’ların gösterim sırasını belirler.**
- **Küçük rakamlar önce gösterilir.**

---

### **5. Form Gönder Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Kaydet</button>
</div>
```
- **Kullanıcı, formu tamamladıktan sonra "Kaydet" butonuna tıklayarak slider'ı ekleyebilir.**

---

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Yeni Slider Ekle</h1>
        <a href="/admin/slider" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8" style="max-width: 800px;">

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/slider/store" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="image_url" class="form-label">Slider Görseli</label>
                    <input type="file" id="image_url" name="image_url" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="link_url" class="form-label">URL</label>
                    <input type="url" id="link_url" name="link_url" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sıra</label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control" required>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Kaydet</button>
                </div>
            </form>
        </main>
    </div>
</div>
```
---
## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Yeni Slider Ekleme** sayfasının işleyişini açıklar. Yönetici, slider ekleyerek site içeriğini yönetebilir.
Görsel yükleme ve veri girişlerinin tamamı form üzerinden sağlanır. Ek geliştirmeler için **önizleme** veya **görsel boyut kontrolü** gibi özellikler eklenebilir.


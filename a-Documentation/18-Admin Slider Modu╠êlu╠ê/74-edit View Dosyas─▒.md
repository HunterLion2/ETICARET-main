# Slider Düzenleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Slider Düzenleme** sayfasının işleyişini açıklar. Yönetici, mevcut bir slider'ı güncelleyerek site içeriğini yönetebilir.

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
    <h1 class="h2 py-0 px-3">Slider Düzenle</h1>
    <a href="/admin/slider" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Slider Düzenle" başlığı gösterilir.
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
- **Başarı Mesajı (`$success`)** → Slider başarıyla güncellendiğinde görüntülenir.
- **Hata Mesajı (`$error`)** → Hatalı giriş veya eksik veri girildiğinde görüntülenir.

---

### **3. Slider Düzenleme Formu**
```html
<form action="/admin/slider/update/<?= htmlspecialchars($slider['id']) ?>" method="POST" enctype="multipart/form-data">
```
- **`action="/admin/slider/update/{id}"`** → Form, güncellenecek slider'ın ID'si ile `update()` metoduna yönlendirilir.
- **`method="POST"`** → Form verisi `POST` ile gönderilir.
- **`enctype="multipart/form-data"`** → Dosya yükleme işlemi için gerekli.

---

### **4. Form Alanları**
#### **Slider Görseli**
```html
<div class="mb-3">
    <label for="image_url" class="form-label">Slider Görseli</label>
    <input type="file" id="image_url" name="image_url" class="form-control">
    <img src="<?= htmlspecialchars($slider['image_url']) ?>" alt="Slider Image" class="img-fluid mt-2" style="max-width: 200px;">
</div>
```
- **Mevcut slider görseli gösterilir.**
- **Yeni görsel yüklenirse eski görsel değiştirilir.**

#### **Başlık**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($slider['title']) ?>" required>
</div>
```
- **Slider başlığı güncellenebilir.**

#### **Açıklama**
```html
<div class="mb-3">
    <label for="description" class="form-label">Açıklama</label>
    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($slider['description']) ?></textarea>
</div>
```
- **Slider açıklaması güncellenebilir.**

#### **Bağlantı (URL)**
```html
<div class="mb-3">
    <label for="link_url" class="form-label">URL</label>
    <input type="url" id="link_url" name="link_url" class="form-control" value="<?= htmlspecialchars($slider['link_url']) ?>" required>
</div>
```
- **Slider’a tıklanınca yönlendirecek URL girilir veya güncellenir.**

#### **Durum (Aktif/Pasif)**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select id="status" name="status" class="form-control" required>
        <option value="1" <?= $slider['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
        <option value="0" <?= $slider['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
    </select>
</div>
```
- **Slider'ın yayın durumunu değiştirebiliriz.**
- **1 → Aktif, 0 → Pasif** anlamına gelir.

#### **Sıra Numarası**
```html
<div class="mb-3">
    <label for="sort_order" class="form-label">Sıra</label>
    <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= htmlspecialchars($slider['sort_order']) ?>" required>
</div>
```
- **Slider’ların gösterim sırasını belirler.**
- **Küçük rakamlar önce gösterilir.**

---

### **5. Form Güncelleme Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Güncelle</button>
</div>
```
- **Kullanıcı, formu tamamladıktan sonra "Güncelle" butonuna tıklayarak slider'ı güncelleyebilir.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Slider Düzenle</h1>
        <a href="/admin/slider" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/slider/update/<?= htmlspecialchars($slider['id']) ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="image_url" class="form-label">Slider Görseli</label>
                    <input type="file" id="image_url" name="image_url" class="form-control">
                    <img src="<?= htmlspecialchars($slider['image_url']) ?>" alt="Slider Image" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($slider['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($slider['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="link_url" class="form-label">URL</label>
                    <input type="url" id="link_url" name="link_url" class="form-control" value="<?= htmlspecialchars($slider['link_url']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="1" <?= $slider['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $slider['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="sort_order" class="form-label">Sıra</label>
                    <input type="number" id="sort_order" name="sort_order" class="form-control" value="<?= htmlspecialchars($slider['sort_order']) ?>" required>
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </main>
    </div>
</div>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Slider Düzenleme** sayfasının işleyişini açıklar. Yönetici, mevcut slider'ı güncelleyerek içeriği yönetebilir.
Mevcut veriler otomatik olarak form alanlarına doldurulur ve kullanıcı değişiklikleri kaydedebilir. Ek geliştirmeler için **önizleme** veya **görsel boyut kontrolü** gibi özellikler eklenebilir.


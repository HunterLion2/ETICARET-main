# Yeni Kampanya Ekleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Yeni Kampanya Ekleme** sayfasının işleyişini açıklar. Yönetici, yeni bir kampanya oluşturarak sistemde aktif veya pasif hale getirebilir.

---

## Kullanılan Teknolojiler
- **PHP** (Form işlemleri ve sunucu tarafı iş mantığı için)
- **HTML5 & CSS3** (Form elemanları ve tasarım için)
- **Bootstrap 5** (Responsive form düzeni için)

---

## Sayfa Yapısı

### **1. Başlık ve Geri Dön Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Yeni Kampanya Ekle</h1>
    <a href="/admin/deal" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** "Yeni Kampanya Ekle" olarak belirlenmiştir.
- **Geri Dön Butonu:** Kullanıcıyı kampanya listesi sayfasına yönlendirir.

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
- **Başarı Mesajı (`$success`)** → Kampanya başarıyla oluşturulduğunda görüntülenir.
- **Hata Mesajı (`$error`)** → Kampanya oluşturma sırasında bir hata meydana gelirse görüntülenir.

---

### **3. Kampanya Ekleme Formu**
```html
<form action="/admin/deal/store" method="post">
```
- **`action="/admin/deal/store"`** → Form, yeni kampanya eklemek için belirtilen rotaya yönlendirilir.
- **`method="post"`** → Form verisi **POST** yöntemiyle gönderilir.

#### **Başlık Alanı**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" class="form-control" id="title" name="title" required>
</div>
```
- **Kullanıcı, kampanyanın adını belirleyebilir.**
- **Zorunlu bir alandır (`required`).**

#### **İçerik Alanı**
```html
<div class="mb-3">
    <label for="content" class="form-label">İçerik</label>
    <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
</div>
```
- **Kullanıcı, kampanya açıklamasını yazabilir.**
- **Zorunlu bir alandır (`required`).**

#### **Başlangıç ve Bitiş Tarihleri**
```html
<div class="mb-3">
    <label for="start_date" class="form-label">Başlangıç Tarihi</label>
    <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
</div>
<div class="mb-3">
    <label for="end_date" class="form-label">Bitiş Tarihi</label>
    <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
</div>
```
- **Kullanıcı, kampanyanın hangi tarihler arasında geçerli olacağını belirleyebilir.**
- **Zorunlu alanlardır (`required`).**

#### **Durum Seçimi (Aktif/Pasif)**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select class="form-control" id="status" name="status" required>
        <option value="1">Aktif</option>
        <option value="0">Pasif</option>
    </select>
</div>
```
- **Kampanya, "Aktif" veya "Pasif" olarak belirlenebilir.**
- **Zorunlu bir alandır (`required`).**

---

### **4. Kaydet Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Kaydet</button>
</div>
```
- **Kullanıcı, "Kaydet" butonuna tıklayarak yeni kampanyayı oluşturabilir.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Yeni Kampanya Ekle</h1>
        <a href="/admin/deal" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/deal/store" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Başlangıç Tarihi</label>
                    <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Bitiş Tarihi</label>
                    <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="1">Aktif</option>
                        <option value="0">Pasif</option>
                    </select>
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

Bu dokümantasyon, **Admin Paneli - Yeni Kampanya Ekleme** sayfasının işleyişini açıklar. Yönetici, kampanyanın başlığını, içeriğini, başlangıç ve bitiş tarihlerini belirleyerek kampanyayı **aktif veya pasif hale getirebilir.**

Geliştirme olarak:
- **Görsel ekleme özelliği entegre edilebilir.**
- **Kampanya indirim oranı belirleme desteği eklenebilir.**


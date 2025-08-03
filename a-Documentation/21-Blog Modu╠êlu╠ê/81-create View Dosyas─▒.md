# Yeni Blog Yazısı Ekleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Yeni Blog Yazısı Ekleme** sayfasının işleyişini açıklar. Yönetici, yeni bir blog yazısı oluşturabilir ve içeriğini düzenleyebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3** (Form yapısı için)
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Form işleme işlemleri için)

---

## Sayfa Yapısı

### **1. Başlık ve Geri Dön Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Yeni Blog Yazısı Ekle</h1>
    <a href="/admin/blogs" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Yeni Blog Yazısı Ekle" başlığı gösterilir.
- **Geri Dön Butonu:** Kullanıcıyı `/admin/blogs` sayfasına yönlendirir.

---

### **2. Başarı ve Hata Mesajları**
```php
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
```
- **Hata Mesajı (`$error`)** → Form gönderilirken bir hata oluştuğunda görüntülenir.

---

### **3. Blog Ekleme Formu**
```html
<form action="/admin/blogs/store" method="POST" enctype="multipart/form-data">
```
- **`action="/admin/blogs/store"`** → Form, `store()` metoduna yönlendirilir.
- **`method="POST"`** → Form verisi `POST` yöntemiyle gönderilir.
- **`enctype="multipart/form-data"`** → Görsel yükleme için gerekli ayarlama yapılır.

#### **Kapak Resmi Yükleme**
```html
<div class="mb-3">
    <label for="thumbnail_url" class="form-label">Kapak Resmi</label>
    <input type="file" id="thumbnail_url" name="thumbnail_url" class="form-control" required>
</div>
```
- **Kullanıcı, blog yazısına bir kapak resmi yükler.**
- **Girilmesi zorunludur (`required`).**

#### **Başlık Girişi**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" id="title" name="title" class="form-control" required>
</div>
```
- **Kullanıcı, blog yazısının başlığını girer.**
- **Zorunlu bir alandır.**

#### **İçerik Alanı**
```html
<div class="mb-3">
    <label for="content" class="form-label">İçerik</label>
    <textarea id="content" name="content" class="form-control" required></textarea>
</div>
```
- **Kullanıcı, blog yazısının içeriğini yazabilir.**
- **Zorunlu bir alandır.**

#### **Yayınlanma Tarihi Seçimi**
```html
<div class="mb-3">
    <label for="published_at" class="form-label">Yayınlanma Tarihi</label>
    <input type="datetime-local" id="published_at" name="published_at" class="form-control" required>
</div>
```
- **Kullanıcı, blog yazısının yayınlanma tarihini belirler.**
- **Zorunlu bir alandır.**

---

### **4. Kaydet Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Kaydet</button>
</div>
```
- **Kullanıcı, "Kaydet" butonuna tıklayarak yeni blog yazısını oluşturabilir.**

---

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Yeni Blog Yazısı Ekle</h1>
        <a href="/admin/blogs" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8" style="max-width: 800px;">

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/blogs/store" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="thumbnail_url" class="form-label">Kapak Resmi</label>
                    <input type="file" id="thumbnail_url" name="thumbnail_url" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea id="content" name="content" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="published_at" class="form-label">Yayınlanma Tarihi</label>
                    <input type="datetime-local" id="published_at" name="published_at" class="form-control" required>
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

Bu dokümantasyon, **Admin Paneli - Yeni Blog Yazısı Ekleme** sayfasının işleyişini açıklar. Yönetici, blog başlığını, içeriğini, kapak resmini ve yayınlanma tarihini belirleyerek yeni bir blog yazısı oluşturabilir. **Zorunlu alanlar belirlenmiş ve hatalar yönetilmiştir.** Geliştirme olarak **önizleme özelliği** veya **kategori seçimi** eklenebilir.


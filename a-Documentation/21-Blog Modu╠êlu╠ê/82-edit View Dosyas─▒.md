# Blog Yazısını Düzenleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Blog Yazısını Düzenleme** sayfasının işleyişini açıklar. Yönetici, mevcut bir blog yazısını güncelleyebilir ve içeriğini düzenleyebilir.

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
    <h1 class="h2 py-0 px-3">Blog Yazısını Düzenle</h1>
    <a href="/admin/blogs" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Blog Yazısını Düzenle" başlığı gösterilir.
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

### **3. Blog Düzenleme Formu**
```html
<form action="/admin/blogs/update/<?= htmlspecialchars($post['id']) ?>" method="POST" enctype="multipart/form-data">
```
- **`action="/admin/blogs/update/{id}"`** → Form, belirtilen blog yazısının ID’sine göre güncelleme metoduna yönlendirilir.
- **`method="POST"`** → Form verisi `POST` yöntemiyle gönderilir.
- **`enctype="multipart/form-data"`** → Görsel yükleme için gerekli ayarlama yapılır.

#### **Kapak Resmi Yükleme ve Önizleme**
```html
<div class="mb-3">
    <label for="thumbnail_url" class="form-label">Kapak Resmi</label>
    <input type="file" id="thumbnail_url" name="thumbnail_url" class="form-control">
    <img src="<?= htmlspecialchars($post['thumbnail_url']) ?>" alt="Blog Thumbnail" class="img-fluid mt-2" style="max-width: 200px;">
</div>
```
- **Kullanıcı, blog yazısının kapak resmini güncelleyebilir.**
- **Mevcut görsel önizleme olarak gösterilir.**

#### **Başlık Girişi**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
</div>
```
- **Kullanıcı, blog yazısının başlığını düzenleyebilir.**
- **Zorunlu bir alandır.**

#### **İçerik Alanı**
```html
<div class="mb-3">
    <label for="content" class="form-label">İçerik</label>
    <textarea id="content" name="content" class="form-control" required><?= htmlspecialchars($post['content']) ?></textarea>
</div>
```
- **Kullanıcı, blog yazısının içeriğini düzenleyebilir.**
- **Zorunlu bir alandır.**

#### **Yayınlanma Tarihi Seçimi**
```html
<div class="mb-3">
    <label for="published_at" class="form-label">Yayınlanma Tarihi</label>
    <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="<?= htmlspecialchars($post['published_at']) ?>" required>
</div>
```
- **Kullanıcı, blog yazısının yayınlanma tarihini belirleyebilir.**
- **Zorunlu bir alandır.**

---

### **4. Güncelle Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Güncelle</button>
</div>
```
- **Kullanıcı, "Güncelle" butonuna tıklayarak mevcut blog yazısını değiştirebilir.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Blog Yazısını Düzenle</h1>
        <a href="/admin/blogs" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/blogs/update/<?= htmlspecialchars($post['id']) ?>" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="thumbnail_url" class="form-label">Kapak Resmi</label>
                    <input type="file" id="thumbnail_url" name="thumbnail_url" class="form-control">
                    <img src="<?= htmlspecialchars($post['thumbnail_url']) ?>" alt="Blog Thumbnail" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($post['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea id="content" name="content" class="form-control" required><?= htmlspecialchars($post['content']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="published_at" class="form-label">Yayınlanma Tarihi</label>
                    <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="<?= htmlspecialchars($post['published_at']) ?>" required>
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

Bu dokümantasyon, **Admin Paneli - Blog Yazısını Düzenleme** sayfasının işleyişini açıklar. Yönetici, blog başlığını, içeriğini, kapak resmini ve yayınlanma tarihini değiştirerek mevcut bir blog yazısını güncelleyebilir. **Mevcut kapak resmi gösterilerek görsel değişikliği yapılabilir.** Geliştirme olarak **önizleme özelliği** veya **kategori seçimi** eklenebilir.
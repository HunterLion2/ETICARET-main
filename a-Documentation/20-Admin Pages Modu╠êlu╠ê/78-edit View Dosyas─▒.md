# Sayfa Düzenleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Sayfa Düzenleme** sayfasının işleyişini açıklar. Yönetici, mevcut bir sayfayı güncelleyebilir ve içeriğini düzenleyebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3** (Form yapısı için)
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Form işleme işlemleri için)
- **TinyMCE** (Zengin metin editörü entegrasyonu)

---

## Sayfa Yapısı

### **1. Başlık ve Geri Dön Butonu**
```html
<div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Sayfa Düzenle</h1>
    <a href="/admin/pages" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Sayfa Düzenle" başlığı gösterilir.
- **Geri Dön Butonu:** Kullanıcıyı `/admin/pages` sayfasına yönlendirir.

---

### **2. Başarı ve Hata Mesajları**
```php
<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php elseif (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
```
- **Başarı Mesajı (`$success`)** → Sayfa başarıyla güncellendiğinde görüntülenir.
- **Hata Mesajı (`$error`)** → Form gönderilirken bir hata oluştuğunda görüntülenir.

---

### **3. Sayfa Düzenleme Formu**
```html
<form action="/admin/pages/update/<?= htmlspecialchars($page['id']) ?>" method="post">
```
- **`action="/admin/pages/update/{id}"`** → Form, belirtilen sayfa ID’sine göre güncelleme metoduna yönlendirilir.
- **`method="post"`** → Form verisi `POST` yöntemiyle gönderilir.

#### **Başlık Girişi**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($page['title']) ?>" required>
</div>
```
- **Kullanıcı, sayfa başlığını düzenleyebilir.**
- **Girilmesi zorunludur (`required`).**

#### **İçerik Alanı**
```html
<div class="mb-3">
    <label for="content" class="form-label">İçerik</label>
    <textarea class="form-control" id="content" name="content" rows="5"><?= htmlspecialchars($page['content']) ?></textarea>
</div>
```
- **Kullanıcı, sayfanın içeriğini düzenleyebilir.**
- **TinyMCE ile gelişmiş editör desteği sağlanır.**

#### **Durum Seçimi**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select class="form-control" id="status" name="status" required>
        <option value="draft" <?= $page['status'] == 'draft' ? 'selected' : '' ?>>Taslak</option>
        <option value="published" <?= $page['status'] == 'published' ? 'selected' : '' ?>>Yayınlandı</option>
    </select>
</div>
```
- **Sayfanın yayın durumu değiştirilebilir.**
- **Taslak veya yayınlanmış olarak güncellenebilir.**

---

### **4. Güncelle Butonu**
```html
<div class="d-flex justify-content-end mt-4 mb-5">
    <button type="submit" class="btn btn-secondary">Güncelle</button>
</div>
```
- **Kullanıcı, "Güncelle" butonuna tıklayarak mevcut sayfa bilgilerini değiştirebilir.**

---

### **5. TinyMCE Entegrasyonu**
```html
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>
```
- **TinyMCE metin editörü etkinleştirilerek gelişmiş metin düzenleme sağlanır.**
- **Değişiklikler kaydedildiğinde, TinyMCE otomatik olarak günceller.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Sayfa Düzenle</h1>
                <a href="/admin/pages" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/pages/update/<?= htmlspecialchars($page['id']) ?>" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($page['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" id="content" name="content" rows="5"><?= htmlspecialchars($page['content']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="draft" <?= $page['status'] == 'draft' ? 'selected' : '' ?>>Taslak</option>
                        <option value="published" <?= $page['status'] == 'published' ? 'selected' : '' ?>>Yayınlandı</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: '#content',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Sayfa Düzenleme** sayfasının işleyişini açıklar. Yönetici, sayfa başlığını, içeriğini ve durumunu değiştirerek mevcut bir sayfayı düzenleyebilir. **TinyMCE entegrasyonu ile gelişmiş metin düzenleme desteği sunulmuştur.** Geliştirme olarak **önizleme özelliği** veya **çoklu dil desteği** eklenebilir.
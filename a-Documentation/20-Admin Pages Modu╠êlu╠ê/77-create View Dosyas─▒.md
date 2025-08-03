# Yeni Sayfa Ekleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Yeni Sayfa Ekleme** sayfasının işleyişini açıklar. Yönetici, yeni bir sayfa oluşturabilir ve içeriğini düzenleyebilir.

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
    <h1 class="h2">Yeni Sayfa Ekle</h1>
    <a href="/admin/pages" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Yeni Sayfa Ekle" başlığı gösterilir.
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
- **Başarı Mesajı (`$success`)** → Sayfa başarıyla oluşturulduğunda görüntülenir.
- **Hata Mesajı (`$error`)** → Form gönderilirken bir hata oluştuğunda görüntülenir.

---

### **3. Sayfa Ekleme Formu**
```html
<form action="/admin/pages/store" method="post">
```
- **`action="/admin/pages/store"`** → Form, `store()` metoduna yönlendirilir.
- **`method="post"`** → Form verisi `POST` yöntemiyle gönderilir.

#### **Başlık Girişi**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" class="form-control" id="title" name="title" required>
</div>
```
- **Kullanıcı, sayfa başlığını girer.**
- **Girilmesi zorunludur (`required`).**

#### **İçerik Alanı**
```html
<div class="mb-3">
    <label for="content" class="form-label">İçerik</label>
    <textarea class="form-control" id="content" name="content" rows="5"></textarea>
</div>
```
- **Kullanıcı, sayfanın içeriğini yazabilir.**
- **TinyMCE ile gelişmiş editör desteği sağlanır.**

#### **Durum Seçimi**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select class="form-control" id="status" name="status" required>
        <option value="draft">Taslak</option>
        <option value="published">Yayınlandı</option>
    </select>
</div>
```
- **Sayfanın yayın durumu seçilebilir.**
- **Taslak veya yayınlanmış olarak kaydedilebilir.**

---

### **4. Kaydet Butonu**
```html
<div class="d-flex justify-content-end mt-4 mb-5">
    <button type="submit" class="btn btn-secondary">Kaydet</button>
</div>
```
- **Kullanıcı, "Kaydet" butonuna tıklayarak yeni sayfayı oluşturabilir.**

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
                <h1 class="h2">Yeni Sayfa Ekle</h1>
                <a href="/admin/pages" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/pages/store" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea class="form-control" id="content" name="content" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="draft">Taslak</option>
                        <option value="published">Yayınlandı</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-secondary">Kaydet</button>
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

Bu dokümantasyon, **Admin Paneli - Yeni Sayfa Ekleme** sayfasının işleyişini açıklar. Yönetici, sayfa başlığını, içeriğini ve durumunu belirleyerek yeni bir sayfa oluşturabilir. **TinyMCE entegrasyonu ile gelişmiş metin düzenleme desteği sunulmuştur.** Geliştirme olarak **önizleme özelliği** veya **çoklu dil desteği** eklenebilir.
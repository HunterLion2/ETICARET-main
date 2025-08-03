# Hakkımızda Bilgilerini Düzenleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Hakkımızda Bilgilerini Düzenleme** sayfasının işleyişini açıklar. Yönetici, vizyon, misyon, biyografi ve görselleri güncelleyebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3**
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Form işleme ve dosya yükleme işlemleri için)
- **TinyMCE** (Zengin metin editörü entegrasyonu)

---

## Sayfa Yapısı

### **1. Başlık ve Geri Dön Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Hakkımızda Bilgilerini Düzenle</h1>
    <a href="/admin/settings" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Hakkımızda Bilgilerini Düzenle" başlığı gösterilir.
- **Geri Dön Butonu:** Kullanıcıyı `/admin/settings` sayfasına yönlendirir.

---

### **2. Hata Mesajı Gösterimi**
```php
<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
```
- **Hata mesajı (`$error`)** → Güncelleme sırasında bir hata oluştuğunda görüntülenir.

---

### **3. Hakkımızda Güncelleme Formu**
```html
<form action="/admin/about/update" method="POST" enctype="multipart/form-data">
```
- **`action="/admin/about/update"`** → Form, `update()` metoduna yönlendirilir.
- **`method="POST"`** → Form verisi `POST` yöntemiyle gönderilir.
- **`enctype="multipart/form-data"`** → Dosya yükleme işlemi için gerekli.

---

### **4. Form Alanları**
#### **Mevcut Resimlerin Saklanması**
```html
<input type="hidden" name="current_image1" value="<?= htmlspecialchars($about['image1']) ?>">
<input type="hidden" name="current_image2" value="<?= htmlspecialchars($about['image2']) ?>">
```
- **Mevcut görsellerin kaybolmaması için gizli alanlar kullanılır.**

#### **Vizyon**
```html
<div class="mb-3">
    <label for="vision" class="form-label">Vizyon</label>
    <textarea id="vision" name="vision" class="form-control" required><?= htmlspecialchars($about['vision']) ?></textarea>
</div>
```
- **Şirketin vizyon metni güncellenebilir.**

#### **Misyon**
```html
<div class="mb-3">
    <label for="mission" class="form-label">Misyon</label>
    <textarea id="mission" name="mission" class="form-control" required><?= htmlspecialchars($about['mission']) ?></textarea>
</div>
```
- **Şirketin misyon metni güncellenebilir.**

#### **Biyografi**
```html
<div class="mb-3">
    <label for="biography" class="form-label">Biyografi</label>
    <textarea id="biography" name="biography" class="form-control tinymce" required><?= htmlspecialchars($about['biography']) ?></textarea>
</div>
```
- **TinyMCE editörü kullanılarak zengin metin içeriği düzenlenebilir.**

#### **Resim 1**
```html
<div class="mb-3">
    <label for="image1" class="form-label">Resim 1</label>
    <input type="file" id="image1" name="image1" class="form-control">
    <img src="<?= htmlspecialchars($about['image1']) ?>" alt="About Image 1" class="img-fluid mt-2" style="max-width: 200px;">
</div>
```
- **Mevcut görsel gösterilir.**
- **Yeni görsel yüklenirse eski görsel güncellenir.**

#### **Resim 2**
```html
<div class="mb-3">
    <label for="image2" class="form-label">Resim 2</label>
    <input type="file" id="image2" name="image2" class="form-control">
    <img src="<?= htmlspecialchars($about['image2']) ?>" alt="About Image 2" class="img-fluid mt-2" style="max-width: 200px;">
</div>
```
- **İkinci görsel için aynı işlemler geçerlidir.**

---

### **5. Form Güncelleme Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Güncelle</button>
</div>
```
- **Kullanıcı, formu tamamladıktan sonra "Güncelle" butonuna tıklayarak bilgileri kaydedebilir.**

---

### **6. TinyMCE Entegrasyonu**
```html
<script>
    tinymce.init({
        selector: 'textarea.tinymce',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });
</script>
```
- **TinyMCE metin editörü etkinleştirilerek gelişmiş metin düzenleme sağlanır.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Hakkımızda Bilgilerini Düzenle</h1>
        <a href="/admin/settings" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/about/update" method="POST" enctype="multipart/form-data">
                <!-- Mevcut resimleri gizli alanlar olarak ekleyin -->
                <input type="hidden" name="current_image1" value="<?= htmlspecialchars($about['image1']) ?>">
                <input type="hidden" name="current_image2" value="<?= htmlspecialchars($about['image2']) ?>">
                <div class="mb-3">
                    <label for="vision" class="form-label">Vizyon</label>
                    <textarea id="vision" name="vision" class="form-control" required><?= htmlspecialchars($about['vision']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="mission" class="form-label">Misyon</label>
                    <textarea id="mission" name="mission" class="form-control" required><?= htmlspecialchars($about['mission']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="biography" class="form-label">Biyografi</label>
                    <textarea id="biography" name="biography" class="form-control tinymce" required><?= htmlspecialchars($about['biography']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="image1" class="form-label">Resim 1</label>
                    <input type="file" id="image1" name="image1" class="form-control">
                    <img src="<?= htmlspecialchars($about['image1']) ?>" alt="About Image 1" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="mb-3">
                    <label for="image2" class="form-label">Resim 2</label>
                    <input type="file" id="image2" name="image2" class="form-control">
                    <img src="<?= htmlspecialchars($about['image2']) ?>" alt="About Image 2" class="img-fluid mt-2" style="max-width: 200px;">
                </div>
                <div class="d-flex justify-content-end mt-4">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </main>
    </div>
</div>
<script>
    tinymce.init({
        selector: 'textarea.tinymce',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
    });
</script>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Hakkımızda Bilgilerini Düzenleme** sayfasının işleyişini açıklar. Yönetici, vizyon, misyon, biyografi ve görselleri güncelleyebilir. **TinyMCE entegrasyonu ile gelişmiş metin düzenleme desteği sunulmuştur.** Geliştirme olarak **çoklu dil desteği** veya **önizleme** gibi özellikler eklenebilir.
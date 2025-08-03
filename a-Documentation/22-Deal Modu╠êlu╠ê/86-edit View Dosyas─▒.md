# Kampanya Düzenleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Kampanya Düzenleme** sayfasının işleyişini açıklar. Yönetici, mevcut bir kampanyayı düzenleyebilir ve güncelleyebilir.

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
    <h1 class="h2 py-0 px-3">Kampanya Düzenle</h1>
    <a href="/admin/deal" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** "Kampanya Düzenle" olarak belirlenmiştir.
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
- **Başarı Mesajı (`$success`)** → Kampanya başarıyla güncellendiğinde görüntülenir.
- **Hata Mesajı (`$error`)** → Güncelleme sırasında bir hata meydana gelirse görüntülenir.

---

### **3. Kampanya Düzenleme Formu**
```html
<form action="/admin/deal/update/<?= htmlspecialchars($deal['id']) ?>" method="POST">
```
- **`action="/admin/deal/update/{id}"`** → Güncellenen kampanya ID’si ile ilgili rotaya yönlendirilir.
- **`method="post"`** → Form verisi **POST** yöntemiyle gönderilir.

#### **Başlık Alanı**
```html
<div class="mb-3">
    <label for="title" class="form-label">Başlık</label>
    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($deal['title']) ?>" required>
</div>
```
- **Kampanya başlığı düzenlenebilir.**
- **Zorunlu bir alandır (`required`).**

#### **İçerik Alanı**
```html
<div class="mb-3">
    <label for="content" class="form-label">İçerik</label>
    <textarea id="content" name="content" class="form-control" required><?= htmlspecialchars($deal['content']) ?></textarea>
</div>
```
- **Kullanıcı, kampanya açıklamasını güncelleyebilir.**
- **Zorunlu bir alandır (`required`).**

#### **Başlangıç ve Bitiş Tarihleri**
```html
<div class="mb-3">
    <label for="start_date" class="form-label">Başlangıç Tarihi</label>
    <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="<?= htmlspecialchars($deal['start_date']) ?>" required>
</div>
<div class="mb-3">
    <label for="end_date" class="form-label">Bitiş Tarihi</label>
    <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="<?= htmlspecialchars($deal['end_date']) ?>" required>
</div>
```
- **Kullanıcı, kampanyanın geçerli olduğu tarihleri değiştirebilir.**
- **Zorunlu alanlardır (`required`).**

#### **Durum Seçimi (Aktif/Pasif)**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select id="status" name="status" class="form-control" required>
        <option value="1" <?= $deal['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
        <option value="0" <?= $deal['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
    </select>
</div>
```
- **Kampanya, "Aktif" veya "Pasif" olarak değiştirilebilir.**
- **Zorunlu bir alandır (`required`).**

---

### **4. Güncelle Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Güncelle</button>
</div>
```
- **Kullanıcı, "Güncelle" butonuna tıklayarak değişiklikleri kaydedebilir.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Kampanya Düzenle</h1>
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
            <form action="/admin/deal/update/<?= htmlspecialchars($deal['id']) ?>" method="POST">
                <div class="mb-3">
                    <label for="title" class="form-label">Başlık</label>
                    <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($deal['title']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">İçerik</label>
                    <textarea id="content" name="content" class="form-control" required><?= htmlspecialchars($deal['content']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="start_date" class="form-label">Başlangıç Tarihi</label>
                    <input type="datetime-local" id="start_date" name="start_date" class="form-control" value="<?= htmlspecialchars($deal['start_date']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="end_date" class="form-label">Bitiş Tarihi</label>
                    <input type="datetime-local" id="end_date" name="end_date" class="form-control" value="<?= htmlspecialchars($deal['end_date']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="1" <?= $deal['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $deal['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
                    </select>
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

Bu dokümantasyon, **Admin Paneli - Kampanya Düzenleme** sayfasının işleyişini açıklar. Yönetici, kampanyanın başlığını, içeriğini, başlangıç ve bitiş tarihlerini değiştirebilir ve kampanyayı **aktif veya pasif hale getirebilir.**

Geliştirme olarak:
- **Görsel ekleme/düzenleme özelliği eklenebilir.**
- **Özel kampanya indirimleri belirleme özelliği entegre edilebilir.**


# Yeni Kategori Ekleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Yeni Kategori Ekle** sayfasının işleyişini açıklar. Yönetici, yeni bir kategori ekleyebilir.

---

## Kullanılan Teknolojiler
- **PHP** (Sunucu tarafı iş mantığı için)
- **HTML5 & CSS3** (Form elemanları ve yapı için)
- **Bootstrap 5** (Responsive tasarım için)

---

## **Yeni Kategori Ekleme Formu**

### **1. Başlık ve Geri Dön Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Yeni Kategori Ekle</h1>
    <a href="/admin/categories" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** "Yeni Kategori Ekle" olarak belirlenmiştir.
- **Geri Dön Butonu:** Kullanıcıyı kategori listesi sayfasına yönlendirir.

---

### **2. Form Alanları**
```html
<form action="/admin/categories/store" method="POST">
```
- **Form, kategori ekleme için POST isteği gönderir.**

#### **Kategori İsmi Girişi**
```html
<div class="mb-3">
    <label for="name" class="form-label">İsim</label>
    <input type="text" id="name" name="name" class="form-control" required>
</div>
```
- **Kategori ismi için giriş alanı.**

#### **Kategori İkonu Girişi**
```html
<div class="mb-3">
    <label for="icon" class="form-label">İkon</label>
    <input type="text" id="icon" name="icon" class="form-control" required>
</div>
```
- **Kategoriye özel bir ikon belirlenebilir.**

#### **Kategori Açıklaması**
```html
<div class="mb-3">
    <label for="description" class="form-label">Açıklama</label>
    <textarea id="description" name="description" class="form-control" required></textarea>
</div>
```
- **Kategori için açıklama girilmesini sağlar.**

#### **Durum Seçimi**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select id="status" name="status" class="form-control" required>
        <option value="1">Aktif</option>
        <option value="0">Pasif</option>
    </select>
</div>
```
- **Kategori aktif veya pasif olarak belirlenebilir.**

---

### **3. Kaydet Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Kaydet</button>
</div>
```
- **Form verileri POST olarak gönderilir.**
- **Başarı mesajı veya hata mesajı görüntülenir.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Yeni Kategori Ekle</h1>
        <a href="/admin/categories" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8" style="max-width: 800px;">

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/categories/store" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">İsim</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">İkon</label>
                    <input type="text" id="icon" name="icon" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea id="description" name="description" class="form-control" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
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

Bu dokümantasyon, **Admin Paneli - Yeni Kategori Ekle** sayfasının işleyişini açıklar. Yönetici, kategori ismi, ikonu, açıklaması ve durumunu belirleyerek yeni bir kategori ekleyebilir.

Geliştirme olarak:
- **Kategoriye resim ekleme desteği getirilebilir.**
- **Alt kategori ekleme seçeneği dahil edilebilir.**


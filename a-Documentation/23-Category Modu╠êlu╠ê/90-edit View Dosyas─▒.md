# Kategori Düzenleme Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Kategori Düzenleme** sayfasının işleyişini açıklar. Yönetici, mevcut bir kategoriyi güncelleyebilir.

---

## Kullanılan Teknolojiler
- **PHP** (Sunucu tarafı iş mantığı için)
- **HTML5 & CSS3** (Form elemanları ve yapı için)
- **Bootstrap 5** (Responsive tasarım için)

---

## **Kategori Düzenleme Formu**

### **1. Başlık ve Geri Dön Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Kategori Düzenle</h1>
    <a href="/admin/categories" class="btn btn-outline-secondary">Geri Dön</a>
</div>
```
- **Başlık:** "Kategori Düzenle" olarak belirlenmiştir.
- **Geri Dön Butonu:** Kullanıcıyı kategori listesi sayfasına yönlendirir.

---

### **2. Form Alanları**
```html
<form action="/admin/categories/update/<?= htmlspecialchars($category['id']) ?>" method="POST">
```
- **Form, kategori güncelleme için POST isteği gönderir.**

#### **Kategori İsmi Güncelleme**
```html
<div class="mb-3">
    <label for="name" class="form-label">İsim</label>
    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
</div>
```
- **Kategori ismi düzenlenebilir.**

#### **Kategori İkonu Güncelleme**
```html
<div class="mb-3">
    <label for="icon" class="form-label">İkon</label>
    <input type="text" id="icon" name="icon" class="form-control" value="<?= htmlspecialchars($category['icon']) ?>" required>
</div>
```
- **Kategoriye özel bir ikon değiştirilebilir.**

#### **Kategori Açıklamasını Güncelleme**
```html
<div class="mb-3">
    <label for="description" class="form-label">Açıklama</label>
    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($category['description']) ?></textarea>
</div>
```
- **Kategori açıklaması düzenlenebilir.**

#### **Durum Güncelleme**
```html
<div class="mb-3">
    <label for="status" class="form-label">Durum</label>
    <select id="status" name="status" class="form-control" required>
        <option value="1" <?= $category['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
        <option value="0" <?= $category['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
    </select>
</div>
```
- **Kategori aktif veya pasif olarak değiştirilebilir.**

---

### **3. Güncelle Butonu**
```html
<div class="d-flex justify-content-end mt-4">
    <button type="submit" class="btn btn-secondary">Güncelle</button>
</div>
```
- **Form verileri POST olarak gönderilir.**
- **Başarı mesajı veya hata mesajı görüntülenir.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Kategori Düzenle</h1>
        <a href="/admin/categories" class="btn btn-outline-secondary">Geri Dön</a>
    </div>
    <div class="row justify-content-center">
        <main class="col-md-8 mb-4" style="max-width: 800px;">

            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php endif; ?>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/categories/update/<?= htmlspecialchars($category['id']) ?>" method="POST">
                <div class="mb-3">
                    <label for="name" class="form-label">İsim</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= htmlspecialchars($category['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="icon" class="form-label">İkon</label>
                    <input type="text" id="icon" name="icon" class="form-control" value="<?= htmlspecialchars($category['icon']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Açıklama</label>
                    <textarea id="description" name="description" class="form-control" required><?= htmlspecialchars($category['description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Durum</label>
                    <select id="status" name="status" class="form-control" required>
                        <option value="1" <?= $category['status'] == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= $category['status'] == 0 ? 'selected' : '' ?>>Pasif</option>
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

Bu dokümantasyon, **Admin Paneli - Kategori Düzenleme** sayfasının işleyişini açıklar. Yönetici, kategori ismi, ikonu, açıklaması ve durumunu güncelleyebilir.

Geliştirme olarak:
- **Kategoriye resim ekleme desteği getirilebilir.**
- **Alt kategori ekleme seçeneği dahil edilebilir.**


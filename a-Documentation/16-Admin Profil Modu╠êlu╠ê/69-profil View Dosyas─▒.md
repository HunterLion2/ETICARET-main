# Profil Güncelleme Sayfası Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Profil Güncelleme** sayfasının yapısını ve işlevlerini açıklar. Kullanıcılar mevcut şifrelerini değiştirerek yeni bir şifre belirleyebilirler.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3**
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Sunucu taraflı veri işleme)

---

## Sayfa Yapısı

### **1. Genel Yerleşim**
```html
<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Profil Güncelleme</h1>
            </div>
        </main>
    </div>
</div>
```

- `container` genel kapsayıcıyı oluşturur.
- `row` içinde **Profil Güncelleme** başlığı bulunur.

---

### **2. Başarı ve Hata Mesajları**
```php
<?php if (isset($success)): ?>
    <div class="alert alert-success" role="alert">
        <?php echo $success; ?>
    </div>
<?php endif; ?>
<?php if (isset($error)): ?>
    <div class="alert alert-danger" role="alert">
        <?php echo $error; ?>
    </div>
<?php endif; ?>
```
- **Başarı Mesajı (`$success`)** → Kullanıcı başarılı şekilde şifresini güncellediğinde görüntülenir.
- **Hata Mesajı (`$error`)** → Kullanıcı hatalı giriş yaptığında veya eşleşmeyen şifreler girildiğinde görüntülenir.

---

### **3. Şifre Güncelleme Formu**
```html
<form action="/admin/profile/updatePassword" method="POST">
    <div class="form-group mb-3">
        <label for="current_password">Mevcut Şifre</label>
        <input type="password" class="form-control" id="current_password" name="current_password" required>
    </div>
    <div class="form-group mb-3">
        <label for="new_password">Yeni Şifre</label>
        <input type="password" class="form-control" id="new_password" name="new_password" required>
    </div>
    <div class="form-group mb-3">
        <label for="confirm_password">Yeni Şifre (Tekrar)</label>
        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
    </div>
    <div class="d-flex justify-content-end mt-3">
        <button type="submit" class="btn btn-secondary">Şifre Güncelle</button>
    </div>
</form>
```

#### **Form Alanları:**
- **Mevcut Şifre (`current_password`)** → Kullanıcıdan mevcut şifresini doğrulaması istenir.
- **Yeni Şifre (`new_password`)** → Kullanıcıdan yeni bir şifre belirlemesi istenir.
- **Yeni Şifre (Tekrar) (`confirm_password`)** → Yeni şifre tekrar girilerek doğrulama yapılır.

#### **Form İşleyişi:**
- Form **POST** yöntemiyle `/admin/profile/updatePassword` adresine gönderilir.
- Gerekli alanlar `required` ile zorunlu hale getirilmiştir.
- Bootstrap `form-control` sınıfı kullanılarak şık bir görünüm kazandırılmıştır.

---
## 📌 **Tam Kod*

```html
<div class="container">

    <!-- Admin panel içeriği buraya gelecek -->
    <div class="row">
        <main class="col-md-12 ">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Profil Güncelleme</h1>
            </div>
            <div class="form-container mx-auto" style="max-width: 500px;">
                <?php if (isset($success)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                <form action="/admin/profile/updatePassword" method="POST">
                    <div class="form-group mb-3">
                        <label for="current_password">Mevcut Şifre</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="new_password">Yeni Şifre</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="confirm_password">Yeni Şifre (Tekrar)</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="submit" class="btn btn-secondary">Şifre Güncelle</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Profil Güncelleme** sayfasının temel yapısını açıklar. Kullanıcılar mevcut şifrelerini güncelleyerek daha güvenli bir giriş deneyimi yaşayabilirler. Eğer sistemin güvenliği artırılmak istenirse, ek doğrulama mekanizmaları (örneğin iki faktörlü kimlik doğrulama) eklenebilir.


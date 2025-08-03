# İletişim Formu Sayfası

Bu döküman, **E-Ticaret V5** uygulamasında yer alan **Bize Ulaşın** sayfasının nasıl çalıştığını açıklamaktadır.

## 📌 İletişim Sayfasının Amacı
İletişim formu, kullanıcıların site yöneticileriyle kolayca bağlantıya geçmesini sağlar. Kullanıcılar, **isim**, **e-posta** ve **mesaj** bilgilerini girerek yöneticilere mesaj gönderebilir.

---
## 🛠️ İletişim Formu Kodu
Aşağıdaki kod, iletişim sayfasının HTML ve PHP bileşenlerinden oluşmaktadır:

```html
<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Bize Ulaşın</h1>
        <i class="fas fa-envelope fa-2x"></i>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>İletişim Formu</h3>
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
            <form action="contact/submit-contact" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Adınız</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mesajınız</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Gönder</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>İletişim Bilgileri</h3>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo $settings['contact_address']; ?></p>
            <p><i class="fas fa-phone"></i> Telefon: <?php echo $settings['contact_phone']; ?></p>
            <p><i class="fas fa-envelope"></i> E-posta: <?php echo $settings['contact_email']; ?></p>
            <h3>Harita</h3>
            <iframe src="https://www.google.com/maps/embed?..." width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
</div>
```

---
## 🎯 Açıklamalar

### 1️⃣ **Form Alanları**
- **Ad**: Kullanıcının adını girmesi için bir giriş alanı.
- **E-posta**: Kullanıcının geçerli bir e-posta adresi girmesi gerekir.
- **Mesaj**: Kullanıcının iletmek istediği mesajı yazdığı alan.
- **Gönder Butonu**: Formun sunucuya gönderilmesini sağlar.

### 2️⃣ **Geri Bildirim Mesajları**
Form başarıyla gönderildiğinde veya hata oluştuğunda, **success** ve **error** değişkenleri aracılığıyla kullanıcıya geri bildirim verilir.

### 3️⃣ **İletişim Bilgileri ve Harita**
Sayfanın sağ tarafında, firma iletişim bilgileri ve Google Haritalar üzerinden konumu bulunmaktadır.

---
## 🔗 Formun Çalışma Mekanizması
1. Kullanıcı **Ad, E-posta ve Mesaj** bilgilerini girer.
2. **Gönder** butonuna bastığında, veriler `/contact/submit-contact` adresine **POST** metodu ile iletilir.
3. Eğer form doğru doldurulmuşsa, mesaj başarıyla gönderilir ve kullanıcıya bildirim verilir.
4. Hatalı giriş yapılırsa, hata mesajları kullanıcıya gösterilir.

---
## 📌 **Tam Kod*

```html
<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Bize Ulaşın</h1>
        <i class="fas fa-envelope fa-2x"></i>
    </div>
    <div class="row">
        <div class="col-md-6">
            <h3>İletişim Formu</h3>
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
            <form action="contact/submit-contact" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Adınız</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">E-posta</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Mesajınız</label>
                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Gönder</button>
            </form>
        </div>
        <div class="col-md-6">
            <h3>İletişim Bilgileri</h3>
            <p><i class="fas fa-map-marker-alt"></i> <?php echo $settings['contact_address']; ?></p>
            <p><i class="fas fa-phone"></i> Telefon: <?php echo $settings['contact_phone']; ?></p>
            <p><i class="fas fa-envelope"></i> E-posta: <?php echo $settings['contact_email']; ?></p>
            <h3>Harita</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3023.953367115474!2d28.9783583153167!3d41.01513727975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x14caba6f7d8b1f81%3A0x8f577d1f9c8f0b1e!2sÖrnek%20Mah.%20Örnek%20Sok.%20No%3A1%2C%20İstanbul!5e0!3m2!1str!2str!4v1611810192000!5m2!1str!2str" width="100%" height="300" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
</div>
```
---

## 🎯 Sonuç
Bu iletişim formu sayesinde kullanıcılar, kolay bir şekilde yöneticilere ulaşabilir. Formun sunucu tarafında doğru çalıştığını ve e-posta fonksiyonlarının aktif olduğunu test ettiğinizden emin olun.

🔹 **Geliştirme Önerisi:** Güvenlik için **CSRF Token** ve **Google reCAPTCHA** ekleyerek spam korumasını artırabilirsiniz.

🚀 **Başarılar dileriz!**


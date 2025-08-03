# **HTML Layouts Yapısının Hazırlanması (Header ve Footer)**
 
Bu eğitim dokümanında, **HTML dosyanızın nasıl yapılandırılacağını** ve **Bootstrap ile dinamik içerik oluşturmanın temel prensiplerini** öğreneceksiniz. Ayrıca, **PHP değişkenleri kullanarak kullanıcı ve içerik yönetiminin nasıl yapıldığını** adım adım inceleyeceğiz.

---

## **1. Header Dosyasının Hazırlanması**

```html
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $settings['site_title']; ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>
```

### **Ne İşe Yarar?**
✅ `meta charset="UTF-8"` → Türkçe karakter desteği sağlar.
✅ `meta name="viewport"` → Mobil uyumluluk için sayfanın ölçeklenmesini yönetir.
✅ `title` etiketi, PHP değişkeni kullanılarak **dinamik başlık** oluşturur.
✅ **CSS dosyaları** projeye entegre edilir:
   - `bootstrap.min.css`: **Bootstrap kütüphanesi**
   - `font-awesome`: **İkon seti**
   - `styles.css`: **Özel stiller**

---

## **2. Yükleme Ekranı (Loading Screen) ve Yönetici Paneli Bağlantısı**

```html
<body>
    <div class="bg-secondary text-white text-center py-2">
        <a href="/admin" class="text-white" style="font-size: 0.8em; font-weight: bold;">Yönetim Paneli için Tıklayın</a>
    </div>
    <div class="text-center" id="loading">
        <p><b>Edukey ETicaretV5 Eğitim Sürümü</b><br>Yükleniyor Lütfen Bekleyin...</p>
    </div>
```

### **Ne İşe Yarar?**
✅ `Yönetim Paneli` butonu, **admin sayfasına** yönlendirme yapar.
✅ `loading` bölümü, **sayfa yüklenirken** kullanıcıya bilgilendirme sunar.

---

## **3. Navigasyon (Menü) Yapısı**

```html
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="/">
            ETicaret<span style="font-weight:bold;">V5</span><br>
            <small style="font-size: 0.5em;">Edukey tarafından eğitim amaçlı üretilmiştir.</small>
        </a>
```

### **Ne İşe Yarar?**
✅ **Marka Alanı:** Anasayfaya yönlendirme yapar.
✅ **Mobil Uyumluluk:** `navbar-toggler` kullanılarak mobil cihazlarda menünün gizlenmesi sağlanır.

---

## **4. Dinamik Kategoriler ve Sayfalar**

```html
<ul class="navbar-nav me-auto">
    <li class="nav-item">
        <a class="nav-link active" href="/"><i class="fas fa-home"></i> Anasayfa</a>
    </li>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" data-bs-toggle="dropdown">
            <i class="fas fa-th-list"></i> Kategoriler
        </a>
        <ul class="dropdown-menu">
            <?php foreach ($categories as $category): ?>
                <li>
                    <a class="dropdown-item" href="/category/<?php echo htmlspecialchars($category['slug']); ?>">
                        <i class="<?php echo htmlspecialchars($category['icon']); ?>"></i>
                        <?php echo htmlspecialchars($category['name']); ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </li>
</ul>
```

### **Ne İşe Yarar?**
✅ PHP döngüsü (`foreach`) ile **dinamik kategori listesi oluşturulur**.
✅ `htmlspecialchars()` kullanılarak **XSS güvenliği sağlanır**.

---

## **5. Kullanıcı ve Sepet Yönetimi**

```html
<ul class="navbar-nav">
    <li class="nav-item">
        <?php if (isset($session['user_id'])): ?>
            <?php if ($cartItemCount > 0): ?>
                <a class="nav-link" href="/cart"><i class="fas fa-shopping-cart"></i> Sepetim (<?php echo $cartItemCount; ?>)</a>
            <?php else: ?>
                <a class="nav-link" href="/cart"><i class="fas fa-shopping-cart"></i> Sepet Boş</a>
            <?php endif; ?>
        <?php else: ?>
            <a class="nav-link" href="/cart"><i class="fas fa-shopping-cart"></i> Sepet Boş</a>
        <?php endif; ?>
    </li>
</ul>
```

### **Ne İşe Yarar?**
✅ Kullanıcının **sepetinde ürün olup olmadığı kontrol edilir**.
✅ Eğer **kullanıcı giriş yapmışsa**, sepet durumu görüntülenir.
✅ Kullanıcı giriş yapmamışsa, **boş sepet mesajı gösterilir**.

---

## **6. Kullanıcı Profili ve Oturum Açma İşlemi**

```html
<?php if (isset($session['user_id'])): ?>
    <?php $firstName = explode(' ', $session['user_name'])[0]; ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown">
            <i class="fas fa-user"></i> <?php echo htmlspecialchars($firstName); ?>
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/customer"><i class="fas fa-user"></i> Profil</a></li>
            <li><a class="dropdown-item" href="/order"><i class="fas fa-receipt"></i> Siparişlerim</a></li>
            <li><a class="dropdown-item" href="/logout"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
        </ul>
    </li>
<?php else: ?>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="loginDropdown" data-bs-toggle="dropdown">
            <i class="fas fa-user"></i> Giriş Yap
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/login"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a></li>
            <li><a class="dropdown-item" href="/register"><i class="fas fa-user-plus"></i> Üye Ol</a></li>
        </ul>
    </li>
<?php endif; ?>
```

## 📌 **Tam Kod (header.php)**
```html
<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $settings['site_title']; ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="bg-secondary text-white text-center py-2">
        <a href="/admin" class="text-white" style="font-size: 0.8em; font-weight: bold;">Yönetim Paneli için Tıklayın</a>
    </div>
    <div class="text-center" id="loading">
        <p><b>Edukey ETicaretV5 Eğitim Sürümü</b><br>Yükleniyor Lütfen Bekleyin...</p>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand" href="/" style="line-height: 0.7; margin-top: 10px;">
                ETicaret<span style="font-weight:bold;">V5</span><br>
                <small style="font-size: 0.5em;">Edukey tarafından eğitim amaçlı üretilmiştir.</small>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-decoration-none" aria-current="page" href="/"><i class="fas fa-home"></i> Anasayfa</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-th-list"></i> Kategoriler
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a class="dropdown-item text-decoration-none" href="/category/<?php echo htmlspecialchars($category['slug']); ?>">
                                        <i class="<?php echo htmlspecialchars($category['icon']); ?>"></i>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none" href="/abouts"><i class="fas fa-building"></i> Kurumsal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none" href="/blog"><i class="fas fa-blog"></i> Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none" href="/contact"><i class="fas fa-envelope"></i> İletişim</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (isset($session['user_id'])): ?>
                            <?php if ($cartItemCount > 0): ?>
                                <a class="nav-link text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepetim (<?php echo $cartItemCount; ?>)</a>
                            <?php else: ?>
                                <a class="nav-link text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepet Boş</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a class="nav-link text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepet Boş</a>
                        <?php endif; ?>
                    </li>
                    <?php if (isset($session['user_id'])): ?>
                        <?php
                        $nameParts = explode(' ', $session['user_name']);
                        $firstName = $nameParts[0];
                        $lastNameInitial = isset($nameParts[1]) ? $nameParts[1][0] . '.' : '';
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($firstName) . ' ' . htmlspecialchars($lastNameInitial); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item text-decoration-none" href="/customer"><i class="fas fa-user"></i> Profil</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/order"><i class="fas fa-receipt"></i> Siparişlerim</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepetim</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/logout"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> Giriş Yap
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                                <li><a class="dropdown-item text-decoration-none" href="/login"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/register"><i class="fas fa-user-plus"></i> Üye Ol</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepetim</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header Finish -->
```

### **Ne İşe Yarar?**
✅ Kullanıcı giriş yapmışsa **adını ve menü seçeneklerini** gösterir.
✅ Giriş yapmamış kullanıcılar için **"Giriş Yap" ve "Üye Ol" seçenekleri** sunulur.

---
## **2. Footer Dosyasının Hazırlanması**

Bu eğitim dokümanında, **footer (alt bilgi) bileşeninin nasıl oluşturulacağını**, **dinamik içeriklerin nasıl ekleneceğini** ve **iletişim bilgileri gibi statik verilerin nasıl yönetileceğini** öğreneceksiniz.

---

## **1. Footer Genel Yapısı**

```html
<footer class="bg-dark text-white py-5" style="position: relative;">
    <div class="container" style="margin-top: auto;">
        <div class="row">
            <div class="col-md-3">
                <h5>Eticaretv5</h5>
                <p>En iyi ürünleri en uygun fiyatlarla sunan online alışveriş platformu.</p>
            </div>
```

### **Ne İşe Yarar?**
✅ `bg-dark text-white` → Arka planı koyu, metni beyaz yapar.
✅ `py-5` → İçeriğin üst ve altına 5 birim padding ekler.
✅ `container` → İçeriği sayfa ortasına hizalar.
✅ `row` ve `col-md-3` → **Dört sütunlu** bir düzen oluşturur.

---

## **2. Dinamik Kategori Listesi**

```html
<div class="col-md-3">
    <h5>Kategoriler</h5>
    <ul class="list-unstyled">
        <?php foreach ($categories as $category): ?>
            <li>
                <a href="/category/<?php echo htmlspecialchars($category['slug']); ?>" class="text-white text-decoration-none">
                    <?php echo htmlspecialchars($category['name']); ?>
                </a>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
```

### **Ne İşe Yarar?**
✅ PHP döngüsü ile **dinamik kategori listesi** oluşturur.
✅ `htmlspecialchars()` ile **XSS saldırılarına karşı koruma sağlar**.
✅ `list-unstyled` ile **madde işaretlerini kaldırır**.

---

## **3. Kurumsal Bilgiler Bölümü**

```html
<div class="col-md-3">
    <h5>Kurumsal</h5>
    <ul class="list-unstyled">
        <li><a href="/abouts" class="text-white text-decoration-none">Hakkımızda</a></li>
        <li><a href="/blog" class="text-white text-decoration-none">Blog</a></li>
        <li><a href="/page/gizlilik-politikasi" class="text-white text-decoration-none">Gizlilik Politikası</a></li>
        <li><a href="/page/mesafeli-satis-sozlemesi" class="text-white text-decoration-none">Mesafeli Satış Sözleşmesi</a></li>
        <li><a href="/page/teslimat-ve-iade-sartlari" class="text-white text-decoration-none">Teslimat ve İade Şartları</a></li>
        <li><a href="/page/kvkk-ve-aydinlatma-metni" class="text-white text-decoration-none">KVKK ve Aydınlatma Metni</a></li>
    </ul>
</div>
```

### **Ne İşe Yarar?**
✅ Kullanıcıların **şirket bilgilerine ve yasal dokümanlara erişimini sağlar**.
✅ `text-white text-decoration-none` ile **metinleri beyaz renkte gösterir ve alt çizgiyi kaldırır**.

---

## **4. İletişim Bilgileri Bölümü**

```html
<div class="col-md-3">
    <h5>İletişim</h5>
    <p><i class="fas fa-map-marker-alt"></i> <?php echo $settings['contact_address']; ?></p>
    <p><i class="fas fa-phone"></i> Telefon: <?php echo $settings['contact_phone']; ?></p>
    <p><i class="fas fa-envelope"></i> Email: <?php echo $settings['contact_email']; ?></p>
</div>
```

### **Ne İşe Yarar?**
✅ PHP değişkenleri kullanılarak **dinamik iletişim bilgileri görüntülenir**.
✅ `fas fa-map-marker-alt` gibi **Font Awesome ikonları** ile kullanıcı deneyimi artırılır.

---

## **5. Telif Hakkı Alanı**

```html
<div class="text-center mt-4">
    <p>&copy; 2025 EticaretV5. EDUKEY tarafından Eğitim Amaçlı Yazılmıştır. Tüm hakları saklıdır.</p>
</div>
```

### **Ne İşe Yarar?**
✅ `&copy; 2025` → **Telif hakkı simgesi ve yıl bilgisi ekler**.
✅ `text-center mt-4` → **Metni ortalar ve üstüne boşluk bırakır**.

---

## **6. Footer İçerisinde JavaScript Dosyalarının Dahil Edilmesi**

```html
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/scripts.js"></script>
```

### **Ne İşe Yarar?**
✅ `bootstrap.bundle.min.js` → **Bootstrap bileşenlerini aktif hale getirir**.
✅ `scripts.js` → **Özel JavaScript dosyanızı yükler**.
✅ **Footer içinde olması**, sayfa yüklenme hızını artırır.

---

Bu dokümanda **footer bileşeninin nasıl oluşturulacağını ve yönetileceğini** öğrendiniz. Şimdi öğrendiklerinizi projelerinizde uygulayabilirsiniz! 🚀


## 📌 **Tam Kod (footer.php)**
```html
<footer class="bg-dark text-white py-5" style="position: relative;">
    <div class="container" style="margin-top: auto;">
        <div class="row">
            <div class="col-md-3">
                <h5>Eticaretv5</h5>
                <p>En iyi ürünleri en uygun fiyatlarla sunan online alışveriş platformu.</p>
            </div>
            <div class="col-md-3">
                <h5>Kategoriler</h5>
                <ul class="list-unstyled">
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="/category/<?php echo htmlspecialchars($category['slug']); ?>" class="text-white text-decoration-none">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Kurumsal</h5>
                <ul class="list-unstyled">
                    <li><a href="/abouts" class="text-white text-decoration-none">Hakkımızda</a></li>
                    <li><a href="/blog" class="text-white text-decoration-none">Blog</a></li>
                    <li><a href="/page/gizlilik-politikasi" class="text-white text-decoration-none">Gizlilik Politikası</a></li>
                    <li><a href="/page/mesafeli-satis-sozlemesi" class="text-white text-decoration-none">Mesafeli Satış Sözleşmesi</a></li>
                    <li><a href="/page/teslimat-ve-iade-sartlari" class="text-white text-decoration-none">Teslimat ve İade Şartları</a></li>
                    <li><a href="/page/kvkk-ve-aydinlatma-metni" class="text-white text-decoration-none">KVKK ve Aydınlatma Metni</a></li>



                </ul>
            </div>
            <div class="col-md-3">
                <h5>İletişim</h5>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $settings['contact_address']; ?></p>
                <p><i class="fas fa-phone"></i> Telefon: <?php echo $settings['contact_phone']; ?></p>
                <p><i class="fas fa-envelope"></i> Email: <?php echo $settings['contact_email']; ?>/p>
            </div>
        </div>
        <div class="text-center mt-4">
            <p>&copy; 2025 EticaretV5. EDUKEY tarafından Eğitim Amaçlı Yazılmıştır Tüm hakları saklıdır.</p>
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</footer>
```

---

Bu dokümanda **HTML yapınızı nasıl oluşturacağınızı ve dinamik içerikleri nasıl yöneteceğinizi** öğrendiniz. Şimdi, öğrendiklerinizi projelerinize uygulayabilirsiniz! 🚀

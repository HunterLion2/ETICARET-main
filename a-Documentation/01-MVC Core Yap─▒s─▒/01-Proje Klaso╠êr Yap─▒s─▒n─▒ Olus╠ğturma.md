# PHP E-Ticaret Projesi

Bu proje, **MVC (Model-View-Controller) mimarisi** kullanılarak geliştirilmiş, PHP tabanlı bir **e-ticaret platformudur**. Kullanıcıların ürünleri keşfetmesine, sepetlerine eklemesine, sipariş oluşturmasına ve ödeme yapmasına olanak tanıyan **dinamik ve modüler bir sistemdir**. Aynı zamanda, yöneticilerin sistem üzerindeki tüm işlemleri kontrol edebileceği **gelişmiş bir yönetim paneli** sunmaktadır.

## Ana Özellikler

Proje, **modern e-ticaret çözümleri** sunan çeşitli **modüllerden** oluşmaktadır:

### **1. Hakkımızda Modülü (About)**
- Firma hakkında detaylı bilgilerin yönetilebileceği bir modüldür.
- Kullanıcılar, firma geçmişi, vizyonu ve misyonu gibi içeriklere erişebilir.
- Admin panelinden hakkımızda sayfasının içeriği düzenlenebilir.

### **2. Blog Modülü (Blog)**
- E-ticaret sitesine özel blog içeriklerinin eklenmesini sağlar.
- Kullanıcıların bilgilendirilmesi ve SEO açısından katkı sunan bir yapıdır.
- Blog yazıları admin panelinden eklenebilir, düzenlenebilir ve kaldırılabilir.

### **3. Kategori Modülü (Category)**
- Ürünlerin belirli kategoriler altında listelenmesini sağlar.
- SEO uyumlu kategori yapıları ile kullanıcı deneyimini artırır.
- Yönetim panelinden kategoriler eklenebilir, düzenlenebilir ve silinebilir.

### **4. Dashboard Modülü (Dashboard)**
- Yönetim panelinin ana sayfasını oluşturur.
- Sipariş istatistikleri, toplam gelir ve stok durumu gibi önemli bilgileri gösterir.
- Kullanıcı ve sipariş hareketlerini izlemeye olanak tanır.

### **5. Fırsatlar Modülü (Deal)**
- Özel indirimler ve kampanyalar oluşturulabilir.
- Belirlenen ürünlerde belirli süreli kampanyalar başlatılabilir.
- Yönetim panelinden fırsat yönetimi sağlanabilir.

### **6. Sipariş Yönetimi Modülü (Order)**
- Kullanıcıların verdiği siparişleri listeleyerek yönetim imkanı sunar.
- Sipariş durum güncellemeleri yapılabilir (Hazırlanıyor, Kargoya Verildi, Teslim Edildi vb.).
- Kullanıcılar, sipariş takibini hesaplarından yapabilir.

### **7. Sayfalar Modülü (Page)**
- **Gizlilik Politikası, Kullanım Şartları, İade ve Teslimat Koşulları gibi** sayfaları yönetmeyi sağlar.
- Kullanıcıların yasal bilgilere kolayca ulaşmasını sağlar.
- Admin panelinden yeni sayfalar eklenebilir, düzenlenebilir ve kaldırılabilir.

### **8. Ürünler Modülü (Product)**
- Ürün ekleme, düzenleme, stok yönetimi ve silme işlemlerini içerir.
- Ürünlere **resim galerisi** eklenebilir ve özellikleri yönetilebilir.
- SEO uyumlu **ürün sayfaları** oluşturulabilir.

### **9. Ayarlar Modülü (Settings)**
- Site genelindeki ayarların yönetilmesini sağlar.
- Ödeme entegrasyonu, kargo ayarları, iletişim bilgileri gibi sistemsel yapılandırmalar buradan kontrol edilir.

### **10. Slider Modülü (Slider)**
- Ana sayfada ve belirli bölümlerde **dinamik görsel içerikler** oluşturmayı sağlar.
- Yönetim panelinden slider ekleme, düzenleme ve kaldırma işlemleri yapılabilir.
- Kullanıcıların dikkatini çekmek için interaktif banner'lar oluşturulabilir.

---

## **Diğer Öne Çıkan Özellikler**
- **Ödeme Entegrasyonu:** İyzico gibi ödeme sistemleri ile entegre edilebilen **modüler bir ödeme yapısı** bulunmaktadır.
- **Kullanıcı Giriş-Çıkış Yönetimi:** Kullanıcılar hesap açabilir, giriş yapabilir ve hesap bilgilerini yönetebilir.
- **SEO Uyumluluğu:** Kategoriler, ürünler ve blog yazıları için **SEO dostu URL yapıları** oluşturulmuştur.
- **Güvenlik:** SQL Injection, XSS ve CSRF gibi saldırılara karşı çeşitli güvenlik önlemleri alınmıştır.
- **Görsellik ve Mobil Uyumluluk:** **Responsive tasarım** ile **mobil cihazlarda tam uyumluluk** sağlanmıştır.
- **Yönetim Paneli:** Kullanıcı dostu bir **admin paneli** ile tüm site içeriği kolayca yönetilebilir.

Bu proje, **açık kaynaklı** olarak geliştirilmiştir ve kolayca özelleştirilebilir. Geliştiriciler için **esnek bir kod yapısı** sunarak yeni özellikler eklemeye olanak tanır. **E-ticaret sektöründe hızlı, güvenli ve ölçeklenebilir bir çözüm** arayanlar için güçlü bir temel sunmaktadır.

## Proje Tam Klasör Yapısı

Bu bölümde, projenin tam klasör yapısı detaylandırılmıştır. **MVC (Model-View-Controller) mimarisi** kullanılarak geliştirilen bu e-ticaret sistemi, belirli bir modüler yapı ve katmanlı mimari yaklaşımı ile organize edilmiştir. 

Aşağıda belirtilen klasör yapısı, **kontrolörler (Controllers), modeller (Models), görünümler (Views) ve çekirdek yapı (Core) gibi temel bileşenleri** içermektedir. Ayrıca, **yardımcı araçlar (Helpers), ara katman yazılımları (Middleware), varlık yönetimi (Uploads) ve bağımsız yönetim panelleri (Admin & Front)** gibi modüller de mevcuttur.

📌 **Dikkat:** Buraya `/vendor` klasörünü dahil etmedik, çünkü bağımlılık yönetimi **Composer** ile sağlanmaktadır. Bağımlılıkların yüklenmesi ve yönetimi için ilgili bölümde detaylı talimatlar verilecektir. 

```
.
├── app
│   ├── Controllers
│   │   ├── Admin
│   │   │   ├── AboutController.php
│   │   │   ├── BlogController.php
│   │   │   ├── CategoryController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── DealController.php
│   │   │   ├── OrderController.php
│   │   │   ├── PageController.php
│   │   │   ├── ProductController.php
│   │   │   ├── SettingsController.php
│   │   │   └── SliderController.php
│   │   └── Front
│   │       ├── AboutsController.php
│   │       ├── AuthController.php
│   │       ├── BlogController.php
│   │       ├── BuyController.php
│   │       ├── CartController.php
│   │       ├── CategoryController.php
│   │       ├── ContactController.php
│   │       ├── CustomerController.php
│   │       ├── HomeController.php
│   │       ├── OrderController.php
│   │       ├── PageController.php
│   │       ├── ProductController.php
│   │       └── SearchController.php
│   ├── Core
│   │   ├── BaseController.php
│   │   ├── Config.php
│   │   ├── Database.php
│   │   └── Route.php
│   ├── Helpers
│   │   └── Mailer.php
│   ├── Middleware
│   │   └── AuthMiddleware.php
│   └── Models
│       ├── AboutModel.php
│       ├── AuthModel.php
│       ├── BlogModel.php
│       ├── BuyModel.php
│       ├── CartModel.php
│       ├── CategoryModel.php
│       ├── DashboardModel.php
│       ├── DealModel.php
│       ├── OrderModel.php
│       ├── PageModel.php
│       ├── ProductModel.php
│       ├── SearchModel.php
│       ├── SettingsModel.php
│       └── SliderModel.php
├── public
│   ├── css
│   │   ├── admin-styles.css
│   │   ├── bootstrap.min.css
│   │   └── styles.css
│   ├── index.php
│   ├── js
│   │   ├── admin-script.js
│   │   ├── bootstrap.bundle.min.js
│   │   └── scripts.js
│   └── uploads
│       ├── about
│       ├── ads
│       ├── blogs
│       ├── products
│       └── sliders
├── views
│   ├── admin
│   │   ├── about
│   │   │   └── edit.php
│   │   ├── blogs
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   └── index.php
│   │   ├── categories
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   └── index.php
│   │   ├── dashboard.php
│   │   ├── deal
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   └── index.php
│   │   ├── order
│   │   │   └── index.php
│   │   ├── page
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   └── index.php
│   │   ├── product
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   ├── gallery.php
│   │   │   └── index.php
│   │   ├── settings
│   │   │   └── index.php
│   │   ├── slider
│   │   │   ├── create.php
│   │   │   ├── edit.php
│   │   │   └── index.php
│   │   └── users
│   │       └── profil.php
│   ├── front
│   │   ├── abouts.php
│   │   ├── auth
│   │   │   ├── customer.php
│   │   │   ├── order.php
│   │   │   └── sidebar.php
│   │   ├── blog
│   │   │   ├── detail.php
│   │   │   └── index.php
│   │   ├── buy
│   │   │   ├── index.php
│   │   │   └── order_success.php
│   │   ├── cart
│   │   │   └── index.php
│   │   ├── category.php
│   │   ├── contact.php
│   │   ├── errors
│   │   │   └── 404.php
│   │   ├── home.php
│   │   ├── login.php
│   │   ├── page.php
│   │   ├── product
│   │   │   └── detail.php
│   │   ├── register.php
│   │   └── search.php
│   └── layouts
│       ├── admin
│       │   ├── footer.php
│       │   └── header.php
│       └── front
│           ├── footer.php
│           └── header.php
├── .env
├── composer.json
├── composer.lock
└── README.md
```


## 📌 Proje Klasör ve Dosya Yapısını Terminal Üzerinden Oluşturma

Bu doküman, **Windows (CMD, PowerShell, Git Bash)** ve **MacOS/Linux (Terminal)** kullanıcıları için PHP tabanlı **E-Ticaret MVC projesinin** klasör ve dosya yapısını terminal üzerinden oluşturmayı açıklar.

---

## **📌 1. Tüm Gerekli Klasörleri Oluştur**
Aşağıdaki komutları terminalde çalıştırarak **tüm klasörleri** oluşturabilirsiniz.

```bash
mkdir -p app/Controllers/Admin app/Controllers/Front app/Core app/Helpers app/Middleware app/Models
mkdir -p public/css public/js public/uploads/about public/uploads/ads public/uploads/blogs public/uploads/products public/uploads/sliders
mkdir -p views/admin/about views/admin/blogs views/admin/categories views/admin/deal views/admin/order views/admin/page views/admin/product views/admin/settings views/admin/slider views/admin/users
mkdir -p views/front/auth views/front/blog views/front/buy views/front/cart views/front/errors views/front/product
mkdir -p views/layouts/admin views/layouts/front
```

---

## **📌 2. PHP Dosyalarını Oluştur**
Aşağıdaki komutlar, **PHP dosyalarını** otomatik olarak oluşturacaktır.

```bash
touch app/Controllers/Admin/{AboutController.php,BlogController.php,CategoryController.php,DashboardController.php,DealController.php,OrderController.php,PageController.php,ProductController.php,SettingsController.php,SliderController.php}
touch app/Controllers/Front/{AboutsController.php,AuthController.php,BlogController.php,BuyController.php,CartController.php,CategoryController.php,ContactController.php,CustomerController.php,HomeController.php,OrderController.php,PageController.php,ProductController.php,SearchController.php}
touch app/Core/{BaseController.php,Config.php,Database.php,Route.php}
touch app/Helpers/Mailer.php
touch app/Middleware/AuthMiddleware.php
touch app/Models/{AboutModel.php,AuthModel.php,BlogModel.php,BuyModel.php,CartModel.php,CategoryModel.php,DashboardModel.php,DealModel.php,OrderModel.php,PageModel.php,ProductModel.php,SearchModel.php,SettingsModel.php,SliderModel.php}
```

---

## **📌 3. Public Klasörü İçin Gerekli Dosyaları Oluştur**

```bash
touch public/index.php
touch public/css/{admin-styles.css,bootstrap.min.css,styles.css}
touch public/js/{admin-script.js,bootstrap.bundle.min.js,scripts.js}
```

---

## **📌 4. Views (Görünümler) İçin Dosyaları Oluştur**

```bash
touch views/admin/about/edit.php
touch views/admin/blogs/{create.php,edit.php,index.php}
touch views/admin/categories/{create.php,edit.php,index.php}
touch views/admin/deal/{create.php,edit.php,index.php}
touch views/admin/order/index.php
touch views/admin/page/{create.php,edit.php,index.php}
touch views/admin/product/{create.php,edit.php,gallery.php,index.php}
touch views/admin/settings/index.php
touch views/admin/slider/{create.php,edit.php,index.php}
touch views/admin/users/profil.php

touch views/front/abouts.php
touch views/front/auth/{customer.php,order.php,sidebar.php}
touch views/front/blog/{detail.php,index.php}
touch views/front/buy/{index.php,order_success.php}
touch views/front/cart/index.php
touch views/front/category.php
touch views/front/contact.php
touch views/front/errors/404.php
touch views/front/home.php
touch views/front/login.php
touch views/front/page.php
touch views/front/product/detail.php
touch views/front/register.php
touch views/front/search.php

touch views/layouts/admin/{footer.php,header.php}
touch views/layouts/front/{footer.php,header.php}
```

---

## **📌 5. Ekstra Dosyaları Oluştur**

```bash
touch .env composer.json composer.lock README.md
```

---

## **🛑 Hata ve Çözümler**
Eğer **permission denied** veya farklı hata mesajları alırsanız, aşağıdaki mini testleri yaparak hataların kaynağını öğrenmelerini sağlayabilirsiniz.

### **Mevcut dizinde yazma izni var mı?**
```bash
ls -ld $(pwd) # Mac/Linux
icacls . # Windows CMD
```

### **Dosya oluşturabiliyor musunuz?**
```bash
touch deneme.txt # Mac/Linux/Git Bash
echo.> deneme.txt # Windows CMD
```

---

## **📌 En Sık Karşılaşılan Hatalar ve Çözümleri**

| Hata | Sebep | Çözüm |
|------|-------|--------|
| **Permission denied** | Yetki eksikliği | `sudo chmod -R 777 klasör_adı/` ile izin verin |
| **Permission denied** | Yetki eksikliği | `sudo chmod -R 755 klasör_adı/` ile izin verin |
| **command not found** | Komut yanlış yazıldı veya ortam değişkeni eksik | Komutu kontrol edin, gerekirse Git Bash veya CMD kullanın |
| **mkdir: cannot create directory** | Dizin zaten var veya yetki yok | `ls -ld klasör_adı/` ile kontrol edin |
| **touch: cannot touch** | Dosya zaten var veya yetki yok | `ls -l dosya_adı` ile kontrol edin |

---



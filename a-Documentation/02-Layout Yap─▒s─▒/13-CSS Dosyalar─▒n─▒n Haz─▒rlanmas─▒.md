# **01- Admin CSS Flexbox ile Sayfa Düzeni Oluşturma (admin-styles.css)**
 
Bu eğitim dokümanında, **Flexbox** kullanarak nasıl düzenli ve esnek bir web sayfası oluşturabileceğinizi öğreneceksiniz. Aşağıda, **HTML ve CSS ile esnek bir yapı kurarken** dikkate alınması gereken temel özellikler açıklanmaktadır.

---

## **1. HTML ve Sayfa Yüksekliği Ayarları**

HTML ve `body` etiketlerinin sayfa boyutuna tam uyum sağlaması için aşağıdaki stil kuralları kullanılır:

```css
html { 
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}
```

### **Ne İşe Yarar?**
✅ `height: 100%` → HTML elemanının tam ekran boyutunda olmasını sağlar.
✅ `min-height: 100vh` → Sayfanın en az tam ekran yüksekliğinde olmasını garanti eder.
✅ `display: flex; flex-direction: column;` → İçeriğin dikey olarak düzenlenmesini sağlar.

---

## **2. Form Kontrollerinin Özelleştirilmesi**
Bazı form elemanları için özel bir arka plan rengi ve şeffaflık ayarları yapılmıştır:

```css
.form-control[readonly] {
    background-color: #e9ecef;
    opacity: 1;
}
```

### **Ne İşe Yarar?**
✅ `background-color: #e9ecef;` → Okunabilirliği artırmak için açık gri arka plan kullanır.
✅ `opacity: 1;` → Okuma modundaki form elemanlarının şeffaf olmamasını sağlar.

---

## **3. Dinamik Başlık Tasarımı**
**Başlıkları vurgulamak ve interaktif hale getirmek** için özel bir stil uygulanmıştır:

```css
.h1d-flex {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.h1d-flex:hover {
    transform: scale(1.02);
}
```

### **Ne İşe Yarar?**
✅ `box-shadow` → Hafif bir gölge ekleyerek başlığın ön plana çıkmasını sağlar.
✅ `transition` → Başlığın üzerine gelindiğinde yumuşak bir büyüme efekti verir.
✅ `transform: scale(1.02);` → Hover (üzerine gelme) durumunda başlığı %2 oranında büyütür.

---

## **4. Bölüm Başlıkları için Stil Ayarları**
Bölüm başlıklarının daha belirgin hale gelmesini sağlamak için şu stil kuralları kullanılmıştır:

```css
.section-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
    color: #333;
    border-bottom: 2px solid #ddd;
    padding-bottom: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title i {
    font-size: 1.5rem;
    color: #666;
}
```

### **Ne İşe Yarar?**
✅ `border-bottom` → Bölüm başlıklarına alt çizgi ekleyerek vurgulamayı artırır.
✅ `display: flex; justify-content: space-between;` → Başlıkların hizalanmasını sağlar.
✅ `font-size` ve `font-weight` → Daha belirgin ve okunaklı başlıklar oluşturur.

---

## **5. Yüklenme Animasyonu (Loading Screen)**
Sayfa yüklenirken bir animasyon göstermek için aşağıdaki CSS kodu kullanılır:

```css
#loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: white;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.5s ease-out;
}

#loading.hidden {
    opacity: 0;
    pointer-events: none;
}
```

### **Ne İşe Yarar?**
✅ `position: fixed;` → Yüklenme animasyonunun sayfa boyunca sabit kalmasını sağlar.
✅ `z-index: 9999;` → Diğer tüm öğelerin üstünde görünmesini garanti eder.
✅ `transition: opacity 0.5s ease-out;` → Sayfa yüklenince animasyonun yumuşak bir şekilde kaybolmasını sağlar.

---

## **6. Esnek Footer Tasarımı**
Sayfanın en altında her zaman düzgün görünen bir footer eklemek için şu kod kullanılmıştır:

```css
.footer {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    margin-top: auto;
    width: 100%;
}
```

### **Ne İşe Yarar?**
✅ `flex-shrink: 0;` → Footer’ın içeriğe göre küçülmesini engeller.
✅ `margin-top: auto;` → Sayfanın en altında sabit durmasını sağlar.
✅ `display: flex; flex-direction: column;` → Footer içeriğini esnek şekilde hizalar.

---
## 📌 **Tam Kod (admin-styles.css)**
```css
html { 
    height: 100%;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

.form-control[readonly] {
    background-color: #e9ecef;
    opacity: 1;
}

.h1d-flex {
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: transform 0.2s ease-in-out;
}

.h1d-flex:hover {
    transform: scale(1.02);
}

.section-title {
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
    color: #333;
    border-bottom: 2px solid #ddd;
    padding-bottom: 0.5rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.section-title i {
    font-size: 1.5rem;
    color: #666;
}

#loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: white;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.5s ease-out;
}

#loading.hidden {
    opacity: 0;
    pointer-events: none;
}

.footer {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    margin-top: auto;
    width: 100%;
}
```
---

Bu dokümanda, **Flexbox kullanarak modern bir sayfa düzeni oluşturma** ve **tasarım bileşenlerini özelleştirme** konularını inceledik. Şimdi, bu stilleri kendi projelerinizde uygulayarak öğrendiklerinizi pekiştirebilirsiniz! 🚀



---
---

# **02 - Frontend CSS Kullanıcı Arayüzü (UI) Stilleri (styles.css)**

Bu eğitim dokümanında, **CSS kullanarak farklı kullanıcı arayüzü (UI) bileşenlerini** nasıl stilize edebileceğinizi öğreneceksiniz. Burada **carousel, kartlar, rozetler, favori ikonlar, haber akışı, dropdown menüler ve admin paneli gibi** bileşenlere yönelik CSS açıklamalarını bulabilirsiniz.

---

## **1. Carousel (Kaydırmalı Galeri) Stilleri**

```css
.carousel-item {
    overflow: hidden;
    border-radius: 0.5rem;
}
.carousel-item-next,
.carousel-item-prev,
.carousel-item.active {
    transition: none;
}
```

### **Ne İşe Yarar?**
✅ `border-radius: 0.5rem;` → Kenarları yuvarlatılmış bir tasarım sunar.
✅ `overflow: hidden;` → Taşan içeriği gizleyerek temiz bir görünüm sağlar.
✅ `transition: none;` → Geçiş animasyonlarını kaldırır.

---

## **2. Kart (Card) Tasarımları**

```css
.card { 
    margin-bottom: 30px;
}
.card-img-top {
    transition: opacity 0.5s ease;
}
.card-img-top.hover-img {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}
.card:hover .card-img-top {
    opacity: 0;
}
.card:hover .card-img-top.hover-img {
    opacity: 1;
}
```

### **Ne İşe Yarar?**
✅ `margin-bottom: 30px;` → Kartlar arasındaki boşluğu ayarlar.
✅ `opacity` ve `hover` → Kullanıcı fareyle üzerine geldiğinde **görsel değişimi** sağlar.

---

## **3. Badge (Rozet) Stilleri**

```css
.badge-label {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
```

### **Ne İşe Yarar?**
✅ `position: absolute;` → Kartın belirli bir köşesine konumlandırır.
✅ `border-radius: 50%;` → Yuvarlak rozet oluşturur.
✅ `box-shadow` → Hafif bir gölge efekti verir.

---

## **4. Favori İkonları**

```css
.favorite-icon {
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 1;
    font-size: 1.5rem;
    cursor: pointer;
}
```

### **Ne İşe Yarar?**
✅ Kullanıcının **favorilere ekleme butonu** oluşturmasını sağlar.
✅ **Konumlandırma ve tıklanabilirlik** için `cursor: pointer;` kullanılır.

---

## **5. Haber Akışı (Breaking News)**

```css
.breaking-news {
    height: 30px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
```

### **Ne İşe Yarar?**
✅ **Kayar haber akışı** için animasyon destekler.
✅ `overflow: hidden;` → **Taşan içerikleri gizler**, sadece belirli haberleri gösterir.

---

## **6. Dropdown Menü Stilleri**

```css
.dropdown-menu .dropdown-item i {
    width: 20px; /* Sabit genişlik belirleniyor */
    text-align: center;
    margin-right: 10px;
}
.dropdown-menu .dropdown-item {
    display: flex;
    align-items: center;
}
```

### **Ne İşe Yarar?**
✅ Dropdown içindeki **ikonların ve metinlerin hizalanmasını** sağlar.
✅ Kullanıcıya **daha düzenli bir deneyim sunar**.

---

## **7. Admin Paneli Yüklenme Animasyonu**

```css
#loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: white;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.5s ease-out;
}
#loading.hidden {
    opacity: 0;
    pointer-events: none;
}
```

### **Ne İşe Yarar?**
✅ Sayfa yüklenirken bir **beyaz ekran efekti** gösterir.
✅ Yüklenme tamamlandığında, `opacity: 0;` ile **görünmez hale gelir**.

---

## **8. Resim Boyutlandırma**

```css
.img-300x300 {
    width: 100%;
    height: 300px;
    object-fit: cover;
}
```

### **Ne İşe Yarar?**
✅ Görsellerin **eşit boyutta** ve **orantılı görünmesini** sağlar.
✅ `object-fit: cover;` ile **görselin orantısını koruyarak kırpma yapar**.

---

## **9. Sekmeler (Tabs) İçin Stil Ayarları**

```css
.nav-tabs .nav-link.active {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}
```

### **Ne İşe Yarar?**
✅ Aktif sekmelerin **belirgin hale gelmesini** sağlar.
✅ Kullanıcı deneyimini artırır.

---

## 📌 **Tam Kod (styles.css)**
```css
/* Carousel */
.carousel-item {
    overflow: hidden;
    border-radius: 0.5rem;
}
.carousel-item-next,
.carousel-item-prev,
.carousel-item.active {
    transition: none;
}

/* Card */
.card { 
    margin-bottom: 30px;
}
.card-img-top {
    transition: opacity 0.5s ease;
}
.card-img-top.hover-img {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
}
.card:hover .card-img-top {
    opacity: 0;
}
.card:hover .card-img-top.hover-img {
    opacity: 1;
}

/* Badge */
.badge-label {
    position: absolute;
    top: 10px;
    right: 10px;
    z-index: 1;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}
.badge-featured {
    position: absolute;
    top: 20px;
    left: 20px;
    z-index: 1;
}
.badge-best-seller {
    position: absolute;
    bottom: 20px;
    left: 20px;
    z-index: 1;
}

/* Favorite Icon */
.favorite-icon {
    position: absolute;
    bottom: 20px;
    right: 20px;
    z-index: 1;
    font-size: 1.5rem;
    cursor: pointer;
}

/* Breaking News */
.breaking-news {
    height: 30px;
    overflow: hidden;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.breaking-news .news-container {
    flex: 1;
    height: 100%;
    overflow: hidden;
    position: relative;
}
.breaking-news p {
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    line-height: 30px;
    text-align: left;
    padding-left: 10px;
    animation: slide 16s linear infinite;
}
.breaking-news p:nth-child(2) {
    animation-delay: 4s;
}
.breaking-news p:nth-child(3) {
    animation-delay: 8s;
}
.breaking-news p:nth-child(4) {
    animation-delay: 12s;
}
@keyframes slide {
    0% { top: 100%; }
    5% { top: 0; }
    25% { top: 0; }
    30% { top: -100%; }
    100% { top: -100%; }
}
.breaking-news p {
    opacity: 0;
}
.breaking-news p:nth-child(1) {
    animation: slide 16s linear infinite, fadeIn 1s forwards;
}
.breaking-news p:nth-child(2) {
    animation: slide 16s linear infinite 4s, fadeIn 1s 4s forwards;
}
.breaking-news p:nth-child(3) {
    animation: slide 16s linear infinite 8s, fadeIn 1s 8s forwards;
}
.breaking-news p:nth-child(4) {
    animation: slide 16s linear infinite 12s, fadeIn 1s 12s forwards;
}
@keyframes fadeIn {
    to { opacity: 1; }
}
.breaking-news .fixed-message {
    white-space: nowrap;
    margin-left: auto;
    padding-right: 10px;
}

/* Dropdown Menu */
.dropdown-menu .dropdown-item i {
    width: 20px; /* Sabit genişlik belirleniyor */
    text-align: center; /* İkonların ortalanması */
    margin-right: 10px; /* İkon ve metin arasında boşluk */
}
.dropdown-menu .dropdown-item {
    display: flex; /* İkon ve metni yan yana hizalamak için */
    align-items: center; /* Dikey olarak ortalanması */
}

/* Admin Styles */
#loading {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    background: white;
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: opacity 0.5s ease-out;
} 
#loading.hidden {
    opacity: 0;
    pointer-events: none;
}

/* Image */
.img-300x300 {
    width: 100%;
    height: 300px;
    object-fit: cover;
}

/* Short Description */
.short-description {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    height: 3em;
    /* 2 satır yüksekliği */
}

/* Tabs */
.tab-content>.tab-pane {
    padding: 20px;
    border: 1px solid #dee2e6;
    border-top: none;
}
.nav-tabs .nav-link {
    border: 1px solid transparent;
    border-radius: 0;
    color: #495057;
}
.nav-tabs .nav-link.active {
    color: #fff;
    background-color: #6c757d;
    border-color: #6c757d;
}
.nav-tabs .nav-link:hover {
    border-color: #6c757d;
}

/* Login */
.separator {
    text-align: center;
    margin: 20px 0;
    position: relative;
}
.separator::before,
.separator::after {
    content: '';
    display: block;
    width: 40%;
    height: 1px;
    background: #ddd;
    position: absolute;
    top: 50%;
}
.separator::before {
    left: 0;
}
.separator::after {
    right: 0;
}

/* Register */
.form-check-label a {
    color: inherit;
    text-decoration: underline;
}

body {
    display: flex;
    flex-direction: column;
    min-height: 100vh;
}

footer {
    position: relative;
    margin-top: auto;
}

footer .container {
    margin-top: auto;
}
```

---

Bu dokümanda, **kullanıcı arayüzü bileşenlerini CSS ile nasıl stilize edebileceğinizi** öğrendiniz. Şimdi, bu bilgileri kendi projelerinizde kullanarak deneyim kazanmaya başlayabilirsiniz! 🚀


# **03 - Bootstrap CSS Dosyasını Projeye Dahil Etme**

Bu bölümde, **Bootstrap CSS kütüphanesini** projenize nasıl ekleyebileceğinizi ve kullanabileceğinizi öğreneceksiniz. Bootstrap, modern ve duyarlı (responsive) tasarımlar oluşturmak için kullanılan en popüler CSS frameworklerinden biridir.

---

## **1. Bootstrap CSS Dosyasını Temin Etme**

Bootstrap kütüphanesini projeye dahil etmek için aşağıdaki yöntemlerden birini kullanabilirsiniz:

### **Yöntem 1: Eğitmenin Paylaştığı Dosyayı Kullanma**

Eğitmeniniz tarafından sağlanan **bootstrap.min.css** dosyasını indirip projenizin ilgili dizinine yerleştirmeniz gerekmektedir. Bu dosyayı **public/css** klasörüne ekleyin:

📂 **Proje Dizini Yapısı:**

```
/your-project
│── public/
│   ├── css/
│   │   ├── bootstrap.min.css  ← (Bootstrap CSS buraya eklenmeli)
│   ├── js/
│   ├── images/
│── index.html (veya PHP dosyalarınız)
```

### **Yöntem 2: Bootstrap'in Resmi Kaynağından İndirme**

Eğer eğitmeniniz dosyayı paylaşmadıysa, aşağıdaki linkten Bootstrap'in en güncel sürümünü indirebilirsiniz:

🔗 [Bootstrap Resmi Sitesi](https://getbootstrap.com/)

**İndirmek İçin:**
1. [https://getbootstrap.com/docs/5.3/getting-started/download/](https://getbootstrap.com/docs/5.3/getting-started/download/) adresine gidin.
2. "Compiled CSS and JS" seçeneğini indirin.
3. İçerisindeki **bootstrap.min.css** dosyasını **public/css** klasörüne yerleştirin.

---

## **2. Bootstrap'i HTML Dosyanıza Dahil Etme**

Bootstrap CSS dosyasını projenize dahil etmek için **HTML sayfanızın `<head>`** bölümüne aşağıdaki satırı ekleyin:

```html
<link rel="stylesheet" href="public/css/bootstrap.min.css">
```

Eğer bir PHP projesinde kullanıyorsanız, **base URL'yi** dinamik olarak eklemek için aşağıdaki gibi bir yol kullanabilirsiniz:

```php
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/public/css/bootstrap.min.css">
```

**Ne İşe Yarar?**
✅ Bootstrap’in tüm stil ve bileşenlerini projenizde kullanmanıza olanak tanır.
✅ HTML dosyanızın Bootstrap tarafından stilize edilmesini sağlar.
✅ Kendi özel CSS dosyalarınızı Bootstrap’in üzerine ekleyerek özelleştirme yapabilirsiniz.

---

## **3. Bootstrap Kullanımına Başlama**

Artık Bootstrap dahil edildiğine göre, aşağıdaki gibi bazı Bootstrap bileşenlerini kullanarak test edebilirsiniz.

### **Örnek 1: Buton Kullanımı**

```html
<button class="btn btn-primary">Bootstrap Butonu</button>
```

### **Örnek 2: Grid Sistemi Kullanımı**

```html
<div class="container">
    <div class="row">
        <div class="col-md-6">Sol Alan</div>
        <div class="col-md-6">Sağ Alan</div>
    </div>
</div>
```

---

## **Sonuç**

Bu adımları takip ederek **Bootstrap CSS dosyanızı projenize ekleyebilir** ve sayfanızın modern, duyarlı bir tasarıma sahip olmasını sağlayabilirsiniz. 🎯
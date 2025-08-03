# **JS Dosyalarının Hazırlanması**
 
Bu bölümde, **JavaScript dosyalarının nasıl yapılandırılacağını ve projeye nasıl entegre edileceğini** öğreneceksiniz. **Admin paneli, frontend scriptleri ve Bootstrap JavaScript dosyalarının** nasıl kullanılacağı detaylı olarak açıklanmıştır.

---

## **1. Admin Paneli JavaScript Dosyası (admin-script.js)**

Admin panelinde **sayfa yüklenirken gösterilen yükleme ekranının (loading screen) kaldırılması** için aşağıdaki kod kullanılır:

```js
window.addEventListener('load', function() {
    const loadingElement = document.getElementById('loading');
    loadingElement.classList.add('hidden');
    setTimeout(function() {
        loadingElement.style.display = 'none';
    }, 500); // Geçiş süresi ile aynı olmalı
});
```

### **Ne İşe Yarar?**
✅ **Sayfa yüklendiğinde** `loading` elementi gizlenir.
✅ **500 ms sonra** öğe tamamen kaldırılarak performans iyileştirilir.

---

## **2. Frontend JavaScript Dosyası (script.js)**

Kullanıcı arayüzünde **carousel sayaç güncellenmesi, favorilere ekleme ve yükleme ekranı** gibi işlemler için aşağıdaki kodlar kullanılır:

```js
document.addEventListener('DOMContentLoaded', function () {
    var carouselElement = document.getElementById('carouselExampleIndicators');
    var carouselCounter = document.getElementById('carouselCounter');
    var totalItems = carouselElement.querySelectorAll('.carousel-item').length;

    carouselElement.addEventListener('slid.bs.carousel', function (event) {
        var currentIndex = event.to + 1;
        carouselCounter.textContent = currentIndex + '/' + totalItems;
    });
});

function addToFavorites() {
    alert("Favorilere eklendi");
}

window.addEventListener('load', function() {
    const loadingElement = document.getElementById('loading');
    loadingElement.classList.add('hidden');
    setTimeout(function() {
        loadingElement.style.display = 'none';
    }, 500); // Geçiş süresi ile aynı olmalı
});
```

### **Ne İşe Yarar?**
✅ **Carousel sayaç** ile geçiş yapılan slaytın numarası ekranda görüntülenir.
✅ **Favorilere ekle butonu** ile kullanıcıya bilgi veren bir pop-up gösterilir.
✅ **Yükleme ekranı (loading screen)** sayfa yüklenince gizlenir.

---

## **3. Bootstrap JavaScript Dosyasının Dahil Edilmesi**

Bootstrap bileşenlerini kullanabilmek için **bootstrap.bundle.min.js** dosyasını projenize eklemeniz gerekmektedir.

### **Dosyanın Temin Edilmesi**
- Eğitmeniniz tarafından sağlanan **bootstrap.bundle.min.js** dosyasını indirin.
- Veya en güncel sürümünü resmi siteden edinin:

🔗 [Bootstrap Resmi Sitesi](https://getbootstrap.com/)

**Dosyayı şu dizine yerleştirin:**

📂 **Proje Dizini Yapısı:**

```
/your-project
│── public/
│   ├── js/
│   │   ├── bootstrap.bundle.min.js  ← (Bootstrap JS buraya eklenmeli)
│   ├── css/
│── index.html (veya PHP dosyalarınız)
```

---



### **Ne İşe Yarar?**
✅ Bootstrap’in **dropdown, modal, tooltip gibi bileşenlerini** aktif eder.
✅ Sayfa performansını artırmak için `<body>` kapanış etiketinden önce eklenmelidir.

---

Bu adımları takip ederek **JavaScript dosyalarınızı yapılandırabilir ve Bootstrap bileşenlerini projeye entegre edebilirsiniz.** 🚀
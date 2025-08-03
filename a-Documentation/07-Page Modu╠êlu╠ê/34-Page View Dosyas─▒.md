# **Page View Dosyasının Kullanımı**

Bu eğitim dokümanında, **page.php view dosyasının nasıl çalıştığını ve sayfa verilerinin nasıl gösterildiğini** öğreneceksiniz. **Bu dosya, belirli bir sayfanın başlığını ve içeriğini dinamik olarak kullanıcıya gösterir.**

---

## **1. Page View Dosyasının Yapısı**

```html
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6"><?= htmlspecialchars($page['title']) ?></h1>
        <i class="fas fa-file-alt fa-3x text-secondary"></i>
    </div>
    <hr>

    <div class="row mt-4">
        <div class="col-md-12">
            <p><?= $page['content']; ?></p>
        </div>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Sayfa başlığını ve içeriğini dinamik olarak gösterir.**  
✅ `htmlspecialchars($page['title'])` → **Başlığı güvenli hale getirerek XSS saldırılarına karşı korur.**  
✅ `<i class="fas fa-file-alt fa-3x text-secondary"></i>` → **Sayfanın ikonunu belirler.**  
✅ `<p><?= $page['content']; ?></p>` → **Veritabanından gelen sayfa içeriğini ekrana basar.**  

---

## **2. Page View’ın Çalışmasını Test Etme**

**Web tarayıcınızda aşağıdaki URL’yi ziyaret edin:**
```url
http://phpeticaretv5.test/page/hakkimizda
```
📌 **Bu sayfa, veritabanından "hakkımızda" slug’ına sahip sayfanın içeriğini çekecektir.**

**Eğer hata alıyorsanız, aşağıdaki kontrolleri yapın:**
1. **`page.php` dosyasının ilgili dizinde olduğundan emin olun.**
2. **PageController’ın `show()` metodunun `$this->render('front/page', ['page' => $page])` çağrısını yaptığını kontrol edin.**
3. **Veritabanında ilgili slug’a sahip bir sayfanın olup olmadığını doğrulayın.**

---

## **3. Güvenlik ve Veri Doğrulama**

🔹 **HTML Injection veya XSS saldırılarını önlemek için şu eklemeyi yapabilirsiniz:**
```php
<p><?= nl2br(htmlspecialchars($page['content'])); ?></p>
```
📌 **Bu, HTML etiketlerini filtreleyerek güvenli hale getirir ve yeni satırları `<br>` etiketi ile gösterir.**

---

```html
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6"><?= htmlspecialchars($page['title']) ?></h1>
        <i class="fas fa-file-alt fa-3x text-secondary"></i>
    </div>
    <hr>

    <div class="row mt-4">
        <div class="col-md-12">
            <p><?= $page['content']; ?></p>
        </div>
    </div>
</div>
```
---

## **Sonuç**
Bu eğitimde, **page.php view dosyasının nasıl çalıştığını, hangi verileri gösterdiğini ve nasıl test edileceğini** öğrendiniz. **Şimdi, PageController ile sayfaları dinamik olarak görüntüleyebilirsiniz!** 🚀
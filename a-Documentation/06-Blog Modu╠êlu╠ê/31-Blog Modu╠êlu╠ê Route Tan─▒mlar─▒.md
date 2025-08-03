# **Blog Rotalarının Tanımlanması**

Bu eğitim dokümanında, **BlogController’ın çalışması için gerekli route tanımlamalarının nasıl yapılacağını** öğreneceksiniz. **Bu route’lar, blog yazılarının listelenmesini ve detay sayfasına yönlendirilmesini sağlar.**

---

## **1. Blog Rotalarının Tanımlanması**

Aşağıdaki route’lar, **public/index.php** dosyanızda tanımlanmalıdır:

```php
Route::add('blog', 'Front\BlogController@index'); 
Route::add('blog/([a-zA-Z0-9_-]+)', 'Front\BlogController@detail'); 
```

### **Ne İşe Yarar?**
✅ `Route::add('blog', 'Front\BlogController@index');` → **Tüm blog makalelerini listeleyen sayfaya yönlendirme yapar.**
✅ `Route::add('blog/([a-zA-Z0-9_-]+)', 'Front\BlogController@detail');` → **Belirli bir blog makalesini görüntülemek için slug’a göre yönlendirme yapar.**

---

## **2. Route’ların Tarayıcıda Test Edilmesi**

Route’ların doğru çalıştığını test etmek için aşağıdaki URL’leri ziyaret edin:

🔹 **Blog sayfasına erişmek için:**
```
https://phpeticaretv5.test/blog
```
📌 **Bu sayfa, BlogController’ın `index()` metodunu çağırarak tüm blog yazılarını listeler.**

🔹 **Belirli bir blog yazısını görmek için:**
```
https://phpeticaretv5.test/blog/php-egitimleri
```
📌 **Bu sayfa, `php-egitimleri` slug’ına sahip blog yazısının detaylarını görüntüler.**

---

## **3. Route Tanımlamalarının Doğruluğunu Kontrol Etme**

Eğer route çalışmıyorsa, aşağıdaki kontrolleri yapın:

1. **public/index.php** içinde yukarıdaki `Route::add()` tanımlamalarının olup olmadığını kontrol edin.
2. **BlogController’ın `index()` ve `detail()` metotlarının mevcut olduğundan emin olun.**
3. **Blog yazılarınızın veritabanında bulunduğunu kontrol edin.**
4. **URL’yi doğru şekilde yazdığınızdan emin olun.**

---

## **Sonuç**

Bu eğitimde, **Blog modülünün çalışması için gerekli route tanımlarını nasıl yapacağınızı ve test edeceğinizi** öğrendiniz. **Route’ların doğru şekilde çalıştığından emin olmak için yukarıdaki kontrolleri gerçekleştirin!** 🚀
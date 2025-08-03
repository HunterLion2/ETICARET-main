# **Product Route Tanımlaması**

Bu eğitim dokümanında, **ürün detay sayfasının nasıl çağrıldığını ve route tanımlamasının nasıl yapıldığını** öğreneceksiniz. **Bu route, belirli bir ürüne ait detay sayfasına erişimi sağlar.**

---

## **1. Product Route Tanımlaması**

Aşağıdaki route, **belirtilen slug’a sahip ürünün detay sayfasını göstermek için** tanımlanmıştır:

```php
Route::add('product/([a-zA-Z0-9_-]+)', 'Front\ProductController@detail');
```

### **Ne İşe Yarar?**
✅ `product/([a-zA-Z0-9_-]+)` → **Ürün slug'ını alarak dinamik olarak yönlendirme yapar.**  
✅ `'Front\ProductController@detail'` → **ProductController’ın `detail` metoduna yönlendirir.**  

**Bu route, aşağıdaki gibi çalışır:**

📌 **Örnek Kullanım:**
```sh
http://phpeticaretv5.test/product/iphone-13-pro
```
**Bu URL çağrıldığında:**
- **`iphone-13-pro` slug’ı alınır.**
- **`ProductController` sınıfının `detail` metodu çalıştırılır.**
- **İlgili ürünün detay sayfası gösterilir.**

---
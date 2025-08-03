# **Abouts Route Tanımlama (public/index.php)**
 
Bu eğitim dokümanında, **PHP ile Route (Yönlendirme) sisteminin nasıl çalıştığını** ve **AboutsController'a nasıl yönlendirme yapılacağını** öğreneceksiniz. **`public/index.php`** dosyasında Route tanımlayarak, **abouts sayfasının tarayıcıda erişilebilir hale gelmesini sağlayacağız.**

---

## **1. Route Tanımlamanın Mantığı**

Bir Route, gelen HTTP isteğini belirli bir Controller’a yönlendiren bir mekanizmadır. `public/index.php` dosyasında **`Route::add`** metodu kullanılarak aşağıdaki gibi bir yönlendirme yapılabilir:

```php
Route::add('abouts', 'Front\AboutsController@index');
```

### **Ne İşe Yarar?**
✅ **`Route::add('abouts', 'Front\AboutsController@index');`** → `abouts` URL’sine gelen istekleri **`Front\AboutsController` içindeki `index` metoduna yönlendirir.**
✅ **Gelen istek sonucunda kullanıcı hakkında sayfasını görür.**
✅ **Kendi tanımladığımız Controller ve Model sistemini kullanarak içerik çekmemizi sağlar.**

---

## **2. Route Tanımlamasını `public/index.php` İçine Eklemek**

```php
Route::add('abouts', 'Front\AboutsController@index');
```




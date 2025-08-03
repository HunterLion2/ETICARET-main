# **Category Route Tanımlaması ve Kontrolü**

Bu eğitim dokümanında, **kategoriye ait ürünleri listelemek için gerekli olan route’un nasıl tanımlandığını** ve **public/index.php dosyasında bu route'un mevcut olup olmadığının nasıl kontrol edileceğini** öğreneceksiniz. 

---

## **1. Category Route’un Tanımlanması**

Category detay sayfasında ürünleri listelemek için aşağıdaki route tanımlanmalıdır:

```php
Route::add('category/([a-zA-Z0-9_-]+)', 'Front\CategoryController@show');
```

### **Ne İşe Yarar?**
✅ `category/([a-zA-Z0-9_-]+)` → **Kategori slug'ını parametre olarak alır.**
✅ `Front\CategoryController@show` → **Kategoriye ait ürünleri listelemek için CategoryController’daki `show` metoduna yönlendirme yapar.**
✅ **Kategori detay sayfası view dosyaları henüz oluşturulmadı, ancak bu route'u şimdiden ekleyerek ileride kullanıma hazır hale getirebiliriz.**

---

## **2. public/index.php Dosyasında Route'un Tanımlı Olduğunu Kontrol Etme**

Category detay sayfasının düzgün çalışabilmesi için **public/index.php** dosyanızda yukarıdaki route’un olup olmadığını kontrol edin.

### **Kontrol İçin Yapılması Gerekenler**
1. **public/index.php dosyasını açın.**
2. Aşağıdaki satırın mevcut olup olmadığını kontrol edin:

   ```php
   Route::add('category/([a-zA-Z0-9_-]+)', 'Front\CategoryController@show');
   ```
3. Eğer kod mevcut değilse, ekleyerek kaydedin.
4. Tarayıcınızda aşağıdaki URL’yi açarak test edin:
   ```
   http://phpeticaretv5/category/elektronik
   ```
5. Eğer herhangi bir hata alıyorsanız, **routes.php veya ilgili routing sistemini içeri dahil ettiğinizden emin olun.**

---

## **3. Route’un Test Edilmesi**

Route'un düzgün çalıştığını doğrulamak için aşağıdaki adımları uygulayın:

✅ **Tarayıcıda şu adresi açın:**
```
http://phpeticaretv5/category/telefon
```
✅ **Eğer ilgili kategoriye ait ürünler listeleniyorsa, route başarıyla tanımlanmıştır.**
✅ **Eğer "404 Not Found" hatası alıyorsanız, route tanımlamasını ve CategoryController’ın mevcut olup olmadığını kontrol edin.**

---

## **Sonuç**

Bu eğitimde, **category route’un nasıl tanımlanacağını ve public/index.php dosyasında bu route’un olup olmadığının nasıl kontrol edileceğini** öğrendiniz. **Bu route’u ekleyerek ilerleyen süreçte kategori detay sayfası için gerekli altyapıyı hazırlamış olacaksınız!** 🚀
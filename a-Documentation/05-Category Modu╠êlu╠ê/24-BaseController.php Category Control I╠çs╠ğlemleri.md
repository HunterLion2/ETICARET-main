# **Category Modülünü BaseController’a Eklemek ve Tüm Rotalara Yayınlamak**

Bu eğitim dokümanında, **CategoryModel'in tüm rotalara nasıl entegre edileceğini** ve **BaseController üzerinden yayınlanmasını** öğreneceksiniz. **Daha önce BaseController.php içinde bu kodlar eklenmişti, ancak çeşitli işlemler sırasında yorum satırına alınmış olabilir. Bu yüzden kontrol edilmesi önemlidir.**

---

## **1. BaseController.php İçinde CategoryModel Kullanımı**

Aşağıdaki kod, **CategoryModel kullanarak uygulama kategorilerini yüklemektedir:**

```php
use App\Models\CategoryModel;

$categoryModel = new CategoryModel();
$this->categories = $categoryModel->getActiveCategories();
```

### **Ne İşe Yarar?**
✅ `use App\Models\CategoryModel;` → **CategoryModel sınıfını dahil eder.**
✅ `new CategoryModel();` → **Veritabanından aktif kategorileri yükler.**
✅ `$this->categories = $categoryModel->getActiveCategories();` → **Uygulama genelinde kategorilere erişimi sağlar.**

🔹 **Önemli Not:**
**BaseController dosyanızda bu kod zaten mevcut, ancak çeşitli işlemler sırasında yorum satırına alınmış olabilir. Kodun aktif olup olmadığını kontrol ediniz!**

---

## **2. Render ve RenderAdmin Metotlarında Kategorilerin Gönderilmesi**

**BaseController.php** dosyanızın `render()` ve `renderAdmin()` metotları içinde aşağıdaki kodun bulunduğunu kontrol ediniz:

```php
$data['categories'] = $this->categories;
```

### **Ne İşe Yarar?**
✅ **Tüm görünümlere (views) kategori listesinin otomatik olarak iletilmesini sağlar.**
✅ **Admin ve kullanıcı arayüzleri için gerekli yapılandırmaları içerir.**

🔹 **Önemli Not:**
Bu kod da halihazırda **BaseController.php** içinde yer almakta, ancak daha önce bazı işlemler için **yorum satırına alınmış olabilir**. Kontrol edilerek tekrar aktif hale getirilmelidir.

---

## **Sonuç**

Bu eğitimde **CategoryModel’in BaseController’a nasıl entegre edildiğini ve tüm rotalara nasıl yayın yapıldığını** öğrendiniz. Şimdi, **BaseController.php dosyanızda bu kodların aktif olduğundan emin olun ve yorum satırına alınmışsa tekrar etkinleştirin!** 🚀

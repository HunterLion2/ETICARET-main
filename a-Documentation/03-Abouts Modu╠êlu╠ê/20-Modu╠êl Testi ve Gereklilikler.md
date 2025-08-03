# **Abouts Modülünü Test Etme ve BaseController Güncelleme**

Bu eğitim dokümanında, **Abouts modülünün nasıl test edileceğini**, **BaseController üzerinden gereksiz kodları devre dışı bırakmayı** ve **test işlemini gerçekleştirirken kullanabileceğiniz URL’leri** öğreneceksiniz.
 
---

## **1. BaseController.php Üzerinde Değişiklik Yapma**

Abouts modülünü test ederken, henüz yazılmamış **SettingsModel** ve **CategoryModel** sınıfları nedeniyle hata alınabilir. Çünkü **BaseController.php**, tüm sayfalara bu modelleri yayınlamaktadır.

Bu nedenle, aşağıdaki kodları **yorum satırına almanız gerekmektedir:**

### **BaseController.php Üzerinde Yorum Satırına Alınması Gereken Kodlar**

```php
// SettingsModel kullanarak ayarları yükle
// $settingsModel = new SettingsModel();
// $this->settings = $settingsModel->getAllSettings();

// CategoryModel'den kategorileri al
// $categoryModel = new CategoryModel();
// $this->categories = $categoryModel->getActiveCategories();
```

### **Ne İşe Yarar?**
✅ **BaseController içindeki gereksiz bağımlılıkları devre dışı bırakır.**
✅ **SettingsModel ve CategoryModel dosyaları oluşturulmadan hata almadan test yapabilmenizi sağlar.**
✅ **Sadece Abouts modülünün çalışmasını kontrol etmek için temiz bir test ortamı oluşturur.**

---

## **2. Abouts Modülünü Test Etme**

Kod düzenlemeleri tamamlandıktan sonra, **tarayıcı üzerinden Abouts modülünü test edebilirsiniz.**

### **Test Linki:**
```
https://projeklasörü.test/abouts
```

Eğer eğitmenin kullandığı proje ortamında test etmek isterseniz aşağıdaki linki ziyaret edebilirsiniz:

### **Eğitmenin Örnekte Kullandığı Test Linki:**
```
https://phpeticaretv5.test/abouts
```

### **Ne İşe Yarar?**
✅ **Abouts modülünün çalışıp çalışmadığını test edersiniz.**
✅ **Veritabanından gelen bilgilerin doğru şekilde görünüp görünmediğini kontrol edersiniz.**
✅ **Sayfa yüklenirken hata olup olmadığını gözlemleyebilirsiniz.**

---

Bu adımları tamamladıktan sonra, artık Abouts modülünüzü **hatasız bir şekilde test edebilir ve geliştirmeye devam edebilirsiniz!** 🚀
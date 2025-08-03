# TinyMCE API Anahtarı ve Domain Ekleme İşlemi

## Genel Bakış

Bu dokümantasyon, **TinyMCE** editörünü kullanırken karşılaşılan *"This domain is not registered in the TinyMCE Customer Portal"* hatasının çözümünü ve API anahtarı ekleme işlemini açıklar.

---

## Hata Açıklaması

TinyMCE kullanırken şu hata mesajıyla karşılaşabilirsiniz:

> *"This domain is not registered in the TinyMCE Customer Portal. Please alert the admin to add it to the approved domains to continue using TinyMCE."*

Bu hata, TinyMCE’nin premium özelliklerini kullanabilmek için **API anahtarının** ve **domain adresinizin** kaydedilmesi gerektiğini belirtir.

---

## TinyMCE API Anahtarı Alma ve Tanımlama

### **1. TinyMCE API Anahtarı Alma**

1. **TinyMCE Resmi Sitesine Git:**
   - [https://www.tiny.cloud](https://www.tiny.cloud) adresine gidin.
2. **Üye Olun veya Giriş Yapın:**
   - Eğer hesabınız yoksa kaydolun, varsa giriş yapın.
3. **API Anahtarınızı Alın:**
   - Dashboard üzerinden **"Get API Key"** butonuna tıklayarak yeni bir API anahtarı oluşturun.

### **2. API Anahtarını TinyMCE Konfigürasyonuna Eklemek**

Aşağıdaki gibi TinyMCE yapılandırmanızda **API anahtarını** tanımlayın:

```html
<script src="https://cdn.tiny.cloud/1/YOUR_API_KEY/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
```

> **Not:** `YOUR_API_KEY` kısmını aldığınız API anahtarı ile değiştirin.

---

## TinyMCE İçin Domain Ekleme

### **1. Domain Kaydetme İşlemi**

1. **TinyMCE Dashboard’a Gidin:**
   - [https://www.tiny.cloud](https://www.tiny.cloud) adresinde oturum açın.
2. **API Key Sayfasına Girin:**
   - "API Keys" sekmesine tıklayın.
3. **Domain Ekleme Alanına Girin:**
   - "Add Domain" butonuna tıklayın.
   - TinyMCE’yi kullanacağınız **domain adresini (örneğin: example.com)** girin.
4. **Kaydı Tamamlayın:**
   - "Save" butonuna tıklayarak domain ekleme işlemini tamamlayın.

### **2. Alternatif Yöntem: API Key Olmadan Ücretsiz Kullanım**

TinyMCE’yi API anahtarı olmadan kullanmak için aşağıdaki gibi tanımlama yapabilirsiniz:

```html
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
```

Bu yöntem, TinyMCE’nin **ücretsiz sürümünü** kullanmanızı sağlar ancak bazı premium özelliklere erişemezsiniz.

---

TinyMCE’yi kullanırken domain kaydı yapmanız ve API anahtarınızı tanımlamanız gerekmektedir. Eğer premium özellikleri kullanmak istiyorsanız **API anahtarınızı eklemeli ve domain adresinizi kaydetmelisiniz.** Eğer sadece temel editör özelliklerini kullanacaksanız **"no-api-key"** seçeneğiyle devam edebilirsiniz.


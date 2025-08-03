# PHP MVC'de CustomerController Kullanımı

Bu dokümanda, bir PHP MVC projesinde `CustomerController`'ın nasıl çalıştığını, işlevlerini ve nasıl genişletilebileceğini inceleyeceğiz.

---

## 📌 CustomerController Nedir?
`CustomerController`, müşteri hesabı ile ilgili işlemleri yöneten bir denetleyicidir. Müşterinin giriş yaparak hesap bilgilerine erişmesini, siparişlerini görüntülemesini ve diğer işlemleri yapmasını sağlar.

Bu dokümanda aşağıdaki örnek `CustomerController` sınıfını inceleyeceğiz:

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;

class CustomerController extends BaseController
{
    /**
     * Müşteri ana sayfasını görüntüler.
     * 
     * @return void
     */
    public function index()
    {
        // Mevcut URL'yi alır
        $currentUrl = $_SERVER['REQUEST_URI'];

        // Görünümü render eder ve verileri gönderir
        $this->render('front/auth/customer', ['currentUrl' => $currentUrl]);
    }
}
```

---

## 📌 CustomerController Ne Yapar?
Bu denetleyici, müşteri panelinin ana sayfasını yükler ve belirli verileri görünüme (`view`) gönderir.

- `index()` metodu çağrıldığında, mevcut URL'yi alır ve `front/auth/customer` görünümünü (`view`) yükler.
- `BaseController` sınıfından türetilmiştir ve onun sağladığı `render()` metodunu kullanır.

---

## 📌 CustomerController Nasıl Genişletilir?

### 🛠️ Yeni Bir Metod Ekleme
Eğer müşteri bilgilerini getirmek istiyorsak, `index()` metodunu aşağıdaki gibi güncelleyebiliriz:

```php
public function index()
{
    // Mevcut URL'yi al
    $currentUrl = $_SERVER['REQUEST_URI'];

    // Kullanıcı bilgilerini al (Örnek olarak session'dan)
    $customer = isset($_SESSION['customer']) ? $_SESSION['customer'] : null;

    // Görünümü render et ve verileri gönder
    $this->render('front/auth/customer', [
        'currentUrl' => $currentUrl,
        'customer' => $customer
    ]);
}
```

Bu güncelleme ile artık müşteri bilgileri de görünüme (`view`) gönderilecektir.

---

## 📌 Controller'ın Route'a Eklenmesi
Bir `CustomerController`'ın çalışabilmesi için `routes.php` dosyanızda aşağıdaki gibi bir yönlendirme (`route`) tanımlanmalıdır:

```php
Route::add('customer', 'Front\CustomerController@index');
```

Bu tanımlama sayesinde, **`https://siteadresi.com/customer`** adresine girildiğinde `CustomerController` içindeki `index()` metodu çalıştırılacaktır.

---

## 📌 Görünüm (View) Dosyası
Denetleyici (`controller`) tarafından çağrılan `front/auth/customer.php` görünüm (`view`) dosyası aşağıdaki gibi olabilir:

```html
<div class="container">
    <h2>Müşteri Paneli</h2>
    <p>Şu an bulunduğunuz sayfa: <?php echo htmlspecialchars($currentUrl); ?></p>
    
    <?php if (isset($customer)): ?>
        <p>Merhaba, <?php echo htmlspecialchars($customer['name']); ?>!</p>
    <?php else: ?>
        <p>Lütfen giriş yapınız.</p>
    <?php endif; ?>
</div>
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;

class CustomerController extends BaseController
{
    /**
     * Müşteri ana sayfasını görüntüler.
     * 
     * @return void
     */
    public function index()
    {
        // Mevcut URL'yi alır
        $currentUrl = $_SERVER['REQUEST_URI'];

        // Görünümü render eder ve verileri gönderir
        $this->render('front/auth/customer', ['currentUrl' => $currentUrl]);
    }
}

```
---


## 📌 Sonuç
Bu dokümanda `CustomerController`'ın nasıl çalıştığını, hangi verileri yönettiğini ve nasıl genişletilebileceğini öğrendik.

✅ `CustomerController`'ı kullanarak müşteri hesabı ile ilgili sayfaları yönetebiliriz.
✅ **Yeni özellikler ekleyerek müşteri panelini geliştirebiliriz!** 🚀

Bu kontrolörün daha gelişmiş kullanımları için **veritabanı bağlantısı, müşteri doğrulaması ve daha fazla özelliğin entegre edilmesi** gerekebilir. Bir sonraki adım olarak `CustomerModel` oluşturarak müşteri bilgilerini veritabanından çekmeyi deneyebilirsiniz! 🎯
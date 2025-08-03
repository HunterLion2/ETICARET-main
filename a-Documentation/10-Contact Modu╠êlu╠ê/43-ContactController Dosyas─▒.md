# İletişim Modülü - ContactController

Bu eğitim dokümanı, **ContactController** sınıfının nasıl çalıştığını ve iletişim formu işlemlerinin nasıl gerçekleştirildiğini açıklamaktadır.

---

## 1. ContactController Nedir?

`ContactController`, kullanıcılardan gelen iletişim formu verilerini işleyen bir sınıftır. Kullanıcılar iletişim formunu doldurup gönderdiklerinde, bu sınıf form verilerini doğrular ve e-posta olarak iletmeye çalışır.

---

## 2. ContactController Yapısı

```php
namespace App\Controllers\Front;

use App\Core\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use App\Helpers\Mailer;
```

- **`BaseController`**: Ana controller sınıfından türetilmiştir.
- **`PHPMailer`**: E-posta gönderimi için kullanılan kütüphane.
- **`Mailer`**: E-posta işlemlerini yöneten yardımcı sınıf.

---

## 3. Yapıcı Metot (`__construct`)

```php
public function __construct()
{
    parent::__construct(); // Üst sınıfın constructor'ını çağır
}
```

Yapıcı metot, `BaseController` sınıfının `__construct` metodu çağırarak temel işlevselliği devralır.

---

## 4. İletişim Formu Sayfasını Gösterme

```php
public function index()
{
    $this->render('front/contact');
}
```

- Kullanıcılar `/contact` adresine gittiğinde, **`contact.php`** şablonu çağrılır ve iletişim formu görüntülenir.

---

## 5. İletişim Formu Gönderme İşlemi

```php
public function sendContactForm()
```

Bu metot, formdan gelen verileri işler ve e-posta olarak gönderir.

### **A. Form Verilerini Alma ve Doğrulama**

```php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $message = trim($_POST['message']);

    $errors = [];
```
- **`$_POST` verileri temizlenerek** gereksiz boşluklar kaldırılır.
- **Doğrulama işlemi gerçekleştirilir**:
  - Ad boş olamaz.
  - Geçerli bir e-posta adresi girilmiş olmalı.
  - Mesaj alanı boş olamaz.

```php
if (empty($name)) {
    $errors[] = "İsim alanı boş olamaz.";
}
if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Geçerli bir e-posta adresi giriniz.";
}
if (empty($message)) {
    $errors[] = "Mesaj alanı boş olamaz.";
}
```

**Hata varsa** form tekrar gösterilir:

```php
if (!empty($errors)) {
    $this->render('front/contact', ['error' => implode('<br>', $errors)]);
    return;
}
```

---

### **B. Mail Gönderme**

Eğer hata yoksa e-posta gönderimi başlatılır.

```php
$mailer = new Mailer(new PHPMailer(true));
$subject = "Yeni İletişim Formu Mesajı";
$body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
        </style>
    </head>
    <body>
        <h2>Yeni İletişim Formu Mesajı</h2>
        <p><strong>Ad:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Mesaj:</strong> $message</p>
    </body>
    </html>
";
```

E-posta, sistemin belirlenen adresine gönderilir:

```php
$result = $mailer->sendMail('info@emrahyuksel.com.tr', $subject, $body);
```

- **Eğer e-posta başarılı gönderildiyse**, bir başarı mesajı döndürülür.
- **Eğer başarısız olursa**, hata mesajı ile form tekrar gösterilir.

```php
if ($result === true) {
    $this->render('front/contact', ['success' => "Mesajınız başarıyla gönderildi."]);
} else {
    $this->render('front/contact', ['error' => $result]);
}
```

---

## 6. Kullanıcıyı Yönlendirme

Eğer `POST` isteği değilse, doğrudan `/contact` sayfasına yönlendirme yapılır:

```php
else {
    header('Location: /contact');
    exit();
}
```

---

## 7. Sonuç

- **İletişim formu**, `ContactController` üzerinden işlenir.
- **Veri doğrulama** işlemi ile hatalı girişler engellenir.
- **PHPMailer** kullanılarak e-posta gönderilir.
- **Başarılı veya başarısız işlem sonucuna göre** kullanıcıya bilgi verilir.

---

**Not:** Eğer e-posta gönderimi çalışmıyorsa:
- `PHPMailer` kütüphanesinin kurulu olduğundan emin olun.
- SMTP ayarlarını doğru yapılandırın.
- `Mailer` sınıfında hata ayıklama (`debug mode`) açılarak hata detaylarını kontrol edin.

---
```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use PHPMailer\PHPMailer\PHPMailer;
use App\Helpers\Mailer;

class ContactController extends BaseController
{
    /**
     * ContactController constructor.
     * Üst sınıfın constructor'ını çağırır.
     */
    public function __construct()
    {
        parent::__construct(); // Üst sınıfın constructor'ını çağır
    }

    /**
     * İletişim formu sayfasını render eder.
     *
     * @return void
     */
    public function index()
    {
        $this->render('front/contact');
    }

    /**
     * İletişim formu gönderimini işler.
     *
     * @return void
     */
    public function sendContactForm()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $message = trim($_POST['message']);

            $errors = [];

            // Temel doğrulamalar
            if (empty($name)) {
                $errors[] = "İsim alanı boş olamaz.";
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Geçerli bir e-posta adresi giriniz.";
            }

            if (empty($message)) {
                $errors[] = "Mesaj alanı boş olamaz.";
            }

            if (!empty($errors)) {
                $this->render('front/contact', ['error' => implode('<br>', $errors)]);
                return;
            }

            $mailer = new Mailer(new PHPMailer(true));
            $subject = "Yeni İletişim Formu Mesajı";
            $body = "
                <html>
                <head>
                    <style>
                        body { font-family: Arial, sans-serif; }
                        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; }
                        .header { background-color: #f7f7f7; padding: 10px; text-align: center; border-bottom: 1px solid #ddd; }
                        .content { padding: 20px; }
                        .footer { background-color: #f7f7f7; padding: 10px; text-align: center; border-top: 1px solid #ddd; }
                        .footer p { margin: 0; }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h2>Yeni İletişim Formu Mesajı</h2>
                        </div>
                        <div class='content'>
                            <p><strong>Ad:</strong> $name</p>
                            <p><strong>Email:</strong> $email</p>
                            <p><strong>Mesaj:</strong></p>
                            <p>$message</p>
                        </div>
                        <div class='footer'>
                            <p>Bu mesaj EticaretV5 sistemi tarafından gönderilmiştir.</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

            $result = $mailer->sendMail('info@emrahyuksel.com.tr', $subject, $body);

            if ($result === true) {
                $this->render('front/contact', ['success' => "Mesajınız başarıyla gönderildi."]);
            } else {
                $this->render('front/contact', ['error' => $result]);
            }
        } else {
            header('Location: /contact');
            exit();
        }
    }
}

```
---

Bu doküman ile **İletişim Modülü**'nü detaylı bir şekilde öğrendiniz! 🎉


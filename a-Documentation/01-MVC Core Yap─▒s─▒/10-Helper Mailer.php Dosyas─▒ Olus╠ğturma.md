# PHP Mailer Kullanımı ve Yapılandırması

Bu dokümanda, **PHPMailer** kütüphanesini kullanarak SMTP üzerinden e-posta gönderme işlemlerini nasıl gerçekleştireceğinizi adım adım açıklayacağız.

---

## 1. PHPMailer Kurulumu

Öncelikle **PHPMailer** kütüphanesini projemize dahil etmemiz gerekiyor. Eğer Composer kullanıyorsanız, aşağıdaki komutu çalıştırarak yükleyebilirsiniz:

```sh
composer require phpmailer/phpmailer
```

Eğer Composer kullanmıyorsanız, PHPMailer'ı manuel olarak [resmi GitHub deposundan](https://github.com/PHPMailer/PHPMailer) indirebilir ve projenize ekleyebilirsiniz.

---

## 2. Mailer Helper Sınıfı Oluşturma

Aşağıda **Mailer** adında bir yardımcı sınıf oluşturduk. Bu sınıf, PHPMailer'ı yapılandırarak e-posta gönderme işlemlerini kolaylaştırır.

### **Mailer.php**

```php
<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Core\Config;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        $this->mail->isSMTP();
        $this->mail->Host = Config::get('MAIL_HOST'); // SMTP sunucunuz
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Config::get('MAIL_USERNAME'); // SMTP kullanıcı adı
        $this->mail->Password = Config::get('MAIL_PASSWORD'); // SMTP şifresi
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = Config::get('MAIL_PORT');
        $this->mail->setFrom(Config::get('MAIL_FROM_ADDRESS'), Config::get('MAIL_FROM_NAME')); // Gönderen e-posta adresi
        $this->mail->CharSet = 'UTF-8'; // Karakter seti

        // Sertifika doğrulamasını devre dışı bırak
        $this->mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }

    public function sendMail($to, $subject, $body)
    {
        try {
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
```

---

## 3. Kullanım Örneği

Yukarıda oluşturduğumuz `Mailer` sınıfını aşağıdaki gibi kullanabilirsiniz:

```php
require_once 'vendor/autoload.php';
use App\Helpers\Mailer;

$mailer = new Mailer();

$to = "ornek@example.com";
$subject = "Test E-postası";
$body = "<h1>Merhaba!</h1><p>Bu bir test e-postasıdır.</p>";

$result = $mailer->sendMail($to, $subject, $body);

if ($result === true) {
    echo "E-posta başarıyla gönderildi!";
} else {
    echo "E-posta gönderilirken hata oluştu: " . $result;
}
```

---

## 4. .env Konfigürasyonu

Eğer ortam değişkenleri kullanıyorsanız, aşağıdaki gibi bir `.env` dosyası oluşturabilirsiniz:

```ini
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=ornek@gmail.com
MAIL_PASSWORD=sifre
MAIL_FROM_ADDRESS=ornek@gmail.com
MAIL_FROM_NAME="Gönderen Adı"
```

Ve bu değerleri `Config` sınıfı ile çağırabilirsiniz:

```php
class Config
{
    public static function get($key)
    {
        return $_ENV[$key] ?? null;
    }
}
```

---
## 📌 **Tam Kod**

```php
<?php

namespace App\Helpers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Core\Config;

class Mailer
{
    private $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->setup();
    }

    private function setup()
    {
        $this->mail->isSMTP();
        $this->mail->Host = Config::get('MAIL_HOST'); // SMTP sunucunuz
        $this->mail->SMTPAuth = true;
        $this->mail->Username = Config::get('MAIL_USERNAME'); // SMTP kullanıcı adı
        $this->mail->Password = Config::get('MAIL_PASSWORD'); // SMTP şifresi
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port = Config::get('MAIL_PORT');
        $this->mail->setFrom(Config::get('MAIL_FROM_ADDRESS'), Config::get('MAIL_FROM_NAME')); // Gönderen e-posta adresi
        $this->mail->CharSet = 'UTF-8'; // Karakter seti

        // Sertifika doğrulamasını devre dışı bırak
        $this->mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];
    }

    public function sendMail($to, $subject, $body)
    {
        try {
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;
            $this->mail->send();
            return true;
        } catch (Exception $e) {
            return "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}

```
---

## 5. Olası Hata ve Çözümleri

| Hata | Çözüm |
|-------|--------|
| SMTP Bağlantı Hatası | Kullanıcı adı, şifre ve sunucu bilgilerini kontrol edin. |
| TLS/SSL Hatası | `$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;` yerine `PHPMailer::ENCRYPTION_SMTPS;` deneyin. |
| Google SMTP Kullanımı | Gmail SMTP kullanıyorsanız, "Daha az güvenli uygulamaları etkinleştirin" ayarını açmanız gerekebilir. |

---

Bu dokümanda, PHPMailer kullanarak SMTP üzerinden e-posta göndermeyi adım adım öğrendik. Şimdi bu bilgileri kendi projelerinizde uygulayabilirsiniz! 🎯
# 🛡️ AuthMiddleware Kullanımı

Bu Markdown dokümanı, `AuthMiddleware` sınıfının nasıl çalıştığını ve projede nasıl kullanılacağını adım adım açıklamaktadır.

---

## 📌 `AuthMiddleware` Nedir?
`AuthMiddleware` sınıfı, kullanıcı oturumlarını kontrol eden ve yetkilendirme işlemlerini gerçekleştiren bir ara katman yazılımıdır. Bu middleware, belirli sayfalara yetkisiz erişimi engelleyerek kullanıcıları oturum açmaya zorlar.

---

## 🏗️ `AuthMiddleware` Nasıl Çalışır?

`AuthMiddleware`, gelen HTTP isteğini kontrol ederek, kullanıcının oturumunun olup olmadığını denetler. Eğer oturum yoksa, kullanıcıyı `/login` sayfasına yönlendirir. Bu işlem aşağıdaki adımlarla gerçekleştirilir:

1. **Oturum Durumu Kontrol Edilir**
   - `session_status()` fonksiyonu kullanılarak, bir oturumun başlatılıp başlatılmadığı kontrol edilir.
   - Eğer oturum başlatılmamışsa `session_start()` ile oturum başlatılır.

2. **Kullanıcının Giriş Yapıp Yapmadığı Kontrol Edilir**
   - `$_SESSION['user_id']` değişkeni kullanılarak, kullanıcının oturum açıp açmadığı kontrol edilir.
   - Eğer oturum açmamışsa, kullanıcı `/login` sayfasına yönlendirilir.

---


## 🚀 `AuthMiddleware` Kullanımı

Bu middleware, rota tanımlamaları sırasında belirli sayfalara erişimi sınırlamak için kullanılır. Örneğin, kullanıcı yalnızca oturum açmışsa aşağıdaki rotalara erişebilir:

```php
use App\Middleware\AuthMiddleware;
use App\Core\Route;

Route::add('dashboard', 'Admin\DashboardController@index')->middleware(AuthMiddleware::class);
Route::add('profile', 'User\ProfileController@index')->middleware(AuthMiddleware::class);
```

Bu kod, kullanıcının **`dashboard`** ve **`profile`** sayfalarına erişmeden önce giriş yapmasını zorunlu kılar. Eğer kullanıcı giriş yapmamışsa `/login` sayfasına yönlendirilir.

---

## 📌 **Tam Kod**

```php
<?php

namespace App\Middleware;
 
class AuthMiddleware
{
    /**
     * İstekleri ele alır ve kullanıcı oturumunu kontrol eder.
     * Eğer oturum yoksa, kullanıcıyı giriş sayfasına yönlendirir.
     */
    public function handle()
    {
        // Oturum başlatılmamışsa oturumu başlat
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Kullanıcı oturumu yoksa giriş sayfasına yönlendir
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit();
        }
    }
}


```

## ✅ Sonuç
Bu dokümanda, `AuthMiddleware` sınıfının nasıl çalıştığını ve projede nasıl kullanılacağını öğrendik. Middleware kullanarak, belirli sayfalara yetkisiz erişimi engelleyebilir ve güvenliği artırabilirsiniz.

📌 **Öğrenciler için not:** Yukarıdaki kodu `app/Middleware/AuthMiddleware.php` dosyasına ekleyerek projenizde kullanabilirsiniz.

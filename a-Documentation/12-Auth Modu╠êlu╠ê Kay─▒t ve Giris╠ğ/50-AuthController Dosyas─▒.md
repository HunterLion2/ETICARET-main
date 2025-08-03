# **Kullanıcı Yetkilendirme Kontrolleri: AuthController**

Bu doküman, **AuthController** sınıfının yapısını ve kullanıcı yetkilendirme işlemlerini nasıl gerçekleştirdiğini anlatmaktadır.

---

## **AuthController Nedir?**

**AuthController**, kullanıcı oturum açma, kayıt olma, şifre güncelleme ve çıkış yapma gibi yetkilendirme işlemlerini yöneten bir kontrolcü sınıftır.

Bu sınıf, **BaseController**'dan türetilmiştir ve **AuthModel** sınıfını kullanarak veritabanı üzerinde yetkilendirme işlemlerini gerçekleştirir.

---

## **Dosyanın Konumu**

Bu dosya projenin **App/Controllers/Front/** dizininde bulunmaktadır.

---

## **AuthController Yapısı**

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\AuthModel;

class AuthController extends BaseController
{
    /**
     * Model örneği için sınıf değişkeni
     *
     * @var AuthModel
     */
    private $authModel;

    /**
     * Yapıcı metod
     */
    public function __construct()
    {
        parent::__construct();
        $this->authModel = new AuthModel();
    }

    public function index() {}

    public function login()
    {
        $this->render('front/login');
    }

    public function register()
    {
        $this->render('front/register');
    }

    public function profile()
    {
        $this->renderAdmin('admin/users/profil');
    }

    public function registerSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $phone = trim($_POST['phone']);

            $errors = [];

            if (empty($name)) {
                $errors[] = "İsim alanı boş olamaz.";
            }
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Geçerli bir e-posta adresi giriniz.";
            }
            if (empty($password) || strlen($password) < 6) {
                $errors[] = "Şifre en az 6 karakter olmalıdır.";
            }
            if (empty($phone) || !preg_match('/^0\d{10}$/', $phone)) {
                $errors[] = "Telefon numarası 0 ile başlamalı ve 11 haneli olmalıdır.";
            }

            if (!empty($errors)) {
                $this->render('front/register', ['error' => implode('<br>', $errors)]);
                return;
            }

            $existingUser = $this->authModel->getUserByEmail($email);
            if ($existingUser) {
                $error = "Bu e-posta adresi zaten kullanılıyor.";
                $this->render('front/register', ['error' => $error]);
                return;
            }

            $isRegistered = $this->authModel->registerUser($name, $email, $password, $phone);

            if ($isRegistered) {
                $success = "Kayıt başarılı! <a href='/login'>Giriş yap</a>";
                $this->render('front/register', ['success' => $success]);
            } else {
                $error = "Kayıt sırasında hata oluştu.";
                $this->render('front/register', ['error' => $error]);
            }
        } else {
            header('Location: /register');
            exit;
        }
    }
}
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\AuthModel;

class AuthController extends BaseController
{
    /** 
     * Model örneği için sınıf değişkeni
     *
     * @var AuthModel
     */
    private $authModel;

    /**
     * Yapıcı metod
     */
    public function __construct()
    {
        parent::__construct();
        $this->authModel = new AuthModel();
    }

    public function index() {}

    public function login()
    {
        // Oturum kontrolü yapmadan login sayfasını render et
        $this->render('front/login');
    }

    public function register()
    {
        // Verileri view'a gönder
        $this->render('front/register');
    }

    public function profile()
    {
        // Verileri view'a gönder
        $this->renderAdmin('admin/users/profil');
    }

    public function registerSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);
            $phone = trim($_POST['phone']);

            $errors = [];

            // Temel doğrulamalar
            if (empty($name)) {
                $errors[] = "İsim alanı boş olamaz.";
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Geçerli bir e-posta adresi giriniz.";
            }

            if (empty($password) || strlen($password) < 6) {
                $errors[] = "Şifre en az 6 karakter uzunluğunda olmalıdır.";
            }

            // Telefon numarası doğrulaması
            if (empty($phone) || !preg_match('/^0\d{10}$/', $phone)) {
                $errors[] = "Telefon numarası 0 ile başlamalı ve 11 karakter uzunluğunda olmalıdır.";
            }

            // Hatalar varsa, hata mesajlarını view'a gönder
            if (!empty($errors)) {
                $this->render('front/register', ['error' => implode('<br>', $errors)]);
                return;
            }

            // E-posta adresi zaten kullanılıyor mu kontrol et
            $existingUser = $this->authModel->getUserByEmail($email);

            if ($existingUser) {
                $error = "Bu e-posta adresi zaten kullanılıyor.";
                $this->render('front/register', ['error' => $error]);
                return;
            }

            // Kullanıcıyı kaydet
            $isRegistered = $this->authModel->registerUser($name, $email, $password, $phone);

            if ($isRegistered) {
                $success = "Kayıt işlemi başarıyla tamamlandı.<br> <a href='/login'>Giriş yap</a>";
                $this->render('front/register', ['success' => $success]);
            } else {
                $error = "Kayıt işlemi sırasında bir hata oluştu.";
                $this->render('front/register', ['error' => $error]);
            }
        } else {
            header('Location: /register');
            exit;
        }
    }

    public function loginSubmit()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            // Kullanıcıyı giriş yap
            $user = $this->authModel->loginUser($email, $password);

            if ($user) {
                // Kullanıcı oturumunu başlat
                session_start();
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_role'] = $user['role'];

                // Kullanıcı rolüne göre yönlendir
                if ($user['role'] === 'admin') {
                    header('Location: /admin');
                } else {
                    header('Location: /');
                }
                exit;
            } else {
                $error = "Geçersiz e-posta adresi veya şifre.";
                $this->render('front/login', ['error' => $error]);
            }
        } else {
            header('Location: /login');
            exit;
        }
    }

    public function logout()
    {
        // Oturumu sonlandır
        session_start();
        session_unset();
        session_destroy();
        header('Location: /login');
        exit;
    }

    public function updatePassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userId = $this->userId;
            $currentPassword = trim($_POST['current_password']);
            $newPassword = trim($_POST['new_password']);
            $confirmPassword = trim($_POST['confirm_password']);

            // Kullanıcıyı al
            $user = $this->authModel->getUserById($userId);

            // Mevcut şifreyi doğrula
            if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
                $error = "Mevcut şifre yanlış.";
                $this->renderAdmin('admin/users/profil', ['error' => $error]);
                return;
            }

            // Yeni şifreler eşleşiyor mu kontrol et
            if ($newPassword !== $confirmPassword) {
                $error = "Yeni şifreler eşleşmiyor.";
                $this->renderAdmin('admin/users/profil', ['error' => $error]);
                return;
            }

            // Yeni şifre uzunluğunu kontrol et
            if (strlen($newPassword) < 6) {
                $error = "Yeni şifre en az 6 karakter uzunluğunda olmalıdır.";
                $this->renderAdmin('admin/users/profil', ['error' => $error]);
                return;
            }

            // Şifreyi güncelle
            $isUpdated = $this->authModel->updatePassword($userId, $newPassword);

            if ($isUpdated) {
                $success = "Şifre başarıyla güncellendi.";
                $this->renderAdmin('admin/users/profil', ['success' => $success]);
            } else {
                $error = "Şifre güncellenirken bir hata oluştu.";
                $this->renderAdmin('admin/users/profil', ['error' => $error]);
            }
        } else {
            header('Location: /admin/users/profil');
            exit;
        }
    }

    public function updatePasswordFront()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $userId = $this->userId;
            $currentPassword = trim($_POST['current_password']);
            $newPassword = trim($_POST['new_password']);
            $confirmPassword = trim($_POST['confirm_password']);

            // Kullanıcıyı al
            $user = $this->authModel->getUserById($userId);

            // Mevcut şifreyi doğrula
            if (!$user || !password_verify($currentPassword, $user['password_hash'])) {
                $error = "Mevcut şifre yanlış.";
                $this->render('front/auth/customer', ['error' => $error]);
                return;
            }

            // Yeni şifreler eşleşiyor mu kontrol et
            if ($newPassword !== $confirmPassword) {
                $error = "Yeni şifreler eşleşmiyor.";
                $this->render('front/auth/customer', ['error' => $error]);
                return;
            }

            // Yeni şifre uzunluğunu kontrol et
            if (strlen($newPassword) < 6) {
                $error = "Yeni şifre en az 6 karakter uzunluğunda olmalıdır.";
                $this->render('front/auth/customer', ['error' => $error]);
                return;
            }

            // Şifreyi güncelle
            $isUpdated = $this->authModel->updatePassword($userId, $newPassword);

            if ($isUpdated) {
                $success = "Şifre başarıyla güncellendi.";
                $this->render('front/auth/customer', ['success' => $success]);
            } else {
                $error = "Şifre güncellenirken bir hata oluştu.";
                $this->render('front/auth/customer', ['error' => $error]);
            }
        } else {
            header('Location: /customer');
            exit;
        }
    }
}

```
---

## **AuthController Metodları**

- **login()**: Kullanıcının giriş yapma sayfasını render eder.
- **register()**: Kullanıcı kayıt sayfasını render eder.
- **profile()**: Kullanıcı profiline ait sayfayı render eder.
- **registerSubmit()**: Kullanıcı kayıt işlemini gerçekleştirir.

---

## **Sonuç**

Bu dokümanda **AuthController** sınıfının temel yapısını ve kullanıcı oturum açma, kaydolma gibi işlemleri nasıl yönettiğini inceledik. Kullanıcı yetkilendirme sürecinin doğru çalışması için veritabanınızda **users** tablosunun ve **AuthModel** sınıfının da eksiksiz olması gerekmektedir.


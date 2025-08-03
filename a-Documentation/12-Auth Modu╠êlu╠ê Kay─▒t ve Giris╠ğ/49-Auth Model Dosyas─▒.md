# Kullanıcı Kimlik Doğrulama ve Yetkilendirme Modeli (AuthModel)

Bu doküman, **AuthModel** sınıfının nasıl kullanıldığını ve ne gibi işlevler sunduğunu açıklamaktadır. Bu model, kullanıcı kaydı, girişi, şifre güncelleme ve kullanıcı bilgilerini alma gibi kimlik doğrulama işlemlerini yönetmek için kullanılır.

## **1. Genel Bakış**

**AuthModel** sınıfı, `users` tablosu üzerinde işlem yaparak, kullanıcı kimlik doğrulama ve yetkilendirme fonksiyonlarını gerçekleştirir.

**Sunduğu özellikler:**
- Yeni kullanıcı kaydı
- Kullanıcı girişi
- Kullanıcı bilgilerini alma
- Şifre güncelleme

## **2. Sınıf Yapısı ve Kullanımı**

### **2.1. Sınıf Tanımı ve Veritabanı Bağlantısı**
```php
namespace App\Models;

use App\Core\Database;

/**
 * AuthModel sınıfı, kullanıcı kimlik doğrulama işlemlerini gerçekleştirir.
 */
class AuthModel
{
    /**
     * @var \PDO Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * AuthModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }
}
```

## **3. Metotlar ve Kullanımı**

### **3.1. Kullanıcı Kaydı**
Bu metod, yeni bir kullanıcı kaydı oluşturur.

```php
public function registerUser($name, $email, $password, $phone)
{
    $stmt = $this->db->prepare("INSERT INTO users (name, email, password_hash, phone_number, role) VALUES (:name, :email, :password_hash, :phone_number, :role)");
    $passwordHash = password_hash($password, PASSWORD_BCRYPT);
    return $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':password_hash' => $passwordHash,
        ':phone_number' => $phone,
        ':role' => 'customer' // Varsayılan rol
    ]);
}
```

**Kullanımı:**
```php
$authModel = new AuthModel();
$authModel->registerUser('Ali Veli', 'ali@example.com', 'sifre123', '05551234567');
```

---

### **3.2. Kullanıcı Bilgisi Getirme (E-Posta ile)**
Bu metod, e-posta adresine göre kullanıcı bilgilerini getirir.
```php
public function getUserByEmail($email)
{
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
```

**Kullanımı:**
```php
$authModel = new AuthModel();
$user = $authModel->getUserByEmail('ali@example.com');
print_r($user);
```

---

### **3.3. Kullanıcı Girişi**
Bu metod, kullanıcının giriş yapabilmesi için e-posta ve şifreyi kontrol eder.

```php
public function loginUser($email, $password)
{
    $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(\PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        return $user;
    }
    return false;
}
```

**Kullanımı:**
```php
$authModel = new AuthModel();
$user = $authModel->loginUser('ali@example.com', 'sifre123');
if ($user) {
    echo "Giriş başarılı";
} else {
    echo "Hatalı giriş";
}
```

---

### **3.4. Kullanıcı Şifresini Güncelleme**
Bu metod, kullanıcının şifresini günceller.

```php
public function updatePassword($userId, $newPassword)
{
    $stmt = $this->db->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :id");
    $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
    return $stmt->execute([
        ':password_hash' => $passwordHash,
        ':id' => $userId
    ]);
}
```

**Kullanımı:**
```php
$authModel = new AuthModel();
$authModel->updatePassword(1, 'yeniSifre123');
```

---

### **3.5. Kullanıcı Bilgisi Getirme (ID ile)**
Bu metod, kullanıcının ID'sine göre bilgilerini getirir.
```php
public function getUserById($userId)
{
    $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
    $stmt->execute([':id' => $userId]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
```

**Kullanımı:**
```php
$authModel = new AuthModel();
$user = $authModel->getUserById(1);
print_r($user);
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * AuthModel sınıfı, kullanıcı kimlik doğrulama işlemleri için gerekli olan
 * veritabanı işlemlerini gerçekleştiren sınıftır.
 */
class AuthModel
{
    /**
     * @var \PDO Veritabanı bağlantısı
     */
    private $db;

    /**
     * AuthModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Yeni bir kullanıcı kaydı oluşturur.
     *
     * @param string $name Kullanıcı adı
     * @param string $email Kullanıcı e-posta adresi
     * @param string $password Kullanıcı şifresi
     * @param string $phone Kullanıcı telefon numarası
     * @return bool Kayıt işleminin başarılı olup olmadığını belirtir
     */
    public function registerUser($name, $email, $password, $phone)
    {
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password_hash, phone_number, role) VALUES (:name, :email, :password_hash, :phone_number, :role)");
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password_hash' => $passwordHash,
            ':phone_number' => $phone,
            ':role' => 'customer' // Varsayılan rol
        ]);
    }

    /**
     * E-posta adresine göre kullanıcı bilgilerini getirir.
     *
     * @param string $email Kullanıcı e-posta adresi
     * @return array|false Kullanıcı bilgileri veya başarısızlık durumunda false
     */
    public function getUserByEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Kullanıcı giriş işlemini gerçekleştirir.
     *
     * @param string $email Kullanıcı e-posta adresi
     * @param string $password Kullanıcı şifresi
     * @return array|false Kullanıcı bilgileri veya başarısızlık durumunda false
     */
    public function loginUser($email, $password)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password_hash'])) {
            return $user;
        }

        return false;
    }

    /**
     * Kullanıcı şifresini günceller.
     *
     * @param int $userId Kullanıcı ID'si
     * @param string $newPassword Yeni şifre
     * @return bool Güncelleme işleminin başarılı olup olmadığını belirtir
     */
    public function updatePassword($userId, $newPassword)
    {
        $stmt = $this->db->prepare("UPDATE users SET password_hash = :password_hash WHERE id = :id");
        $passwordHash = password_hash($newPassword, PASSWORD_BCRYPT);
        return $stmt->execute([
            ':password_hash' => $passwordHash,
            ':id' => $userId
        ]);
    }

    /**
     * Kullanıcı ID'sine göre kullanıcı bilgilerini getirir.
     *
     * @param int $userId Kullanıcı ID'si
     * @return array|false Kullanıcı bilgileri veya başarısızlık durumunda false
     */
    public function getUserById($userId)
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([':id' => $userId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}

```
---

## **Sonuç**
Bu dokümanda, **AuthModel** sınıfının temel işlevleri ve kullanım senaryoları anlatılmıştır. Bu model, kimlik doğrulama sürecinde kritik bir rol oynar ve güvenli bir oturum yönetimi sağlar.


# PHP E-Ticaret Projesi: CartController Sınıfı

Bu dokümanda, **CartController** sınıfının ne işe yaradığını, hangi metodlara sahip olduğunu ve bu metodların nasıl kullanıldığını açıklayacağız.

---

## 1. CartController Sınıfı Nedir?

CartController sınıfı, kullanıcıların sepetlerini yönetmek için oluşturulmuş bir kontrolördür. Bu sınıf **sepete ürün ekleme, ürün silme, miktar güncelleme ve sepeti listeleme** gibi işlemleri gerçekleştirir.

---

## 2. Sınıf Tanımı

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\CartModel;

class CartController extends BaseController
{
    /**
     * @var CartModel $cartModel Sepet modeli örneği
     */
    private $cartModel;

    /**
     * CartController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve CartModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();
    }
```

---

## 3. Metodlar

### **a) Sepet Sayfasını Görüntüleme**

Bu metod, kullanıcının oturumunu kontrol eder ve sepetteki ürünleri getirir.

```php
public function index()
{
    $userId = $_SESSION['user_id'] ?? null;

    if ($userId) {
        $cartItems = $this->cartModel->getCartItemsByUserId($userId);
    } else {
        $cartItems = [];
    }

    $this->render('front/cart/index', [
        'cartItems' => $cartItems
    ]);
}
```

### **b) Sepete Ürün Ekleme**

Bu metod, form verileriyle **kullanıcı ID ve ürün ID** alarak sepete ürün ekler.

```php
public function addToCart()
{
    $userId = $_SESSION['user_id'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['product_id'] ?? null;
        $quantity = $_POST['quantity'] ?? 1;

        if ($userId && $productId) {
            $this->cartModel->addToCart($userId, $productId, $quantity);
            header('Location: /cart');
        } else {
            echo "Gerekli veriler eksik.";
        }
    }
}
```

### **c) Sepetten Ürün Çıkarma**

```php
public function removeFromCart()
{
    $userId = $_SESSION['user_id'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['product_id'] ?? null;

        if ($userId && $productId) {
            $this->cartModel->removeFromCart($userId, $productId);
            header('Location: /cart');
        } else {
            echo "Gerekli veriler eksik.";
        }
    }
}
```

### **d) Sepetteki Ürün Miktarını Artırma**

```php
public function increaseQuantity()
{
    $userId = $_SESSION['user_id'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['product_id'] ?? null;

        if ($userId && $productId) {
            $this->cartModel->increaseQuantity($userId, $productId);
            header('Location: /cart');
        } else {
            echo "Gerekli veriler eksik.";
        }
    }
}
```

### **e) Sepetteki Ürün Miktarını Azaltma**

```php
public function decreaseQuantity()
{
    $userId = $_SESSION['user_id'] ?? null;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $productId = $_POST['product_id'] ?? null;

        if ($userId && $productId) {
            $this->cartModel->decreaseQuantity($userId, $productId);
            header('Location: /cart');
        } else {
            echo "Gerekli veriler eksik.";
        }
    }
}
```

---

## 4. Kullanım Senaryosu

Bu metodlar bir **view dosyasından gelen POST istekleri** ile aşağıdaki gibi çalıştırılabilir:

```html
<form action="/cart/addToCart" method="post">
    <input type="hidden" name="product_id" value="1">
    <input type="hidden" name="quantity" value="1">
    <button type="submit">Sepete Ekle</button>
</form>
```

---

## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\CartModel;

class CartController extends BaseController
{
    /**
     * @var CartModel $cartModel Sepet modeli örneği
     */
    private $cartModel;

    /**
     * CartController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve CartModel örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->cartModel = new CartModel();
    }

    /**
     * Sepet sayfasını görüntüler.
     */
    public function index()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($userId) {
            $cartItems = $this->cartModel->getCartItemsByUserId($userId);
        } else {
            $cartItems = [];
        }

        // Verileri view'a gönder
        $this->render('front/cart/index', [
            'cartItems' => $cartItems
        ]);
    }

    /**
     * Sepete ürün ekler.
     */
    public function addToCart()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;
            $quantity = $_POST['quantity'] ?? 1; // Varsayılan olarak 1

            if ($userId && $productId) {
                $this->cartModel->addToCart($userId, $productId, $quantity);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }

    /**
     * Sepetten ürün çıkarır.
     */
    public function removeFromCart()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;

            if ($userId && $productId) {
                $this->cartModel->removeFromCart($userId, $productId);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }

    /**
     * Sepetteki ürün miktarını artırır.
     */
    public function increaseQuantity()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;

            if ($userId && $productId) {
                $this->cartModel->increaseQuantity($userId, $productId);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }

    /**
     * Sepetteki ürün miktarını azaltır.
     */
    public function decreaseQuantity()
    {
        $userId = $_SESSION['user_id'] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $productId = $_POST['product_id'] ?? null;

            if ($userId && $productId) {
                $this->cartModel->decreaseQuantity($userId, $productId);
                header('Location: /cart');
            } else {
                // Hata durumunu ele al
                echo "Gerekli veriler eksik.";
            }
        }
    }
}

```
---

## 5. Sonuç

Bu **CartController** sınıfı, e-ticaret sistemlerindeki **sepet** yönetimini kolaylaştırır.

Eğer **sepette eklemeler yapma, ürün çıkarma ve miktar güncelleme** gibi işlemler yapmak istiyorsanız, yukarıdaki metodları kullanabilirsiniz.

**Geliştirme Tavsiyeleri:**
- Sepette **stok kontrolü** eklenebilir.
- Kullanıcı bazlı özel **indirimler** uygulanabilir.

Bu döküman, CartController sınıfını anlamanız ve projelerinize entegre etmeniz için hazırlanmıştır.


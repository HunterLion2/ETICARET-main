# BuyController Kullanım Kılavuzu

## Giriş
BuyController, e-ticaret platformlarında ödeme süreçlerini yönetmek için kullanılan bir PHP sınıfıdır. Iyzico ödeme altyapısını entegre ederek, kullanıcıların sepetlerindeki ürünleri satın almalarını sağlar. Bu doküman, sınıfın nasıl çalıştığını, temel işlevlerini ve kullanım senaryolarını açıklar.

---

## 1. Sınıf Tanıtımı
BuyController sınıfı, ödeme işlemlerini yönetmek için oluşturulmuştur. Aşağıdaki temel özelliklere sahiptir:
- Kullanıcı adres bilgilerini alma ve güncelleme
- Sepetteki ürünleri kontrol etme
- Iyzico API üzerinden ödeme sürecini başlatma ve yönetme
- Sipariş oluşturma ve ödeme işlemlerini tamamladıktan sonra sepeti temizleme

---

## 2. Yapıcı Metod
```php
public function __construct()
```
Bu metod, sınıfın bir örneği oluşturulduğunda çağrılır. İçerisinde:
- `BuyModel` sınıfından bir nesne oluşturulur.
- `initializeIyzipayOptions()` metodu çağrılarak Iyzico API bağlantı ayarları yüklenir.

---

## 3. Iyzico API Bağlantı Ayarları
```php
private function initializeIyzipayOptions()
```
Bu metod, ödeme işlemlerini başlatmak için gereken API bağlantı bilgilerini yükler. Iyzico'ya bağlanmak için gerekli API anahtarları `Config::get()` metodu ile `.env` dosyasından çekilir.

- **`IYZIPAY_API_KEY`** → Iyzico API anahtarı
- **`IYZIPAY_SECRET_KEY`** → Iyzico gizli anahtar
- **`IYZIPAY_BASE_URL`** → Iyzico API URL’si (sandbox veya production)

---

## 4. Kullanıcı Satın Alma Sayfası
```php
public function index($data = [])
```
Bu metod, kullanıcı satın alma sayfasını oluşturur. İçeriğinde:
- Kullanıcının sepetindeki ürünlerin olup olmadığı kontrol edilir.
- Kullanıcının adres bilgileri yüklenir.
- Ödeme formu başlatılır.
- Sayfa, `front/buy/index` şablonuna yönlendirilir.

**Eğer kullanıcı sepetinde ürün yoksa**, `/cart` sayfasına yönlendirilir.

---

## 5. Kullanıcı Adres Bilgilerini Güncelleme
```php
public function submit()
```
Bu metod, kullanıcı adreslerini kaydetmek veya güncellemek için kullanılır. İşleyiş:
1. Kullanıcının ID bilgisi alınır.
2. Kullanıcının fatura türü (bireysel/kurumsal) kontrol edilir.
3. Eğer kullanıcı daha önce adres kaydetmişse, mevcut adres güncellenir.
4. Yeni bir adres girilmişse, veritabanına eklenir.
5. İşlem sonucuna göre geri bildirim mesajları oluşturulur.

---

## 6. Ödeme Formunu Başlatma
```php
private function initializePayment()
```
Bu metod, Iyzico üzerinden ödeme formu oluşturur. İşleyiş:
1. Kullanıcının kimlik bilgileri alınır.
2. Sepetteki ürünler alınarak toplam fiyat hesaplanır.
3. **Iyzico Checkout Form** oluşturulur.
4. Kullanıcının adres bilgileri ödeme formuna eklenir.
5. Eğer ödeme başarılı şekilde başlatılmışsa, form HTML içeriği döndürülür. Aksi halde hata mesajı gösterilir.

**Başarılı ödeme süreci:**
- Kullanıcı Iyzico tarafından sağlanan ödeme sayfasına yönlendirilir.
- Ödeme tamamlandığında Iyzico, belirlenen `callback URL`'e yönlendirme yapar.

---

## 7. Ödeme Sonucunu İşleme
```php
public function callback()
```
Bu metod, Iyzico ödeme sonucunu işler. İşleyiş:
1. Kullanıcıdan gelen `token` değeri alınır.
2. Iyzico API üzerinden ödeme durumu sorgulanır.
3. Eğer ödeme başarılı ise `processOrder()` metodu çağrılarak sipariş tamamlanır.
4. Başarılı sipariş sonrası `order_success` sayfası görüntülenir.
5. Eğer hata oluşursa, hata mesajı kullanıcıya gösterilir.

---

## 8. Sipariş Veritabanı İşlemleri
```php
private function processOrder($checkoutForm)
```
Bu metod, sipariş tamamlandığında kullanıcı sepetini ve ödeme bilgilerini veritabanına kaydeder. İşleyiş:
- Kullanıcının sipariş bilgileri veritabanına eklenir.
- Kullanıcının adres bilgileri sipariş kaydı olarak eklenir.
- Sepet içeriği siparişe aktarılır.
- Kullanıcının sepeti temizlenir.

---

## 9. Test Amaçlı Sipariş Başarı Sayfası
```php
public function testOrderSuccess()
```
Bu metod, test senaryoları için sahte bir `conversationId` oluşturarak, başarılı sipariş sayfasının görüntülenmesini sağlar.

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Core\Config;
use App\Models\BuyModel;

class BuyController extends BaseController
{
    /**
     * @var BuyModel $buyModel Kullanılacak model örneği
     */
    private $buyModel;

    /**
     * @var \Iyzipay\Options $options Iyzipay API seçenekleri
     */
    private $options;

    /**
     * BuyController constructor.
     * Üst sınıfın yapıcı metodunu çağırır ve model örneğini oluşturur.
     */
    public function __construct()
    {
        parent::__construct();
        $this->buyModel = new BuyModel();
        $this->initializeIyzipayOptions();
    }

    /**
     * Iyzipay API seçeneklerini başlatır.
     */
    private function initializeIyzipayOptions()
    {
        $this->options = new \Iyzipay\Options();
        $this->options->setApiKey(Config::get('IYZIPAY_API_KEY'));
        $this->options->setSecretKey(Config::get('IYZIPAY_SECRET_KEY'));
        $this->options->setBaseUrl(Config::get('IYZIPAY_BASE_URL'));
    }

    /**
     * Satın alma sayfasını görüntüler.
     *
     * @param array $data Görüntülenecek veri
     */
    public function index($data = [])
    {
        $userId = $this->userId;

        // Sepetin boş olup olmadığını kontrol et
        $cartItems = $this->buyModel->getCartItems($userId);
        if (empty($cartItems)) {
            header('Location: /cart');
            return;
        }

        $addresses = $this->buyModel->getUserAddresses($userId);
        $userAddress = $this->buyModel->getUserAddress($userId);

        $paymentForm = null;
        if ($userAddress) {
            $paymentForm = $this->initializePayment();
        }

        $data = array_merge($data, [
            'addresses' => $addresses,
            'userAddress' => $userAddress,
            'paymentForm' => $paymentForm,
            'success' => $data['success'] ?? null,
            'error' => $data['error'] ?? null
        ]);

        $this->render('front/buy/index', $data);
    }

    /**
     * Adres bilgilerini kaydeder veya günceller.
     */
    public function submit()
    {
        $userId = $_SESSION['user_id'];
        $invoiceType = $_POST['invoiceType'] ?? null;

        if ($invoiceType) {
            $data = [
                'user_id' => $userId,
                'full_name' => $_POST['fullName'],
                'phone' => $_POST['phone'],
                'city' => $_POST['city'],
                'district' => $_POST['district'],
                'neighborhood' => $_POST['neighborhood'],
                'address' => $_POST['address'],
                'invoice_type' => $invoiceType,
                'tax_office' => $invoiceType === 'corporate' ? $_POST['taxOffice'] : null,
                'tax_number' => $_POST['taxNumber'],
                'company_name' => $invoiceType === 'corporate' ? $_POST['companyName'] : null,
                'is_default' => 0
            ];

            if ($this->buyModel->getUserAddress($userId)) {
                if ($this->buyModel->updateAddress($data)) {
                    $this->index(['success' => 'Adres başarıyla güncellendi.']);
                } else {
                    $this->index(['error' => 'Adres güncellenirken bir hata oluştu.']);
                }
            } else {
                if ($this->buyModel->saveAddress($data)) {
                    $this->index(['success' => 'Adres başarıyla kaydedildi.']);
                } else {
                    $this->index(['error' => 'Adres kaydedilirken bir hata oluştu.']);
                }
            }
        } else {
            $this->index(['error' => 'Fatura türü seçilmedi.']);
        }
    }

    /**
     * Ödeme formunu başlatır.
     *
     * @return string|array Ödeme formu HTML içeriği veya hata mesajı
     */
    private function initializePayment()
    {
        $userId = $this->userId;
        $user = $this->buyModel->getUserById($userId);
        $userAddress = $this->buyModel->getUserAddress($userId);
        $cartItems = $this->buyModel->getCartItems($userId);

        try {
            // Ödeme isteği oluştur
            $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
            $request->setLocale(\Iyzipay\Model\Locale::TR);
            $request->setConversationId(uniqid());

            $totalPrice = 0;
            $basketItems = array();
            foreach ($cartItems as $item) {
                $basketItem = new \Iyzipay\Model\BasketItem();
                $basketItem->setId($item['product_id']);
                $basketItem->setName($item['name']);
                $basketItem->setCategory1($item['category']);
                $basketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
                $basketItem->setPrice($item['price'] * $item['quantity']);
                $basketItems[] = $basketItem;
                $totalPrice += $item['price'] * $item['quantity'];
            }
            $request->setBasketItems($basketItems);
            $request->setPrice($totalPrice);
            $request->setPaidPrice($totalPrice);
            $request->setCurrency(\Iyzipay\Model\Currency::TL);
            $request->setBasketId("B67832");
            $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
            $request->setCallbackUrl("https://phpeticaretv5dev.test/buy/callback"); // Ödeme tamamlandığında yönlendirme yapılacak URL

            // Alıcı bilgileri
            $buyer = new \Iyzipay\Model\Buyer();
            $buyer->setId($user['id']);
            $buyer->setName($user['name'] ?? ''); // Varsayılan değer ekleyin
            $buyer->setSurname($user['name'] ?? ''); // Varsayılan değer ekleyin
            $buyer->setGsmNumber($user['phone_number'] ?? ''); // Varsayılan değer ekleyin
            $buyer->setEmail($user['email']);
            $buyer->setIdentityNumber($user['identity_number'] ?? '11111111111'); // Varsayılan değer ekleyin
            $buyer->setLastLoginDate($user['last_login_date'] ?? '2013-04-21 15:12:09'); // Varsayılan değer ekleyin
            $buyer->setRegistrationDate($user['registration_date'] ?? '2013-04-21 15:12:09'); // Varsayılan değer ekleyin
            $buyer->setRegistrationAddress($userAddress['address']);
            $buyer->setIp($_SERVER['REMOTE_ADDR']);
            $buyer->setCity($userAddress['city']);
            $buyer->setCountry("Turkey");
            $buyer->setZipCode($userAddress['zip_code'] ?? ''); // Varsayılan değer ekleyin
            $request->setBuyer($buyer);

            // Teslimat adresi
            $shippingAddress = new \Iyzipay\Model\Address();
            $shippingAddress->setContactName($userAddress['full_name']);
            $shippingAddress->setCity($userAddress['city']);
            $shippingAddress->setCountry("Turkey");
            $shippingAddress->setAddress($userAddress['address']);
            $shippingAddress->setZipCode($userAddress['zip_code'] ?? ''); // Varsayılan değer ekleyin
            $request->setShippingAddress($shippingAddress);

            // Fatura adresi
            $billingAddress = new \Iyzipay\Model\Address();
            $billingAddress->setContactName($userAddress['full_name']);
            $billingAddress->setCity($userAddress['city']);
            $billingAddress->setCountry("Turkey");
            $billingAddress->setAddress($userAddress['address']);
            $billingAddress->setZipCode($userAddress['zip_code'] ?? ''); // Varsayılan değer ekleyin
            $request->setBillingAddress($billingAddress);

            // Ödeme formunu başlat
            $checkoutFormInitialize = \Iyzipay\Model\CheckoutFormInitialize::create($request, $this->options);

            if ($checkoutFormInitialize->getStatus() === "success") {
                // Ödeme formunun HTML içeriği
                return $checkoutFormInitialize->getCheckoutFormContent();
            } else {
                return ['error' => "Hata: " . $checkoutFormInitialize->getErrorMessage()];
            }
        } catch (\Exception $e) {
            return ['error' => "Bir hata oluştu: " . $e->getMessage()];
        }
    }

    /**
     * Ödeme sonucunu işler ve siparişi tamamlar.
     */
    public function callback()
    {
        $token = $_POST['token'] ?? null;

        if ($token) {
            try {
                // Ödeme sonucu isteği oluştur
                $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
                $request->setLocale(\Iyzipay\Model\Locale::TR);
                $request->setConversationId(uniqid());
                $request->setToken($token);

                // Ödeme sonucunu al
                $checkoutForm = \Iyzipay\Model\CheckoutForm::retrieve($request, $this->options);

                if ($checkoutForm->getStatus() === "success") {
                    // Veritabanı işlemlerini gerçekleştir
                    $this->processOrder($checkoutForm);

                    // Başarılı ödeme view dosyasını render et
                    $this->render('front/buy/order_success', ['conversationId' => $checkoutForm->getConversationId()]);
                } else {
                    $this->index(['error' => "Hata: " . $checkoutForm->getErrorMessage()]);
                }
            } catch (\Exception $e) {
                $this->index(['error' => "Bir hata oluştu: " . $e->getMessage()]);
            }
        } else {
            $this->index(['error' => "Geçersiz token."]);
        }
    }

    /**
     * Sipariş veritabanı işlemlerini gerçekleştirir.
     *
     * @param \Iyzipay\Model\CheckoutForm $checkoutForm Ödeme formu
     */
    private function processOrder($checkoutForm)
    {
        $userId = $this->userId;
        $cartItems = $this->buyModel->getCartItems($userId);
        $userAddress = $this->buyModel->getUserAddress($userId);

        // Sipariş veritabanı işlemleri
        $orderId = $this->buyModel->createOrder([
            'user_id' => $userId,
            'total_price' => $checkoutForm->getPaidPrice()
        ]);

        foreach ($cartItems as $item) {
            $this->buyModel->createOrderItem([
                'order_id' => $orderId,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        $this->buyModel->createOrderPayment([
            'order_id' => $orderId,
            'payment_method' => 'credit_card',
            'transaction_id' => $checkoutForm->getPaymentId(),
            'payment_total' => $checkoutForm->getPaidPrice()
        ]);

        $this->buyModel->createOrderAddress([
            'order_id' => $orderId,
            'address_type' => 'shipping',
            'full_name' => $userAddress['full_name'],
            'phone' => $userAddress['phone'],
            'city' => $userAddress['city'],
            'district' => $userAddress['district'],
            'neighborhood' => $userAddress['neighborhood'],
            'address' => $userAddress['address']
        ]);

        $this->buyModel->createOrderAddress([
            'order_id' => $orderId,
            'address_type' => 'billing',
            'full_name' => $userAddress['full_name'],
            'phone' => $userAddress['phone'],
            'city' => $userAddress['city'],
            'district' => $userAddress['district'],
            'neighborhood' => $userAddress['neighborhood'],
            'address' => $userAddress['address']
        ]);

        // Kullanıcının sepetini boşalt
        $this->buyModel->clearCart($userId);
    }

    /**
     * Test amaçlı başarılı sipariş sayfasını görüntüler.
     */
    public function testOrderSuccess()
    {
        $fakeConversationId = '123456789';
        $this->render('front/buy/order_success', ['conversationId' => $fakeConversationId]);
    }
}

```
---

## Sonuç
BuyController, e-ticaret sitelerinde ödeme sürecini yönetmek için kapsamlı bir çözümdür. **Iyzico API ile ödeme sürecini başlatır, kullanıcıdan gelen yanıtı işler ve siparişi tamamlar.** Bu dokümanda, BuyController’ın tüm önemli işlevlerini açıkladık.

Eğer bir hata alıyorsanız, aşağıdaki adımları kontrol edin:
1. **API Anahtarlarınızı** `.env` dosyanızda doğru şekilde yapılandırdığınızdan emin olun.
2. **Iyzico Test Modu** için doğru `BASE_URL` kullandığınızdan emin olun.
3. **Geri çağrı (callback) URL'si** Iyzico'da kayıtlı mı, kontrol edin.

Daha fazla geliştirme yapmak için `BuyModel` içindeki veritabanı işlemlerini genişletebilir, sipariş onay e-postası ekleyebilir veya farklı ödeme yöntemlerini entegre edebilirsiniz. 🚀


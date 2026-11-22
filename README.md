# E-ticaret MVC — geliştirme iskeleti

PHP MVC yapısını, veritabanı erişimini ve e-ticaret akışlarını çalışmak için kullanılan bir proje iskeleti.

**Mevcut durum:** Çalışan bir mağaza veya ödeme demosu değildir. Controller/model ve birçok view dosyası boş yer tutucudur. Route tanımları bulunması, bu işlemlerin uygulanmış olduğu anlamına gelmez. Bu nedenle ana portföy vitrininde önceliklendirilmiyor.

## Depoda bulunanlar

- Özel router, temel controller ve veritabanı yapılandırması.
- Ön yüz layout taslakları ve public giriş dosyası.
- Composer manifest/lock; Dotenv, PHPMailer, Iyzico bağımlılıkları.
- Ortam değişkenleri için `.env.example`.
- `a-Documentation/` altında çalışma notları.

## Geliştirme hazırlığı

Composer gereksinimlerini karşılayan PHP ortamında:

```sh
git clone https://github.com/HunterLion2/ETICARET-main.git
cd ETICARET-main
composer install
cp .env.example .env
```

Bu komutlar bağımlılıkları ve örnek yapılandırmayı hazırlar; mağazayı tamamlamaz. Eksik controller/model/view uygulamaları ve veritabanı şeması olmadan uçtan uca çalışma beklenmemeli. Web sunucusunun kökü `public/` olmalıdır. Gerçek API anahtarlarını koda veya Git'e eklemeyin; ödeme denemeleri için örnekteki sandbox ortamını kullanın.

## Kalan işler

- Controller/model/view akışlarının uygulanması.
- Veritabanı migration ve sentetik seed verisi.
- Sepet, stok, sipariş ve sandbox ödeme akışlarının entegrasyon testleri.
- Kimlik doğrulama, yetkilendirme, girdi doğrulama ve hata durumlarının kontrolü.
- Çalışan demo ve gerçek ekran görüntüleri.

## Kaynak ve kapsam

Mevcut Composer paketi `emrahyuksel/mvc` adını ve MVC açıklamasını taşıyor. Bu başlangıç bilgisini koruyorum; iskeleti bütünüyle bana ait tamamlanmış bir ürün olarak sunmuyorum.

Güncel kökte `.env.example` var. Bu README çalışması geçmiş commit'ler için kapsamlı bir sır/güvenlik denetimi değildir. Bağımlılıkların kendi lisansları geçerlidir.

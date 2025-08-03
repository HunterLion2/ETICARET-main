# Route.php Dosyası Açıklaması

Bu dokümanda **Route.php** dosyasının nasıl çalıştığını adım adım inceleyeceğiz. Route sınıfı, uygulamanızdaki URL yönlendirmelerini yönetmek için kullanılır.

---

## 📌 **Namespace ve Sınıf Tanımlaması**

```php
namespace App\Core;

class Route
```

- **`namespace App\Core;`** → Bu sınıfın `App\Core` isim alanında bulunduğunu belirtir.
- **`class Route`** → Route sınıfını tanımlar, bu sınıf tüm yönlendirme işlemlerini kontrol edecektir.

---

## 📌 **Özel Değişkenler**

```php
/**
 * @var array $routes Tanımlanan rotaları tutar
 */
private static $routes = [];

/**
 * @var array $middlewares Rotaya atanmış middleware'leri tutar
 */
private static $middlewares = [];
```

- **`$routes`** → Uygulamada tanımlanan tüm rotaları saklar.
- **`$middlewares`** → Rotalara atanmış olan `middleware` sınıflarını tutar.

---

## 📌 **Rota Tanımlama Metodu: `add()`**

```php
public static function add($uri, $controller)
{
    self::$routes[$uri] = $controller;
    return new static;
}
```

- **`add($uri, $controller)`** → Yeni bir rota eklemek için kullanılır.
- **`self::$routes[$uri] = $controller;`** → URI ile ilişkili denetleyiciyi `$routes` dizisine ekler.
- **`return new static;`** → Zincirleme metot çağrısı yapılmasını sağlar (`middleware()` metodu için gereklidir).

#### **Kullanım Örneği:**
```php
Route::add('/home', 'HomeController@index');
```

---

## 📌 **Middleware Tanımlama Metodu: `middleware()`**

```php
public static function middleware($middleware)
{
    $lastRoute = array_key_last(self::$routes);
    self::$middlewares[$lastRoute] = $middleware;
}
```

- **`$lastRoute = array_key_last(self::$routes);`** → En son eklenen rotayı alır.
- **`self::$middlewares[$lastRoute] = $middleware;`** → Middleware'i bu rotaya ekler.

#### **Kullanım Örneği:**
```php
Route::add('/admin', 'AdminController@index')->middleware(AuthMiddleware::class);
```

---

## 📌 **Rotaları Çalıştırma Metodu: `dispatch()`**

Bu metod, gelen URL'nin uygun denetleyiciye yönlendirilmesini sağlar.

```php
public static function dispatch($uri)
{
    foreach (self::$routes as $route => $controller) {
        $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $route);
        $pattern = "#^" . $pattern . "$#";

        if (preg_match($pattern, $uri, $matches)) {
            array_shift($matches);

            if (isset(self::$middlewares[$route])) {
                $middleware = self::$middlewares[$route];
                (new $middleware)->handle();
            }

            [$class, $method] = explode('@', $controller);
            $class = "App\\Controllers\\" . $class;

            if (class_exists($class) && method_exists($class, $method)) {
                call_user_func_array([new $class, $method], $matches);
                return;
            } else {
                http_response_code(404);
                echo "404 Not Found - Sınıf ya da Metot Bulunamadı";
                return;
            }
        }
    }
    throw new \Exception("404 Not Found");
}
```

- **`foreach (self::$routes as $route => $controller) { ... }`** → Tanımlanan rotalar arasında döngü yapar.
- **`preg_replace()`** → `{id}` gibi dinamik parametreleri regex ile yakalar.
- **`preg_match()`** → Gelen URI'nin tanımlı bir rotaya uyup uymadığını kontrol eder.
- **`$matches`** → Yakalanan URL parametrelerini tutar.
- **`if (isset(self::$middlewares[$route]))`** → Eğer bir middleware varsa, çalıştırılır.
- **`[$class, $method] = explode('@', $controller);`** → Denetleyiciyi ve metodu belirler.
- **`call_user_func_array()`** → Belirtilen denetleyici metodunu parametrelerle birlikte çağırır.

#### **Kullanım Örneği:**
```php
Route::dispatch('/home');
```
Eğer `/home` tanımlıysa, `HomeController@index` metodu çalışacaktır.

---

## 📌 **Tam Kod**

```php
<?php

namespace App\Core;

class Route
{
    /**
     * @var array $routes Tanımlanan rotaları tutar
     */
    private static $routes = [];

    /**
     * @var array $middlewares Rotaya atanmış middleware'leri tutar
     */
    private static $middlewares = [];

    /**
     * Yeni bir rota ekler
     *
     * @param string $uri Rota URI'si
     * @param string $controller Rota ile ilişkilendirilecek kontrolör
     * @return static
     */
    public static function add($uri, $controller)
    {
        self::$routes[$uri] = $controller;
        return new static;
    }

    /**
     * Bir rotaya middleware ekler
     *
     * @param string $middleware Middleware sınıfı
     * @return void
     */
    public static function middleware($middleware)
    {
        $lastRoute = array_key_last(self::$routes);
        self::$middlewares[$lastRoute] = $middleware;
    }

    /**
     * Gelen URI'yi uygun kontrolör ve metoda yönlendirir
     *
     * @param string $uri Gelen URI
     * @return void
     */
    public static function dispatch($uri)
    {
        foreach (self::$routes as $route => $controller) {
            // Dinamik parametreleri yakalamak için regex oluştur
            $pattern = preg_replace('/\{([a-zA-Z0-9_]+)\}/', '([a-zA-Z0-9_-]+)', $route);
            $pattern = "#^" . $pattern . "$#";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // İlk eleman tüm eşleşmedir, onu çıkar

                if (isset(self::$middlewares[$route])) {
                    $middleware = self::$middlewares[$route];
                    (new $middleware)->handle();
                }

                [$class, $method] = explode('@', $controller);
                $class = "App\\Controllers\\" . $class;

                if (class_exists($class) && method_exists($class, $method)) {
                    call_user_func_array([new $class, $method], $matches);
                    return;
                } else {
                    http_response_code(404);
                    echo "404 Not Found - Sınıf ya da Metot Bulunamadı";
                    return;
                }
            }
        }

        // Eğer hiçbir rota eşleşmezse
        throw new \Exception("404 Not Found");
    }
}

```

---

## 🎯 **Öğrencilere Not:**
Bu kodu `Route.php` dosyanıza yapıştırın ve yönlendirme işlemlerinizde kullanabilirsiniz. Eğer yeni rotalar tanımlamak istiyorsanız, aşağıdaki gibi bir kullanım yapabilirsiniz:

```php
Route::add('/home', 'HomeController@index');
Route::add('/admin', 'AdminController@index')->middleware(AuthMiddleware::class);
```

Bu sayede uygulamanızın yönlendirme işlemlerini merkezi bir şekilde yönetebilirsiniz. 🚀
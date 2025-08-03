# SearchModel Kullanımı ve Arama İşlevselliği

## SearchModel Nedir?
`SearchModel` sınıfı, bir e-ticaret sitesinde ürün arama işlemlerini gerçekleştirmek için kullanılır. Kullanıcının girdiği arama sorgusuna uygun olarak veritabanında ürünleri arar ve eşleşen sonuçları döndürür.

## SearchModel'in Tanımlanması
`SearchModel`, `Database` sınıfını kullanarak veritabanı bağlantısını yönetir. Ürünler `products` tablosunda aranır ve belirlenen kriterlere uyan sonuçlar döndürülür.

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * SearchModel sınıfı, ürün arama işlemlerini gerçekleştirmek için kullanılır.
 */
class SearchModel
{
    /**
     * @var \PDO Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * SearchModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Ürünleri verilen sorguya göre arar.
     *
     * @param string $query Arama sorgusu
     * @return array Arama sonuçları
     */
    public function searchProducts($query)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name LIKE ? OR short_description LIKE ? OR tag LIKE ?");
        $searchQuery = '%' . $query . '%';
        $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
```

## SearchModel Kullanımı

### 1. `searchProducts` Metodu
Bu metod, kullanıcının girdiği arama terimini veritabanında `products` tablosundaki `name`, `short_description` ve `tag` sütunlarında arar. `LIKE` operatörü kullanılarak, verilen anahtar kelimenin herhangi bir yerinde geçen kayıtlar döndürülür.

### 2. Örnek Kullanım

Bir controller içinde `SearchModel` sınıfı kullanılarak arama yapılabilir:

```php
<?php
namespace App\Controllers\Front;

use App\Core\BaseController;
use App\Models\SearchModel;

class SearchController extends BaseController
{
    private $searchModel;

    public function __construct()
    {
        parent::__construct();
        $this->searchModel = new SearchModel();
    }

    public function search()
    {
        if (isset($_GET['query'])) {
            $query = trim($_GET['query']);
            $results = $this->searchModel->searchProducts($query);
            $this->render('front/search_results', ['results' => $results, 'query' => $query]);
        } else {
            $this->render('front/search_results', ['results' => [], 'query' => '']);
        }
    }
}
```

### 3. Arama Sonuçlarını Gösterme

Bir `search_results.php` şablon dosyasında arama sonuçları gösterilebilir:

```php
<div class="container my-4">
    <h2>Arama Sonuçları: "<?= htmlspecialchars($query) ?>"</h2>
    <?php if (!empty($results)): ?>
        <ul>
            <?php foreach ($results as $product): ?>
                <li>
                    <a href="/product/<?= htmlspecialchars($product['id']) ?>">
                        <?= htmlspecialchars($product['name']) ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Sonuç bulunamadı.</p>
    <?php endif; ?>
</div>
```

---
## 📌 **Tam Kod*

```php
<?php

namespace App\Models;

use App\Core\Database;

/**
 * SearchModel sınıfı, ürün arama işlemlerini gerçekleştirmek için kullanılır.
 */
class SearchModel
{
    /**
     * @var \PDO Veritabanı bağlantı nesnesi
     */
    private $db;

    /**
     * SearchModel constructor.
     * Veritabanı bağlantısını başlatır.
     */
    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    /**
     * Ürünleri verilen sorguya göre arar.
     *
     * @param string $query Arama sorgusu
     * @return array Arama sonuçları
     */
    public function searchProducts($query)
    {
        $stmt = $this->db->prepare("SELECT * FROM products WHERE name LIKE ? OR short_description LIKE ? OR tag LIKE ?");
        $searchQuery = '%' . $query . '%';
        $stmt->execute([$searchQuery, $searchQuery, $searchQuery]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}

```
---

## Sonuç
- `SearchModel` ile ürün arama işlemi kolaylaştırılmıştır.
- `LIKE` operatörü ile esnek arama gerçekleştirilmiştir.
- Controller ve view entegrasyonu ile kullanıcıya arama sonuçları sunulmuştur.

Bu yapı, kullanıcıların aradıkları ürünleri kolayca bulmasını sağlar ve e-ticaret sitesinin kullanımını daha verimli hale getirir.


# Arama Sonuçları Sayfası

Bu döküman, e-ticaret sitesinin arama sonuçları sayfasını oluşturan HTML ve PHP kodlarını açıklamaktadır. Kullanıcıların arama sorgularına göre ürün listesinin nasıl gösterileceğini öğrenebilirsiniz.

## 1. Sayfa Başlığı ve İkon

Kodun başlangıcında, arama sonuçlarını göstermek için bir başlık ve ikon bulunmaktadır.

```html
<h1 class="h2 py-0 px-3">Arama Sonuçları: "<?php echo htmlspecialchars($query); ?>"</h1>
<i class="fas fa-user-edit fa-2x"></i>
```
- **`$query`**: Kullanıcının arama kutusuna girdiği metni temsil eder.
- **`htmlspecialchars`**: Kullanıcıdan gelen metnin HTML güvenliğini sağlamak için kullanılır.
- **İkon (`<i>` etiketi)**: Arama sonuçlarını simgeleyen bir ikon eklenmiştir.

---

## 2. Ürünlerin Listelenmesi

Bu bölüm, eğer arama sonuçlarında ürünler varsa onları listeleyen kod bloğunu içerir.

```html
<?php if (!empty($products)): ?>
    <div class="row">
        <?php foreach ($products as $product): ?>
            <div class="col-md-3">
                <div class="card">
                    <div class="position-relative">
                        <span class="badge bg-secondary badge-label"><?php echo htmlspecialchars($product['tag'] ?? ''); ?></span>
                        <span class="badge bg-secondary badge-featured">Öne Çıkan</span>
                        <span class="badge bg-secondary badge-best-seller"><?php echo htmlspecialchars($product['category_name'] ?? ''); ?></span>
                        <img src="<?php echo htmlspecialchars($product['standard_image'] ?? ''); ?>" class="card-img-top img-300x300" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>">
                        <img src="<?php echo htmlspecialchars($product['hover_image'] ?? ''); ?>" class="card-img-top hover-img img-300x300" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?> Hover">
                        <i class="fas fa-heart favorite-icon" onclick="addToFavorites()"></i>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo htmlspecialchars($product['name'] ?? ''); ?></h5>
                        <p class="card-text short-description"><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></p>
                        <div class="d-flex justify-content-between">
                            <a href="/product/<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-secondary">Detaylar</a>
                            <form action="/cart/add" method="post">
                                <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-dark"><i class="fas fa-cart-plus"></i> Sepete Ekle</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p class="text-center">Ürün bulunamadı.</p>
<?php endif; ?>
```

### Açıklamalar
- **`if (!empty($products))`**: Eğer ürünler bulunursa listelenmeye başlanır.
- **Döngü (`foreach`)**: `$products` dizisinde bulunan her bir ürünü ayrı bir `card` içinde göstermek için kullanılır.
- **Ürün Görselleri**:
  - `standard_image`: Ürünün ana görseli
  - `hover_image`: Üzerine gelindiğinde değişecek görsel
- **Etiketler (`badge`)**: Ürünün tag, öne çıkan ve kategori bilgileri gösterilir.
- **Sepete Ekle Butonu**: Kullanıcı ürünleri sepete ekleyebilir.

---

## 3. Ürün Bulunamadığında Gösterilecek Mesaj

Eğer arama sonucunda hiçbir ürün bulunamazsa aşağıdaki kod çalışır ve kullanıcıya "Ürün bulunamadı" mesajı gösterilir.

```html
<p class="text-center">Ürün bulunamadı.</p>
```

---
## 📌 **Tam Kod*

```html
<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Arama Sonuçları: "<?php echo htmlspecialchars($query); ?>"</h1>
        <i class="fas fa-user-edit fa-2x"></i>
    </div>
    <div class="row">
        <div class="col-md-12">
            <?php if (!empty($products)): ?>
                <div class="row">
                    <?php foreach ($products as $product): ?>
                        <div class="col-md-3">
                            <div class="card">
                                <div class="position-relative">
                                    <span class="badge bg-secondary badge-label"><?php echo htmlspecialchars($product['tag'] ?? ''); ?></span>
                                    <span class="badge bg-secondary badge-featured">Öne Çıkan</span>
                                    <span class="badge bg-secondary badge-best-seller"><?php echo htmlspecialchars($product['category_name'] ?? ''); ?></span>
                                    <img src="<?php echo htmlspecialchars($product['standard_image'] ?? ''); ?>" class="card-img-top img-300x300" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>">
                                    <img src="<?php echo htmlspecialchars($product['hover_image'] ?? ''); ?>" class="card-img-top hover-img img-300x300" alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?> Hover">
                                    <i class="fas fa-heart favorite-icon" onclick="addToFavorites()"></i>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($product['name'] ?? ''); ?></h5>
                                    <p class="card-text short-description"><?php echo htmlspecialchars($product['short_description'] ?? ''); ?></p>
                                    <div class="d-flex justify-content-between">
                                        <a href="/product/<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-secondary">Detaylar</a>
                                        <form action="/cart/add" method="post">
                                            <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
                                            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="btn btn-dark"><i class="fas fa-cart-plus"></i> Sepete Ekle</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-center">Ürün bulunamadı.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
```
---

## Sonuç
Bu dosya, kullanıcının girdiği arama sorgusuna uygun olarak ürünleri listeleyen ve arama sonuçlarını görüntüleyen bir HTML-PHP şablonudur. Kullanıcılar ürünleri detaylı görebilir veya sepete ekleyebilirler. Eğer herhangi bir ürün bulunmazsa, bilgilendirici bir mesaj gösterilir.

Bu şablon Bootstrap ve Font Awesome ikonları ile şekillendirilmiştir. Görsel ve stil değişiklikleriyle özelleştirilerek daha iyi bir kullanıcı deneyimi sağlanabilir.


# **Ana Sayfa İçeriği Yönetimi**

Bu eğitim dokümanında, **anasayfa bileşenlerini nasıl yöneteceğinizi** öğreneceksiniz. **Slider, kampanyalar, ürünler ve fırsatlar gibi bölümleri nasıl ekleyebileceğinizi ve görüntüleyebileceğinizi** adım adım anlatacağız.

---

## **1. Fırsatlar (Breaking News) Alanı**

```html
<div class="bg-secondary text-white py-2">
    <div class="container breaking-news">
        <span class="fw-bold me-3">Fırsatlar:</span>
        <div class="news-container">
            <?php if (!empty($deals)): ?>
                <?php foreach ($deals as $deal): ?>
                    <p>
                        <a href="#" class="text-white text-decoration-none mx-3">
                            <?php
                            echo htmlspecialchars($deal['title']) . ': ';
                            echo htmlspecialchars(mb_strimwidth($deal['content'], 0, 70, '...'));
                            ?>
                        </a>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Kampanya bulunamadı.</p>
            <?php endif; ?>
        </div>
        <span class="fixed-message"><i class="fas fa-credit-card"></i> Kredi Kartına 12 Ay'a Varan Taksit İmkanı.</span>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Güncel fırsatları ve kampanyaları ekrana getirir.**  
✅ **Eğer bir kampanya yoksa "Kampanya bulunamadı" mesajı gösterilir.**

---

## **2. Arama Alanı ve Toplam Ürün Sayısı**

```html
<div class="bg-dark text-white py-5">
    <div class="container">
        <h1 class="text-center mb-4">En İyi Ürünleri Keşfedin</h1>
        <p class="text-center mb-4">Toplam Ürün Sayısı: <?php echo $totalProductCount; ?></p>
        <div class="input-group mb-4">
            <form action="/search" method="get" class="d-flex w-100" onsubmit="return validateSearch()">
                <input type="text" name="query" class="form-control" placeholder="Ne aramıştınız?" required minlength="3">
                <button class="btn btn-dark" type="submit">Ara</button>
            </form>
        </div>
        <script>
            function validateSearch() {
                const query = document.querySelector('input[name="query"]').value;
                if (query.length < 3) {
                    alert('Lütfen en az 3 harf giriniz.');
                    return false;
                }
                return true;
            }
        </script>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Kullanıcının arama yapmasını sağlar.**  
✅ **Arama kutusu en az 3 karakter girişi gerektirir.**

---

## **3. Slider Alanı**

```html
<div class="container my-5">
    <div class="row">
        <div class="col-8">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if (!empty($sliders)): ?>
                        <?php foreach ($sliders as $index => $slider): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo htmlspecialchars($slider['image_url']); ?>" class="d-block w-100 rounded shadow" alt="<?php echo htmlspecialchars($slider['title']); ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <img src="https://place-hold.it/800x400?text=No+Sliders" class="d-block w-100 rounded shadow" alt="No Sliders">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Slider Bulunamadı</h5>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Anasayfada slider görsellerini döndürerek gösterir.**  
✅ **Eğer slider yoksa "Slider Bulunamadı" mesajı gösterilir.**

---

## **4. Öne Çıkan Ürünler**

```html
<div class="container my-5">
    <h2 class="text-center mb-4">Öne Çıkan Ürünler</h2>
    <div class="row g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-3">
                    <div class="card">
                        <img src="<?php echo htmlspecialchars($product['standard_image']); ?>" class="card-img-top img-300x300" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text short-description"><?php echo htmlspecialchars($product['short_description']); ?></p>
                            <div class="d-flex justify-content-between">
                                <a href="product/<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-secondary">Detaylar</a>
                                <form action="/cart/add" method="post">
                                    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                                    <input type="hidden" name="quantity" value="1">
                                    <button type="submit" class="btn btn-dark"><i class="fas fa-cart-plus"></i> Sepete Ekle</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center">Ürün bulunamadı.</p>
        <?php endif; ?>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Öne çıkan ürünleri kullanıcıya gösterir.**  
✅ **Eğer ürün yoksa "Ürün bulunamadı" mesajı gösterilir.**

---
## 📌 **Tam Kod*

```html
<div class="bg-secondary text-white py-2">
    <div class="container breaking-news">
        <span class="fw-bold me-3">Fırsatlar:</span>
        <div class="news-container">
            <?php if (!empty($deals)): ?>
                <?php foreach ($deals as $deal): ?>
                    <p>
                        <a href="#" class="text-white text-decoration-none mx-3">
                            <?php
                            echo htmlspecialchars($deal['title']) . ': ';
                            echo htmlspecialchars(mb_strimwidth($deal['content'], 0, 70, '...'));
                            ?>
                        </a>
                    </p>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Kampanya bulunamadı.</p>
            <?php endif; ?>
        </div>
        <span class="fixed-message"><i class="fas fa-credit-card"></i> Kredi Kartına 12 Ay'a Varan Taksit İmkanı.</span>
    </div>
</div>

<!-- Home Page -->
<div class="bg-dark text-white py-5">
    <div class="container">
        <h1 class="text-center mb-4">En İyi Ürünleri Keşfedin</h1>
        <p class="text-center mb-4">Toplam Ürün Sayısı: <?php echo $totalProductCount; ?></p>
        <div class="input-group mb-4">
            <form action="/search" method="get" class="d-flex w-100" onsubmit="return validateSearch()">
                <input type="text" name="query" class="form-control" placeholder="Ne aramıştınız?" required minlength="3">
                <button class="btn btn-dark" type="submit">Ara</button>
            </form>
        </div>
        <script>
            function validateSearch() {
                const query = document.querySelector('input[name="query"]').value;
                if (query.length < 3) {
                    alert('Lütfen en az 3 harf giriniz.');
                    return false;
                }
                return true;
            }
        </script>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <div class="col-8">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php if (!empty($sliders)): ?>
                        <?php foreach ($sliders as $index => $slider): ?>
                            <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                                <img src="<?php echo htmlspecialchars($slider['image_url']); ?>" class="d-block w-100 rounded shadow" alt="<?php echo htmlspecialchars($slider['title']); ?>">
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="carousel-item active">
                            <img src="https://place-hold.it/800x400?text=No+Sliders" class="d-block w-100 rounded shadow" alt="No Sliders">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Slider Bulunamadı</h5>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="carousel-caption d-none d-md-block text-end" style="right: 30px; bottom: -10px;">
                        <p id="carouselCounter" class="badge bg-secondary shadow">1/<?php echo count($sliders); ?></p>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
            <div class="mt-3 d-flex justify-content-center">
                <?php if (!empty($sliders)): ?>
                    <?php foreach ($sliders as $index => $slider): ?>
                        <img
                            src="<?php echo htmlspecialchars($slider['image_url']); ?>"
                            class="img-thumbnail mx-1"
                            style="width: 100px; height: 50px; object-fit: cover;"
                            data-bs-target="#carouselExampleIndicators"
                            data-bs-slide-to="<?php echo $index; ?>"
                            alt="<?php echo htmlspecialchars($slider['title']) . ' Thumbnail'; ?>">
                    <?php endforeach; ?>
                <?php else: ?>
                    <img
                        src="https://place-hold.it/100x50?text=No+Thumbnail"
                        class="img-thumbnail mx-1"
                        style="width: 100px; height: 50px; object-fit: cover;"
                        alt="No Thumbnail">
                <?php endif; ?>
            </div>
        </div>
        <div class="col-4">
            <img src="https://place-hold.it/400x400?text=Reklam+Alanı" class="d-block w-100 rounded shadow" alt="Reklam Alanı">
        </div>
    </div>
</div>

<div class="container my-5">
    <h2 class="text-center mb-4">Öne Çıkan Ürünler</h2>
    <p class="text-center mb-4">En popüler ve en çok satan ürünlerimizi keşfedin.</p>
    <div class="row g-4">
        <?php if (!empty($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-3">
                    <div class="card">
                        <div class="position-relative">
                            <span class="badge bg-secondary badge-label"><?php echo htmlspecialchars($product['tag']); ?></span>
                            <span class="badge bg-secondary badge-featured">Öne Çıkan</span>
                            <span class="badge bg-secondary badge-best-seller"><?php echo htmlspecialchars($product['category_name']); ?></span>
                            <img src="<?php echo htmlspecialchars($product['standard_image']); ?>" class="card-img-top img-300x300" alt="<?php echo htmlspecialchars($product['name']); ?>">
                            <img src="<?php echo htmlspecialchars($product['hover_image']); ?>" class="card-img-top hover-img img-300x300" alt="<?php echo htmlspecialchars($product['name']); ?> Hover">
                            <i class="fas fa-heart favorite-icon" onclick="addToFavorites()"></i>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                            <p class="card-text short-description"><?php echo htmlspecialchars($product['short_description']); ?></p>
                            <div class="d-flex justify-content-between">
                                <a href="product/<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-secondary">Detaylar</a>
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
        <?php else: ?>
            <p class="text-center">Ürün bulunamadı.</p>
        <?php endif; ?>
    </div>
</div>
```
---

## **Sonuç**

Bu dokümanda, **anasayfadaki fırsatlar, sliderlar, arama alanı ve öne çıkan ürünler gibi bölümleri nasıl yönetebileceğinizi öğrendiniz.** 🚀

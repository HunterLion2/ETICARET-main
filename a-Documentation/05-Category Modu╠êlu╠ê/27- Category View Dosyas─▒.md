# **Kategoriye Ait Ürünlerin Görüntülenmesi**

Bu eğitim dokümanında, **kategoriye ait ürünlerin nasıl listeleneceğini** ve **görünüm (view) dosyasında ürünlerin nasıl gösterileceğini** öğreneceksiniz. Bu sayfa, kategoriye ait ürünleri listelemek ve kullanıcıya sunmak için tasarlanmıştır.

---

## **1. Sayfa Yapısının Oluşturulması**

```html
<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Kategori'ye ait ürünler listeleniyor...</h1>
        <i class="fas fa-user-edit fa-2x"></i>
    </div>
```

### **Ne İşe Yarar?**
✅ `container my-2` → Sayfa içeriğini **ortalar** ve **üst-alt boşluk ekler.**
✅ `d-flex justify-content-between` → **Başlık ve ikonu hizalar.**
✅ `fa-user-edit fa-2x` → **Kategori detaylarını temsil eden ikon.**

---

## **2. Ürünlerin Listelenmesi**

```html
<div class="row">
    <div class="col-md-12">
        <?php if (!empty($products)): ?>
            <div class="row">
                <?php foreach ($products as $product): ?>
                    <div class="col-md-3">
                        <div class="card">
```

### **Ne İşe Yarar?**
✅ `if (!empty($products))` → **Ürün listesi boş değilse ürünleri gösterir.**
✅ `foreach ($products as $product)` → **Tüm ürünleri döngü ile sıralar.**
✅ `col-md-3` → **Her ürün için Bootstrap ile 4'lü sütun yapısı oluşturur.**

🔹 **Eğer ürün bulunamazsa, aşağıdaki kod çalışır:**

```html
<?php else: ?>
    <p class="text-center">Ürün bulunamadı.</p>
<?php endif; ?>
```

---

## **3. Ürün Kartlarının Tasarlanması**

```html
<div class="position-relative">
    <span class="badge bg-secondary badge-label">
        <?php echo htmlspecialchars($product['tag'] ?? ''); ?>
    </span>
    <span class="badge bg-secondary badge-featured">Öne Çıkan</span>
    <span class="badge bg-secondary badge-best-seller">
        <?php echo htmlspecialchars($product['category_name'] ?? ''); ?>
    </span>
```

### **Ne İşe Yarar?**
✅ **Ürün etiketi (tag) ve kategorisini gösterir.**
✅ `badge bg-secondary` → **Bootstrap rozetleri kullanılarak ürün özellikleri vurgulanır.**

---

## **4. Ürün Resimlerinin Gösterimi**

```html
<img src="<?php echo htmlspecialchars($product['standard_image'] ?? ''); ?>" 
     class="card-img-top img-300x300" 
     alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?>">

<img src="<?php echo htmlspecialchars($product['hover_image'] ?? ''); ?>" 
     class="card-img-top hover-img img-300x300" 
     alt="<?php echo htmlspecialchars($product['name'] ?? ''); ?> Hover">
```

### **Ne İşe Yarar?**
✅ **Standart ve hover (üzerine gelindiğinde değişen) görselleri yükler.**
✅ `img-300x300` → **Görsellerin boyutlarını sabitler ve responsive hale getirir.**

---

## **5. Ürün Açıklaması ve Detay Butonu**

```html
<div class="card-body">
    <h5 class="card-title">
        <?php echo htmlspecialchars($product['name'] ?? ''); ?>
    </h5>
    <p class="card-text short-description">
        <?php echo htmlspecialchars($product['short_description'] ?? ''); ?>
    </p>
    <div class="d-flex justify-content-between">
        <a href="/product/<?php echo htmlspecialchars($product['slug']); ?>" class="btn btn-secondary">Detaylar</a>
```

### **Ne İşe Yarar?**
✅ **Ürün adı ve açıklamasını ekler.**
✅ **Ürüne özel detay sayfasına yönlendiren butonu ekler.**

---

## **6. Sepete Ekleme İşlemi**

```html
<form action="/cart/add" method="post">
    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">
    <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
    <input type="hidden" name="quantity" value="1">
    <button type="submit" class="btn btn-dark">
        <i class="fas fa-cart-plus"></i> Sepete Ekle
    </button>
</form>
```

### **Ne İşe Yarar?**
✅ **Ürünü sepete eklemek için form gönderimi yapar.**
✅ **Kullanıcının ID’si, ürün ID’si ve varsayılan miktar (1) gizli input alanlarıyla gönderilir.**
✅ **Sepete ekleme işlemi için `cart/add` endpointine yönlendirilir.**

---
## 📌 **Tam Kod*

```html
<div class="container my-2">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2 py-0 px-3">Kategori'ye ait ürünler listeleniyor...</h1>
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
—--

## **Sonuç**

Bu eğitimde **kategoriye ait ürünlerin nasıl listeleneceğini ve Bootstrap ile nasıl şık bir görünüm oluşturulacağını** öğrendiniz. Artık bu sayfayı özelleştirerek ürünlerinizi etkili bir şekilde sergileyebilirsiniz! 🚀

# Ürün Galeri Yönetimi Dokümantasyonu

Bu dokümantasyon, bir ürünün galeri yönetimini sağlayan PHP tabanlı yönetim paneli sayfasını açıklamaktadır. Ürünlerin galeri görsellerini ekleme ve silme işlemlerinin nasıl yapıldığını anlatmaktadır.

## 1. Kullanılan Teknolojiler
- **PHP**: Sunucu tarafında verileri işlemek için
- **HTML & Bootstrap**: Sayfa tasarımı ve form elemanlarını düzenlemek için
- **MySQL**: Veritabanında galeri bilgilerini saklamak için

---

## 2. Ürün Galerisi Formu
### Açıklama
Bu form, seçili ürüne galeri görseli eklemek için kullanılır.

```php
<form action="/admin/products/gallery/add" method="post" enctype="multipart/form-data">
    <h4>Ürün Adı: <?= htmlspecialchars($product_name ?? '') ?></h4>
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
    <div class="mb-3">
        <label for="gallery_image" class="form-label">Galeri Resmi</label>
        <input type="file" class="form-control" id="gallery_image" name="gallery_image" required>
    </div>
    <div class="d-flex justify-content-end mt-4 mb-5">
        <button type="submit" class="btn btn-secondary">Ekle</button>
    </div>
</form>
```

### Açıklamalar
- Kullanıcı, **Galerisi** eklemek istediği ürünü seçer.
- **hidden input** olarak `product_id` değeri saklanır.
- `gallery_image` dosya yükleme alanından görsel eklenir.
- `enctype="multipart/form-data"` formun dosya yükleme destekli çalışmasını sağlar.
- **Ekle** butonuna basıldığında form `/admin/products/gallery/add` adresine gönderilir.

---

## 3. Ürün Galeri Listesi
### Açıklama
Eklenen görsellerin listelenmesini sağlar. Eğer ürün için herhangi bir görsel yoksa kullanıcıya bir uyarı mesajı gösterilir.

```php
<?php if (empty($gallery_images)): ?>
    <div class="col-md-12">
        <div class="alert alert-secondary text-center">Bu ürün için galeri resmi bulunmamaktadır.</div>
    </div>
<?php else: ?>
    <?php foreach ($gallery_images as $image): ?>
        <div class="col-md-3">
            <div class="card mb-3">
                <img src="<?= htmlspecialchars($image['image_path']) ?>" class="card-img-top" alt="...">
                <div class="card-body text-center">
                    <form action="/admin/products/gallery/delete" method="post">
                        <input type="hidden" name="image_path" value="<?= htmlspecialchars($image['image_path']) ?>">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                        <button type="submit" class="btn btn-secondary btn-sm">Sil</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
```

### Açıklamalar
- `empty($gallery_images)`: Eğer ürün için galeri görselleri yoksa kullanıcıya **"Bu ürün için galeri resmi bulunmamaktadır."** uyarısı verilir.
- Görseller, **Bootstrap kart** tasarımı ile listelenir.
- Her görselin altında **Sil** butonu bulunur.
- `form action="/admin/products/gallery/delete"` formun ilgili görseli silmesini sağlar.
- `input type="hidden" name="image_path"`: Görselin yolu form içinde gizli olarak gönderilir.

---

## 4. Ürün Galeri Görsellerini Silme
### Açıklama
Kullanıcı, yüklenmiş görselleri silebilir. **Sil** butonuna tıklandığında, form `/admin/products/gallery/delete` adresine bir POST isteği gönderir.

```php
<form action="/admin/products/gallery/delete" method="post">
    <input type="hidden" name="image_path" value="<?= htmlspecialchars($image['image_path']) ?>">
    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
    <button type="submit" class="btn btn-secondary btn-sm">Sil</button>
</form>
```

### Açıklamalar
- Kullanıcı **Sil** butonuna bastığında ürünün görseli kaldırılır.
- `image_path` verisi sunucuya gönderilir ve ilgili görsel silinir.
- Görselin başarıyla silinmesi durumunda sayfa yeniden yüklenerek güncellenmiş galeri listelenir.

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Ürün Galerisi</h1>
                <a href="/admin/products" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <form action="/admin/products/gallery/add" method="post" enctype="multipart/form-data">
                <h4>Ürün Adı: <?= htmlspecialchars($product_name ?? '') ?></h4>
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                <div class="mb-3">
                    <label for="gallery_image" class="form-label">Galeri Resmi</label>
                    <input type="file" class="form-control" id="gallery_image" name="gallery_image" required>
                </div>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-secondary">Ekle</button>
                </div>
            </form>
            <div class="row">
                <?php if (empty($gallery_images)): ?>
                    <div class="col-md-12">
                        <div class="alert alert-secondary text-center">Bu ürün için galeri resmi bulunmamaktadır.</div>
                    </div>
                <?php else: ?>
                    <?php foreach ($gallery_images as $image): ?>
                        <div class="col-md-3">
                            <div class="card mb-3">
                                <img src="<?= htmlspecialchars($image['image_path']) ?>" class="card-img-top" alt="...">
                                <div class="card-body text-center">
                                    <form action="/admin/products/gallery/delete" method="post">
                                        <input type="hidden" name="image_path" value="<?= htmlspecialchars($image['image_path']) ?>">
                                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product_id) ?>">
                                        <button type="submit" class="btn btn-secondary btn-sm">Sil</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
```
---

## 5. Sonuç
Bu dokümantasyon, **ürün galerisi** yönetimini sağlayan sayfanın detaylı açıklamasını içermektedir. **PHP, HTML ve Bootstrap** kullanılarak geliştirilmiş bu sistem sayesinde, yöneticiler ürünlerin galeri görsellerini ekleyebilir ve silebilirler.

---

Eğer eklenmesini istediğiniz özellikler veya geliştirilmesi gereken alanlar varsa, geri bildirimlerinizi paylaşabilirsiniz! 🚀


# Ürün Düzenleme Sayfası Dokümantasyonu

Bu doküman, **"Ürün Düzenleme"** sayfasının yapısını ve içeriğini detaylı olarak açıklamaktadır. Sayfa, mevcut bir ürünün bilgilerini düzenlemek ve güncellemek için kullanılır.

---

## **1. Sayfa Bileşenleri**

### **1.1 Sayfa Başlığı ve Geri Dön Butonu**
- **Başlık:** "Ürün Düzenle"
- **Geri Dön Butonu:** Kullanıcının ürün listesini gördüğü ana sayfaya dönmesini sağlar.

```html
<h1 class="h2">Ürün Düzenle</h1>
<a href="/admin/products" class="btn btn-outline-secondary">Geri Dön</a>
```

---

### **1.2 Bildirim Alanları**
- **Başarı Mesajı:** Güncelleme işlemi başarılıysa kullanıcıya gösterilir.
- **Hata Mesajı:** Hata oluştuğunda kullanıcıyı bilgilendirir.

```php
<?php if (isset($success)): ?>
    <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
<?php elseif (isset($error)): ?>
    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>
```

---

## **2. Form Alanları**

### **2.1 Resim Yükleme Alanları**
- **Standart Resim** ve **Hover Resim** yükleme için iki ayrı alan bulunur.
- Eski resimler görsel olarak görüntülenir.
- Kullanıcı yeni bir resim yüklemezse, mevcut resim kullanılmaya devam eder.

```php
<input type="file" class="form-control" id="standard_image" name="standard_image">
<input type="hidden" name="current_standard_image" value="<?= htmlspecialchars($product['standard_image']) ?>">
<img src="<?= htmlspecialchars($product['standard_image']) ?>" alt="Product Image" class="img-fluid mt-2" style="width: 100px;">
```

---

### **2.2 Genel Bilgiler**
- **Ürün Adı**, **Kısa Açıklama** ve **Kategori Seçimi** gibi temel bilgiler girilir.

```php
<input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
<textarea class="form-control" id="short_description" name="short_description" rows="3"><?= htmlspecialchars($product['short_description']) ?></textarea>
<select class="form-control" id="category_id" name="category_id" required>
    <?php foreach ($categories as $category): ?>
        <option value="<?= htmlspecialchars($category['id']) ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
    <?php endforeach; ?>
</select>
```

---

### **2.3 Stok ve Teslimat Bilgileri**
- **Stok Miktarı**, **Teslimat Süresi** girilir.

```php
<input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
<input type="number" class="form-control" id="delivery_date" name="delivery_date" value="<?= htmlspecialchars($product['delivery_date']) ?>" required>
```

---

### **2.4 Öne Çıkan ve Etiket Seçimi**
- Kullanıcı, **Öne Çıkan** ve **Etiket** durumlarını belirleyebilir.

```php
<select class="form-control" id="featured" name="featured" required>
    <option value="none" <?= $product['featured'] == 'none' ? 'selected' : '' ?>>Yok</option>
    <option value="featured" <?= $product['featured'] == 'featured' ? 'selected' : '' ?>>Öne Çıkan</option>
    <option value="bestseller" <?= $product['featured'] == 'bestseller' ? 'selected' : '' ?>>Çok Satan</option>
</select>
```

---

### **2.5 Uzun Açıklama (TinyMCE Editör Entegrasyonu)**
- Uzun açıklamalar için TinyMCE editörü kullanılmaktadır.

```html
<script>
    tinymce.init({
        selector: '#long_description',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>
```

---

## **3. Formu Gönderme ve Güncelleme**

- Form gönderildiğinde **admin/products/update/{id}** adresine POST isteği gönderilir.
- **Kaydet** butonuna basıldığında form verileri gönderilir.

```php
<button type="submit" class="btn btn-secondary">Güncelle</button>
```

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Ürün Düzenle</h1>
                <a href="/admin/products" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/products/update/<?= htmlspecialchars($product['id']) ?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="standard_image" class="form-label">Standart Resim</label>
                    <input type="file" class="form-control" id="standard_image" name="standard_image">
                    <input type="hidden" name="current_standard_image" value="<?= htmlspecialchars($product['standard_image']) ?>">
                    <img src="<?= htmlspecialchars($product['standard_image']) ?>" alt="Product Image" class="img-fluid mt-2" style="width: 100px;">
                </div>
                <div class="mb-3">
                    <label for="hover_image" class="form-label">Hover Resim</label>
                    <input type="file" class="form-control" id="hover_image" name="hover_image">
                    <input type="hidden" name="current_hover_image" value="<?= htmlspecialchars($product['hover_image']) ?>">
                    <img src="<?= htmlspecialchars($product['hover_image']) ?>" alt="Product Image" class="img-fluid mt-2" style="width: 100px;">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Ürün İsmi</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="short_description" class="form-label">Kısa Açıklama</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="3"><?= htmlspecialchars($product['short_description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['id']) ?>" <?= $product['category_id'] == $category['id'] ? 'selected' : '' ?>><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="stock_quantity" class="form-label">Stok Miktarı</label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" value="<?= htmlspecialchars($product['stock_quantity']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="delivery_date" class="form-label">Teslimat Süresi (Gün)</label>
                    <input type="number" class="form-control" id="delivery_date" name="delivery_date" value="<?= htmlspecialchars($product['delivery_date']) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="long_description" class="form-label">Uzun Açıklama</label>
                    <textarea class="form-control" id="long_description" name="long_description" rows="5"><?= htmlspecialchars($product['long_description']) ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="featured" class="form-label">Öne Çıkan</label>
                    <select class="form-control" id="featured" name="featured" required>
                        <option value="none" <?= $product['featured'] == 'none' ? 'selected' : '' ?>>Yok</option>
                        <option value="featured" <?= $product['featured'] == 'featured' ? 'selected' : '' ?>>Öne Çıkan</option>
                        <option value="bestseller" <?= $product['featured'] == 'bestseller' ? 'selected' : '' ?>>Çok Satan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tag" class="form-label">Etiket</label>
                    <select class="form-control" id="tag" name="tag" required>
                        <option value="new" <?= $product['tag'] == 'new' ? 'selected' : '' ?>>Yeni</option>
                        <option value="campaign" <?= $product['tag'] == 'campaign' ? 'selected' : '' ?>>Kampanya</option>
                        <option value="discount" <?= $product['tag'] == 'discount' ? 'selected' : '' ?>>İndirim</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-secondary">Güncelle</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    tinymce.init({
        selector: '#long_description',
        plugins: 'advlist autolink lists link image charmap print preview hr anchor pagebreak',
        toolbar_mode: 'floating',
        setup: function(editor) {
            editor.on('change', function() {
                editor.save();
            });
        }
    });
</script>
```
---

## **Sonuç**
Bu doküman, **"Ürün Düzenleme"** sayfasının iç yapısını, kullanılan kodları ve formların nasıl çalıştığını detaylandırmaktadır. Sayfanın temel amacı, mevcut bir ürünün bilgilerini güncelleyerek sistemde kaydetmektir. İşlemler sırasında TinyMCE gibi ek entegrasyonlar ve resim yükleme mekanizmaları da kullanılmaktadır.


# Yeni Ürün Ekleme Dokümantasyonu

Bu dokümantasyon, **Yeni Ürün Ekle** sayfasının kod yapısını ve çalışma mantığını detaylı bir şekilde açıklamaktadır. 

## Sayfa Yapısı ve Kullanılan Teknolojiler
Bu sayfa, **PHP ve HTML** kullanılarak geliştirilmiştir. Arayüz Bootstrap framework'ü ile şekillendirilmiştir. 
Ayrıca, **TinyMCE** WYSIWYG editörü uzun açıklama alanı için entegre edilmiştir.

---

## **Form Alanları**

### 1. **Standart Resim (Zorunlu)**
- Ürün için görsel seçilmesini sağlar.
- `input type="file"` kullanılır.
- Form `multipart/form-data` olarak ayarlandı.

### 2. **Hover Resim (Opsiyonel)**
- Fare ile ürün üzerine gelindiğinde görünen alternatif görseli belirler.
- `input type="file"` alanı kullanılır.

### 3. **Ürün İsmi (Zorunlu)**
- `input type="text"` alanı kullanılır.
- Boş bırakılamaz.

### 4. **Kısa Açıklama (Opsiyonel)**
- `textarea` etiketi ile tanımlanmıştır.
- Maksimum 3 satır olacak şekilde tasarlanmıştır.

### 5. **Kategori (Zorunlu)**
- `select` etiketi ile **kategori listesi** dinamik olarak getirilir.
- PHP ile `$categories` dizisi döngü kullanılarak listeye eklenir.

### 6. **Stok Miktarı (Zorunlu)**
- `input type="number"` kullanılır.
- Minimum 0 olacak şekilde denetlenir.

### 7. **Teslimat Süresi (Gün) (Zorunlu)**
- `input type="number"` kullanılır.
- Kullanıcıdan gün bazlı bir teslimat süresi alınır.

### 8. **Uzun Açıklama (Opsiyonel)**
- `textarea` etiketi ile tanımlanmıştır.
- **TinyMCE** editörü kullanılarak daha iyi bir yazı deneyimi sunulmuştur.

### 9. **Öne Çıkan (Zorunlu)**
- `select` etiketi ile kullanılır.
- Enum değerleri: **Yok, Öne Çıkan, Çok Satan**

### 10. **Etiket (Zorunlu)**
- `select` etiketi kullanılmıştır.
- Enum değerleri: **Yeni, Kampanya, İndirim**

---

## **Form Çalışma Mantığı**
- **Form verileri POST ile gönderilir.**
- **Görsel yüklemeleri `multipart/form-data` olarak gerçekleşir.**
- **Boş bırakılan alanlar hata mesajı ile kullanıcıya gösterilir.**
- **Eğer başarılıysa, başarı mesajı görüntülenir.**

---

## **TinyMCE Editör Entegrasyonu**
Uzun açıklama alanında kullanılan TinyMCE editörü aşağıdaki gibi entegre edilmiştir:

```js
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
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2">Yeni Ürün Ekle</h1>
                <a href="/admin/products" class="btn btn-outline-secondary">Geri Dön</a>
            </div>
            <?php if (isset($success)): ?>
                <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
            <?php elseif (isset($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>
            <form action="/admin/products/store" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="standard_image" class="form-label">Standart Resim</label>
                    <input type="file" class="form-control" id="standard_image" name="standard_image" required>
                </div>
                <div class="mb-3">
                    <label for="hover_image" class="form-label">Hover Resim</label>
                    <input type="file" class="form-control" id="hover_image" name="hover_image">
                </div>
                <div class="mb-3">
                    <label for="name" class="form-label">Ürün İsmi</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="short_description" class="form-label">Kısa Açıklama</label>
                    <textarea class="form-control" id="short_description" name="short_description" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="category_id" class="form-label">Kategori</label>
                    <select class="form-control" id="category_id" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['id']) ?>"><?= htmlspecialchars($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="stock_quantity" class="form-label">Stok Miktarı</label>
                    <input type="number" class="form-control" id="stock_quantity" name="stock_quantity" required>
                </div>
                <div class="mb-3">
                    <label for="delivery_date" class="form-label">Teslimat Süresi (Gün)</label>
                    <input type="number" class="form-control" id="delivery_date" name="delivery_date" required>
                </div>
                <div class="mb-3">
                    <label for="long_description" class="form-label">Uzun Açıklama</label>
                    <textarea class="form-control" id="long_description" name="long_description" rows="5"></textarea>
                </div>
                <div class="mb-3">
                    <label for="featured" class="form-label">Öne Çıkan</label>
                    <select class="form-control" id="featured" name="featured" required>
                        <option value="none">Yok</option>
                        <option value="featured">Öne Çıkan</option>
                        <option value="bestseller">Çok Satan</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="tag" class="form-label">Etiket</label>
                    <select class="form-control" id="tag" name="tag" required>
                        <option value="new">Yeni</option>
                        <option value="campaign">Kampanya</option>
                        <option value="discount">İndirim</option>
                    </select>
                </div>
                <div class="d-flex justify-content-end mt-4 mb-5">
                    <button type="submit" class="btn btn-secondary">Kaydet</button>
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
Bu dokümantasyon, **yeni ürün ekleme sayfasının** içeriğini detaylı bir şekilde açıklamaktadır. PHP, Bootstrap ve TinyMCE gibi teknolojiler ile geliştirilmiş olan bu sayfa, **dinamik ve kullanışli bir arayüz** sunmaktadır. 

Herhangi bir güncelleme veya ekleme yapılması gerekiyorsa, kodun ilgili bölümlerine yeni fonksiyonlar eklenerek geliştirilebilir. 🚀
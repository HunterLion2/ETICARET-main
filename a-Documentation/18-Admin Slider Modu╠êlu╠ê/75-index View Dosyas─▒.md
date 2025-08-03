# Slider Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Slider Yönetimi** sayfasının işleyişini açıklar. Yönetici, mevcut sliderları listeleyebilir, düzenleyebilir ve silebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3**
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Dinamik veri işleme)
- **jQuery & DataTables** (Tablo yönetimi)

---

## Sayfa Yapısı

### **1. Başlık ve Yeni Slider Ekle Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Slider Yönetimi</h1>
    <a href="/admin/slider/create" class="btn btn-outline-secondary">Yeni Ekle</a>
</div>
```
- **Başlık:** Sayfanın üst kısmında "Slider Yönetimi" başlığı gösterilir.
- **Yeni Ekle Butonu:** Kullanıcıyı yeni bir slider eklemek için `/admin/slider/create` sayfasına yönlendirir.

---

### **2. Sliderları Listeleme**
```html
<table id="sliderTable" class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th class="text-center" style="width: 5%;">#</th>
            <th style="width: 25%;">Resim</th>
            <th style="width: 25%;">Başlık</th>
            <th style="width: 15%;">Sıra</th>
            <th style="width: 10%;">Durum</th>
            <th style="width: 5%;">İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        foreach ($sliders as $slider):
            $index++;
        ?>
        <tr>
            <td class="text-center"><?= $index ?></td>
            <td><img src="<?= htmlspecialchars($slider['image_url']) ?>" alt="Slider Image" class="img-fluid"></td>
            <td><?= htmlspecialchars($slider['title']) ?></td>
            <td class="text-center"><?= htmlspecialchars($slider['sort_order']) ?></td>
            <td class="text-center"><?= $slider['status'] == 1 ? 'Aktif' : 'Pasif' ?></td>
            <td class="text-center">
                <a href="/admin/slider/edit/<?= htmlspecialchars($slider['id']) ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="/admin/slider/delete/<?= htmlspecialchars($slider['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```
- **Slider Listesi:** Mevcut sliderlar listelenir.
- **Her satırda:** 
  - **Resim** → Slider'a ait görsel gösterilir.
  - **Başlık** → Slider'ın başlığı görüntülenir.
  - **Sıra** → Slider'ın sıralama değeri gösterilir.
  - **Durum** → Slider'ın aktif veya pasif olduğu belirtilir.
  - **İşlemler:** Düzenleme ve silme butonları bulunur.

---

### **3. Düzenleme ve Silme İşlemleri**
#### **Düzenleme Butonu**
```html
<a href="/admin/slider/edit/<?= htmlspecialchars($slider['id']) ?>" class="btn btn-secondary btn-sm">
    <i class="fas fa-edit"></i>
</a>
```
- Kullanıcı, **düzenleme** butonuna tıkladığında ilgili slider’ın güncelleme sayfasına yönlendirilir.

#### **Silme Butonu**
```html
<a href="/admin/slider/delete/<?= htmlspecialchars($slider['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
    <i class="fas fa-trash-alt"></i>
</a>
```
- Kullanıcı, **silme** butonuna tıkladığında onay mesajı gösterilir.
- Eğer onay verirse ilgili slider `/admin/slider/delete/{id}` adresine gönderilerek silinir.

---

### **4. DataTables Entegrasyonu**
```javascript
$(document).ready(function() {
    $('#sliderTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
        },
        "ordering": true,
        "columnDefs": [{
            "orderable": false,
            "targets": [0, 5]
        }]
    });
});
```
- **DataTables kullanılarak:**
  - **Dil desteği** Türkçe olarak ayarlanır.
  - **Sıralama** etkinleştirilir.
  - **İlk sütun (#) ve İşlemler sütunu sıralama dışı bırakılır.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Slider Yönetimi</h1>
                <a href="/admin/slider/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="sliderTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 25%;">Resim</th>
                                    <th style="width: 25%;">Başlık</th>
                                    <th style="width: 15%;">Sıra</th>
                                    <th style="width: 10%;">Durum</th>
                                    <th style="width: 5%;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0;
                                foreach ($sliders as $slider):
                                    $index++;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $index ?></td>
                                        <td><img src="<?= htmlspecialchars($slider['image_url']) ?>" alt="Slider Image" class="img-fluid"></td>
                                        <td><?= htmlspecialchars($slider['title']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($slider['sort_order']) ?></td>
                                        <td class="text-center"><?= $slider['status'] == 1 ? 'Aktif' : 'Pasif' ?></td>
                                        <td class="text-center">
                                            <a href="/admin/slider/edit/<?= htmlspecialchars($slider['id']) ?>" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/admin/slider/delete/<?= htmlspecialchars($slider['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#sliderTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 5]
            }]
        });
    });
</script>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Slider Yönetimi** sayfasının işleyişini açıklar. Yönetici, sliderları **listeleyebilir, düzenleyebilir ve silebilir.** 
Ek geliştirmeler için **sürükle-bırak sıralama** veya **durumu anlık değiştirme (AJAX toggle)** gibi özellikler eklenebilir.
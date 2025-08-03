# Kampanya Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Kampanya Yönetimi** sayfasının işleyişini açıklar. Yönetici, mevcut kampanyaları listeleyebilir, düzenleyebilir ve silebilir.

---

## Kullanılan Teknolojiler
- **PHP** (Sunucu tarafı iş mantığı için)
- **HTML5 & CSS3** (Tablo yapısı ve tasarım için)
- **Bootstrap 5** (Responsive tasarım için)
- **jQuery & DataTables** (Tablo filtreleme ve sıralama için)

---

## Sayfa Yapısı

### **1. Başlık ve Yeni Kampanya Ekle Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Kampanya Yönetimi</h1>
    <a href="/admin/deal/create" class="btn btn-outline-secondary">Yeni Ekle</a>
</div>
```
- **Başlık:** "Kampanya Yönetimi" olarak belirlenmiştir.
- **Yeni Ekle Butonu:** Kullanıcıyı kampanya oluşturma sayfasına yönlendirir.

---

### **2. Kampanya Tablosu**
```html
<table id="dealTable" class="table table-bordered table-hover">
```
- **Tüm kampanyalar listelenir.**
- **Kampanyalar sıralanabilir ve filtrelenebilir.**

#### **Tablo Başlıkları**
```html
<thead class="table-light">
    <tr>
        <th class="text-center" style="width: 5%;">#</th>
        <th style="width: 15%;">Başlık</th>
        <th style="width: 30%;">İçerik</th>
        <th style="width: 15%;">Başlangıç Tarihi</th>
        <th style="width: 15%;">Bitiş Tarihi</th>
        <th style="width: 5%;">Durum</th>
        <th style="width: 10%;">İşlemler</th>
    </tr>
</thead>
```
- **Kampanya başlıkları, içerikleri, tarihleri ve durumu görüntülenir.**
- **İşlemler sütununda düzenleme ve silme butonları bulunur.**

#### **Tablo İçeriği**
```php
<?php
$index = 0;
foreach ($deals as $deal):
    $index++;
?>
<tr>
    <td class="text-center"><?= $index ?></td>
    <td><?= htmlspecialchars($deal['title']) ?></td>
    <td><?= htmlspecialchars($deal['content']) ?></td>
    <td class="text-center"><?= htmlspecialchars($deal['start_date']) ?></td>
    <td class="text-center"><?= htmlspecialchars($deal['end_date']) ?></td>
    <td class="text-center"><?= $deal['status'] == 1 ? 'Aktif' : 'Pasif' ?></td>
    <td class="text-center">
        <a href="/admin/deal/edit/<?= htmlspecialchars($deal['id']) ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-edit"></i>
        </a>
        <a href="/admin/deal/delete/<?= htmlspecialchars($deal['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
            <i class="fas fa-trash-alt"></i>
        </a>
    </td>
</tr>
<?php endforeach; ?>
```
- **Her kampanya için dinamik olarak satır oluşturulur.**
- **Düzenleme butonu `/admin/deal/edit/{id}` sayfasına yönlendirir.**
- **Silme butonu `/admin/deal/delete/{id}` rotasına yönlendirir.**

---

### **3. DataTables ile Tablo Fonksiyonları**
```html
<script>
    $(document).ready(function() {
        $('#dealTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 6]
            }]
        });
    });
</script>
```
- **DataTables eklentisi, kampanyaların sıralanabilir ve filtrelenebilir olmasını sağlar.**
- **İlk sütun (#) ve son sütun (İşlemler) sıralamaya kapatılmıştır.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Kampanya Yönetimi</h1>
                <a href="/admin/deal/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="dealTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 15%;">Başlık</th>
                                    <th style="width: 30%;">İçerik</th>
                                    <th style="width: 15%;">Başlangıç Tarihi</th>
                                    <th style="width: 15%;">Bitiş Tarihi</th>
                                    <th style="width: 5%;">Durum</th>
                                    <th style="width: 10%;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0;
                                foreach ($deals as $deal):
                                    $index++;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $index ?></td>
                                        <td><?= htmlspecialchars($deal['title']) ?></td>
                                        <td><?= htmlspecialchars($deal['content']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($deal['start_date']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($deal['end_date']) ?></td>
                                        <td class="text-center"><?= $deal['status'] == 1 ? 'Aktif' : 'Pasif' ?></td>
                                        <td class="text-center">
                                            <a href="/admin/deal/edit/<?= htmlspecialchars($deal['id']) ?>" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/admin/deal/delete/<?= htmlspecialchars($deal['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
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
        $('#dealTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 6]
            }]
        });
    });
</script>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Kampanya Yönetimi** sayfasının işleyişini açıklar. Yönetici, kampanyaları **listeleyebilir, düzenleyebilir ve silebilir.**

Geliştirme olarak:
- **Kampanyalara resim ekleme desteği getirilebilir.**
- **İndirim oranı ve özel promosyon kodları gibi ek özellikler entegre edilebilir.**


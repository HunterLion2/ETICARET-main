# Sayfa Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Sayfa Yönetimi** sayfasının işleyişini açıklar. Yönetici, mevcut sayfaları görüntüleyebilir, düzenleyebilir ve silebilir. Ayrıca yeni bir sayfa ekleyebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3** (Tablo ve form yapıları için)
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Veritabanı işlemleri için)
- **DataTables** (Gelişmiş tablo yönetimi için)
- **JavaScript** (Clipboard kopyalama işlemi için)

---

## Sayfa Yapısı

### **1. Başlık ve Yeni Sayfa Ekle Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Sayfa Yönetimi</h1>
    <a href="/admin/pages/create" class="btn btn-outline-secondary">Yeni Ekle</a>
</div>
```
- **Başlık:** "Sayfa Yönetimi" olarak belirlenmiştir.
- **Yeni Ekle Butonu:** Yönetici, yeni bir sayfa oluşturmak için `/admin/pages/create` sayfasına yönlendirilir.

---

### **2. Sayfa Tablosu**
```html
<table id="pageTable" class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th class="text-center align-middle" style="width: 5%;">#</th>
            <th class="text-left align-middle" style="width: 20%;">Başlık</th>
            <th class="text-left align-middle" style="width: 20%;">Slug</th>
            <th class="text-center align-middle" style="width: 10%;">Durum</th>
            <th class="text-center align-middle" style="width: 10%;">İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        foreach ($pages as $page):
            $index++;
        ?>
        <tr>
            <td class="text-center align-middle"><?= $index ?></td>
            <td class="text-left align-middle"><?= htmlspecialchars($page['title']) ?></td>
            <td class="text-left align-middle">
                <div class="d-flex align-items-center">
                    <span id="slug-<?= $page['id'] ?>"><?= htmlspecialchars($page['slug']) ?></span>
                    <button class="btn btn-outline-secondary btn-sm ms-2" onclick="copyToClipboard('<?= htmlspecialchars($page['slug']) ?>')">
                        <i class="fas fa-copy"></i>
                    </button>
                </div>
            </td>
            <td class="text-center align-middle"><?= htmlspecialchars($page['status']) ?></td>
            <td class="text-center align-middle">
                <a href="/admin/pages/edit/<?= htmlspecialchars($page['id']) ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="/admin/pages/delete/<?= htmlspecialchars($page['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```
- **Başlık:** Sayfanın adı gösterilir.
- **Slug:** Sayfanın URL dostu adı gösterilir ve kopyalama butonu ile URL kopyalanabilir.
- **Durum:** Sayfanın yayında olup olmadığı gösterilir.
- **İşlemler:** Düzenleme ve silme butonları bulunur.

---

### **3. Kopyalama Fonksiyonu**
```html
<script>
    function copyToClipboard(slug) {
        const url = window.location.origin + '/page/' + slug;
        navigator.clipboard.writeText(url).then(function() {
            alert('URL kopyalandı: ' + url);
        }, function(err) {
            console.error('Kopyalama hatası: ', err);
        });
    }
</script>
```
- **Slug bilgisi tıklanınca kopyalanır.**
- **Kullanıcıya "URL kopyalandı" mesajı gösterilir.**

---

### **4. DataTables Entegrasyonu**
```html
<script>
    $(document).ready(function() {
        $('#pageTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 4]
            }]
        });
    });
</script>
```
- **DataTables kullanılarak:**
  - **Dil desteği** Türkçe olarak ayarlanır.
  - **Sıralama özelliği etkinleştirilir.**
  - **İlk sütun (#) ve İşlemler sütunu sıralama dışı bırakılır.**

---
## 📌 **Tam Kod*

```html
<div class="container">
    <div class="row">
        <main class="col-md-12">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Sayfa Yönetimi</h1>
                <a href="/admin/pages/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="pageTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center align-middle" style="width: 5%;">#</th>
                                    <th class="text-left align-middle" style="width: 20%;">Başlık</th>
                                    <th class="text-left align-middle" style="width: 20%;">Slug</th>
                                    <th class="text-center align-middle" style="width: 10%;">Durum</th>
                                    <th class="text-center align-middle" style="width: 10%;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0;
                                foreach ($pages as $page):
                                    $index++;
                                ?>
                                    <tr>
                                        <td class="text-center align-middle"><?= $index ?></td>
                                        <td class="text-left align-middle"><?= htmlspecialchars($page['title']) ?></td>
                                        <td class="text-left align-middle">
                                            <div class="d-flex align-items-center">
                                                <span id="slug-<?= $page['id'] ?>"><?= htmlspecialchars($page['slug']) ?></span>
                                                <button class="btn btn-outline-secondary btn-sm ms-2" onclick="copyToClipboard('<?= htmlspecialchars($page['slug']) ?>')">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle"><?= htmlspecialchars($page['status']) ?></td>
                                        <td class="text-center align-middle">
                                            <a href="/admin/pages/edit/<?= htmlspecialchars($page['id']) ?>" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/admin/pages/delete/<?= htmlspecialchars($page['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu kaydı silmek istediğinize emin misiniz?');">
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
    function copyToClipboard(slug) {
        const url = window.location.origin + '/page/' + slug;
        navigator.clipboard.writeText(url).then(function() {
            alert('URL kopyalandı: ' + url);
        }, function(err) {
            console.error('Kopyalama hatası: ', err);
        });
    }
    $(document).ready(function() {
        $('#pageTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 4]
            }]
        });
    });
</script>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Sayfa Yönetimi** sayfasının işleyişini açıklar. Yönetici, sayfaları **görüntüleyebilir, düzenleyebilir ve silebilir.** Ayrıca **yeni sayfa ekleyebilir ve slug bilgilerini kopyalayabilir.** Geliştirme olarak **sayfa önizleme özelliği** veya **durumu anlık değiştirme (AJAX toggle)** gibi özellikler eklenebilir.
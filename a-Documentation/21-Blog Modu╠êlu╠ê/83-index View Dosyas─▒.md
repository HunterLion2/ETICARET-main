# Blog Yönetimi Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Blog Yönetimi** sayfasının işleyişini açıklar. Yönetici, mevcut blog yazılarını listeleyebilir, düzenleyebilir ve silebilir. Ayrıca yeni bir blog yazısı ekleyebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3** (Tablo ve form yapıları için)
- **Bootstrap 5** (Responsive tasarım)
- **PHP** (Veritabanı işlemleri için)
- **DataTables** (Gelişmiş tablo yönetimi için)
- **JavaScript & jQuery** (Tablo yönetimi için)

---

## Sayfa Yapısı

### **1. Başlık ve Yeni Blog Ekle Butonu**
```html
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2 py-0 px-3">Blog Yönetimi</h1>
    <a href="/admin/blogs/create" class="btn btn-outline-secondary">Yeni Ekle</a>
</div>
```
- **Başlık:** "Blog Yönetimi" olarak belirlenmiştir.
- **Yeni Ekle Butonu:** Yönetici, yeni bir blog yazısı oluşturmak için `/admin/blogs/create` sayfasına yönlendirilir.

---

### **2. Blog Yazıları Tablosu**
```html
<table id="blogTable" class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th class="text-center" style="width: 5%;">#</th>
            <th style="width: 25%;">Kapak Resmi</th>
            <th style="width: 25%;">Başlık</th>
            <th style="width: 15%;">Yayınlanma Tarihi</th>
            <th style="width: 5%;">İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        foreach ($posts as $post):
            $index++;
        ?>
        <tr>
            <td class="text-center"><?= $index ?></td>
            <td><img src="<?= htmlspecialchars($post['thumbnail_url']) ?>" alt="Blog Thumbnail" class="img-fluid"></td>
            <td><?= htmlspecialchars($post['title']) ?></td>
            <td class="text-center"><?= htmlspecialchars($post['published_at']) ?></td>
            <td class="text-center">
                <a href="/admin/blogs/edit/<?= htmlspecialchars($post['id']) ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="/admin/blogs/delete/<?= htmlspecialchars($post['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu yazıyı silmek istediğinize emin misiniz?');">
                    <i class="fas fa-trash-alt"></i>
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```
- **Kapak Resmi:** Blog yazısına ait görsel gösterilir.
- **Başlık:** Blog yazısının adı gösterilir.
- **Yayınlanma Tarihi:** Blogun yayınlandığı tarih belirtilir.
- **İşlemler:** Düzenleme ve silme butonları bulunur.

---

### **3. DataTables Entegrasyonu**
```html
<script>
    $(document).ready(function() {
        $('#blogTable').DataTable({
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
                <h1 class="h2 py-0 px-3">Blog Yönetimi</h1>
                <a href="/admin/blogs/create" class="btn btn-outline-secondary">Yeni Ekle</a>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="blogTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 25%;">Kapak Resmi</th>
                                    <th style="width: 25%;">Başlık</th>
                                    <th style="width: 15%;">Yayınlanma Tarihi</th>
                                    <th style="width: 5%;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0;
                                foreach ($posts as $post):
                                    $index++;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $index ?></td>
                                        <td><img src="<?= htmlspecialchars($post['thumbnail_url']) ?>" alt="Blog Thumbnail" class="img-fluid"></td>
                                        <td><?= htmlspecialchars($post['title']) ?></td>
                                        <td class="text-center"><?= htmlspecialchars($post['published_at']) ?></td>
                                        <td class="text-center">
                                            <a href="/admin/blogs/edit/<?= htmlspecialchars($post['id']) ?>" class="btn btn-secondary btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="/admin/blogs/delete/<?= htmlspecialchars($post['id']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Bu yazıyı silmek istediğinize emin misiniz?');">
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
        $('#blogTable').DataTable({
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

Bu dokümantasyon, **Admin Paneli - Blog Yönetimi** sayfasının işleyişini açıklar. Yönetici, blog yazılarını **görüntüleyebilir, düzenleyebilir ve silebilir.** Ayrıca **yeni blog yazısı ekleyebilir ve yayınlanma tarihlerini görebilir.** Geliştirme olarak **önizleme özelliği** veya **etiket kategorisi ekleme** gibi özellikler eklenebilir.
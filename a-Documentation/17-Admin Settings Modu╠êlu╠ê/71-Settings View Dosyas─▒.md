# Site Ayarları Yönetim Paneli Dokümantasyonu

## Genel Bakış

Bu dokümantasyon, **Admin Paneli - Site Ayarları Yönetimi** sayfasının yapısını ve işleyişini açıklar. Yönetici, site ayarlarını görüntüleyebilir ve güncelleyebilir.

---

## Kullanılan Teknolojiler
- **HTML5 & CSS3**
- **Bootstrap 5** (Responsive tasarım)
- **jQuery & AJAX** (Dinamik veri işlemleri)
- **DataTables** (Tablo yönetimi)
- **PHP** (Sunucu taraflı veri işleme)

---

## Sayfa Yapısı

### **1. Genel Yerleşim**
```html
<div class="container">
    <div class="row">
        <main class="col-md-12">
            <h1 class="h2 py-0 px-3">Site Ayarları</h1>
        </main>
    </div>
</div>
```

- `container` genel kapsayıcıyı oluşturur.
- `row` içinde **Site Ayarları** başlığı bulunur.

---

### **2. Ayarları Listeleme**

```html
<table id="settingsTable" class="table table-bordered table-hover">
    <thead class="table-light">
        <tr>
            <th class="text-center" style="width: 5%;">#</th>
            <th style="width: 20%;">Ayar Anahtarı</th>
            <th style="width: 70%;">Ayar Değeri</th>
            <th style="width: 5%;">İşlemler</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $index = 0;
        foreach ($settings as $key => $value):
            $index++;
        ?>
        <tr>
            <td class="text-center"><?= $index ?></td>
            <td class="bg-secondary text-white"><?= htmlspecialchars($key) ?></td>
            <td><?= htmlspecialchars($value) ?></td>
            <td class="text-center">
                <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editSettingModal" data-key="<?= htmlspecialchars($key) ?>" data-value="<?= htmlspecialchars($value) ?>">
                    <i class="fas fa-edit"></i>
                </button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
```

- **`settingsTable`**: Ayarları listeleyen bir DataTable.
- **Her satırda** ayar anahtarı, değeri ve düzenleme butonu bulunur.
- **Düzenleme butonu** modal penceresini açar.

---

### **3. Ayar Güncelleme Modalı**

```html
<div class="modal fade" id="editSettingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editSettingForm">
                <div class="modal-header">
                    <h5 class="modal-title">Ayar Düzenle</h5>
                </div>
                <div class="modal-body">
                    <label for="settingKey">Ayar Anahtarı</label>
                    <input type="text" id="settingKey" name="key" class="form-control" readonly>
                    <label for="settingValue">Ayar Değeri</label>
                    <input type="text" id="settingValue" name="value" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-secondary">Kaydet</button>
                </div>
            </form>
        </div>
    </div>
</div>
```

- **Düzenleme Formu (`editSettingForm`)**
  - `settingKey`: Güncellenen ayarın anahtarını içerir (readonly).
  - `settingValue`: Yeni değer girişi yapılır.

---

### **4. JavaScript İşlevselliği**

#### **Tablo Yapılandırması**
```javascript
$(document).ready(function() {
    $('#settingsTable').DataTable({
        "language": {
            "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
        },
        "ordering": true,
        "columnDefs": [{ "orderable": false, "targets": [0, 3] }]
    });
});
```

- **DataTables** kullanılarak ayarların sıralanması sağlanır.

#### **Modal Veriyi Yükleme**
```javascript
$('#editSettingModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget);
    var key = button.data('key');
    var value = button.data('value');

    var modal = $(this);
    modal.find('#settingKey').val(key);
    modal.find('#settingValue').val(value);
});
```

- **Düzenleme butonuna tıklandığında**, modal içine ilgili ayar yüklenir.

#### **Ayar Güncelleme İşlemi**
```javascript
$('#editSettingForm').on('submit', function(event) {
    event.preventDefault();
    $.ajax({
        url: '/admin/settings/updateSetting',
        type: 'POST',
        data: $(this).serialize(),
        success: function(response) {
            var result = JSON.parse(response);
            var alertMessage = $('#alertMessage');
            if (result.status === 'success') {
                alertMessage.addClass('alert-success').text(result.message).removeClass('d-none');
                $('#settingsTable').find('button[data-key="' + $('#settingKey').val() + '"]').closest('tr').find('td:eq(2)').text($('#settingValue').val());
            } else {
                alertMessage.addClass('alert-danger').text(result.message).removeClass('d-none');
            }
        }
    });
});
```

- **AJAX kullanılarak** ayar güncelleme işlemi yapılır.
- **Başarılı güncelleme sonrası** tablo güncellenir.

---

```html
<div class="container">
    <div class="row">
        <main class="col-md-12 ">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                <h1 class="h2 py-0 px-3">Site Ayarları</h1>
            </div>
            <div class="container my-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table id="settingsTable" class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th class="text-center" style="width: 5%;">#</th>
                                    <th style="width: 20%;">Ayar Anahtarı</th>
                                    <th style="width: 70%;">Ayar Değeri</th>
                                    <th style="width: 5%;">İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $index = 0; // Sıra numarası için
                                foreach ($settings as $key => $value):
                                    $index++;
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $index ?></td>
                                        <td class="bg-secondary text-white"><?= htmlspecialchars($key) ?></td>
                                        <td><?= htmlspecialchars($value) ?></td>
                                        <td class="text-center">
                                            <button class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#editSettingModal" data-key="<?= htmlspecialchars($key) ?>" data-value="<?= htmlspecialchars($value) ?>">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Düzenleme Modalı -->
            <div class="modal fade" id="editSettingModal" tabindex="-1" aria-labelledby="editSettingModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="editSettingForm">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editSettingModalLabel">Ayar Düzenle</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="alertMessage" class="alert d-none" role="alert"></div>
                                <div class="mb-3">
                                    <label for="settingKey" class="form-label">Ayar Anahtarı</label>
                                    <input type="text" id="settingKey" name="key" class="form-control" readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="settingValue" class="form-label">Ayar Değeri</label>
                                    <input type="text" id="settingValue" name="value" class="form-control" required autocomplete="off">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary">Kaydet</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script>
    $(document).ready(function() {
        var table = $('#settingsTable').DataTable({
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.11.5/i18n/tr.json"
            },
            "ordering": true,
            "columnDefs": [{
                "orderable": false,
                "targets": [0, 3]
            }]
        });

        $('#editSettingModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var key = button.data('key');
            var value = button.data('value');

            var modal = $(this);
            modal.find('#settingKey').val(key);
            modal.find('#settingValue').val(value);
        });

        $('#editSettingForm').on('submit', function(event) {
            event.preventDefault();

            $.ajax({
                url: '/admin/settings/updateSetting',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    var result = JSON.parse(response);
                    var alertMessage = $('#alertMessage');

                    if (result.status === 'success') {
                        alertMessage.removeClass('d-none alert-danger').addClass('alert-success').text(result.message);
                        var key = $('#settingKey').val();
                        var value = $('#settingValue').val();
                        table.cell($('button[data-key="' + key + '"]').closest('tr').find('td:eq(2)')).data(value).draw();
                    } else {
                        alertMessage.removeClass('d-none alert-success').addClass('alert-danger').text(result.message);
                    }
                }
            });
        });

        $('#editSettingModal').on('hidden.bs.modal', function() {
            $('#alertMessage').addClass('d-none').removeClass('alert-success alert-danger').text('');
        });
    });
</script>
```
---

## **Sonuç**

Bu dokümantasyon, **Admin Paneli - Site Ayarları Yönetimi** sayfasının işleyişini açıklar. Yönetici, ayarları kolayca görüntüleyebilir ve güncelleyebilir. **AJAX ile anlık güncellenebilirlik** sağlanmıştır. Geliştirmeler için ek güvenlik doğrulamaları veya ayar silme özelliği eklenebilir.


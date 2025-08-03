# Kullanıcı Menü Bileşeni

Bu dokümanda, kullanıcı profil, sipariş ve çıkış işlemlerini yönetmek için bir menü bileşeni oluşturacağız. Bu bileşen, **Bootstrap** kullanarak büyük ekranlarda kart yapısı, küçük ekranlarda ise bir açılır menü şeklinde tasarlanmıştır.

## 📌 Kullanım Senaryosu
Bu bileşen, kullanıcıların **Profilim, Siparişlerim** ve **Çıkış Yap** bağlantılarına erişimini sağlar. **Mevcut sayfaya göre aktif sekme vurgulanır**.

## 💻 HTML Kodu

Aşağıdaki kod, menüyü oluşturur:

```html
<div class="col-md-3">
    <div class="card d-none d-md-block">
        <div class="card-header">
            <h4 class="mb-0">Menü</h4>
        </div>
        <div class="list-group list-group-flush">
            <a href="/customer" class="list-group-item list-group-item-action <?php echo $currentUrl == '/customer' ? 'bg-secondary text-white' : ''; ?>">Profilim</a>
            <a href="/order" class="list-group-item list-group-item-action <?php echo $currentUrl == '/order' ? 'bg-secondary text-white' : ''; ?>">Siparişlerim</a>
            <a href="/logout" class="list-group-item list-group-item-action <?php echo $currentUrl == '/logout' ? 'bg-secondary text-white' : ''; ?>">Çıkış Yap</a>
        </div>
    </div>
    <div class="d-block d-md-none my-3">
        <select class="form-select" onchange="location = this.value;">
            <option value="/customer" <?php echo $currentUrl == '/customer' ? 'selected' : ''; ?>>Profilim</option>
            <option value="/order" <?php echo $currentUrl == '/order' ? 'selected' : ''; ?>>Siparişlerim</option>
            <option value="/logout" <?php echo $currentUrl == '/logout' ? 'selected' : ''; ?>>Çıkış Yap</option>
        </select>
    </div>
</div>
```

## 🛠 Açıklamalar
1. **Büyük ekranlar için kart menü:**
    - `d-none d-md-block` sınıfı ile küçük ekranlarda gizlenir.
    - `list-group-item` sınıfı, **Bootstrap List Group** bileşeni ile uyumlu hale getirir.
    - **Mevcut sayfa belirleme:** `<?php echo $currentUrl == '/customer' ? 'bg-secondary text-white' : ''; ?>`
      - Eğer mevcut URL `/customer` ise, bağlantının arka plan rengi değişir.

2. **Küçük ekranlar için açılır menü:**
    - `d-block d-md-none` sınıfı ile sadece mobilde görünür.
    - `onchange="location = this.value;"` özelliği, seçim yapıldığında sayfayı yönlendirir.
    
## 🎨 Stil
Bileşen, **Bootstrap 5**'in varsayılan sınıflarını kullanır. Eğer ek stil vermek isterseniz, aşağıdaki gibi düzenlemeler yapabilirsiniz:

```css
.list-group-item {
    transition: background 0.3s;
}
.list-group-item:hover {
    background: #f8f9fa;
}
```
## 📌 **Tam Kod*

---
```html
<div class="col-md-3">
    <div class="card d-none d-md-block">
        <div class="card-header">
            <h4 class="mb-0">Menü</h4>
        </div>
        <div class="list-group list-group-flush">
            <a href="/customer" class="list-group-item list-group-item-action <?php echo $currentUrl == '/customer' ? 'bg-secondary text-white' : ''; ?>">Profilim</a>
            <a href="/order" class="list-group-item list-group-item-action <?php echo $currentUrl == '/order' ? 'bg-secondary text-white' : ''; ?>">Siparişlerim</a>
            <a href="/logout" class="list-group-item list-group-item-action <?php echo $currentUrl == '/logout' ? 'bg-secondary text-white' : ''; ?>">Çıkış Yap</a>
        </div>
    </div>
    <div class="d-block d-md-none my-3">
        <select class="form-select" onchange="location = this.value;">
            <option value="/customer" <?php echo $currentUrl == '/customer' ? 'selected' : ''; ?>>Profilim</option>
            <option value="/order" <?php echo $currentUrl == '/order' ? 'selected' : ''; ?>>Siparişlerim</option>
            <option value="/logout" <?php echo $currentUrl == '/logout' ? 'selected' : ''; ?>>Çıkış Yap</option>
        </select>
    </div>
</div>
```
---

## 🚀 Sonuç
Bu bileşen, **kullanıcı dostu ve responsive** bir menü yapısı sağlar. Hem büyük ekranlar hem de mobil cihazlar için optimize edilmiştir.


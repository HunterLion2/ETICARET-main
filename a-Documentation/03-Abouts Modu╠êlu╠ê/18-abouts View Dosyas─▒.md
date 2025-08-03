# **abouts.php View Dosyasının Kullanımı**
 
Bu eğitim dokümanında, **PHP ile bir View (görünüm) dosyasının nasıl oluşturulacağını** ve **Hakkında sayfasının nasıl dinamik olarak yönetileceğini** öğreneceksiniz. **abouts.php** dosyası, `about` tablosundan gelen verileri kullanıcıya göstermek için tasarlanmıştır.

---

## **1. Sayfa Yapısının Oluşturulması**

```html
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6">Kurumsal</h1>
        <i class="fas fa-building fa-3x text-secondary"></i>
    </div>
    <hr>
```

### **Ne İşe Yarar?**
✅ **`container mt-5 mb-5`** → Sayfanın içeriğini ortalar ve üst-alt boşluk ekler.
✅ **`d-flex justify-content-between align-items-center`** → Başlık ve ikonu hizalar.
✅ **`display-6`** → Bootstrap başlık stilini kullanarak büyük ve belirgin bir başlık oluşturur.
✅ **`fa-building fa-3x`** → Font Awesome ikonuyla **kurumsal simge** ekler.

---

## **2. Vizyon ve Misyon Kartları**

```html
<div class="row">
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Vizyonumuz</h2>
                <p class="card-text"><?= $about['vision']; ?></p>
            </div>
        </div>
    </div>
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Misyonumuz</h2>
                <p class="card-text"><?= $about['mission']; ?></p>
            </div>
        </div>
    </div>
</div>
```

### **Ne İşe Yarar?**
✅ **Bootstrap grid sistemi** kullanılarak **iki sütun halinde vizyon ve misyon bölümleri oluşturulur**.
✅ `<?= $about['vision']; ?>` ve `<?= $about['mission']; ?>` **PHP değişkenleri ile veritabanından gelen veriler sayfaya yansıtılır.**
✅ `card-body` → Bootstrap **kart bileşeni kullanılarak** profesyonel bir tasarım oluşturulur.

---

## **3. Firma Özgeçmişi Bölümü**

```html
<div class="row mt-4">
    <div class="col-md-12">
        <h2>Firmamızın Özgeçmişi</h2>
        <p><?= $about['biography']; ?></p>
```

### **Ne İşe Yarar?**
✅ `col-md-12` ile **tam genişlikte bir alan** kullanılır.
✅ **Firmaya ait özgeçmiş bilgileri veritabanından çağrılarak** kullanıcıya gösterilir.

---

## **4. Firma ve Ekip Resimlerinin Gösterimi**

```html
<div class="clearfix">
    <img src="<?= $about['image1']; ?>" class="col-md-4 float-md-end mb-3 ms-md-3 img-fluid rounded" alt="Firmamız">
    <p><?= $about['biography']; ?></p>
</div>

<div class="clearfix">
    <img src="<?= $about['image2']; ?>" class="col-md-4 float-md-start mb-3 me-md-3 img-fluid rounded" alt="Ekibimiz">
    <p><?= $about['biography']; ?></p>
</div>
```

### **Ne İşe Yarar?**
✅ `float-md-end` ve `float-md-start` ile **görseller metne göre hizalanır**.
✅ `img-fluid rounded` ile **görseller responsive hale getirilir ve köşeleri yuvarlatılır**.
✅ `<?= $about['image1']; ?>` ve `<?= $about['image2']; ?>` kullanılarak **veritabanından gelen resimler otomatik olarak yüklenir.**

---

## 📌 **Tam Kod*

```html
<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center">
        <h1 class="display-6">Kurumsal</h1>
        <i class="fas fa-building fa-3x text-secondary"></i>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Vizyonumuz</h2>
                    <p class="card-text"><?= $about['vision']; ?></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Misyonumuz</h2>
                    <p class="card-text"><?= $about['mission']; ?></p>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
            <h2>Firmamızın Özgeçmişi</h2>
            <p><?= $about['biography']; ?></p>
            <div class="clearfix">
                <img src="<?= $about['image1']; ?>" class="col-md-4 float-md-end mb-3 ms-md-3 img-fluid rounded" alt="Firmamız">
                <p><?= $about['biography']; ?></p>
            </div>
            <div class="clearfix">
                <img src="<?= $about['image2']; ?>" class="col-md-4 float-md-start mb-3 me-md-3 img-fluid rounded" alt="Ekibimiz">
                <p><?= $about['biography']; ?></p>
            </div>
        </div>
    </div>
</div>
```
—

## **Sonuç**

Bu eğitimde **abouts.php görünüm dosyasının nasıl oluşturulacağını, dinamik verilerin nasıl gösterileceğini ve sayfanın tasarımının nasıl düzenleneceğini** öğrendiniz. Şimdi öğrendiklerinizi projelerinizde uygulayabilirsiniz! 🚀
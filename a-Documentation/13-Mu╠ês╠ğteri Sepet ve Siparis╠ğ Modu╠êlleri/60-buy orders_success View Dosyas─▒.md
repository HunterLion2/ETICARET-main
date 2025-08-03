# Ödeme Başarılı Sayfası - Eğitim Dokümanı

Bu dokümanda, e-ticaret sitelerinde bir kullanıcının ödemesi başarıyla tamamlandığında gösterilecek "Ödeme Başarılı" sayfasını oluşturacağız.

## İçerik
Bu sayfa, kullanıcıya siparişinin başarıyla tamamlandığını bildiren bir mesaj, sipariş numarası ve siparişlerin görüntülenebileceği bir yönlendirme butonu içerir.

---

## HTML Kodu
Aşağıda, başarılı ödeme sayfasını oluşturan HTML kodu bulunmaktadır:

```html
<div class="container mt-20 mb-5">
    <div style="margin-top:120px !important; margin-bottom:170px !important" class="d-flex flex-column align-items-center mt-20 mb-5">
        <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
        <h1 class="display-4 text-center">Ödeme Başarılı!</h1>
        <p class="lead text-center">Siparişiniz başarıyla tamamlandı.</p>
        <p class="text-center">Sipariş Numaranız: <strong><?= htmlspecialchars($conversationId) ?></strong></p>
        <div class="d-flex justify-content-center mt-3">
            <a href="/" class="btn btn-secondary me-2">Alışverişe Devam Et</a>
            <a href="/order" class="btn btn-secondary">Siparişlerim</a>
        </div>
    </div>
</div>
```

## İşlevsellik
Bu sayfa aşağıdaki özelliklere sahiptir:
- **Başarı mesajı**: Kullanıcıya ödeme işleminin tamamlandığını bildirir.
- **Sipariş numarası gösterimi**: Kullanıcı, siparişini takip edebilmesi için sipariş numarasını görebilir.
- **Yönlendirme butonları**:
  - "Alışverişe Devam Et": Kullanıcını tekrar anasayfaya götürür.
  - "Siparişlerim": Kullanıcının siparişlerini görebileceği sayfaya yönlendirir.

## Kullanılan Teknolojiler
- **HTML & Bootstrap**: Sayfa yapısını düzenlemek ve mobil uyumlu hale getirmek için kullanılır.
- **FontAwesome**: Başarı ikonu için kullanılmaktadır.
- **PHP htmlspecialchars() fonksiyonu**: XSS saldırılarına karşı koruma sağlamak için sipariş numarası gösterimi sırasında kullanılmıştır.

---
## 📌 **Tam Kod*

```html
<div class="container mt-20 mb-5">
    <div style="margin-top:120px !important; margin-bottom:170px !important" class="d-flex flex-column align-items-center mt-20 mb-5">
        <i class="fas fa-check-circle fa-5x text-success mb-3"></i>
        <h1 class="display-4 text-center">Ödeme Başarılı!</h1>
        <p class="lead text-center">Siparişiniz başarıyla tamamlandı.</p>
        <p class="text-center">Sipariş Numaranız: <strong><?= htmlspecialchars($conversationId) ?></strong></p>
        <div class="d-flex justify-content-center mt-3">
            <a href="/" class="btn btn-secondary me-2">Alışverişe Devam Et</a>
            <a href="/order" class="btn btn-secondary">Siparişlerim</a>
        </div>
    </div>
</div>
```
---

## Sonuç
Bu çalışma, e-ticaret siteleri için başarılı bir ödeme sayfasının nasıl hazırlanabileceğini göstermektedir. Geliştirme yaparken, tasarımın kullanıcı dostu ve anlaşılabilir olmasına dikkat edilmelidir.
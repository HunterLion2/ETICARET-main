# ETİCARETv5 Yönetim Paneli Footer

## Genel Bakış
ETİCARETv5 yönetim panelinin alt bilgi (footer) bölümü, sayfanın en altında yer alarak telif hakkı bilgilerini göstermektedir. Footer, sayfanın tüm bölümlerinde görünecek şekilde tasarlanmıştır ve dinamik içerik sunmamaktadır.

---

## Kullanılan Teknolojiler
- **HTML5**: Footer yapısı oluşturulmuş.
- **Bootstrap 5**: Arayüz elemanlarının hizalanması ve responsive uyumluluk sağlanmış.
- **CSS (Bootstrap sınıfları)**: Arkaplan rengi, yazı rengi ve margin/padding ayarlamaları için kullanılmış.

---

## Yapı ve Bileşenler
### 1. **Footer İçeriği**
Footer, tüm sayfaların alt kısmında sabit bir telif hakkı mesajı göstermek için tasarlanmıştır.

#### HTML Yapısı
```html
<footer class="foot bg-dark text-white mt-auto py-3">
    <div class="container">
        <div class="text-center mt-2">
            <p>&copy; 2025 Eticaretv5 Admin Panel. Tüm hakları saklıdır.</p>
        </div>
    </div>
</footer>
```

#### Açıklamalar:
- `<footer>` etiketi, web sayfasının alt kısmındaki bilgileri temsil eder.
- **Sınıflar (Classes):**
  - `bg-dark`: Arka plan rengini koyu yapar.
  - `text-white`: Metin rengini beyaz yapar.
  - `mt-auto`: Sayfanın geri kalan kısmının tamamını kullanmasını sağlar.
  - `py-3`: Üst ve alt boşluk (padding) ekler.
- **`container`**: İçeriğin düzgün hizalanmasını sağlar.
- **`text-center`**: İçeriğin yatayda ortalanmasını sağlar.
- **Copyright (`&copy; 2025`)**: Dinamik olarak yıl bilgisi değiştirilebilir.

---
## 📌 **Tam Kod*

```html
<footer class="foot bg-dark text-white mt-auto py-3">
    <div class="container">
        <div class="text-center mt-2">
            <p>&copy; 2025 Eticaretv5 Admin Panel. Tüm hakları saklıdır.</p>
        </div>
    </div>
</footer>
```
---

## Sonuç
ETİCARETv5 footer yapısı basit ve işlevsel bir şekilde tasarlanmıştır. Bootstrap kullanımı ile kolayca responsive hale getirilmiştir. Dinamik yıl güncellemesi ve ek fonksiyonlarla geliştirilebilir bir yapıdadır.


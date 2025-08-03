# **Database İşlemleri ve Veritabanı Yapısının Oluşturulması**

Bu bölümde, **veritabanı yapımızı oluşturma** sürecini ele alacağız. Model işlemlerine geçmeden önce, ihtiyacımız olan **database (veritabanı) yapısını** oluşturup yapılandırmamız gerekiyor.

## **1. Veritabanı Dosyasını Temin Etme**

Eğitim kapsamında kullanacağımız veritabanı dosyasını aşağıdaki yerlerde bulabilirsiniz:

- Dersin ekinde **phpeticaretv5dev.sql** dosyası olarak.
- Eğitmeninizin yönlendirdiği platformda veya paylaşım alanında.

Eğer dosyayı temin ettiyseniz, **içeri aktarma (import)** işlemini gerçekleştirebiliriz.

---

## **2. phpMyAdmin Üzerinden Veritabanı İçe Aktarma**

### **Adım 1: phpMyAdmin’e Giriş Yapın**

Öncelikle tarayıcınız üzerinden **phpMyAdmin**’i açın. Genellikle aşağıdaki adreslerden birini kullanabilirsiniz:

- **Herd Kullanıyorsanız:** `https://phpmyadmin.test`
- **XAMPP Kullanıyorsanız:** `http://localhost/phpmyadmin`
- **WAMP Kullanıyorsanız:** `http://localhost/phpmyadmin`
- **Live Server (Canlı Sunucu) Kullanıyorsanız:** Hosting veya VPS hizmetinizin sunduğu phpMyAdmin adresine gidin.

### **Adım 2: Yeni Bir Veritabanı Oluşturun**

1. **phpMyAdmin** içinde **Veritabanları (Databases)** sekmesine tıklayın.
2. Yeni bir veritabanı adı girin (örneğin: `eticaret`).
3. **Karakter Seti (Collation)** olarak `utf8mb4_turkish_ci` seçin.
4. **Oluştur (Create)** butonuna tıklayın.

### **Adım 3: SQL Dosyasını İçe Aktarın**

1. Üst menüden **İçe Aktar (Import)** sekmesine gidin.
2. **Gözat (Choose File)** butonuna tıklayarak **phpeticaretv5dev.sql** dosyanızı seçin.
3. **Dosya biçimi** olarak `SQL` seçili olduğundan emin olun.
4. **Yürüt (Go)** butonuna basarak içe aktarma işlemini başlatın.

Eğer işlem başarıyla tamamlandıysa, **veritabanı tabloları oluşturulmuş** olacaktır.

---

## **4. Dummy (Test) Verilerinin Kullanımı**

**phpeticaretv5dev.sql** dosyası içerisinde **dummy (örnek) veriler** bulunmaktadır. Bu sayede, veritabanını içe aktardığınızda **test ortamı için gerekli olan tüm veriler de otomatik olarak yüklenmiş olacaktır**. Bu test verileri sayesinde:

- **Kullanıcı hesapları, ürünler, ve diğer veritabanı tabloları önceden doldurulmuş olacak.**
- **E-ticaret sisteminizi hemen test etmeye başlayabileceksiniz.**
- **Geliştirme sürecinde ihtiyacınız olan örnek verilerle fonksiyonları rahatça deneyebileceksiniz.**

Bu veriler, gerçek bir sistem simülasyonu yapmak için oluşturulmuştur ve test amaçlı kullanılabilir.

---

Bu aşamaları tamamladıktan sonra, artık **Model işlemlerine** geçmeye hazırız! 🎯


# Kullanıcı Kayıt ve Giriş Görünümleri

Bu dokümanda **kayıt (register)** ve **giriş (login)** görünümleri açıklanmaktadır. Her iki sayfa da kullanıcıların kayıt olmasını ve giriş yapmasını sağlamak için geliştirilmiştir.

## Kayıt (Register) Sayfası

Kullanıcılar, aşağıdaki formu kullanarak sisteme kayıt olabilirler.

### Özellikler:
- **Ad, e-posta, şifre ve telefon numarası alanları** bulunur.
- **Şifre göster/gizle** özelliği eklenmiştir.
- **Telefon numarası doğrulama** işlemi için regex kullanılmıştır.
- **KVKK ve Aydınlatma Metni kabul kutusu** eklenmiştir.
- Kullanıcıya hata veya başarı mesajları görüntülenir.

```html
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs justify-content-center mb-3" id="loginTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="login-tab" href="/login" role="tab">Giriş yap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="register-tab" href="/register" role="tab">Üye ol</a>
                        </li>
                    </ul>
                    <form method="POST" action="/register/submit">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Ad Soyad" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="E-posta adresi" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Şifre" required>
                            <i class="fas fa-eye position-absolute" id="togglePassword" style="top: 12px; right: 15px; cursor: pointer;"></i>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="text" class="form-control" name="phone" id="phone" placeholder="Telefon Numarası (05XXXXXXXXX)" required autocomplete="off">
                            <small id="phoneHelp" class="form-text text-muted" style="display: none;">Telefon numarası 05XXXXXXXXX formatında olmalıdır.</small>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="kvkkCheck" required>
                            <label class="form-check-label" for="kvkkCheck">
                                <a href="/page/kvkk-ve-aydinlatma-metni" target="_blank">KVKK ve Aydınlatma Metni</a>'ni okudum ve kabul ediyorum.
                            </label>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100">Üye ol</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

## 📌 **Tam Kod register*

```html
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs justify-content-center mb-3" id="loginTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="login-tab" href="/login" role="tab" aria-controls="login" aria-selected="true">
                                Giriş yap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="register-tab" href="/register" role="tab" aria-controls="register" aria-selected="false">
                                Üye ol
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="loginTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form method="POST" action="/register/submit">
                                <div class="mb-3">
                                    <input type="text" class="form-control" name="name" placeholder="Ad Soyad" required>
                                </div>
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="E-posta adresi" required>
                                </div>
                                <div class="mb-3 position-relative">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Şifre" required>
                                    <i class="fas fa-eye position-absolute" id="togglePassword" style="top: 12px; right: 15px; cursor: pointer;"></i>
                                </div>

                                <div class="mb-3 position-relative">
                                    <input type="text" class="form-control" name="phone" id="phone" placeholder="Telefon Numarası (05XXXXXXXXX)" required autocomplete="off">
                                    <small id="phoneHelp" class="form-text text-muted" style="display: none;">Telefon numarası 05XXXXXXXXX formatında olmalıdır.</small>
                                </div>
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="kvkkCheck" required>
                                    <label class="form-check-label" for="kvkkCheck">
                                        <a href="/page/kvkk-ve-aydinlatma-metni" target="_blank">KVKK ve Aydınlatma Metni</a>'ni okudum ve kabul ediyorum.
                                    </label>
                                </div>
                                <?php if (isset($success)): ?>
                                    <div class="alert alert-secondary"><?php echo $success; ?></div>
                                <?php endif; ?>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                <button type="submit" class="btn btn-secondary w-100">Üye ol</button>
                            </form>
                            <div class="separator">veya</div>

                            <button class="btn btn-outline-secondary w-100" type="button" onclick="showApiKeyAlert()">Cep Telefonu ile Giriş Yap</button>
                            <button class="btn btn-outline-secondary w-100 mt-2" type="button" onclick="showApiKeyAlert()">Mail ile Giriş Yap</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showApiKeyAlert() {
        alert("API KEY'ler girilmemiş. Lütfen sistem yöneticinizle iletişime geçin.");
    }

    document.getElementById('phone').addEventListener('input', function(e) {
        const phoneInput = e.target;
        const phoneHelp = document.getElementById('phoneHelp');
        const phonePattern = /^0\d{10}$/;

        if (!phonePattern.test(phoneInput.value)) {
            phoneHelp.style.display = 'block';
        } else {
            phoneHelp.style.display = 'none';
        }
    });

    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>
```
---

## Giriş (Login) Sayfası

Kullanıcılar aşağıdaki formu kullanarak sisteme giriş yapabilirler.

### Özellikler:
- **E-posta ve şifre alanları** bulunur.
- **Şifre göster/gizle** özelliği eklenmiştir.
- Kullanıcıya hata mesajları görüntülenir.
- Kullanıcı şifresini unuttuysa "Şifremi Unuttum" bağlantısı yer alır.

```html
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs justify-content-center mb-3" id="loginTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" href="/login" role="tab">Giriş yap</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" href="/register" role="tab">Üye ol</a>
                        </li>
                    </ul>
                    <form method="POST" action="/login/submit">
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="E-posta adresi" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <input type="password" class="form-control" name="password" id="password" placeholder="Şifre" required>
                            <i class="fas fa-eye position-absolute" id="togglePassword" style="top: 12px; right: 15px; cursor: pointer;"></i>
                        </div>
                        <div class="mb-3 text-end">
                            <a href="#" class="text-decoration-none text-secondary">Şifremi unuttum</a>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100">Giriş yap</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
```

## Ekstra Özellikler

### Şifre Göster/Gizle İşlevselliği
Aşağıdaki JavaScript kodu, şifre alanının gösterilmesini veya gizlenmesini sağlar.

```javascript
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
```

### Telefon Numarası Doğrulama
Telefon numarası girişini belirli bir formata uygun hale getirmek için regex kullanılmıştır.

```javascript
    document.getElementById('phone').addEventListener('input', function(e) {
        const phoneInput = e.target;
        const phoneHelp = document.getElementById('phoneHelp');
        const phonePattern = /^0\d{10}$/;

        if (!phonePattern.test(phoneInput.value)) {
            phoneHelp.style.display = 'block';
        } else {
            phoneHelp.style.display = 'none';
        }
    });
```

## 📌 **Tam Kod login*

```html
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <ul class="nav nav-tabs justify-content-center mb-3" id="loginTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="login-tab" href="/login" role="tab" aria-controls="login" aria-selected="true">
                                Giriş yap
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="register-tab" href="/register" role="tab" aria-controls="register" aria-selected="false">
                                Üye ol
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content" id="loginTabContent">
                        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
                            <form method="POST" action="/login/submit">
                                <div class="mb-3">
                                    <input type="email" class="form-control" name="email" placeholder="E-posta adresi" value="course@emrahyuksel.com.tr" required>
                                </div>
                                <div class="mb-3 position-relative">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Şifre" value="111111" required>
                                    <i class="fas fa-eye position-absolute" id="togglePassword" style="top: 12px; right: 15px; cursor: pointer;"></i>
                                </div>
                                <?php if (isset($error)): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                <div class="mb-3 text-end">
                                    <a href="#" class="text-decoration-none text-secondary">Şifremi unuttum</a>
                                </div>
                                <button type="submit" class="btn btn-secondary w-100">Giriş yap</button>
                            </form>
                            <div class="separator">veya</div>
                            <button class="btn btn-outline-secondary w-100 mb-2" type="button" onclick="showApiKeyAlert()">Cep Telefonu ile Giriş Yap</button>
                            <button class="btn btn-outline-secondary w-100" type="button" onclick="showApiKeyAlert()">Mail ile Giriş Yap</button>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function showApiKeyAlert() {
        alert("API KEY'ler girilmemiş. Lütfen sistem yöneticinizle iletişime geçin.");
    }

    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>
```
---

Bu doküman, kayıt ve giriş sayfalarının nasıl çalıştığını ve temel doğrulama işlemlerinin nasıl yapıldığını anlamanıza yardımcı olacaktır.


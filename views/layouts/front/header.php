<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $settings['site_title']; ?></title>
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="/css/styles.css">
</head>

<body>
    <div class="bg-secondary text-white text-center py-2">
        <a href="/admin" class="text-white" style="font-size: 0.8em; font-weight: bold;">Yönetim Paneli için Tıklayın</a>
    </div>
    <div class="text-center" id="loading">
        <p><b>Edukey ETicaretV5 Eğitim Sürümü</b><br>Yükleniyor Lütfen Bekleyin...</p>
    </div>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">

            <a class="navbar-brand" href="/" style="line-height: 0.7; margin-top: 10px;">
                ETicaret<span style="font-weight:bold;">V5</span><br>
                <small style="font-size: 0.5em;">Edukey tarafından eğitim amaçlı üretilmiştir.</small>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active text-decoration-none" aria-current="page" href="/"><i class="fas fa-home"></i> Anasayfa</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-th-list"></i> Kategoriler
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php foreach ($categories as $category): ?>
                                <li>
                                    <a class="dropdown-item text-decoration-none" href="/category/<?php echo htmlspecialchars($category['slug']); ?>">
                                        <i class="<?php echo htmlspecialchars($category['icon']); ?>"></i>
                                        <?php echo htmlspecialchars($category['name']); ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none" href="/abouts"><i class="fas fa-building"></i> Kurumsal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none" href="/blog"><i class="fas fa-blog"></i> Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-decoration-none" href="/contact"><i class="fas fa-envelope"></i> İletişim</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <?php if (isset($session['user_id'])): ?>
                            <?php if ($cartItemCount > 0): ?>
                                <a class="nav-link text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepetim (<?php echo $cartItemCount; ?>)</a>
                            <?php else: ?>
                                <a class="nav-link text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepet Boş</a>
                            <?php endif; ?>
                        <?php else: ?>
                            <a class="nav-link text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepet Boş</a>
                        <?php endif; ?>
                    </li>

                        <!-- Aşşağıda ki kodun değerlendirilmesi şudur.if değeri ile user_id gelen değerin var olup olmamasına bakarız.
                         -->

                    <?php if (isset($session['user_id'])): ?>
                        <?php
                        $nameParts = explode(' ', $session['user_name']); // explode değeri içerisine girilen değerin yani mesela user_name değeri içerisinde eğer birden fazla değer varsa bu değerleri diziye dönüştürür.
                        $firstName = $nameParts[0]; // Buradan da diziye dönüştürülen değerleri çağırırız.
                        $lastNameInitial = isset($nameParts[1]) ? $nameParts[1][0] . '.' : '';
                        ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> <?php echo htmlspecialchars($firstName) . ' ' . htmlspecialchars($lastNameInitial); ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item text-decoration-none" href="/customer"><i class="fas fa-user"></i> Profil</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/order"><i class="fas fa-receipt"></i> Siparişlerim</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepetim</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/logout"><i class="fas fa-sign-out-alt"></i> Çıkış Yap</a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-decoration-none" href="#" id="loginDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-user"></i> Giriş Yap
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="loginDropdown">
                                <li><a class="dropdown-item text-decoration-none" href="/login"><i class="fas fa-sign-in-alt"></i> Giriş Yap</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/register"><i class="fas fa-user-plus"></i> Üye Ol</a></li>
                                <li><a class="dropdown-item text-decoration-none" href="/cart"><i class="fas fa-shopping-cart"></i> Sepetim</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>
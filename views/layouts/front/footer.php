<footer class="bg-dark text-white py-5" style="position: relative;">
    <div class="container" style="margin-top: auto;">
        <div class="row">
            <div class="col-md-3">
                <h5>Eticaretv5</h5>
                <p>En iyi ürünleri en uygun fiyatlarla sunan online alışveriş platformu.</p>
            </div>
            <div class="col-md-3">
                <h5>Kategoriler</h5>
                <ul class="list-unstyled">
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="/category/<?php echo htmlspecialchars($category['slug']); ?>" class="text-white text-decoration-none">
                                <?php echo htmlspecialchars($category['name']); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="col-md-3">
                <h5>Kurumsal</h5>
                <ul class="list-unstyled">
                    <li><a href="/abouts" class="text-white text-decoration-none">Hakkımızda</a></li>
                    <li><a href="/blog" class="text-white text-decoration-none">Blog</a></li>
                    <li><a href="/page/gizlilik-politikasi" class="text-white text-decoration-none">Gizlilik Politikası</a></li>
                    <li><a href="/page/mesafeli-satis-sozlemesi" class="text-white text-decoration-none">Mesafeli Satış Sözleşmesi</a></li>
                    <li><a href="/page/teslimat-ve-iade-sartlari" class="text-white text-decoration-none">Teslimat ve İade Şartları</a></li>
                    <li><a href="/page/kvkk-ve-aydinlatma-metni" class="text-white text-decoration-none">KVKK ve Aydınlatma Metni</a></li>



                </ul>
            </div>
            <div class="col-md-3">
                <h5>İletişim</h5>
                <p><i class="fas fa-map-marker-alt"></i> <?php echo $settings['contact_address']; ?></p>
                <p><i class="fas fa-phone"></i> Telefon: <?php echo $settings['contact_phone']; ?></p>
                <p><i class="fas fa-envelope"></i> Email: <?php echo $settings['contact_email']; ?>/p>
            </div>
        </div>
        <div class="text-center mt-4">
            <p>&copy; 2025 EticaretV5. EDUKEY tarafından Eğitim Amaçlı Yazılmıştır Tüm hakları saklıdır.</p>
        </div>
    </div>

    <script src="/js/bootstrap.bundle.min.js"></script>
    <script src="/js/scripts.js"></script>
</footer>
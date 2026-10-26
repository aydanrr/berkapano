<?php
/**
 * Berka Pano - Yenilenen Ana Sayfa
 * Urbanist Fontu, Düzeltilmiş Modern Banner, Kaldırılan Medya ve Özellikler
 * SEO Uyumlu Başlık Hiyerarşisi (H1, H2, H3) ve Yumuşak Hatlar
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/lang.php';

$pageTitle = localized($settings, 'site_title');

// Öne Çıkan Ürünler
$stmtProd = $db->query("SELECT * FROM products ORDER BY is_featured DESC, sort_order ASC LIMIT 6");
$featuredProducts = $stmtProd->fetchAll();

require_once __DIR__ . '/inc/header.php';
?>

<!-- 1. TAM ALAN ARKA PLAN GÖRSELLİ VE OKUNAKLI YAZILI MODERN BANNER -->
<section class="hero-full-banner">
    <div class="hero-bg-media">
        <img src="images/<?= e($settings['hero_image'] ?? 'berkapano1.jpg') ?>" 
             alt="Berkapano Endüstriyel Pano Sistemleri" 
             class="hero-full-img">
        <div class="hero-full-overlay"></div>
    </div>

    <div class="container hero-full-container">
        <div class="hero-full-content-box">
            <h1 class="hero-full-title">
                Endüstriyel Güç Dağıtım ve Otomasyon Panoları
            </h1>
            
            <p class="hero-full-desc">
                Ağır sanayi, ticari yapılar ve otomasyon tesisleri için tip testli, uluslararası IEC normlarında yüksek güvenlikli modüler elektrik panoları imalatı.
            </p>
            
            <div class="hero-actions">
                <a href="https://wa.me/905434504542?text=Merhaba,%20fiyat%20teklifi%20almak%20istiyorum." target="_blank" rel="noopener" class="btn btn-primary" style="background: #2563eb; box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);">
                    Hemen Teklif Al &rarr;
                </a>
                <a href="products.php" class="btn btn-outline" style="border-color: rgba(255,255,255,0.4); color: #ffffff; background: rgba(255,255,255,0.08); backdrop-filter: blur(8px);">
                    <?= t('discover_products') ?>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- 2. RAKAMLARLA BERKAPANO (İstatistik Şeridi) -->
<section class="container">
    <div class="stats-ribbon">
        <div class="stats-grid">
            <div>
                <div class="stat-item-num"><?= t('stat_1_num') ?></div>
                <div class="stat-item-title"><?= t('stat_1_title') ?></div>
            </div>
            <div>
                <div class="stat-item-num"><?= t('stat_2_num') ?></div>
                <div class="stat-item-title"><?= t('stat_2_title') ?></div>
            </div>
            <div>
                <div class="stat-item-num"><?= t('stat_3_num') ?></div>
                <div class="stat-item-title"><?= t('stat_3_title') ?></div>
            </div>
            <div>
                <div class="stat-item-num"><?= t('stat_4_num') ?></div>
                <div class="stat-item-title"><?= t('stat_4_title') ?></div>
            </div>
        </div>
    </div>
</section>

<!-- 3. ÖNE ÇIKAN ÇÖZÜMLERİMİZ & ÜRÜNLER (H2 Başlık) -->
<section class="section-wrapper" style="background: #ffffff;">
    <div class="container">
        <div class="section-head">
            <div>
                <span class="section-tag"><?= t('featured_products') ?></span>
                <h2 class="section-title">Üretimini Yaptığımız Endüstriyel Pano Çözümleri</h2>
            </div>
            <a href="products.php" class="btn btn-outline" style="padding: 10px 22px;">
                <?= t('all_products') ?> &rarr;
            </a>
        </div>

        <div class="product-grid">
            <?php foreach ($featuredProducts as $prod): ?>
                <div class="product-card">
                    <div class="product-img-wrap">
                        <span class="product-tag"><?= e($prod['category']) ?></span>
                        <img src="images/<?= e($prod['image']) ?>" alt="<?= e(localized($prod, 'title')) ?>">
                    </div>
                    <div class="product-content">
                        <h3 class="product-title"><?= e(localized($prod, 'title')) ?></h3>
                        <p class="product-desc"><?= e(localized($prod, 'short_desc')) ?></p>
                        <a href="https://wa.me/905434504542?text=Merhaba,%20<?= urlencode(localized($prod, 'title')) ?>%20hakkinda%20bilgi%20ve%20fiyat%20almak%20istiyorum." target="_blank" rel="noopener" class="btn btn-primary" style="width: 100%; border-radius: var(--radius-md);">
                            WhatsApp ile Teklif İste
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- 4. DOĞRULANMIŞ MÜŞTERİ DEĞERLENDİRMELERİ (Sade & Prestijli) -->
<section class="section-wrapper" style="background: var(--color-bg-subtle);">
    <div class="container">
        <div style="text-align: center; max-width: 680px; margin: 0 auto 44px;">
            <span class="section-tag">GÜVEN VE MEMNUNİYET</span>
            <h2 class="section-title">Doğrulanmış Müşteri Değerlendirmeleri</h2>
            <p style="color: var(--color-text-muted); font-size: 1.05rem;">
                Sanayi tesisleri, şantiyeler ve otomasyon projelerinde Berka Pano kalitesini tercih eden iş ortaklarımızın geri bildirimleri.
            </p>
        </div>

        <div class="testimonial-grid">
            <!-- Yorum 1 -->
            <div class="testimonial-card">
                <div>
                    <div class="stars-row">
                        ★★★★★
                    </div>
                    <p class="testimonial-text">
                        "Çukurova bölgesindeki un fabrikamızın tüm ana dağıtım ve kompanzasyon panolarını Berka Pano teslim etti. 3 yıldır sıfır arıza ve reaktif cezasız kesintisiz üretim yapıyoruz."
                    </p>
                </div>
                <div class="testimonial-author">
                    <div>
                        <div class="author-name">
                            Murat Yılmaz
                            <span class="verified-badge">✓ Doğrulandı</span>
                        </div>
                        <div class="author-role">Fabrika Müdürü, Adana</div>
                    </div>
                </div>
            </div>

            <!-- Yorum 2 -->
            <div class="testimonial-card">
                <div>
                    <div class="stars-row">
                        ★★★★★
                    </div>
                    <p class="testimonial-text">
                        "MCC motor kontrol panolarında kablolama düzeni, ABB sürücü montajı ve etiketleme mühendislik harikasıydı. Şantiye devreye alma sürecinde çok destek oldular."
                    </p>
                </div>
                <div class="testimonial-author">
                    <div>
                        <div class="author-name">
                            Engin Kaya
                            <span class="verified-badge">✓ Doğrulandı</span>
                        </div>
                        <div class="author-role">Elektrik Başmühendisi, Mersin</div>
                    </div>
                </div>
            </div>

            <!-- Yorum 3 -->
            <div class="testimonial-card">
                <div>
                    <div class="stars-row">
                        ★★★★★
                    </div>
                    <p class="testimonial-text">
                        "Özel paslanmaz dış ortam panolarında malzeme kalitesi ve IP sızdırmazlık standartları beklentimizin çok üzerinde çıktı. Zamanında teslimat için teşekkürler."
                    </p>
                </div>
                <div class="testimonial-author">
                    <div>
                        <div class="author-name">
                            Serdar Taşçı
                            <span class="verified-badge">✓ Doğrulandı</span>
                        </div>
                        <div class="author-role">Proje Müteahhidi, Hatay</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 5. SIKÇA SORULAN SORULAR (SSS) -->
<section class="section-wrapper" style="background: #ffffff;">
    <div class="container">
        <div style="text-align: center; max-width: 680px; margin: 0 auto 40px;">
            <span class="section-tag">MERAK EDİLENLER</span>
            <h2 class="section-title">Sıkça Sorulan Sorular</h2>
            <p style="color: var(--color-text-muted); font-size: 1.05rem;">
                Panolarımızın teknik özellikleri, tip testleri ve sipariş süreçleriyle ilgili en çok sorulan sorular.
            </p>
        </div>

        <div class="faq-list">
            <div class="faq-item">
                <button class="faq-question" type="button">
                    <span>Panolarınız hangi standartlara ve tip testlerine uygundur?</span>
                    <span class="faq-icon">↓</span>
                </button>
                <div class="faq-answer">
                    Tüm imalatlarımız uluslararası IEC 61439-1 ve IEC 61439-2 standartlarına tam uyumlu olarak üretilmektedir. Talebe göre Form 2B'den Form 4B'ye kadar iç bölmelendirme ve IP55/IP65 sızdırmazlık koruma sınıfında teslimat yapılmaktadır.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    <span>Projeye özel ebat ve şalt malzeme seçimi yapabiliyor muyuz?</span>
                    <span class="faq-icon">↓</span>
                </button>
                <div class="faq-answer">
                    Evet. Tesisinizin gereksinimlerine göre özel projelendirme yapıyoruz. Schneider Electric, Siemens, ABB, Eaton gibi dünya lideri şalt malzeme markalarıyla müşterimizin onayladığı teknik şartnameye uygun imalat gerçekleştiriyoruz.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    <span>Teklif ve teslimat süreniz ne kadardır?</span>
                    <span class="faq-icon">↓</span>
                </button>
                <div class="faq-answer">
                    Teknik şartname ve tek hat şeması iletildikten sonra en geç 24 saat içerisinde detaylı fiyat teklifimiz hazırlanır. İmalat süresi projenin büyüklüğüne göre belirlenip taahhüt edilen tarihte eksiksiz fabrikasyon testleri tamamlanarak sevk edilir.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-question" type="button">
                    <span>Şantiye veya sahada devreye alma desteğiniz var mı?</span>
                    <span class="faq-icon">↓</span>
                </button>
                <div class="faq-answer">
                    Evet, talebiniz doğrultusunda uzman mühendis ve teknisyen kadromuz sahada montaj kontrolü, dielektrik izolasyon testleri ve devreye alma süpervizörlük hizmeti sunmaktadır.
                </div>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Accordion Etkileşim Scripti -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(btn => {
            btn.addEventListener('click', () => {
                const item = btn.parentElement;
                item.classList.toggle('active');
            });
        });
    });
</script>

<!-- 6. KURUMSAL VURGU & ÇÖZÜM ORTAKLIĞI -->
<section class="section-wrapper" style="background: var(--color-bg-subtle);">
    <div class="container" style="text-align: center; max-width: 860px;">
        <span class="section-tag">GÜVENİLİR ENERJİ DAĞITIMI</span>
        <h2 class="section-title" style="margin-bottom: 18px;">Projelerinize Özel Mühendislik ve İmalat</h2>
        <p style="font-size: 1.15rem; color: var(--color-text-muted); line-height: 1.8; margin-bottom: 30px;">
            Berka Pano olarak Adana Seyhan'daki tesislerimizde ana dağıtım panoları, MCC motor kontrol panoları, kompanzasyon ve paslanmaz saha kutularını en yüksek kalite normlarıyla üretiyoruz.
        </p>
        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="tel:05434504542" class="btn btn-primary" style="font-size: 1.05rem; padding: 14px 32px;">
                Bizi Arayın: 0543 450 45 42
            </a>
            <a href="contact.php" class="btn btn-outline" style="font-size: 1.05rem; padding: 14px 32px;">
                İletişim ve Konum Bilgileri
            </a>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/inc/footer.php'; ?>

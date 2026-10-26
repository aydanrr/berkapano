<?php
/**
 * Berka Pano - Dinamik Kurumsal Sayfalar (Hakkımızda, Kalite Politikamız, Referanslar)
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/lang.php';

$slug = $_GET['slug'] ?? 'hakkimizda';

$stmt = $db->prepare("SELECT * FROM pages WHERE slug = ? AND is_active = 1");
$stmt->execute([$slug]);
$page = $stmt->fetch();

if (!$page) {
    header("Location: index.php");
    exit;
}

$pageTitle = localized($page, 'title');

require_once __DIR__ . '/inc/header.php';
?>

<!-- Sayfa Başlığı ve Banner -->
<div style="background: var(--color-primary-dark); color: #fff; padding: 70px 0; border-bottom-left-radius: var(--radius-xl); border-bottom-right-radius: var(--radius-xl); position: relative; overflow: hidden;">
    <div class="container" style="position: relative; z-index: 2;">
        <span class="section-tag" style="color: #38bdf8;"><?= t('nav_corporate') ?></span>
        <h1 style="font-size: 2.6rem; font-weight: 800; font-family: var(--font-display); margin-bottom: 8px;">
            <?= e(localized($page, 'title')) ?>
        </h1>
        <p style="color: #94a3b8; font-size: 0.95rem;">
            <?= e($settings['company_name'] ?? 'Berka Pano') ?> &bull; <?= e(localized($page, 'title')) ?>
        </p>
    </div>
</div>

<div class="container section-wrapper">
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; align-items: start;">
        <!-- Ana İçerik -->
        <div style="background: #fff; padding: 40px; border-radius: var(--radius-xl); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light); line-height: 1.8; font-size: 1.02rem; color: var(--color-text-main);">
            <?php if (!empty($page['banner_image'])): ?>
                <div style="border-radius: var(--radius-lg); overflow: hidden; margin-bottom: 30px; max-height: 380px;">
                    <img src="images/<?= e($page['banner_image']) ?>" alt="<?= e(localized($page, 'title')) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
            <?php endif; ?>
            
            <div class="page-body-content">
                <?= localized($page, 'content') ?>
            </div>
        </div>

        <!-- Yan Panel / Hızlı Menü -->
        <div>
            <div style="background: var(--color-bg-card); padding: 30px; border-radius: var(--radius-xl); box-shadow: var(--shadow-sm); border: 1px solid var(--color-border-light); margin-bottom: 24px;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: var(--color-primary); margin-bottom: 16px; font-family: var(--font-display);">
                    <?= t('nav_corporate') ?>
                </h3>
                <?php
                $otherPages = $db->query("SELECT slug, title_tr, title_en FROM pages WHERE is_active = 1 ORDER BY sort_order ASC")->fetchAll();
                ?>
                <ul style="list-style: none;">
                    <?php foreach ($otherPages as $op): ?>
                        <li style="margin-bottom: 10px;">
                            <a href="page.php?slug=<?= e($op['slug']) ?>" 
                               style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border-radius: var(--radius-md); font-weight: 600; font-size: 0.9rem; background: <?= ($slug === $op['slug']) ? 'var(--color-bg-subtle)' : 'transparent' ?>; color: <?= ($slug === $op['slug']) ? 'var(--color-accent)' : 'var(--color-text-main)' ?>;">
                                <span><?= e(localized($op, 'title')) ?></span>
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Hızlı İletişim Kartı -->
            <div style="background: linear-gradient(135deg, var(--color-primary-dark), var(--color-primary)); color: #fff; padding: 32px; border-radius: var(--radius-xl); text-align: center;">
                <h4 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 10px; font-family: var(--font-display);">Özel Proje Çözümleri</h4>
                <p style="font-size: 0.88rem; color: #cbd5e1; margin-bottom: 20px;">Teknik şartnamenizi gönderin, uzman mühendis ekibimiz projenizi hemen fiyatlandırsın.</p>
                <a href="contact.php" class="btn btn-primary" style="background: #38bdf8; color: #0f172a; width: 100%;">
                    <?= t('nav_quote') ?>
                </a>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>

<?php
/**
 * Berka Pano - Ürünler Listesi Sayfası
 * Kategori filtreleme, arama ve teknik özellikler
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/inc/config.php';
require_once __DIR__ . '/inc/lang.php';

$pageTitle = t('nav_products');

$selectedCat = $_GET['cat'] ?? null;

if ($selectedCat) {
    $stmt = $db->prepare("SELECT * FROM products WHERE category LIKE ? ORDER BY sort_order ASC, id DESC");
    $stmt->execute(['%' . $selectedCat . '%']);
} else {
    $stmt = $db->query("SELECT * FROM products ORDER BY sort_order ASC, id DESC");
}
$products = $stmt->fetchAll();

// Mevcut benzersiz kategorileri al
$categories = $db->query("SELECT DISTINCT category FROM products WHERE category IS NOT NULL AND category != ''")->fetchAll(PDO::FETCH_COLUMN);

require_once __DIR__ . '/inc/header.php';
?>

<div style="background: var(--color-primary-dark); color: #fff; padding: 60px 0; border-bottom-left-radius: var(--radius-xl); border-bottom-right-radius: var(--radius-xl);">
    <div class="container" style="text-align: center;">
        <span class="section-tag" style="color: #38bdf8;"><?= t('nav_products') ?></span>
        <h1 style="font-size: 2.4rem; font-weight: 800; font-family: var(--font-display); margin-bottom: 12px;"><?= t('featured_products') ?></h1>
        <p style="color: #cbd5e1; max-width: 600px; margin: 0 auto;"><?= t('featured_products_desc') ?></p>
    </div>
</div>

<div class="container section-wrapper">
    <!-- Kategori Filtre Butonları (Yumuşak Hap Butonlar) -->
    <div style="display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-bottom: 40px;">
        <a href="products.php" class="btn <?= empty($selectedCat) ? 'btn-primary' : 'btn-outline' ?>" style="padding: 8px 18px; font-size: 0.85rem;">
            <?= t('all_products') ?>
        </a>
        <?php foreach ($categories as $cat): ?>
            <a href="products.php?cat=<?= urlencode($cat) ?>" 
               class="btn <?= ($selectedCat === $cat) ? 'btn-primary' : 'btn-outline' ?>" 
               style="padding: 8px 18px; font-size: 0.85rem;">
                <?= e($cat) ?>
            </a>
        <?php endforeach; ?>
    </div>

    <!-- Ürünler Izgarası -->
    <div class="product-grid">
        <?php if (empty($products)): ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px; color: var(--color-text-muted);">
                <h3>Bu kategoride henüz ürün bulunmuyor.</h3>
            </div>
        <?php else: ?>
            <?php foreach ($products as $prod): ?>
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
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/inc/footer.php'; ?>

<?php
/**
 * Berka Pano - Header & Navigasyon Bileşeni
 * Font: Urbanist
 * Logo: Düz Yazıyla Berkapano (İkon kaldırıldı)
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

if (!isset($db)) {
    require_once __DIR__ . '/config.php';
}
if (!isset($currentLang)) {
    require_once __DIR__ . '/lang.php';
}

$settings = getSettings($db);
$pageTitle = $pageTitle ?? localized($settings, 'site_title');
?>
<!DOCTYPE html>
<html lang="<?= e($currentLang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | <?= e($settings['company_name'] ?? 'Berkapano') ?></title>
    <meta name="description" content="<?= e(localized($settings, 'site_tagline')) ?>">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" type="image/png" href="images/berkapano1.jpg">
</head>
<body>

    <!-- Üst İletişim & Dil Seçim Barı -->
    <header class="topbar">
        <div class="container topbar-content">
            <div class="topbar-items">
                <div class="topbar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 01-2.18 2 19.79 19.79 0 01-8.63-3.07 19.5 19.5 0 01-6-6 19.79 19.79 0 01-3.07-8.67A2 2 0 014.11 2h3a2 2 0 012 1.72 12.84 12.84 0 00.7 2.81 2 2 0 01-.45 2.11L8.09 9.91a16 16 0 006 6l1.27-1.27a2 2 0 012.11-.45 12.84 12.84 0 002.81.7A2 2 0 0122 16.92z"/></svg>
                    <a href="tel:<?= preg_replace('/\s+/', '', $settings['phone'] ?? '05434504542') ?>"><?= e($settings['phone'] ?? '0543 450 45 42') ?></a>
                </div>
                <div class="topbar-item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <span>Seyhan / Adana</span>
                </div>
            </div>
            <div class="topbar-actions">
                <div class="lang-switch">
                    <a href="?lang=tr" class="lang-btn <?= $currentLang === 'tr' ? 'active' : '' ?>">TR</a>
                    <a href="?lang=en" class="lang-btn <?= $currentLang === 'en' ? 'active' : '' ?>">EN</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Ana Navigasyon Çubuğu -->
    <div class="site-header">
        <div class="container navbar">
            <!-- Düz Yazıyla Berkapano Logosu (İkon Kaldırıldı) -->
            <a href="index.php" class="logo">
                Berkapano
            </a>

            <button class="mobile-menu-btn" id="mobileMenuToggle" aria-label="Menü">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
            </button>

            <!-- Header Navigasyon Menüsü -->
            <ul class="nav-menu" id="navMenu">
                <li><a href="index.php" class="nav-link"><?= t('nav_home') ?></a></li>
                <li><a href="page.php?slug=hakkimizda" class="nav-link"><?= t('nav_about') ?></a></li>
                <li><a href="products.php" class="nav-link"><?= t('nav_products') ?></a></li>
                <li><a href="page.php?slug=kalite-politikamiz" class="nav-link"><?= t('nav_corporate') ?></a></li>
                <li><a href="page.php?slug=referanslar" class="nav-link"><?= t('nav_references') ?></a></li>
                <li><a href="contact.php" class="nav-link"><?= t('nav_contact') ?></a></li>
            </ul>

            <div class="nav-cta">
                <a href="https://wa.me/905434504542?text=Merhaba,%20pano%20fiyat%20teklifi%20almak%20istiyorum." target="_blank" rel="noopener" class="btn btn-primary"><?= t('nav_quote') ?></a>
            </div>
        </div>
    </div>

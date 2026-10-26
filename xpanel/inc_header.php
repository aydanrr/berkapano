<?php
/**
 * Berka Pano - xpanel Üst Bar ve Navigasyon Menüsü
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

if (!isset($_SESSION['admin_user'])) {
    header("Location: login.php");
    exit;
}

$currentUser = $_SESSION['admin_user'];
$activePage = $activePage ?? '';

// Okunmamış mesaj sayısı
$unreadCount = (int)$db->query("SELECT COUNT(*) FROM contact_messages WHERE is_read = 0")->fetchColumn();
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($adminTitle ?? 'Yönetim Paneli') ?> | Berka Pano</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="../images/berkapano1.jpg">
</head>
<body>

    <!-- Yan Menü (Sidebar) -->
    <aside class="admin-sidebar">
        <div class="admin-sidebar-header">
            <div>
                <h3 style="font-size: 1.15rem; font-weight: 800; color: #fff; letter-spacing: 0.5px; margin: 0;">BERKA PANO</h3>
                <span style="font-size: 0.74rem; color: #94a3b8; font-weight: 600;">Yönetim Paneli</span>
            </div>
        </div>

        <nav class="admin-nav">
            <a href="index.php" class="admin-nav-item <?= $activePage === 'dashboard' ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                <span>Başlangıç</span>
            </a>

            <a href="settings.php" class="admin-nav-item <?= $activePage === 'settings' ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                <span>Genel Site Ayarları</span>
            </a>

            <a href="products.php" class="admin-nav-item <?= $activePage === 'products' ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                <span>Ürünler Yönetimi</span>
            </a>

            <a href="features.php" class="admin-nav-item <?= $activePage === 'features' ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                <span>01-02-03 Kart Alanları</span>
            </a>

            <a href="media.php" class="admin-nav-item <?= $activePage === 'media' ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                <span>Medya & Haberler</span>
            </a>

            <a href="pages.php" class="admin-nav-item <?= $activePage === 'pages' ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                <span>Kurumsal Sayfalar</span>
            </a>

            <a href="messages.php" class="admin-nav-item <?= $activePage === 'messages' ? 'active' : '' ?>">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <span>Gelen Mesajlar</span>
                <?php if ($unreadCount > 0): ?>
                    <span class="badge-tag badge-danger" style="margin-left: auto;"><?= $unreadCount ?></span>
                <?php endif; ?>
            </a>
        </nav>

        <div style="padding: 16px; border-top: 1px solid rgba(255, 255, 255, 0.08);">
            <a href="../index.php" target="_blank" class="admin-nav-item" style="color: #94a3b8; font-size: 0.84rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                <span>Siteyi Görüntüle</span>
            </a>
            <a href="logout.php" class="admin-nav-item" style="color: #f87171; font-size: 0.84rem;">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                <span>Çıkış Yap</span>
            </a>
        </div>
    </aside>

    <!-- Mobil Karartma Overlay -->
    <div id="mobileSheetOverlay" class="mobile-sheet-overlay" onclick="toggleMobileMenu(false)"></div>

    <!-- Mobil Aşağıdan Açılır Menü Çekmecesi (Bottom Sheet) -->
    <div id="mobileBottomSheet" class="mobile-bottom-sheet" aria-hidden="true">
        <div class="mobile-sheet-handle-wrap" onclick="toggleMobileMenu(false)">
            <div class="mobile-sheet-handle"></div>
        </div>
        <div class="mobile-sheet-header">
            <div>
                <h4 style="font-size: 0.95rem; font-weight: 800; color: #fff; margin:0;">Tüm Yönetim Sayfaları</h4>
                <span style="font-size: 0.72rem; color: #94a3b8; font-weight:600;">Berka Pano</span>
            </div>
            <button type="button" class="mobile-sheet-close-btn" onclick="toggleMobileMenu(false)" aria-label="Menüyü Kapat">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
            </button>
        </div>
        <div class="mobile-sheet-body">
            <nav class="mobile-sheet-nav">
                <a href="index.php" class="mobile-nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span>Başlangıç (Dashboard)</span>
                </a>
                <a href="products.php" class="mobile-nav-link <?= $activePage === 'products' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
                    <span>Ürünler Yönetimi</span>
                </a>
                <a href="messages.php" class="mobile-nav-link <?= $activePage === 'messages' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <span>Gelen Mesajlar</span>
                    <?php if ($unreadCount > 0): ?>
                        <span class="badge-tag badge-danger" style="margin-left: auto;"><?= $unreadCount ?></span>
                    <?php endif; ?>
                </a>
                <a href="features.php" class="mobile-nav-link <?= $activePage === 'features' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                    <span>01-02-03 Kart Alanları</span>
                </a>
                <a href="media.php" class="mobile-nav-link <?= $activePage === 'media' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                    <span>Medya & Haberler</span>
                </a>
                <a href="pages.php" class="mobile-nav-link <?= $activePage === 'pages' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span>Kurumsal Sayfalar</span>
                </a>
                <a href="settings.php" class="mobile-nav-link <?= $activePage === 'settings' ? 'active' : '' ?>">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
                    <span>Genel Site Ayarları</span>
                </a>
            </nav>

            <div class="mobile-sheet-footer">
                <a href="../index.php" target="_blank" class="mobile-sheet-sub-link">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 01-2 2H5a2 2 0 01-2-2V8a2 2 0 012-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                    <span>Siteyi Görüntüle</span>
                </a>
                <a href="logout.php" class="mobile-sheet-sub-link danger">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    <span>Çıkış Yap</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Mobil Sabit Alt Navigasyon Barı (Bottom Bar) -->
    <nav class="mobile-bottom-bar" aria-label="Mobil Hızlı Menü">
        <a href="index.php" class="mobile-bar-item <?= $activePage === 'dashboard' ? 'active' : '' ?>">
            <div class="mobile-bar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <span>Panel</span>
        </a>

        <a href="products.php" class="mobile-bar-item <?= $activePage === 'products' ? 'active' : '' ?>">
            <div class="mobile-bar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 00-1-1.73l-7-4a2 2 0 00-2 0l-7 4A2 2 0 003 8v8a2 2 0 001 1.73l7 4a2 2 0 002 0l7-4A2 2 0 0021 16z"/></svg>
            </div>
            <span>Ürünler</span>
        </a>

        <button type="button" class="mobile-bar-item mobile-menu-trigger" onclick="toggleMobileMenu()" aria-label="Tüm Sayfaları Aç">
            <div class="mobile-bar-icon trigger-bubble">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
            </div>
            <span>Menü</span>
        </button>

        <a href="messages.php" class="mobile-bar-item <?= $activePage === 'messages' ? 'active' : '' ?>">
            <div class="mobile-bar-icon" style="position: relative;">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                <?php if ($unreadCount > 0): ?>
                    <span class="mobile-badge-dot"><?= $unreadCount ?></span>
                <?php endif; ?>
            </div>
            <span>Mesajlar</span>
        </a>

        <a href="settings.php" class="mobile-bar-item <?= $activePage === 'settings' ? 'active' : '' ?>">
            <div class="mobile-bar-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-2 2 2 2 0 01-2-2v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83 0 2 2 0 010-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 01-2-2 2 2 0 012-2h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 010-2.83 2 2 0 012.83 0l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 012-2 2 2 0 012 2v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 0 2 2 0 010 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 012 2 2 2 0 01-2 2h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            </div>
            <span>Ayarlar</span>
        </a>
    </nav>

    <!-- Ana Çalışma Alanı -->
    <main class="admin-main">
        <header class="admin-header">
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 800; color: var(--admin-primary); margin:0; line-height:1.2;"><?= e($adminTitle ?? 'Yönetim Paneli') ?></h2>
                <span class="mobile-header-subtitle">Berka Pano</span>
            </div>
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="text-align: right;" class="desktop-only-user">
                    <div style="font-size: 0.88rem; font-weight: 700; color: var(--admin-primary);"><?= e($currentUser['name']) ?></div>
                    <div style="font-size: 0.74rem; font-weight: 700; color: var(--admin-accent); text-transform: uppercase;">YÖNETİCİ</div>
                </div>
                <div style="width: 38px; height: 38px; border-radius: 50%; background: #e2e8f0; display:flex; align-items:center; justify-content:center; font-weight:700; color: #1e293b; font-size: 0.85rem;" title="<?= e($currentUser['name']) ?>">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                </div>
            </div>
        </header>

        <div class="admin-content">

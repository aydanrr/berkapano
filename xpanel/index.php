<?php
/**
 * Berka Pano - xpanel Dashboard Başlangıç
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$activePage = 'dashboard';
$adminTitle = 'Genel Bakış & Kontrol Paneli';

$countProd = (int)$db->query("SELECT COUNT(*) FROM products")->fetchColumn();
$countPages = (int)$db->query("SELECT COUNT(*) FROM pages")->fetchColumn();
$countMedia = (int)$db->query("SELECT COUNT(*) FROM media_news")->fetchColumn();
$countMsgs = (int)$db->query("SELECT COUNT(*) FROM contact_messages")->fetchColumn();

// Son gelen 5 mesaj
$recentMsgs = $db->query("SELECT * FROM contact_messages ORDER BY id DESC LIMIT 5")->fetchAll();

require_once __DIR__ . '/inc_header.php';
?>

<!-- Üst İstatistik Kartları -->
<div class="stat-card-grid">
    <div class="stat-box">
        <div class="stat-box-title">Toplam Ürün</div>
        <div class="stat-box-num"><?= $countProd ?></div>
    </div>
    <div class="stat-box">
        <div class="stat-box-title">Kurumsal Sayfalar</div>
        <div class="stat-box-num"><?= $countPages ?></div>
    </div>
    <div class="stat-box">
        <div class="stat-box-title">Medya / Haber İçeriği</div>
        <div class="stat-box-num"><?= $countMedia ?></div>
    </div>
    <div class="stat-box">
        <div class="stat-box-title">Gelen Teklif & Mesaj</div>
        <div class="stat-box-num"><?= $countMsgs ?></div>
    </div>
</div>

<!-- Hızlı Yönetim Alanı -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Hızlı Eylemler & Modüller</h3>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px;">
        <a href="products.php?action=add" class="btn-admin btn-admin-primary" style="justify-content: center; padding: 16px;">
            + Yeni Ürün Ekle
        </a>
        <a href="media.php?action=add" class="btn-admin btn-admin-secondary" style="justify-content: center; padding: 16px;">
            + Yeni Medya/Haber Ekle
        </a>
        <a href="pages.php?action=add" class="btn-admin btn-admin-secondary" style="justify-content: center; padding: 16px;">
            + Yeni Kurumsal Sayfa
        </a>
        <a href="settings.php" class="btn-admin btn-admin-secondary" style="justify-content: center; padding: 16px;">
            Site Ayarlarını Düzenle
        </a>
    </div>
</div>

<!-- Son Gelen Mesajlar Tablosu -->
<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Son Gelen Teklif & İletişim Talepleri</h3>
        <a href="messages.php" class="btn-admin btn-admin-secondary">Tümünü Gör</a>
    </div>

    <div class="admin-table-wrapper">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Tarih</th>
                    <th>Gönderen</th>
                    <th>E-posta</th>
                    <th>Telefon</th>
                    <th>Konu</th>
                    <th>Durum</th>
                    <th>İşlem</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($recentMsgs)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--admin-muted); padding: 30px;">Henüz yeni mesaj bulunmamaktadır.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($recentMsgs as $m): ?>
                        <tr>
                            <td><?= date('d.m.Y H:i', strtotime($m['created_at'])) ?></td>
                            <td><strong><?= e($m['fullname']) ?></strong></td>
                            <td><?= e($m['email']) ?></td>
                            <td><?= e($m['phone'] ?: '-') ?></td>
                            <td><?= e($m['subject'] ?: 'Belirtilmedi') ?></td>
                            <td>
                                <span class="badge-tag <?= $m['is_read'] ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $m['is_read'] ? 'Okundu' : 'Yeni' ?>
                                </span>
                            </td>
                            <td>
                                <a href="messages.php?id=<?= $m['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 6px 12px; font-size: 0.8rem;">Detay</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/inc_footer.php'; ?>

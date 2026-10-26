<?php
/**
 * Berka Pano - xpanel Gelen İletişim & Teklif Mesajları
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$activePage = 'messages';
$adminTitle = 'Gelen İletişim Talepleri';

$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$action = $_GET['action'] ?? null;

// Mesajı Silme
if ($action === 'delete' && $id) {
    $del = $db->prepare("DELETE FROM contact_messages WHERE id = ?");
    $del->execute([$id]);
    header("Location: messages.php?msg=deleted");
    exit;
}

// Mesajı Okundu İşaretleme / Detay
$selectedMsg = null;
if ($id) {
    $upd = $db->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
    $upd->execute([$id]);

    $stmt = $db->prepare("SELECT * FROM contact_messages WHERE id = ?");
    $stmt->execute([$id]);
    $selectedMsg = $stmt->fetch();
}

$messages = $db->query("SELECT * FROM contact_messages ORDER BY id DESC")->fetchAll();

require_once __DIR__ . '/inc_header.php';
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div style="background: #fee2e2; color: #991b1b; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        Mesaj silindi.
    </div>
<?php endif; ?>

<?php if ($selectedMsg): ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Mesaj Detayı: <?= e($selectedMsg['subject'] ?: 'Konusuz') ?></h3>
            <a href="messages.php" class="btn-admin btn-admin-secondary">&larr; Mesaj Listesine Dön</a>
        </div>

        <div style="background: #f8fafc; padding: 20px; border-radius: var(--admin-radius); margin-bottom: 20px;">
            <p style="margin-bottom: 8px;"><strong>Gönderen:</strong> <?= e($selectedMsg['fullname']) ?></p>
            <p style="margin-bottom: 8px;"><strong>E-Posta:</strong> <a href="mailto:<?= e($selectedMsg['email']) ?>" style="color: var(--admin-accent); font-weight:700;"><?= e($selectedMsg['email']) ?></a></p>
            <p style="margin-bottom: 8px;"><strong>Telefon:</strong> <a href="tel:<?= e($selectedMsg['phone'] ?? '') ?>"><?= e($selectedMsg['phone'] ?: '-') ?></a></p>
            <p style="margin-bottom: 8px;"><strong>Tarih:</strong> <?= date('d.m.Y H:i:s', strtotime($selectedMsg['created_at'])) ?></p>
        </div>

        <div style="background: #fff; border: 1.5px solid var(--admin-border); padding: 24px; border-radius: var(--admin-radius); line-height: 1.7; font-size: 1rem; margin-bottom: 20px;">
            <?= nl2br(e($selectedMsg['message'])) ?>
        </div>

        <div>
            <a href="mailto:<?= e($selectedMsg['email']) ?>?subject=RE: <?= urlencode($selectedMsg['subject'] ?? '') ?>" class="btn-admin btn-admin-primary">E-Posta İle Yanıtla</a>
            <a href="messages.php?action=delete&id=<?= $selectedMsg['id'] ?>" onclick="return confirm('Bu mesajı silmek istediğinize emin misiniz?');" class="btn-admin btn-admin-danger" style="margin-left: 10px;">Sil</a>
        </div>
    </div>
<?php endif; ?>

<div class="admin-card">
    <div class="admin-card-header">
        <h3 class="admin-card-title">Tüm Gelen Mesajlar (<?= count($messages) ?>)</h3>
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
                    <th style="text-align: right;">İşlemler</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($messages)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--admin-muted); padding: 30px;">Henüz gelen mesaj bulunmuyor.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($messages as $m): ?>
                        <tr style="<?= empty($m['is_read']) ? 'font-weight: 700; background: #f0fdf4;' : '' ?>">
                            <td><?= date('d.m.Y H:i', strtotime($m['created_at'])) ?></td>
                            <td><?= e($m['fullname']) ?></td>
                            <td><?= e($m['email']) ?></td>
                            <td><?= e($m['phone'] ?: '-') ?></td>
                            <td><?= e($m['subject'] ?: 'Teklif/Bilgi') ?></td>
                            <td>
                                <span class="badge-tag <?= $m['is_read'] ? 'badge-success' : 'badge-danger' ?>">
                                    <?= $m['is_read'] ? 'Okundu' : 'Yeni Mesaj' ?>
                                </span>
                            </td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="messages.php?id=<?= $m['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 6px 12px; font-size: 0.8rem;">İncele</a>
                                <a href="messages.php?action=delete&id=<?= $m['id'] ?>" onclick="return confirm('Silmek istediğinize emin misiniz?');" class="btn-admin btn-admin-danger" style="padding: 6px 12px; font-size: 0.8rem;">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php require_once __DIR__ . '/inc_footer.php'; ?>

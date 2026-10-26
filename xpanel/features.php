<?php
/**
 * Berka Pano - xpanel 01-02-03 Özellik Kartları Yönetimi
 * Kullanıcının ilettiği görselin orta bölümündeki dinamik kartlar
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$activePage = 'features';
$adminTitle = '01-02-03 Kart Alanları Yönetimi';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $step_number = trim($_POST['step_number'] ?? '01');
    $title_tr = trim($_POST['title_tr'] ?? '');
    $title_en = trim($_POST['title_en'] ?? '');
    $desc_tr = trim($_POST['desc_tr'] ?? '');
    $desc_en = trim($_POST['desc_en'] ?? '');
    $sort_order = (int)($_POST['sort_order'] ?? 0);
    $is_highlighted = isset($_POST['is_highlighted']) ? 1 : 0;

    if ($id) {
        $stmt = $db->prepare("UPDATE features SET step_number = ?, title_tr = ?, title_en = ?, desc_tr = ?, desc_en = ?, sort_order = ?, is_highlighted = ? WHERE id = ?");
        $stmt->execute([$step_number, $title_tr, $title_en, $desc_tr, $desc_en, $sort_order, $is_highlighted, $id]);
        $message = "Özellik kartı güncellendi!";
    } else {
        $stmt = $db->prepare("INSERT INTO features (step_number, title_tr, title_en, desc_tr, desc_en, sort_order, is_highlighted) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$step_number, $title_tr, $title_en, $desc_tr, $desc_en, $sort_order, $is_highlighted]);
        $message = "Yeni özellik kartı eklendi!";
    }
    $action = 'list';
}

require_once __DIR__ . '/inc_header.php';
?>

<?php if ($message): ?>
    <div style="background: #dcfce7; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        <?= e($message) ?>
    </div>
<?php endif; ?>

<?php if ($action === 'edit' && $id): ?>
    <?php
    $stmt = $db->prepare("SELECT * FROM features WHERE id = ?");
    $stmt->execute([$id]);
    $feat = $stmt->fetch();
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Kartı Düzenle (No: <?= e($feat['step_number']) ?>)</h3>
            <a href="features.php" class="btn-admin btn-admin-secondary">&larr; Geri Dön</a>
        </div>

        <form action="features.php?action=edit&id=<?= $id ?>" method="POST">
            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Adım Numarası (Örn: 01, 02, 03)</label>
                    <input type="text" name="step_number" class="form-control-admin" value="<?= e($feat['step_number']) ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Sıralama</label>
                    <input type="number" name="sort_order" class="form-control-admin" value="<?= $feat['sort_order'] ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Kart Başlığı (Türkçe)</label>
                    <input type="text" name="title_tr" class="form-control-admin" value="<?= e($feat['title_tr']) ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Kart Başlığı (İngilizce)</label>
                    <input type="text" name="title_en" class="form-control-admin" value="<?= e($feat['title_en']) ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Açıklama (Türkçe)</label>
                    <textarea name="desc_tr" class="form-control-admin" rows="3" required><?= e($feat['desc_tr']) ?></textarea>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Açıklama (İngilizce)</label>
                    <textarea name="desc_en" class="form-control-admin" rows="3" required><?= e($feat['desc_en']) ?></textarea>
                </div>
            </div>

            <div class="form-group-admin">
                <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 700;">
                    <input type="checkbox" name="is_highlighted" value="1" <?= $feat['is_highlighted'] ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                    <span>Koyu Mavi Vurgulu Kart Yap (Görseldeki 03 gibi)</span>
                </label>
            </div>

            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 28px;">
                Kaydet
            </button>
        </form>
    </div>
<?php else: ?>
    <?php
    $features = $db->query("SELECT * FROM features ORDER BY sort_order ASC, id ASC")->fetchAll();
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Mevcut 01-02-03 Özellik Kartları</h3>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Başlık (TR)</th>
                        <th>Açıklama (TR)</th>
                        <th>Vurgu</th>
                        <th>Sıra</th>
                        <th style="text-align: right;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($features as $f): ?>
                        <tr>
                            <td><strong style="font-size: 1.2rem; color: var(--admin-accent);"><?= e($f['step_number']) ?></strong></td>
                            <td><strong><?= e($f['title_tr']) ?></strong></td>
                            <td style="color: var(--admin-muted); max-width: 350px;"><?= e($f['desc_tr']) ?></td>
                            <td>
                                <span class="badge-tag <?= $f['is_highlighted'] ? 'badge-primary' : '' ?>" style="<?= $f['is_highlighted'] ? 'background:#1e3a8a; color:#fff;' : '' ?>">
                                    <?= $f['is_highlighted'] ? 'Vurgulu (Koyu)' : 'Açık Kart' ?>
                                </span>
                            </td>
                            <td><?= $f['sort_order'] ?></td>
                            <td style="text-align: right;">
                                <a href="features.php?action=edit&id=<?= $f['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 6px 14px; font-size: 0.82rem;">Düzenle</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/inc_footer.php'; ?>

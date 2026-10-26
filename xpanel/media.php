<?php
/**
 * Berka Pano - xpanel Medya & Haberler Yönetimi
 * Kullanıcının ilettiği görselin altındaki 3 kart alanı
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$activePage = 'media';
$adminTitle = 'Medya, Haber & Basın Yönetimi';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$message = null;

$imageFiles = array_diff(scandir(UPLOADS_PATH) ?: [], ['.', '..']);

if ($action === 'delete' && $id) {
    $del = $db->prepare("DELETE FROM media_news WHERE id = ?");
    $del->execute([$id]);
    header("Location: media.php?msg=deleted");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = trim($_POST['type'] ?? 'photo');
    $badge_tr = trim($_POST['badge_tr'] ?? 'FOTOĞRAF');
    $badge_en = trim($_POST['badge_en'] ?? 'PHOTO');
    $title_tr = trim($_POST['title_tr'] ?? '');
    $title_en = trim($_POST['title_en'] ?? '');
    $date_text_tr = trim($_POST['date_text_tr'] ?? '');
    $date_text_en = trim($_POST['date_text_en'] ?? '');
    $subtext_tr = trim($_POST['subtext_tr'] ?? '');
    $subtext_en = trim($_POST['subtext_en'] ?? '');
    $link = trim($_POST['link'] ?? '#');
    $image = trim($_POST['image'] ?? 'berkapano7.jpg');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    // Yeni dosya yüklendiyse
    if (!empty($_FILES['custom_image']['name']) && $_FILES['custom_image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['custom_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $newName = 'media_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['custom_image']['tmp_name'], UPLOADS_PATH . DIRECTORY_SEPARATOR . $newName)) {
                $image = $newName;
            }
        }
    }

    if ($id) {
        $stmt = $db->prepare("UPDATE media_news SET type = ?, badge_tr = ?, badge_en = ?, title_tr = ?, title_en = ?, date_text_tr = ?, date_text_en = ?, subtext_tr = ?, subtext_en = ?, image = ?, link = ?, sort_order = ? WHERE id = ?");
        $stmt->execute([$type, $badge_tr, $badge_en, $title_tr, $title_en, $date_text_tr, $date_text_en, $subtext_tr, $subtext_en, $image, $link, $sort_order, $id]);
        $message = "Medya içeriği başarıyla güncellendi!";
    } else {
        $stmt = $db->prepare("INSERT INTO media_news (type, badge_tr, badge_en, title_tr, title_en, date_text_tr, date_text_en, subtext_tr, subtext_en, image, link, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$type, $badge_tr, $badge_en, $title_tr, $title_en, $date_text_tr, $date_text_en, $subtext_tr, $subtext_en, $image, $link, $sort_order]);
        $message = "Yeni medya içeriği eklendi!";
    }
    $action = 'list';
}

require_once __DIR__ . '/inc_header.php';
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div style="background: #fee2e2; color: #991b1b; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        Kayıt silindi.
    </div>
<?php endif; ?>

<?php if ($message): ?>
    <div style="background: #dcfce7; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        <?= e($message) ?>
    </div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <?php
    $item = null;
    if ($action === 'edit' && $id) {
        $stmt = $db->prepare("SELECT * FROM media_news WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch();
    }
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title"><?= $action === 'edit' ? 'Medya İçeriğini Düzenle' : 'Yeni Medya/Haber Ekle' ?></h3>
            <a href="media.php" class="btn-admin btn-admin-secondary">&larr; Geri Dön</a>
        </div>

        <form action="media.php<?= $action === 'edit' ? '?action=edit&id=' . $id : '?action=add' ?>" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Rozet / Tip Metni (Türkçe - Örn: VİDEO, FOTOĞRAF)</label>
                    <input type="text" name="badge_tr" class="form-control-admin" value="<?= e($item['badge_tr'] ?? 'FOTOĞRAF') ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Rozet / Tip Metni (İngilizce - Örn: VIDEO, PHOTO)</label>
                    <input type="text" name="badge_en" class="form-control-admin" value="<?= e($item['badge_en'] ?? 'PHOTO') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Tarih Metni (Türkçe - Örn: 28 EKİM 2024)</label>
                    <input type="text" name="date_text_tr" class="form-control-admin" value="<?= e($item['date_text_tr'] ?? '') ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Tarih Metni (İngilizce - Örn: 28 OCT 2024)</label>
                    <input type="text" name="date_text_en" class="form-control-admin" value="<?= e($item['date_text_en'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Başlık (Türkçe)</label>
                    <input type="text" name="title_tr" class="form-control-admin" value="<?= e($item['title_tr'] ?? '') ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Başlık (İngilizce)</label>
                    <input type="text" name="title_en" class="form-control-admin" value="<?= e($item['title_en'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Alt Not / Galeri Sayısı (Türkçe - Örn: 24 FOTOĞRAF)</label>
                    <input type="text" name="subtext_tr" class="form-control-admin" value="<?= e($item['subtext_tr'] ?? '24 FOTOĞRAF') ?>">
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Alt Not / Galeri Sayısı (İngilizce - Örn: 24 PHOTOS)</label>
                    <input type="text" name="subtext_en" class="form-control-admin" value="<?= e($item['subtext_en'] ?? '24 PHOTOS') ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Görsel Seç</label>
                    <select name="image" class="form-control-admin">
                        <?php foreach ($imageFiles as $img): ?>
                            <option value="<?= e($img) ?>" <?= ($item['image'] ?? '') === $img ? 'selected' : '' ?>><?= e($img) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Veya Yeni Görsel Yükle</label>
                    <input type="file" name="custom_image" class="form-control-admin" accept="image/*">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Hedef Link</label>
                    <input type="text" name="link" class="form-control-admin" value="<?= e($item['link'] ?? '#') ?>">
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Sıralama Değeri</label>
                    <input type="number" name="sort_order" class="form-control-admin" value="<?= (int)($item['sort_order'] ?? 0) ?>">
                </div>
            </div>

            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 28px;">
                Kaydet
            </button>
        </form>
    </div>
<?php else: ?>
    <?php
    $media = $db->query("SELECT * FROM media_news ORDER BY sort_order ASC, id ASC")->fetchAll();
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Kayıtlı Medya Kartları</h3>
            <a href="media.php?action=add" class="btn-admin btn-admin-primary">+ Yeni Medya Ekle</a>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Görsel</th>
                        <th>Rozet</th>
                        <th>Tarih</th>
                        <th>Başlık</th>
                        <th>Alt Metin</th>
                        <th style="text-align: right;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($media as $m): ?>
                        <tr>
                            <td style="width: 70px;">
                                <img src="../images/<?= e($m['image']) ?>" alt="" style="width: 60px; height: 45px; object-fit: cover; border-radius: 8px;">
                            </td>
                            <td><span class="badge-tag"><?= e($m['badge_tr']) ?></span></td>
                            <td><?= e($m['date_text_tr']) ?></td>
                            <td><strong><?= e($m['title_tr']) ?></strong></td>
                            <td><?= e($m['subtext_tr']) ?></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="media.php?action=edit&id=<?= $m['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 6px 12px; font-size: 0.82rem;">Düzenle</a>
                                <a href="media.php?action=delete&id=<?= $m['id'] ?>" onclick="return confirm('Silmek istediğinize emin misiniz?');" class="btn-admin btn-admin-danger" style="padding: 6px 12px; font-size: 0.82rem;">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/inc_footer.php'; ?>

<?php
/**
 * Berka Pano - xpanel Kurumsal Sayfa Yönetimi
 * Hakkımızda, Kalite Politikası, Referanslar ve yeni sayfalar ekleme
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$activePage = 'pages';
$adminTitle = 'Kurumsal Sayfa Yönetimi';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$message = null;

$imageFiles = array_diff(scandir(UPLOADS_PATH) ?: [], ['.', '..']);

if ($action === 'delete' && $id) {
    $del = $db->prepare("DELETE FROM pages WHERE id = ?");
    $del->execute([$id]);
    header("Location: pages.php?msg=deleted");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $slug = trim($_POST['slug'] ?? '');
    $title_tr = trim($_POST['title_tr'] ?? '');
    $title_en = trim($_POST['title_en'] ?? '');
    $content_tr = trim($_POST['content_tr'] ?? '');
    $content_en = trim($_POST['content_en'] ?? '');
    $banner_image = trim($_POST['banner_image'] ?? 'berkapano1.jpg');
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    if ($id) {
        $stmt = $db->prepare("UPDATE pages SET slug = ?, title_tr = ?, title_en = ?, content_tr = ?, content_en = ?, banner_image = ?, sort_order = ? WHERE id = ?");
        $stmt->execute([$slug, $title_tr, $title_en, $content_tr, $content_en, $banner_image, $sort_order, $id]);
        $message = "Sayfa güncellendi!";
    } else {
        $stmt = $db->prepare("INSERT INTO pages (slug, title_tr, title_en, content_tr, content_en, banner_image, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$slug, $title_tr, $title_en, $content_tr, $content_en, $banner_image, $sort_order]);
        $message = "Yeni sayfa eklendi!";
    }
    $action = 'list';
}

require_once __DIR__ . '/inc_header.php';
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div style="background: #fee2e2; color: #991b1b; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        Sayfa silindi.
    </div>
<?php endif; ?>

<?php if ($message): ?>
    <div style="background: #dcfce7; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        <?= e($message) ?>
    </div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <?php
    $page = null;
    if ($action === 'edit' && $id) {
        $stmt = $db->prepare("SELECT * FROM pages WHERE id = ?");
        $stmt->execute([$id]);
        $page = $stmt->fetch();
    }
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title"><?= $action === 'edit' ? 'Sayfayı Düzenle' : 'Yeni Kurumsal Sayfa Ekle' ?></h3>
            <a href="pages.php" class="btn-admin btn-admin-secondary">&larr; Geri Dön</a>
        </div>

        <form action="pages.php<?= $action === 'edit' ? '?action=edit&id=' . $id : '?action=add' ?>" method="POST">
            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Sayfa URL Slug (Örn: hakkimizda, vizyonumuz)</label>
                    <input type="text" name="slug" class="form-control-admin" value="<?= e($page['slug'] ?? '') ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Banner Görseli</label>
                    <select name="banner_image" class="form-control-admin">
                        <?php foreach ($imageFiles as $img): ?>
                            <option value="<?= e($img) ?>" <?= ($page['banner_image'] ?? '') === $img ? 'selected' : '' ?>><?= e($img) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Sayfa Başlığı (Türkçe)</label>
                    <input type="text" name="title_tr" class="form-control-admin" value="<?= e($page['title_tr'] ?? '') ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Sayfa Başlığı (İngilizce)</label>
                    <input type="text" name="title_en" class="form-control-admin" value="<?= e($page['title_en'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-group-admin">
                <label class="form-label-admin">Sayfa İçeriği (Türkçe - HTML destekli)</label>
                <textarea name="content_tr" class="form-control-admin" rows="8"><?= e($page['content_tr'] ?? '') ?></textarea>
            </div>

            <div class="form-group-admin">
                <label class="form-label-admin">Sayfa İçeriği (İngilizce - HTML destekli)</label>
                <textarea name="content_en" class="form-control-admin" rows="8"><?= e($page['content_en'] ?? '') ?></textarea>
            </div>

            <div class="form-group-admin" style="max-width: 200px;">
                <label class="form-label-admin">Sıralama</label>
                <input type="number" name="sort_order" class="form-control-admin" value="<?= (int)($page['sort_order'] ?? 0) ?>">
            </div>

            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 28px;">
                Kaydet
            </button>
        </form>
    </div>
<?php else: ?>
    <?php
    $pages = $db->query("SELECT * FROM pages ORDER BY sort_order ASC, id ASC")->fetchAll();
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Kurumsal Sayfalar (<?= count($pages) ?>)</h3>
            <a href="pages.php?action=add" class="btn-admin btn-admin-primary">+ Yeni Sayfa Ekle</a>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Görsel</th>
                        <th>Slug</th>
                        <th>Başlık (TR)</th>
                        <th>Başlık (EN)</th>
                        <th>Sıra</th>
                        <th style="text-align: right;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pages as $pg): ?>
                        <tr>
                            <td style="width: 70px;">
                                <img src="../images/<?= e($pg['banner_image']) ?>" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 6px;">
                            </td>
                            <td><code>/page.php?slug=<?= e($pg['slug']) ?></code></td>
                            <td><strong><?= e($pg['title_tr']) ?></strong></td>
                            <td style="color: var(--admin-muted);"><?= e($pg['title_en']) ?></td>
                            <td><?= $pg['sort_order'] ?></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="../page.php?slug=<?= e($pg['slug']) ?>" target="_blank" class="btn-admin btn-admin-secondary" style="padding: 6px 10px; font-size: 0.8rem;">Görüntüle</a>
                                <a href="pages.php?action=edit&id=<?= $pg['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 6px 12px; font-size: 0.82rem;">Düzenle</a>
                                <a href="pages.php?action=delete&id=<?= $pg['id'] ?>" onclick="return confirm('Bu sayfayı silmek istediğinize emin misiniz?');" class="btn-admin btn-admin-danger" style="padding: 6px 12px; font-size: 0.82rem;">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/inc_footer.php'; ?>

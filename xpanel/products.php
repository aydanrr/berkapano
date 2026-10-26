<?php
/**
 * Berka Pano - xpanel Ürün Yönetimi
 * Ürün Ekleme, Düzenleme, Silme ve Sıralama
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$activePage = 'products';
$adminTitle = 'Ürünler & Çözümler Yönetimi';

$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;
$message = null;

$imageFiles = array_diff(scandir(UPLOADS_PATH) ?: [], ['.', '..']);

// Silme İşlemi
if ($action === 'delete' && $id) {
    $del = $db->prepare("DELETE FROM products WHERE id = ?");
    $del->execute([$id]);
    header("Location: products.php?msg=deleted");
    exit;
}

// Kaydetme / Düzenleme İşlemi
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category = trim($_POST['category'] ?? 'Genel');
    $title_tr = trim($_POST['title_tr'] ?? '');
    $title_en = trim($_POST['title_en'] ?? '');
    $code = trim($_POST['code'] ?? '');
    $short_desc_tr = trim($_POST['short_desc_tr'] ?? '');
    $short_desc_en = trim($_POST['short_desc_en'] ?? '');
    $specs_tr = trim($_POST['specs_tr'] ?? '');
    $specs_en = trim($_POST['specs_en'] ?? '');
    $image = trim($_POST['image'] ?? 'berkapano1.jpg');
    $is_featured = isset($_POST['is_featured']) ? 1 : 0;
    $sort_order = (int)($_POST['sort_order'] ?? 0);

    // Yeni dosya yüklendiyse
    if (!empty($_FILES['custom_image']['name']) && $_FILES['custom_image']['error'] === UPLOAD_ERR_OK) {
        $ext = strtolower(pathinfo($_FILES['custom_image']['name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)) {
            $newName = 'pano_' . time() . '.' . $ext;
            if (move_uploaded_file($_FILES['custom_image']['tmp_name'], UPLOADS_PATH . DIRECTORY_SEPARATOR . $newName)) {
                $image = $newName;
            }
        }
    }

    if ($id) {
        $stmt = $db->prepare("UPDATE products SET category = ?, title_tr = ?, title_en = ?, code = ?, short_desc_tr = ?, short_desc_en = ?, specs_tr = ?, specs_en = ?, image = ?, is_featured = ?, sort_order = ? WHERE id = ?");
        $stmt->execute([$category, $title_tr, $title_en, $code, $short_desc_tr, $short_desc_en, $specs_tr, $specs_en, $image, $is_featured, $sort_order, $id]);
        $message = "Ürün başarıyla güncellendi!";
    } else {
        $stmt = $db->prepare("INSERT INTO products (category, title_tr, title_en, code, short_desc_tr, short_desc_en, specs_tr, specs_en, image, is_featured, sort_order) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$category, $title_tr, $title_en, $code, $short_desc_tr, $short_desc_en, $specs_tr, $specs_en, $image, $is_featured, $sort_order]);
        $message = "Yeni ürün başarıyla eklendi!";
    }
    $action = 'list';
}

require_once __DIR__ . '/inc_header.php';
?>

<?php if (isset($_GET['msg']) && $_GET['msg'] === 'deleted'): ?>
    <div style="background: #fee2e2; color: #991b1b; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        Ürün başarıyla silindi.
    </div>
<?php endif; ?>

<?php if ($message): ?>
    <div style="background: #dcfce7; color: #166534; padding: 12px 18px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
        <?= e($message) ?>
    </div>
<?php endif; ?>

<?php if ($action === 'add' || $action === 'edit'): ?>
    <?php
    $prod = null;
    if ($action === 'edit' && $id) {
        $stmt = $db->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $prod = $stmt->fetch();
    }
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title"><?= $action === 'edit' ? 'Ürünü Düzenle' : 'Yeni Pano / Ürün Ekle' ?></h3>
            <a href="products.php" class="btn-admin btn-admin-secondary">&larr; Listeye Dön</a>
        </div>

        <form action="products.php<?= $action === 'edit' ? '?action=edit&id=' . $id : '?action=add' ?>" method="POST" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Ürün Adı (Türkçe)</label>
                    <input type="text" name="title_tr" class="form-control-admin" value="<?= e($prod['title_tr'] ?? '') ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Ürün Adı (İngilizce)</label>
                    <input type="text" name="title_en" class="form-control-admin" value="<?= e($prod['title_en'] ?? '') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Ürün Kodu (Örn: BP-900, MCC-400)</label>
                    <input type="text" name="code" class="form-control-admin" value="<?= e($prod['code'] ?? '') ?>" required>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Kategori (Örn: Ana Dağıtım, Otomasyon)</label>
                    <input type="text" name="category" class="form-control-admin" value="<?= e($prod['category'] ?? 'Ana Dağıtım') ?>" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Kısa Açıklama (Türkçe)</label>
                    <textarea name="short_desc_tr" class="form-control-admin" rows="3"><?= e($prod['short_desc_tr'] ?? '') ?></textarea>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Kısa Açıklama (İngilizce)</label>
                    <textarea name="short_desc_en" class="form-control-admin" rows="3"><?= e($prod['short_desc_en'] ?? '') ?></textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Teknik Özellikler (Türkçe)</label>
                    <input type="text" name="specs_tr" class="form-control-admin" value="<?= e($prod['specs_tr'] ?? '') ?>" placeholder="Örn: 6300A | IP65 | IEC 61439">
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Teknik Özellikler (İngilizce)</label>
                    <input type="text" name="specs_en" class="form-control-admin" value="<?= e($prod['specs_en'] ?? '') ?>" placeholder="Örn: Rated: 6300A | IP65 | IEC 61439">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group-admin">
                    <label class="form-label-admin">Mevcut Görsellerden Seç</label>
                    <select name="image" class="form-control-admin">
                        <?php foreach ($imageFiles as $img): ?>
                            <option value="<?= e($img) ?>" <?= ($prod['image'] ?? '') === $img ? 'selected' : '' ?>><?= e($img) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group-admin">
                    <label class="form-label-admin">Veya Yeni Görsel Yükle</label>
                    <input type="file" name="custom_image" class="form-control-admin" accept="image/*">
                </div>
            </div>

            <div class="form-row" style="align-items: center; margin-top: 10px;">
                <div class="form-group-admin">
                    <label class="form-label-admin">Sıralama Değeri</label>
                    <input type="number" name="sort_order" class="form-control-admin" value="<?= (int)($prod['sort_order'] ?? 0) ?>">
                </div>
                <div class="form-group-admin" style="padding-top: 24px;">
                    <label style="display: flex; align-items: center; gap: 10px; cursor: pointer; font-weight: 700;">
                        <input type="checkbox" name="is_featured" value="1" <?= (!empty($prod['is_featured'])) ? 'checked' : '' ?> style="width: 18px; height: 18px;">
                        <span>Ana Sayfada Öne Çıkar (Vitrin)</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="btn-admin btn-admin-primary" style="padding: 12px 28px; margin-top: 10px;">
                <?= $action === 'edit' ? 'Değişiklikleri Kaydet' : 'Ürünü Sisteme Ekle' ?>
            </button>
        </form>
    </div>

<?php else: ?>
    <?php
    $products = $db->query("SELECT * FROM products ORDER BY sort_order ASC, id DESC")->fetchAll();
    ?>
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Kayıtlı Ürün Listesi (<?= count($products) ?>)</h3>
            <a href="products.php?action=add" class="btn-admin btn-admin-primary">+ Yeni Ürün Ekle</a>
        </div>

        <div class="admin-table-wrapper">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Görsel</th>
                        <th>Kod</th>
                        <th>Başlık (TR / EN)</th>
                        <th>Kategori</th>
                        <th>Vitrin</th>
                        <th>Sıra</th>
                        <th style="text-align: right;">İşlemler</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $p): ?>
                        <tr>
                            <td style="width: 70px;">
                                <img src="../images/<?= e($p['image']) ?>" alt="" style="width: 50px; height: 50px; object-fit: contain; border-radius: 8px; background: #f1f5f9; padding: 4px;">
                            </td>
                            <td><strong style="color: var(--admin-accent);"><?= e($p['code']) ?></strong></td>
                            <td>
                                <div style="font-weight: 700;"><?= e($p['title_tr']) ?></div>
                                <div style="font-size: 0.8rem; color: var(--admin-muted);"><?= e($p['title_en']) ?></div>
                            </td>
                            <td><span class="badge-tag"><?= e($p['category']) ?></span></td>
                            <td>
                                <span class="badge-tag <?= $p['is_featured'] ? 'badge-success' : '' ?>">
                                    <?= $p['is_featured'] ? 'Evet' : 'Hayır' ?>
                                </span>
                            </td>
                            <td><?= $p['sort_order'] ?></td>
                            <td style="text-align: right; white-space: nowrap;">
                                <a href="products.php?action=edit&id=<?= $p['id'] ?>" class="btn-admin btn-admin-secondary" style="padding: 6px 12px; font-size: 0.82rem;">Düzenle</a>
                                <a href="products.php?action=delete&id=<?= $p['id'] ?>" onclick="return confirm('Bu ürünü silmek istediğinize emin misiniz?');" class="btn-admin btn-admin-danger" style="padding: 6px 12px; font-size: 0.82rem;">Sil</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
<?php endif; ?>

<?php require_once __DIR__ . '/inc_footer.php'; ?>

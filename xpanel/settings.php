<?php
/**
 * Berka Pano - xpanel Genel Ayarlar Yönetimi
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$activePage = 'settings';
$adminTitle = 'Genel Site Ayarları & Hero Alanı';
$message = null;

if (($_SERVER['REQUEST_METHOD'] ?? '') === 'POST') {
    foreach ($_POST as $k => $v) {
        if ($k === 'submit') continue;
        if (($dbType ?? '') === 'mysql') {
            $stmt = $db->prepare("INSERT INTO `settings` (`setting_key`, `setting_value`) VALUES (?, ?) ON DUPLICATE KEY UPDATE `setting_value` = VALUES(`setting_value`)");
        } else {
            $stmt = $db->prepare("INSERT INTO settings (setting_key, setting_value) VALUES (?, ?) ON CONFLICT(setting_key) DO UPDATE SET setting_value = excluded.setting_value");
        }
        $stmt->execute([$k, trim((string)$v)]);
    }
    $message = "Ayarlar başarıyla güncellendi!";
}

$s = getSettings($db);
$imageFiles = array_diff(scandir(UPLOADS_PATH) ?: [], ['.', '..']);

require_once __DIR__ . '/inc_header.php';
?>

<?php if ($message): ?>
    <div style="background: #dcfce7; color: #166534; padding: 14px 20px; border-radius: 12px; margin-bottom: 24px; font-weight: 600;">
        <?= e($message) ?>
    </div>
<?php endif; ?>

<form action="settings.php" method="POST">
    <!-- 1. Hero / Vitrin Alanı Ayarları -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Ana Sayfa Hero / Vitrin Alanı (Tasarım Görseliyle Birebir)</h3>
        </div>

        <div class="form-row">
            <div class="form-group-admin">
                <label class="form-label-admin">Arka Plan Dev Model Kodu / Yazısı (Örn: BP-900)</label>
                <input type="text" name="hero_code" class="form-control-admin" value="<?= e($s['hero_code'] ?? 'BP-900') ?>" required>
            </div>
            <div class="form-group-admin">
                <label class="form-label-admin">Merkez Vitrin Görseli</label>
                <select name="hero_image" class="form-control-admin">
                    <?php foreach ($imageFiles as $img): ?>
                        <option value="<?= e($img) ?>" <?= ($s['hero_image'] ?? '') === $img ? 'selected' : '' ?>><?= e($img) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-admin">
                <label class="form-label-admin">Hero Başlık (Türkçe)</label>
                <input type="text" name="hero_title_tr" class="form-control-admin" value="<?= e($s['hero_title_tr'] ?? '') ?>" required>
            </div>
            <div class="form-group-admin">
                <label class="form-label-admin">Hero Başlık (İngilizce)</label>
                <input type="text" name="hero_title_en" class="form-control-admin" value="<?= e($s['hero_title_en'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-admin">
                <label class="form-label-admin">Hero Açıklama (Türkçe)</label>
                <textarea name="hero_desc_tr" class="form-control-admin" rows="3"><?= e($s['hero_desc_tr'] ?? '') ?></textarea>
            </div>
            <div class="form-group-admin">
                <label class="form-label-admin">Hero Açıklama (İngilizce)</label>
                <textarea name="hero_desc_en" class="form-control-admin" rows="3"><?= e($s['hero_desc_en'] ?? '') ?></textarea>
            </div>
        </div>
    </div>

    <!-- 2. Firma & İletişim Bilgileri -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Kurumsal & İletişim Bilgileri</h3>
        </div>

        <div class="form-row">
            <div class="form-group-admin">
                <label class="form-label-admin">Firma Ünvanı</label>
                <input type="text" name="company_name" class="form-control-admin" value="<?= e($s['company_name'] ?? '') ?>" required>
            </div>
            <div class="form-group-admin">
                <label class="form-label-admin">E-Posta Adresi</label>
                <input type="email" name="email" class="form-control-admin" value="<?= e($s['email'] ?? '') ?>" required>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group-admin">
                <label class="form-label-admin">Telefon Numarası 1</label>
                <input type="text" name="phone" class="form-control-admin" value="<?= e($s['phone'] ?? '') ?>">
            </div>
            <div class="form-group-admin">
                <label class="form-label-admin">Telefon Numarası 2 / GSM</label>
                <input type="text" name="phone2" class="form-control-admin" value="<?= e($s['phone2'] ?? '') ?>">
            </div>
        </div>

        <div class="form-group-admin">
            <label class="form-label-admin">Açık Adres</label>
            <textarea name="address" class="form-control-admin" rows="2"><?= e($s['address'] ?? '') ?></textarea>
        </div>

        <div class="form-group-admin">
            <label class="form-label-admin">Google Harita Embed URL'si</label>
            <input type="text" name="map_embed" class="form-control-admin" value="<?= e($s['map_embed'] ?? '') ?>">
        </div>
    </div>

    <!-- 3. Sosyal Medya Bağlantıları -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h3 class="admin-card-title">Sosyal Medya Hesapları</h3>
        </div>

        <div class="form-row">
            <div class="form-group-admin">
                <label class="form-label-admin">LinkedIn Linki</label>
                <input type="url" name="social_linkedin" class="form-control-admin" value="<?= e($s['social_linkedin'] ?? '') ?>">
            </div>
            <div class="form-group-admin">
                <label class="form-label-admin">Instagram Linki</label>
                <input type="url" name="social_instagram" class="form-control-admin" value="<?= e($s['social_instagram'] ?? '') ?>">
            </div>
        </div>
    </div>

    <button type="submit" name="submit" class="btn-admin btn-admin-primary" style="padding: 14px 32px; font-size: 1rem;">
        Tüm Ayarları Kaydet
    </button>
</form>

<?php require_once __DIR__ . '/inc_footer.php'; ?>

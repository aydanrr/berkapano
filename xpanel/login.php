<?php
/**
 * Berka Pano - xpanel Giriş Sayfası
 * Süperadmin Kullanıcı: suleymannozer0@gmail.com / 7530
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

require_once __DIR__ . '/../inc/config.php';

$error = null;

if (isset($_SESSION['admin_user'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = trim($_POST['password'] ?? '');

    if (!empty($email) && !empty($pass)) {
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Parola doğrulaması (veya ilk seferlik direct eşleşme garantisi)
        if ($user && (password_verify($pass, $user['password']) || ($email === 'suleymannozer0@gmail.com' && $pass === '7530'))) {
            // Şifreyi hash olarak güncelle
            if (!password_verify($pass, $user['password'])) {
                $newHash = password_hash($pass, PASSWORD_DEFAULT);
                $u = $db->prepare("UPDATE users SET password = ? WHERE id = ?");
                $u->execute([$newHash, $user['id']]);
            }

            $_SESSION['admin_user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'is_protected' => (int)$user['is_protected']
            ];
            header("Location: index.php");
            exit;
        } else {
            $error = "Hatalı e-posta adresi veya parola!";
        }
    } else {
        $error = "Lütfen e-posta ve şifrenizi giriniz.";
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli Girişi | Berka Pano</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/png" href="../images/berkapano1.jpg">
</head>
<body class="login-body">
    <div class="login-card">
        <div class="login-logo" style="text-align: center; flex-direction: column; gap: 6px;">
            <h2 style="font-size: 1.5rem; font-weight: 800; color: #0f172a; margin: 0; letter-spacing: 0.5px;">BERKA PANO</h2>
            <span style="font-size: 0.82rem; font-weight: 600; color: #64748b;">Yönetim Paneli Girişi</span>
        </div>

        <?php if ($error): ?>
            <div style="background: #fee2e2; color: #991b1b; padding: 12px 16px; border-radius: 12px; font-size: 0.88rem; font-weight: 600; margin-bottom: 20px;">
                <?= e($error) ?>
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group-admin">
                <label class="form-label-admin">Yönetici E-Posta</label>
                <input type="email" name="email" class="form-control-admin" required value="suleymannozer0@gmail.com" placeholder="suleymannozer0@gmail.com">
            </div>

            <div class="form-group-admin" style="margin-bottom: 24px;">
                <label class="form-label-admin">Parola</label>
                <input type="password" name="password" class="form-control-admin" required placeholder="••••••••">
            </div>

            <button type="submit" class="btn-admin btn-admin-primary" style="width: 100%; padding: 13px; font-size: 0.95rem; justify-content: center;">
                Güvenli Giriş Yap &rarr;
            </button>
        </form>

        <div style="margin-top: 24px; text-align: center;">
            <a href="../index.php" style="font-size: 0.84rem; color: #64748b; text-decoration: none;">&larr; Web Sitesine Geri Dön</a>
        </div>
    </div>
</body>
</html>

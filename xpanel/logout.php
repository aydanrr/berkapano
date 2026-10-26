<?php
/**
 * Berka Pano - xpanel Güvenli Çıkış
 * PHP 8.1 - 8.4+ Uyumlu
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

unset($_SESSION['admin_user']);
session_destroy();

header("Location: login.php");
exit;

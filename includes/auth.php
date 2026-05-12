<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function require_login() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: ' . base_url('login.php'));
        exit;
    }
}
function require_admin() {
    require_login();
    if (($_SESSION['role'] ?? '') !== 'admin') {
        header('Location: ' . base_url('user/dashboard.php'));
        exit;
    }
}
function base_url($path = '') {
    // Menghasilkan URL absolut berdasarkan path folder aplikasi.
    // Contoh: /umkm-php/assets/css/style.css
    $script = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
    $dir = str_replace('index.php', '', $script);
    $dir = preg_replace('#/[^/]*\.php$#', '', $dir); // ambil direktori halaman aktif
    $dir = rtrim($dir, '/');

    // Jika sedang di /admin atau /user, pakai folder induk.
    if (preg_match('#/(admin|user)$#', $dir)) {
        $dir = dirname($dir);
    }

    if ($dir === '' || $dir === '\\') {
        $dir = '/';
    }

    return rtrim($dir, '/') . '/' . ltrim($path, '/');
}
function flash($key, $msg = null) {
    if ($msg === null) {
        $v = $_SESSION['flash'][$key] ?? null;
        unset($_SESSION['flash'][$key]);
        return $v;
    }
    $_SESSION['flash'][$key] = $msg;
}
function e($s){ return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8'); }

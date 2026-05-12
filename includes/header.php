<?php
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/../config/database.php';
$is_logged = isset($_SESSION['user_id']);
$is_admin = ($_SESSION['role'] ?? '') === 'admin';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= isset($page_title) ? e($page_title).' - ' : '' ?>BPS UMKM Gamification</title>
<link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
</head>
<body>
<nav class="navbar">
  <div class="nav-container">
    <a href="<?= base_url('index.php') ?>" class="brand">
      <span class="logo">BPS</span> UMKM Gamification
    </a>
    <div class="nav-menu">
      <?php
        $current = $_SERVER['SCRIPT_NAME'] ?? '';
        $current = str_replace('\\', '/', $current);
        $isCurrent = function(string $target) use ($current){
          $target = str_replace('\\', '/', $target);
          return str_ends_with($current, $target);
        };
      ?>
      <?php if ($is_logged && !$is_admin): ?>
        <a href="<?= base_url('user/dashboard.php') ?>" style="<?= $isCurrent('user/dashboard.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Dashboard</a>
        <a href="<?= base_url('user/tasks.php') ?>" style="<?= $isCurrent('user/tasks.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Tugas</a>
        <a href="<?= base_url('user/rewards.php') ?>" style="<?= $isCurrent('user/rewards.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Reward</a>
        <a href="<?= base_url('user/profile.php') ?>" style="<?= $isCurrent('user/profile.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Profil (<?= e($_SESSION['nama']) ?>)</a>
        <a href="<?= base_url('logout.php') ?>" class="btn-logout">Logout</a>
      <?php elseif ($is_logged && $is_admin): ?>
        <a href="<?= base_url('admin/dashboard.php') ?>" style="<?= $isCurrent('admin/dashboard.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Dashboard</a>
        <a href="<?= base_url('admin/tasks.php') ?>" style="<?= $isCurrent('admin/tasks.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Kelola Tugas</a>
        <a href="<?= base_url('admin/validasi.php') ?>" style="<?= $isCurrent('admin/validasi.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Validasi Survey</a>
        <a href="<?= base_url('admin/rewards.php') ?>" style="<?= $isCurrent('admin/rewards.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Kelola Reward</a>
        <a href="<?= base_url('logout.php') ?>" class="btn-logout">Logout</a>
      <?php else: ?>
        <a href="<?= base_url('login.php') ?>" style="<?= $isCurrent('login.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>">Login</a>
        <a href="<?= base_url('register.php') ?>" style="<?= $isCurrent('register.php') ? 'border-bottom:3px solid var(--primary);color:var(--primary);' : '' ?>" class="btn-primary">Register</a>
      <?php endif; ?>
    </div>
  </div>
</nav>
<main class="container">
<?php if ($f = flash('success')): ?><div class="alert alert-success"><?= e($f) ?></div><?php endif; ?>
<?php if ($f = flash('error')): ?><div class="alert alert-error"><?= e($f) ?></div><?php endif; ?>

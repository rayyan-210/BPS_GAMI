<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/database.php';
$uid = $_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();
$total_survey = $conn->query("SELECT COUNT(*) c FROM surveys WHERE user_id=$uid")->fetch_assoc()['c'];
$approved = $conn->query("SELECT COUNT(*) c FROM surveys WHERE user_id=$uid AND status_validasi='approved'")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) c FROM surveys WHERE user_id=$uid AND status_validasi='pending'")->fetch_assoc()['c'];
$page_title='Dashboard';
include __DIR__ . '/../includes/header.php';
?>
<h1>Halo, <?= e($user['nama']) ?> 👋</h1>
<p class="muted">Selamat datang kembali di sistem gamification UMKM.</p>
<div class="grid grid-3" style="margin-top:18px">
  <div class="card"><h3>Total Poin</h3><div class="point-display"><?= (int)$user['poin'] ?></div></div>
  <div class="card"><h3>Survey Terkirim</h3><div class="point-display"><?= (int)$total_survey ?></div></div>
  <div class="card"><h3>Disetujui</h3><div class="point-display" style="color:var(--success)"><?= (int)$approved ?></div><p class="muted">Pending: <?= (int)$pending ?></p></div>
</div>
<div class="card" style="margin-top:18px">
  <h2>Mulai Berkontribusi</h2>
  <p class="muted">Pilih tugas pendataan UMKM yang tersedia, isi data dengan akurat, dan dapatkan poin.</p>
  <div style="margin-top:14px">
    <a href="tasks.php" class="btn-primary">Lihat Tugas</a>
    <a href="rewards.php" class="btn-primary" style="background:var(--success)">Tukar Reward</a>
  </div>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

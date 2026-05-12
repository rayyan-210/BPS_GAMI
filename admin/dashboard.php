<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../config/database.php';
$total_user = $conn->query("SELECT COUNT(*) c FROM users WHERE role='user'")->fetch_assoc()['c'];
$total_task = $conn->query("SELECT COUNT(*) c FROM tasks")->fetch_assoc()['c'];
$pending = $conn->query("SELECT COUNT(*) c FROM surveys WHERE status_validasi='pending'")->fetch_assoc()['c'];
$total_survey = $conn->query("SELECT COUNT(*) c FROM surveys")->fetch_assoc()['c'];
$page_title='Admin Dashboard';
include __DIR__ . '/../includes/header.php';
?>
<h1>Admin Dashboard</h1>
<p class="muted">Ringkasan sistem.</p>
<div class="grid grid-3" style="margin-top:18px">
  <div class="card"><h3>Total User</h3><div class="point-display"><?= (int)$total_user ?></div></div>
  <div class="card"><h3>Total Tugas</h3><div class="point-display"><?= (int)$total_task ?></div></div>
  <div class="card"><h3>Total Survey</h3><div class="point-display"><?= (int)$total_survey ?></div><p class="muted">Pending: <?= (int)$pending ?></p></div>
</div>
<div class="card" style="margin-top:18px">
  <h2>Aksi Cepat</h2>
  <a href="tasks.php" class="btn-primary">Kelola Tugas</a>
  <a href="validasi.php" class="btn-primary">Validasi Survey (<?= (int)$pending ?>)</a>
  <a href="rewards.php" class="btn-primary">Kelola Reward</a>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

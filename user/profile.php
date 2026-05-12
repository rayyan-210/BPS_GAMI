<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/database.php';

$uid = (int)$_SESSION['user_id'];
$user = $conn->query("SELECT * FROM users WHERE id=$uid")->fetch_assoc();

// Hitung Total Survey Selesai (approved) & tentukan status
$selesai = (int)$conn->query("SELECT COUNT(*) AS cnt FROM surveys WHERE user_id=$uid AND status_validasi='approved'")->fetch_assoc()['cnt'];

$status_label = 'Mulai berpartisipasi';
if ($selesai >= 20) {
    $status_label = 'Pahlawan Statistik';
} elseif ($selesai >= 10) {
    $status_label = 'Penggerak Data';
} elseif ($selesai >= 5) {
    $status_label = 'Mitra Statistik';
} elseif ($selesai >= 3) {
    $status_label = 'Enumerator Pemula';
} elseif ($selesai >= 1) {
    $status_label = 'Kontributor Data';
}

$page_title='Profil';
include __DIR__ . '/../includes/header.php';
?>
<div class="card">
  <h1>Profil Saya</h1>
  <table style="margin-top:14px">
    <tr><th style="width:30%">Nama</th><td><?= e($user['nama']) ?></td></tr>
    <tr><th>Email</th><td><?= e($user['email']) ?></td></tr>
    <tr><th>Role</th><td><?= e($user['role']) ?></td></tr>
    <tr><th>Total Poin</th><td><strong><?= (int)$user['poin'] ?></strong></td></tr>
    <tr><th>Total Survey Selesai</th><td><strong><?= $selesai ?></strong></td></tr>
    <tr><th>Status</th><td><strong><?= e($status_label) ?></strong></td></tr>
    <tr><th>Bergabung</th><td><?= date('d M Y',strtotime($user['created_at'])) ?></td></tr>
  </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>


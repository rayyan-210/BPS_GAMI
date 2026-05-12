<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/database.php';
$tasks = $conn->query("SELECT * FROM tasks WHERE is_completed=0 ORDER BY created_at DESC");
$page_title='Daftar Tugas';
include __DIR__ . '/../includes/header.php';
?>
<h1>Daftar Tugas Pendataan UMKM</h1>
<p class="muted">Pilih tugas dan isi survey untuk mendapatkan poin.</p>
<div class="grid grid-2" style="margin-top:18px">
<?php while($t = $tasks->fetch_assoc()): ?>
  <div class="card task-card">
    <h3><?= e($t['judul']) ?></h3>
    <p class="muted">📍 <?= e($t['lokasi']) ?></p>
    <p style="margin:10px 0"><?= e($t['deskripsi']) ?></p>
    <div class="flex-between">
      <span class="badge badge-approved">+<?= (int)$t['poin_reward'] ?> Poin</span>
      <a href="survey.php?task_id=<?= (int)$t['id'] ?>" class="btn-primary btn-sm">Isi Survey</a>
    </div>
  </div>
<?php endwhile; ?>
</div>
<h2 style="margin-top:30px">Survey Anda</h2>
<?php
$uid = $_SESSION['user_id'];
// Tampilkan hanya task yang belum divalidasi (pending/rejected) untuk user.
$mine = $conn->query("SELECT s.*, t.judul FROM surveys s JOIN tasks t ON s.task_id=t.id WHERE s.user_id=$uid AND s.status_validasi<>'approved' ORDER BY s.created_at DESC");
?>
<table>
<tr><th>Tanggal</th><th>Tugas</th><th>Nama UMKM</th><th>Status</th><th>Poin</th></tr>
<?php while($r = $mine->fetch_assoc()): ?>
<tr>
  <td><?= date('d M Y', strtotime($r['created_at'])) ?></td>
  <td><?= e($r['judul']) ?></td>
  <td><?= e($r['nama_umkm']) ?></td>
  <td><span class="badge badge-<?= e($r['status_validasi']) ?>"><?= e($r['status_validasi']) ?></span></td>
  <td><?= (int)$r['poin'] ?></td>
</tr>
<?php endwhile; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>

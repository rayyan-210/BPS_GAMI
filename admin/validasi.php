<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $id = (int)$_POST['id'];
    $aksi = $_POST['aksi'] ?? '';
    $survey = $conn->query("SELECT s.*, t.poin_reward FROM surveys s JOIN tasks t ON s.task_id=t.id WHERE s.id=$id")->fetch_assoc();
    if ($survey && $survey['status_validasi']==='pending') {
        if ($aksi==='approve') {
            $poin = (int)$survey['poin_reward'];
            $uid = (int)$survey['user_id'];
            $task_id = (int)$survey['task_id'];

            // Setujui survey
            $conn->query("UPDATE surveys SET status_validasi='approved' WHERE id=$id");
            $conn->query("UPDATE users SET poin = poin + $poin WHERE id=$uid");
            
            // Tandai task sebagai selesai (completed) sehingga tidak muncul lagi untuk user
            $conn->query("UPDATE tasks SET is_completed=1 WHERE id=$task_id");

            flash('success','Survey disetujui, poin ditambahkan. Task ditandai selesai.');
        } elseif ($aksi==='reject') {
            $conn->query("UPDATE surveys SET status_validasi='rejected' WHERE id=$id");
            flash('success','Survey ditolak.');
        }
    }
    header('Location: validasi.php'); exit;
}
$filter = $_GET['status'] ?? 'pending';
$where = in_array($filter,['pending','approved','rejected']) ? "WHERE s.status_validasi='$filter'" : '';
$rows = $conn->query("SELECT s.*, u.nama as user_nama, t.judul as task_judul FROM surveys s JOIN users u ON s.user_id=u.id JOIN tasks t ON s.task_id=t.id $where ORDER BY s.created_at DESC");
$page_title='Validasi Survey';
include __DIR__ . '/../includes/header.php';
?>
<h1>Validasi Survey</h1>
<div style="margin:14px 0">
  <a href="?status=pending" class="btn-sm btn-primary" style="<?= $filter==='pending'?'':'opacity:.6' ?>">Pending</a>
  <a href="?status=approved" class="btn-sm btn-primary" style="<?= $filter==='approved'?'':'opacity:.6' ?>">Approved</a>
  <a href="?status=rejected" class="btn-sm btn-primary" style="<?= $filter==='rejected'?'':'opacity:.6' ?>">Rejected</a>
  <a href="?status=all" class="btn-sm btn-primary" style="<?= $filter==='all'?'':'opacity:.6' ?>">Semua</a>
</div>
<div class="grid grid-2">
<?php while($s = $rows->fetch_assoc()): ?>
  <div class="card">
    <div class="flex-between"><h3><?= e($s['nama_umkm']) ?></h3><span class="badge badge-<?= e($s['status_validasi']) ?>"><?= e($s['status_validasi']) ?></span></div>
    <p class="muted">Tugas: <?= e($s['task_judul']) ?> · Oleh: <?= e($s['user_nama']) ?></p>
    <p style="margin-top:8px"><strong>Alamat:</strong> <?= e($s['alamat']) ?></p>
    <p><strong>Jenis:</strong> <?= e($s['jenis_usaha']) ?> · <strong>Tlp:</strong> <?= e($s['no_telepon']) ?></p>
    <?php if($s['deskripsi']): ?><p><?= e($s['deskripsi']) ?></p><?php endif; ?>
    <div style="display:flex;gap:8px;margin-top:10px">
      <?php if($s['foto_umkm']): ?><a href="<?= base_url('assets/uploads/'.e($s['foto_umkm'])) ?>" target="_blank"><img src="<?= base_url('assets/uploads/'.e($s['foto_umkm'])) ?>" class="umkm-img" style="height:90px;width:auto"></a><?php endif; ?>
      <?php if($s['bukti_lokasi']): ?><a href="<?= base_url('assets/uploads/'.e($s['bukti_lokasi'])) ?>" target="_blank"><img src="<?= base_url('assets/uploads/'.e($s['bukti_lokasi'])) ?>" class="umkm-img" style="height:90px;width:auto"></a><?php endif; ?>
    </div>
    <?php if($s['status_validasi']==='pending'): ?>
    <form method="post" style="margin-top:12px;display:flex;gap:8px">
      <input type="hidden" name="id" value="<?= (int)$s['id'] ?>">
      <button name="aksi" value="approve" class="btn-success">✓ Setujui</button>
      <button name="aksi" value="reject" class="btn-danger" onclick="return confirm('Tolak survey ini?')">✗ Tolak</button>
    </form>
    <?php endif; ?>
  </div>
<?php endwhile; ?>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
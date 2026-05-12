<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/database.php';

$task_id = (int)($_GET['task_id'] ?? 0);
$task = $conn->query("SELECT * FROM tasks WHERE id=$task_id")->fetch_assoc();
if (!$task) { flash('error','Tugas tidak ditemukan'); header('Location: tasks.php'); exit; }

function upload_file($field) {
    if (!isset($_FILES[$field]) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) return null;
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowed)) return null;
    if ($_FILES[$field]['size'] > 5*1024*1024) return null;
    $dir = __DIR__ . '/../assets/uploads/';
    if (!is_dir($dir)) mkdir($dir, 0777, true);
    $fname = uniqid('umkm_').'.'.$ext;
    if (move_uploaded_file($_FILES[$field]['tmp_name'], $dir.$fname)) return $fname;
    return null;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $nama_umkm = trim($_POST['nama_umkm'] ?? '');
    $alamat = trim($_POST['alamat'] ?? '');
    $jenis = trim($_POST['jenis_usaha'] ?? '');
    $tlp = trim($_POST['no_telepon'] ?? '');
    $desk = trim($_POST['deskripsi'] ?? '');
    if (!$nama_umkm || !$alamat || !$jenis) {
        flash('error','Nama UMKM, alamat, jenis usaha wajib diisi.');
    } else {
        $foto = upload_file('foto_umkm');
        $bukti = upload_file('bukti_lokasi');
        $uid = $_SESSION['user_id'];
        $stmt = $conn->prepare("INSERT INTO surveys(user_id,task_id,nama_umkm,alamat,jenis_usaha,no_telepon,deskripsi,foto_umkm,bukti_lokasi) VALUES(?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('iisssssss',$uid,$task_id,$nama_umkm,$alamat,$jenis,$tlp,$desk,$foto,$bukti);
        $stmt->execute();
        flash('success','Survey terkirim! Menunggu validasi admin.');
        header('Location: tasks.php'); exit;
    }
}
$page_title='Isi Survey';
include __DIR__ . '/../includes/header.php';
?>
<div class="card">
  <h1>Survey: <?= e($task['judul']) ?></h1>
  <p class="muted"><?= e($task['deskripsi']) ?> · Reward: <?= (int)$task['poin_reward'] ?> poin</p>
  <form method="post" enctype="multipart/form-data" style="margin-top:18px">
    <div class="form-group"><label>Nama UMKM *</label><input type="text" name="nama_umkm" required></div>
    <div class="form-group"><label>Alamat *</label><textarea name="alamat" required></textarea></div>
    <div class="form-group"><label>Jenis Usaha *</label>
      <select name="jenis_usaha" required>
        <option value="">-- Pilih --</option>
        <option>Kuliner</option><option>Fashion</option><option>Kerajinan</option>
        <option>Jasa</option><option>Pertanian</option><option>Lainnya</option>
      </select>
    </div>
    <div class="form-group"><label>No. Telepon</label><input type="text" name="no_telepon"></div>
    <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi"></textarea></div>
    <div class="form-group"><label>Foto UMKM (jpg/png, max 5MB)</label><input type="file" name="foto_umkm" accept="image/*"></div>
    <div class="form-group"><label>Bukti Lokasi (jpg/png, max 5MB)</label><input type="file" name="bukti_lokasi" accept="image/*"></div>
    <button type="submit" class="btn-primary">Kirim Survey</button>
    <a href="tasks.php" class="btn-primary" style="background:var(--muted)">Batal</a>
  </form>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

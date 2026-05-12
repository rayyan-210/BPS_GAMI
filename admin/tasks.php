<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../config/database.php';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['delete'])) {
        $id = (int)$_POST['id'];
        $conn->query("DELETE FROM tasks WHERE id=$id");
        flash('success','Tugas dihapus.');
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $judul = trim($_POST['judul']);
        $desk = trim($_POST['deskripsi']);
        $lok = trim($_POST['lokasi']);
        $poin = (int)$_POST['poin_reward'];
        if (!$judul) flash('error','Judul wajib');
        elseif ($id) {
            $stmt=$conn->prepare("UPDATE tasks SET judul=?,deskripsi=?,lokasi=?,poin_reward=? WHERE id=?");
            $stmt->bind_param('sssii',$judul,$desk,$lok,$poin,$id);
            $stmt->execute();
            flash('success','Tugas diupdate.');
        } else {
            $stmt=$conn->prepare("INSERT INTO tasks(judul,deskripsi,lokasi,poin_reward,is_completed) VALUES(?,?,?,?,0)");
            $stmt->bind_param('sssi',$judul,$desk,$lok,$poin);
            $stmt->execute();
            flash('success','Tugas ditambahkan.');
        }
    }
    header('Location: tasks.php'); exit;
}
$edit = null;
if (isset($_GET['edit'])) {
    $id=(int)$_GET['edit'];
    $edit = $conn->query("SELECT * FROM tasks WHERE id=$id")->fetch_assoc();
}
$tasks = $conn->query("SELECT * FROM tasks WHERE is_completed=0 ORDER BY created_at DESC");
$page_title='Kelola Tugas';
include __DIR__ . '/../includes/header.php';
?>
<h1>Kelola Tugas</h1>
<div class="card">
  <h2><?= $edit?'Edit':'Tambah' ?> Tugas</h2>
  <form method="post" style="margin-top:14px">
    <?php if($edit): ?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif; ?>
    <div class="form-group"><label>Judul *</label><input type="text" name="judul" required value="<?= e($edit['judul']??'') ?>"></div>
    <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi"><?= e($edit['deskripsi']??'') ?></textarea></div>
    <div class="form-group"><label>Lokasi</label><input type="text" name="lokasi" value="<?= e($edit['lokasi']??'') ?>"></div>
    <div class="form-group"><label>Poin Reward</label><input type="number" name="poin_reward" value="<?= (int)($edit['poin_reward']??10) ?>" min="1"></div>
    <button class="btn-primary"><?= $edit?'Update':'Tambah' ?></button>
    <?php if($edit): ?><a href="tasks.php" class="btn-primary" style="background:var(--muted)">Batal</a><?php endif; ?>
  </form>
</div>
<div class="card">
  <h2>Daftar Tugas Aktif</h2>
  <table>
    <tr><th>Judul</th><th>Lokasi</th><th>Poin</th><th>Aksi</th></tr>
    <?php while($t=$tasks->fetch_assoc()): ?>
    <tr>
      <td><?= e($t['judul']) ?></td><td><?= e($t['lokasi']) ?></td><td><?= (int)$t['poin_reward'] ?></td>
      <td>
        <a href="?edit=<?= (int)$t['id'] ?>" class="btn-sm btn-primary">Edit</a>
        <form method="post" style="display:inline" onsubmit="return confirm('Hapus tugas ini?')">
          <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
          <button name="delete" class="btn-danger btn-sm">Hapus</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>
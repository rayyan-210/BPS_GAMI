<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
require_once __DIR__ . '/../config/database.php';

function up_img($field){
    if(!isset($_FILES[$field])||$_FILES[$field]['error']!==UPLOAD_ERR_OK)return null;
    $ext=strtolower(pathinfo($_FILES[$field]['name'],PATHINFO_EXTENSION));
    if(!in_array($ext,['jpg','jpeg','png','webp']))return null;
    $dir=__DIR__.'/../assets/uploads/';
    if(!is_dir($dir))mkdir($dir,0777,true);
    $f='reward_'.uniqid().'.'.$ext;
    return move_uploaded_file($_FILES[$field]['tmp_name'],$dir.$f)?$f:null;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    if (isset($_POST['delete'])) {
        $id=(int)$_POST['id'];
        $conn->query("DELETE FROM rewards WHERE id=$id");
        flash('success','Reward dihapus.');
    } else {
        $id = (int)($_POST['id'] ?? 0);
        $nama = trim($_POST['nama_reward']);
        $poin = (int)$_POST['poin_required'];
        $gambar = up_img('gambar');
        if (!$nama || $poin<1) flash('error','Nama & poin wajib');
        elseif ($id) {
            if ($gambar) {
                $stmt=$conn->prepare("UPDATE rewards SET nama_reward=?,poin_required=?,gambar=? WHERE id=?");
                $stmt->bind_param('sisi',$nama,$poin,$gambar,$id);
            } else {
                $stmt=$conn->prepare("UPDATE rewards SET nama_reward=?,poin_required=? WHERE id=?");
                $stmt->bind_param('sii',$nama,$poin,$id);
            }
            $stmt->execute();
            flash('success','Reward diupdate.');
        } else {
            $stmt=$conn->prepare("INSERT INTO rewards(nama_reward,poin_required,gambar) VALUES(?,?,?)");
            $stmt->bind_param('sis',$nama,$poin,$gambar);
            $stmt->execute();
            flash('success','Reward ditambahkan.');
        }
    }
    header('Location: rewards.php'); exit;
}
$edit=null;
if(isset($_GET['edit'])){$id=(int)$_GET['edit'];$edit=$conn->query("SELECT * FROM rewards WHERE id=$id")->fetch_assoc();}
$rewards = $conn->query("SELECT * FROM rewards ORDER BY poin_required ASC");
$page_title='Kelola Reward';
include __DIR__ . '/../includes/header.php';
?>
<h1>Kelola Reward</h1>
<div class="card">
  <h2><?= $edit?'Edit':'Tambah' ?> Reward</h2>
  <form method="post" enctype="multipart/form-data" style="margin-top:14px">
    <?php if($edit): ?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif; ?>
    <div class="form-group"><label>Nama Reward *</label><input type="text" name="nama_reward" required value="<?= e($edit['nama_reward']??'') ?>"></div>
    <div class="form-group"><label>Poin Required *</label><input type="number" name="poin_required" required min="1" value="<?= (int)($edit['poin_required']??50) ?>"></div>
    <div class="form-group"><label>Gambar</label><input type="file" name="gambar" accept="image/*"></div>
    <button class="btn-primary"><?= $edit?'Update':'Tambah' ?></button>
    <?php if($edit): ?><a href="rewards.php" class="btn-primary" style="background:var(--muted)">Batal</a><?php endif; ?>
  </form>
</div>
<div class="card">
  <h2>Daftar Reward</h2>
  <table>
    <tr><th>Gambar</th><th>Nama</th><th>Poin</th><th>Aksi</th></tr>
    <?php while($r=$rewards->fetch_assoc()): ?>
    <tr>
      <td><?php if($r['gambar']): ?><img src="<?= base_url('assets/uploads/'.e($r['gambar'])) ?>" style="width:60px;height:60px;object-fit:cover;border-radius:6px"><?php else: ?>-<?php endif; ?></td>
      <td><?= e($r['nama_reward']) ?></td><td><?= (int)$r['poin_required'] ?></td>
      <td>
        <a href="?edit=<?= (int)$r['id'] ?>" class="btn-sm btn-primary">Edit</a>
        <form method="post" style="display:inline" onsubmit="return confirm('Hapus?')">
          <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
          <button name="delete" class="btn-danger btn-sm">Hapus</button>
        </form>
      </td>
    </tr>
    <?php endwhile; ?>
  </table>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

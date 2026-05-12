<?php
require_once __DIR__ . '/../includes/auth.php';
require_login();
require_once __DIR__ . '/../config/database.php';
$uid = $_SESSION['user_id'];

if (isset($_POST['redeem'])) {
    $rid = (int)$_POST['reward_id'];
    $r = $conn->query("SELECT * FROM rewards WHERE id=$rid")->fetch_assoc();
    $u = $conn->query("SELECT poin FROM users WHERE id=$uid")->fetch_assoc();
    if (!$r) flash('error','Reward tidak ditemukan');
    elseif ($u['poin'] < $r['poin_required']) flash('error','Poin Anda tidak cukup.');
    else {
        $conn->query("INSERT INTO redeem_rewards(user_id,reward_id) VALUES($uid,$rid)");
        $conn->query("UPDATE users SET poin = poin - {$r['poin_required']} WHERE id=$uid");
        flash('success','Reward berhasil ditukar! Hubungi admin untuk klaim.');
    }
    header('Location: rewards.php'); exit;
}

$user = $conn->query("SELECT poin FROM users WHERE id=$uid")->fetch_assoc();
$rewards = $conn->query("SELECT * FROM rewards ORDER BY poin_required ASC");
$page_title='Reward';
include __DIR__ . '/../includes/header.php';
?>
<div class="flex-between">
  <div><h1>Tukar Reward</h1><p class="muted">Tukarkan poin Anda dengan reward menarik.</p></div>
  <div class="card" style="margin:0;padding:14px 22px"><span class="muted">Poin Anda</span><div class="point-display"><?= (int)$user['poin'] ?></div></div>
</div>
<div class="grid grid-3" style="margin-top:18px">
<?php while($r = $rewards->fetch_assoc()):
  $bisa = $user['poin'] >= $r['poin_required']; ?>
  <div class="card">
    <?php if ($r['gambar']): ?><img src="<?= base_url('assets/uploads/'.e($r['gambar'])) ?>" class="reward-img" alt=""><?php endif; ?>
    <h3><?= e($r['nama_reward']) ?></h3>
    <p class="muted">Butuh <strong><?= (int)$r['poin_required'] ?></strong> poin</p>
    <form method="post" style="margin-top:10px">
      <input type="hidden" name="reward_id" value="<?= (int)$r['id'] ?>">
      <button type="submit" name="redeem" class="btn-primary" <?= $bisa?'':'disabled style="opacity:.5;cursor:not-allowed"' ?>><?= $bisa?'Tukar':'Poin Kurang' ?></button>
    </form>
  </div>
<?php endwhile; ?>
</div>
<h2 style="margin-top:30px">Riwayat Penukaran</h2>
<table>
<tr><th>Tanggal</th><th>Reward</th></tr>
<?php
$h = $conn->query("SELECT rr.tanggal_redeem, r.nama_reward FROM redeem_rewards rr JOIN rewards r ON rr.reward_id=r.id WHERE rr.user_id=$uid ORDER BY tanggal_redeem DESC");
while($row=$h->fetch_assoc()): ?>
<tr><td><?= date('d M Y H:i',strtotime($row['tanggal_redeem'])) ?></td><td><?= e($row['nama_reward']) ?></td></tr>
<?php endwhile; ?>
</table>
<?php include __DIR__ . '/../includes/footer.php'; ?>

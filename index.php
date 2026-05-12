<?php
require_once __DIR__ . '/includes/auth.php';
if (isset($_SESSION['user_id'])) {
    header('Location: ' . base_url(($_SESSION['role']==='admin'?'admin':'user').'/dashboard.php'));
    exit;
}
$page_title = 'Beranda';
include __DIR__ . '/includes/header.php';
?>
<section class="hero">
  <h1>BPS UMKM Gamification</h1>
  <p>Bantu pendataan UMKM di seluruh Indonesia dan dapatkan poin yang bisa ditukar reward menarik!</p>
  <div class="mt-3">
    <a href="<?= base_url('register.php') ?>" class="btn btn-light">Daftar Sekarang</a>
    <a href="<?= base_url('login.php') ?>" class="btn btn-outline">Login</a>
  </div>
</section>

<section>
  <h2 style="text-align: center; margin-bottom: 32px;">Bagaimana Cara Kerjanya?</h2>
  <div class="grid grid-3">
    <div class="card">
      <h3>1. Daftar & Login</h3>
      <p class="muted">Buat akun gratis sebagai kontributor BPS.</p>
    </div>
    <div class="card">
      <h3>2. Kerjakan Tugas</h3>
      <p class="muted">Pilih lokasi & kumpulkan data UMKM via form survey.</p>
    </div>
    <div class="card">
      <h3>3. Tukar Poin</h3>
      <p class="muted">Survey tervalidasi memberi poin untuk ditukar reward.</p>
    </div>
  </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>

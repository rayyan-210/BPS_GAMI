<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = trim($_POST['nama'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    if (!$nama || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 6) {
        flash('error', 'Nama wajib, email valid, password min 6 karakter.');
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param('s', $email);
        $check->execute();
        if ($check->get_result()->num_rows > 0) {
            flash('error', 'Email sudah terdaftar.');
        } else {
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users(nama,email,password,role) VALUES(?,?,?,'user')");
            $stmt->bind_param('sss', $nama, $email, $hash);
            $stmt->execute();
            flash('success', 'Registrasi berhasil. Silakan login.');
            header('Location: ' . base_url('login.php'));
            exit;
        }
    }
}
$page_title = 'Register';
include __DIR__ . '/includes/header.php';
?>
<div class="auth-box">
  <div class="card">
    <h1>Daftar Akun</h1>
    <p class="muted">Buat akun untuk mulai berkontribusi.</p>
    <form method="post" style="margin-top:18px">
      <div class="form-group"><label>Nama Lengkap</label><input type="text" name="nama" required></div>
      <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
      <div class="form-group"><label>Password (min 6)</label><input type="password" name="password" required minlength="6"></div>
      <button type="submit" class="btn-primary" style="width:100%">Daftar</button>
    </form>
    <p class="muted" style="margin-top:14px;text-align:center">Sudah punya akun? <a href="<?= base_url('login.php') ?>">Login</a></p>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

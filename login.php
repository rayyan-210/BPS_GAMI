<?php
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';
    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
    if ($user && password_verify($pass, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['role'] = $user['role'];
        header('Location: ' . base_url(($user['role']==='admin'?'admin':'user').'/dashboard.php'));
        exit;
    }
    flash('error', 'Email atau password salah.');
}
$page_title = 'Login';
include __DIR__ . '/includes/header.php';
?>
<div class="auth-box">
  <div class="card">
    <h1>Login</h1>
    <form method="post" style="margin-top:18px">
      <div class="form-group"><label>Email</label><input type="email" name="email" required></div>
      <div class="form-group"><label>Password</label><input type="password" name="password" required></div>
      <button type="submit" class="btn-primary" style="width:100%">Masuk</button>
    </form>
    <p class="muted" style="margin-top:14px;text-align:center">Belum punya akun? <a href="<?= base_url('register.php') ?>">Daftar</a></p>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>

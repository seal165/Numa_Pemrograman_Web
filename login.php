<?php
require_once __DIR__ . '/includes/config.php';

// kalau udah login, ngapain ke halaman login lagi? langsung lempar ke dashboard
if (sudahLogin()) {
    redirect(user()['role'] === 'admin' ? 'admin/admin-dashboard.php' : 'user/dashboard.php');
}

$error = '';
// username diisi otomatis dari cookie "ingat saya" kalau ada
$usernameIsi = $_COOKIE['numa_ingat'] ?? '';
$ingatDicentang = isset($_COOKIE['numa_ingat']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kunci = trim($_POST['username'] ?? '');
    $sandi = $_POST['password'] ?? '';
    $ingat = isset($_POST['remember']);
    $usernameIsi = $kunci;
    $ingatDicentang = $ingat;

    if ($kunci === '' || $sandi === '') {
        $error = 'Username dan kata sandi wajib diisi.';
    } else {
        $akun = cariUser($kunci);
        // password_verify ngebandingin sandi yang diketik dengan hash di users.json
        if (!$akun || !password_verify($sandi, $akun['password'])) {
            $error = 'Username/email atau kata sandi salah.';
        } else {
            masukkanKeSession($akun);                  // simpen data ke $_SESSION
            if ($ingat) {
                setCookieIngat($akun['username']);     // cookie 30 hari
            } else {
                hapusCookieIngat();
            }
            setFlash('sukses', 'Selamat datang, ' . namaDepan($akun['nama']) . '!');
            redirect($akun['role'] === 'admin' ? 'admin/admin-dashboard.php' : 'user/dashboard.php');
        }
    }
}
$flash = ambilFlash();      // pesan dari halaman lain (misal "harus login dulu")
if (!$flash && isset($_GET['keluar'])) {
    $flash = ['jenis' => 'sukses', 'pesan' => 'Kamu sudah keluar. Sampai jumpa lagi!'];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa - Halaman Masuk (Login)</title>
  <link rel="stylesheet" href="css/style.css">
  <!-- Font Awesome untuk ikon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>

  <!-- Header Logo -->
  <header class="header">
    <div class="logo">
      <div class="logo-icon">
        <span class="plus">+</span>
        <span class="dot"></span>
      </div>
      <span class="logo-text">numa<span class="dot-purple">•</span></span>
    </div>
  </header>

  <!-- Container Utama -->
  <main class="login-container">
    <div class="card">
      
      <!-- Welcome Badge -->
      <div class="badge">
        <i class="fa-regular fa-hand"></i> Selamat Datang Kembali!
      </div>

      <!-- Title & Subtitle -->
      <h1 class="title">Masuk ke Numa</h1>
      <p class="subtitle">
        Lanjutkan petualangan matematika dan pertahankan posisimu di Liga Pythagoras mingguan!
      </p>

      <!-- Social Login Buttons -->
      <div class="social-login">
        <button type="button" class="btn-social">
          <svg class="google-icon" width="18" height="18" viewBox="0 0 18 18">
            <path fill="#4285F4" d="M17.64 9.2c0-.637-.057-1.251-.164-1.84H9v3.481h4.844a4.14 4.14 0 0 1-1.796 2.716v2.259h2.908c1.702-1.567 2.684-3.875 2.684-6.616z"/>
            <path fill="#34A853" d="M9 18c2.43 0 4.467-.806 5.956-2.18l-2.908-2.259c-.806.54-1.837.86-3.048.86-2.344 0-4.328-1.584-5.036-3.711H.957v2.332A8.997 8.997 0 0 0 9 18z"/>
            <path fill="#FBBC05" d="M3.964 10.71A5.41 5.41 0 0 1 3.682 9c0-.593.102-1.17.282-1.71V4.958H.957A8.996 8.996 0 0 0 0 9c0 1.452.348 2.827.957 4.042l3.007-2.332z"/>
            <path fill="#EA4335" d="M9 3.58c1.321 0 2.508.454 3.44 1.345l2.582-2.58C13.463.891 11.426 0 9 0A8.997 8.997 0 0 0 .957 4.958L3.964 7.29C4.672 5.163 6.656 3.58 9 3.58z"/>
          </svg>
          Google
        </button>
        <button type="button" class="btn-social">
          <i class="fa-solid fa-graduation-cap icon-green"></i>
          Akun Sekolah (SSO)
        </button>
      </div>

      <!-- Divider -->
      <div class="divider">
        <span>ATAU DENGAN AKUN NUMA</span>
      </div>

      <!-- Login Form -->
      <?php if ($error): ?><div class="alert alert-error"><?= e($error) ?></div><?php endif; ?>
      <?php if ($flash): ?><div class="alert alert-<?= e($flash['jenis']) ?>"><?= e($flash['pesan']) ?></div><?php endif; ?>
      <form action="login.php" method="POST" autocomplete="on">
        <!-- Input Email/Username -->
        <div class="form-group">
          <label for="username">Email atau Username Siswa</label>
          <div class="input-wrapper">
            <i class="fa-regular fa-user input-icon"></i>
            <input type="text" id="username" name="username" value="<?= e($usernameIsi) ?>" placeholder="arka_juara atau email@sekolah.id" required>
          </div>
        </div>

        <!-- Input Password -->
        <div class="form-group">
          <div class="label-row">
            <label for="password">Kata Sandi</label>
            <a href="#" class="link-forgot">Lupa Kata Sandi?</a>
          </div>
          <div class="input-wrapper">
            <i class="fa-solid fa-lock input-icon"></i>
            <input type="password" id="password" name="password" placeholder="Masukkan setidaknya 8 karakter" required>
            <i class="fa-regular fa-eye toggle-password"></i>
          </div>
        </div>

        <!-- Checkbox Options -->
        <div class="form-options">
          <label class="checkbox-label">
            <input type="checkbox" name="remember" <?= $ingatDicentang ? 'checked' : '' ?>>
            <span>Ingat saya di perangkat ini</span>
          </label>
          <div class="secure-session">
            <i class="fa-solid fa-shield-halved"></i> Sesi Aman
          </div>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="btn-submit">
          Masuk ke Numa <i class="fa-solid fa-rocket"></i>
        </button>
      </form>

      <!-- Footer Banner Register -->
      <div class="register-banner">
        <div class="banner-text">
          <span class="icon-box"><i class="fa-solid fa-gift"></i></span>
          <span>Belum punya akun Numa?</span>
        </div>
        <a href="register.php" class="btn-register">Daftar Gratis</a>
      </div>

    </div>
  </main>

</body>
</html>
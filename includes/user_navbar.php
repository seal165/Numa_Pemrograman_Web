<?php
/*
 * user_navbar.php - navbar yang sama dipakai semua halaman user.
 * Sebelumnya tiap halaman nulis navbar sendiri-sendiri (isinya beda-beda),
 * sekarang cukup satu file ini aja pake include.
 * Variabel yang dipakai: $aktif (menu yang lagi dibuka) dan $base (prefix path)
 */
$u = user();
$stat = statUser();
$base = $base ?? '../';
$aktif = $aktif ?? '';
?>
<header class="navbar">
    <div class="nav-left">
      <a href="<?= $base ?>user/dashboard.php" class="brand-logo">
        <span class="logo-icon">+</span>
        <span class="logo-text">numa.</span>
      </a>
      <nav class="nav-menu">
        <?php foreach ($MENU_USER as $kode => $m): ?>
          <a href="<?= $base ?>user/<?= $m['file'] ?>" class="nav-item<?= $aktif === $kode ? ' active' : '' ?>"><?= e($m['label']) ?></a>
        <?php endforeach; ?>
      </nav>
    </div>

    <div class="nav-right">
      <div class="badge-item streak-badge" title="Sisa hati">❤️ <?= (int)$stat['hati'] ?></div>
      <div class="badge-item streak-badge-gold" title="Streak harian">🔥 <?= (int)$stat['streak'] ?></div>
      <div class="badge-item xp-badge" title="Total XP">💎 <?= (int)$stat['xp'] ?> XP</div>
      <div class="badge-item coin-badge" title="Koin">🪙 <?= (int)$stat['koin'] ?></div>

      <!-- nama user diambil dari $_SESSION, jadi muncul di semua halaman -->
      <a href="<?= $base ?>user/dashboard.php" class="nav-user" title="Lihat profil">
        <span class="user-avatar-inisial"><?= e(inisial($u['nama'])) ?></span>
        <span class="nav-user-nama"><?= e(namaDepan($u['nama'])) ?></span>
      </a>
      <!-- tombol logout: ngarah ke logout.php yang ngehapus session -->
      <a href="<?= $base ?>logout.php" class="btn-logout" onclick="return confirm('Yakin mau keluar dari akun <?= e($u['username']) ?>?');">Keluar</a>
    </div>
  </header>
  <?php tampilFlash(); ?>

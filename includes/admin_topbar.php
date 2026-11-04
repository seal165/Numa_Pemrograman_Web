<?php
/* admin_topbar.php - bar atas admin. Nama & peran diambil dari session. */
$u = user();
$jumlahNotif = count(array_filter($NOTIFIKASI_ADMIN, fn($n) => $n['baru']));
?>
<header class="topbar">
      <div class="search-box">
        <i class="fa-solid fa-magnifying-glass"></i>
        <input type="text" placeholder="Cari pengguna, kursus, atau laporan...">
      </div>
      <div class="topbar-right">
        <div class="date-badge"><i class="fa-regular fa-calendar"></i> <?= date('j') . ' ' . ['','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][(int)date('n')] . ' ' . date('Y') ?></div>
        <a href="admin-notifikasi.php" class="icon-btn" title="Notifikasi">
          <i class="fa-regular fa-bell"></i>
          <?php if ($jumlahNotif): ?><span class="notification-dot"></span><?php endif; ?>
        </a>
        <div class="profile-menu">
          <div class="avatar-circle"><?= e(inisial($u['nama'])) ?></div>
          <div class="profile-info">
            <span class="profile-name"><?= e($u['nama']) ?></span>
            <span class="profile-role"><?= $u['role'] === 'admin' ? 'Super Admin' : 'Pengguna' ?></span>
          </div>
        </div>
        <a href="../logout.php" class="btn-logout-admin" onclick="return confirm('Keluar dari panel admin?');"><i class="fa-solid fa-right-from-bracket"></i> Keluar</a>
      </div>
    </header>
    <?php tampilFlash(); ?>

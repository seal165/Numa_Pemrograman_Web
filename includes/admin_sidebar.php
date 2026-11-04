<?php
/*
 * admin_sidebar.php - sidebar admin yang dipakai semua halaman admin.
 * $aktif = kode menu yang lagi dibuka (lihat array $MENU_ADMIN di data.php)
 */
$aktif = $aktif ?? '';
$jumlahNotif = count(array_filter($NOTIFIKASI_ADMIN, fn($n) => $n['baru']));
$jumlahUser = count(muatUsers());
?>
<aside class="sidebar">
    <div class="sidebar-brand">
      <div class="logo-icon"><i class="fa-solid fa-plus"></i></div>
      <div class="logo-text-group">
        <span class="logo-text">numa<span class="dot-purple">.</span></span>
        <span class="logo-tag">ADMIN PUSAT</span>
      </div>
    </div>

    <?php foreach ($MENU_ADMIN as $judulBagian => $daftar): ?>
    <div class="nav-section">
      <span class="section-label"><?= e($judulBagian) ?></span>
      <?php foreach ($daftar as $kode => $m): ?>
      <a href="<?= $m['file'] ?>" class="nav-item<?= $aktif === $kode ? ' active' : '' ?>">
        <i class="<?= $m['ikon'] ?>"></i> <?= e($m['label']) ?>
        <?php if ($kode === 'pengguna'): ?><span class="badge-count"><?= $jumlahUser ?></span><?php endif; ?>
        <?php if ($kode === 'notifikasi' && $jumlahNotif): ?><span class="badge-count purple"><?= $jumlahNotif ?></span><?php endif; ?>
      </a>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>

    <div class="system-status-card">
      <div class="status-indicator">
        <span class="dot-status green"></span>
        <span class="status-title">Semua sistem normal</span>
      </div>
      <p>Sesi aktif sejak <?= date('H:i', user()['login_at']) ?> WIB.</p>
    </div>

    <div class="sidebar-footer">
      <a href="../logout.php" class="btn-help" onclick="return confirm('Keluar dari panel admin?');">
        <i class="fa-solid fa-right-from-bracket"></i> Keluar (logout)
      </a>
    </div>
  </aside>

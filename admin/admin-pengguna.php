<?php
require_once __DIR__ . '/../includes/config.php';
wajibAdmin('../');
$aktif = 'pengguna';

// akun yang daftar lewat register.php (disimpan di data/users.json) ditaruh di atas data contoh
$warna = ['purple-bg', 'green-bg', 'orange-bg', 'blue-bg'];
$semuaPengguna = [];
foreach (muatUsers() as $i => $usr) {
    $semuaPengguna[] = [
        'inisial' => inisial($usr['nama']), 'warna' => $warna[$i % 4], 'nama' => $usr['nama'], 'email' => $usr['email'],
        'peran' => ucfirst($usr['role']), 'peran_warna' => $usr['role'] === 'admin' ? 'green' : 'purple',
        'status' => 'Aktif', 'status_warna' => 'green', 'terakhir' => tanggalIndo($usr['dibuat']),
        'metrik' => '@' . $usr['username'], 'metrik_ket' => 'Akun terdaftar',
    ];
}
$semuaPengguna = array_merge($semuaPengguna, $PENGGUNA_DEMO);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa Admin Pusat — Manajemen Pengguna</title>
  <link rel="stylesheet" href="../css/style-admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Sidebar Navigasi Admin -->
  <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

  <!-- Main Content Wrapper -->
  <main class="admin-wrapper">

    <!-- Top Header -->
    <?php include __DIR__ . '/../includes/admin_topbar.php'; ?>

    <!-- Dashboard Body -->
    <div class="dashboard-body">

      <!-- Judul Halaman -->
      <div style="margin-top: 8px; margin-bottom: 8px;">
        <h2 style="font-size: 24px; font-weight: 800; color: var(--text-main);">Manajemen Pengguna</h2>
        <p class="subtitle" style="font-size: 14px;">Kelola data siswa, guru, dan administrator platform Numa.</p>
      </div>

      <!-- Statistik Ringkas Pengguna -->
      <section class="stats-grid" style="grid-template-columns: repeat(3, 1fr);">
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon purple"><i class="fa-solid fa-users"></i></div>
          </div>
          <div class="stat-number">48.275</div>
          <div class="stat-desc"><strong>Total Pengguna</strong></div>
        </div>
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon green"><i class="fa-solid fa-user-check"></i></div>
          </div>
          <div class="stat-number">31.842</div>
          <div class="stat-desc"><strong>Pengguna Aktif</strong></div>
        </div>
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon orange"><i class="fa-solid fa-user-clock"></i></div>
          </div>
          <div class="stat-number">12</div>
          <div class="stat-desc"><strong>Perlu Verifikasi</strong></div>
        </div>
      </section>

      <!-- Tabel Pengguna -->
      <section class="card table-card">
        <div class="card-header">
          <div>
            <h3>Daftar Pengguna</h3>
            <p class="subtitle">Menampilkan seluruh pengguna yang terdaftar di platform.</p>
          </div>
          <div class="header-actions">
            <button class="btn btn-outline"><i class="fa-solid fa-download"></i> Ekspor Data</button>
          </div>
        </div>

        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>PENGGUNA</th>
                <th>PERAN</th>
                <th>STATUS</th>
                <th>TERAKHIR AKTIF</th>
                <th>PROGRES</th>
                <th class="text-right">TINDAKAN</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($semuaPengguna as $p): ?>
              <tr>
                <td>
                  <div class="user-profile-cell">
                    <div class="avatar-circle <?= e($p['warna']) ?>"><?= e($p['inisial']) ?></div>
                    <div>
                      <div class="user-name"><?= e($p['nama']) ?></div>
                      <div class="user-email"><?= e($p['email']) ?></div>
                    </div>
                  </div>
                </td>
                <td><span class="badge-status <?= e($p['peran_warna']) ?>"><?= e($p['peran']) ?></span></td>
                <td><span class="badge-status <?= e($p['status_warna']) ?>"><?= e($p['status']) ?></span></td>
                <td><?= e($p['terakhir']) ?></td>
                <td>
                  <strong><?= e($p['metrik']) ?></strong>
                  <div class="sub-text"><?= e($p['metrik_ket']) ?></div>
                </td>
                <td class="text-right">
                  <a href="#" class="btn-table"><i class="fa-solid fa-pen"></i> Edit</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>

        <div class="table-footer">
          <span class="table-info">Menampilkan 5 dari 48.275 pengguna</span>
          <div class="pagination">
            <button class="btn-page"><i class="fa-solid fa-chevron-left"></i></button>
            <button class="btn-page active">1</button>
            <button class="btn-page">2</button>
            <button class="btn-page">3</button>
            <button class="btn-page">...</button>
            <button class="btn-page"><i class="fa-solid fa-chevron-right"></i></button>
          </div>
        </div>
      </section>

    </div>
  </main>

</body>
</html>
<?php
require_once __DIR__ . '/../includes/config.php';
wajibAdmin('../');
$aktif = 'kursus';

// hapus kursus (dikirim dari form POST di tabel)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['aksi'] ?? '') === 'hapus') {
    $id = $_POST['id'] ?? '';
    $sisa = array_values(array_filter(muatKursus(), fn($k) => $k['id'] !== $id));
    tulisJson('kursus', $sisa);
    setFlash('sukses', 'Kursus berhasil dihapus.');
    redirect('admin-kursus.php');
}
$daftarKursus = muatKursus();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa Admin Pusat — Kursus & Materi</title>
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
        <h2 style="font-size: 24px; font-weight: 800; color: var(--text-main);">Kursus & Materi</h2>
        <p class="subtitle" style="font-size: 14px;">Kelola kurikulum, modul pembelajaran, dan materi pendukung.</p>
      </div>

      <!-- Statistik Ringkas Kursus (Menggunakan 4 kolom bawaan CSS) -->
      <section class="stats-grid">
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon purple"><i class="fa-solid fa-book-open"></i></div>
            <span class="badge-growth purple">+6 bulan ini</span>
          </div>
          <div class="stat-number">128</div>
          <div class="stat-desc"><strong>Total Kursus</strong></div>
          <div class="stat-sub">14 kursus diperbarui</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon blue"><i class="fa-solid fa-file-lines"></i></div>
            <span class="badge-growth blue">+12 bulan ini</span>
          </div>
          <div class="stat-number">1.450</div>
          <div class="stat-desc"><strong>Total Materi</strong></div>
          <div class="stat-sub">Modul & kuis interaktif</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon green"><i class="fa-solid fa-users"></i></div>
            <span class="badge-growth green">+8,4% bulan ini</span>
          </div>
          <div class="stat-number">48.275</div>
          <div class="stat-desc"><strong>Siswa Terdaftar</strong></div>
          <div class="stat-sub">Di seluruh kursus</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon orange"><i class="fa-solid fa-star"></i></div>
            <span class="badge-growth orange">+0,2 poin</span>
          </div>
          <div class="stat-number">4.8<span style="font-size: 16px; color: var(--text-muted);">/5</span></div>
          <div class="stat-desc"><strong>Rating Rata-rata</strong></div>
          <div class="stat-sub">Berdasarkan 12.840 ulasan</div>
        </div>
      </section>

      <!-- Tabel Kursus -->
      <section class="card table-card">
        <div class="card-header">
          <div>
            <h3>Daftar Kursus</h3>
            <p class="subtitle">Menampilkan seluruh kursus yang tersedia di platform.</p>
          </div>
          <div class="header-actions">
            <button class="btn btn-outline"><i class="fa-solid fa-filter"></i> Filter Kategori</button>
            <a href="admin-tambah-kursus.php"><a href="admin-tambah-kursus.php" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Kursus</a></a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="admin-table">
            <thead>
              <tr>
                <th>NAMA KURSUS</th>
                <th>KATEGORI</th>
                <th>MATERI</th>
                <th>SISWA</th>
                <th>STATUS</th>
                <th class="text-right">TINDAKAN</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($daftarKursus as $k): ?>
              <tr>
                <td>
                  <div class="user-profile-cell">
                    <div class="avatar-circle <?= e($k['warna']) ?>"><i class="fa-solid <?= e(str_replace('fa-solid ', '', $k['ikon'])) ?>"></i></div>
                    <div>
                      <div class="user-name"><?= e($k['nama']) ?></div>
                      <div class="user-email"><?= e($k['sub']) ?></div>
                    </div>
                  </div>
                </td>
                <td><span class="badge-status purple"><?= e($k['kategori']) ?></span></td>
                <td><strong><?= e($k['materi']) ?></strong> <span class="sub-text">Materi</span></td>
                <td><strong><?= e($k['siswa']) ?></strong> <span class="sub-text">Siswa</span></td>
                <td><span class="badge-status <?= e($k['status_warna']) ?>"><?= e($k['status']) ?></span></td>
                <td class="text-right">
                  <a href="admin-edit-kursus.php?id=<?= urlencode($k['id']) ?>" class="btn-table"><i class="fa-solid fa-pen"></i> Edit</a>
                  <a href="admin-kelola-soal.php?id=<?= urlencode($k['id']) ?>" class="btn-table"><i class="fa-solid fa-plus"></i> Kelola Soal</a>
                  <form method="POST" action="admin-kursus.php" style="display:inline;" onsubmit="return confirm('Hapus kursus <?= e(addslashes($k['nama'])) ?>?');">
                    <input type="hidden" name="aksi" value="hapus"><input type="hidden" name="id" value="<?= e($k['id']) ?>">
                    <button type="submit" class="btn-table" style="color:#dc2626; border:0; cursor:pointer;"><i class="fa-solid fa-trash"></i> Hapus</button>
                  </form>
                </td>
              </tr>
              <?php endforeach; ?>
              <?php if (!$daftarKursus): ?><tr><td colspan="6" style="text-align:center; padding:24px;">Belum ada kursus.</td></tr><?php endif; ?>
            </tbody>
          </table>
        </div>

        <div class="table-footer">
          <span class="table-info">Menampilkan 5 dari 128 kursus</span>
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
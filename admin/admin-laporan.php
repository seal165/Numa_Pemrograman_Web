<?php
require_once __DIR__ . '/../includes/config.php';
wajibAdmin('../');
$aktif = 'laporan';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa Admin Pusat — Laporan</title>
  <link rel="stylesheet" href="../css/style-admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Sidebar Navigasi Admin -->
  <?php include __DIR__ . '/../includes/admin_sidebar.php'; ?>

  <!-- Main Content Wrapper -->
  <main class="admin-wrapper">
    <?php include __DIR__ . '/../includes/admin_topbar.php'; ?>

    <div class="dashboard-body">

      <!-- Judul Halaman -->
      <div class="page-header">
        <div>
          <h2 class="page-title">Laporan</h2>
          <p class="subtitle">Kelola, unduh, dan jadwalkan laporan platform Numa.</p>
        </div>
        <div class="header-actions">
          <button class="btn btn-outline"><i class="fa-solid fa-calendar-plus"></i> Jadwalkan Laporan</button>
          <button class="btn btn-primary"><i class="fa-solid fa-plus"></i> Buat Laporan Baru</button>
        </div>
      </div>

      <!-- Statistik Laporan -->
      <section class="stats-grid">
        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon purple"><i class="fa-solid fa-file-lines"></i></div>
            <span class="badge-growth purple">+6 bulan ini</span>
          </div>
          <div class="stat-number">24</div>
          <div class="stat-desc"><strong>Total Laporan</strong></div>
          <div class="stat-sub">Tersedia untuk diunduh</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon green"><i class="fa-solid fa-calendar-check"></i></div>
            <span class="badge-growth green">Terjadwal</span>
          </div>
          <div class="stat-number">5</div>
          <div class="stat-desc"><strong>Laporan Terjadwal</strong></div>
          <div class="stat-sub">Otomatis dibuat</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon blue"><i class="fa-solid fa-download"></i></div>
            <span class="badge-growth blue">+18%</span>
          </div>
          <div class="stat-number">142</div>
          <div class="stat-desc"><strong>Total Unduhan</strong></div>
          <div class="stat-sub">30 hari terakhir</div>
        </div>

        <div class="stat-card">
          <div class="stat-header">
            <div class="stat-icon orange"><i class="fa-solid fa-clock-rotate-left"></i></div>
          </div>
          <div class="stat-number">2 mnt</div>
          <div class="stat-desc"><strong>Waktu Generate</strong></div>
          <div class="stat-sub">Rata-rata per laporan</div>
        </div>
      </section>

      <!-- Kategori Laporan Cepat -->
      <section class="card">
        <div class="card-header">
          <div>
            <h3>Buat Laporan Cepat</h3>
            <p class="subtitle">Pilih jenis laporan yang ingin Anda buat sekarang.</p>
          </div>
        </div>

        <div class="report-grid">
          <a href="#" class="report-card">
            <div class="report-icon bg-purple"><i class="fa-solid fa-users"></i></div>
            <div class="report-info">
              <strong>Laporan Pengguna</strong>
              <span class="sub-text">Data lengkap pengguna & aktivitas</span>
            </div>
            <i class="fa-solid fa-chevron-right report-arrow"></i>
          </a>

          <a href="#" class="report-card">
            <div class="report-icon bg-green"><i class="fa-solid fa-book-open"></i></div>
            <div class="report-info">
              <strong>Laporan Kursus</strong>
              <span class="sub-text">Performa & engagement kursus</span>
            </div>
            <i class="fa-solid fa-chevron-right report-arrow"></i>
          </a>

          <a href="#" class="report-card">
            <div class="report-icon bg-orange"><i class="fa-solid fa-chart-line"></i></div>
            <div class="report-info">
              <strong>Laporan Aktivitas</strong>
              <span class="sub-text">Sesi belajar & keterlibatan</span>
            </div>
            <i class="fa-solid fa-chevron-right report-arrow"></i>
          </a>

          <a href="#" class="report-card">
            <div class="report-icon bg-blue"><i class="fa-solid fa-triangle-exclamation"></i></div>
            <div class="report-info">
              <strong>Laporan Konten</strong>
              <span class="sub-text">Laporan masalah dari pengguna</span>
            </div>
            <i class="fa-solid fa-chevron-right report-arrow"></i>
          </a>

          <a href="#" class="report-card">
            <div class="report-icon bg-purple"><i class="fa-solid fa-gear"></i></div>
            <div class="report-info">
              <strong>Laporan Sistem</strong>
              <span class="sub-text">Performa & log sistem</span>
            </div>
            <i class="fa-solid fa-chevron-right report-arrow"></i>
          </a>
        </div>
      </section>

      <!-- Layout 2 Kolom: Tabel Laporan & Sidebar -->
      <div class="grid-2-col grid-sidebar">

        <!-- Kolom Kiri: Tabel Laporan Terbaru -->
        <div class="stack-col">
          <section class="card table-card">
            <div class="card-header">
              <div>
                <h3>Laporan Terbaru</h3>
                <p class="subtitle">Daftar laporan yang baru saja dibuat atau diunduh.</p>
              </div>
              <div class="header-actions">
                <button class="btn btn-outline"><i class="fa-solid fa-filter"></i> Filter</button>
              </div>
            </div>

            <div class="table-responsive">
              <table class="admin-table">
                <thead>
                  <tr>
                    <th>NAMA LAPORAN</th>
                    <th>JENIS</th>
                    <th>PERIODE</th>
                    <th>UKURAN</th>
                    <th>STATUS</th>
                    <th class="text-right">TINDAKAN</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($LAPORAN_ADMIN as $l): ?>
                  <tr>
                    <td>
                      <div class="user-profile-cell">
                        <div class="avatar-circle <?= e($l['warna']) ?>"><i class="fa-solid <?= e(str_replace('fa-solid ', '', $l['ikon'])) ?>"></i></div>
                        <div>
                          <div class="user-name"><?= e($l['nama']) ?></div>
                          <div class="user-email"><?= e($l['dibuat']) ?></div>
                        </div>
                      </div>
                    </td>
                    <td><span class="badge-status <?= e($l['jenis_warna']) ?>"><?= e($l['jenis']) ?></span></td>
                    <td><?= e($l['periode']) ?></td>
                    <td><?= e($l['ukuran']) ?></td>
                    <td><span class="badge-status <?= e($l['status_warna']) ?>"><?= e($l['status']) ?></span></td>
                    <td class="text-right">
                      <?php if ($l['aksi'] === 'Unduh'): ?>
                        <a href="#" class="btn-table"><i class="fa-solid fa-download"></i> Unduh</a>
                      <?php else: ?>
                        <a href="#" class="btn-table"><i class="fa-solid fa-clock"></i> Menunggu</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="table-footer">
              <span class="table-info">Menampilkan 5 dari 24 laporan</span>
              <div class="pagination">
                <button class="btn-page"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="btn-page active">1</button>
                <button class="btn-page">2</button>
                <button class="btn-page">3</button>
                <button class="btn-page"><i class="fa-solid fa-chevron-right"></i></button>
              </div>
            </div>
          </section>
        </div>

        <!-- Kolom Kanan: Sidebar -->
        <div class="stack-col">

          <!-- Laporan Terjadwal -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Terjadwal</h3>
                <p class="subtitle">Laporan otomatis berikutnya</p>
              </div>
            </div>

            <div class="activity-list">
              <div class="activity-item">
                <div class="user-avatar-tag bg-purple-light"><i class="fa-solid fa-users"></i></div>
                <div class="activity-content">
                  <strong>Laporan Pengguna Mingguan</strong>
                  <div class="sub-text sub-text-mt">Senin depan, 08:00</div>
                </div>
                <span class="time-tag purple">Mingguan</span>
              </div>

              <div class="activity-item">
                <div class="user-avatar-tag bg-green-light"><i class="fa-solid fa-book-open"></i></div>
                <div class="activity-content">
                  <strong>Performa Kursus Bulanan</strong>
                  <div class="sub-text sub-text-mt">1 Nov 2026, 08:00</div>
                </div>
                <span class="time-tag green">Bulanan</span>
              </div>

              <div class="activity-item">
                <div class="user-avatar-tag bg-orange-light"><i class="fa-solid fa-chart-line"></i></div>
                <div class="activity-content">
                  <strong>Aktivitas Belajar Harian</strong>
                  <div class="sub-text sub-text-mt">Besok, 06:00</div>
                </div>
                <span class="time-tag orange">Harian</span>
              </div>
            </div>

            <a href="#" class="btn btn-outline btn-full">
              <i class="fa-solid fa-calendar"></i> Kelola Jadwal
            </a>
          </div>

          <!-- Statistik Cepat -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Aktivitas Laporan</h3>
                <p class="subtitle">Aktivitas 7 hari terakhir</p>
              </div>
            </div>

            <div class="metrics-list">
              <div class="metric-item">
                <div class="metric-label">
                  <span>Laporan dibuat</span>
                  <strong>12</strong>
                </div>
                <div class="progress-bar-sm"><div class="fill purple" style="width: 80%;"></div></div>
              </div>

              <div class="metric-item">
                <div class="metric-label">
                  <span>Laporan diunduh</span>
                  <strong>38</strong>
                </div>
                <div class="progress-bar-sm"><div class="fill green" style="width: 92%;"></div></div>
              </div>

              <div class="metric-item">
                <div class="metric-label">
                  <span>Laporan terjadwal</span>
                  <strong>5</strong>
                </div>
                <div class="progress-bar-sm"><div class="fill orange" style="width: 45%;"></div></div>
              </div>
            </div>
          </div>

          <!-- Bantuan -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Butuh Bantuan?</h3>
                <p class="subtitle">Panduan seputar laporan</p>
              </div>
            </div>

            <div class="activity-list">
              <div class="activity-item">
                <div class="user-avatar-tag bg-blue-light"><i class="fa-solid fa-book"></i></div>
                <div class="activity-content">
                  <a href="#">Cara membuat laporan kustom</a>
                </div>
              </div>

              <div class="activity-item">
                <div class="user-avatar-tag bg-green-light"><i class="fa-solid fa-circle-question"></i></div>
                <div class="activity-content">
                  <a href="#">FAQ — Format & Ekspor</a>
                </div>
              </div>

              <div class="activity-item">
                <div class="user-avatar-tag bg-purple-light"><i class="fa-solid fa-headset"></i></div>
                <div class="activity-content">
                  <a href="#">Hubungi tim support</a>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>

    </div>
  </main>
</body>
</html>
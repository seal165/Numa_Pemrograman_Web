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
  <title>Numa Admin Pusat — Buat Laporan Baru</title>
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
          <h2 class="page-title">Buat Laporan Baru</h2>
          <p class="subtitle">Konfigurasikan laporan kustom sesuai kebutuhan Anda.</p>
        </div>
        <a href="admin-laporan.php" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
      </div>

      <!-- Layout 2 Kolom -->
      <div class="grid-2-col grid-sidebar">

        <!-- Kolom Kiri: Form Konfigurasi -->
        <div class="stack-col">

          <!-- Step 1: Jenis Laporan -->
          <section class="card">
            <div class="step-header">
              <span class="step-number">1</span>
              <h3>Pilih Jenis Laporan</h3>
            </div>

            <div class="report-grid">
              <label class="selectable-card">
                <input type="radio" name="jenis_laporan" value="pengguna" checked>
                <div class="report-card">
                  <div class="report-icon bg-purple"><i class="fa-solid fa-users"></i></div>
                  <div class="report-info">
                    <strong>Pengguna</strong>
                    <span class="sub-text">Data pengguna & aktivitas</span>
                  </div>
                </div>
              </label>

              <label class="selectable-card">
                <input type="radio" name="jenis_laporan" value="kursus">
                <div class="report-card">
                  <div class="report-icon bg-green"><i class="fa-solid fa-book-open"></i></div>
                  <div class="report-info">
                    <strong>Kursus</strong>
                    <span class="sub-text">Performa & engagement</span>
                  </div>
                </div>
              </label>

              <label class="selectable-card">
                <input type="radio" name="jenis_laporan" value="aktivitas">
                <div class="report-card">
                  <div class="report-icon bg-orange"><i class="fa-solid fa-chart-line"></i></div>
                  <div class="report-info">
                    <strong>Aktivitas</strong>
                    <span class="sub-text">Sesi belajar & keterlibatan</span>
                  </div>
                </div>
              </label>

              <label class="selectable-card">
                <input type="radio" name="jenis_laporan" value="konten">
                <div class="report-card">
                  <div class="report-icon bg-blue"><i class="fa-solid fa-triangle-exclamation"></i></div>
                  <div class="report-info">
                    <strong>Konten</strong>
                    <span class="sub-text">Laporan masalah pengguna</span>
                  </div>
                </div>
              </label>

              <label class="selectable-card">
                <input type="radio" name="jenis_laporan" value="sistem">
                <div class="report-card">
                  <div class="report-icon bg-purple"><i class="fa-solid fa-gear"></i></div>
                  <div class="report-info">
                    <strong>Sistem</strong>
                    <span class="sub-text">Performa & log sistem</span>
                  </div>
                </div>
              </label>
            </div>
          </section>

          <!-- Step 2: Periode Laporan -->
          <section class="card">
            <div class="step-header">
              <span class="step-number">2</span>
              <h3>Pilih Periode Laporan</h3>
            </div>

            <div class="form-group">
              <label>Preset Periode</label>
              <select class="form-control">
                <option>Hari ini</option>
                <option>7 hari terakhir</option>
                <option selected>30 hari terakhir</option>
                <option>Bulan ini</option>
                <option>Bulan lalu</option>
                <option>Kuartal ini (Q4)</option>
                <option>Tahun ini</option>
                <option>Kustom (isi tanggal manual)</option>
              </select>
            </div>

            <div class="form-grid form-grid-flush">
              <div class="form-group">
                <label>Tanggal Mulai</label>
                <input type="date" class="form-control" value="2026-09-02">
              </div>
              <div class="form-group">
                <label>Tanggal Akhir</label>
                <input type="date" class="form-control" value="2026-10-02">
              </div>
            </div>
          </section>

          <!-- Step 3: Filter Lanjutan -->
          <section class="card">
            <div class="step-header">
              <span class="step-number">3</span>
              <h3>Filter Lanjutan <span class="label-optional">(opsional)</span></h3>
            </div>

            <div class="form-grid form-grid-flush">
              <div class="form-group">
                <label>Kategori Kursus</label>
                <select class="form-control">
                  <option selected>Semua Kategori</option>
                  <option>Matematika</option>
                  <option>Sains</option>
                  <option>Bahasa</option>
                  <option>Sosial</option>
                </select>
              </div>
              <div class="form-group">
                <label>Tingkat Kelas</label>
                <select class="form-control">
                  <option selected>Semua Tingkat</option>
                  <option>Kelas 4–6</option>
                  <option>Kelas 7–8</option>
                  <option>Kelas 9</option>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label>Filter Berdasarkan Status</label>
              <div class="checkbox-group">
                <label class="checkbox-item">
                  <input type="checkbox" checked>
                  <span>Sertakan pengguna aktif</span>
                </label>
                <label class="checkbox-item">
                  <input type="checkbox">
                  <span>Sertakan pengguna tidak aktif</span>
                </label>
                <label class="checkbox-item">
                  <input type="checkbox" checked>
                  <span>Hanya kursus yang sudah dipublikasikan</span>
                </label>
                <label class="checkbox-item">
                  <input type="checkbox">
                  <span>Sertakan data yang dihapus (soft-deleted)</span>
                </label>
              </div>
            </div>
          </section>

          <!-- Step 4: Format Output -->
          <section class="card">
            <div class="step-header">
              <span class="step-number">4</span>
              <h3>Pilih Format Output</h3>
            </div>

            <div class="radio-card-group">
              <label class="radio-card">
                <input type="radio" name="format" value="pdf" checked>
                <div class="radio-card-inner">
                  <i class="fa-solid fa-file-pdf"></i>
                  <strong>PDF</strong>
                  <span>Cocok untuk cetak</span>
                </div>
              </label>

              <label class="radio-card">
                <input type="radio" name="format" value="excel">
                <div class="radio-card-inner">
                  <i class="fa-solid fa-file-excel"></i>
                  <strong>Excel</strong>
                  <span>Untuk analisis data</span>
                </div>
              </label>

              <label class="radio-card">
                <input type="radio" name="format" value="csv">
                <div class="radio-card-inner">
                  <i class="fa-solid fa-file-csv"></i>
                  <strong>CSV</strong>
                  <span>Format mentah universal</span>
                </div>
              </label>
            </div>
          </section>

          <!-- Step 5: Opsi Tambahan -->
          <section class="card">
            <div class="step-header">
              <span class="step-number">5</span>
              <h3>Opsi Tambahan</h3>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Sertakan Grafik & Visualisasi</strong>
                <p>Tambahkan bar chart dan pie chart dalam laporan.</p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Sertakan Ringkasan Eksekutif</strong>
                <p>Tambahkan halaman ringkasan di awal laporan.</p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Kirim ke Email</strong>
                <p>Kirim salinan laporan ke <strong>alya.r@numa.id</strong> setelah dibuat.</p>
              </div>
              <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Jadwalkan Otomatis</strong>
                <p>Buat laporan ini secara berkala sesuai periode yang dipilih.</p>
              </div>
              <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
              </label>
            </div>
          </section>

          <!-- Tombol Aksi -->
          <section class="card card-pad-sm">
            <div class="form-actions form-actions-flush">
              <a href="admin-laporan.php" class="btn btn-outline">Batal</a>
              <button class="btn btn-outline"><i class="fa-solid fa-eye"></i> Pratinjau</button>
              <button class="btn btn-primary"><i class="fa-solid fa-wand-magic-sparkles"></i> Generate Laporan</button>
            </div>
          </section>

        </div>

        <!-- Kolom Kanan: Sidebar Ringkasan -->
        <div class="stack-col">

          <!-- Ringkasan Pilihan -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Ringkasan Pilihan</h3>
                <p class="subtitle">Periksa kembali konfigurasi Anda</p>
              </div>
            </div>

            <div class="summary-item">
              <span class="summary-label">Jenis Laporan</span>
              <span class="summary-value">Laporan Pengguna</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Periode</span>
              <span class="summary-value">30 hari terakhir<br>(2 Sep – 2 Okt 2026)</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Kategori</span>
              <span class="summary-value">Semua Kategori</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Tingkat Kelas</span>
              <span class="summary-value">Semua Tingkat</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Format</span>
              <span class="summary-value">PDF</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Grafik</span>
              <span class="summary-value text-active">Disertakan</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Estimasi Ukuran</span>
              <span class="summary-value">± 2,4 MB</span>
            </div>
            <div class="summary-item">
              <span class="summary-label">Estimasi Waktu</span>
              <span class="summary-value">± 2 menit</span>
            </div>
          </div>

          <!-- Info Card -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>💡 Tips</h3>
                <p class="subtitle">Agar laporan lebih efektif</p>
              </div>
            </div>

            <div class="activity-list">
              <div class="activity-item">
                <div class="user-avatar-tag bg-purple-light"><i class="fa-solid fa-lightbulb"></i></div>
                <div class="activity-content">
                  Gunakan <strong>filter lanjutan</strong> agar laporan lebih fokus & ringkas.
                </div>
              </div>

              <div class="activity-item">
                <div class="user-avatar-tag bg-green-light"><i class="fa-solid fa-clock"></i></div>
                <div class="activity-content">
                  Untuk data besar (>100rb baris), pilih format <strong>CSV</strong> atau <strong>Excel</strong>.
                </div>
              </div>

              <div class="activity-item">
                <div class="user-avatar-tag bg-orange-light"><i class="fa-solid fa-calendar-check"></i></div>
                <div class="activity-content">
                  Aktifkan <strong>Jadwalkan Otomatis</strong> untuk laporan rutin bulanan.
                </div>
              </div>
            </div>

            <div class="alert-box orange-alert alert-mt">
              <i class="fa-regular fa-circle-info"></i>
              <span>Laporan yang sudah di-generate akan tersimpan di halaman Laporan.</span>
            </div>
          </div>

          <!-- Butuh Bantuan -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Butuh Bantuan?</h3>
                <p class="subtitle">Panduan membuat laporan</p>
              </div>
            </div>

            <div class="activity-list">
              <div class="activity-item">
                <div class="user-avatar-tag bg-blue-light"><i class="fa-solid fa-book"></i></div>
                <div class="activity-content">
                  <a href="#">Panduan membuat laporan kustom</a>
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
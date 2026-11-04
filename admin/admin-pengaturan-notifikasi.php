<?php
require_once __DIR__ . '/../includes/config.php';
wajibAdmin('../');
$aktif = 'notifikasi';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa Admin Pusat — Pengaturan Notifikasi</title>
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
          <h2 class="page-title">Pengaturan Notifikasi</h2>
          <p class="subtitle">Atur bagaimana dan kapan Anda menerima pemberitahuan dari platform Numa.</p>
        </div>
        <a href="admin-notifikasi.php" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali ke Notifikasi</a>
      </div>

      <!-- Info Card -->
      <section class="card card-pad-sm">
        <div class="info-header">
          <div class="stat-icon purple"><i class="fa-solid fa-sliders"></i></div>
          <div class="flex-1">
            <h3 class="card-title-md">Preferensi Notifikasi Anda</h3>
            <p class="subtitle">Perubahan akan langsung berlaku setelah Anda menyimpan pengaturan ini.</p>
          </div>
          <span class="badge-status green"><i class="fa-solid fa-circle-check"></i> Tersinkron</span>
        </div>
      </section>

      <!-- Layout 2 Kolom -->
      <div class="grid-2-col grid-sidebar">

        <!-- Kolom Kiri: Form Pengaturan -->
        <div class="stack-col">

          <!-- Kanal Notifikasi -->
          <section class="card">
            <div class="card-header">
              <div>
                <h3><i class="fa-solid fa-tower-broadcast icon-inline"></i> Kanal Notifikasi</h3>
                <p class="subtitle">Pilih bagaimana Anda ingin menerima pemberitahuan.</p>
              </div>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Email Notifikasi</strong>
                <p>Kirim ringkasan dan pemberitahuan penting ke email <strong>alya.r@numa.id</strong></p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Push Notifikasi</strong>
                <p>Terima notifikasi langsung di browser atau aplikasi mobile Anda.</p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Notifikasi WhatsApp</strong>
                <p>Kirim pemberitahuan mendesak ke WhatsApp <strong>+62 812-****-****</strong></p>
              </div>
              <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>SMS Notifikasi</strong>
                <p>Kirim pemberitahuan penting melalui SMS ke nomor terdaftar.</p>
              </div>
              <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
              </label>
            </div>
          </section>

          <!-- Jenis Notifikasi -->
          <section class="card">
            <div class="card-header">
              <div>
                <h3><i class="fa-solid fa-bell icon-inline"></i> Jenis Notifikasi</h3>
                <p class="subtitle">Pilih kategori notifikasi yang ingin Anda terima.</p>
              </div>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Laporan Konten</strong>
                <p>Notifikasi saat ada pengguna melaporkan soal atau materi bermasalah.</p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Pengguna Baru</strong>
                <p>Notifikasi saat ada pengguna baru mendaftar atau perlu verifikasi.</p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Perubahan Kursus</strong>
                <p>Notifikasi saat kursus dibuat, diperbarui, atau dipublikasikan.</p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Insight & Analitik</strong>
                <p>Rekomendasi otomatis dan ringkasan performa platform.</p>
              </div>
              <label class="switch">
                <input type="checkbox" checked>
                <span class="slider"></span>
              </label>
            </div>

            <div class="pref-row">
              <div class="pref-info">
                <strong>Pembaruan Sistem</strong>
                <p>Info tentang update fitur, maintenance, dan perubahan kebijakan.</p>
              </div>
              <label class="switch">
                <input type="checkbox">
                <span class="slider"></span>
              </label>
            </div>
          </section>

          <!-- Frekuensi -->
          <section class="card">
            <div class="card-header">
              <div>
                <h3><i class="fa-solid fa-clock icon-inline"></i> Frekuensi Ringkasan</h3>
                <p class="subtitle">Seberapa sering Anda ingin menerima ringkasan notifikasi?</p>
              </div>
            </div>

            <div class="form-group">
              <label>Kirim ringkasan</label>
              <select class="form-control">
                <option>Langsung (real-time)</option>
                <option selected>Ringkasan harian (setiap pukul 08:00)</option>
                <option>Ringkasan mingguan (setiap Senin)</option>
                <option>Nonaktifkan ringkasan</option>
              </select>
            </div>

            <div class="form-grid form-grid-flush">
              <div class="form-group">
                <label>Jam tenang — Mulai</label>
                <input type="time" class="form-control" value="21:00">
              </div>
              <div class="form-group">
                <label>Jam tenang — Berakhir</label>
                <input type="time" class="form-control" value="07:00">
              </div>
            </div>

            <div class="alert-box orange-alert alert-mt">
              <i class="fa-regular fa-lightbulb"></i>
              <span>Selama jam tenang, notifikasi tetap masuk namun tidak akan mengganggu Anda.</span>
            </div>
          </section>

          <!-- Tombol Aksi -->
          <section class="card card-pad-sm">
            <div class="form-actions form-actions-flush">
              <button class="btn btn-outline"><i class="fa-solid fa-rotate-left"></i> Reset ke Default</button>
              <button class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Simpan Pengaturan</button>
            </div>
          </section>

        </div>

        <!-- Kolom Kanan: Sidebar Info -->
        <div class="stack-col">

          <!-- Preview Notifikasi -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Pratinjau</h3>
                <p class="subtitle">Contoh notifikasi yang akan Anda terima</p>
              </div>
            </div>

            <div class="activity-list">
              <div class="activity-item notif-preview">
                <div class="user-avatar-tag bg-red-light"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <div class="activity-content">
                  <strong>3 Laporan Konten Baru</strong>
                  <div class="sub-text sub-text-mt">Baru saja</div>
                </div>
              </div>

              <div class="activity-item notif-preview">
                <div class="user-avatar-tag bg-purple-light"><i class="fa-solid fa-user-plus"></i></div>
                <div class="activity-content">
                  <strong>Verifikasi Wali Baru</strong>
                  <div class="sub-text sub-text-mt">5 menit lalu</div>
                </div>
              </div>
            </div>
          </div>

          <!-- Status Aktif -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Status Saat Ini</h3>
                <p class="subtitle">Ringkasan preferensi aktif Anda</p>
              </div>
            </div>

            <div class="metrics-list">
              <div class="metric-item">
                <div class="metric-label">
                  <span><i class="fa-solid fa-envelope icon-fixed"></i> Email</span>
                  <strong class="text-active">Aktif</strong>
                </div>
              </div>

              <div class="metric-item">
                <div class="metric-label">
                  <span><i class="fa-solid fa-mobile-screen icon-fixed"></i> Push</span>
                  <strong class="text-active">Aktif</strong>
                </div>
              </div>

              <div class="metric-item">
                <div class="metric-label">
                  <span><i class="fa-brands fa-whatsapp icon-fixed"></i> WhatsApp</span>
                  <strong class="text-inactive">Nonaktif</strong>
                </div>
              </div>

              <div class="metric-item">
                <div class="metric-label">
                  <span><i class="fa-solid fa-comment-sms icon-fixed"></i> SMS</span>
                  <strong class="text-inactive">Nonaktif</strong>
                </div>
              </div>

              <div class="metric-item">
                <div class="metric-label">
                  <span><i class="fa-solid fa-clock icon-fixed"></i> Frekuensi</span>
                  <strong>Harian</strong>
                </div>
              </div>
            </div>
          </div>

          <!-- Bantuan -->
          <div class="card">
            <div class="card-header">
              <div>
                <h3>Butuh Bantuan?</h3>
                <p class="subtitle">Pelajari lebih lanjut tentang notifikasi</p>
              </div>
            </div>

            <div class="activity-list">
              <div class="activity-item">
                <div class="user-avatar-tag bg-blue-light"><i class="fa-solid fa-book"></i></div>
                <div class="activity-content">
                  <a href="#">Panduan pengaturan notifikasi</a>
                </div>
              </div>

              <div class="activity-item">
                <div class="user-avatar-tag bg-green-light"><i class="fa-solid fa-circle-question"></i></div>
                <div class="activity-content">
                  <a href="#">FAQ — Notifikasi & Email</a>
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
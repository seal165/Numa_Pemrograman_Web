<?php
require_once __DIR__ . '/../includes/config.php';
wajibLogin('../');
$aktif = 'quiz';
$base = '../';
$u = user();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa - Kuis Matematika</title>
  <link rel="stylesheet" href="../css/style-user.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body>

  <!-- Top Navbar -->
  <?php include __DIR__ . '/../includes/user_navbar.php'; ?>

  <!-- Container Utama -->
  <main class="dashboard-container">
    
    <!-- Hero Banner Arena Kuis -->
    <section class="quiz-hero-banner">
      <div class="quiz-badge-tag">
        <span class="icon">⚙️</span> KONFIGURASI SESI ADAPTIF
      </div>
      <h1 class="quiz-hero-title">Siapkan Arena <span class="highlight-purple">Kuis Matematika</span></h1>
      <p class="quiz-hero-desc">
        Uji pemahaman kalkulasi, asah kecepatan logika, dan kumpulkan XP untuk naik ke Liga Berlian minggu ini.
      </p>
    </section>

    <!-- Main Grid Content -->
    <div class="quiz-grid">

      <!-- Kolom Kiri: Konfigurasi Mode & Topik -->
      <section class="quiz-main-card">
        
        <div class="section-header">
          <h2>Pilih Mode Pertanyaan</h2>
          <p>Tentukan apakah ingin fokus pada 1 materi khusus atau tantangan campur.</p>
        </div>

        <!-- Selection Cards (Mode) -->
        <div class="mode-selector-grid">
          
          <label class="mode-card selected">
            <input type="radio" name="quiz_mode" checked hidden>
            <div class="mode-icon-box">
              <span class="icon">📑</span>
            </div>
            <div class="mode-info">
              <div class="mode-title-row">
                <h3>Materi Spesifik</h3>
                <span class="check-badge">✓</span>
              </div>
              <p>Latihan terfokus pada sub-topik tertentu yang ingin diperdalam.</p>
            </div>
          </label>

          <label class="mode-card">
            <input type="radio" name="quiz_mode" hidden>
            <div class="mode-icon-box">
              <span class="icon">🔀</span>
            </div>
            <div class="mode-info">
              <div class="mode-title-row">
                <h3>Mix Adaptif (Acak)</h3>
                <span class="xp-bonus-tag">+25% XP</span>
              </div>
              <p>Dikocok pintar dari seluruh materi dengan algoritma retensi spasial.</p>
            </div>
          </label>

        </div>

        <!-- Topik Selector -->
        <div class="topic-section-header">
          <span>Pilih Satu Topik Materi:</span>
          <span class="topic-count"><?= count($TOPIK_QUIZ) ?> Topik Tersedia</span>
        </div>

        <div class="topic-list-container">
          <?php foreach ($TOPIK_QUIZ as $t): ?>
          <div class="topic-card<?= $t['aktif'] ? ' active' : '' ?>">
            <div class="topic-icon-placeholder"></div>
            <div class="topic-details">
              <h3><?= e($t['judul']) ?></h3>
              <p><?= e($t['ket']) ?></p>
            </div>
            <div class="topic-action">
              <span class="badge-mastery <?= e($t['warna']) ?>"><?= e($t['persen']) ?></span>
              <?php if ($t['aktif']): ?><span class="arrow-icon">❯</span><?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>

      </section>

      <!-- Kolom Kanan: Sidebar Ringkasan & Tips -->
      <aside class="quiz-sidebar">

        <!-- Detail Persiapan -->
        <div class="card summary-card">
          <div class="summary-header">
            <div>
              <span class="summary-subtitle">RINGKASAN SESI</span>
              <h2>Detail Persiapan</h2>
            </div>
            <div class="icon-circle-purple">
              <span>📈</span>
            </div>
          </div>

          <div class="summary-info-row">
            <span class="label"><span class="icon">📑</span> Materi</span>
            <span class="value">Aljabar Linear Dasar</span>
          </div>

          <button class="btn btn-start-quiz">
            <span class="icon">🚀</span> Mulai Kuis Kilat Sekarang
          </button>
        </div>

        <!-- Tips Numa -->
        <div class="card tips-card">
          <div class="tips-icon-box">
            💡
          </div>
          <div class="tips-content">
            <h4>Tips Kilat Numa</h4>
            <p>"Kuis kilat melatih insting komputasi tanpa takut kehilangan nyawa atau hati. Jawab dengan cepat untuk melipatgandakan multiplier bonus combo!"</p>
          </div>
        </div>

        <!-- Riwayat Terakhir -->
        <div class="card history-card">
          <div class="history-header">
            <h3>Riwayat Terakhir</h3>
            <a href="#" class="link-all">Lihat Semua</a>
          </div>

          <div class="history-list">
            <?php foreach ($RIWAYAT_QUIZ as $r): ?>
            <div class="history-item">
              <div class="history-status check">✓</div>
              <div class="history-info">
                <h4><?= e($r['judul']) ?></h4>
                <p><?= e($r['ket']) ?></p>
              </div>
              <span class="history-xp"><?= e($r['xp']) ?></span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

      </aside>

    </div>

  </main>

  <?php include __DIR__ . '/../includes/user_footer.php'; ?>

</body>
</html>
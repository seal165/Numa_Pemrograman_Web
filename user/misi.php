<?php
require_once __DIR__ . '/../includes/config.php';
wajibLogin('../');
$aktif = 'misi';
$base = '../';
$u = user();

// ---- proses form (POST): beli hati & klaim misi, hasilnya disimpen di session ----
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stat = statUser();
    $aksi = $_POST['aksi'] ?? '';
    if ($aksi === 'beli_hati') {
        $jumlah = (int)($_POST['jumlah'] ?? 0);
        // harga diambil dari array di server, bukan dari form (biar gak bisa diakalin)
        $paket = array_values(array_filter($SHOP_HATI, fn($p) => $p['jumlah'] === $jumlah))[0] ?? null;
        if (!$paket) {
            setFlash('error', 'Paket hati tidak dikenal.');
        } elseif ($stat['hati'] >= 5) {
            setFlash('error', 'Hati kamu sudah penuh.');
        } elseif ($stat['koin'] < $paket['harga']) {
            setFlash('error', 'Koin kamu belum cukup (butuh ' . $paket['harga'] . ', punya ' . $stat['koin'] . ').');
        } else {
            $stat['koin'] -= $paket['harga'];
            $stat['hati'] = min(5, $stat['hati'] + $jumlah);
            $_SESSION['stat'] = $stat;
            setFlash('sukses', 'Pembelian berhasil! Hati kamu sekarang ' . $stat['hati'] . '.');
        }
    } elseif ($aksi === 'klaim_pemanasan' && empty($_SESSION['klaim']['pemanasan'])) {
        $stat['xp'] += 30;
        $stat['koin'] += 30;
        $_SESSION['stat'] = $stat;
        $_SESSION['klaim']['pemanasan'] = true;
        setFlash('sukses', 'Hadiah diklaim: +30 XP dan +30 koin.');
    }
    redirect('misi.php');      // pola Post-Redirect-Get biar gak kirim ulang pas di-refresh
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa - Pusat Misi & Tantangan</title>
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
    
    <!-- Hero Banner Misi -->
    <section class="misi-hero-banner">
      <div class="hero-left-content">
        <div class="misi-badge-tag">
          <span class="icon">🎯</span> NUMA QUEST ARENA
        </div>
        <h1 class="misi-hero-title">Pusat Misi & Tantangan</h1>
        <p class="misi-hero-desc">
          Selesaikan target harian, mingguan, dan pencapaian khusus untuk meraih XP, dan Lencana Kehormatan.
        </p>
      </div>

      <div class="timer-card-box">
        <div class="timer-icon-box">⏱️</div>
        <div class="timer-details">
          <span class="timer-label">RESET MISI HARIAN</span>
          <div class="timer-countdown">
            <span class="time-val">06</span> <span class="time-unit">jam</span> : <span class="time-val">42</span> <span class="time-unit">menit</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Main Content Layout -->
    <div class="misi-grid">

      <!-- Kolom Kiri: Misi Harian & Mingguan -->
      <section class="misi-main-section">
        
        <!-- SECTION: MISI HARIAN -->
        <div class="section-title-row">
          <div class="title-with-icon">
            <div class="icon-circle purple">☀️</div>
            <div>
              <h2>Misi Harian</h2>
              <p class="sub-title">Kumpulkan reward untuk mengamankan streak harian</p>
            </div>
          </div>
          <span class="badge-counter">1 / 3 Selesai</span>
        </div>

        <div class="misi-list">
          
          <!-- Item Misi 1 (Siap Klaim) -->
          <div class="misi-card ready">
            <div class="misi-icon-box green">🔥</div>
            <div class="misi-info">
              <div class="misi-header">
                <h3>Pemanasan Pagi</h3>
                <span class="tag-status green">✓ Siap Klaim</span>
              </div>
              <p class="misi-desc">Selesaikan 5 latihan kuis matematika.</p>
              <div class="progress-wrapper">
                <div class="progress-bar-sm"><div class="progress-fill green" style="width: 100%;"></div></div>
                <span class="progress-text">5/5 Selesai</span>
              </div>
            </div>
            <button class="btn btn-claim">
              <span class="icon">🧰</span> Klaim +30 XP & 30 Koin
            </button>
          </div>

          <!-- Item Misi 2 (Berjalan) -->
          <div class="misi-card">
            <div class="misi-icon-box orange">⏱️</div>
            <div class="misi-info">
              <div class="misi-header">
                <h3>Penjaga Streak</h3>
                <span class="tag-status gray">Berjalan</span>
              </div>
              <p class="misi-desc">Belajar minimal 10 menit tanpa jeda.</p>
              <div class="progress-wrapper">
                <div class="progress-bar-sm"><div class="progress-fill orange" style="width: 80%;"></div></div>
                <span class="progress-text">8/10 menit (80%)</span>
              </div>
            </div>
            <div class="action-reward-group">
              <span class="reward-pill">+50 XP</span>
              <button class="btn btn-secondary">Lanjut</button>
            </div>
          </div>

          <!-- Item Misi 3 (Belum Dimulai) -->
          <div class="misi-card">
            <div class="misi-icon-box blue">🎖️</div>
            <div class="misi-info">
              <div class="misi-header">
                <h3>Akurasi Ksatria</h3>
                <span class="tag-status gray">Belum Dimulai</span>
              </div>
              <p class="misi-desc">Capai skor minimal 90% pada sesi Course Aljabar.</p>
              <div class="progress-wrapper">
                <div class="progress-bar-sm"><div class="progress-fill blue" style="width: 0%;"></div></div>
                <span class="progress-text">0/1 Sesi</span>
              </div>
            </div>
            <div class="action-reward-group">
              <span class="reward-pill">+60 XP</span>
              <button class="btn btn-primary">Mulai</button>
            </div>
          </div>

        </div>

        <!-- SECTION: MISI MINGGUAN -->
        <div class="section-title-row margin-top-lg">
          <div class="title-with-icon">
            <div class="icon-circle orange">📅</div>
            <div>
              <h2>Misi Mingguan (Pekan 10)</h2>
              <p class="sub-title">Berakhir dalam 3 hari pada hari Minggu pukul 23:59 WIB</p>
            </div>
          </div>
          <span class="tag-grand-quest">⭐ Grand Quest</span>
        </div>

        <div class="misi-list">

          <!-- Item Misi Mingguan 1 -->
          <div class="misi-card weekly-card">
            <div class="misi-icon-box gray-bg">🏋️</div>
            <div class="misi-info">
              <div class="misi-header">
                <h3>Maraton 100 Soal</h3>
                <span class="tag-status green-light">64% Selesai</span>
              </div>
              <p class="misi-desc">Tuntaskan 100 soal matematika dalam 7 hari di mode kuis apa pun.</p>
              <div class="progress-wrapper">
                <div class="progress-bar-sm"><div class="progress-fill teal" style="width: 64%;"></div></div>
                <div class="progress-labels">
                  <span>64 Soal Terjawab</span>
                  <span>Target: 100 Soal</span>
                </div>
              </div>
            </div>
            
            <div class="chest-reward-box">
              <div class="chest-icon">🏆</div>
              <div class="chest-title">Peti Harta Emas</div>
              <div class="chest-sub">+250 XP & Badge</div>
              <button class="btn btn-secondary btn-sm">Lanjut Soal</button>
            </div>
          </div>

          <!-- Item Misi Mingguan 2 -->
          <div class="misi-card weekly-card">
            <div class="misi-icon-box pink-bg">📈</div>
            <div class="misi-info">
              <div class="misi-header">
                <h3>Juara Tanpa Salah</h3>
                <span class="tag-status gray">33% Progres</span>
              </div>
              <p class="misi-desc">Perbaiki seluruh soal yang keliru di Lab Kesalahan pekan ini.</p>
              <div class="progress-wrapper">
                <div class="progress-bar-sm"><div class="progress-fill blue-purple" style="width: 33%;"></div></div>
                <div class="progress-labels">
                  <span>1 / 3 Soal Diperbaiki</span>
                  <span>Sisa 2 Soal</span>
                </div>
              </div>
            </div>

            <div class="chest-reward-box purple-theme">
              <div class="chest-icon">💎</div>
              <div class="chest-title">+150 XP</div>
              <div class="chest-sub">Lab Analisis</div>
              <button class="btn btn-purple btn-sm">Buka Lab</button>
            </div>
          </div>

        </div>

      </section>

      <!-- Kolom Kanan: Shop Hati & Pencapaian Spesial -->
      <aside class="misi-sidebar">

        <!-- Widget Shop Hati -->
        <div class="card shop-card">
          <div class="shop-header">
            <div class="shop-icon">🔥</div>
            <div>
              <h3>Shop Hati</h3>
              <p>Beli nyawa untuk melanjutkan permainan</p>
            </div>
          </div>
          <p class="shop-note">Pilih paket hati yang sesuai untuk melanjutkan permainan tanpa menunggu waktu regenerasi.</p>

          <div class="shop-items-list">
            <?php foreach ($SHOP_HATI as $sh): ?>
            <form method="POST" action="misi.php" style="margin: 0;" onsubmit="return confirm('Beli <?= (int)$sh['jumlah'] ?> hati seharga <?= (int)$sh['harga'] ?> koin?');">
              <input type="hidden" name="aksi" value="beli_hati">
              <input type="hidden" name="jumlah" value="<?= (int)$sh['jumlah'] ?>">
              <button type="submit" class="shop-item" style="width: 100%; border: 0; font: inherit; cursor: pointer; text-align: left;">
                <div class="item-left"><span class="heart-icon">💙</span> <?= (int)$sh['jumlah'] ?> Hati</div>
                <div class="item-price"><?= (int)$sh['harga'] ?> Koin</div>
              </button>
            </form>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Widget Pencapaian Spesial -->
        <div class="card achievement-card">
          <div class="card-title-row">
            <h3>🏆 Pencapaian Spesial</h3>
            <a href="#" class="link-see-all">Lihat Semua (18)</a>
          </div>

          <div class="achievement-list">
            <?php foreach ($PENCAPAIAN_MISI as $a): ?>
            <div class="achievement-item<?= $a['locked'] ? ' locked' : '' ?>">
              <div class="achieve-icon <?= e($a['warna']) ?>"><?= $a['ikon'] ?></div>
              <div class="achieve-info">
                <div class="achieve-header">
                  <h4><?= e($a['judul']) ?></h4>
                  <?php if ($a['lencana']): ?><span class="level-badge <?= e($a['lencana_warna']) ?>"><?= e($a['lencana']) ?></span><?php endif; ?>
                </div>
                <p><?= e($a['ket']) ?></p>
                <div class="progress-bar-sm"><div class="progress-fill <?= e($a['bar']) ?>" style="width: <?= (int)$a['persen'] ?>%;"></div></div>
                <?php if ($a['teks']): ?><span class="stat-count"><?= e($a['teks']) ?></span><?php endif; ?>
              </div>
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
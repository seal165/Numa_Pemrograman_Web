<?php
require_once __DIR__ . '/../includes/config.php';
wajibLogin('../');
$aktif = '';
$base = '../';
$u = user();
$stat = statUser();
$level = intdiv((int)$stat['xp'], 500) + 1;
$xpLevel = (int)$stat['xp'] % 500;
$terakhir = kunjunganTerakhir();       // dibaca dari cookie SEBELUM dioverwrite catatKunjungan() halaman ini
$jam = (int)date('G');
$sapaan = $jam < 11 ? 'Selamat pagi' : ($jam < 15 ? 'Selamat siang' : ($jam < 18 ? 'Selamat sore' : 'Selamat malam'));
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa - Dashboard</title>
  
  <!-- Path CSS eksternal -->
  <link rel="stylesheet" href="../css/style-user.css">
  
  <!-- Font Plus Jakarta Sans & Remix Icon -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
</head>
<body>

  <!-- NAVBAR UTAMA -->
  <?php include __DIR__ . '/../includes/user_navbar.php'; ?>

  <!-- MAIN CONTAINER -->
  <main class="dashboard-container">

    <!-- sapaan: nama dari $_SESSION, info terakhir dibuka dari $_COOKIE -->
    <div class="sapaan-box">
      <div>
        <h1 class="sapaan-judul"><?= $sapaan ?>, <?= e(namaDepan($u['nama'])) ?>! 👋</h1>
        <p class="sapaan-ket">
          <?php if ($terakhir): ?>
            Terakhir kamu membuka <b><?= e($terakhir['halaman']) ?></b> pada <?= tanggalIndo($terakhir['waktu']) ?> WIB.
          <?php else: ?>
            Ini pertama kalinya kamu membuka Numa di browser ini.
          <?php endif; ?>
          Masuk sebagai <b>@<?= e($u['username']) ?></b> sejak <?= date('H:i', $u['login_at']) ?>.
        </p>
      </div>
      <a href="../logout.php" class="btn-logout-besar" onclick="return confirm('Yakin mau keluar?');">Keluar (Logout)</a>
    </div>


    <!-- USER PROFILE CARD -->
    <section class="profile-card-main card">
      <div class="profile-header-flex">
        <div class="profile-info-left">
          <div class="avatar-box">
            <img src="https://placehold.co/104x104?text=<?= urlencode(inisial($u['nama'])) ?>" alt="<?= e($u['nama']) ?>">
          </div>
          <div class="status-dot-green"></div>
          <div class="user-meta-details">
            <div class="name-row">
              <h2 id="displayNameJey"><?= e($u['nama']) ?></h2>
              <span class="username-badge">@<?= e($u['username']) ?></span>
            </div>
            <div class="email-follow-row">
              <span class="email-text"><i class="ri-mail-line"></i> <span id="displayEmailJey"><?= e($u['email']) ?></span></span>
              <div class="follow-stats">
                <span class="highlight-num">98</span> <span class="label-text">Mengikuti</span>
                <span class="dot-separator">•</span>
                <span class="highlight-num">70</span> <span class="label-text">Pengikut</span>
              </div>
            </div>
          </div>
        </div>
        
        <div class="profile-action-buttons">
          <button class="btn btn-light-gray" id="btnBukaFormEdit"><i class="ri-pencil-line"></i> Edit Profil</button>
          <button class="btn btn-navy"><i class="ri-share-box-line"></i> Bagikan Portofolio</button>
        </div>
      </div>

      <!-- FORM CRUD PROFIL TAMBAHAN (UNTUK TUGAS PRAKTIKUM) -->
      <div id="formEditContainer" style="display: none; margin-top: 20px; padding: 20px; background: #f8fafc; border-radius: 12px; border: 1px solid #cbd5e1;">
        <h3 style="margin-bottom: 12px; font-size: 1rem; color: #0f172a;">⚙️ Form Pengaturan & Web Storage CRUD</h3>
        <form id="formProfilJey">
          <div style="margin-bottom: 12px;">
            <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Nama Lengkap:</label>
            <input type="text" id="inputNamaJey" class="input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff;" required>
          </div>
          <div style="margin-bottom: 12px;">
            <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Email:</label>
            <input type="email" id="inputEmailJey" class="input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff;" required>
          </div>
          <div style="margin-bottom: 15px;">
            <label style="display: block; font-size: 0.8rem; font-weight: 700; margin-bottom: 4px;">Kata Sandi Baru:</label>
            <input type="password" id="inputSandiJey" class="input" style="width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 8px; background: #fff;" placeholder="Minimal 6 karakter">
            <small id="notifSandi" style="display: block; margin-top: 4px; font-size: 0.75rem; font-weight: 600;"></small>
          </div>
          <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <button type="submit" id="btnSimpanPerubahan" class="btn btn-primary" style="padding: 6px 14px; font-size: 0.8rem;">Simpan Perubahan</button>
            <button type="button" id="btnEditPrompt" class="btn btn-secondary" style="padding: 6px 14px; font-size: 0.8rem;">Ubah Cepat (Prompt Box)</button>
            <button type="button" id="btnResetStorage" class="btn" style="background: #ef4444; color: white; padding: 6px 14px; font-size: 0.8rem; border-radius: 8px; cursor: pointer;">Reset Storage</button>
          </div>
        </form>
        <!-- Kotak Fetch API -->
        <div id="boxApiQuote" style="margin-top: 15px; padding: 10px; background: #e0e7ff; border-left: 4px solid #4f46e5; border-radius: 6px;">
          <p id="teksApiQuote" style="font-size: 0.8rem; color: #3730a3;"><i>Mengambil quotes motivasi secara asynchronous...</i></p>
        </div>
      </div>

      <!-- STATS OVERVIEW GRID (5 KOTAK UTAMA) -->
      <div class="stats-overview-grid" style="margin-top: 20px;">
        
        <!-- 1. Streak Aktif -->
        <div class="stat-inner-box">
          <div class="stat-box-top">
            <span class="stat-box-title">STREAK AKTIF</span>
            <i class="ri-fire-fill orange-text" style="font-size: 1.1rem;"></i>
          </div>
          <div class="stat-box-value orange-text"><?= (int)$stat['streak'] ?> Hari</div>
          <div class="streak-dots-row">
            <span class="streak-dot light">S</span>
            <span class="streak-dot light">S</span>
            <span class="streak-dot active-gold">R</span>
            <span class="streak-dot">K</span>
            <span class="streak-dot">J</span>
            <span class="streak-dot">S</span>
            <span class="streak-dot">M</span>
          </div>
        </div>

        <!-- 2. Total XP -->
        <div class="stat-inner-box">
          <div class="stat-box-top">
            <span class="stat-box-title">TOTAL XP</span>
            <i class="ri-flashlight-fill purple-text" style="font-size: 1.1rem;"></i>
          </div>
          <div class="stat-box-value purple-text"><?= (int)$stat['xp'] ?></div>
          <div class="stat-box-sub">Akumulasi belajar</div>
        </div>

        <!-- 3. Level Siswa -->
        <div class="stat-inner-box">
          <div class="stat-box-top">
            <span class="stat-title">LEVEL SISWA</span>
            <i class="ri-shield-fill" style="color: #2563eb; font-size: 1.1rem;"></i>
          </div>
          <div class="level-progress-group">
            <div class="level-header-row">
              <span class="level-title-num">Lv. <?= $level ?></span>
              <span class="level-ratio"><?= $xpLevel ?> / 500 XP</span>
            </div>
            <div class="progress-bar-sm">
              <div class="progress-fill purple" style="width: <?= round($xpLevel / 500 * 100) ?>%;"></div>
            </div>
          </div>
          <div class="stat-box-sub"><?= 500 - $xpLevel ?> XP lagi ke Level <?= $level + 1 ?></div>
        </div>

        <!-- 4. Energi Latihan -->
        <div class="stat-inner-box">
          <div class="stat-box-top">
            <span class="stat-box-title">ENERGI LATIHAN</span>
            <i class="ri-heart-3-fill red-text" style="font-size: 1.1rem;"></i>
          </div>
          <div class="stat-box-value red-text"><?= (int)$stat['hati'] ?> <span class="sub-unit">/ 5 Hati</span></div>
          <div class="energy-status-row">
            <span class="mini-green-dot"></span>
            <span class="green-text-bold"><?= $stat['hati'] >= 5 ? 'Energi Penuh' : 'Energi Kurang' ?></span>
          </div>
        </div>

        <!-- 5. Liga Pythagoras -->
        <div class="stat-inner-box">
          <div class="stat-box-top">
            <span class="stat-title">LIGA PYTHAGORAS</span>
            <i class="ri-trophy-fill" style="color: #d97706; font-size: 1.1rem;"></i>
          </div>
          <div class="league-rank-row">
            <span class="rank-num">#3</span>
            <span class="league-name">Klasemen Emas</span>
          </div>
          <div class="badge-promo-pill">Zona Promosi ↑</div>
        </div>

      </div>
    </section>

    <!-- CONTENT GRID 2 KOLOM (KIRI & KANAN TERTATA RAPI) -->
    <div style="margin-top: 24px; display: grid; grid-template-columns: 1fr 340px; gap: 24px; align-items: start;">
      
      <!-- KOLOM KIRI (BERURUTAN KE BAWAH) -->
      <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <!-- 1. Banner Modul Lanjutan -->
        <div class="unit-banner card" style="margin-bottom: 0;">
          <div class="unit-content">
            <span class="unit-tag">Modul Lanjutan 1.4</span>
            <h2>Unit 1: Operasi Bilangan Berpangkat & Aljabar Linear</h2>
            <p>Pecahkan 7 tantangan soal cerita persamaan linear satu variabel untuk menyelesaikan Bab 1 dan klaim Lencana Master Aljabar!</p>
            <div class="unit-progress-row">
              <div class="progress-bar-sm"><div class="progress-fill purple" style="width: 46%;"></div></div>
              <span class="progress-stars">46% Selesai</span>
            </div>
          </div>
          <button class="btn btn-concept">Mulai Belajar</button>
        </div>

        <!-- 2. 3 Menu Cepat Berjejer Rapi ke Samping -->
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
          <?php foreach ($MENU_CEPAT as $m): ?>
          <a href="<?= $m['link'] ?>" class="quick-action-card" style="margin-bottom: 0; text-decoration: none; color: inherit;">
            <div class="quick-icon-wrap <?= $m['warna'] ?>"><i class="<?= $m['ikon'] ?>"></i></div>
            <div class="quick-text-info">
              <div class="quick-title-row">
                <h3><?= e($m['judul']) ?></h3>
                <span class="<?= $m['badge'] ?>"><?= e($m['badge_teks']) ?></span>
              </div>
              <p><?= e($m['ket']) ?></p>
            </div>
            <i class="ri-arrow-right-s-line arrow-col"></i>
          </a>
          <?php endforeach; ?>
        </div>

        <!-- 3. Statistik Perkembangan XP -->
        <div class="card chart-card" style="padding: 20px; margin-bottom: 0;">
          <div class="chart-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <div>
              <h3 style="font-size: 1rem; font-weight: 800;">Statistik Perkembangan XP</h3>
              <span style="font-size: 0.75rem; color: var(--text-muted);">Akun sejak Jan 2023</span>
            </div>
            <div class="year-selector" style="display: flex; gap: 4px;">
              <button style="padding: 4px 8px; font-size: 0.7rem; border-radius: 6px; background: #f1f5f9; border: 1px solid #cbd5e1;">&lt; 2023</button>
              <button style="padding: 4px 8px; font-size: 0.7rem; border-radius: 6px; background: #3730a3; color: white; font-weight: 700;">2024</button>
              <button style="padding: 4px 8px; font-size: 0.7rem; border-radius: 6px; background: #f1f5f9; border: 1px solid #cbd5e1;">2025 &gt;</button>
            </div>
          </div>

          <!-- Dummy Bar Chart Visual -->
          <div class="bar-chart-container" style="display: flex; justify-content: space-between; align-items: flex-end; height: 120px; padding-top: 20px; border-bottom: 1px solid #e2e8f0;">
            <?php $maks = max($XP_BULANAN); foreach ($XP_BULANAN as $bulan => $xp): ?>
              <?php if ($xp > 0 && $xp === $maks): ?>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1; position: relative;">
              <span style="position: absolute; top: -22px; font-size: 0.65rem; background: #3730a3; color: white; padding: 2px 4px; border-radius: 4px; font-weight: 700; white-space: nowrap;">★ <?= (int)$xp ?></span>
              <div style="width: 18px; height: 90px; background: #4f46e5; border-radius: 4px;"></div>
              <span style="font-size: 0.65rem; font-weight: 700; color: #3730a3;"><?= e($bulan) ?></span>
            </div>
              <?php else: ?>
            <div style="display: flex; flex-direction: column; align-items: center; gap: 4px; flex: 1;"><div style="width: 16px; height: 10px; background: #cbd5e1; border-radius: 4px;"></div><span style="font-size: 0.65rem; color: var(--text-muted);"><?= e($bulan) ?></span></div>
              <?php endif; ?>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- 4. Pencapaian Siswa -->
        <div class="card" style="padding: 20px; margin-bottom: 0;">
          <div class="card-title-row">
            <h3><i class="ri-medal-line"></i> Pencapaian Siswa</h3>
            <a href="#" class="link-see-all">Lihat Semua (18)</a>
          </div>
          <div class="achievement-list">
            <?php foreach ($PENCAPAIAN as $a): ?>
            <div class="achievement-item">
              <div class="achieve-icon <?= $a['warna'] ?>"><i class="<?= $a['ikon'] ?>"></i></div>
              <div class="achieve-info">
                <div class="achieve-header">
                  <h4><?= e($a['judul']) ?></h4>
                  <span class="level-badge <?= $a['lencana_warna'] ?>"><?= e($a['lencana']) ?></span>
                </div>
                <p><?= e($a['ket']) ?></p>
                <div class="progress-bar-sm"><div class="progress-fill <?= $a['bar'] ?>" style="width: <?= (int)$a['persen'] ?>%; <?= $a['extra'] ?>"></div></div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

      </div>

      <!-- KOLOM KANAN (SIDEBAR: LIGA, TEMAN, CHEST) -->
      <div style="display: flex; flex-direction: column; gap: 20px;">
        
        <!-- Liga Pythagoras -->
        <div class="card" style="padding: 20px; margin-bottom: 0;">
          <div class="card-title-row">
            <h3><i class="ri-trophy-line"></i> Liga Pythagoras</h3>
            <span class="tag-promo-green">Sisa: 1 Hari</span>
          </div>
          <p class="league-desc">Zona Promosi ke Liga Diamond (Top 3)</p>
          <div class="league-list">
            <div class="league-item active-user">
              <span class="rank-no">#3</span>
              <span class="user-name" id="rankNameJey"><?= e(namaDepan($u['nama'])) ?> (Kamu)</span>
              <span class="xp-value"><?= (int)$stat['xp'] ?> XP</span>
            </div>
          </div>
        </div>

        <!-- Teman Belajar -->
        <div class="card" style="padding: 20px; margin-bottom: 0;">
          <div class="card-title-row">
            <h3>Teman Belajar</h3>
            <span class="tag-level-purple">98 Mengikuti</span>
          </div>
          <div class="league-list" style="margin-top: 10px; gap: 8px;">
            <?php foreach ($TEMAN as $t): ?>
            <div class="league-item" style="display: flex; justify-content: space-between; align-items: center;">
              <span class="user-name"><strong><?= e($t['nama']) ?></strong><br><small style="color: #64748b;">Streak <?= (int)$t['streak'] ?> Hari 🔥</small></span>
              <span class="xp-value"><?= (int)$t['xp'] ?> XP</span>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <!-- Peti Harta Karun -->
        <div class="chest-card" style="margin-bottom: 0;">
          <div class="chest-info">
            <div class="chest-icon">🎁</div>
            <div>
              <h4>Peti Harta Karun</h4>
              <p>Klaim bonus XP harianmu!</p>
            </div>
          </div>
          <button class="btn-claim">Klaim</button>
        </div>

      </div>

    </div>

  </main>

  <?php include __DIR__ . '/../includes/user_footer.php'; ?>

  <!-- SCRIPT -->
  <script>
    // data dari session PHP dikirim ke javascript
    window.NUMA_USER = <?= json_encode(['nama' => $u['nama'], 'email' => $u['email'], 'username' => $u['username']], JSON_HEX_TAG | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE) ?>;
  </script>
  <script src="../js/user/dashboard.js"></script>
</body>
</html>
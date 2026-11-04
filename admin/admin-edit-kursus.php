<?php
require_once __DIR__ . '/../includes/config.php';
wajibAdmin('../');
$aktif = 'kursus';
$mode = 'edit';
$id = $_GET['id'] ?? ($_POST['id'] ?? '');
$daftar = muatKursus();
$idx = null;
foreach ($daftar as $i => $k) { if ($k['id'] === $id) { $idx = $i; } }
if ($idx === null) {
    setFlash('error', 'Kursus yang mau diedit tidak ditemukan.');
    redirect('admin-kursus.php');
}
$k = $daftar[$idx];
$nilai = ['nama' => $k['nama'], 'kategori' => mb_strtolower($k['kategori']), 'tingkat' => $k['tingkat'] ?? '', 'deskripsi' => $k['deskripsi'] ?? '', 'status' => $k['status'] === 'Aktif' ? 'aktif' : 'draft'];
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    [$nilai, $errors] = validasiKursus($_POST);
    if (!$errors) {
        $baru = bikinKursus($nilai, $k['id']);
        $baru['materi'] = $k['materi']; $baru['siswa'] = $k['siswa'];
        $daftar[$idx] = $baru;
        tulisJson('kursus', $daftar);
        setFlash('sukses', 'Perubahan kursus disimpan.');
        redirect('admin-kursus.php');
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Numa Admin Pusat — Edit Kursus</title>
  <link rel="stylesheet" href="../css/style-admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  
  <style>
    .form-card { padding: 32px; }
    .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px; }
    .form-group { display: flex; flex-direction: column; margin-bottom: 24px; }
    .form-group label { font-size: 13px; font-weight: 700; color: var(--text-main); margin-bottom: 8px; }
    .form-control {
      width: 100%; padding: 12px 16px; border: 1px solid var(--border-color);
      border-radius: 8px; font-family: inherit; font-size: 14px; color: var(--text-main);
      background: white; outline: none; transition: all 0.2s ease;
    }
    .form-control:focus { border-color: var(--primary-color); box-shadow: 0 0 0 3px rgba(91, 76, 230, 0.1); }
    .form-control::placeholder { color: #94a3b8; }
    textarea.form-control { resize: vertical; min-height: 120px; }
    .form-actions { display: flex; justify-content: flex-end; gap: 12px; border-top: 1px solid var(--border-color); padding-top: 24px; margin-top: 8px; }
    @media (max-width: 768px) { .form-grid { grid-template-columns: 1fr; } .form-card { padding: 20px; } }
  </style>
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
      <!-- Judul Halaman & Breadcrumb -->
      <div style="margin-top: 8px; margin-bottom: 8px; display: flex; justify-content: space-between; align-items: center;">
        <div>
          <h2 style="font-size: 24px; font-weight: 800; color: var(--text-main);">Edit Kursus: Aljabar Linear Dasar</h2>
          <p class="subtitle" style="font-size: 14px;">Perbarui informasi kursus sesuai kebutuhan.</p>
        </div>
        <a href="admin-kursus.php" class="btn btn-outline"><i class="fa-solid fa-arrow-left"></i> Kembali</a>
      </div>

      <!-- Form Card -->
      <section class="card form-card">
        <?php include __DIR__ . '/../includes/form_kursus.php'; ?>
      </section>
    </div>
  </main>
</body>
</html>
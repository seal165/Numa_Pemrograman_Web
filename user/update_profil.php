<?php
/*
 * update_profil.php
 * Dipanggil lewat fetch() dari dashboard.js pas user nyimpen perubahan profil,
 * supaya nama di $_SESSION (dan di navbar halaman lain) ikut berubah.
 */
require_once __DIR__ . '/../includes/config.php';
header('Content-Type: application/json; charset=utf-8');

if (!sudahLogin() || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    echo json_encode(['ok' => false, 'pesan' => 'Tidak diizinkan']);
    exit;
}

$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? user()['email']);
if (mb_strlen($nama) < 3 || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'pesan' => 'Nama minimal 3 huruf dan email harus valid']);
    exit;
}

// update di session
$_SESSION['user']['nama'] = $nama;
$_SESSION['user']['email'] = $email;

// update juga di file users.json
$users = muatUsers();
foreach ($users as $i => $usr) {
    if ($usr['username'] === user()['username']) {
        $users[$i]['nama'] = $nama;
        $users[$i]['email'] = $email;
    }
}
tulisJson('users', $users);

echo json_encode(['ok' => true, 'nama' => $nama]);

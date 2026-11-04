<?php
/*
 * functions.php
 * Kumpulan fungsi bantu: session, cookie, baca/tulis file json, dll.
 */


// ---------- CADANGAN FUNGSI mb_* ----------
// Fungsi mb_* butuh ekstensi mbstring. Kalau di PHP-mu belum aktif, dipakai versi sederhana ini
// supaya web tetap jalan tanpa error "Call to undefined function".
if (!function_exists('mb_strlen')) {
    function mb_strlen($s, $enc = null) { return preg_match_all('/./us', (string)$s); }
}
if (!function_exists('mb_substr')) {
    function mb_substr($s, $start, $len = null, $enc = null) {
        preg_match_all('/./us', (string)$s, $m);
        return implode('', array_slice($m[0], $start, $len));
    }
}
if (!function_exists('mb_strtolower')) {
    function mb_strtolower($s, $enc = null) { return strtolower((string)$s); }
}
if (!function_exists('mb_strtoupper')) {
    function mb_strtoupper($s, $enc = null) { return strtoupper((string)$s); }
}

// ---------- HELPER UMUM ----------

// biar teks dari user aman ditampilin di HTML (cegah XSS)
function e($teks): string
{
    return htmlspecialchars((string)$teks, ENT_QUOTES, 'UTF-8');
}

function redirect(string $url): void
{
    header('Location: ' . $url);
    exit;
}

// ambil kata pertama dari nama, buat sapaan
function namaDepan(string $nama): string
{
    return explode(' ', trim($nama))[0] ?? $nama;
}

// huruf depan nama buat avatar, contoh "Jey Raditya" -> "JR"
function inisial(string $nama): string
{
    $kata = preg_split('/\s+/', trim($nama));
    $hasil = '';
    foreach (array_slice($kata, 0, 2) as $k) {
        $hasil .= mb_strtoupper(mb_substr($k, 0, 1));
    }
    return $hasil ?: '?';
}

function tanggalIndo(?int $waktu = null): string
{
    $bulan = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    $waktu = $waktu ?? time();
    return date('j', $waktu) . ' ' . $bulan[(int)date('n', $waktu)] . ' ' . date('Y, H:i', $waktu);
}

// ---------- FLASH MESSAGE (pesan sekali tampil, disimpen di session) ----------
function setFlash(string $jenis, string $pesan): void
{
    $_SESSION['flash'] = ['jenis' => $jenis, 'pesan' => $pesan];
}

function ambilFlash(): ?array
{
    $f = $_SESSION['flash'] ?? null;
    unset($_SESSION['flash']);          // diambil sekali, langsung dihapus
    return $f;
}

function tampilFlash(): void
{
    $f = ambilFlash();
    if ($f) {
        echo '<div class="flash flash-' . e($f['jenis']) . '">' . e($f['pesan']) . '</div>';
    }
}

// ---------- FILE JSON (pengganti database sederhana) ----------
function bacaJson(string $nama, array $default = []): array
{
    $path = DATA_DIR . '/' . $nama . '.json';
    if (!file_exists($path)) {
        return $default;
    }
    $isi = json_decode(file_get_contents($path), true);
    return is_array($isi) ? $isi : $default;
}

function tulisJson(string $nama, array $data): bool
{
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0775, true);
    }
    $path = DATA_DIR . '/' . $nama . '.json';
    // LOCK_EX biar kalau ada 2 request barengan, filenya gak rusak
    return file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE), LOCK_EX) !== false;
}

// ---------- DATA PENGGUNA ----------
// kalau data/users.json belum ada, dibikinin akun contoh dulu
function muatUsers(): array
{
    $users = bacaJson('users', []);
    if (!$users) {
        $users = [
            ['username' => 'jey_math',   'email' => 'jey.pratama@sekolah.sch.id', 'nama' => 'Jey Raditya Pratama', 'role' => 'siswa', 'password' => password_hash('jey12345', PASSWORD_DEFAULT),   'dibuat' => time()],
            ['username' => 'arka_juara', 'email' => 'arka@sekolah.sch.id',        'nama' => 'Arka Juara',          'role' => 'siswa', 'password' => password_hash('numa12345', PASSWORD_DEFAULT), 'dibuat' => time()],
            ['username' => 'admin',      'email' => 'admin@numa.id',              'nama' => 'Alya Rahmani',        'role' => 'admin', 'password' => password_hash('admin12345', PASSWORD_DEFAULT), 'dibuat' => time()],
        ];
        tulisJson('users', $users);
    }
    return $users;
}

// cari user lewat username ATAU email
function cariUser(string $kunci): ?array
{
    $kunci = mb_strtolower(trim($kunci));
    foreach (muatUsers() as $u) {
        if (mb_strtolower($u['username']) === $kunci || mb_strtolower($u['email']) === $kunci) {
            return $u;
        }
    }
    return null;
}

// ---------- SESSION LOGIN ----------
function user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function sudahLogin(): bool
{
    return isset($_SESSION['user']);
}

// dipanggil di awal halaman user: kalau belum login, lempar ke halaman login
function wajibLogin(string $base = '../'): void
{
    if (!sudahLogin()) {
        setFlash('error', 'Kamu harus masuk dulu buat buka halaman itu.');
        redirect($base . 'login.php');
    }
    catatKunjungan();
}

// khusus halaman admin, siswa biasa gak boleh masuk
function wajibAdmin(string $base = '../'): void
{
    if (!sudahLogin()) {
        setFlash('error', 'Silakan masuk dulu sebagai admin.');
        redirect($base . 'login.php');
    }
    if (user()['role'] !== 'admin') {
        setFlash('error', 'Halaman admin cuma bisa dibuka akun admin.');
        redirect($base . 'user/dashboard.php');
    }
}

// simpen data user ke session setelah login berhasil
function masukkanKeSession(array $u): void
{
    session_regenerate_id(true);        // ganti id session, cegah session fixation
    $_SESSION['user'] = [
        'username' => $u['username'],
        'email'    => $u['email'],
        'nama'     => $u['nama'],
        'role'     => $u['role'],
        'login_at' => time(),
    ];
    // statistik awal tiap kali login (hati, streak, xp, koin)
    $_SESSION['stat'] = ['hati' => 5, 'streak' => 3, 'xp' => 105, 'koin' => 30];
}

// logout: hapus isi session, hapus cookie session, lalu destroy
function keluarkanUser(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'] ?? '', $p['secure'] ?? false, $p['httponly'] ?? true);
    }
    session_destroy();
}

function statUser(): array
{
    return $_SESSION['stat'] ?? ['hati' => 5, 'streak' => 3, 'xp' => 105, 'koin' => 30];
}

// ---------- COOKIE ----------
// cookie "ingat saya": nyimpen username 30 hari
function setCookieIngat(string $username): void
{
    setcookie('numa_ingat', $username, [
        'expires'  => time() + 60 * 60 * 24 * 30,
        'path'     => '/',
        'httponly' => true,
        'samesite' => 'Lax',
    ]);
}

function hapusCookieIngat(): void
{
    setcookie('numa_ingat', '', time() - 3600, '/');
    unset($_COOKIE['numa_ingat']);
}

// cookie "terakhir dibuka": nyatet halaman terakhir yang dikunjungi + waktunya
function catatKunjungan(): void
{
    if (headers_sent()) {
        return;
    }
    $halaman = ucwords(str_replace(['-', '.php'], [' ', ''], basename($_SERVER['SCRIPT_NAME'])));
    $nilai = $halaman . '|' . time();      // setcookie() otomatis meng-encode nilainya
    setcookie('numa_terakhir', $nilai, ['expires' => time() + 60 * 60 * 24 * 30, 'path' => '/', 'samesite' => 'Lax']);
}

// baca cookie tadi, hasilnya contoh: ['halaman' => 'Misi', 'waktu' => 1730000000]
function kunjunganTerakhir(): ?array
{
    if (empty($_COOKIE['numa_terakhir'])) {
        return null;
    }
    $bagian = explode('|', $_COOKIE['numa_terakhir']);
    if (count($bagian) !== 2) {
        return null;
    }
    return ['halaman' => $bagian[0], 'waktu' => (int)$bagian[1]];
}

// ---------- KURSUS (admin) ----------
// ambil daftar kursus dari data/kursus.json; kalau belum ada, dibikin dari $KURSUS_AWAL di data.php
function muatKursus(): array
{
    global $KURSUS_AWAL;
    $daftar = bacaJson('kursus', []);
    if (!$daftar) {
        $daftar = $KURSUS_AWAL;
        tulisJson('kursus', $daftar);
    }
    return $daftar;
}

// cek isi form kursus. return [nilai_bersih, daftar_error]
function validasiKursus(array $post): array
{
    $nilai = [
        'nama'      => trim($post['nama_kursus'] ?? ''),
        'kategori'  => $post['kategori'] ?? '',
        'tingkat'   => $post['tingkat'] ?? '',
        'deskripsi' => trim($post['deskripsi'] ?? ''),
        'status'    => $post['status'] ?? 'draft',
    ];
    $errors = [];
    if (mb_strlen($nilai['nama']) < 5) {
        $errors[] = 'Nama kursus minimal 5 karakter.';
    }
    if (!in_array($nilai['kategori'], ['matematika', 'sains', 'bahasa', 'sosial'], true)) {
        $errors[] = 'Pilih kategori kursus.';
    }
    if (!in_array($nilai['tingkat'], ['4-6', '7-8', '9'], true)) {
        $errors[] = 'Pilih tingkat kelas.';
    }
    if (mb_strlen($nilai['deskripsi']) > 500) {
        $errors[] = 'Deskripsi maksimal 500 karakter.';
    }
    if (!in_array($nilai['status'], ['draft', 'aktif'], true)) {
        $nilai['status'] = 'draft';
    }
    return [$nilai, $errors];
}

// ubah nilai form jadi 1 item kursus siap simpan
function bikinKursus(array $n, string $id): array
{
    $label = ['4-6' => 'Kelas 4–6', '7-8' => 'Kelas 7–8', '9' => 'Kelas 9'][$n['tingkat']] ?? $n['tingkat'];
    return [
        'id' => $id, 'nama' => $n['nama'], 'sub' => $label . ' • ' . ucfirst($n['kategori']),
        'warna' => 'orange-bg', 'ikon' => 'fa-book', 'kategori' => ucfirst($n['kategori']),
        'tingkat' => $n['tingkat'], 'deskripsi' => $n['deskripsi'],
        'materi' => '0', 'siswa' => '0',
        'status' => $n['status'] === 'aktif' ? 'Aktif' : 'Draft', 'status_warna' => $n['status'] === 'aktif' ? 'green' : 'orange',
    ];
}

// upload thumbnail: cuma gambar, maksimal 2 MB. return nama file atau ''
function simpanThumbnail(?array $f): string
{
    if (!$f || ($f['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return '';
    }
    $ext = strtolower(pathinfo($f['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true) || $f['size'] > 2 * 1024 * 1024) {
        return '';
    }
    $folder = ROOT_DIR . '/uploads';
    if (!is_dir($folder)) {
        mkdir($folder, 0775, true);
    }
    $nama = 'thumb_' . time() . '.' . $ext;
    return move_uploaded_file($f['tmp_name'], $folder . '/' . $nama) ? $nama : '';
}

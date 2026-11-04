# Numa - Tugas Praktikum PHP (Session & Cookie)

## Cara menjalankan
**Pakai XAMPP:** copy folder `Numa_PHP` ke `C:\xampp\htdocs\`, nyalakan Apache, buka `http://localhost/Numa_PHP/`.
**Pakai PHP bawaan:** buka terminal di folder ini lalu `php -S localhost:8000`, buka `http://localhost:8000`.
Folder `data/` harus bisa ditulis (di XAMPP otomatis bisa).

## Akun contoh (dibuat otomatis di data/users.json saat pertama dibuka)
| Username | Password | Peran |
|---|---|---|
| jey_math | jey12345 | siswa |
| arka_juara | numa12345 | siswa |
| admin | admin12345 | admin |
Bisa juga daftar akun baru lewat `register.php`.

## Yang diterapkan
**Tugas 1 - PHP**
- `include`/`require`: navbar, footer, sidebar & topbar admin dipisah ke folder `includes/` (dulu ditulis ulang di tiap halaman dan isinya beda-beda).
- Array + `foreach`: menu, statistik bulanan, pencapaian, teman, toko hati, topik quiz, tabel pengguna/kursus/laporan (data di `includes/data.php`).
- Form `$_POST`: login, register (validasi server), beli hati & klaim misi, tambah/edit/hapus kursus (+ upload thumbnail).
- Fungsi buatan sendiri (`includes/functions.php`), file JSON sebagai pengganti database, `password_hash`/`password_verify`, `htmlspecialchars` lewat `e()`.

**Tugas 2 - Session & Cookie**
- **Session:** `login.php` menyimpan data user di `$_SESSION['user']`. Nama tampil di navbar semua halaman user, sapaan dashboard, dan topbar admin. Halaman user/admin dilindungi (`wajibLogin()` / `wajibAdmin()`).
- **Logout:** tombol **Keluar** (navbar, dashboard, sidebar admin) -> `logout.php` -> `session_destroy()` + hapus cookie session.
- **Cookie:** `numa_ingat` (checkbox "Ingat saya", username terisi otomatis di form login) dan `numa_terakhir` (halaman terakhir yang dibuka, tampil di dashboard).

## Program yang salah & sudah dibetulkan
1. `index.html`: path CSS/JS salah (`../css/style.css`, `../js/quiz.js`) sehingga landing page tampil polos; link `flashcard.html`/`misi.html` juga salah folder.
2. `user/dashboard.html`: script `../js/user.dashboard.js` tidak ada (yang benar `../js/user/dashboard.js`) sehingga fitur edit profil tidak jalan.
3. Navbar tiap halaman user berbeda-beda (ikon, avatar, tidak ada nama user); sidebar admin semua link menuju file yang tidak ada (`pengguna.html`, `kursus.html`, dst.). Sekarang satu include.
4. `path-learning.html` menuju `lab.html` dan `missions.html` yang tidak ada.
5. Form login/register memakai `method="GET"` dan langsung ke dashboard tanpa cek apa pun (password ikut tampil di URL). Sekarang `POST` + validasi.
6. Sisa tulisan `[cite: 11]` di halaman Misi dihapus.
7. `dashboard.js`: kunci localStorage sama untuk semua akun, jadi ganti akun masih menampilkan nama akun lama. Sekarang kuncinya per-username.

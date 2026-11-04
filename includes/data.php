<?php
/*
 * data.php
 * Data statis aplikasi, disimpan sebagai array PHP.
 * Isi halaman ditampilkan lewat perulangan foreach, jadi kalau mau nambah
 * data (misal 1 teman lagi) cukup tambah 1 baris array di sini,
 * gak perlu copy-paste blok HTML berkali-kali.
 */

// menu navbar user: kode => [file, label]
$MENU_USER = [
    'belajar' => [
        'file' => 'path-learning.php',
        'label' => 'Belajar',
    ],
    'quiz' => [
        'file' => 'quiz.php',
        'label' => 'Quiz Kilat',
    ],
    'lab' => [
        'file' => 'lab-kesalahan.php',
        'label' => 'Lab Kesalahan',
    ],
    'flashcard' => [
        'file' => 'flashcard.php',
        'label' => 'Flashcard',
    ],
    'misi' => [
        'file' => 'misi.php',
        'label' => 'Misi',
    ],
];

// menu sidebar admin, dikelompokin per bagian
$MENU_ADMIN = [
    'WORKSPACE' => [
        'ringkasan' => [
            'file' => 'admin-dashboard.php',
            'label' => 'Ringkasan',
            'ikon' => 'fa-solid fa-border-all',
        ],
        'pengguna' => [
            'file' => 'admin-pengguna.php',
            'label' => 'Pengguna',
            'ikon' => 'fa-solid fa-users',
        ],
        'kursus' => [
            'file' => 'admin-kursus.php',
            'label' => 'Kursus & Materi',
            'ikon' => 'fa-solid fa-book-open',
        ],
        'aktivitas' => [
            'file' => 'admin-aktivitas-belajar.php',
            'label' => 'Aktivitas Belajar',
            'ikon' => 'fa-solid fa-chart-line',
        ],
        'analitik' => [
            'file' => 'admin-analitik.php',
            'label' => 'Analitik',
            'ikon' => 'fa-solid fa-chart-pie',
        ],
    ],
    'OPERASIONAL' => [
        'notifikasi' => [
            'file' => 'admin-notifikasi.php',
            'label' => 'Notifikasi',
            'ikon' => 'fa-regular fa-bell',
        ],
        'laporan' => [
            'file' => 'admin-laporan.php',
            'label' => 'Laporan',
            'ikon' => 'fa-regular fa-file-lines',
        ],
        'pengaturan' => [
            'file' => 'admin-pengaturan.php',
            'label' => 'Pengaturan',
            'ikon' => 'fa-solid fa-gear',
        ],
    ],
];

// notifikasi admin (baru = belum dibaca)
$NOTIFIKASI_ADMIN = [
    [
        'judul' => '3 Laporan Konten Baru',
        'baru' => true,
    ],
    [
        'judul' => 'Siswa Tidak Aktif 14 Hari',
        'baru' => true,
    ],
    [
        'judul' => 'Verifikasi Wali Baru',
        'baru' => true,
    ],
    [
        'judul' => 'Kursus Menunggu Review',
        'baru' => true,
    ],
    [
        'judul' => 'Backup Selesai',
        'baru' => false,
    ],
];

// ===== DASHBOARD USER =====
$MENU_CEPAT = [
    [
        'warna' => 'orange-bg',
        'ikon' => 'ri-flashlight-line',
        'judul' => 'Quiz Kilat',
        'badge' => 'badge-xp-orange',
        'badge_teks' => '+15 XP',
        'ket' => '5 Soal sprint 60s',
        'link' => 'quiz.php',
    ],
    [
        'warna' => 'purple-bg',
        'ikon' => 'ri-file-list-2-line',
        'judul' => 'Flashcard',
        'badge' => 'badge-card-count',
        'badge_teks' => '24 Kartu',
        'ket' => 'Hafal teorema',
        'link' => 'flashcard.php',
    ],
    [
        'warna' => 'red-bg',
        'ikon' => 'ri-history-line',
        'judul' => 'Lab Salah',
        'badge' => 'badge-error-count',
        'badge_teks' => '3 Soal',
        'ket' => 'Perbaiki kuis lalu',
        'link' => 'lab-kesalahan.php',
    ],
];
$XP_BULANAN = [
    'Jan' => 0,
    'Feb' => 0,
    'Mar' => 0,
    'Apr' => 0,
    'Mei' => 0,
    'Jun' => 105,
    'Jul' => 0,
    'Agu' => 0,
    'Sep' => 0,
    'Okt' => 0,
    'Nov' => 0,
    'Des' => 0,
];
$PENCAPAIAN = [
    [
        'warna' => 'orange',
        'ikon' => 'ri-fire-fill',
        'judul' => 'Api Membara',
        'lencana' => 'Level 5 Selesai',
        'lencana_warna' => 'orange',
        'ket' => 'Pertahankan latihan matematika 7 hari berturut-turut tanpa jeda.',
        'persen' => 100,
        'bar' => 'orange',
        'extra' => 'background: #f97316;',
    ],
    [
        'warna' => 'purple',
        'ikon' => 'ri-calculator-line',
        'judul' => 'Pakar Aljabar & Operasi',
        'lencana' => 'Sempurna 100%',
        'lencana_warna' => 'purple',
        'ket' => 'Selesaikan 50 kuis matematika dengan akurasi 100% tanpa salah langkah.',
        'persen' => 100,
        'bar' => 'purple',
        'extra' => '',
    ],
];
$TEMAN = [
    [
        'nama' => 'Jono',
        'streak' => 7,
        'xp' => 120,
    ],
    [
        'nama' => 'Haechan Lee',
        'streak' => 10,
        'xp' => 256,
    ],
    [
        'nama' => 'manusia',
        'streak' => 1,
        'xp' => 50,
    ],
];

// ===== MISI =====
$SHOP_HATI = [
    [
        'jumlah' => 1,
        'harga' => 50,
    ],
    [
        'jumlah' => 3,
        'harga' => 120,
    ],
    [
        'jumlah' => 5,
        'harga' => 220,
    ],
];
$PENCAPAIAN_MISI = [
    [
        'locked' => false,
        'warna' => 'orange',
        'ikon' => '🔥',
        'judul' => 'Api Membara',
        'lencana' => 'Level 5 Selesai',
        'lencana_warna' => 'orange',
        'ket' => 'Pertahankan latihan matematika 7 hari berturut-turut tanpa jeda.',
        'bar' => 'orange',
        'persen' => 100,
        'teks' => '',
    ],
    [
        'locked' => false,
        'warna' => 'purple',
        'ikon' => '🧠',
        'judul' => 'Orang Bijak',
        'lencana' => 'Level 8',
        'lencana_warna' => 'purple',
        'ket' => 'Kumpulkan lebih dari 10.000 XP dari soal matematika adaptif.',
        'bar' => 'purple',
        'persen' => 85,
        'teks' => '',
    ],
    [
        'locked' => false,
        'warna' => 'green',
        'ikon' => '➗',
        'judul' => 'Pakar Aljabar & Operasi',
        'lencana' => '',
        'lencana_warna' => '',
        'ket' => 'Selesaikan 50 kuis matematika dengan akurasi 100% tanpa salah langkah.',
        'bar' => 'green',
        'persen' => 100,
        'teks' => '(50/50)',
    ],
    [
        'locked' => false,
        'warna' => 'gold',
        'ikon' => '🏆',
        'judul' => 'Juara Liga Pythagoras',
        'lencana' => '',
        'lencana_warna' => '',
        'ket' => 'Mencapai finis di peringkat 3 besar mingguan dalam klasemen liga.',
        'bar' => 'gold',
        'persen' => 75,
        'teks' => '',
    ],
    [
        'locked' => true,
        'warna' => 'gray',
        'ikon' => '🔒',
        'judul' => 'Penakluk Aljabar',
        'lencana' => '',
        'lencana_warna' => '',
        'ket' => 'Kuasai 15 bab konsep variabel dan persamaan dasar.',
        'bar' => 'gray',
        'persen' => 60,
        'teks' => '(9/15)',
    ],
];

// ===== QUIZ =====
$TOPIK_QUIZ = [
    [
        'aktif' => true,
        'judul' => 'Aljabar Linear Dasar',
        'ket' => 'Variabel, substitusi nilai, dan penyederhanaan suku sejenis.',
        'warna' => 'green',
        'persen' => '85% Dikuasai',
    ],
    [
        'aktif' => false,
        'judul' => 'Operasi Bilangan & Eksponen',
        'ket' => 'Sifat pangkat, bilangan bulat negatif, dan akar kuadrat.',
        'warna' => 'green',
        'persen' => '92% Dikuasai',
    ],
    [
        'aktif' => false,
        'judul' => 'Persamaan & Pertidaksamaan',
        'ket' => 'Himpunan penyelesaian linear satu variabel dan garis bilangan.',
        'warna' => 'orange',
        'persen' => '64% Dikuasai',
    ],
    [
        'aktif' => false,
        'judul' => 'Geometri & Pythagoras',
        'ket' => 'Segitiga siku-siku, tripel Pythagoras, dan bidang koordinat.',
        'warna' => 'gray',
        'persen' => '48% Dikuasai',
    ],
];
$RIWAYAT_QUIZ = [
    [
        'judul' => 'Aljabar Linear',
        'ket' => 'Kemarin • 9/10 Benar',
        'xp' => '+150 XP',
    ],
    [
        'judul' => 'Geometri Segitiga',
        'ket' => '2 Hari Lalu • 8/10 Benar',
        'xp' => '+120 XP',
    ],
];

// ===== ADMIN =====
// data contoh pengguna (siswa/guru). Akun yang daftar lewat register.php ditampilkan di atasnya
$PENGGUNA_DEMO = [
    [
        'inisial' => 'AF',
        'warna' => 'purple-bg',
        'nama' => 'Adit Firmansyah',
        'email' => 'adit.f@pelajar.id',
        'peran' => 'Siswa',
        'peran_warna' => 'purple',
        'status' => 'Tidak Aktif',
        'status_warna' => 'red',
        'terakhir' => '18 Sep 2026',
        'metrik' => '12%',
        'metrik_ket' => 'Progres kursus',
    ],
    [
        'inisial' => 'SN',
        'warna' => 'orange-bg',
        'nama' => 'Salsa Nabila',
        'email' => 'salsa.n@sekolah.id',
        'peran' => 'Siswa',
        'peran_warna' => 'purple',
        'status' => 'Aktif',
        'status_warna' => 'green',
        'terakhir' => 'Hari ini, 08:42',
        'metrik' => '43%',
        'metrik_ket' => 'Akurasi 7 hari',
    ],
    [
        'inisial' => 'FR',
        'warna' => 'blue-bg',
        'nama' => 'Fajar Ramadhan',
        'email' => 'fajar.r@gmail.com',
        'peran' => 'Guru',
        'peran_warna' => 'blue',
        'status' => 'Aktif',
        'status_warna' => 'green',
        'terakhir' => 'Kemarin, 21:08',
        'metrik' => '3',
        'metrik_ket' => 'Laporan terbuka',
    ],
    [
        'inisial' => 'ZM',
        'warna' => 'green-bg',
        'nama' => 'Zahra Mulyani',
        'email' => 'zahra.m@belajar.id',
        'peran' => 'Siswa',
        'peran_warna' => 'purple',
        'status' => 'Streak Terputus',
        'status_warna' => 'orange',
        'terakhir' => '30 Sep 2026',
        'metrik' => '21 hari',
        'metrik_ket' => 'Streak terbaik',
    ],
    [
        'inisial' => 'RH',
        'warna' => 'red-bg',
        'nama' => 'Rizky Hidayat',
        'email' => 'rizky.h@sekolah.id',
        'peran' => 'Siswa',
        'peran_warna' => 'purple',
        'status' => 'Baru',
        'status_warna' => 'blue',
        'terakhir' => 'Hari ini, 07:15',
        'metrik' => 'Baru',
        'metrik_ket' => 'Akun siswa',
    ],
];
// daftar kursus awal, dipakai kalau data/kursus.json belum ada
$KURSUS_AWAL = [
    [
        'id' => 'K1',
        'nama' => 'Aljabar Linear Dasar',
        'sub' => 'Kelas 7–8 • Matematika',
        'warna' => 'purple-bg',
        'ikon' => 'fa-solid fa-xmark',
        'kategori' => 'Matematika',
        'materi' => '24',
        'siswa' => '12.840',
        'status' => 'Aktif',
        'status_warna' => 'green',
    ],
    [
        'id' => 'K2',
        'nama' => 'Operasi Bilangan',
        'sub' => 'Kelas 4–6 • Matematika',
        'warna' => 'green-bg',
        'ikon' => 'fa-solid fa-leaf',
        'kategori' => 'Matematika',
        'materi' => '18',
        'siswa' => '10.462',
        'status' => 'Aktif',
        'status_warna' => 'green',
    ],
    [
        'id' => 'K3',
        'nama' => 'Geometri & Pythagoras',
        'sub' => 'Kelas 8–9 • Matematika',
        'warna' => 'orange-bg',
        'ikon' => 'fa-solid fa-shapes',
        'kategori' => 'Matematika',
        'materi' => '15',
        'siswa' => '8.920',
        'status' => 'Draft',
        'status_warna' => 'orange',
    ],
    [
        'id' => 'K4',
        'nama' => 'Statistika Dasar',
        'sub' => 'Kelas 9 • Matematika',
        'warna' => 'blue-bg',
        'ikon' => 'fa-solid fa-chart-column',
        'kategori' => 'Matematika',
        'materi' => '12',
        'siswa' => '7.315',
        'status' => 'Aktif',
        'status_warna' => 'green',
    ],
    [
        'id' => 'K5',
        'nama' => 'Pengantar IPA Terpadu',
        'sub' => 'Kelas 7 • Sains',
        'warna' => 'red-bg',
        'ikon' => 'fa-solid fa-flask',
        'kategori' => 'Sains',
        'materi' => '20',
        'siswa' => '5.120',
        'status' => 'Aktif',
        'status_warna' => 'green',
    ],
];
$LAPORAN_ADMIN = [
    [
        'nama' => 'Laporan Pengguna Okt 2026',
        'dibuat' => 'Dibuat 2 Okt 2026, 09:42',
        'warna' => 'purple-bg',
        'ikon' => 'fa-solid fa-users',
        'jenis' => 'Pengguna',
        'jenis_warna' => 'purple',
        'periode' => 'Okt 2026',
        'ukuran' => '2,4 MB',
        'status' => 'Siap',
        'status_warna' => 'green',
        'aksi' => 'Unduh',
    ],
    [
        'nama' => 'Performa Kursus Q3 2026',
        'dibuat' => 'Dibuat 1 Okt 2026, 14:20',
        'warna' => 'green-bg',
        'ikon' => 'fa-solid fa-book-open',
        'jenis' => 'Kursus',
        'jenis_warna' => 'green',
        'periode' => 'Jul–Sep 2026',
        'ukuran' => '3,8 MB',
        'status' => 'Siap',
        'status_warna' => 'green',
        'aksi' => 'Unduh',
    ],
    [
        'nama' => 'Aktivitas Belajar September',
        'dibuat' => 'Dibuat 30 Sep 2026, 22:15',
        'warna' => 'orange-bg',
        'ikon' => 'fa-solid fa-chart-line',
        'jenis' => 'Aktivitas',
        'jenis_warna' => 'orange',
        'periode' => 'Sep 2026',
        'ukuran' => '1,9 MB',
        'status' => 'Siap',
        'status_warna' => 'green',
        'aksi' => 'Unduh',
    ],
    [
        'nama' => 'Laporan Konten Bermasalah',
        'dibuat' => 'Dibuat 29 Sep 2026, 10:30',
        'warna' => 'blue-bg',
        'ikon' => 'fa-solid fa-triangle-exclamation',
        'jenis' => 'Konten',
        'jenis_warna' => 'blue',
        'periode' => 'Sep 2026',
        'ukuran' => '850 KB',
        'status' => 'Siap',
        'status_warna' => 'green',
        'aksi' => 'Unduh',
    ],
    [
        'nama' => 'Log Sistem Mingguan',
        'dibuat' => 'Dibuat 28 Sep 2026, 06:00',
        'warna' => 'red-bg',
        'ikon' => 'fa-solid fa-gear',
        'jenis' => 'Sistem',
        'jenis_warna' => 'red',
        'periode' => '22–28 Sep 2026',
        'ukuran' => '1,2 MB',
        'status' => 'Diproses',
        'status_warna' => 'orange',
        'aksi' => 'Menunggu',
    ],
];

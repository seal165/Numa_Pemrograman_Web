<?php
/*
 * logout.php
 * Tombol "Keluar" di semua halaman ngarah ke sini.
 * Isinya: hapus session (data login + statistik), hapus cookie session, lalu balik ke halaman login.
 * Catatan: cookie "numa_ingat" sengaja TIDAK dihapus, supaya username tetap keisi di form login
 * kalau tadi user mencentang "Ingat saya".
 */
require_once __DIR__ . '/includes/config.php';

keluarkanUser();                 // $_SESSION dikosongin + cookie session dihapus + session_destroy()

// pesannya dikirim lewat query string karena session-nya udah dihancurkan
redirect('login.php?keluar=1');

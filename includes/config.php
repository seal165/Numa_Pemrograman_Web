<?php
/*
 * config.php
 * File ini di-require paling atas di SEMUA halaman.
 * Tugasnya: mulai session, set zona waktu, lalu load fungsi & data.
 */

// session_start() harus dipanggil sebelum ada output HTML sama sekali,
// makanya semua halaman manggil file ini di baris paling atas
if (session_status() === PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0,          // 0 = hilang pas browser ditutup
        'path'     => '/',
        'httponly' => true,       // cookie session gak bisa dibaca javascript
        'samesite' => 'Lax',
    ]);
    session_start();
}

date_default_timezone_set('Asia/Jakarta');

define('ROOT_DIR', dirname(__DIR__));
define('DATA_DIR', ROOT_DIR . '/data');

require_once __DIR__ . '/functions.php';
require_once __DIR__ . '/data.php';

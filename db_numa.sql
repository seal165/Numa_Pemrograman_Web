-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Nov 11, 2026 at 10:21 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_numa`
--

-- --------------------------------------------------------

--
-- Table structure for table `aktivitas_belajar`
--

CREATE TABLE `aktivitas_belajar` (
  `id_aktivitas` int NOT NULL,
  `id_user` int NOT NULL,
  `id_kursus` int NOT NULL,
  `jenis` enum('Belajar','Kuis') NOT NULL,
  `durasi_menit` int NOT NULL DEFAULT '0',
  `waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flashcard`
--

CREATE TABLE `flashcard` (
  `id_kartu` int NOT NULL,
  `id_kursus` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `jawaban` text NOT NULL,
  `petunjuk` text,
  `rumus` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jawaban_sesi`
--

CREATE TABLE `jawaban_sesi` (
  `id_jawaban` int NOT NULL,
  `id_sesi` int NOT NULL,
  `id_soal` int NOT NULL,
  `id_opsi` int NOT NULL,
  `is_benar` tinyint(1) NOT NULL,
  `waktu_jawab_detik` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kesalahan`
--

CREATE TABLE `kesalahan` (
  `id_kesalahan` int NOT NULL,
  `id_user` int NOT NULL,
  `id_soal` int NOT NULL,
  `jawaban_salah` text,
  `jenis_kesalahan` varchar(100) DEFAULT NULL,
  `catatan` text,
  `status_remedial` varchar(50) NOT NULL DEFAULT 'Belum',
  `xp_potensial` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kuis`
--

CREATE TABLE `kuis` (
  `id_kuis` int NOT NULL,
  `id_kursus` int NOT NULL,
  `id_materi` int DEFAULT NULL,
  `judul` varchar(150) NOT NULL,
  `durasi_menit` int NOT NULL DEFAULT '0',
  `nilai_lulus` int NOT NULL DEFAULT '60',
  `status` varchar(50) NOT NULL DEFAULT 'Aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kursus`
--

CREATE TABLE `kursus` (
  `id_kursus` int NOT NULL,
  `nama` varchar(150) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `tingkat` varchar(50) NOT NULL,
  `deskripsi` text,
  `thumbnail` varchar(255) DEFAULT NULL,
  `status` enum('Draft','Publish') NOT NULL DEFAULT 'Draft',
  `ikon` varchar(100) DEFAULT NULL,
  `warna` varchar(7) DEFAULT NULL,
  `dibuat_oleh` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan`
--

CREATE TABLE `laporan` (
  `id_laporan` int NOT NULL,
  `id_admin` int DEFAULT NULL,
  `nama` varchar(150) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `periode_mulai` date NOT NULL,
  `periode_akhir` date NOT NULL,
  `format` enum('PDF','CSV','XLSX') NOT NULL DEFAULT 'PDF',
  `ukuran` varchar(50) DEFAULT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Selesai',
  `dibuat_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `laporan_konten`
--

CREATE TABLE `laporan_konten` (
  `id_laporan_konten` int NOT NULL,
  `id_pelapor` int NOT NULL,
  `id_soal` int NOT NULL,
  `alasan` text NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'Open',
  `waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `liga_peringkat`
--

CREATE TABLE `liga_peringkat` (
  `id_peringkat` int NOT NULL,
  `id_user` int NOT NULL,
  `nama_liga` varchar(100) NOT NULL,
  `minggu` date NOT NULL,
  `xp_mingguan` int NOT NULL DEFAULT '0',
  `peringkat` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `materi`
--

CREATE TABLE `materi` (
  `id_materi` int NOT NULL,
  `id_kursus` int NOT NULL,
  `judul` varchar(150) NOT NULL,
  `urutan` int NOT NULL,
  `tipe` enum('Teks','Video','Dokumen') NOT NULL DEFAULT 'Teks',
  `xp_reward` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `misi`
--

CREATE TABLE `misi` (
  `id_misi` int NOT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text NOT NULL,
  `jenis` enum('Harian','Mingguan','Spesial') NOT NULL DEFAULT 'Harian',
  `target` int NOT NULL,
  `reward_xp` int NOT NULL DEFAULT '0',
  `reward_koin` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `misi_user`
--

CREATE TABLE `misi_user` (
  `id_misi_user` int NOT NULL,
  `id_user` int NOT NULL,
  `id_misi` int NOT NULL,
  `progres` int NOT NULL DEFAULT '0',
  `status` varchar(50) NOT NULL DEFAULT 'Berjalan',
  `diklaim_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `notifikasi`
--

CREATE TABLE `notifikasi` (
  `id_notifikasi` int NOT NULL,
  `id_user` int NOT NULL,
  `judul` varchar(150) NOT NULL,
  `jenis` varchar(100) NOT NULL,
  `sudah_dibaca` tinyint(1) NOT NULL DEFAULT '0',
  `waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `opsi_jawaban`
--

CREATE TABLE `opsi_jawaban` (
  `id_opsi` int NOT NULL,
  `id_soal` int NOT NULL,
  `label` char(1) NOT NULL,
  `teks` text NOT NULL,
  `is_benar` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `paket_hati`
--

CREATE TABLE `paket_hati` (
  `id_paket` int NOT NULL,
  `jumlah` int NOT NULL,
  `harga_koin` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pencapaian`
--

CREATE TABLE `pencapaian` (
  `id_pencapaian` int NOT NULL,
  `judul` varchar(150) NOT NULL,
  `ikon` varchar(100) DEFAULT NULL,
  `deskripsi` text NOT NULL,
  `target` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pencapaian_user`
--

CREATE TABLE `pencapaian_user` (
  `id_pencapaian_user` int NOT NULL,
  `id_user` int NOT NULL,
  `id_pencapaian` int NOT NULL,
  `persen` int NOT NULL DEFAULT '0',
  `tanggal_raih` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pengaturan_notifikasi`
--

CREATE TABLE `pengaturan_notifikasi` (
  `id_user` int NOT NULL,
  `kanal_email` tinyint(1) NOT NULL DEFAULT '1',
  `kanal_push` tinyint(1) NOT NULL DEFAULT '1',
  `kanal_wa` tinyint(1) NOT NULL DEFAULT '0',
  `kanal_sms` tinyint(1) NOT NULL DEFAULT '0',
  `frekuensi` varchar(50) NOT NULL DEFAULT 'Instan',
  `jam_tenang_mulai` time DEFAULT NULL,
  `jam_tenang_akhir` time DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pertemanan`
--

CREATE TABLE `pertemanan` (
  `id_user` int NOT NULL,
  `id_teman` int NOT NULL,
  `dibuat_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progres_flashcard`
--

CREATE TABLE `progres_flashcard` (
  `id_progres` int NOT NULL,
  `id_user` int NOT NULL,
  `id_kartu` int NOT NULL,
  `tingkat_paham` enum('Paham','Ragu','Lupa') NOT NULL,
  `terakhir_review` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `progres_materi`
--

CREATE TABLE `progres_materi` (
  `id_progres` int NOT NULL,
  `id_user` int NOT NULL,
  `id_materi` int NOT NULL,
  `bintang` int DEFAULT '0',
  `status` enum('Selesai','Belum') NOT NULL DEFAULT 'Belum',
  `xp_didapat` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sesi_kuis`
--

CREATE TABLE `sesi_kuis` (
  `id_sesi` int NOT NULL,
  `id_user` int NOT NULL,
  `id_kuis` int NOT NULL,
  `mode` enum('Normal','Remedial') NOT NULL DEFAULT 'Normal',
  `skor` decimal(5,2) NOT NULL DEFAULT '0.00',
  `jumlah_benar` int NOT NULL DEFAULT '0',
  `xp_didapat` int NOT NULL DEFAULT '0',
  `waktu_mulai` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `soal`
--

CREATE TABLE `soal` (
  `id_soal` int NOT NULL,
  `id_kuis` int NOT NULL,
  `pertanyaan` text NOT NULL,
  `pembahasan` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `statistik_user`
--

CREATE TABLE `statistik_user` (
  `id_user` int NOT NULL,
  `hati` int NOT NULL DEFAULT '5',
  `streak` int NOT NULL DEFAULT '0',
  `xp` int NOT NULL DEFAULT '0',
  `koin` int NOT NULL DEFAULT '0',
  `akurasi` decimal(5,2) NOT NULL DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_hati`
--

CREATE TABLE `transaksi_hati` (
  `id_transaksi` int NOT NULL,
  `id_user` int NOT NULL,
  `id_paket` int NOT NULL,
  `harga` int NOT NULL,
  `waktu` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id_user` int NOT NULL,
  `username` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `nama` varchar(150) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('Siswa','Admin') NOT NULL DEFAULT 'Siswa',
  `status` varchar(50) NOT NULL DEFAULT 'Aktif',
  `no_telepon` varchar(20) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `bio` text,
  `foto` varchar(255) DEFAULT NULL,
  `dibuat_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `xp_log`
--

CREATE TABLE `xp_log` (
  `id_log` int NOT NULL,
  `id_user` int NOT NULL,
  `sumber` varchar(100) NOT NULL,
  `xp` int NOT NULL,
  `tanggal` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aktivitas_belajar`
--
ALTER TABLE `aktivitas_belajar`
  ADD PRIMARY KEY (`id_aktivitas`),
  ADD KEY `fk_abelajar_user` (`id_user`),
  ADD KEY `fk_abelajar_kursus` (`id_kursus`);

--
-- Indexes for table `flashcard`
--
ALTER TABLE `flashcard`
  ADD PRIMARY KEY (`id_kartu`),
  ADD KEY `fk_flashcard_kursus` (`id_kursus`);

--
-- Indexes for table `jawaban_sesi`
--
ALTER TABLE `jawaban_sesi`
  ADD PRIMARY KEY (`id_jawaban`),
  ADD KEY `fk_jsesi_sesi` (`id_sesi`),
  ADD KEY `fk_jsesi_soal` (`id_soal`),
  ADD KEY `fk_jsesi_opsi` (`id_opsi`);

--
-- Indexes for table `kesalahan`
--
ALTER TABLE `kesalahan`
  ADD PRIMARY KEY (`id_kesalahan`),
  ADD KEY `fk_kesalahan_user` (`id_user`),
  ADD KEY `fk_kesalahan_soal` (`id_soal`);

--
-- Indexes for table `kuis`
--
ALTER TABLE `kuis`
  ADD PRIMARY KEY (`id_kuis`),
  ADD KEY `fk_kuis_kursus` (`id_kursus`),
  ADD KEY `fk_kuis_materi` (`id_materi`);

--
-- Indexes for table `kursus`
--
ALTER TABLE `kursus`
  ADD PRIMARY KEY (`id_kursus`),
  ADD KEY `fk_kursus_admin` (`dibuat_oleh`);

--
-- Indexes for table `laporan`
--
ALTER TABLE `laporan`
  ADD PRIMARY KEY (`id_laporan`),
  ADD KEY `fk_laporan_admin` (`id_admin`);

--
-- Indexes for table `laporan_konten`
--
ALTER TABLE `laporan_konten`
  ADD PRIMARY KEY (`id_laporan_konten`),
  ADD KEY `fk_lkonten_user` (`id_pelapor`),
  ADD KEY `fk_lkonten_soal` (`id_soal`);

--
-- Indexes for table `liga_peringkat`
--
ALTER TABLE `liga_peringkat`
  ADD PRIMARY KEY (`id_peringkat`),
  ADD KEY `fk_liga_user` (`id_user`);

--
-- Indexes for table `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`),
  ADD KEY `fk_materi_kursus` (`id_kursus`);

--
-- Indexes for table `misi`
--
ALTER TABLE `misi`
  ADD PRIMARY KEY (`id_misi`);

--
-- Indexes for table `misi_user`
--
ALTER TABLE `misi_user`
  ADD PRIMARY KEY (`id_misi_user`),
  ADD KEY `fk_muser_user` (`id_user`),
  ADD KEY `fk_muser_misi` (`id_misi`);

--
-- Indexes for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD PRIMARY KEY (`id_notifikasi`),
  ADD KEY `fk_notif_user` (`id_user`);

--
-- Indexes for table `opsi_jawaban`
--
ALTER TABLE `opsi_jawaban`
  ADD PRIMARY KEY (`id_opsi`),
  ADD KEY `fk_opsi_soal` (`id_soal`);

--
-- Indexes for table `paket_hati`
--
ALTER TABLE `paket_hati`
  ADD PRIMARY KEY (`id_paket`);

--
-- Indexes for table `pencapaian`
--
ALTER TABLE `pencapaian`
  ADD PRIMARY KEY (`id_pencapaian`);

--
-- Indexes for table `pencapaian_user`
--
ALTER TABLE `pencapaian_user`
  ADD PRIMARY KEY (`id_pencapaian_user`),
  ADD KEY `fk_puser_user` (`id_user`),
  ADD KEY `fk_puser_badge` (`id_pencapaian`);

--
-- Indexes for table `pengaturan_notifikasi`
--
ALTER TABLE `pengaturan_notifikasi`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `pertemanan`
--
ALTER TABLE `pertemanan`
  ADD PRIMARY KEY (`id_user`,`id_teman`),
  ADD KEY `fk_pertemanan_teman` (`id_teman`);

--
-- Indexes for table `progres_flashcard`
--
ALTER TABLE `progres_flashcard`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `fk_pcard_user` (`id_user`),
  ADD KEY `fk_pcard_card` (`id_kartu`);

--
-- Indexes for table `progres_materi`
--
ALTER TABLE `progres_materi`
  ADD PRIMARY KEY (`id_progres`),
  ADD KEY `fk_pmateri_user` (`id_user`),
  ADD KEY `fk_pmateri_materi` (`id_materi`);

--
-- Indexes for table `sesi_kuis`
--
ALTER TABLE `sesi_kuis`
  ADD PRIMARY KEY (`id_sesi`),
  ADD KEY `fk_sesi_user` (`id_user`),
  ADD KEY `fk_sesi_kuis` (`id_kuis`);

--
-- Indexes for table `soal`
--
ALTER TABLE `soal`
  ADD PRIMARY KEY (`id_soal`),
  ADD KEY `fk_soal_kuis` (`id_kuis`);

--
-- Indexes for table `statistik_user`
--
ALTER TABLE `statistik_user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indexes for table `transaksi_hati`
--
ALTER TABLE `transaksi_hati`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `fk_thati_user` (`id_user`),
  ADD KEY `fk_thati_paket` (`id_paket`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `xp_log`
--
ALTER TABLE `xp_log`
  ADD PRIMARY KEY (`id_log`),
  ADD KEY `fk_xplog_user` (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aktivitas_belajar`
--
ALTER TABLE `aktivitas_belajar`
  MODIFY `id_aktivitas` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flashcard`
--
ALTER TABLE `flashcard`
  MODIFY `id_kartu` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jawaban_sesi`
--
ALTER TABLE `jawaban_sesi`
  MODIFY `id_jawaban` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kesalahan`
--
ALTER TABLE `kesalahan`
  MODIFY `id_kesalahan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kuis`
--
ALTER TABLE `kuis`
  MODIFY `id_kuis` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kursus`
--
ALTER TABLE `kursus`
  MODIFY `id_kursus` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan`
--
ALTER TABLE `laporan`
  MODIFY `id_laporan` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `laporan_konten`
--
ALTER TABLE `laporan_konten`
  MODIFY `id_laporan_konten` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `liga_peringkat`
--
ALTER TABLE `liga_peringkat`
  MODIFY `id_peringkat` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `misi`
--
ALTER TABLE `misi`
  MODIFY `id_misi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `misi_user`
--
ALTER TABLE `misi_user`
  MODIFY `id_misi_user` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `notifikasi`
--
ALTER TABLE `notifikasi`
  MODIFY `id_notifikasi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `opsi_jawaban`
--
ALTER TABLE `opsi_jawaban`
  MODIFY `id_opsi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `paket_hati`
--
ALTER TABLE `paket_hati`
  MODIFY `id_paket` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pencapaian`
--
ALTER TABLE `pencapaian`
  MODIFY `id_pencapaian` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pencapaian_user`
--
ALTER TABLE `pencapaian_user`
  MODIFY `id_pencapaian_user` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `progres_flashcard`
--
ALTER TABLE `progres_flashcard`
  MODIFY `id_progres` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `progres_materi`
--
ALTER TABLE `progres_materi`
  MODIFY `id_progres` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sesi_kuis`
--
ALTER TABLE `sesi_kuis`
  MODIFY `id_sesi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `soal`
--
ALTER TABLE `soal`
  MODIFY `id_soal` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_hati`
--
ALTER TABLE `transaksi_hati`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id_user` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `xp_log`
--
ALTER TABLE `xp_log`
  MODIFY `id_log` int NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `aktivitas_belajar`
--
ALTER TABLE `aktivitas_belajar`
  ADD CONSTRAINT `fk_abelajar_kursus` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_abelajar_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `flashcard`
--
ALTER TABLE `flashcard`
  ADD CONSTRAINT `fk_flashcard_kursus` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `jawaban_sesi`
--
ALTER TABLE `jawaban_sesi`
  ADD CONSTRAINT `fk_jsesi_opsi` FOREIGN KEY (`id_opsi`) REFERENCES `opsi_jawaban` (`id_opsi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jsesi_sesi` FOREIGN KEY (`id_sesi`) REFERENCES `sesi_kuis` (`id_sesi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_jsesi_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kesalahan`
--
ALTER TABLE `kesalahan`
  ADD CONSTRAINT `fk_kesalahan_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kesalahan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `kuis`
--
ALTER TABLE `kuis`
  ADD CONSTRAINT `fk_kuis_kursus` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_kuis_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `kursus`
--
ALTER TABLE `kursus`
  ADD CONSTRAINT `fk_kursus_admin` FOREIGN KEY (`dibuat_oleh`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `laporan`
--
ALTER TABLE `laporan`
  ADD CONSTRAINT `fk_laporan_admin` FOREIGN KEY (`id_admin`) REFERENCES `users` (`id_user`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `laporan_konten`
--
ALTER TABLE `laporan_konten`
  ADD CONSTRAINT `fk_lkonten_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_lkonten_user` FOREIGN KEY (`id_pelapor`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `liga_peringkat`
--
ALTER TABLE `liga_peringkat`
  ADD CONSTRAINT `fk_liga_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `materi`
--
ALTER TABLE `materi`
  ADD CONSTRAINT `fk_materi_kursus` FOREIGN KEY (`id_kursus`) REFERENCES `kursus` (`id_kursus`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `misi_user`
--
ALTER TABLE `misi_user`
  ADD CONSTRAINT `fk_muser_misi` FOREIGN KEY (`id_misi`) REFERENCES `misi` (`id_misi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_muser_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `notifikasi`
--
ALTER TABLE `notifikasi`
  ADD CONSTRAINT `fk_notif_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `opsi_jawaban`
--
ALTER TABLE `opsi_jawaban`
  ADD CONSTRAINT `fk_opsi_soal` FOREIGN KEY (`id_soal`) REFERENCES `soal` (`id_soal`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pencapaian_user`
--
ALTER TABLE `pencapaian_user`
  ADD CONSTRAINT `fk_puser_badge` FOREIGN KEY (`id_pencapaian`) REFERENCES `pencapaian` (`id_pencapaian`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_puser_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pengaturan_notifikasi`
--
ALTER TABLE `pengaturan_notifikasi`
  ADD CONSTRAINT `fk_pnotif_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `pertemanan`
--
ALTER TABLE `pertemanan`
  ADD CONSTRAINT `fk_pertemanan_teman` FOREIGN KEY (`id_teman`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pertemanan_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `progres_flashcard`
--
ALTER TABLE `progres_flashcard`
  ADD CONSTRAINT `fk_pcard_card` FOREIGN KEY (`id_kartu`) REFERENCES `flashcard` (`id_kartu`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pcard_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `progres_materi`
--
ALTER TABLE `progres_materi`
  ADD CONSTRAINT `fk_pmateri_materi` FOREIGN KEY (`id_materi`) REFERENCES `materi` (`id_materi`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_pmateri_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `sesi_kuis`
--
ALTER TABLE `sesi_kuis`
  ADD CONSTRAINT `fk_sesi_kuis` FOREIGN KEY (`id_kuis`) REFERENCES `kuis` (`id_kuis`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sesi_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `soal`
--
ALTER TABLE `soal`
  ADD CONSTRAINT `fk_soal_kuis` FOREIGN KEY (`id_kuis`) REFERENCES `kuis` (`id_kuis`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `statistik_user`
--
ALTER TABLE `statistik_user`
  ADD CONSTRAINT `fk_statistik_users` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `transaksi_hati`
--
ALTER TABLE `transaksi_hati`
  ADD CONSTRAINT `fk_thati_paket` FOREIGN KEY (`id_paket`) REFERENCES `paket_hati` (`id_paket`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_thati_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `xp_log`
--
ALTER TABLE `xp_log`
  ADD CONSTRAINT `fk_xplog_user` FOREIGN KEY (`id_user`) REFERENCES `users` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

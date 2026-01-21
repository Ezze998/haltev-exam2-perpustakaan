-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 21, 2026 at 05:22 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `perpustakaan`
--

-- --------------------------------------------------------

--
-- Table structure for table `anggota`
--

CREATE TABLE `anggota` (
  `id_anggota` int(11) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `telepon` varchar(20) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `status` enum('aktif','tidak') DEFAULT 'aktif',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `anggota`
--

INSERT INTO `anggota` (`id_anggota`, `nama_lengkap`, `telepon`, `alamat`, `status`, `created_at`) VALUES
(1, 'Syarif Hidayatullah', '085231312819', 'Jl. Irigasi Taman IV Blok B2 No.5, Bekasi Timur', 'aktif', '2026-01-20 05:00:17'),
(2, 'Harry', '081321212219', 'Jl. Irigasi Tertia III Blok D5 No.1, Bekasi Timur, Bekasi Jaya', 'aktif', '2026-01-20 05:11:29'),
(3, 'Maguire', '081231129212', 'Jl. Manchester United', '', '2026-01-20 05:12:01'),
(4, 'Lionel Messi', '081231299932', 'Jl. Inter Miami', 'aktif', '2026-01-20 05:12:42'),
(5, 'Andika', '081399232328', 'Jl. Mekarsari Raya Blok B2 No.12', 'aktif', '2026-01-20 05:34:37'),
(6, 'Zilong', '081321123124', 'Jl. Land Of Dawn', 'aktif', '2026-01-20 10:35:38');

-- --------------------------------------------------------

--
-- Table structure for table `buku`
--

CREATE TABLE `buku` (
  `id_buku` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `isbn` varchar(20) DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `total_copies` int(11) DEFAULT 0,
  `available_copies` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `buku`
--

INSERT INTO `buku` (`id_buku`, `judul`, `isbn`, `penulis`, `total_copies`, `available_copies`, `created_at`) VALUES
(1, '5 CM', '12121030120', 'Donny Dhirgantoro', 20, 18, '2026-01-18 23:13:32'),
(2, 'Laskar Pelangi', '0231123192', 'Andrea Hirata', 10, 9, '2026-01-20 02:39:08'),
(3, 'Bumi Manusia', '1201310123', 'Pramoedya Ananta Toer', 5, 4, '2026-01-20 03:00:21'),
(4, 'Harry Potter', '1201321321', 'J.K. Rowling', 10, 10, '2026-01-20 03:01:11'),
(5, 'The Alchemist', '1012910932', 'Paulo Coelho', 15, 14, '2026-01-20 03:03:32'),
(8, 'Laut Bercerita', '1210231201', 'Leila S. Chudori', 8, 8, '2026-01-20 07:47:43'),
(10, 'Don Quixote', '1221213219', 'Miguel de Cervantes', 3, 2, '2026-01-20 21:20:29');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id_peminjaman` int(11) NOT NULL,
  `id_buku` int(11) NOT NULL,
  `id_anggota` int(11) NOT NULL,
  `id_staff` int(11) NOT NULL,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_tenggat` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `status_kembali` enum('dipinjam','dikembalikan','hilang') DEFAULT 'dipinjam'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id_peminjaman`, `id_buku`, `id_anggota`, `id_staff`, `tanggal_pinjam`, `tanggal_tenggat`, `tanggal_kembali`, `status_kembali`) VALUES
(1, 3, 2, 1, '2026-01-20', '2026-01-27', '2026-01-20', 'dikembalikan'),
(2, 3, 4, 1, '2026-01-20', '2026-01-27', NULL, 'dipinjam'),
(3, 2, 1, 1, '2026-01-20', '2026-01-27', NULL, 'dipinjam'),
(4, 1, 5, 1, '2026-01-20', '2026-01-27', NULL, 'dipinjam'),
(5, 1, 2, 1, '2026-01-20', '2026-01-27', '2026-01-20', 'dikembalikan'),
(6, 5, 6, 1, '2026-01-20', '2026-01-27', NULL, 'dipinjam'),
(7, 1, 1, 2, '2026-01-20', '2026-01-27', NULL, 'dipinjam'),
(8, 10, 5, 1, '2026-01-21', '2026-01-28', NULL, 'dipinjam'),
(9, 3, 1, 1, '2026-01-21', '2026-01-28', '2026-01-21', 'dikembalikan');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `role` enum('admin','staff') NOT NULL DEFAULT 'staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `username`, `password`, `nama_lengkap`, `created_at`, `role`) VALUES
(1, 'admin', '$2y$10$6Nlc0x/nMrSwyMqUJ6Y8zua3XwLTSQ0q2Efr4uY0w.xYETGxvls26', 'Administrator', '2026-01-15 06:46:55', 'admin'),
(2, 'syarif', '$2y$10$6Q.cMPEcqmc.ViLwGx194eKyQT3JuSB4xjdngqBENAWshp6JLBxSi', 'Syarif Hidayatullah', '2026-01-20 13:01:28', 'staff'),
(3, 'anton', '$2y$10$CdQk3f4ZCtC5yLyTkAwWkuXQBVBEviMGkentbnauHRm8wJGtF7hHG', 'Anthony', '2026-01-20 13:58:28', 'staff'),
(4, 'ronald', '$2y$10$.kvTPmVnMx.57AC3393CpuPJG9mU.Bqgsd4sZ9pf0lsh3KyO.jaki', 'Ronald', '2026-01-21 03:46:48', 'staff');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `anggota`
--
ALTER TABLE `anggota`
  ADD PRIMARY KEY (`id_anggota`);

--
-- Indexes for table `buku`
--
ALTER TABLE `buku`
  ADD PRIMARY KEY (`id_buku`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `fk_peminjaman_buku` (`id_buku`),
  ADD KEY `fk_peminjaman_anggota` (`id_anggota`),
  ADD KEY `fk_peminjaman_staff` (`id_staff`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `anggota`
--
ALTER TABLE `anggota`
  MODIFY `id_anggota` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `buku`
--
ALTER TABLE `buku`
  MODIFY `id_buku` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id_peminjaman` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD CONSTRAINT `fk_peminjaman_anggota` FOREIGN KEY (`id_anggota`) REFERENCES `anggota` (`id_anggota`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_buku` FOREIGN KEY (`id_buku`) REFERENCES `buku` (`id_buku`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_peminjaman_staff` FOREIGN KEY (`id_staff`) REFERENCES `user` (`id_user`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

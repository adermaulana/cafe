-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 21, 2025 at 02:27 PM
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
-- Database: `sintya221042`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_221042`
--

CREATE TABLE `admin_221042` (
  `nik_221042` int(11) NOT NULL,
  `nama_221042` varchar(255) NOT NULL,
  `username_221042` varchar(255) NOT NULL,
  `password_221042` varchar(255) NOT NULL,
  `role_221042` enum('admin','pelayan','kasir') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_221042`
--

INSERT INTO `admin_221042` (`nik_221042`, `nama_221042`, `username_221042`, `password_221042`, `role_221042`) VALUES
(12345, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(123456, 'kasir', 'kasir', 'c7911af3adbd12a035b289556d96470a', 'kasir'),
(1234567, 'pelayan', 'pelayan', '511cc40443f2a1ab03ab373b77d28091', 'pelayan');

-- --------------------------------------------------------

--
-- Table structure for table `detail_pesanan_221042`
--

CREATE TABLE `detail_pesanan_221042` (
  `kode_detailpesanan_221042` int(12) NOT NULL,
  `kode_pesanan_221042` int(12) DEFAULT NULL,
  `kode_menu_221042` int(12) DEFAULT NULL,
  `jumlah_221042` int(10) DEFAULT NULL,
  `subtotal_221042` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meja_221042`
--

CREATE TABLE `meja_221042` (
  `kode_meja_221042` int(12) NOT NULL,
  `nomor_meja_221042` int(12) DEFAULT NULL,
  `kapasitas_221042` int(12) DEFAULT NULL,
  `status_221042` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_221042`
--

CREATE TABLE `menu_221042` (
  `kode_menu_221042` int(12) NOT NULL,
  `nama_menu_221042` varchar(255) DEFAULT NULL,
  `deskripsi_221042` text DEFAULT NULL,
  `harga_221042` decimal(10,2) DEFAULT NULL,
  `gambar_221042` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan_221042`
--

CREATE TABLE `pelanggan_221042` (
  `nik_221042` int(12) NOT NULL,
  `nama_221042` varchar(50) DEFAULT NULL,
  `telepon_221042` varchar(15) DEFAULT NULL,
  `email_221042` varchar(50) DEFAULT NULL,
  `username_221042` varchar(255) DEFAULT NULL,
  `password_221042` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_221042`
--

CREATE TABLE `pembayaran_221042` (
  `kode_pembayaran_221042` int(12) NOT NULL,
  `kode_pesanan_221042` int(12) DEFAULT NULL,
  `metode_pembayaran_221042` varchar(50) DEFAULT NULL,
  `jumlah_221042` decimal(10,2) DEFAULT NULL,
  `status_221042` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_221042`
--

CREATE TABLE `pesanan_221042` (
  `kode_pesanan_221042` int(12) NOT NULL,
  `nik_221042` int(12) DEFAULT NULL,
  `kode_reservasi_221042` int(12) DEFAULT NULL,
  `tanggal_pesanan_221042` datetime DEFAULT NULL,
  `catatan_221042` varchar(255) DEFAULT NULL,
  `total_221042` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_221042`
--

CREATE TABLE `reservasi_221042` (
  `kode_reservasi_221042` int(12) NOT NULL,
  `nik_221042` int(12) DEFAULT NULL,
  `kode_meja_221042` int(12) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_221042`
--
ALTER TABLE `admin_221042`
  ADD PRIMARY KEY (`nik_221042`);

--
-- Indexes for table `detail_pesanan_221042`
--
ALTER TABLE `detail_pesanan_221042`
  ADD PRIMARY KEY (`kode_detailpesanan_221042`),
  ADD KEY `id_pesanan_221042` (`kode_pesanan_221042`),
  ADD KEY `id_menu_221042` (`kode_menu_221042`),
  ADD KEY `kode_pesanan_221042` (`kode_pesanan_221042`),
  ADD KEY `kode_menu_221042` (`kode_menu_221042`);

--
-- Indexes for table `meja_221042`
--
ALTER TABLE `meja_221042`
  ADD PRIMARY KEY (`kode_meja_221042`);

--
-- Indexes for table `menu_221042`
--
ALTER TABLE `menu_221042`
  ADD PRIMARY KEY (`kode_menu_221042`);

--
-- Indexes for table `pelanggan_221042`
--
ALTER TABLE `pelanggan_221042`
  ADD PRIMARY KEY (`nik_221042`);

--
-- Indexes for table `pembayaran_221042`
--
ALTER TABLE `pembayaran_221042`
  ADD PRIMARY KEY (`kode_pembayaran_221042`),
  ADD KEY `id_pesanan_221042` (`kode_pesanan_221042`);

--
-- Indexes for table `pesanan_221042`
--
ALTER TABLE `pesanan_221042`
  ADD PRIMARY KEY (`kode_pesanan_221042`),
  ADD KEY `id_pelanggan_221042` (`nik_221042`),
  ADD KEY `id_reservasi_221042` (`kode_reservasi_221042`);

--
-- Indexes for table `reservasi_221042`
--
ALTER TABLE `reservasi_221042`
  ADD PRIMARY KEY (`kode_reservasi_221042`),
  ADD KEY `id_pelanggan_221042` (`nik_221042`),
  ADD KEY `id_meja_221042` (`kode_meja_221042`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan_221042`
--
ALTER TABLE `detail_pesanan_221042`
  ADD CONSTRAINT `detail_pesanan_221042_ibfk_1` FOREIGN KEY (`kode_pesanan_221042`) REFERENCES `pesanan_221042` (`kode_pesanan_221042`),
  ADD CONSTRAINT `detail_pesanan_221042_ibfk_2` FOREIGN KEY (`kode_menu_221042`) REFERENCES `menu_221042` (`kode_menu_221042`);

--
-- Constraints for table `pembayaran_221042`
--
ALTER TABLE `pembayaran_221042`
  ADD CONSTRAINT `pembayaran_221042_ibfk_1` FOREIGN KEY (`kode_pesanan_221042`) REFERENCES `pesanan_221042` (`kode_pesanan_221042`);

--
-- Constraints for table `pesanan_221042`
--
ALTER TABLE `pesanan_221042`
  ADD CONSTRAINT `pesanan_221042_ibfk_1` FOREIGN KEY (`nik_221042`) REFERENCES `pelanggan_221042` (`nik_221042`),
  ADD CONSTRAINT `pesanan_221042_ibfk_2` FOREIGN KEY (`kode_reservasi_221042`) REFERENCES `reservasi_221042` (`kode_reservasi_221042`);

--
-- Constraints for table `reservasi_221042`
--
ALTER TABLE `reservasi_221042`
  ADD CONSTRAINT `reservasi_221042_ibfk_1` FOREIGN KEY (`nik_221042`) REFERENCES `pelanggan_221042` (`nik_221042`),
  ADD CONSTRAINT `reservasi_221042_ibfk_2` FOREIGN KEY (`kode_meja_221042`) REFERENCES `meja_221042` (`kode_meja_221042`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

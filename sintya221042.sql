-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 19, 2025 at 03:56 PM
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
-- Table structure for table `detail_pesanan_221042`
--

CREATE TABLE `detail_pesanan_221042` (
  `id_detailpesanan_221042` int(12) NOT NULL,
  `id_pesanan_221042` int(12) DEFAULT NULL,
  `id_menu_221042` int(12) DEFAULT NULL,
  `jumlah_221042` int(10) DEFAULT NULL,
  `subtotal_221042` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `meja_221042`
--

CREATE TABLE `meja_221042` (
  `id_meja_221042` int(12) NOT NULL,
  `nomor_meja_221042` int(12) DEFAULT NULL,
  `kapasitas_221042` int(12) DEFAULT NULL,
  `status_221042` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `menu_221042`
--

CREATE TABLE `menu_221042` (
  `id_menu_221042` int(12) NOT NULL,
  `nama_menu_221042` varchar(255) DEFAULT NULL,
  `deskripsi_221042` text DEFAULT NULL,
  `harga_221042` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan_221042`
--

CREATE TABLE `pelanggan_221042` (
  `id_pelanggan_221042` int(12) NOT NULL,
  `nama_221042` varchar(50) DEFAULT NULL,
  `telepon_221042` varchar(15) DEFAULT NULL,
  `email_221042` varchar(50) DEFAULT NULL,
  `username_221042` varchar(255) DEFAULT NULL,
  `password_221042` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pelanggan_221042`
--

INSERT INTO `pelanggan_221042` (`id_pelanggan_221042`, `nama_221042`, `telepon_221042`, `email_221042`, `username_221042`, `password_221042`) VALUES
(1, 'tes', '0843', 'tes@gmail.com', 'tes', '202cb962ac59075b964b07152d234b70');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran_221042`
--

CREATE TABLE `pembayaran_221042` (
  `id_pembayaran_221042` int(12) NOT NULL,
  `id_pesanan_221042` int(12) DEFAULT NULL,
  `metode_pembayaran_221042` varchar(50) DEFAULT NULL,
  `jumlah_221042` decimal(10,2) DEFAULT NULL,
  `status_221042` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pesanan_221042`
--

CREATE TABLE `pesanan_221042` (
  `id_pesanan_221042` int(12) NOT NULL,
  `id_pelanggan_221042` int(12) DEFAULT NULL,
  `id_reservasi_221042` int(12) DEFAULT NULL,
  `kode_pesanan_221042` varchar(255) DEFAULT NULL,
  `tanggal_pesanan_221042` datetime DEFAULT NULL,
  `catatan_221042` varchar(255) DEFAULT NULL,
  `total_221042` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `reservasi_221042`
--

CREATE TABLE `reservasi_221042` (
  `id_reservasi_221042` int(12) NOT NULL,
  `id_pelanggan_221042` int(12) DEFAULT NULL,
  `id_meja_221042` int(12) DEFAULT NULL,
  `kode_reservasi_221042` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_pesanan_221042`
--
ALTER TABLE `detail_pesanan_221042`
  ADD PRIMARY KEY (`id_detailpesanan_221042`),
  ADD KEY `id_pesanan_221042` (`id_pesanan_221042`),
  ADD KEY `id_menu_221042` (`id_menu_221042`);

--
-- Indexes for table `meja_221042`
--
ALTER TABLE `meja_221042`
  ADD PRIMARY KEY (`id_meja_221042`);

--
-- Indexes for table `menu_221042`
--
ALTER TABLE `menu_221042`
  ADD PRIMARY KEY (`id_menu_221042`);

--
-- Indexes for table `pelanggan_221042`
--
ALTER TABLE `pelanggan_221042`
  ADD PRIMARY KEY (`id_pelanggan_221042`);

--
-- Indexes for table `pembayaran_221042`
--
ALTER TABLE `pembayaran_221042`
  ADD PRIMARY KEY (`id_pembayaran_221042`),
  ADD KEY `id_pesanan_221042` (`id_pesanan_221042`);

--
-- Indexes for table `pesanan_221042`
--
ALTER TABLE `pesanan_221042`
  ADD PRIMARY KEY (`id_pesanan_221042`),
  ADD KEY `id_pelanggan_221042` (`id_pelanggan_221042`),
  ADD KEY `id_reservasi_221042` (`id_reservasi_221042`);

--
-- Indexes for table `reservasi_221042`
--
ALTER TABLE `reservasi_221042`
  ADD PRIMARY KEY (`id_reservasi_221042`),
  ADD KEY `id_pelanggan_221042` (`id_pelanggan_221042`),
  ADD KEY `id_meja_221042` (`id_meja_221042`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_pesanan_221042`
--
ALTER TABLE `detail_pesanan_221042`
  MODIFY `id_detailpesanan_221042` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `meja_221042`
--
ALTER TABLE `meja_221042`
  MODIFY `id_meja_221042` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `menu_221042`
--
ALTER TABLE `menu_221042`
  MODIFY `id_menu_221042` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pelanggan_221042`
--
ALTER TABLE `pelanggan_221042`
  MODIFY `id_pelanggan_221042` int(12) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `pembayaran_221042`
--
ALTER TABLE `pembayaran_221042`
  MODIFY `id_pembayaran_221042` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pesanan_221042`
--
ALTER TABLE `pesanan_221042`
  MODIFY `id_pesanan_221042` int(12) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reservasi_221042`
--
ALTER TABLE `reservasi_221042`
  MODIFY `id_reservasi_221042` int(12) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `detail_pesanan_221042`
--
ALTER TABLE `detail_pesanan_221042`
  ADD CONSTRAINT `detail_pesanan_221042_ibfk_1` FOREIGN KEY (`id_pesanan_221042`) REFERENCES `pesanan_221042` (`id_pesanan_221042`),
  ADD CONSTRAINT `detail_pesanan_221042_ibfk_2` FOREIGN KEY (`id_menu_221042`) REFERENCES `menu_221042` (`id_menu_221042`);

--
-- Constraints for table `pembayaran_221042`
--
ALTER TABLE `pembayaran_221042`
  ADD CONSTRAINT `pembayaran_221042_ibfk_1` FOREIGN KEY (`id_pesanan_221042`) REFERENCES `pesanan_221042` (`id_pesanan_221042`);

--
-- Constraints for table `pesanan_221042`
--
ALTER TABLE `pesanan_221042`
  ADD CONSTRAINT `pesanan_221042_ibfk_1` FOREIGN KEY (`id_pelanggan_221042`) REFERENCES `pelanggan_221042` (`id_pelanggan_221042`),
  ADD CONSTRAINT `pesanan_221042_ibfk_2` FOREIGN KEY (`id_reservasi_221042`) REFERENCES `reservasi_221042` (`id_reservasi_221042`);

--
-- Constraints for table `reservasi_221042`
--
ALTER TABLE `reservasi_221042`
  ADD CONSTRAINT `reservasi_221042_ibfk_1` FOREIGN KEY (`id_pelanggan_221042`) REFERENCES `pelanggan_221042` (`id_pelanggan_221042`),
  ADD CONSTRAINT `reservasi_221042_ibfk_2` FOREIGN KEY (`id_meja_221042`) REFERENCES `meja_221042` (`id_meja_221042`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

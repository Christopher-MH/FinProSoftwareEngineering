-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2025 at 06:46 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `trash_trade`
--

-- --------------------------------------------------------

--
-- Table structure for table `alamat`
--

CREATE TABLE `alamat` (
  `alamat_id` char(6) NOT NULL,
  `user_id` char(6) DEFAULT NULL,
  `provinsi` varchar(100) DEFAULT NULL,
  `kota` varchar(100) DEFAULT NULL,
  `alamat_lengkap` varchar(255) DEFAULT NULL,
  `maps_pinpoint` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penjemputan`
--

CREATE TABLE `penjemputan` (
  `penjemputan_id` char(6) NOT NULL,
  `user_id` char(6) DEFAULT NULL,
  `berat_organik` float DEFAULT NULL,
  `berat_anorganik` float DEFAULT NULL,
  `berat_b3` float DEFAULT NULL,
  `jam_penjemputan` datetime DEFAULT NULL,
  `lokasi_penjemputan` varchar(255) DEFAULT NULL,
  `poin_masuk` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` char(6) NOT NULL,
  `nama_pertama` varchar(100) NOT NULL,
  `nama_akhir` varchar(100) NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `tanggal_lahir` varchar(100) NOT NULL,
  `handphone` char(13) DEFAULT NULL CHECK (`handphone` regexp '^[0-9]+$'),
  `email` varchar(100) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `status_account` enum('aktif','blokir','suspend') NOT NULL,
  `poin_skrng` int(11) NOT NULL,
  `poin_masuk` int(11) NOT NULL,
  `poin_keluar` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `nama_pertama`, `nama_akhir`, `photo_path`, `tanggal_lahir`, `handphone`, `email`, `pass`, `status_account`, `poin_skrng`, `poin_masuk`, `poin_keluar`) VALUES
('U0001', 'Boss', 'Besar', '../page_assets/profile_pictures/U0001_Photo.png', '1 January 2000', '081234567890', 'admin@gmail.com', '0192023a7bbd73250516f069df18b500', 'aktif', 0, 0, 0),
('U0002', 'Cairn', 'Tsukigane', '../page_assets/profile_pictures/U0002_Photo.png', '15 June 2005', '0895334929292', 'harmity@gmail.com', '246556e541037a347f83fa7c470f9928', 'aktif', 310, 0, 1370),
('U0003', 'Kaida', 'Mikagura', '../page_assets/profile_pictures/U0003_Photo.png', '15 June 2005', '0895334929292', 'kaida@gmail.com', 'd51526469e0e84de1c48a00751b27a64', 'aktif', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vouchers`
--

CREATE TABLE `vouchers` (
  `voucher_id` char(6) NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `photo_path` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` int(11) DEFAULT NULL,
  `stok` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `vouchers`
--

INSERT INTO `vouchers` (`voucher_id`, `nama`, `photo_path`, `deskripsi`, `harga`, `stok`) VALUES
('V0001', 'Paket Benih Sayur', '../page_assets/vouchers/benih_sayur.png', 'Isi 3 benih: bayam, kangkung, tomat.', 70, 14),
('V0002', 'Botol Minum', '../page_assets/vouchers/bottle.png', 'Botol minum ramah lingkungan.', 150, 1),
('V0003', 'Totebag Daur Ulang', '../page_assets/vouchers/totebag.png', 'Totebag ramah lingkungan dari bahan daur ulang.', 120, 15),
('V0004', 'Sabun Organik', '../page_assets/vouchers/sabun_organik.png', 'Sabun mandi alami tanpa bahan kimia.', 90, 20),
('V0005', 'Tumbler Stainless', '../page_assets/vouchers/tumbler.png', 'Tumbler anti bocor 500ml untuk aktivitas sehari-hari.', 180, 12);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alamat`
--
ALTER TABLE `alamat`
  ADD PRIMARY KEY (`alamat_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `penjemputan`
--
ALTER TABLE `penjemputan`
  ADD PRIMARY KEY (`penjemputan_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `vouchers`
--
ALTER TABLE `vouchers`
  ADD PRIMARY KEY (`voucher_id`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alamat`
--
ALTER TABLE `alamat`
  ADD CONSTRAINT `alamat_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `penjemputan`
--
ALTER TABLE `penjemputan`
  ADD CONSTRAINT `penjemputan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

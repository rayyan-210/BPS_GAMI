-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 12, 2026 at 02:56 AM
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
-- Database: `bps_umkm`
--

-- --------------------------------------------------------

--
-- Table structure for table `redeem_rewards`
--

CREATE TABLE `redeem_rewards` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reward_id` int(11) NOT NULL,
  `tanggal_redeem` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `redeem_rewards`
--

INSERT INTO `redeem_rewards` (`id`, `user_id`, `reward_id`, `tanggal_redeem`) VALUES
(1, 4, 1, '2026-05-10 16:26:37');

-- --------------------------------------------------------

--
-- Table structure for table `rewards`
--

CREATE TABLE `rewards` (
  `id` int(11) NOT NULL,
  `nama_reward` varchar(150) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `poin_required` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rewards`
--

INSERT INTO `rewards` (`id`, `nama_reward`, `gambar`, `poin_required`, `created_at`) VALUES
(1, 'Pulsa Rp 10.000', NULL, 50, '2026-05-10 15:35:46'),
(2, 'Voucher Belanja Rp 25.000', NULL, 100, '2026-05-10 15:35:46'),
(3, 'E-Wallet Rp 50.000', NULL, 200, '2026-05-10 15:35:46'),
(4, 'Merchandise BPS', NULL, 150, '2026-05-10 15:35:46');

-- --------------------------------------------------------

--
-- Table structure for table `surveys`
--

CREATE TABLE `surveys` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `task_id` int(11) NOT NULL,
  `nama_umkm` varchar(150) NOT NULL,
  `alamat` text DEFAULT NULL,
  `jenis_usaha` varchar(100) DEFAULT NULL,
  `no_telepon` varchar(30) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `foto_umkm` varchar(255) DEFAULT NULL,
  `bukti_lokasi` varchar(255) DEFAULT NULL,
  `status_validasi` enum('pending','approved','rejected') DEFAULT 'pending',
  `poin` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `surveys`
--

INSERT INTO `surveys` (`id`, `user_id`, `task_id`, `nama_umkm`, `alamat`, `jenis_usaha`, `no_telepon`, `deskripsi`, `foto_umkm`, `bukti_lokasi`, `status_validasi`, `poin`, `created_at`) VALUES
(3, 4, 2, 'dsada', 'erwerew', 'Pertanian', '324234324', 'dgfsvgsdfs', 'umkm_6a00b0d99a712.jpg', 'umkm_6a00b0d99c338.png', 'approved', 25, '2026-05-10 16:22:49'),
(4, 4, 4, 'dsada', 'sdadasd', 'Kerajinan', '3123123123', 'sdasdas', 'umkm_6a00b133549e2.jpg', 'umkm_6a00b13355131.png', 'approved', 21, '2026-05-10 16:24:19'),
(5, 4, 4, 'unabd', 'sdasds', 'Jasa', '231231231', 'asdfasdsad', 'umkm_6a0141a2984e9.jpg', NULL, 'approved', 21, '2026-05-11 02:40:34'),
(6, 4, 4, 'sadas', 'sdadas', 'Jasa', '06172631732', 'dsdasda', NULL, 'umkm_6a01deb358c0e.jpg', 'approved', 21, '2026-05-11 13:50:43'),
(7, 4, 2, 'sadas', 'sadasd', 'Jasa', '06172631732', 'sfa', NULL, NULL, 'approved', 0, '2026-05-11 14:08:04'),
(8, 6, 3, 'solo mantap', 'jln kesamben', 'Kuliner', '06172631732', 'usaha tepi sawah', NULL, NULL, 'approved', 0, '2026-05-12 00:53:26');

-- --------------------------------------------------------

--
-- Table structure for table `tasks`
--

CREATE TABLE `tasks` (
  `id` int(11) NOT NULL,
  `judul` varchar(150) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `poin_reward` int(11) DEFAULT 10,
  `is_completed` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tasks`
--

INSERT INTO `tasks` (`id`, `judul`, `deskripsi`, `lokasi`, `poin_reward`, `is_completed`, `created_at`) VALUES
(2, 'Pendataan UMKM Malioboro', 'Data pedagang sepanjang Malioboro', 'Yogyakarta', 25, 1, '2026-05-10 15:35:46'),
(3, 'Pendataan UMKM Kuliner Solo', 'Survey UMKM kuliner di Solo', 'Solo', 30, 1, '2026-05-10 15:35:46'),
(4, 'Bogas', 'dsdasdasdas', 'wqeqedsa3', 21, 0, '2026-05-10 16:23:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') DEFAULT 'user',
  `poin` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `poin`, `created_at`) VALUES
(4, 'rayyan', 'rayy@gmail.com', '$2y$10$YYBHVxutMvqAiGlapCl3vusF22zYTlFWXVOn/NYo7i2Ad6fb7LACm', 'user', 83, '2026-05-10 16:16:43'),
(5, 'faras', 'fara@gmail.com', '$2y$10$3/JcaqxW.9v.qj1heM.KmuKQIC/q33HU6g0of6SFVifBC9Oi0apLi', 'admin', 0, '2026-05-10 16:18:32'),
(6, 'vicky ananda', 'gorila@gmail.com', '$2y$10$ILPsCJiamXReSCqYIyv6IO/8bqqc2fWu.y2/4TKoFMl/9/TjVQXwu', 'user', 30, '2026-05-12 00:51:20');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `redeem_rewards`
--
ALTER TABLE `redeem_rewards`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `reward_id` (`reward_id`);

--
-- Indexes for table `rewards`
--
ALTER TABLE `rewards`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `surveys`
--
ALTER TABLE `surveys`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `task_id` (`task_id`);

--
-- Indexes for table `tasks`
--
ALTER TABLE `tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `redeem_rewards`
--
ALTER TABLE `redeem_rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `rewards`
--
ALTER TABLE `rewards`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `surveys`
--
ALTER TABLE `surveys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `tasks`
--
ALTER TABLE `tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `redeem_rewards`
--
ALTER TABLE `redeem_rewards`
  ADD CONSTRAINT `redeem_rewards_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `redeem_rewards_ibfk_2` FOREIGN KEY (`reward_id`) REFERENCES `rewards` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `surveys`
--
ALTER TABLE `surveys`
  ADD CONSTRAINT `surveys_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `surveys_ibfk_2` FOREIGN KEY (`task_id`) REFERENCES `tasks` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

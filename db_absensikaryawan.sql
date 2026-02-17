-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 03, 2024 at 10:49 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_absensikaryawan`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id_absen` varchar(191) NOT NULL,
  `username` varchar(191) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `checkinout` varchar(191) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absen`
--

INSERT INTO `absen` (`id_absen`, `username`, `waktu`, `checkinout`, `keterangan`) VALUES
('6657f711985c5', 'admin', '2024-05-29 20:48:33', 'In', 'Tesss check in'),
('6657f71b46cff', 'admin', '2024-05-29 20:48:43', 'Out', 'Tess Out'),
('66582398695be', 'fahmi', '2024-05-29 23:58:32', 'In', 'asdasd'),
('665826f938452', 'fahmi', '2024-05-30 00:12:57', 'Out', 'asda sdasd'),
('6658278c92675', 'kevin', '2024-05-30 00:15:24', 'In', 'Tes Check In'),
('665827a439f78', 'kevin', '2024-05-30 00:15:48', 'Out', 'Tes check out'),
('667eac5b2a0f9', 'admin', '2024-06-28 13:28:11', 'In', 'Masuk'),
('667eac9c16b4d', 'fahmi_perdana', '2024-06-28 13:29:16', 'In', 'masuk');

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `username` varchar(191) NOT NULL,
  `password` varchar(50) DEFAULT NULL,
  `level` varchar(191) NOT NULL,
  `nama_lengkap` varchar(191) NOT NULL,
  `alamat` varchar(191) NOT NULL,
  `telepon` int(191) NOT NULL,
  `jkel` varchar(191) NOT NULL,
  `nik` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `ttd` varchar(191) NOT NULL,
  `waktu` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`username`, `password`, `level`, `nama_lengkap`, `alamat`, `telepon`, `jkel`, `nik`, `email`, `ttd`, `waktu`) VALUES
('admin', 'admin', 'admin', 'Administrator', 'Jl. Padjajaran Pamulang', 2147483647, 'Laki-laki', '20000', 'administrator@gmail.com', '6449c316d144e.png', '2024-07-03 09:35:23'),
('fahmi', '123', 'karyawan', 'fahmi', 'JL. Bambu kuning, Jakarta Timur', 2147483647, 'Laki-laki', '20001', 'fahmi@gmail.com', '', '2024-07-03 09:29:06'),
('fahmi_perdana', '123', 'karyawan', 'fahmi perdana', 'jl. kebagusan jaksel', 0, 'Laki-laki', 'abc', 'fahmipw@gmail.com', '', '2024-06-28 13:25:49'),
('kevin', '123', 'karyawan', 'kevin', 'Jl. Siliwiangi, Pamulang', 2147483647, 'Laki-laki', '20003', 'kevin@gmail.com', '', '2024-06-28 07:16:36'),
('luthfi', '123', 'karyawan', 'luthfi', 'Jl. Anggur, Jakarta Barat', 2147483647, 'Laki-laki', '20002', 'luthfi@gmail.com', '', '2024-06-28 07:16:36'),
('yuda', '123', 'karyawan', 'yuda', 'jakarta', 2147483647, 'Laki-laki', '20202', 'asdasd@gmail.com', '', '2024-07-03 09:35:48');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `fk_absen_login` (`username`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`username`);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `absen`
--
ALTER TABLE `absen`
  ADD CONSTRAINT `fk_absen_login` FOREIGN KEY (`username`) REFERENCES `login` (`username`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

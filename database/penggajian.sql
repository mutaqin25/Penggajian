-- phpMyAdmin SQL Dump
-- version 5.0.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 01, 2022 at 02:06 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.4.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `penggajian`
--

-- --------------------------------------------------------

--
-- Table structure for table `absen`
--

CREATE TABLE `absen` (
  `id_absen` int(15) NOT NULL,
  `nik` bigint(30) NOT NULL,
  `tanggal` date NOT NULL,
  `jam_masuk` time DEFAULT NULL,
  `ket_masuk` varchar(100) DEFAULT NULL,
  `jam_keluar` time DEFAULT NULL,
  `ket_keluar` varchar(100) DEFAULT NULL,
  `keterangan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `absen`
--

INSERT INTO `absen` (`id_absen`, `nik`, `tanggal`, `jam_masuk`, `ket_masuk`, `jam_keluar`, `ket_keluar`, `keterangan`) VALUES
(1, 20160910024, '2022-06-15', '18:00:31', 'Terlambat', '14:16:30', 'Pulang Lebih Awal', 'Hadir'),
(2, 20160910024, '2022-06-16', '07:03:00', 'Tepat Waktu', '14:16:30', 'Pulang Lebih Awal', 'Hadir'),
(6, 3333333333333, '2022-06-21', '13:25:33', 'Tepat Waktu', '13:25:37', 'Pulang Lebih Awal', 'Hadir'),
(7, 20160910024, '2022-06-20', '00:00:00', '', '00:00:00', '', 'Sakit'),
(8, 20160910024, '2022-06-21', '14:17:31', 'Terlambat', '14:18:29', 'Pulang Lebih Awal', 'Hadir'),
(9, 99999999999, '2022-06-21', '16:14:00', 'Terlambat', '16:14:04', 'Pulang Lebih Awal', 'Hadir'),
(10, 251098, '2022-06-23', '13:09:33', 'Terlambat', '13:09:46', 'Lembur', 'Hadir'),
(11, 251098, '2022-06-24', '08:12:00', 'Tepat Waktu', '14:12:00', 'Lembur', 'Hadir'),
(12, 20160910024, '2022-06-28', '22:13:14', 'Terlambat', '00:00:00', '', NULL),
(13, 20160910024, '2022-07-01', '00:00:00', '', '00:00:00', '', 'Tidak Masuk');

-- --------------------------------------------------------

--
-- Table structure for table `gaji_bulanan`
--

CREATE TABLE `gaji_bulanan` (
  `id_gaji` int(11) NOT NULL,
  `periode` varchar(30) NOT NULL,
  `nik` bigint(30) NOT NULL,
  `tanggal` date NOT NULL,
  `gaji_pokok` bigint(30) NOT NULL,
  `total_hadir` int(15) NOT NULL,
  `uang_tunjangan` bigint(30) NOT NULL,
  `uang_lembur` bigint(30) NOT NULL,
  `uang_potongan` bigint(30) NOT NULL,
  `bpjs` bigint(20) NOT NULL,
  `pph21` bigint(30) NOT NULL,
  `gaji_bersih` bigint(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `gaji_bulanan`
--

INSERT INTO `gaji_bulanan` (`id_gaji`, `periode`, `nik`, `tanggal`, `gaji_pokok`, `total_hadir`, `uang_tunjangan`, `uang_lembur`, `uang_potongan`, `bpjs`, `pph21`, `gaji_bersih`) VALUES
(1, '2022-06', 20160910024, '2022-07-01', 4000000, 3, 120000, 138728, 355000, 181600, 0, 4085328),
(2, '2022-07', 20160910024, '2022-07-01', 4000000, 0, 0, 0, 100000, 181600, 0, 4081600);

-- --------------------------------------------------------

--
-- Table structure for table `karyawan`
--

CREATE TABLE `karyawan` (
  `nik` bigint(20) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(100) NOT NULL,
  `tgl_lahir` date DEFAULT NULL,
  `alamat` varchar(100) NOT NULL,
  `status` varchar(50) NOT NULL,
  `agama` varchar(50) NOT NULL,
  `no_hp` text NOT NULL,
  `jabatan` varchar(30) NOT NULL,
  `shift` varchar(15) NOT NULL,
  `gaji` bigint(50) NOT NULL,
  `bpjs` varchar(100) NOT NULL,
  `tgl_masuk` date NOT NULL,
  `pendidikan` varchar(50) NOT NULL,
  `foto` varchar(100) NOT NULL,
  `qrcode` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `karyawan`
--

INSERT INTO `karyawan` (`nik`, `nama`, `jenis_kelamin`, `tgl_lahir`, `alamat`, `status`, `agama`, `no_hp`, `jabatan`, `shift`, `gaji`, `bpjs`, `tgl_masuk`, `pendidikan`, `foto`, `qrcode`) VALUES
(251098, 'Taqin', 'Laki-Laki', '1998-10-25', 'Cirebon                                                                                             ', 'Belum Menikah', 'Islam', '081111111111', 'Leader Pelayan', 'Shift 1', 4000000, 'Jaminan Kecelakaan Kerja,Jaminan Pensiun,Jaminan Kesehatan,Jaminan Kecelakaan Kerja,Jaminan Pensiun,', '2022-06-01', 'Diploma', '279398082_teahub.io-iron-spider-wallpaper-856302.png', '251098.png'),
(8634242467, 'Erik', 'Laki-Laki', '2018-05-10', 'adada                                                                                               ', 'Menikah', 'Islam', '0834535324', 'Pelayan', 'Shift 1', 4000000, '', '2022-04-21', 'Kejuruan', '1646752479_javascript_original_logo_icon_146455.png', '8634242467.png'),
(20160910024, 'Muttaqin', 'Laki-Laki', '1998-10-25', 'Cirebon                                                                                             ', 'Belum Menikah', 'Islam', '084245224233', 'Staff Pelayan', 'Shift 1', 4000000, 'Jaminan Kecelakaan Kerja,Jaminan Kematian,Jaminan Kesehatan,Jaminan Kecelakaan Kerja,Jaminan Kematia', '2022-02-08', 'Sarjana', '1782092867_985969.jpg', '20160910024.png'),
(99999999999, 'Andora', 'Laki-Laki', '2022-06-17', 'nnnnn                                            ', 'Belum Menikah', 'Islam', '084245224233', 'Pelayan', 'Shift 1', 5000000, 'Jaminan Kecelakaan Kerja,Jaminan Kematian,Jaminan Hari Tua,Jaminan Pensiun', '2022-06-01', 'Sekolah Menengah Atas', '1170555466_1653512.jpg', '99999999999.png'),
(3333333333333, 'Erika', 'Perempuan', '1997-08-06', '  adsad                                                                                             ', 'Menikah', 'Hindu', '0824242423', 'Pelayan', 'Shift 2', 8000000, 'Jaminan Kecelakaan Kerja,Jaminan Kematian', '2022-05-10', 'Diploma', '985652032_vue-js-1.png', '3333333333333.png');

-- --------------------------------------------------------

--
-- Table structure for table `penghasilan`
--

CREATE TABLE `penghasilan` (
  `id_penghasilan` int(15) NOT NULL,
  `nik` bigint(30) NOT NULL,
  `id_absen` bigint(30) NOT NULL,
  `tanggal` date DEFAULT NULL,
  `hadir` int(30) NOT NULL,
  `tidak_masuk` int(30) DEFAULT NULL,
  `sakit` int(30) DEFAULT NULL,
  `terlambat` int(30) DEFAULT NULL,
  `lembur` int(30) DEFAULT NULL,
  `uang_makan` bigint(30) NOT NULL,
  `uang_transport` bigint(30) NOT NULL,
  `uang_sakit` bigint(30) DEFAULT NULL,
  `uang_tidak_masuk` bigint(30) DEFAULT NULL,
  `uang_lembur` bigint(30) DEFAULT NULL,
  `uang_terlambat` bigint(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `penghasilan`
--

INSERT INTO `penghasilan` (`id_penghasilan`, `nik`, `id_absen`, `tanggal`, `hadir`, `tidak_masuk`, `sakit`, `terlambat`, `lembur`, `uang_makan`, `uang_transport`, `uang_sakit`, `uang_tidak_masuk`, `uang_lembur`, `uang_terlambat`) VALUES
(1, 20160910024, 1, '2022-06-15', 1, 0, 0, 10, 3, 20000, 20000, 0, 0, 69364, 100000),
(2, 20160910024, 2, '2022-06-16', 1, 0, 0, 0, 3, 20000, 20000, 0, 0, 69364, 0),
(6, 3333333333333, 6, '2022-06-21', 1, 0, 0, 0, 0, 20000, 20000, 0, 0, 0, 0),
(7, 20160910024, 7, '2022-06-20', 0, 0, 1, 0, 0, 0, 0, 75000, 0, 0, 0),
(8, 20160910024, 8, '2022-06-21', 1, 0, 0, 5, 0, 20000, 20000, 0, 0, 0, 50000),
(9, 99999999999, 9, '2022-06-21', 1, 0, 0, 7, 0, 20000, 20000, 0, 0, 0, 70000),
(10, 251098, 10, '2022-06-23', 1, 0, 0, 4, 3, 20000, 20000, 0, 0, 69364, 40000),
(11, 251098, 11, '2022-06-24', 1, 0, 0, 0, 2, 20000, 20000, 0, 0, 46243, 0),
(12, 20160910024, 12, '2022-06-28', 0, 0, 0, 13, 0, 0, 0, 0, 0, 0, 130000),
(13, 20160910024, 13, '2022-07-01', 0, 1, 0, 0, 0, 0, 0, 0, 100000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` bigint(15) NOT NULL,
  `nik` bigint(30) NOT NULL,
  `nama` varchar(50) NOT NULL,
  `jenis_kelamin` varchar(50) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `level` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `nik`, `nama`, `jenis_kelamin`, `username`, `password`, `level`) VALUES
(3, 20160910024, 'Muttaqin', 'Laki-Laki', 'zaenul', 'zaenul123', 'Pegawai'),
(4, 123456789, 'Admin', 'Laki-Laki', 'admin', 'admin', 'Admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `absen`
--
ALTER TABLE `absen`
  ADD PRIMARY KEY (`id_absen`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `gaji_bulanan`
--
ALTER TABLE `gaji_bulanan`
  ADD PRIMARY KEY (`id_gaji`),
  ADD KEY `nik` (`nik`);

--
-- Indexes for table `karyawan`
--
ALTER TABLE `karyawan`
  ADD PRIMARY KEY (`nik`);

--
-- Indexes for table `penghasilan`
--
ALTER TABLE `penghasilan`
  ADD PRIMARY KEY (`id_penghasilan`),
  ADD KEY `nik` (`nik`),
  ADD KEY `id_absen` (`id_absen`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 01, 2026 at 08:42 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.4.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tjkt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nama` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` text NOT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `nama`, `email`, `password`, `telepon`, `foto`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'admin@tkjt.local', 'admin123', '088833332222', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `api_sarpras`
--

CREATE TABLE `api_sarpras` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL DEFAULT 'sarpras',
  `base_url` varchar(255) NOT NULL,
  `api_key` varchar(255) DEFAULT NULL,
  `api_secret` varchar(255) DEFAULT NULL,
  `token` text DEFAULT NULL,
  `tipe_auth` varchar(50) DEFAULT 'bearer',
  `aktif` tinyint(1) DEFAULT 0,
  `keterangan` text DEFAULT NULL,
  `last_sync` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `api_sarpras`
--

INSERT INTO `api_sarpras` (`id`, `nama`, `base_url`, `api_key`, `api_secret`, `token`, `tipe_auth`, `aktif`, `keterangan`, `last_sync`, `created_at`, `updated_at`) VALUES
(2, 'SARPRAS PUSAT', 'https://be-sarpras.aryajaka.site', NULL, NULL, NULL, 'api_key', 1, 'API resmi SARPRAS pusat untuk tarik data inventaris KIB berdasarkan kode unik (QR)', '2026-01-30 08:01:06', '2026-01-27 11:25:30', '2026-01-30 08:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `aturan`
--

CREATE TABLE `aturan` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `maks_hari` int(11) DEFAULT NULL,
  `denda_hari` decimal(10,2) DEFAULT NULL,
  `perlu_setuju` tinyint(1) DEFAULT NULL,
  `role_setuju` varchar(50) DEFAULT NULL,
  `aktif` tinyint(1) DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aturan`
--

INSERT INTO `aturan` (`id`, `nama`, `deskripsi`, `maks_hari`, `denda_hari`, `perlu_setuju`, `role_setuju`, `aktif`, `created_at`, `updated_at`) VALUES
(1, 'testtesttesttesttest', 'testtesttesttesttesttesttesttest', NULL, NULL, NULL, 'admin', 1, '2026-01-21 11:03:33', '2026-01-22 09:56:40'),
(2, 'wakakawakakawakakawakaka', 'wakakawakaka', NULL, NULL, NULL, 'admin', 1, '2026-01-22 01:20:12', '2026-01-22 09:56:32');

-- --------------------------------------------------------

--
-- Table structure for table `bahan`
--

CREATE TABLE `bahan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `nama` varchar(191) NOT NULL,
  `stok` decimal(10,2) DEFAULT 0.00,
  `satuan` varchar(50) DEFAULT 'pcs',
  `lokasi_id` int(10) UNSIGNED DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `sarpras_id` varchar(100) DEFAULT NULL,
  `sarpras_sync` tinyint(1) DEFAULT 0,
  `sarpras_last_sync` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bahan`
--

INSERT INTO `bahan` (`id`, `kode`, `nama`, `stok`, `satuan`, `lokasi_id`, `keterangan`, `sarpras_id`, `sarpras_sync`, `sarpras_last_sync`, `created_at`, `updated_at`) VALUES
(1, 'K-6834', 'kabela', 1.00, 'pcs', 2, 'saaasasa', NULL, NULL, NULL, '2026-01-22 08:18:15', '2026-01-25 00:06:18');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `nama` varchar(191) NOT NULL,
  `spesifikasi` text DEFAULT NULL,
  `merk` varchar(100) DEFAULT NULL,
  `kategori_id` int(10) UNSIGNED DEFAULT NULL,
  `stok` int(11) DEFAULT 0,
  `satuan` varchar(50) DEFAULT 'unit',
  `kondisi` varchar(100) DEFAULT 'Baik',
  `lokasi_id` int(10) UNSIGNED DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `foto` text DEFAULT NULL,
  `qr_code` varchar(255) DEFAULT NULL,
  `sarpras_id` varchar(100) DEFAULT NULL,
  `sarpras_sync` tinyint(1) DEFAULT NULL,
  `sarpras_last_sync` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `barang`
--

INSERT INTO `barang` (`id`, `kode`, `nama`, `spesifikasi`, `merk`, `kategori_id`, `stok`, `satuan`, `kondisi`, `lokasi_id`, `keterangan`, `tipe`, `foto`, `qr_code`, `sarpras_id`, `sarpras_sync`, `sarpras_last_sync`, `created_at`, `updated_at`) VALUES
(7, 'LAPTO-6202', 'Laptop', 'Laptop Asus 16gb', 'Asus', 3, 10, 'unit', 'baik', 2, NULL, NULL, NULL, 'uploads/qr_barang/qr-LAPTO-6202.svg', NULL, NULL, NULL, '2026-01-22 08:37:36', '2026-01-22 23:08:56'),
(8, 'KOMPU-7765', 'Komputer Dell', 'Komputer Dell 32gb', 'Dell', 3, 15, 'unit', 'baik', 2, NULL, NULL, NULL, 'uploads/qr_barang/qr-KOMPU-7765.svg', NULL, NULL, NULL, '2026-01-22 09:03:52', '2026-01-22 09:31:43'),
(9, 'LAPTO-8422', 'Laptop Asus', 'Laptop Asus 48gb', 'Asus', 3, 20, 'unit', 'baik', 3, NULL, NULL, NULL, 'uploads/qr_barang/qr-LAPTO-8422.svg', NULL, NULL, NULL, '2026-01-22 10:14:00', '2026-01-22 10:14:02'),
(17, '1.01.000021', 'Proyektor', 'test', 'Epson X500', NULL, 1, 'unit', 'baik', 3, 'Barang ditarik dari SARPRAS Pusat - 30/01/2026 15:01', 'sarpras', NULL, 'https://minio-api.aryajaka.site/sapras-app/qrcodes/1.01.000021.png', NULL, 1, '2026-01-30 08:01:06', '2026-01-30 08:01:06', '2026-01-30 08:01:06');

-- --------------------------------------------------------

--
-- Table structure for table `guru`
--

CREATE TABLE `guru` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nip` varchar(50) DEFAULT NULL,
  `nama` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` text NOT NULL,
  `telepon` varchar(50) DEFAULT NULL,
  `jabatan` varchar(100) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `guru`
--

INSERT INTO `guru` (`id`, `nip`, `nama`, `email`, `password`, `telepon`, `jabatan`, `foto`, `created_at`, `updated_at`) VALUES
(1, '34234535234', 'guruku', 'budi@tkjt.local', 'guru123', '3254354353', 'Guru', 'uploads/foto_guru/guru_1_1769174849.jpg', NULL, '2026-01-23 06:27:29'),
(2, '37945860', 'Siti Aminah', 'siti@tkjt.local', 'hoho', '03864', 'Guru', 'uploads/foto_guru/guru_1769064694_0XXlTS.jpeg', '2026-01-21 23:51:34', '2026-01-21 23:51:34');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `tipe` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama`, `deskripsi`, `tipe`, `created_at`, `updated_at`) VALUES
(3, 'komputer', 'komputer', 'alat', '2026-01-20 23:56:17', '2026-01-20 23:56:17'),
(5, 'Alat Tulis', 'Alat Tulis Kantoran..', NULL, '2026-01-22 09:52:16', '2026-01-22 09:52:21');

-- --------------------------------------------------------

--
-- Table structure for table `log`
--

CREATE TABLE `log` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `user_role` varchar(50) DEFAULT NULL,
  `aksi` varchar(100) NOT NULL,
  `tabel` varchar(100) DEFAULT NULL,
  `id_data` bigint(20) UNSIGNED DEFAULT NULL,
  `data_lama` text DEFAULT NULL,
  `data_baru` text DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `lokasi`
--

CREATE TABLE `lokasi` (
  `id` int(10) UNSIGNED NOT NULL,
  `nama` varchar(191) NOT NULL,
  `penanggung_jawab` varchar(191) DEFAULT NULL,
  `foto_penanggung_jawab` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `lokasi`
--

INSERT INTO `lokasi` (`id`, `nama`, `penanggung_jawab`, `foto_penanggung_jawab`, `keterangan`, `created_at`, `updated_at`) VALUES
(2, 'Lab', 'sassuolo bambang yudoyono', '1769019287_Atlas Special Gunpowder Green Tea.jpeg', 'Lab komputer', '2026-01-20 23:56:40', '2026-01-21 11:14:47'),
(3, 'gudang', 'adili fufufafa', '1769100382_Chief Operating Officer2.jpeg', 'gudang', '2026-01-22 09:46:22', '2026-01-22 09:46:57');

-- --------------------------------------------------------

--
-- Table structure for table `peminjaman`
--

CREATE TABLE `peminjaman` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `peminjam_id` bigint(20) UNSIGNED NOT NULL,
  `peminjam_role` varchar(50) NOT NULL,
  `setuju_id` bigint(20) UNSIGNED DEFAULT NULL,
  `setuju_role` varchar(50) DEFAULT NULL,
  `barang_id` bigint(20) UNSIGNED NOT NULL,
  `barang_nama` varchar(191) NOT NULL,
  `jumlah` int(11) DEFAULT 1,
  `tanggal_pinjam` date NOT NULL,
  `tanggal_kembali` date DEFAULT NULL,
  `harus_kembali` date NOT NULL,
  `status` enum('pending','disetujui','dipinjam','dikembalikan','ditolak') NOT NULL DEFAULT 'pending',
  `alasan` text DEFAULT NULL,
  `aturan_id` int(10) UNSIGNED DEFAULT NULL,
  `denda` decimal(10,2) DEFAULT 0.00,
  `kondisi_pinjam` varchar(191) DEFAULT 'Baik',
  `kondisi_kembali` varchar(191) DEFAULT NULL,
  `qr_verifikasi` varchar(255) DEFAULT NULL,
  `qr_code_short` varchar(4) DEFAULT NULL,
  `qr_validated_at` timestamp NULL DEFAULT NULL,
  `sarpras_status` varchar(50) DEFAULT NULL,
  `sarpras_ref` varchar(100) DEFAULT NULL,
  `sarpras_response` text DEFAULT NULL,
  `sarpras_checked_at` timestamp NULL DEFAULT NULL,
  `catatan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `peminjaman`
--

INSERT INTO `peminjaman` (`id`, `kode`, `peminjam_id`, `peminjam_role`, `setuju_id`, `setuju_role`, `barang_id`, `barang_nama`, `jumlah`, `tanggal_pinjam`, `tanggal_kembali`, `harus_kembali`, `status`, `alasan`, `aturan_id`, `denda`, `kondisi_pinjam`, `kondisi_kembali`, `qr_verifikasi`, `qr_code_short`, `qr_validated_at`, `sarpras_status`, `sarpras_ref`, `sarpras_response`, `sarpras_checked_at`, `catatan`, `created_at`, `updated_at`) VALUES
(15, 'PMJ-1769098846', 1, 'siswa', 2, 'guru', 7, 'Laptop', 1, '2026-01-22', '2026-01-22', '2026-01-22', 'dikembalikan', NULL, NULL, 0.00, 'Baik', 'Baik', 'uploads/qr_verifikasi/PMJ-1769098846-7466.svg', '7466', '2026-01-22 09:20:49', NULL, NULL, NULL, NULL, 'sss', '2026-01-22 09:20:46', '2026-01-22 09:23:18'),
(16, 'PMJ-1769099055', 2, 'siswa', 2, 'guru', 8, 'Komputer Dell', 1, '2026-01-22', '2026-01-23', '2026-01-23', 'dikembalikan', NULL, NULL, 0.00, 'Baik', 'Baik', 'uploads/qr_verifikasi/PMJ-1769099055-9286.svg', '9286', '2026-01-22 09:24:18', NULL, NULL, NULL, NULL, 'sssss', '2026-01-22 09:24:15', '2026-01-22 09:25:07'),
(17, 'PMJ-1769148235', 1, 'siswa', 1, 'guru', 7, 'Laptop', 1, '2026-01-23', '2026-01-24', '2026-01-24', 'dikembalikan', NULL, NULL, 0.00, 'Baik', 'Baik syekali', 'uploads/qr_verifikasi/PMJ-1769148234-5181.svg', '5181', '2026-01-22 23:04:39', NULL, NULL, NULL, NULL, 'sssss', '2026-01-22 23:03:55', '2026-01-22 23:08:56'),
(18, 'PMJ-1769148834', 1, 'siswa', 1, 'guru', 7, 'Laptop', 1, '2026-01-23', '2026-01-24', '2026-01-24', 'ditolak', NULL, NULL, 0.00, 'Baik', NULL, 'uploads/qr_verifikasi/PMJ-1769148834-5256.svg', '5256', '2026-01-23 06:53:34', NULL, NULL, NULL, NULL, 'sasdas', '2026-01-22 23:13:54', '2026-01-23 06:53:55');

-- --------------------------------------------------------

--
-- Table structure for table `penggunaan_bahan`
--

CREATE TABLE `penggunaan_bahan` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode` varchar(100) DEFAULT NULL,
  `siswa_id` bigint(20) UNSIGNED DEFAULT NULL,
  `guru_id` bigint(20) UNSIGNED DEFAULT NULL,
  `bahan_id` bigint(20) UNSIGNED NOT NULL,
  `bahan_nama` varchar(191) NOT NULL,
  `jumlah` decimal(10,2) DEFAULT 0.00,
  `tanggal` date NOT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `penggunaan_bahan`
--

INSERT INTO `penggunaan_bahan` (`id`, `kode`, `siswa_id`, `guru_id`, `bahan_id`, `bahan_nama`, `jumlah`, `tanggal`, `keterangan`, `created_at`, `updated_at`) VALUES
(1, 'PBH-20260122152800', 1, 2, 1, 'kabel', 1.00, '2026-01-22', 'ddadada', '2026-01-22 08:28:00', '2026-01-22 08:28:00');

-- --------------------------------------------------------

--
-- Table structure for table `siswa`
--

CREATE TABLE `siswa` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `nis` varchar(50) DEFAULT NULL,
  `nama` varchar(191) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password` text NOT NULL,
  `kelas` varchar(50) DEFAULT NULL,
  `jurusan` varchar(100) DEFAULT 'TKJT',
  `telepon` varchar(50) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `siswa`
--

INSERT INTO `siswa` (`id`, `nis`, `nama`, `email`, `password`, `kelas`, `jurusan`, `telepon`, `foto`, `created_at`, `updated_at`) VALUES
(1, '4353453454', 'siswaaaaaaa', 'andi@student.local', 'siswa123', '12', 'TKJT', '5465464', 'uploads/foto_siswa/siswa_1_1769174348.jpeg', NULL, '2026-01-23 06:19:08'),
(2, '435425243', 'aknula', 'rina@student.local', 'siswa456', '12', 'TKJT', '46456546', 'uploads/foto_siswa/siswa_1769066931_1c1HaU.jpeg', '2026-01-22 00:28:51', '2026-01-22 10:04:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `api_sarpras`
--
ALTER TABLE `api_sarpras`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `aturan`
--
ALTER TABLE `aturan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `bahan`
--
ALTER TABLE `bahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `guru`
--
ALTER TABLE `guru`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `log`
--
ALTER TABLE `log`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `lokasi`
--
ALTER TABLE `lokasi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `peminjaman`
--
ALTER TABLE `peminjaman`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `penggunaan_bahan`
--
ALTER TABLE `penggunaan_bahan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `siswa`
--
ALTER TABLE `siswa`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `api_sarpras`
--
ALTER TABLE `api_sarpras`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `aturan`
--
ALTER TABLE `aturan`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `bahan`
--
ALTER TABLE `bahan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `guru`
--
ALTER TABLE `guru`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `log`
--
ALTER TABLE `log`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `lokasi`
--
ALTER TABLE `lokasi`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `peminjaman`
--
ALTER TABLE `peminjaman`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `penggunaan_bahan`
--
ALTER TABLE `penggunaan_bahan`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `siswa`
--
ALTER TABLE `siswa`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

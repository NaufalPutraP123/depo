-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 19, 2022 at 02:11 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pos_cafev2`
--

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE `customer` (
  `id` int(11) NOT NULL,
  `kode_customer` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `created_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `kategori` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `kategori`) VALUES
(1, 'Uncategory');

-- --------------------------------------------------------

--
-- Table structure for table `keranjang`
--

CREATE TABLE `keranjang` (
  `id` int(11) NOT NULL,
  `id_menu` int(11) NOT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `login_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan_lainnya`
--

CREATE TABLE `keuangan_lainnya` (
  `id` int(11) NOT NULL,
  `no_ledger` varchar(255) DEFAULT NULL,
  `nama_urusan` varchar(255) DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `jumlah_masuk` int(11) NOT NULL,
  `jumlah_keluar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `keuangan_ledger`
--

CREATE TABLE `keuangan_ledger` (
  `id` int(11) NOT NULL,
  `no_ledger` varchar(255) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `jenis` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `login`
--

CREATE TABLE `login` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `nama_user` varchar(255) NOT NULL,
  `alamat` text NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `telepon` varchar(255) NOT NULL,
  `foto` text NOT NULL,
  `level` varchar(255) DEFAULT NULL,
  `tgl_bergabung` varchar(255) NOT NULL,
  `deleted_at` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `login`
--

INSERT INTO `login` (`id`, `user`, `pass`, `nama_user`, `alamat`, `email`, `telepon`, `foto`, `level`, `tgl_bergabung`, `deleted_at`) VALUES
(5, 'adminkasir', '$2y$10$XUrgFfZ6Y1b0UeaYnYLJbu2lU51cR8r8DwWI.ISmtKYfAqntwCXT2', 'Admin Toko', 'Bekasi', 'dummy@gmail.com', '081234567890', 'user_1636966029.png', 'Admin', '2019-09-11', '2021-07-27 12:25:48'),
(6, 'kasir', '$2y$10$eHrfr.9BhSJorN1iAqR0BOJ5W1rOnu5DHutn5eDXFMep5A9Fr3V6e', 'Fauzan Falah', 'Bekasi', 'dummy2@gmail.com', '081234567890', 'user_1636966560.png', 'Admin', '2021-10-04', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `id_kategori` int(11) NOT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga_pokok` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `stok` int(11) NOT NULL,
  `stok_minim` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `id_kategori`, `kode_menu`, `nama`, `harga_pokok`, `harga_jual`, `stok`, `stok_minim`, `keterangan`, `gambar`, `created_at`) VALUES
(1, 1, 'P0001', 'Ayam Bakar', 8000, 15000, 100, 3, 'Percik', '-', '2021-12-16 12:34:06'),
(3, 1, 'P001', 'Teh', 2000, 3000, 34, 1, NULL, '-', '2022-02-13 21:03:05');

-- --------------------------------------------------------

--
-- Table structure for table `menu_stok`
--

CREATE TABLE `menu_stok` (
  `id` int(11) NOT NULL,
  `menu_id` int(11) NOT NULL,
  `stok_awal` int(11) NOT NULL,
  `stok_akhir` int(11) NOT NULL,
  `date` date NOT NULL,
  `periode` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `profil_toko`
--

CREATE TABLE `profil_toko` (
  `id` int(11) NOT NULL,
  `nama_toko` varchar(255) NOT NULL,
  `alamat_toko` text NOT NULL,
  `telepon_toko` varchar(25) DEFAULT NULL,
  `email_toko` varchar(255) DEFAULT NULL,
  `pemilik_toko` varchar(255) DEFAULT NULL,
  `website_toko` varchar(255) DEFAULT NULL,
  `tgl_update` datetime DEFAULT NULL,
  `os` int(11) DEFAULT NULL,
  `print` int(11) DEFAULT NULL,
  `print_default` int(11) DEFAULT NULL,
  `driver` varchar(255) DEFAULT NULL,
  `footer_struk` varchar(255) DEFAULT NULL,
  `pajak` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `diskon` int(11) NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profil_toko`
--

INSERT INTO `profil_toko` (`id`, `nama_toko`, `alamat_toko`, `telepon_toko`, `email_toko`, `pemilik_toko`, `website_toko`, `tgl_update`, `os`, `print`, `print_default`, `driver`, `footer_struk`, `pajak`, `voucher`, `diskon`, `user_id`) VALUES
(1, 'Codekop Cafe', 'Bekasi', '081234567890', 'halo@gmail.com', 'Anang', 'sample.com', '2021-03-07 05:25:19', 1, 1, 1, 'logo_1652604576.jpeg', 'TERIMA KASIH\r\nATAS KUNJUNGAN ANDA', 1, 0, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` int(11) NOT NULL,
  `no_bon` varchar(255) DEFAULT NULL,
  `kasir_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `atas_nama` varchar(255) DEFAULT NULL,
  `pesanan` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `diskon` int(11) NOT NULL,
  `pajak` int(11) NOT NULL,
  `voucher` int(11) NOT NULL,
  `grandmodal` int(11) NOT NULL,
  `grandtotal` int(11) NOT NULL,
  `total_qty` int(11) NOT NULL,
  `dibayar` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `transaksi_produk`
--

CREATE TABLE `transaksi_produk` (
  `id` int(11) NOT NULL,
  `no_bon` varchar(255) DEFAULT NULL,
  `kode_menu` varchar(255) DEFAULT NULL,
  `kategori` varchar(255) DEFAULT NULL,
  `nama_menu` varchar(255) DEFAULT NULL,
  `qty` int(11) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL,
  `keterangan` text DEFAULT NULL,
  `pesan` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `date` date DEFAULT NULL,
  `periode` varchar(255) DEFAULT NULL,
  `year` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customer`
--
ALTER TABLE `customer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keranjang`
--
ALTER TABLE `keranjang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keuangan_lainnya`
--
ALTER TABLE `keuangan_lainnya`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `keuangan_ledger`
--
ALTER TABLE `keuangan_ledger`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `menu_stok`
--
ALTER TABLE `menu_stok`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profil_toko`
--
ALTER TABLE `profil_toko`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transaksi_produk`
--
ALTER TABLE `transaksi_produk`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customer`
--
ALTER TABLE `customer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `keranjang`
--
ALTER TABLE `keranjang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=219;

--
-- AUTO_INCREMENT for table `keuangan_lainnya`
--
ALTER TABLE `keuangan_lainnya`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `keuangan_ledger`
--
ALTER TABLE `keuangan_ledger`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `login`
--
ALTER TABLE `login`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `menu_stok`
--
ALTER TABLE `menu_stok`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `profil_toko`
--
ALTER TABLE `profil_toko`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transaksi_produk`
--
ALTER TABLE `transaksi_produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

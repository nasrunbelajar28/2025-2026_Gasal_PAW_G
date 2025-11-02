-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 02 Nov 2025 pada 06.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `store`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) DEFAULT NULL,
  `telp` varchar(12) DEFAULT NULL,
  `alamat` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id`, `nama`, `telp`, `alamat`) VALUES
(1, 'PT Maju Jaya Sentosa', '081123456780', 'Jl. Industri No. 1, Jakarta'),
(2, 'CV Sembada Makmur', '085678901231', 'Jl. Merdeka No. 5, Bandung'),
(3, 'Toko Bahan Makanan Sari Rasa', '087800112232', 'Jl. Cipta No. 10, Surabaya'),
(4, 'Distributor Elektronik Cepat', '081233445563', 'Jl. Gatot Subroto No. 22, Semarang'),
(5, 'Mitra Abadi Sejahtera', '085998765444', 'Jl. Pahlawan No. 20, Yogyakarta'),
(6, 'PT Surya Kencana', '082155667785', 'Jl. Sudirman No. 3A, Medan'),
(7, 'Global Food Supply', '081300998876', 'Jl. Asia Afrika No. 45, Palembang'),
(8, 'UD Sumber Rejeki', '087711223347', 'Jl. Veteran No. 7, Makassar'),
(9, 'Pabrik Peralatan Rumah', '089655443328', 'Jl. Rajawali No. 12, Denpasar'),
(10, 'Importir Komoditi Utama', '081577889909', 'Jl. Kartini No. 101, Bekasi');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

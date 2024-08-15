-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Agu 2024 pada 04.51
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
-- Database: `spnaivebayes1`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayes_admin`
--

CREATE TABLE `bayes_admin` (
  `user` varchar(16) NOT NULL,
  `pass` varchar(16) NOT NULL,
  `level` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bayes_admin`
--

INSERT INTO `bayes_admin` (`user`, `pass`, `level`) VALUES
('admin', 'admin', 'admin'),
('user', 'user', 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayes_aturan`
--

CREATE TABLE `bayes_aturan` (
  `ID` int(11) NOT NULL,
  `kode_penyakit` varchar(16) NOT NULL,
  `kode_gejala` varchar(16) NOT NULL,
  `nilai` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bayes_aturan`
--

INSERT INTO `bayes_aturan` (`ID`, `kode_penyakit`, `kode_gejala`, `nilai`) VALUES
(39, 'B', '1', 0.7),
(40, 'D', '1', 0.7),
(41, 'F', '1', 0.6),
(42, 'A', '2', 0.9),
(43, 'F', '2', 0.5),
(44, 'B', '2', 0.1),
(45, 'F', '3', 0.75),
(46, 'B', '3', 0.7),
(47, 'F', '4', 0.2),
(48, 'A', '6', 0.95),
(49, 'D', '2', 0.2),
(50, 'F', '5', 0.9),
(51, 'D', '3', 0.2),
(52, 'F', '6', 0.3),
(53, 'A', '1', 0.2),
(54, 'A', '3', 0.2),
(55, 'A', '4', 0.2),
(56, 'A', '5', 0.2),
(57, 'A', '7', 0.2),
(58, 'B', '4', 0.9),
(59, 'B', '5', 0.3),
(60, 'B', '6', 0.3),
(61, 'B', '7', 0.2),
(62, 'D', '4', 0.2),
(63, 'D', '5', 0.2),
(64, 'D', '6', 0.7),
(65, 'D', '7', 0.9),
(66, 'F', '7', 0.5),
(67, 'A', 'T01', 0.889),
(68, 'A', 'B05', 0.889),
(69, 'B', 'D02', 0.727),
(70, 'B', 'T03', 0),
(71, 'B', 'D01', 1),
(72, 'C', 'D10', 1),
(73, 'D', 'D04', 0.5),
(74, 'D', 'B08', 0),
(75, 'D', 'D03', 0.667),
(76, 'D', 'D14', 0.833),
(77, 'D', 'D11', 0.5),
(78, 'D', 'D05', 0.167),
(79, 'E', 'D13', 1),
(80, 'E', 'B03', 1),
(81, 'E', 'D12', 0.75),
(82, 'E', 'D05', 0.875),
(83, 'E', 'B01', 0.75),
(84, 'E', 'D07', 0.625),
(85, 'E', 'D06', 0.625),
(86, 'E', 'B02', 0.875),
(87, 'F', 'D08', 0.667),
(88, 'F', 'D09', 1),
(89, 'G', 'D15', 1),
(90, 'G', 'D16', 1),
(91, 'G', 'D17', 1),
(92, 'H', 'B04', 0.5),
(93, 'H', 'T02', 0.833),
(94, 'H', 'B06', 0.167),
(95, 'H', 'B07', 0.833);

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayes_gejala`
--

CREATE TABLE `bayes_gejala` (
  `kode_gejala` varchar(16) NOT NULL,
  `nama_gejala` varchar(64) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bayes_gejala`
--

INSERT INTO `bayes_gejala` (`kode_gejala`, `nama_gejala`) VALUES
('B01', 'Batang seperti terpotong pisau'),
('B02', 'Ruas tebu bengkak'),
('B03', 'Ruas batang bengkok dan sedikit gepeng'),
('B04', 'Membusuknya akar dan pangkal batang'),
('B05', 'Warna jingga kemerahan pada berkas pembuluh batang tebu'),
('B06', 'Tampak garis dan warna hitam jika pangkal batang di belah'),
('B07', 'Tunggul tebu di tumbuhi stroma jamur abu tua dengan ujung putih'),
('B08', 'Batang mati'),
('D01', 'Daun berubah bentuk menyerupai cambuk'),
('D02', 'Daun mengecil seperti rumput'),
('D03', 'Daun tidak berwarna karena klorofil hilang'),
('D04', 'Daun mengering'),
('D05', 'Daun menggulung'),
('D06', 'Daun sobek seperti tangga'),
('D07', 'Bintik klorosis pada daun'),
('D08', 'Noda oval memanjang 1-5mm X 4-18mm pada daun'),
('D09', 'Pusat noda berwana pucat dan tepi berwarna coklat'),
('D10', 'Noda / garis pola Mosaik berwarna hijau muda / kuning pada daun'),
('D11', 'Pucuk daun yang terlipat - lipat'),
('D12', 'Pembusukan dari daun ke batang'),
('D13', 'Pertumbuhan pelepah daun terhambat'),
('D14', 'Seluruh daun bergaris hijau dan putih'),
('D15', 'Noda sempit memanjang berwarna kuning pada daun'),
('D16', 'Kematian jaringan daun pada bagian tengah '),
('D17', 'Lesi berubah warna menjadi warna jerami kering'),
('T01', 'Tanaman tampak kerdil'),
('T02', 'Tanaman menguning dan layu'),
('T03', 'Pertumbuhan terhambat');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayes_penyakit`
--

CREATE TABLE `bayes_penyakit` (
  `kode_penyakit` varchar(16) NOT NULL,
  `nama_penyakit` varchar(255) NOT NULL,
  `bobot` double NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bayes_penyakit`
--

INSERT INTO `bayes_penyakit` (`kode_penyakit`, `nama_penyakit`, `bobot`, `keterangan`) VALUES
('A', 'Pembuluh / Ratoon Stunting Disease', 0.18, 'Keterangan'),
('B', 'Luka Api', 0.22, ''),
('C', 'Mosaik', 0.08, ''),
('D', 'Blendok', 0.12, ''),
('E', 'Pokkahbung', 0.16, ''),
('F', 'Noda Cincin', 0.06, ''),
('G', 'Daun Hangus', 0.06, ''),
('H', 'Busuk Akar dan Pangkal Batang', 0.12, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayes_user`
--

CREATE TABLE `bayes_user` (
  `id_user` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `level` varchar(255) NOT NULL DEFAULT 'user',
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bayes_user`
--

INSERT INTO `bayes_user` (`id_user`, `user`, `pass`, `email`, `nama`, `level`, `alamat`) VALUES
(1, 'user', 'user', 'user@mail.com', 'Nama User', 'user', ''),
(2, 'pakar', 'pakar', 'pakar@mail.com', 'Nama Pakar', 'pakar', '');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bayes_admin`
--
ALTER TABLE `bayes_admin`
  ADD PRIMARY KEY (`user`);

--
-- Indeks untuk tabel `bayes_aturan`
--
ALTER TABLE `bayes_aturan`
  ADD PRIMARY KEY (`ID`);

--
-- Indeks untuk tabel `bayes_gejala`
--
ALTER TABLE `bayes_gejala`
  ADD PRIMARY KEY (`kode_gejala`);

--
-- Indeks untuk tabel `bayes_penyakit`
--
ALTER TABLE `bayes_penyakit`
  ADD PRIMARY KEY (`kode_penyakit`);

--
-- Indeks untuk tabel `bayes_user`
--
ALTER TABLE `bayes_user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bayes_aturan`
--
ALTER TABLE `bayes_aturan`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT untuk tabel `bayes_user`
--
ALTER TABLE `bayes_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

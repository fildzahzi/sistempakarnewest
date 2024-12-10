-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 10 Des 2024 pada 06.47
-- Versi server: 10.11.10-MariaDB
-- Versi PHP: 7.2.34

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `u659182449_spnaivebayes1`
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
(69, 'B', 'D02', 0.727),
(71, 'B', 'D01', 1),
(72, 'C', 'D10', 1),
(73, 'D', 'D04', 0.5),
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
(95, 'H', 'B07', 0.833),
(96, 'A', 'B05', 0.889);

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
('T02', 'Tanaman menguning dan layu');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayes_konsultasi`
--

CREATE TABLE `bayes_konsultasi` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `varietas` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `penyakit` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nilai_akurasi` decimal(10,4) DEFAULT NULL,
  `penanganan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `tanggal` datetime DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bayes_konsultasi`
--

INSERT INTO `bayes_konsultasi` (`id`, `nama`, `varietas`, `penyakit`, `nilai_akurasi`, `penanganan`, `tanggal`) VALUES
(80, 'Fildzah Zata', 'PS864', 'Pokkahbung', 0.5457, 'Pengendalian dengan menanam varietas tahan.', '2024-09-23 15:57:17'),
(85, 'mazaya fadiah iffah', 'Cening', 'Pembuluh / Ratoon Stunting Disease', 0.4156, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-09-24 09:16:56'),
(101, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Luka Api', 0.4817, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-18 18:01:37'),
(102, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:09:24'),
(103, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:30:16'),
(104, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:30:21'),
(105, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:30:23'),
(106, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:31:34'),
(107, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:32:06'),
(108, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:32:09'),
(109, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:32:34'),
(110, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:32:37'),
(111, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:33:26'),
(112, 'Mazaya Fadiah Iffah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-18 18:33:39'),
(113, 'lily', 'Bulu Lawang', 'Pokkahbung', 0.9332, 'Pengendalian dengan menanam varietas tahan, sanitasi kebun, penggunaan fungisida dengan bahan aktif tembaga.', '2024-10-20 08:38:32'),
(114, 'Fildzah zata', 'Cening', 'Blendok', 0.4068, 'Pengendalian penyakit Blendok dapat dilakukan dengan cara menanam varietas yang tahan terhadap serangannya, membinasakan tebu yang sudah terinfeksi, dan selalu menggunakan parang atau pisau pemotong stek tebu yang steril, Pemakaian benih yang berasal dari tanaman yang sehat yang diperoleh \r\ndari perawatan bagal dengan perlakuan air panas (perendaman bibit dengan air mengalir selama 48 jam dilanjutkan dengan perawatan air panas suhu 50ºC \r\nselama 2 jam), penggunaan desinfektan pada pisau pemotong tebu dengan Lysol 20%.', '2024-10-21 12:53:22'),
(115, 'Mohammad Nurwahyudi ', 'Bulu Lawang', 'Luka Api', 0.3680, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-22 02:26:22'),
(116, 'Wahyu', 'PS862', 'Pokkahbung', 0.6001, 'Pengendalian dengan menanam varietas tahan, sanitasi kebun, penggunaan fungisida dengan bahan aktif tembaga.', '2024-10-22 03:02:46'),
(117, 'Zakiki Syahrindra ', 'PS864', 'Pokkahbung', 0.6668, 'Pengendalian dengan menanam varietas tahan, sanitasi kebun, penggunaan fungisida dengan bahan aktif tembaga.', '2024-10-22 03:05:57'),
(118, 'Wahyu 2', 'PS862', 'Luka Api', 0.4804, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-22 03:16:08'),
(119, 'Wafiqul azizah', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4165, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-22 03:40:08'),
(120, 'Sri Suharsono, S.Pd, S.Kom', 'PS862', 'Luka Api', 0.3426, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-22 10:30:29'),
(121, 'Lailun Nasiah', 'PS864', 'Luka Api', 0.4849, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 00:28:12'),
(122, 'Sri Andonowarih. SPd', 'PS864', 'Luka Api', 0.3459, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 00:28:35'),
(123, 'Nurul Lailiah', 'Bulu Lawang', 'Luka Api', 0.4929, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 00:37:39'),
(124, 'Welly ', 'W19', 'Pembuluh / Ratoon Stunting Disease', 0.5390, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 00:37:46'),
(125, 'Sulikanah', 'Bongkeng', 'Pembuluh / Ratoon Stunting Disease', 0.4445, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 00:39:25'),
(126, 'ELIS SETIYANINGSIH', 'PS864', 'Pembuluh / Ratoon Stunting Disease', 0.4000, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 00:42:00'),
(127, 'SULIKANAH S.Pd', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4210, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 00:43:37'),
(128, 'Wiji hartini', 'PS864', 'Luka Api', 0.5067, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 00:44:36'),
(129, 'Fennisa Fadillawati', 'PS862', 'Pembuluh / Ratoon Stunting Disease', 0.5039, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 00:47:16'),
(130, 'NIK', 'PS862', 'Pembuluh / Ratoon Stunting Disease', 0.4800, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 01:03:49'),
(131, 'Umaiyah', 'PS862', 'Luka Api', 0.3014, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 01:05:21'),
(132, 'Mariana', 'Cening', 'Luka Api', 0.5428, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 02:00:14'),
(133, 'Annisa rahma aulia', 'Bulu Lawang', 'Luka Api', 0.3571, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 03:27:32'),
(134, 'Jewad', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.4055, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 03:28:24'),
(135, 'Abdul', 'PS862', 'Pokkahbung', 0.3637, 'Pengendalian dengan menanam varietas tahan, sanitasi kebun, penggunaan fungisida dengan bahan aktif tembaga.', '2024-10-23 04:00:05'),
(136, 'Syukri Arizal ', 'Bulu Lawang', 'Pembuluh / Ratoon Stunting Disease', 0.3637, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-23 05:39:48'),
(137, 'Verty', 'Bulu Lawang', 'Luka Api', 0.3730, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 09:48:08'),
(138, 'Sugeng', 'PS862', 'Luka Api', 0.5000, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-23 16:17:24'),
(139, 'izzy', 'Bulu Lawang', 'Busuk Akar dan Pangkal Batang', 0.4165, 'Pengendalian dengan menanam varietas tahan, dan pemberian pupuk hijau dan eradikasi.', '2024-10-24 17:02:19'),
(140, 'testing', 'PS862', 'Luka Api', 1.0000, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-24 17:35:16'),
(141, 'testing', 'PS862', 'Luka Api', 0.5000, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-24 17:35:51'),
(142, 'testing', 'PS862', 'Pembuluh / Ratoon Stunting Disease', 0.4211, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-24 17:36:34'),
(143, 'testing', 'PS862', 'Mosaik', 0.7059, 'Pengendalian dengan menanam varietas tahan, dan pemilihan benih yang sehat, eradiksi (pemusnahan rumpun sakit), sanitasi kebun.', '2024-10-24 17:37:50'),
(144, 'testing', 'PS862', 'Blendok', 1.0000, 'Pengendalian penyakit Blendok dapat dilakukan dengan cara menanam varietas yang tahan terhadap serangannya, membinasakan tebu yang sudah terinfeksi, dan selalu menggunakan parang atau pisau pemotong stek tebu yang steril, Pemakaian benih yang berasal dari tanaman yang sehat yang diperoleh \r\ndari perawatan bagal dengan perlakuan air panas (perendaman bibit dengan air mengalir selama 48 jam dilanjutkan dengan perawatan air panas suhu 50ºC \r\nselama 2 jam), penggunaan desinfektan pada pisau pemotong tebu dengan Lysol 20%.', '2024-10-24 17:38:59'),
(145, 'testing', 'PS862', 'Pokkahbung', 1.0000, 'Pengendalian dengan menanam varietas tahan, sanitasi kebun, penggunaan fungisida dengan bahan aktif tembaga.', '2024-10-24 17:40:52'),
(146, 'testing', 'PS862', 'Pembuluh / Ratoon Stunting Disease', 1.0000, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.', '2024-10-24 17:41:40'),
(147, 'testing', 'PS862', 'Mosaik', 1.0000, 'Pengendalian dengan menanam varietas tahan, dan pemilihan benih yang sehat, eradiksi (pemusnahan rumpun sakit), sanitasi kebun.', '2024-10-24 17:41:59'),
(148, 'testing', 'PS862', 'Noda Cincin', 0.5456, 'Pengendalian dengan menanam varietas tahan.', '2024-10-24 17:42:49'),
(149, 'testing', 'PS862', 'Blendok', 1.0000, 'Pengendalian penyakit Blendok dapat dilakukan dengan cara menanam varietas yang tahan terhadap serangannya, membinasakan tebu yang sudah terinfeksi, dan selalu menggunakan parang atau pisau pemotong stek tebu yang steril, Pemakaian benih yang berasal dari tanaman yang sehat yang diperoleh \r\ndari perawatan bagal dengan perlakuan air panas (perendaman bibit dengan air mengalir selama 48 jam dilanjutkan dengan perawatan air panas suhu 50ºC \r\nselama 2 jam), penggunaan desinfektan pada pisau pemotong tebu dengan Lysol 20%.', '2024-10-24 17:44:10'),
(150, 'testing', 'PS862', 'Luka Api', 1.0000, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-24 17:44:28'),
(151, 'testing', 'PS862', 'Mosaik', 1.0000, 'Pengendalian dengan menanam varietas tahan, dan pemilihan benih yang sehat, eradiksi (pemusnahan rumpun sakit), sanitasi kebun.', '2024-10-24 17:44:57'),
(152, 'testing', 'PS862', 'Pokkahbung', 0.9332, 'Pengendalian dengan menanam varietas tahan, sanitasi kebun, penggunaan fungisida dengan bahan aktif tembaga.', '2024-10-24 17:45:20'),
(153, 'testing', 'PS862', 'Luka Api', 1.0000, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-24 17:46:03'),
(154, 'testing', 'PS862', 'Luka Api', 0.5789, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-24 17:46:24'),
(155, 'testing', 'PS862', 'Busuk Akar dan Pangkal Batang', 1.0000, 'Pengendalian dengan menanam varietas tahan, dan pemberian pupuk hijau dan eradikasi.', '2024-10-24 17:46:48'),
(156, 'Dion Defindra Dinatha', 'Bulu Lawang', 'Luka Api', 0.3700, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-26 07:45:10'),
(157, 'mdsakjnaw', 'Cening', 'Luka Api', 0.6876, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-10-30 01:48:37'),
(158, 'amsjdhajsd', 'Cening', 'Luka Api', 1.0000, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.', '2024-11-08 04:22:43');

-- --------------------------------------------------------

--
-- Struktur dari tabel `bayes_konsultasi_detail`
--

CREATE TABLE `bayes_konsultasi_detail` (
  `id` int(11) NOT NULL,
  `konsultasi_id` int(11) NOT NULL,
  `kode_gejala` varchar(16) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `bayes_konsultasi_detail`
--

INSERT INTO `bayes_konsultasi_detail` (`id`, `konsultasi_id`, `kode_gejala`) VALUES
(251, 80, 'D06'),
(252, 80, 'B07'),
(253, 80, 'T02'),
(267, 85, 'D05'),
(268, 85, 'B01'),
(269, 85, 'B07'),
(270, 85, 'T01'),
(326, 101, 'D01'),
(327, 101, 'D15'),
(328, 101, 'D16'),
(329, 101, 'B06'),
(330, 101, 'B07'),
(331, 101, 'T01'),
(332, 102, 'D09'),
(333, 102, 'D15'),
(334, 102, 'D16'),
(335, 102, 'B05'),
(336, 102, 'T02'),
(337, 103, 'D09'),
(338, 103, 'D15'),
(339, 103, 'D16'),
(340, 103, 'B05'),
(341, 103, 'T02'),
(342, 104, 'D09'),
(343, 104, 'D15'),
(344, 104, 'D16'),
(345, 104, 'B05'),
(346, 104, 'T02'),
(347, 105, 'D09'),
(348, 105, 'D15'),
(349, 105, 'D16'),
(350, 105, 'B05'),
(351, 105, 'T02'),
(352, 106, 'D09'),
(353, 106, 'D15'),
(354, 106, 'D16'),
(355, 106, 'B05'),
(356, 106, 'T02'),
(357, 107, 'D09'),
(358, 107, 'D15'),
(359, 107, 'D16'),
(360, 107, 'B05'),
(361, 107, 'T02'),
(362, 108, 'D09'),
(363, 108, 'D15'),
(364, 108, 'D16'),
(365, 108, 'B05'),
(366, 108, 'T02'),
(367, 109, 'D09'),
(368, 109, 'D15'),
(369, 109, 'D16'),
(370, 109, 'B05'),
(371, 109, 'T02'),
(372, 110, 'D09'),
(373, 110, 'D15'),
(374, 110, 'D16'),
(375, 110, 'B05'),
(376, 110, 'T02'),
(377, 111, 'D09'),
(378, 111, 'D15'),
(379, 111, 'D16'),
(380, 111, 'B05'),
(381, 111, 'T02'),
(382, 112, 'D09'),
(383, 112, 'D15'),
(384, 112, 'D16'),
(385, 112, 'B05'),
(386, 112, 'T02'),
(387, 113, 'B02'),
(388, 113, 'B04'),
(389, 113, 'B06'),
(390, 114, 'D03'),
(391, 114, 'D08'),
(392, 114, 'D16'),
(393, 114, 'D17'),
(394, 114, 'B06'),
(395, 114, 'T02'),
(396, 115, 'D02'),
(397, 115, 'D06'),
(398, 115, 'D07'),
(399, 115, 'D09'),
(400, 115, 'D13'),
(401, 115, 'D17'),
(402, 115, 'B02'),
(403, 115, 'B07'),
(404, 116, 'D04'),
(405, 116, 'D05'),
(406, 116, 'B07'),
(407, 116, 'T02'),
(408, 117, 'D06'),
(409, 117, 'B04'),
(410, 117, 'T02'),
(411, 118, 'D01'),
(412, 118, 'D05'),
(413, 118, 'D06'),
(414, 118, 'D07'),
(415, 118, 'B02'),
(416, 118, 'B04'),
(417, 118, 'B06'),
(418, 118, 'T01'),
(419, 119, 'D06'),
(420, 119, 'D09'),
(421, 119, 'D11'),
(422, 119, 'B02'),
(423, 119, 'B05'),
(424, 119, 'B06'),
(425, 119, 'T02'),
(426, 120, 'D01'),
(427, 120, 'D04'),
(428, 120, 'B01'),
(429, 120, 'B05'),
(430, 120, 'T01'),
(431, 120, 'T02'),
(432, 121, 'D02'),
(433, 121, 'D03'),
(434, 121, 'D05'),
(435, 121, 'D07'),
(436, 121, 'D10'),
(437, 121, 'D13'),
(438, 121, 'B02'),
(439, 121, 'B03'),
(440, 122, 'D02'),
(441, 122, 'D05'),
(442, 122, 'D09'),
(443, 122, 'B02'),
(444, 122, 'T02'),
(445, 123, 'D01'),
(446, 123, 'D03'),
(447, 123, 'D07'),
(448, 123, 'D10'),
(449, 123, 'D12'),
(450, 123, 'B01'),
(451, 123, 'B04'),
(452, 123, 'B06'),
(453, 124, 'D04'),
(454, 124, 'D07'),
(455, 124, 'D11'),
(456, 124, 'B01'),
(457, 124, 'B05'),
(458, 124, 'B06'),
(459, 124, 'B07'),
(460, 124, 'T01'),
(461, 125, 'D11'),
(462, 125, 'B02'),
(463, 125, 'T01'),
(464, 126, 'D03'),
(465, 126, 'B03'),
(466, 126, 'T01'),
(467, 127, 'D03'),
(468, 127, 'B02'),
(469, 127, 'T01'),
(470, 128, 'D01'),
(471, 128, 'D03'),
(472, 128, 'D05'),
(473, 128, 'D07'),
(474, 128, 'D09'),
(475, 128, 'D11'),
(476, 128, 'D13'),
(477, 128, 'D16'),
(478, 129, 'D03'),
(479, 129, 'D09'),
(480, 129, 'B05'),
(481, 129, 'T01'),
(482, 130, 'D12'),
(483, 130, 'D13'),
(484, 130, 'D16'),
(485, 130, 'B02'),
(486, 130, 'B04'),
(487, 130, 'B06'),
(488, 130, 'T01'),
(489, 130, 'T02'),
(490, 131, 'D01'),
(491, 131, 'D04'),
(492, 131, 'D06'),
(493, 131, 'D09'),
(494, 131, 'D11'),
(495, 131, 'D17'),
(496, 131, 'B05'),
(497, 131, 'B07'),
(498, 132, 'D02'),
(499, 132, 'D03'),
(500, 132, 'D04'),
(501, 132, 'D06'),
(502, 132, 'D07'),
(503, 132, 'D08'),
(504, 132, 'B02'),
(505, 132, 'B03'),
(506, 133, 'D02'),
(507, 133, 'D05'),
(508, 133, 'D06'),
(509, 133, 'D12'),
(510, 133, 'B04'),
(511, 133, 'B05'),
(512, 133, 'T01'),
(513, 134, 'D06'),
(514, 134, 'D07'),
(515, 134, 'D10'),
(516, 134, 'B02'),
(517, 134, 'B03'),
(518, 134, 'B05'),
(519, 134, 'T02'),
(520, 135, 'D10'),
(521, 135, 'D14'),
(522, 135, 'B03'),
(523, 135, 'T02'),
(524, 136, 'D02'),
(525, 136, 'B01'),
(526, 136, 'T01'),
(527, 137, 'D01'),
(528, 137, 'D03'),
(529, 137, 'D04'),
(530, 137, 'D07'),
(531, 137, 'B02'),
(532, 137, 'B05'),
(533, 137, 'B07'),
(534, 137, 'T01'),
(535, 138, 'D01'),
(536, 138, 'D04'),
(537, 138, 'T01'),
(538, 139, 'D03'),
(539, 139, 'D16'),
(540, 139, 'T02'),
(541, 140, 'D01'),
(542, 141, 'D01'),
(543, 141, 'D04'),
(544, 141, 'T01'),
(545, 142, 'D02'),
(546, 142, 'D04'),
(547, 142, 'T01'),
(548, 143, 'D03'),
(549, 143, 'D10'),
(550, 143, 'D11'),
(551, 143, 'D14'),
(552, 144, 'D03'),
(553, 144, 'D14'),
(554, 145, 'D06'),
(555, 145, 'D12'),
(556, 145, 'D13'),
(557, 145, 'B01'),
(558, 145, 'B02'),
(559, 145, 'B03'),
(560, 146, 'B05'),
(561, 146, 'T01'),
(562, 147, 'D10'),
(563, 148, 'D09'),
(564, 148, 'D11'),
(565, 148, 'D14'),
(566, 149, 'D11'),
(567, 150, 'D01'),
(568, 151, 'D10'),
(569, 152, 'D05'),
(570, 152, 'D11'),
(571, 153, 'D01'),
(572, 153, 'D02'),
(573, 154, 'D01'),
(574, 154, 'T01'),
(575, 155, 'B07'),
(576, 155, 'T02'),
(577, 156, 'D02'),
(578, 156, 'D03'),
(579, 156, 'B04'),
(580, 156, 'B05'),
(581, 156, 'T01'),
(582, 156, 'T02'),
(583, 157, 'D01'),
(584, 157, 'D14'),
(585, 158, 'D01');

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
('A', 'Pembuluh / Ratoon Stunting Disease', 0.18, 'Sanitasi alat pertanian dan penanaman bahan tanam yang sehat, Pengendalian penyakit pembuluh dengan perawatan air panas 50°C selama 2 jam terhadap benih dapat mengembalikan hasil yang hilang sebesar +10% dan desinfeksi pisau pemotong bibit alat panen dengan larutan Lysol 20 %.'),
('B', 'Luka Api', 0.22, 'Pengendaliannya dengan cara penanaman varietas tahan, melakukan desinfeksi benih, yaitu dengan cara merendam benih tebu kedalam larutan pestisida berbahan aktif Triadimefon, atau secara mekanis dilakukan pemusnahan tanaman atau rumpun tebu yang berpenyakit secara benar dengan cara membungkus dengan plastik agar spora tidak menyebar dan kemudian dibawa keluar kebun kemudian ditimbun.'),
('C', 'Mosaik', 0.08, 'Pengendalian dengan menanam varietas tahan, dan pemilihan benih yang sehat, eradiksi (pemusnahan rumpun sakit), sanitasi kebun.'),
('D', 'Blendok', 0.12, 'Pengendalian penyakit Blendok dapat dilakukan dengan cara menanam varietas yang tahan terhadap serangannya, membinasakan tebu yang sudah terinfeksi, dan selalu menggunakan parang atau pisau pemotong stek tebu yang steril, Pemakaian benih yang berasal dari tanaman yang sehat yang diperoleh \r\ndari perawatan bagal dengan perlakuan air panas (perendaman bibit dengan air mengalir selama 48 jam dilanjutkan dengan perawatan air panas suhu 50ºC \r\nselama 2 jam), penggunaan desinfektan pada pisau pemotong tebu dengan Lysol 20%.'),
('E', 'Pokkahbung', 0.16, 'Pengendalian dengan menanam varietas tahan, sanitasi kebun, penggunaan fungisida dengan bahan aktif tembaga.'),
('F', 'Noda Cincin', 0.06, 'Pengendalian dengan menanam varietas tahan.'),
('G', 'Daun Hangus', 0.06, 'Pengendalian dengan menanam varietas tahan.'),
('H', 'Busuk Akar dan Pangkal Batang', 0.12, 'Pengendalian dengan menanam varietas tahan, dan pemberian pupuk hijau dan eradikasi.');

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
-- Indeks untuk tabel `bayes_konsultasi`
--
ALTER TABLE `bayes_konsultasi`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `bayes_konsultasi_detail`
--
ALTER TABLE `bayes_konsultasi_detail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `bayes_konsultasi_detail_konsultasi_id_foreign` (`konsultasi_id`),
  ADD KEY `bayes_konsultasi_detail_kode_gejala_foreign` (`kode_gejala`);

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
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT untuk tabel `bayes_konsultasi`
--
ALTER TABLE `bayes_konsultasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=159;

--
-- AUTO_INCREMENT untuk tabel `bayes_konsultasi_detail`
--
ALTER TABLE `bayes_konsultasi_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=586;

--
-- AUTO_INCREMENT untuk tabel `bayes_user`
--
ALTER TABLE `bayes_user`
  MODIFY `id_user` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bayes_konsultasi_detail`
--
ALTER TABLE `bayes_konsultasi_detail`
  ADD CONSTRAINT `bayes_konsultasi_detail_kode_gejala_foreign` FOREIGN KEY (`kode_gejala`) REFERENCES `bayes_gejala` (`kode_gejala`),
  ADD CONSTRAINT `bayes_konsultasi_detail_konsultasi_id_foreign` FOREIGN KEY (`konsultasi_id`) REFERENCES `bayes_konsultasi` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

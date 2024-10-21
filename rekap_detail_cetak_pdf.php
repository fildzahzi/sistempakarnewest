<?php
// Include TCPDF
require_once('tcpdf/tcpdf.php');

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "spnaivebayes1"; // Nama database yang sesuai
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi database
if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Inisialisasi objek TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Set informasi dokumen
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Pakar');
$pdf->SetTitle('Hasil Diagnosa');

// Hapus header dan footer default
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// Tambah halaman baru
$pdf->AddPage();

// Set font
$pdf->SetFont('helvetica', '', 12);

// Proses data yang dibutuhkan
$selected = isset($_GET["selected"]) ? (array) $_GET["selected"] : [];
if (empty($selected)) {
    die("Tidak ada gejala yang dipilih.");
}

// Query gejala yang dipilih
$query_gejala = "SELECT kode_gejala, nama_gejala FROM bayes_gejala WHERE kode_gejala IN ('" . implode("','", $selected) . "')";
$result_gejala = mysqli_query($koneksi, $query_gejala);

if (!$result_gejala) {
    die("Query gejala gagal: " . mysqli_error($koneksi));
}

session_start(); // Pastikan session dimulai

// Ambil data dari session
$nama_pengguna = isset($_SESSION['nama']) ? $_SESSION['nama'] : 'Nama Pengguna';
$varietas = isset($_SESSION['varietas']) ? $_SESSION['varietas'] : 'Varietas yang Dipilih';




$html = '<h1>Hasil Diagnosa</h1>';
$html .= '<p><strong>Nama Pengguna:</strong> ' . htmlspecialchars($nama_pengguna) . '</p>';
$html .= '<p><strong>Varietas:</strong> ' . htmlspecialchars($varietas) . '</p>';
$html .= '<h3>Gejala Terpilih</h3>';
$html .= '<table border="1" cellspacing="3" cellpadding="4">';
$html .= '<thead><tr><th>No</th><th>Nama Gejala</th></tr></thead>';
$no = 1;
$gejala = [];



while ($row = mysqli_fetch_assoc($result_gejala)) {
    $gejala[$row['kode_gejala']] = $row['nama_gejala'];
    $html .= '<tr><td>' . $no++ . '</td><td>' . $row['nama_gejala'] . '</td></tr>';
}
$html .= '</table>';

// Query penyakit
$query_penyakit = "SELECT * FROM bayes_penyakit ORDER BY kode_penyakit";
$result_penyakit = mysqli_query($koneksi, $query_penyakit);

if (!$result_penyakit) {
    die("Query penyakit gagal: " . mysqli_error($koneksi));
}

$penyakit = [];
while ($row = mysqli_fetch_assoc($result_penyakit)) {
    $penyakit[$row['kode_penyakit']] = $row;
}

function get_data($selected = array())
{
    global $koneksi; // Menggunakan koneksi database global
    $data = [];
    $query = "SELECT r.kode_penyakit, r.kode_gejala, r.nilai FROM bayes_aturan r WHERE r.kode_gejala IN ('" . implode("','", $selected) . "') ORDER BY r.kode_penyakit, r.kode_gejala";
    $result = mysqli_query($koneksi, $query);

    if (!$result) {
        die("Query get_data gagal: " . mysqli_error($koneksi));
    }

    while ($row = mysqli_fetch_assoc($result)) {
        $data[$row['kode_penyakit']][$row['kode_gejala']] = $row['nilai'];
    }
    return $data;
}

function bayes($data = array(), $bobot = array())
{
    $result = array();
    foreach ($data as $key => $val) {
        $result['kali'][$key] = $bobot[$key]['bobot'];
        foreach ($val as $k => $v) {
            $result['kali'][$key] *= $v;
        }
    }

    $result['total'] = array_sum($result['kali']);
    foreach ($result['kali'] as $key => $val) {
        $result['hasil'][$key] = $val / $result['total'];
    }

    return $result;
}

// Simulasikan fungsi get_data() dan bayes()
$data = get_data($selected);  // Pastikan fungsi ini ada dan berfungsi dengan benar
$bayes = bayes($data, $penyakit);  // Pastikan fungsi ini ada dan berfungsi dengan benar

$html .= '<h3>Hasil Analisa</h3>';
$html .= '<table border="1" cellspacing="3" cellpadding="4">';
$html .= '<thead><tr><th>Nama Penyakit</th><th>Bobot Penyakit</th><th>Gejala Dipilih</th><th>Bobot Aturan</th><th>Perkalian</th><th>Hasil</th></tr></thead>';

foreach ($data as $key => $val) {
    $html .= '<tr>';
    $html .= '<td rowspan="' . count($val) . '">' . $penyakit[$key]['nama_penyakit'] . '</td>';
    $html .= '<td rowspan="' . count($val) . '">' . $penyakit[$key]['bobot'] . '</td>';
    $html .= '<td>' . $gejala[key($val)] . '</td>';
    $html .= '<td>' . current($val) . '</td>';
    $html .= '<td rowspan="' . count($val) . '">' . round($bayes['kali'][$key], 4) . '</td>';
    $html .= '<td rowspan="' . count($val) . '">' . round($bayes['hasil'][$key], 4) . '</td>';
    $html .= '</tr>';

    unset($val[key($val)]);  // Hapus elemen pertama tanpa menghapus key

    foreach ($val as $k => $v) {
        $html .= '<tr><td>' . $gejala[$k] . '</td><td>' . $v . '</td></tr>';
    }
}

$html .= '<tr><td colspan="5">Total</td><td colspan="2">' . round($bayes['total'], 4) . '</td></tr>';
$html .= '</table>';

// Sorting hasil bayes
arsort($bayes['hasil']);
$html .= '<p>Hasil Terbesar Didapatkan oleh Penyakit = <strong>' . $penyakit[key($bayes['hasil'])]['nama_penyakit'] . '</strong></p>';
$html .= '<p><strong>Solusi Penanganan:</strong><br>' . nl2br($penyakit[key($bayes['hasil'])]['keterangan']) . '</p>';

// Tulis HTML ke dalam PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Set nama file PDF
$filename = "hasil_diagnosa.pdf";

// Output file PDF (download langsung)
$pdf->Output($filename, 'D'); // 'D' untuk download langsung, 'I' untuk membuka di browser

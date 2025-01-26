<?php
// Include TCPDF
require_once('tcpdf/tcpdf.php');

// Koneksi ke database
$host = "localhost";
$user = "u659182449_fildzahzata";
$pass = "Fildzaya911";
$db   = "u659182449_spnaivebayes1"; // Nama database yang sesuai
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

// Header Laporan
$html = '<h1 style="text-align: center;">Hasil Diagnosa Sistem</h1>';
$html .= '<p><strong>Nama Pengguna:</strong> ' . htmlspecialchars($nama_pengguna) . '</p>';
$html .= '<p><strong>Varietas:</strong> ' . htmlspecialchars($varietas) . '</p>';
$html .= '<h3>Gejala Terpilih</h3>';
$html .= '<table border="1" cellspacing="0" cellpadding="4" style="border-collapse:collapse; border:1px solid #000;">';
$html .= '<thead>
            <tr style="background-color:#B3B792; border:1px solid #000;">
                <th width="10%" style="border:1px solid #000;"><strong>No</strong></th>
                <th width="90%" style="border:1px solid #000;"><strong>Nama Gejala</strong></th>
            </tr>
            </thead>';
$no = 1;
$gejala = [];

while ($row = mysqli_fetch_assoc($result_gejala)) {
    $gejala[$row['kode_gejala']] = $row['nama_gejala'];
    $html .= '<tr>
                <td style="width:10%; text-align:center; border:1px solid #000;">' . $no++ . '</td>
                <td style="width:90%; text-align:left; border:1px solid #000;">' . $row['nama_gejala'] . '</td>
                </tr>';
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

// Hitung Bayes
$data = get_data($selected);
$bayes = bayes($data, $penyakit);

// Tampilkan hasil penyakit dan gambar
arsort($bayes['hasil']);
$hasil_penyakit = $penyakit[key($bayes['hasil'])];
$html .= '<p>Hasil Diagnosa Penyakit adalah: <strong>' . $hasil_penyakit['nama_penyakit'] . '</strong></p>';

if (!empty($hasil_penyakit['gambar'])) {
    $image_path = 'uploads/' . $hasil_penyakit['gambar'];
    if (file_exists($image_path)) {
        $html .= '<table><tr>';
        $html .= '<td><img src="' . $image_path . '" width="150" height="150" /></td>';
        $html .= '</tr></table>';
    } else {
        $html .= '<p><strong>Gambar tidak ditemukan!</strong></p>';
    }
}

$html .= '<p><strong>Solusi Penanganan:</strong><br>' . nl2br($hasil_penyakit['keterangan']) . '</p>';

// Output HTML ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Set nama file PDF
$filename = "hasil_diagnosa.pdf";

// Output file PDF (download langsung)
$pdf->Output($filename, 'D');

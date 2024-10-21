<?php
require_once('tcpdf/tcpdf.php'); // Sertakan library TCPDF

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "spnaivebayes1"; // Nama database yang sesuai

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Ambil data pencarian dari parameter 'r'
$r = isset($_GET['r']) ? mysqli_real_escape_string($koneksi, $_GET['r']) : '';

// Query untuk mengambil data dari tabel bayes_konsultasi sesuai pencarian
$sql = "SELECT * FROM bayes_konsultasi 
        WHERE nama LIKE '%$r%' 
        OR penyakit LIKE '%$r%' 
        ORDER BY tanggal DESC";

$q_exec = mysqli_query($koneksi, $sql);

// Membuat objek PDF
$pdf = new TCPDF();

// Atur properti dasar PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nama Author');
$pdf->SetTitle('Rekap Konsultasi');

// Tambah halaman
$pdf->AddPage();

// Set font dasar
$pdf->SetFont('helvetica', '', 10);

// Mulai output dalam bentuk HTML
$html = '
<style>
    th {
        background-color: #dedede;
        color: #333333;
        font-weight: bold;
        text-align: center;
    }
    td {
        text-align: center;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table, th, td {
        border: 1px solid black;
    }
</style>
<h3 style="text-align:center;">Daftar Konsultasi</h3>';

// Menambahkan informasi pencarian jika ada
if (!empty($r)) {
    $html .= '<p style="text-align:center;">Hasil pencarian untuk: <strong>' . htmlspecialchars($r) . '</strong></p>';
}

$html .= '
<table>
    <thead>
        <tr>
            <th style="width:5%">No.</th>
            <th style="width:15%">Nama</th>
            <th style="width:10%">Varietas</th>
            <th style="width:15%">Penyakit</th>
            <th style="width:10%">Nilai Akurasi</th>
            <th style="width:25%">Penanganan</th>
            <th style="width:10%">Tanggal</th>
        </tr>
    </thead>
    <tbody>';

// Looping data dari database ke dalam HTML menggunakan variabel $r
$i = 1;
while ($row = mysqli_fetch_assoc($q_exec)) {
    $html .= '
    <tr>
        <td style="width:5%">' . $i++ . '</td>
        <td style="width:15%">' . $row['nama'] . '</td>
        <td style="width:10%">' . $row['varietas'] . '</td>
        <td style="width:15%">' . $row['penyakit'] . '</td>
        <td style="width:10%">' . $row['nilai_akurasi'] . '</td>
        <td style="width:25%">' . $row['penanganan'] . '</td>
        <td style="width:10%">' . $row['tanggal'] . '</td>
    </tr>';
}

// Jika tidak ada hasil, tampilkan pesan
if ($i == 1) {
    $html .= '
    <tr>
        <td colspan="7" style="text-align:center;">Tidak ada data yang ditemukan</td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

// Tampilkan HTML ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF ke browser
$pdf->Output('rekap_konsultasi.pdf', 'D');

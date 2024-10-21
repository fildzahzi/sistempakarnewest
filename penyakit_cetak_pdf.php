<?php
require_once('tcpdf/tcpdf.php'); // Sertakan library TCPDF

// Koneksi ke database
$host = "localhost";
$user = "root";
$pass = "";
$db   = "spnaivebayes1"; // Nama database yang sesuai

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Ambil parameter pencarian (opsional)
$q = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, $_GET['q']) : '';

// Query untuk mengambil data dari tabel bayes_penyakit sesuai pencarian
$sql1 = "SELECT * FROM bayes_penyakit 
        WHERE kode_penyakit LIKE '%$q%' 
        OR nama_penyakit LIKE '%$q%' 
        OR keterangan LIKE '%$q%' 
        ORDER BY kode_penyakit";

$q1   = mysqli_query($koneksi, $sql1);

// Membuat objek PDF
$pdf = new TCPDF();

// Atur properti dasar PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nama Author');
$pdf->SetTitle('Daftar Penyakit');

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
<h3 style="text-align:center;">Daftar Penyakit</h3>';

// Menambahkan informasi pencarian jika ada
if (!empty($q)) {
    $html .= '<p style="text-align:center;">Hasil pencarian untuk: <strong>' . htmlspecialchars($q) . '</strong></p>';
}

$html .= '
<table>
    <thead>
        <tr>
            <th style="width:10%">No.</th>
            <th style="width:15%">Kode Penyakit</th>
            <th style="width:30%">Nama Penyakit</th>
            <th style="width:15%">Bobot</th>
            <th style="width:30%">Keterangan</th>
        </tr>
    </thead>
    <tbody>';

// Looping data dari database ke dalam HTML
$i = 1;
while ($r1 = mysqli_fetch_assoc($q1)) {
    $html .= '
    <tr>
        <td style="width:10%">' . $i++ . '</td>
        <td style="width:15%">' . $r1['kode_penyakit'] . '</td>
        <td style="width:30%">' . $r1['nama_penyakit'] . '</td>
        <td style="width:15%">' . $r1['bobot'] . '</td>
        <td style="width:30%">' . $r1['keterangan'] . '</td>
    </tr>';
}

// Jika tidak ada hasil, tampilkan pesan
if ($i == 1) {
    $html .= '
    <tr>
        <td colspan="5" style="text-align:center;">Tidak ada data yang ditemukan</td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

// Tampilkan HTML ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF ke browser
$pdf->Output('daftar_penyakit.pdf', 'D');

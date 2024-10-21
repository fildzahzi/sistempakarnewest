<?php
require_once('tcpdf/tcpdf.php'); // Sertakan library TCPDF

// Koneksi ke database
$host = "localhost";
$user = "u659182449_fildzahzata";
$pass = "Fildzaya911";
$db   = "u659182449_spnaivebayes1"; // Nama database yang sesuai

$koneksi = mysqli_connect($host, $user, $pass, $db);

// Ambil data pencarian (opsional)
$q = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, $_GET['q']) : '';

// Query untuk mengambil data dari tabel bayes_aturan dengan JOIN ke bayes_penyakit dan bayes_gejala
$sql1 = "
    SELECT a.*, p.nama_penyakit, g.nama_gejala
    FROM bayes_aturan a
    JOIN bayes_penyakit p ON a.kode_penyakit = p.kode_penyakit
    JOIN bayes_gejala g ON a.kode_gejala = g.kode_gejala
    WHERE p.nama_penyakit LIKE '%$q%' 
    OR g.nama_gejala LIKE '%$q%' 
    OR a.nilai LIKE '%$q%'
    ORDER BY a.ID
";

$q1   = mysqli_query($koneksi, $sql1);

// Membuat objek PDF
$pdf = new TCPDF();

// Atur properti dasar PDF
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nama Author');
$pdf->SetTitle('Daftar Aturan');

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
<h3 style="text-align:center;">Daftar Aturan</h3>';

// Menambahkan informasi pencarian jika ada
if (!empty($q)) {
    $html .= '<p style="text-align:center;">Hasil pencarian untuk: <strong>' . htmlspecialchars($q) . '</strong></p>';
}

$html .= '
<table>
    <thead>
        <tr>
            <th style="width:10%">No.</th>
            <th style="width:20%">Nama Penyakit</th>
            <th style="width:40%">Nama Gejala</th>
            <th style="width:15%">Nilai</th>
        </tr>
    </thead>
    <tbody>';

// Looping data dari database ke dalam HTML
$i = 1;
while ($r1 = mysqli_fetch_assoc($q1)) {
    $html .= '
    <tr>
        <td style="width:10%">' . $i++ . '</td>
        <td style="width:20%">' . $r1['nama_penyakit'] . '</td>
        <td style="width:40%">' . $r1['nama_gejala'] . '</td>
        <td style="width:15%">' . $r1['nilai'] . '</td>
    </tr>';
}

// Jika tidak ada hasil, tampilkan pesan
if ($i == 1) {
    $html .= '
    <tr>
        <td colspan="4" style="text-align:center;">Tidak ada data yang ditemukan</td>
    </tr>';
}

$html .= '
    </tbody>
</table>';

// Tampilkan HTML ke PDF
$pdf->writeHTML($html, true, false, true, false, '');

// Output PDF ke browser
$pdf->Output('daftar_aturan.pdf', 'D');

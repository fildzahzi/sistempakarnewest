<?php
require_once('tcpdf/tcpdf.php');

// Koneksi database
$host = "localhost";
$user = "u659182449_fildzahzata";
$pass = "Fildzaya911";
$db   = "u659182449_spnaivebayes1"; // Nama database yang sesuai
$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Inisialisasi TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Sistem Pakar');
$pdf->SetTitle('Hasil Diagnosa');
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
$pdf->AddPage();
$pdf->SetFont('helvetica', '', 12);

// Isi PDF (berdasarkan gejala dan diagnosa)
$html = '<h1>Hasil Diagnosa</h1>';
// Tambahkan konten PDF lainnya di sini sesuai dengan data diagnosa
$pdf->writeHTML($html, true, false, true, false, '');

// Nama file PDF yang dihasilkan
$filename = "hasil_diagnosa.pdf";

// Cek jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'email') {
        // Simpan PDF ke server terlebih dahulu
        $filepath = __DIR__ . "/hasil_diagnosa.pdf"; // Menggunakan path absolut untuk file
        $pdf->Output($filepath, 'F'); // Simpan PDF ke file di server

        $email_penerima = $_POST['email'];
        if (filter_var($email_penerima, FILTER_VALIDATE_EMAIL)) {
            // Menggunakan fungsi mail() bawaan PHP untuk mengirim email
            $to = $email_penerima;
            $subject = 'Hasil Diagnosa PDF';
            $message = 'Berikut adalah hasil diagnosa Anda dalam format PDF.';
            $headers = 'From: your-email@example.com' . "\r\n" .
                'Reply-To: your-email@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            // Attach PDF sebagai file
            $content = file_get_contents($filepath);
            $encoded_content = chunk_split(base64_encode($content)); // Encode file ke base64

            // Boundary untuk multipart email
            $boundary = md5(time());

            // Set header untuk email dengan attachment
            $headers .= 'MIME-Version: 1.0' . "\r\n";
            $headers .= 'Content-Type: multipart/mixed; boundary=' . $boundary . "\r\n";

            // Body email
            $body = '--' . $boundary . "\r\n";
            $body .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
            $body .= 'Content-Transfer-Encoding: 7bit' . "\r\n\r\n";
            $body .= $message . "\r\n";

            // Tambahkan attachment PDF
            $body .= '--' . $boundary . "\r\n";
            $body .= 'Content-Type: application/pdf; name="hasil_diagnosa.pdf"' . "\r\n";
            $body .= 'Content-Transfer-Encoding: base64' . "\r\n";
            $body .= 'Content-Disposition: attachment; filename="hasil_diagnosa.pdf"' . "\r\n\r\n";
            $body .= $encoded_content . "\r\n";
            $body .= '--' . $boundary . '--';

            // Kirim email dengan attachment
            if (mail($to, $subject, $body, $headers)) {
                echo 'Email berhasil dikirim ke ' . htmlspecialchars($email_penerima);
            } else {
                echo 'Email gagal dikirim.';
            }

            // Hapus file PDF setelah email terkirim
            if (file_exists($filepath)) {
                unlink($filepath);
            }
        } else {
            echo 'Email tidak valid!';
        }
    } elseif ($action == 'download') {
        // Output file PDF langsung untuk didownload
        $pdf->Output($filename, 'D'); // 'D' untuk mendownload file PDF
    }
}

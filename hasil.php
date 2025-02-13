<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/3270fbce75.js" crossorigin="anonymous"></script>

    <title>Document</title>
</head>

<body>

</body>

</html>

<?php
//manggil nama
session_start();
$_SESSION['nama'] = isset($_POST['nama']) ? $_POST['nama'] : 'Nama Pengguna Default';
$_SESSION['varietas'] = isset($_POST['varietas']) ? $_POST['varietas'] : 'Varietas Default';

$selected = (array) $_POST["selected"];
$db->query("INSERT INTO bayes_konsultasi (nama, varietas) VALUES ('$nama', '$varietas')");
$last_id = $db->insert_id;
$sql = "INSERT INTO bayes_konsultasi_detail (konsultasi_id, kode_gejala) VALUES ";
$values = [];
foreach ($selected as $row) {
    $values[] = "('" . $last_id . "', '" . $db->escape($row) . "')";
}
$sql .= implode(", ", $values);
$db->query($sql);
$rows = $db->get_results("SELECT kode_gejala, nama_gejala FROM bayes_gejala WHERE kode_gejala IN ('" . implode("','", $selected) . "')");
?>
<div class="panel">
    <div class="downloadhasil">
        <div>
            <h5>Nama Pengguna = <b><?= $nama ?></b></h5>
            <h5>Jenis Tebu = <b><?= $varietas ?></b></h5>
        </div>
        <a href="hasil_cetak_pdf.php?m=hasil&<?= http_build_query(array('selected' => $selected)) ?>" target="_blank"><i class="fa-solid fa-download"></i></a>
    </div>

    <br>
    <div class="panel-heading">
        <h3 class="panel-title">Gejala Terpilih</h3>
    </div>
    <table class="tablehasil">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Gejala</th>
            </tr>
        </thead>
        <?php
        $no = 1;
        foreach ($rows as $row):
            $gejala[$row->kode_gejala] = $row->nama_gejala;
        ?>
            <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= $row->nama_gejala ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <?php

    $rows = $db->get_results("SELECT * FROM bayes_penyakit ORDER BY kode_penyakit");
    foreach ($rows as $row) {
        $penyakit[$row->kode_penyakit] = $row;
    }

    $data = get_data($selected);
    $bayes = bayes($data, $penyakit);

    ?>

    <div>

        <p>
            <?php
            arsort($bayes['hasil']);
            ?>
            Hasil Diagnosa Penyakit adalah = <strong><?= $penyakit[key($bayes['hasil'])]->nama_penyakit ?></strong>
            <!-- </strong> dengan Nilai = <strong><?= round(current($bayes['hasil']), 4) ?></strong> -->
        </p>
        <?php if (isset($penyakit[key($bayes['hasil'])]->gambar)): ?>
            <img src="uploads/<?= $penyakit[key($bayes['hasil'])]->gambar ?>" width="200" style="margin-bottom: 1rem;" align-items="center">
        <?php endif ?>
        <p>
            <strong>Solusi Penanganan:</strong><br>
            <?= nl2br($penyakit[key($bayes['hasil'])]->keterangan) ?>
        </p>
        <p class="buttonhasil">
            <a class="btn btn-primary" href="?m=konsultasi"><i class="fa-solid fa-headset"></i>
                Konsultasi Lagi</a>
            <a class="btn btn-primary" href="?m=homeadmin"><i class="fa-solid fa-house"></i>
                Kembali ke Beranda</a>
            <!-- <a class="btn btn-primary" onclick="openEmailPopup()">Kirim PDF ke Email</a> -->
        </p>
    </div>
</div>

<!-- <div class="panel"> -->
<!-- <div class="panel-heading">
        <h3 class="panel-title">Hasil Analisa</h3>
    </div> -->
<!-- <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Penyakit</th>
                <th>Bobot Penyakit</th>
                <th>Gejala Dipilih</th>
                <th>Bobot Aturan</th>
                <th>Perkalian</th>
                <th>Hasil</th>
            </tr>
        </thead>
        
        <?php foreach ($data as $key => $val):  ?>
            <tr>
                <td rowspan="<?= count($val) ?>"><?= $penyakit[$key]->nama_penyakit ?></td>
                <td rowspan="<?= count($val) ?>"><?= $penyakit[$key]->bobot ?></td>
                <td><?= $gejala[key($val)] ?></td>
                <td><?= current($val) ?></td>
                <td rowspan="<?= count($val) ?>"><?= round($bayes['kali'][$key], 4) ?></td>
                <td rowspan="<?= count($val) ?>"><?= round($bayes['hasil'][$key], 4) ?></td>
            </tr>
            <?php
            /** menghilangkan elemen pertama array tanpa menghilangkan key */
            unset($val[key($val)]);

            foreach ($val as $k => $v): ?>
                <tr>
                    <td><?= $gejala[$k] ?></td>
                    <td><?= $v ?></td>
                </tr>
            <?php endforeach ?>
        <?php endforeach ?>
        <tr>
            <td colspan="5">Total</td>
            <td colspan="2"><?= round($bayes['total'], 4) ?></td>
            
        </tr>
    </table> -->





<!-- </div> -->
<?php
$nama_penyakit = $penyakit[key($bayes['hasil'])]->nama_penyakit;
$ket = $penyakit[key($bayes['hasil'])]->keterangan;
$nilai_akurasi = round(current($bayes['hasil']), 4);
$tanggal = date('Y-m-d H:i:s');
$db->query("UPDATE bayes_konsultasi SET penyakit='$nama_penyakit', penanganan='$ket', nilai_akurasi='$nilai_akurasi', tanggal='$tanggal' WHERE id='$last_id'");
?>
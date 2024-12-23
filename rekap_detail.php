<?php
$id = $_GET['ID'];
$data = $db->get_results("SELECT * FROM bayes_konsultasi WHERE id='$id'");
$details = $db->get_results("SELECT * FROM bayes_konsultasi_detail WHERE konsultasi_id='$id'");
$selected = [];
foreach ($details as $detail) {
    $selected[] = $detail->kode_gejala;
}
$rows = $db->get_results("SELECT kode_gejala, nama_gejala FROM bayes_gejala WHERE kode_gejala IN ('" . implode("','", $selected) . "')");
?>
<div class="gejala">

    <div class="page">
        <h1>Rekap Konsultasi <?= $data[0]->nama ?></h1>
    </div>
    <div class="panel">
        <p>Nama = <?= $data[0]->nama ?></p>
        <p>Varietas = <?= $data[0]->varietas ?></p>
    </div>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Gejala Terpilih</h3>
        </div>
        <table class="table">
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
    </div>
    <?php

    $rows = $db->get_results('SELECT * FROM bayes_penyakit ORDER BY kode_penyakit');
    foreach ($rows as $row) {
        $penyakit[$row->kode_penyakit] = $row;
    }

    $data = get_data($selected);
    $bayes = bayes($data, $penyakit);

    ?>
    <div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title">Hasil Analisa</h3>
        </div>
        <table class="table table-bordered">
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
            <?php foreach ($data as $key => $val): ?>
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
        </table>
        <div class="panel-body">
            <p>
                <?php
                arsort($bayes['hasil']);
                ?>
                Hasil Terbesar Didapatkan oleh Penyakit =
                <strong><?= $penyakit[key($bayes['hasil'])]->nama_penyakit ?></strong>
                <!-- dengan Nilai =<strong><?= round(current($bayes['hasil']), 4) ?></strong> -->
            </p>
            <?php if (isset($penyakit[key($bayes['hasil'])]->gambar)): ?>
            <img src="uploads/<?= $penyakit[key($bayes['hasil'])]->gambar ?>"width="200" style="margin-bottom: 1rem;">
            <?php endif ?>
            <p>
                <strong>Solusi Penanganan:</strong><br>
                <?= nl2br($penyakit[key($bayes['hasil'])]->keterangan) ?>
            </p>
            <!-- <p>
                <a class="btn btn-primary"
                    href="cetak.php?m=hasil&<?= http_build_query(['selected' => $selected]) ?>"
                    target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak</a>
                <a class="btn btn-primary" href="rekap_detail_cetak_pdf.php?m=hasil&<?= http_build_query(array('selected' => $selected)) ?>" target="_blank"><i class="fa-solid fa-download"></i> Unduh PDF</a>
            </p> -->
        </div>
    </div>
</div>
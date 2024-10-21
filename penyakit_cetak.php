<?php include_once 'functions.php'; ?>
<!doctype html>
<html>

<head>
    <meta name="robots" content="noindex, nofollow" />
    <title>Laporan Penyakit</title>
    <style>
        body {
            font-family: Verdana;
            font-size: 13px;
        }

        h1 {
            font-size: 14px;
            border-bottom: 4px double #000;
            padding: 3px 0;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 10px;
        }

        td,
        th {
            border: 1px solid #000;
            padding: 3px;
        }

        .wrapper {
            margin: 0 auto;
            width: 980px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <h1>Daftar Penyakit</h1>

        <!-- Tombol untuk download PDF -->
        <a href="penyakit_cetak_pdf.php?q=<?= $_GET['q'] ?>" class="btn btn-primary">Download PDF</a>

        <table>
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Nama Penyakit</th>
                    <th>Bobot</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $q = esc_field($_GET['q']);
                $rows = $db->get_results("SELECT * FROM bayes_penyakit 
                WHERE kode_penyakit LIKE '%$q%' OR nama_penyakit LIKE '%$q%' OR keterangan LIKE '%$q%' 
                ORDER BY kode_penyakit");

                foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= $row->kode_penyakit ?></td>
                        <td><?= $row->nama_penyakit ?></td>
                        <td><?= $row->bobot ?></td>
                        <td><?= $row->keterangan ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>
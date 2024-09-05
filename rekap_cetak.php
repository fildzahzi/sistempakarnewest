//belum diedit
<h1>Rekap</h1>
<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Nama Varietas</th>
            <th>Penyakit</th>
            <th>Nilai</th>
            <th>Penanganan</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <?php
    $r = esc_field($_GET['r'] ?? '');
    $rows = $db->get_results("SELECT * FROM bayes_konsultasi 
        WHERE nama LIKE '%$r%' OR penyakit LIKE '%$r%'
        ORDER BY tanggal DESC");
    $no = 0;
    foreach ($rows as $row): ?>
        <tr>
            <td><?= $row->nama ?></td>
            <td><?= $row->varietas ?></td>
            <td><?= $row->penyakit ?></td>
            <td><?= $row->nilai_akurasi ?></td>
            <td><?= $row->penanganan ?></td>
            <td><?= $row->tanggal ?></td>
        </tr>
    <?php endforeach; ?>
</table>
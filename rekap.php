<div class="gejala">

    <div class="page">
        <h1>Rekap Konsultasi</h1>
    </div>
    <div class="panel">

        <form>
            <div class="pencarian">
                <input type="hidden" name="m" value="gejala" />
                <input class="kolomcari" type="text" placeholder="Pencarian. . ." name="q" value="<?= $_GET['q'] ?? '' ?>" />
                <button class="cari"><span class="glyphicon glyphicon-search"></span> Cari</button>
            </div>

        </form>

        <div class="table">
            <?php
            // Mendapatkan data gejala dari database
            $q = esc_field($_GET['q'] ?? '');
            $rows = $db->get_results("SELECT * FROM bayes_konsultasi 
                WHERE nama LIKE '%$q%' OR penyakit LIKE '%$q%'
                ORDER BY tanggal DESC");
        ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">No</th>
                        <th>Nama</th>
                        <th>Nama Varietas</th>
                        <th>Penyakit</th>
                        <th>Nilai</th>
                        <th>Penanganan</th>
                        <th>Tanggal</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 0;
                    foreach ($rows as $row) { ?>
                        <tr>
                            <td class="text-center"><?= ++$no ?></td>
                            <td><?= $row->nama ?></td>
                            <td><?= $row->varietas ?></td>
                            <td><?= $row->penyakit ?></td>
                            <td><?= $row->nilai_akurasi ?></td>
                            <td><?= $row->penanganan ?></td>
                            <td><?= $row->tanggal ?></td>
                            <td class="nw text-center">
                                <a class="btn btn-sm btn-info" href="?m=rekap_detail&amp;ID=<?= $row->id ?>"><span class="glyphicon glyphicon-eye-open"></span></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="penyakit">

    <div class="page">
        <h1>Daftar Penyakit</h1>
    </div>
    <div class="panel">

        <form>
            <div class="pencarian">
                <input type="hidden" name="m" value="penyakit" />
                <input class="kolomcari" type="text" placeholder="Pencarian. . ." name="q" value="<?= $_GET["q"] ?? '' ?>" />
                <button class="cari"><span class="glyphicon glyphicon-search"></span> Cari</a>
            </div>
            <div class="tambahdancetak">

                <div class="tambah">
                    <a href="?m=penyakit_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Data</a>
                </div>
                <div class="cetak">
                    <a href="cetak.php?m=penyakit&q=<?= $_GET["q"] ?? '' ?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak Data</a>
                </div>
            </div>
        </form>

        <div class="table">
            <table>
                <thead>
                    <tr class="nw">
                        <th>Kode</th>
                        <th>Nama Penyakit</th>
                        <th>Bobot</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <?php
                $q = esc_field($_GET['q'] ?? '');
                $rows = $db->get_results("SELECT * FROM bayes_penyakit 
            WHERE kode_penyakit LIKE '%$q%' OR nama_penyakit LIKE '%$q%' OR keterangan LIKE '%$q%' 
            ORDER BY kode_penyakit");
                $no = 0;

                foreach ($rows as $row) : ?>
                    <tr>
                        <td><?= $row->kode_penyakit ?></td>
                        <td><?= $row->nama_penyakit ?></td>
                        <td><?= $row->bobot ?></td>
                        <td><?= $row->keterangan ?></td>
                        <td class="nw">
                            <a class="btn btn-xs btn-warning" href="?m=penyakit_ubah&amp;ID=<?= $row->kode_penyakit ?>"><span class="glyphicon glyphicon-edit"></span> Edit</a>
                            <a class="btn btn-xs btn-danger" href="aksi.php?act=penyakit_hapus&amp;ID=<?= $row->kode_penyakit ?>" onclick="return confirm('Hapus data?')"><span class="glyphicon glyphicon-trash"></span> Hapus</a>
                        </td>
                    </tr>
                <?php endforeach;
                ?>
            </table>
        </div>
    </div>

</div>
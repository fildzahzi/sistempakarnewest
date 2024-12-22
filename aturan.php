<div class="aturan">

    <div class="page">
        <h1>Aturan</h1>
    </div>
    <div class="panel">

        <form>
            <div class="pencarian">
                <input type="hidden" name="m" value="aturan" />
                <input class="kolomcari" type="text" placeholder="Pencarian. . ." name="q" value="<?= $_GET['q'] ?? '' ?>" />
                <button class="cari"><i class="fa-solid fa-magnifying-glass"></i> <b>Cari</b></a>
            </div>
            <div class="tambahdancetak">
                <div class="tambah">
                    <a href="?m=aturan_tambah"><i class="fa-solid fa-plus"></i> <b>Tambah Data</b></a>
                </div>
                <div class="cetak">
                    <a href="aturan_cetak_pdf.php?q=<?= urlencode(isset($_GET['q']) ? $_GET['q'] : '') ?>"><i class="fa-solid fa-download"></i><b>Download Data</b></a>

                </div>
            </div>
        </form>


        <table class="table">
            <thead>
                <tr class="nw">
                    <th>No</th>
                    <th>Penyakit</th>
                    <th>Gejala</th>
                    <th>Nilai</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <?php
            $q = esc_field($_GET['q'] ?? '');
            $rows = $db->get_results("SELECT r.ID, g.nama_gejala, p.nama_penyakit, r.nilai
            FROM bayes_aturan r INNER JOIN bayes_penyakit p ON p.`kode_penyakit`=r.`kode_penyakit` INNER JOIN bayes_gejala g ON g.`kode_gejala`=r.`kode_gejala`
            WHERE r.kode_gejala LIKE '%$q%'
                OR r.kode_penyakit LIKE '%$q%'
                OR g.nama_gejala LIKE '%$q%'
                OR p.nama_penyakit LIKE '%$q%' 
            ORDER BY r.kode_penyakit, r.kode_gejala");
            $no = 0;

            foreach ($rows as $row): ?>
                <tr>
                    <td><?= ++$no ?></td>
                    <td><?= $row->nama_penyakit ?></td>
                    <td><?= $row->nama_gejala ?></td>
                    <td><?= $row->nilai ?></td>
                    <td class="nw">
                        <a class="btnedit" href="?m=aturan_ubah&ID=<?= $row->ID ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                        <a class="btndelete" href="aksi.php?act=aturan_hapus&ID=<?= $row->ID ?>" onclick="return confirm('Hapus data?')"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                    </td>
                </tr>
            <?php endforeach;
            ?>
        </table>

    </div>
</div>
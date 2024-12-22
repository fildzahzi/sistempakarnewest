<div class="penyakit">

    <div class="page">
        <h1>Daftar Penyakit</h1>
    </div>
    <div class="panel">

        <form>
            <div class="pencarian">
                <input type="hidden" name="m" value="penyakit" />
                <input class="kolomcari" type="text" placeholder="Pencarian. . ." name="q" value="<?= $_GET["q"] ?? '' ?>" />
                <button class="cari"><i class="fa-solid fa-magnifying-glass"></i><b> Cari</b></a>

            </div>

            <div class="tambahdancetak">
                <div class="tambah">
                    <a href="?m=penyakit_tambah"><i class="fa-solid fa-plus"></i> <b>Tambah Data</b></a>
                </div>
                <div class="cetak">
                    <a href="penyakit_cetak_pdf.php?q=<?= isset($_GET['q']) ? $_GET['q'] : '' ?>"><i class="fa-solid fa-download"></i><b>Download Data</b></a>

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
                        <th>Penanganan</th>
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
                            <a class="btnedit" href="?m=penyakit_ubah&amp;ID=<?= $row->kode_penyakit ?>"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                            <a class="btndelete" href="aksi.php?act=penyakit_hapus&amp;ID=<?= $row->kode_penyakit ?>" onclick="return confirm('Hapus data?')"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                        </td>
                    </tr>
                <?php endforeach;
                ?>
            </table>
        </div>
    </div>

</div>
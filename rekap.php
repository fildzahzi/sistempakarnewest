<div class="rekap">

    <div class="page">
        <h1>Rekap Konsultasi</h1>
    </div>
    <div class="panel">

        <form>
            <div class="pencarian">
                <input type="hidden" name="m" value="rekap" />
                <input class="kolomcari" type="text" placeholder="Pencarian. . ." name="r" value="<?= $_GET['r'] ?? '' ?>" />
                <button class="cari"><i class="fa-solid fa-magnifying-glass"></i> Cari</button>
            </div>
            <div class="tambahdancetak">

                <div class="cetak">
                    <a href="rekap_cetak_pdf.php?r=<?= isset($_GET['r']) ? $_GET['r'] : '' ?>"><i class="fa-solid fa-download"></i>Download Data</a>
                </div>
            </div>
        </form>

        <div class="table">
            <?php
            // Mendapatkan data gejala dari database
            $r = esc_field($_GET['r'] ?? '');
            $rows = $db->get_results("SELECT * FROM bayes_konsultasi 
                WHERE nama LIKE '%$r%' OR penyakit LIKE '%$r%'
                ORDER BY tanggal DESC");
            ?>
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
                        <th>Aksi</th>
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
                            <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                <?= $row->penanganan ?>
                            </td>
                            <td><?= $row->tanggal ?></td>
                            <td class="nw text-center">
                                <a class="btnview" href="?m=rekap_detail&amp;ID=<?= $row->id ?>"><i class="fa-solid fa-eye"></i> Detail</a>
                                <a class="btndelete" href="aksi.php?act=rekap_hapus&amp;ID=<?= $row->id ?>" onclick="return confirm('Hapus data?')"><i class="fa-solid fa-trash-can"></i> Hapus</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
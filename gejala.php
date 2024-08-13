<div class="gejala">

    <div class="page">
        <h1>Gejala</h1>
    </div>
    <div class="panel">

        <form>
            <div class="pencarian">
                <input type="hidden" name="m" value="gejala" />
                <input class="kolomcari" type="text" placeholder="Pencarian. . ." name="q" value="<?= $_GET['q'] ?? '' ?>" />
                <button class="cari"><span class="glyphicon glyphicon-search"></span> Cari</button>
            </div>
            <div class="tambahdancetak">
                <div class="tambah">
                    <a href="?m=gejala_tambah"><span class="glyphicon glyphicon-plus"></span> Tambah Data</a>
                </div>
                <div class="cetak">
                    <a href="cetak.php?m=gejala&q=<?= $_GET['q'] ?? '' ?>" target="_blank"><span class="glyphicon glyphicon-print"></span> Cetak Data</a>
                </div>
            </div>

        </form>

        <div class="table">
            <?php
            // Mendapatkan data gejala dari database
            $q = esc_field($_GET['q'] ?? '');
            $rows = $db->get_results("SELECT * FROM bayes_gejala 
        WHERE kode_gejala LIKE '%$q%' OR nama_gejala LIKE '%$q%'
        ORDER BY kode_gejala");

            // Inisialisasi array untuk Daun, Batang, dan Tumbuhan
            $daun = [];
            $batang = [];
            $tumbuhan = [];

            // Pengelompokan berdasarkan awalan kode_gejala
            foreach ($rows as $row) {
                if (strpos($row->kode_gejala, 'D') === 0) {
                    $daun[] = $row;
                } elseif (strpos($row->kode_gejala, 'B') === 0) {
                    $batang[] = $row;
                } else {
                    $tumbuhan[] = $row;
                }
            }

            // Fungsi untuk menampilkan tabel
            function render_table($rows)
            {
                echo '<table class="table">';
                echo '<thead><tr><th>Kode</th><th>Nama Gejala</th><th>Aksi</th></tr></thead>';
                foreach ($rows as $row) {
                    echo '<tr>';
                    echo '<td>' . $row->kode_gejala . '</td>';
                    echo '<td>' . $row->nama_gejala . '</td>';
                    echo '<td class="nw">';
                    echo '<a class="btn btn-xs btn-warning" href="?m=gejala_ubah&amp;ID=' . $row->kode_gejala . '"><span class="glyphicon glyphicon-edit"></span></a>';
                    echo '<a class="btn btn-xs btn-danger" href="aksi.php?act=gejala_hapus&amp;ID=' . $row->kode_gejala . '" onclick="return confirm(\'Hapus data?\')"><span class="glyphicon glyphicon-trash"></span></a>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</table>';
            }

            // Menampilkan tabel-tabel dengan nama bagian baru
            echo '<h2>Daun</h2>';
            render_table($daun);

            echo '<h2>Batang</h2>';
            render_table($batang);

            echo '<h2>Tumbuhan</h2>';
            render_table($tumbuhan);
            ?>
        </div>
    </div>
</div>
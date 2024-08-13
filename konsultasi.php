<div class="konsultasi">
    <div class="page">
        <h1>Konsultasi</h1>
    </div>
    <?php
    $success = false;
    if ($_POST) {
        if (count($_POST["selected"]) > 0) {
            $success = true;
            include 'hasil.php';
        } else {
            print_msg('Pilih minimal 1 gejala');
        }
    }
    if (!$success) : ?>
        <form action="?m=konsultasi" method="post">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Pilih Beberapa Gejala</h3>
                </div>
                <div class="table-responsive">
                    <?php
                    // Ambil data dari database
                    $rows = $db->get_results("SELECT * FROM bayes_gejala ORDER BY kode_gejala");

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
                        echo '<thead><tr><th><input type="checkbox" id="checkAll" /></th><th>No</th><th>Nama Gejala</th></tr></thead>';
                        $no = 0;
                        foreach ($rows as $row) {
                            echo '<tr class="clickable-row">';  // Tambahkan kelas clickable-row
                            echo '<td><input type="checkbox" name="selected[]" value="' . $row->kode_gejala . '"/></td>';
                            echo '<td>' . ++$no . '</td>';
                            echo '<td>' . $row->nama_gejala . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                    }

                    // Menampilkan tabel untuk Daun
                    echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading"><h3 class="panel-title">Daun</h3></div>';
                    echo '<div class="table-responsive">';
                    render_table($daun);
                    echo '</div>';
                    echo '</div>';

                    // Menampilkan tabel untuk Batang
                    echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading"><h3 class="panel-title">Batang</h3></div>';
                    echo '<div class="table-responsive">';
                    render_table($batang);
                    echo '</div>';
                    echo '</div>';

                    // Menampilkan tabel untuk Tumbuhan
                    echo '<div class="panel panel-default">';
                    echo '<div class="panel-heading"><h3 class="panel-title">Tumbuhan</h3></div>';
                    echo '<div class="table-responsive">';
                    render_table($tumbuhan);
                    echo '</div>';
                    echo '</div>';
                    ?>
                </div>
                <div class="panel-footer">
                    <button class="btn btn-primary" name="submit"><span class="glyphicon glyphicon-ok"></span> Submit Diagnosa</button>
                </div>
            </div>
        </form>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(function() {
                // Fungsi untuk toggle checkbox semua baris
                $("#checkAll").click(function() {
                    $('input:checkbox').not(this).prop('checked', this.checked);
                });

                // Fungsi untuk membuat seluruh baris bisa diklik
                $(".clickable-row").click(function(e) {
                    if ($(e.target).is("input:checkbox")) {
                        return; // Jika checkbox diklik langsung, tidak perlu melakukan apa-apa
                    }

                    var checkbox = $(this).find('input:checkbox');
                    checkbox.prop("checked", !checkbox.prop("checked")); // Toggle checkbox
                });
            });
        </script>
    <?php endif ?>
</div>
<div class="konsultasi">
    <div class="page">
        <h1>Konsultasi</h1>
    </div>
    <?php
    $success = false;
    if ($_POST) {
        $nama = $_POST["nama"];
        $varietas = $_POST["varietas"];
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
                    <h3 class="panel-title">Form Konsultasi</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group mb-3">
                        <label for="">Nama Pengguna</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Nama Varietas Tebu</label>
                        <select class="form-control" id="varietas" name="varietas" required>
                            <option value="" disabled selected>Pilih varietas</option>
                            <option value="varietas1">PS862</option>
                            <option value="varietas2">PS864</option>
                            <option value="varietas3">Bulu Lawang</option>
                            <option value="varietas3">Cening</option>
                            <!-- Tambahkan lebih banyak opsi sesuai kebutuhan -->
                        </select>
                    </div>
                </div>
                <div class="panel-heading">
                    <h3 class="panel-title">Pilih Minimal 1 Gejala dan Maksimal 8 Gejala</h3>
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
                        echo '<thead><tr><th><input type="checkbox" id="checkAll" style="display: none;" /></th><th>No</th><th>Nama Gejala</th></tr></thead>';
                        $no = 0;
                        foreach ($rows as $row) {
                            echo '<tr class="clickable-row">';  // Tambahkan kelas clickable-row
                            echo '<td class="text-center"><input type="checkbox" name="selected[]" value="' . $row->kode_gejala . '"/></td>';
                            echo '<td class="text-center">' . ++$no . '</td>';
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
                // Fungsi untuk memastikan minimal 1 checkbox dipilih
                function validateCheckboxSelection() {
                    var checkedCount = $('input:checkbox:checked').length;
                    return checkedCount >= 1 && checkedCount <= 8;
                }

                // Fungsi untuk update status checkbox sesuai dengan batasan
                function updateCheckboxStatus() {
                    var checkedCount = $('input:checkbox:checked').length;
                    $('input:checkbox').not(':checked').prop('disabled', checkedCount >= 8); // Disable checkbox jika sudah ada 8 yang terpilih
                }

                // Toggle checkbox individual
                $(".clickable-row").click(function(e) {
                    if ($(e.target).is("input:checkbox")) {
                        return; // Jika checkbox diklik langsung, tidak perlu melakukan apa-apa
                    }

                    var checkbox = $(this).find('input:checkbox');
                    checkbox.prop("checked", !checkbox.prop("checked")); // Toggle checkbox

                    if (!validateCheckboxSelection()) {
                        checkbox.prop("checked", false); // Batalkan toggle jika melanggar aturan
                    }

                    updateCheckboxStatus();
                });

                // Update status checkbox saat halaman dimuat
                $('input:checkbox').change(function() {
                    if (!validateCheckboxSelection()) {
                        $(this).prop("checked", false); // Batalkan jika melanggar aturan
                    }

                    updateCheckboxStatus();
                });

                // Initial call to update the checkbox status on page load
                updateCheckboxStatus();
            });
        </script>

    <?php endif ?>
</div>
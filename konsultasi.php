<div class="konsultasi">
    <div class="page">
        <h1>Konsultasi</h1>
    </div>
    <?php
    $success = false;
    if ($_POST) {
        $nama = trim($_POST["nama"]);
        $varietas = $_POST["varietas"] ?? '';

        if (empty($nama)) {
            print_msg('Nama tidak boleh kosong.');
        } elseif (empty($varietas)) {
            print_msg('Pilih salah satu jenis varietas.');
        } elseif (isset($_POST["selected"]) && is_array($_POST["selected"]) && count($_POST["selected"]) > 0) {
            $success = true;
            include 'hasil.php';
        } else {
            print_msg('Pilih minimal 1 gejala.');
        }
    }

    if (!$success) : ?>
        <form action="?m=konsultasi" method="post" id="konsultasiForm">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">Form Konsultasi</h3>
                </div>
                <div class="panel-body">
                    <div class="form-group mb-3">
                        <label for="">Nama Pengguna</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama Anda">
                    </div>
                    <div class="form-group mb-3">
                        <label for="">Jenis Tebu</label>
                        <select class="form-control" id="varietas" name="varietas">
                            <option value="" disabled selected>Pilih Jenis Tebu</option>
                            <option value="PS862">PS862</option>
                            <option value="PS864">PS864</option>
                            <option value="Bulu Lawang">Bulu Lawang</option>
                            <option value="Cening">Cening</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>

                        <div id="customVarietasContainer" style="display: none;">
                            <input type="text" id="customVarietas" placeholder="Masukkan varietas baru">
                        </div>

                    </div>
                </div>
            </div>
            <div class="space">
                <p>Untuk memulai proses diagnosa, pengguna diminta untuk mencentang gejala yang terdapat pada <b>daun</b>, <b>batang</b>, atau <b>tumbuhan</b> pada tanaman tebu di kolom-kolom di bawah ini. <br>
                    Pengguna wajib memilih minimal 1 gejala dan maksimal 8 gejala.</p>
            </div>

            <div class="kolomgejala">
                <div class="row">
                    <?php
                    $rows = $db->get_results("SELECT * FROM bayes_gejala ORDER BY kode_gejala");
                    $daun = [];
                    $batang = [];
                    $tumbuhan = [];

                    foreach ($rows as $row) {
                        if (strpos($row->kode_gejala, 'D') === 0) {
                            $daun[] = $row;
                        } elseif (strpos($row->kode_gejala, 'B') === 0) {
                            $batang[] = $row;
                        } else {
                            $tumbuhan[] = $row;
                        }
                    }

                    function render_card($title, $rows)
                    {
                        echo '<div class="col-md-4">';
                        echo '<div class="card mb-2">';
                        echo '<div class="card-header"><h5 class="card-title">' . $title . '</h5></div>';
                        echo '<div class="card-body">';
                        echo '<table class="table">';
                        echo '<thead><tr><th></th><th>No</th><th>Nama Gejala</th></tr></thead>';
                        $no = 0;
                        foreach ($rows as $row) {
                            echo '<tr class="clickable-row">';
                            echo '<td class="text-center"><input type="checkbox" name="selected[]" value="' . $row->kode_gejala . '"/></td>';
                            echo '<td class="text-center">' . ++$no . '</td>';
                            echo '<td>' . $row->nama_gejala . '</td>';
                            echo '</tr>';
                        }
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                        echo '</div>';
                    }

                    // Render cards for each category
                    render_card('Daun', $daun);
                    render_card('Batang', $batang);
                    render_card('Tumbuhan', $tumbuhan);
                    ?>
                </div>
            </div>
            <div class="panel-footer">
                <button class="btn btn-primary" name="submit" type="submit"><span class="glyphicon glyphicon-ok"></span> <b>Submit Diagnosa</b></button>
            </div>
        </form>


        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $(function() {
                $('#konsultasiForm').on('submit', function(e) {
                    var nama = $('#nama').val().trim();
                    console.log('Nama:', nama); // Debugging output
                    var varietas = $('#varietas').val();

                    if (!nama) {
                        alert('Nama tidak boleh kosong.');
                        e.preventDefault();
                        return false;
                    }

                    if (!varietas) {
                        alert('Pilih salah satu jenis varietas.');
                        e.preventDefault();
                        return false;
                    }
                });

                $(".clickable-row").click(function(e) {
                    if ($(e.target).is("input:checkbox")) {
                        return;
                    }

                    var checkbox = $(this).find('input:checkbox');
                    checkbox.prop("checked", !checkbox.prop("checked"));
                    updateCheckboxStatus();
                });

                function updateCheckboxStatus() {
                    var checkedCount = $('input:checkbox:checked').length;
                    $('input:checkbox').not(':checked').prop('disabled', checkedCount >= 8);
                }

                $('input:checkbox').change(function() {
                    updateCheckboxStatus();
                });

                const selectElement = document.getElementById('varietas');
                const customVarietasContainer = document.getElementById('customVarietasContainer');
                const customVarietasInput = document.getElementById('customVarietas');

                selectElement.addEventListener('change', function() {
                    if (this.value === 'Lainnya') {
                        customVarietasContainer.style.display = 'block';
                        customVarietasInput.value = '';
                    } else {
                        customVarietasContainer.style.display = 'none';
                        customVarietasInput.value = '';
                    }
                });

                customVarietasInput.addEventListener('input', function() {
                    if (customVarietasInput.value.trim() !== '') {
                        selectElement.options[selectElement.selectedIndex].value = customVarietasInput.value;
                        selectElement.options[selectElement.selectedIndex].textContent = customVarietasInput.value;
                    } else {
                        selectElement.options[selectElement.selectedIndex].value = 'Lainnya';
                        selectElement.options[selectElement.selectedIndex].textContent = 'Lainnya';
                    }
                });

                updateCheckboxStatus();
            });
        </script>

    <?php endif ?>
</div>
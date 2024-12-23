<div class="universal">
    <div class="page">
        <h1>Tambah Penyakit</h1>
    </div>

    <div class="kolom">
        <div class="row">
            <div class="col">
                <?php if ($_POST) include 'aksi.php' ?>
                <form method="post" action="?m=penyakit_tambah" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Kode <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="kode_penyakit" value="<?= $_POST["kode_penyakit"] ?? '' ?>" />
                    </div>
                    <div class="form-group">
                        <label>Nama Penyakit <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="nama_penyakit" value="<?= $_POST["nama_penyakit"] ?? '' ?>" />
                    </div>
                    <div class="form-group">
                        <label>Bobot <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="bobot" value="<?= $_POST["bobot"] ?? '' ?>" />
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan"><?= $_POST["keterangan"] ?? '' ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"><span class="glyphicon glyphicon-save"></span> Simpan</button>
                        <a class="btn btn-danger" href="?m=penyakit"><span class="glyphicon glyphicon-arrow-left"></span> Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
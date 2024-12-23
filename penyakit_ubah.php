<?php
$row = $db->get_row("SELECT * FROM bayes_penyakit WHERE kode_penyakit='$_GET[ID]'");
?>
<div class="universal">
    <div class="page">
        <h1>Ubah Penyakit</h1>
    </div>

    <div class="kolom">
        <div class="row">
            <div class="col">
                <?php if ($_POST) include 'aksi.php' ?>
                <form method="post" action="?m=penyakit_ubah&amp;ID=<?= $row->kode_penyakit ?>" enctype="multipart/form-data">
                    <div class="form-group">
                        <label>Kode <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="kode_penyakit" readonly="readonly" value="<?= $row->kode_penyakit ?>" />
                    </div>
                    <div class="form-group">
                        <label>Nama Alternatif <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="nama_penyakit" value="<?= $row->nama_penyakit ?>" />
                    </div>
                    <div class="form-group">
                        <label>Bobot <span class="text-danger">*</span></label>
                        <input class="form-control" type="text" name="bobot" value="<?= $row->bobot ?>" />
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" name="keterangan"><?= $row->keterangan ?></textarea>
                    </div>
                    <div class="form-group">
                        <label>Gambar</label>
                        <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
                        <?php if ($row->gambar) { ?>
                            <img src="uploads/<?= $row->gambar ?>" class="img-thumbnail" style="margin-top: 1rem;">
                        <?php } ?>
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
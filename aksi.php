<?php
require_once 'functions.php';
$demo = false;
/*$urls  = array(
    'penyakit_tambah' => 'penyakit',
    'penyakit_ubah' => 'penyakit',
    'penyakit_hapus' => 'penyakit',
    
    'gejala_tambah' => 'gejala',
    'gejala_ubah' => 'gejala',
    'gejala_hapus' => 'gejala',
    
    'aturan_tambah' => 'aturan',
    'aturan_ubah' => 'aturan',
    'aturan_hapus' => 'aturan',        
);*/

/** LOGIN */
if ($mod == 'login') {
    $user = esc_field($_POST["user"]);
    $pass = esc_field($_POST["pass"]);

    $row = $db->get_row("SELECT * FROM bayes_admin WHERE user='$user' AND pass='$pass'");
    if ($row) {
        $_SESSION['login'] = $row->user;
        $_SESSION['role'] = $row->role;
        if ($row->role == 'admin') {
            redirect_js("index.php");
        } else {
            redirect_js("index_admin.php");
        }
    } else {
        print_msg("Salah kombinasi username dan password");
    }
} else if ($mod == 'password') {
    $pass1 = $_POST['pass1'];
    $pass2 = $_POST['pass2'];
    $pass3 = $_POST['pass3'];

    $row = $db->get_row("SELECT * FROM bayes_admin WHERE user='$_SESSION[login]' AND pass='$pass1'");

    if ($pass1 == '' || $pass2 == '' || $pass3 == '')
        print_msg('Field bertanda * harus diisi.');
    elseif (!$row)
        print_msg('Password lama salah.');
    elseif ($pass2 != $pass3)
        print_msg('Password baru dan konfirmasi password baru tidak sama.');
    else {
        $db->query("UPDATE bayes_admin SET pass='$pass2' WHERE user='$_SESSION[login]'");
        print_msg('Password berhasil diubah.', 'success');
    }
} elseif ($act == 'logout') {
    session_destroy();
    header("location:index.php");
}

/** PENYAKIT */
elseif ($mod == 'penyakit_tambah') {
    $kode_penyakit = $_POST['kode_penyakit'];
    $nama_penyakit = $_POST['nama_penyakit'];
    $bobot = $_POST['bobot'];
    $keterangan = $_POST['keterangan'];

    // Check if the file was uploaded without errors
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        
        // Get the file details
        $file_name = $_FILES['gambar']['name'];
        $file_size = $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_type = $_FILES['gambar']['type'];
        
        // Get the file extension
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        // Check if the file size is less than 5MB (you can adjust this size as needed)
        if ($file_size <= 5 * 1024 * 1024) { 
            
            // Create a unique name for the file to avoid overwriting
            $slug = createSlug($nama_penyakit);
            $new_file_name = $slug . '-' . uniqid() . '.' . $file_extension;
            
            // Define the upload directory
            $upload_dir = 'uploads/';

            // Check if the directory does not exist
            if (!file_exists($upload_dir)) {
                // Create the directory with permissions (0755)
                mkdir($upload_dir, 0755);
            }
            
            // Move the uploaded file to the desired directory
            if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
                // File upload failed
                print_msg("Maaf, terjadi kesalahan saat mengunggah berkas Anda.");
            }

        } else {
            print_msg("Maaf, berkas Anda terlalu besar. Ukuran maksimum adalah 5 MB.");
        }
    } else {
        print_msg("Terjadi kesalahan saat mengunggah berkas: " . $_FILES['image']['error']);
    }

    if (!$kode_penyakit || !$nama_penyakit || !$bobot)
        print_msg("Field yang bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM bayes_penyakit WHERE kode_penyakit='$kode_penyakit'"))
        print_msg("Kode sudah ada!");
    else {
        $db->query("INSERT INTO bayes_penyakit (kode_penyakit, nama_penyakit, bobot, keterangan, gambar) VALUES ('$kode_penyakit', '$nama_penyakit', '$bobot', '$keterangan', '$new_file_name')");
        redirect_js("index_admin.php?m=penyakit");
    }
} else if ($mod == 'penyakit_ubah') {
    $nama_penyakit = $_POST['nama_penyakit'];
    $bobot = $_POST['bobot'];
    $keterangan = $_POST['keterangan'];

    // Check if the file was uploaded without errors
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $row = $db->get_row("SELECT * FROM bayes_penyakit WHERE kode_penyakit='$_GET[ID]'");
        $file = 'uploads/' . $row->gambar;
        if (file_exists($file)) {
            // Delete the file
            if (!unlink($file)) {
                print_msg("Kesalahan saat menghapus file '$file'.");
            }
        }
        // Get the file details
        $file_name = $_FILES['gambar']['name'];
        $file_size = $_FILES['gambar']['size'];
        $file_tmp = $_FILES['gambar']['tmp_name'];
        $file_type = $_FILES['gambar']['type'];
        
        // Get the file extension
        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        // Check if the file size is less than 5MB (you can adjust this size as needed)
        if ($file_size <= 5 * 1024 * 1024) { 
            
            // Create a unique name for the file to avoid overwriting
            $slug = createSlug($nama_penyakit);
            $new_file_name = $slug . '-' . uniqid() . '.' . $file_extension;
            
            // Define the upload directory
            $upload_dir = 'uploads/';

            // Check if the directory does not exist
            if (!file_exists($upload_dir)) {
                // Create the directory with permissions (0755)
                mkdir($upload_dir, 0755);
            }
            
            // Move the uploaded file to the desired directory
            if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
                // File upload failed
                print_msg("Maaf, terjadi kesalahan saat mengunggah berkas Anda.");
            }

        } else {
            print_msg("Maaf, berkas Anda terlalu besar. Ukuran maksimum adalah 5 MB.");
        }
    } else {
        print_msg("Terjadi kesalahan saat mengunggah berkas: " . $_FILES['image']['error']);
    }

    if (!$nama_penyakit || !$bobot)
        print_msg("Field yang bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE bayes_penyakit SET nama_penyakit='$nama_penyakit', bobot='$bobot', keterangan='$keterangan', gambar='$new_file_name' WHERE kode_penyakit='$_GET[ID]'");
        redirect_js("index_admin.php?m=penyakit");
    }
} else if ($act == 'penyakit_hapus') {
    $row = $db->get_row("SELECT * FROM bayes_penyakit WHERE kode_penyakit='$_GET[ID]'");
    $file = 'uploads/' . $row->gambar;
    if (file_exists($file)) {
        // Delete the file
        if (!unlink($file)) {
            print_msg("Kesalahan saat menghapus file '$file'.");
        }
    }
    $db->query("DELETE FROM bayes_penyakit WHERE kode_penyakit='$_GET[ID]'");
    header("location:index_admin.php?m=penyakit ");
}

/** GEJALA */
if ($mod == 'gejala_tambah') {
    $kode_gejala = $_POST['kode_gejala'];
    $nama_gejala = $_POST['nama_gejala'];

    if (!$kode_gejala || !$nama_gejala)
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($db->get_results("SELECT * FROM bayes_gejala WHERE kode_gejala='$kode_gejala'"))
        print_msg("Kode sudah ada!");
    else {
        $db->query("INSERT INTO bayes_gejala (kode_gejala, nama_gejala) VALUES ('$kode_gejala', '$nama_gejala')");
        redirect_js("index_admin.php?m=gejala");
    }
} else if ($mod == 'gejala_ubah') {
    $nama_gejala = $_POST['nama_gejala'];

    if (!$nama_gejala)
        print_msg("Field bertanda * tidak boleh kosong!");
    else {
        $db->query("UPDATE bayes_gejala SET nama_gejala='$nama_gejala' WHERE kode_gejala='$_GET[ID]'");
        redirect_js("index_admin.php?m=gejala");
    }
} else if ($act == 'gejala_hapus') {
    $db->query("DELETE FROM bayes_gejala WHERE kode_gejala='$_GET[ID]'");
    header("location:index_admin.php?m=gejala");
}

/** ATURAN TAMBAH */
else if ($mod == 'aturan_tambah') {
    $kode_penyakit = $_POST['kode_penyakit'];
    $kode_gejala = $_POST['kode_gejala'];
    $nilai = $_POST['nilai'];

    $kombinasi_ada = $db->get_row("SELECT * FROM bayes_aturan WHERE kode_penyakit='$kode_penyakit' AND kode_gejala='$kode_gejala'");

    if (!$kode_penyakit || !$kode_gejala || !$nilai)
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($kombinasi_ada)
        print_msg("Kombinasi diagnosa dan gejala sudah ada!");
    else {
        $db->query("INSERT INTO bayes_aturan (kode_penyakit, kode_gejala, nilai) VALUES ('$kode_penyakit', '$kode_gejala', '$nilai')");
        redirect_js("index_admin.php?m=aturan");
    }
} else if ($mod == 'aturan_ubah') {
    $kode_penyakit = $_POST['kode_penyakit'];
    $kode_gejala = $_POST['kode_gejala'];
    $nilai = $_POST['nilai'];

    $kombinasi_ada = $db->get_row("SELECT * FROM bayes_aturan WHERE kode_penyakit='$kode_penyakit' AND kode_gejala='$kode_gejala' AND ID<>'$_GET[ID]'");

    if (!$kode_penyakit || !$kode_gejala || !$nilai)
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($kombinasi_ada)
        print_msg("Kombinasi penyakit dan gejala sudah ada!");
    else {
        $db->query("UPDATE bayes_aturan SET kode_penyakit='$kode_penyakit', kode_gejala='$kode_gejala', nilai='$nilai' WHERE ID='$_GET[ID]'");
        redirect_js("index_admin.php?m=aturan");
    }
    header("location:index_admin.php?m=aturan");
} else if ($act == 'aturan_hapus') {
    $db->query("DELETE FROM bayes_aturan WHERE ID='$_GET[ID]'");
    header("location:index_admin.php?m=aturan");
}

/** Rekap Detail */
else if ($mod == 'rekap_detail') {
    $kode_penyakit = $_POST['kode_penyakit'];
    $kode_gejala = $_POST['kode_gejala'];
    $nilai = $_POST['nilai'];

    $kombinasi_ada = $db->get_row("SELECT * FROM bayes_aturan WHERE kode_penyakit='$kode_penyakit' AND kode_gejala='$kode_gejala' AND ID<>'$_GET[ID]'");

    if (!$kode_penyakit || !$kode_gejala || !$nilai)
        print_msg("Field bertanda * tidak boleh kosong!");
    elseif ($kombinasi_ada)
        print_msg("Kombinasi penyakit dan gejala sudah ada!");
    else {
        $db->query("UPDATE bayes_aturan SET kode_penyakit='$kode_penyakit', kode_gejala='$kode_gejala', nilai='$nilai' WHERE ID='$_GET[ID]'");
        redirect_js("index_admin.php?m=rekap");
    }
    header("location:index_admin.php?m=rekap");
} else if ($act == 'rekap_hapus') {
    // Hapus data terkait di tabel bayes_konsultasi_detail
    $db->query("DELETE FROM bayes_konsultasi_detail WHERE konsultasi_id='$_GET[ID]'");

    // Hapus data di tabel bayes_konsultasi
    $db->query("DELETE FROM bayes_konsultasi WHERE ID='$_GET[ID]'");

    // Redirect setelah penghapusan
    header("location:index_admin.php?m=rekap");
}

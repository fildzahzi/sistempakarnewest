<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">



<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="assets/images/logosistempakar.ico" />

    <title>Sistem Pakar Penyakit Tebu</title>
    <link href="assets/css/darkly-bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/general.css" rel="stylesheet" />
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@100..900&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/3270fbce75.js" crossorigin="anonymous"></script>

    <!-- Styles -->
    <link href="styles/indexstyle.css" rel="stylesheet">
</head>

<body>
    <div class="main-content">


        <body>
            <div>
                <!-- Sidebar -->
                <nav id="sidebar">
                    <div class="sidebar-header">
                        <img src="assets/images/logosistempakar.png" alt="">
                        <h3><b>Sistem Pakar Penyakit Tebu</b></h3>
                    </div>

                    <ul class="list-unstyled components">
                        <li><a href="?m=dashboard"><i class="fa-solid fa-house"></i><span><b>Dashboard</b></span></a></li>
                        <li><a href="?m=penyakit"><i class="fa-solid fa-disease"></i><span><b>Penyakit</b></span></a></li>
                        <li><a href="?m=gejala"><i class="fa-solid fa-leaf"></i><span><b>Gejala</b></span></a></li>
                        <li><a href="?m=aturan"><i class="fa-solid fa-pen-ruler"></i><span><b>Aturan</b></span></a></li>
                        <li><a href="?m=rekap"><i class="fa-solid fa-rectangle-list"></i><span><b>Rekap Konsultasi</b></span></a></li>
                        <li><a href="aksi.php?act=logout"><i class="fa-solid fa-right-from-bracket"></i><span><b>Logout</b></span></a></li>
                    </ul>
                </nav>
        </body>

        <div>
            <?php
            if (file_exists($mod . '.php')) {
                if (isset($_SESSION['login']) || $mod == 'login' || $mod == 'konsultasi' || $mod == 'thumbs') {
                    include $mod . '.php';
                } else {
                    redirect_js('index_admin.php?m=login');
                }
            } else {
                include 'home_admin.php';
            }
            ?>
        </div>
    </div>
    <footer>
        <div class="kakikiri">
            <p>Sistem Pakar Penyakit Tebu Metode Naive Bayes</p>
            <span>
                Copyright &copy; <?= date('Y') ?>
                <b></b>
            </span>
        </div>
        <div class="kakitengah">
            <!-- <p>Social Media</p>
            <div class="sosmed">
                <a href="#">Facebook</a><br>
                <a href="#">Twitter</a><br>
                <a href="#">Instagram</a> -->
        </div>
        <div class="kakikanan">
            <p><b>Referensi</b></p>
            <p>Buku Saku "Hama dan Penyakit Tebu" & Buku Saku Pengelolaan OPT Tanaman Tebu (revisi 1)</p>

        </div>

    </footer>


</html>
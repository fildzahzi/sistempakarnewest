<?php
include 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" href="favicon.ico" />

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
                        <img src="assets/images/logo.png" alt="">
                        <h3>Sistem Pakar Penyakit Tebu</h3>
                    </div>

                    <ul class="list-unstyled components">
                        <li><a href="?m=dashboard"><i class="fa-solid fa-house"></i>Dashboard</a></li>
                        <li><a href="?m=penyakit"><i class="fa-solid fa-disease"></i>Penyakit</a></li>
                        <li><a href="?m=gejala"><i class="fa-solid fa-leaf"></i>Gejala</a></li>
                        <li><a href="?m=aturan"><i class="fa-solid fa-pen-ruler"></i>Aturan</a></li>
                        <li><a href="?m=rekap"><i class="fa-solid fa-rectangle-list"></i>Rekap Konsultasi</a></li>
                        <li><a href="aksi.php?act=logout"><i class="fa-solid fa-right-from-bracket"></i>Logout</a></li>
                    </ul>
                </nav>
        </body>

        <div>
            <?php
            if (file_exists($mod . '.php')) {
                if (isset($_SESSION['login']) || $mod == 'login' || $mod == 'konsultasi' || $mod == 'thumbs') {
                    include $mod . '.php';
                } else {
                    redirect_js('index.php?m=login');
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
                Copyright &copy; <?= date('Y') ?> <i class="fa fa-heart pulse"></i>
                <b><a href="http://www.mycoding.net" target="_blank">My Coding</a></b>
            </span>
        </div>
        <div class="kakitengah">
            <p>Social Media</p>
            <div class="sosmed">
                <a href="#">Facebook</a><br>
                <a href="#">Twitter</a><br>
                <a href="#">Instagram</a>
            </div>

        </div>
        <div class="kakikanan">
            <p>Referensi</p>
            <p>Buku Saku "Hama dan Penyakit Tebu"</p>

        </div>
        </div>
    </footer>


</html>
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

  <!-- Styles -->
  <link href="styles/indexstyle.css" rel="stylesheet">
</head>

<body>
  <div class="main-content">


    <header class="navbar">
      <div class="navbar-brand">
        <img src="assets/images/logosistempakar.png" alt="Logo Sistem Pakar">
        <a href="?" class="brand-text"><b>Sistem Pakar Penyakit Tebu</b></a>
      </div>
      <div class="navbar-center">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) : ?>
            <li><a href="?m=penyakit">Penyakit</a></li>
            <li><a href="?m=gejala">Gejala</a></li>
            <li><a href="?m=aturan">Aturan</a></li>
            <!-- <li><a href="?m=password">Password</a></li> -->
            <li><a href="?m=konsultasi">Konsultasi</a></li>
            <li><a href="?m=rekap">Rekap Konsultasi</a></li>
          <?php endif ?>
        </ul>
      </div>
      <div class="navbar-right">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) : ?>
            <li><a href="aksi.php?act=logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
          <?php else : ?>
            <li><a href="?m=konsultasi"><b>Konsultasi</b></a></li>
            <li><a href="?m=login"><span class="glyphicon glyphicon-log-in"></span> <b>Login Admin</b></a></li>
          <?php endif ?>
        </ul>
      </div>

    </header>
    <div>
      <?php
      if (file_exists($mod . '.php')) {
        if (isset($_SESSION['login']) || $mod == 'login' || $mod == 'konsultasi' || $mod == 'thumbs') {
          include $mod . '.php';
        } else {
          redirect_js('index.php?m=login');
        }
      } else {
        include 'home.php';
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

  <!-- <script>
    // Fungsi untuk mengecek ukuran jendela dan menyembunyikan/munculkan teks
    function checkScreenSize() {
      const brandText = document.querySelector('.navbar-brand .brand-text'); // Selector untuk teks
      if (window.innerWidth < 768) { // Ukuran max-width untuk handphone
        brandText.style.display = 'none'; // Sembunyikan teks
      } else {
        brandText.style.display = 'inline'; // Tampilkan teks kembali
      }
    }

    // Panggil fungsi saat halaman dimuat
    checkScreenSize();

    // Tambahkan event listener untuk resize
    window.addEventListener('resize', checkScreenSize);
  </script> -->


</html>
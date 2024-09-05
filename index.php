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

  <!-- Styles -->
  <link href="styles/indexstyle.css" rel="stylesheet">
</head>

<body>
  <div class="main-content">


    <header class="navbar">
      <div class="navbar-brand">
        <img src="assets/images/logo.png" alt="">
        <a href="?">Sistem Pakar Penyakit Tebu</a>
      </div>
      <div class="navbar-center">
        <ul class="nav navbar-nav">
          <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) : ?>
            <li><a href="?m=penyakit">Penyakit</a></li>
            <li><a href="?m=gejala">Gejala</a></li>
            <li><a href="?m=aturan">Aturan</a></li>
            <li><a href="?m=password">Password</a></li>
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
            <li><a href="?m=konsultasi">Konsultasi</a></li>
            <li><a href="?m=login"><span class="glyphicon glyphicon-log-in"></span> Login Admin</a></li>
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
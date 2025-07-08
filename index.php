<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Ubah X-UA-Compatible jadi http-equiv -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Website Inventory Toko Nor'in"> <!-- Deskripsi lebih spesifik -->
    <meta name="author" content="Naufal Wiyura">

    <title>Inventory Barang - Toko Nor'in</title> <!-- Judul lebih SEO friendly -->

    <!-- Bootstrap -->
    <link href="vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <!-- <link href="vendor/css/bootstrap/bootstrap.css" rel="stylesheet"> --> <!-- Cukup satu, min.css untuk produksi -->

    <!-- Font Awesome -->
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Google Fonts (Optional, tapi sangat direkomendasikan untuk tampilan modern) -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">

    <!-- Tema CSS Kustom Anda -->
    <link href="css/tampilan.css" rel="stylesheet">

</head>
<body>

<!-- Menu -->
<nav class="navbar navbar-default navbar-fixed-top navbar-custom">
  <div class="container">
    <div class="navbar-header page-scroll">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <i class="fa fa-bars"></i> <!-- Sudah menggunakan fa-bars, bagus! -->
      </button>
      <a class="navbar-brand" href="index.php">NOR'IN</a> <!-- Beri href ke index.php -->
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
        <li class="page-scroll">
          <a href="index.php">Beranda</a>
        </li>
        <li class="page-scroll">
          <a href="#login">Masuk</a>
        </li>
        <li class="page-scroll">
          <a href="#tentang">Tentang</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Header atau gambar (Carousel) -->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li> <!-- Tambah class active di yg pertama -->
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner" role="listbox">
    <div class="item active">
      <img class="first-slide" src="images/toko.png" alt="Toko Nor'in"> <!-- Alt text lebih deskriptif -->
    </div>
    <div class="item">
      <img class="second-slide" src="images/logistic2.jpg" alt="Proses Logistik">
    </div>
    <div class="item">
      <img class="third-slide" src="images/logistic3.jpg" alt="Manajemen Gudang">
    </div>
  </div>
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="fa fa-chevron-left" aria-hidden="true"></span> <!-- Menggunakan Font Awesome Icon -->
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="fa fa-chevron-right" aria-hidden="true"></span> <!-- Menggunakan Font Awesome Icon -->
    <span class="sr-only">Next</span>
  </a>
</div>

<!-- Login Feature Section Start -->
<section id="login" class="section-container">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center modern-panel">
                <h2 class="section-heading">MASUK SEBAGAI</h2>
                <hr class="short-hr">
                <a href="admin/login.php" target="_blank" class="btn btn-custom btn-custom-primary">ADMIN</a>
                <a href="petugas/login_petugas.php" target="_blank" class="btn btn-custom btn-custom-secondary">PETUGAS</a>
            </div>
        </div>
    </div>
</section>

<!-- Tentang Section Start -->
<section id="tentang" class="section-container section-bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center modern-panel">
                <h2 class="section-heading">WEBSITE INVENTORY TOKO NOR'IN</h2>
                <hr class="short-hr">
                <p class="lead">Website inventory ini dirancang untuk mengatur dan mencatat keluar masuk barang di setiap gudang dalam perusahaan Anda. Ini mencakup pencatatan barang masuk dari Supplier dan pencatatan barang keluar secara efisien.</p>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer-modern">
  <div class="container text-center">
    <ul class="list-inline social-icons">
      <li>
        <a href="https://www.facebook.com/naufalwiyuras" target="_blank"><i class="fa fa-facebook fa-fw"></i></a>
      </li>
      <li>
        <a href="https://github.com/" target="_blank"><i class="fa fa-github fa-fw"></i></a>
      </li>
      <!-- Tambahkan ikon sosial media lain jika ada -->
    </ul>
    <p class="copyright-text">Copyright © <script>document.write(new Date().getFullYear());</script> Naufal Wiyura. All Rights Reserved.</p>
  </div>
</footer>

<!-- jQuery -->
<script src="vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap JS -->
<script src="vendor/css/js/bootstrap.min.js"></script>

</body>
</html>
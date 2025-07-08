<?php
include_once '../koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Dashboard Nor'in">
    <meta name="author" content="Naufal Wiyura">
    <title><?php echo isset($judul) ? htmlspecialchars($judul) : "Data Petugas"; ?></title>

    <link href="../vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="../css/tampilanadmin-interactive.css" rel="stylesheet">
</head>
<body>
    <div id="wrapper" class="admin-layout">

        <nav class="navbar admin-navbar navbar-fixed-top" role="navigation">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".admin-sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="?m=awal.php">NOR'IN</a>
            </div>
            <?php
            $nama_user_display = 'Pengguna';
            $foto_user_display = '../images/default-avatar.png';
            if (isset($_SESSION['idinv']) && isset($koneksi)) {
                $id_admin_session = $_SESSION['idinv'];
                $sql_user = "SELECT nama, foto FROM tb_admin WHERE id_admin = ?";
                $stmt_user = mysqli_prepare($koneksi, $sql_user);
                mysqli_stmt_bind_param($stmt_user, "s", $id_admin_session);
                mysqli_stmt_execute($stmt_user);
                $result_user = mysqli_stmt_get_result($stmt_user);
                if ($user_data = mysqli_fetch_array($result_user)) {
                    $nama_user_display = htmlspecialchars($user_data['nama']);
                    if (!empty($user_data['foto']) && file_exists('../images/admin/' . $user_data['foto'])) {
                        $foto_user_display = '../images/admin/' . htmlspecialchars($user_data['foto']);
                    }
                }
                mysqli_stmt_close($stmt_user);
            }
            ?>
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown user-menu">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-haspopup="true" aria-expanded="false">
                        <img src="<?php echo $foto_user_display; ?>" class="user-avatar" alt="Avatar">
                        <span class="username hidden-xs"><?php echo $nama_user_display; ?></span> <i class="fa fa-caret-down icon-caret"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right user-dropdown-menu">
                        <li><a href="#"><i class="fa fa-user fa-fw"></i> Profil</a></li>
                        <li><a href="#"><i class="fa fa-cog fa-fw"></i> Pengaturan</a></li>
                        <li class="divider"></li>
                        <li>
                            <form action="logout.php" method="post" style="margin:0;">
                                <button type="submit" name="keluar" class="btn-logout-link" onclick="return confirm('Yakin ingin logout?');">
                                    <i class="fa fa-sign-out fa-fw"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

            <div class="admin-sidebar admin-sidebar-collapse" role="navigation">
                <div class="sidebar-nav">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-brand-item">
                            <a href="?m=awal.php" class="sidebar-brand-link">
                                <i class="fa fa-cubes brand-icon"></i>
                                <span class="brand-text">NOR'IN INV</span>
                            </a>
                        </li>
                        <li class="nav-header">MENU UTAMA</li>
                        <li><a href="?m=awal.php" class="<?php echo (!isset($_GET['m']) || $_GET['m'] == 'awal.php') ? 'active' : ''; ?>"><i class="fa fa-dashboard fa-fw"></i><span>Beranda</span></a></li>
                        <li><a href="?m=admin&s=awal" class="<?php echo (isset($_GET['m']) && $_GET['m'] == 'admin') ? 'active' : ''; ?>"><i class="fa fa-user fa-fw"></i><span>Data Admin</span></a></li>
                        <li><a href="?m=petugas&s=awal" class="<?php echo (isset($_GET['m']) && $_GET['m'] == 'petugas') ? 'active' : ''; ?>"><i class="fa fa-users fa-fw"></i><span>Data Petugas</span></a></li>
                        <li><a href="?m=supplier&s=awal" class="<?php echo (isset($_GET['m']) && $_GET['m'] == 'supplier') ? 'active' : ''; ?>"><i class="fa fa-building fa-fw"></i><span>Data Supplier</span></a></li>
                        <li><a href="?m=rak&s=awal" class="<?php echo (isset($_GET['m']) && $_GET['m'] == 'rak') ? 'active' : ''; ?>"><i class="fa fa-cubes fa-fw"></i><span>Data Rak</span></a></li>
                        <li><a href="?m=barang&s=awal" class="<?php echo (isset($_GET['m']) && $_GET['m'] == 'barang') ? 'active' : ''; ?>"><i class="fa fa-archive fa-fw"></i><span>Data Barang</span></a></li>
                        <li><a href="?m=barangKeluar&s=awal" class="<?php echo (isset($_GET['m']) && $_GET['m'] == 'barangKeluar') ? 'active' : ''; ?>"><i class="fa fa-cart-arrow-down fa-fw"></i><span>Barang Keluar</span></a></li>
                        <li class="nav-header">AKUN</li>
                        <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?')"><i class="fa fa-sign-out fa-fw"></i><span>Logout</span></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="page-content-wrapper">
            <div class="container-fluid">
                <div class="row page-header-container">
                    <div class="col-lg-8">
                        <h1 class="page-title">Data Petugas</h1>
                        <p class="page-subtitle">Manajemen data pengguna dengan hak akses petugas.</p>
                    </div>
                    <div class="col-lg-4 text-right action-buttons-container">
                        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addPetugasModal">
                            <span class="icon text-white-50"><i class="fa fa-plus"></i></span>
                            <span class="text">Tambah Petugas</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm data-table-card">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Daftar Petugas</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover interactive-table" id="petugasDataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ID Petugas</th>
                                                <th>Nama</th>
                                                <th>Telepon</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($koneksi)) {
                                                // Assuming 'paging.php' is adapted for personnel data
                                                include 'paging.php';
                                            } else {
                                                echo "<tr><td colspan='5' class='text-center'>Koneksi database tidak tersedia.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (isset($total_halaman) && $total_halaman > 1 && isset($koneksi)): ?>
                                <nav aria-label="Page navigation" class="mt-4">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php if($halaman <= 1){ echo 'disabled'; } ?>">
                                            <a class="page-link" href="<?php if($halaman > 1){ echo "?m=petugas&s=awal&halaman=$previous"; } else { echo '#';} ?>">Previous</a>
                                        </li>
                                        <?php for($x=1; $x<=$total_halaman; $x++): ?>
                                        <li class="page-item <?php if($halaman == $x) {echo 'active';} ?>">
                                            <a class="page-link" href="?m=petugas&s=awal&halaman=<?php echo $x ?>"><?php echo $x; ?></a>
                                        </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php if($halaman >= $total_halaman) {echo 'disabled';} ?>">
                                            <a class="page-link" href="<?php if($halaman < $total_halaman) { echo "?m=petugas&s=awal&halaman=$next"; } else {echo '#';} ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></div><div class="modal fade" id="addPetugasModal" tabindex="-1" role="dialog" aria-labelledby="addPetugasModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content interactive-modal">
          <div class="modal-header">
            <h5 class="modal-title" id="addPetugasModalLabel">Tambah Data Petugas Baru</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <form action="?m=petugas&s=simpan" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" required>
                            <div class="invalid-feedback">Username wajib diisi.</div>
                        </div>
                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required>
                            <div class="invalid-feedback">Password wajib diisi.</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama lengkap" required>
                            <div class="invalid-feedback">Nama wajib diisi.</div>
                        </div>
                        <div class="form-group">
                            <label for="telepon">Nomor Telepon</label>
                            <input type="tel" class="form-control" id="telepon" name="telepon" placeholder="Contoh: 08123456789">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
              <button type="submit" name="simpan" class="btn btn-primary">Simpan Data</button>
            </div>
          </form>
        </div>
      </div>
    </div>


    <footer class="admin-footer">
      <div class="container-fluid">
        <p>Copyright © <script>document.write(new Date().getFullYear());</script> Naufal Wiyura. All rights reserved.</p>
      </div>
    </footer>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/js/bootstrap.bundle.min.js"></script>
    <script>
    // Script for Bootstrap form validation
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
    </script>
  </body>
</html>
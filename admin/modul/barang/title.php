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
    <title><?php echo isset($judul) ? htmlspecialchars($judul) : "Admin Dashboard"; ?></title>

    <link href="../vendor/css/bootstrap/bootstrap.min.css" rel="stylesheet">
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">

    <link href="../css/tampilanadmin-interactive.css" rel="stylesheet"> </head>
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
            // session_start(); // Pastikan session sudah dimulai
            $nama_user_display = 'Pengguna';
            $foto_user_display = '../images/default-avatar.png'; // Sediakan default avatar
            if (isset($_SESSION['idinv'])) {
                $id_admin_session = $_SESSION['idinv'];
                // include_once '../koneksi.php'; // Idealnya include sekali di awal script
                if (isset($koneksi)) {
                    $sql_user = "SELECT nama, foto FROM tb_admin WHERE id_admin = ?";
                    $stmt_user = mysqli_prepare($koneksi, $sql_user);
                    mysqli_stmt_bind_param($stmt_user, "s", $id_admin_session);
                    mysqli_stmt_execute($stmt_user);
                    $result_user = mysqli_stmt_get_result($stmt_user);
                    if ($user_data = mysqli_fetch_array($result_user)) {
                        $nama_user_display = htmlspecialchars($user_data['nama']);
                        $foto_path = '../images/admin/' . htmlspecialchars($user_data['foto']);
                        if (!empty($user_data['foto']) && file_exists($foto_path)) {
                            $foto_user_display = $foto_path;
                        }
                    }
                    mysqli_stmt_close($stmt_user);
                }
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
                        <h1 class="page-title">Data Barang</h1>
                        <p class="page-subtitle">Manajemen data stok barang masuk dan keluar.</p>
                    </div>
                    <div class="col-lg-4 text-right action-buttons-container">
                        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addBarangModal">
                            <span class="icon text-white-50"><i class="fa fa-plus"></i></span>
                            <span class="text">Tambah Barang</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm data-table-card">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Daftar Barang</h6>
                                <div class="filter-container">
                                     <form action="" method="POST" class="form-inline">
                                        <input class="form-control form-control-sm mr-sm-2" type="text" name="cari" placeholder="Cari Barang..." aria-label="Search">
                                        <button class="btn btn-outline-primary btn-sm my-2 my-sm-0" type="submit" name="go">Cari</button>
                                    </form>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover interactive-table" id="barangDataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stok</th>
                                                <th>Rak</th>
                                                <th>Supplier</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($koneksi)) {
                                                include 'paging.php'; // Pastikan script paging.php disesuaikan
                                            } else {
                                                echo "<tr><td colspan='7' class='text-center'>Koneksi database tidak tersedia.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (isset($total_halaman) && $total_halaman > 1 && isset($koneksi)): ?>
                                <nav aria-label="Page navigation" class="mt-4">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item <?php if($halaman <= 1){ echo 'disabled'; } ?>">
                                            <a class="page-link" href="<?php if($halaman > 1){ echo "?m=barang&s=awal&halaman=$previous"; } else { echo '#';} ?>">Previous</a>
                                        </li>
                                        <?php for($x=1; $x<=$total_halaman; $x++): ?>
                                        <li class="page-item <?php if($halaman == $x) {echo 'active';} ?>">
                                            <a class="page-link" href="?m=barang&s=awal&halaman=<?php echo $x ?>"><?php echo $x; ?></a>
                                        </li>
                                        <?php endfor; ?>
                                        <li class="page-item <?php if($halaman >= $total_halaman) {echo 'disabled';} ?>">
                                            <a class="page-link" href="<?php if($halaman < $total_halaman) { echo "?m=barang&s=awal&halaman=$next"; } else {echo '#';} ?>">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></div><div class="modal fade" id="addBarangModal" tabindex="-1" role="dialog" aria-labelledby="addBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content interactive-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBarangModalLabel">Tambah Data Barang Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="?m=barang&s=simpan" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="kode_brg">Kode Barang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="kode_brg" name="kode_brg" placeholder="Masukkan Kode Barang" maxlength="5" required>
                                    <div class="invalid-feedback">Kode barang wajib diisi.</div>
                                </div>
                                <div class="form-group">
                                    <label for="nama_brg">Nama Barang <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama_brg" name="nama_brg" placeholder="Masukkan Nama Lengkap" required>
                                    <div class="invalid-feedback">Nama barang wajib diisi.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="stok">Stok Awal <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="stok" name="stok" placeholder="Masukkan Jumlah Stok" required>
                                    <div class="invalid-feedback">Stok wajib diisi.</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="rak">Rak <span class="text-danger">*</span></label>
                                    <select class="form-control" id="rak" name="rak" required>
                                        <option value="" disabled selected>Pilih Rak</option>
                                        <?php 
                                        if (isset($koneksi)) {
                                            $sql_rak = "SELECT nama_rak FROM tb_rak ORDER BY nama_rak";
                                            $hasil_rak = mysqli_query($koneksi, $sql_rak);
                                            while ($data_rak = mysqli_fetch_array($hasil_rak)) {
                                                echo '<option value="'.htmlspecialchars($data_rak['nama_rak']).'">'.htmlspecialchars($data_rak['nama_rak']).'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih rak.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="supplier">Supplier <span class="text-danger">*</span></label>
                                    <select class="form-control" id="supplier" name="supplier" required>
                                        <option value="" disabled selected>Pilih Supplier</option>
                                        <?php
                                        if (isset($koneksi)) {
                                            $sql_sup = "SELECT nama_sup FROM tb_sup ORDER BY nama_sup";
                                            $hasil_sup = mysqli_query($koneksi, $sql_sup);
                                            while ($data_sup = mysqli_fetch_array($hasil_sup)) {
                                                echo '<option value="'.htmlspecialchars($data_sup['nama_sup']).'">'.htmlspecialchars($data_sup['nama_sup']).'</option>';
                                            }
                                        }
                                        ?>
                                    </select>
                                    <div class="invalid-feedback">Silakan pilih supplier.</div>
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
    <script src="../vendor/js/bootstrap.bundle.min.js"></script> <script>
    // Script untuk validasi form Bootstrap
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
<?php 
// It's assumed session_start() and include '../koneksi.php' have been called on a parent page.
date_default_timezone_set("Asia/Jakarta");
$tanggalSekarang = date("Y-m-d");
$jamSekarang = date("H:i:s"); // Using 24-hour format for consistency
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
    <title><?php echo isset($judul) ? htmlspecialchars($judul) : "Data Barang Masuk"; ?></title>

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
                // Using prepared statements to prevent SQL injection
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
                        <li><a href="?m=barangMasuk&s=awal" class="<?php echo (isset($_GET['m']) && $_GET['m'] == 'barangMasuk') ? 'active' : ''; ?>"><i class="fa fa-cart-plus fa-fw"></i><span>Barang Masuk</span></a></li>
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
                        <h1 class="page-title">Data Barang Masuk</h1>
                        <p class="page-subtitle">Pencatatan barang yang diterima dari supplier.</p>
                    </div>
                    <div class="col-lg-4 text-right action-buttons-container">
                        <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#addBarangMasukModal">
                            <span class="icon text-white-50"><i class="fa fa-plus"></i></span>
                            <span class="text">Tambah Data</span>
                        </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card shadow-sm data-table-card">
                            <div class="card-header">
                                <h6 class="m-0 font-weight-bold text-primary">Daftar Barang Masuk</h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover interactive-table" id="barangMasukTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>No. Invoice</th>
                                                <th>Tanggal</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah Masuk</th>
                                                <th>Supplier</th>
                                                <th>Petugas</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if (isset($koneksi)) {
                                                // Assuming 'paging.php' is adapted to fetch and display incoming goods data
                                                include 'paging.php';
                                            } else {
                                                echo "<tr><td colspan='8' class='text-center'>Koneksi database tidak tersedia.</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div></div><div class="modal fade" id="addBarangMasukModal" tabindex="-1" role="dialog" aria-labelledby="addBarangMasukModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content interactive-modal">
                <div class="modal-header">
                    <h5 class="modal-title" id="addBarangMasukModalLabel">Tambah Data Barang Masuk</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="?m=barangMasuk&s=simpan" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="noinv">No. Invoice <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="noinv" name="noinv" placeholder="Masukkan Nomor Invoice" required>
                                    <div class="invalid-feedback">Nomor invoice wajib diisi.</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal">Tanggal Masuk <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="tanggal" name="tanggal" value="<?php echo $tanggalSekarang; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="kode_brg">Kode Barang <span class="text-danger">*</span></label>
                            <select class="form-control" name="kode_brg" id="kode_brg" required>
                                <option value="" selected disabled>--- Pilih Kode Barang ---</option>
                                <?php 
                                if (isset($koneksi)) {
                                    $query_brg = "SELECT * FROM tb_barang ORDER BY nama_brg";
                                    $result_brg = mysqli_query($koneksi, $query_brg);
                                    $jsArray = "var prdName = new Array();\n";
                                    while ($row = mysqli_fetch_array($result_brg)) {
                                        echo '<option value="'. htmlspecialchars($row['kode_brg']) .'">'. htmlspecialchars($row['kode_brg']) .' - '. htmlspecialchars($row['nama_brg']) .'</option>';
                                        $jsArray .= "prdName['". $row['kode_brg'] ."'] = {
                                            nama_brg:'". addslashes(htmlspecialchars($row['nama_brg'])) ."',
                                            stok:'". addslashes(htmlspecialchars($row['stok'])) ."',
                                            supplier:'". addslashes(htmlspecialchars($row['supplier'])) ."'
                                        };\n";
                                    }
                                }
                                ?>
                            </select>
                            <div class="invalid-feedback">Silakan pilih kode barang.</div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Barang</label>
                                    <input type="text" name="nama_brg" readonly id="prd_nmbrg" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Supplier Terkait</label>
                                    <input type="text" name="supplier" readonly id="prd_sup" class="form-control">
                                </div>
                            </div>
                             <div class="col-md-6">
                                <div class="form-group">
                                    <label>Stok Saat Ini</label>
                                    <input type="number" readonly id="prd_stk" name="stok" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="jml_masuk">Jumlah Masuk <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="jml_masuk" name="jml_masuk" placeholder="Masukkan jumlah barang" required min="1">
                                    <div class="invalid-feedback">Jumlah masuk wajib diisi dan minimal 1.</div>
                                </div>
                            </div>
                        </div>
                         <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Jam</label>
                                    <input type="text" class="form-control" value="<?php echo $jamSekarang; ?>" name="jam" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
                                 <div class="form-group">
                                    <label>Petugas</label>
                                    <input type="text" class="form-control" value="<?php echo $nama_user_display; ?>" name="petugas" readonly>
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
    // Script untuk auto-fill data barang di modal
    <?php echo isset($jsArray) ? $jsArray : ''; ?>
    function changeValue(id) {
        if (prdName[id]) {
            document.getElementById('prd_nmbrg').value = prdName[id].nama_brg;
            document.getElementById('prd_stk').value = prdName[id].stok;
            document.getElementById('prd_sup').value = prdName[id].supplier;
        } else {
            document.getElementById('prd_nmbrg').value = '';
            document.getElementById('prd_stk').value = '';
            document.getElementById('prd_sup').value = '';
        }
    }
    
    // Listener untuk select barang
    document.getElementById('kode_brg').addEventListener('change', function() {
        changeValue(this.value);
    });

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
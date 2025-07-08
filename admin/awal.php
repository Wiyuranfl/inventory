<?php
// It's assumed session_start() has been called.
include_once '../koneksi.php';

// Check if the user is logged in, redirect to login page if not.
if (!isset($_SESSION["idinv"])) {
    header("Location: login.php");
    exit();
}

// --- Data Fetching Optimization ---
// Fetch all counts with a single connection and a series of queries.
$counts = [
    'admin' => 0,
    'supplier' => 0,
    'rak' => 0,
    'barang' => 0,
    'barang_in' => 0,
    'ajuan' => 0,
    'barang_out' => 0
];

if (isset($koneksi)) {
    // Get Admin's info for the welcome message
    $id_admin_session = $_SESSION['idinv'];
    $sql_user = "SELECT nama, foto FROM tb_admin WHERE id_admin = ?";
    $stmt_user = mysqli_prepare($koneksi, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "s", $id_admin_session);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);
    $user_data = mysqli_fetch_assoc($result_user);
    mysqli_stmt_close($stmt_user);

    // Get all counts
    $queries = [
        'admin' => "SELECT count(id_admin) as count FROM tb_admin",
        'supplier' => "SELECT count(id_sup) as count FROM tb_sup",
        'rak' => "SELECT count(id_rak) as count FROM tb_rak",
        'barang' => "SELECT count(kode_brg) as count FROM tb_barang",
        'barang_in' => "SELECT count(id_brg_in) as count FROM tb_barang_in",
        'ajuan' => "SELECT count(no_ajuan) as count FROM tb_ajuan",
        'barang_out' => "SELECT count(no_brg_out) as count FROM tb_barang_out"
    ];

    foreach ($queries as $key => $sql) {
        if ($result = mysqli_query($koneksi, $sql)) {
            $row = mysqli_fetch_assoc($result);
            $counts[$key] = $row['count'];
        }
    }
}

$nama_user_display = isset($user_data['nama']) ? htmlspecialchars($user_data['nama']) : 'Pengguna';
$foto_user_display = '../images/default-avatar.png';
if (isset($user_data['foto']) && !empty($user_data['foto']) && file_exists('../images/admin/' . $user_data['foto'])) {
    $foto_user_display = '../images/admin/' . htmlspecialchars($user_data['foto']);
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Admin Dashboard Nor'in">
    <meta name="author" content="Naufal Wiyura">
    <title><?php echo isset($judul) ? htmlspecialchars($judul) : "Dashboard"; ?></title>

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
                    <div class="col-lg-12">
                        <h1 class="page-title">Selamat Datang, <?php echo $nama_user_display; ?>!</h1>
                        <p class="page-subtitle">Ringkasan data dan statistik dari sistem inventaris Anda.</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-primary shadow-sm h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Jumlah Admin</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts['admin']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-user fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                             <a href="?m=admin&s=awal" class="card-footer-link">
                                <span>Lihat Detail</span>
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                    
                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-success shadow-sm h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Jumlah Supplier</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts['supplier']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-building fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                            <a href="?m=supplier&s=awal" class="card-footer-link">
                                <span>Lihat Detail</span>
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-info shadow-sm h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Rak</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts['rak']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-cubes fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                             <a href="?m=rak&s=awal" class="card-footer-link">
                                <span>Lihat Detail</span>
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-warning shadow-sm h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Jenis Barang</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts['barang']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-archive fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                             <a href="?m=barang&s=awal" class="card-footer-link">
                                <span>Lihat Detail</span>
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-danger shadow-sm h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Transaksi Barang Keluar</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts['barang_out']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-cart-arrow-down fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                             <a href="?m=barangKeluar&s=awal" class="card-footer-link">
                                <span>Lihat Detail</span>
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>

                     <div class="col-xl-4 col-md-6 mb-4">
                        <div class="card border-left-secondary shadow-sm h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-secondary text-uppercase mb-1">Transaksi Barang Masuk</div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $counts['barang_in']; ?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fa fa-cart-plus fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                             <a href="?m=barangMasuk&s=awal" class="card-footer-link">
                                <span>Lihat Detail</span>
                                <i class="fa fa-arrow-circle-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div></div><footer class="admin-footer">
      <div class="container-fluid">
        <p>Copyright © <script>document.write(new Date().getFullYear());</script> Naufal Wiyura. All rights reserved.</p>
      </div>
    </footer>

    <script src="../vendor/jquery/jquery.min.js"></script>
    <script src="../vendor/js/bootstrap.bundle.min.js"></script>

</body>
</html>
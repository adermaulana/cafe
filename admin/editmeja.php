<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login' || !isset($_SESSION['username_admin'])){

    header("location:../");

}

$kode_meja = "";
$nomor_meja = "";
$kapasitas = "";
$status = "";

// Check if it's an edit operation
if(isset($_GET['hal'])){
    if($_GET['hal'] == "edit"){
        $tampil = mysqli_query($koneksi, "SELECT * FROM meja_221042 WHERE kode_meja_221042 = '$_GET[kode]'");
        $data = mysqli_fetch_array($tampil);
        if($data){
            $kode_meja = $data['kode_meja_221042'];
            $nomor_meja = $data['nomor_meja_221042'];
            $kapasitas = $data['kapasitas_221042'];
            $status = $data['status_221042'];
        }
    }
}

// Process form submission
if (isset($_POST['update'])) {
    $kode_meja = $_POST['kode_meja'];
    $nomor_meja = $_POST['nomor_meja'];
    $kapasitas = $_POST['kapasitas'];
    $status = $_POST['status'];
    
    // Query to update data in database
    $update = mysqli_query($koneksi, "UPDATE meja_221042 
                                    SET nomor_meja_221042 = '$nomor_meja', 
                                        kapasitas_221042 = '$kapasitas', 
                                        status_221042 = '$status' 
                                    WHERE kode_meja_221042 = '$kode_meja'");

    // Check if update was successful
    if ($update) {
        echo "<script>
                alert('Meja berhasil diperbarui!');
                document.location='meja.php';
            </script>";
    } else {
        echo "<script>
                alert('Gagal memperbarui meja! " . mysqli_error($koneksi) . "');
            </script>";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="../assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- <link rel="stylesheet" href="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css"> -->
    <link rel="stylesheet" href="../assets/vendors/datatables.net-bs5/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="../assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" type="text/css" href="../assets/js/select.dataTables.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="../assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <a class="navbar-brand brand-logo me-5" href="index.php"><img src="" class="me-2" alt="logo" /></a>
    <a class="navbar-brand brand-logo-mini" href="index.php"><img src="" alt="logo" /></a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="icon-menu"></span>
    </button>
    <ul class="navbar-nav mr-lg-2">
      <li class="nav-item nav-search d-none d-lg-block">
        <div class="input-group">
          <div class="input-group-prepend hover-cursor" id="navbar-search-icon">
            <span class="input-group-text" id="search">
              <i class="icon-search"></i>
            </span>
          </div>
          <input type="text" class="form-control" id="navbar-search-input" placeholder="Search now" aria-label="search" aria-describedby="search">
        </div>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">

      <li class="nav-item nav-profile dropdown">
        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="profileDropdown">
          <img src="../assets/images/faces/face28.jpg" alt="profile" />
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
          <a class="dropdown-item" href="logout.php">
            <i class="ti-power-off text-primary"></i> Logout </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="icon-menu"></span>
    </button>
  </div>
</nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
        <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="index.php">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>

    <li class="nav-item">
      <a class="nav-link" href="menu.php">
        <i class="icon-menu menu-icon"></i>
        <span class="menu-title">Manajemen Menu</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="meja.php">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Manajemen Meja</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pengguna.php">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Manajemen Pengguna</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Reservasi</span>
      </a>
    </li>
            <li class="nav-item">
              <a class="nav-link" href="pesanan.php">
                <i class="icon-paper menu-icon"></i>
                <span class="menu-title">Pesanan</span>
              </a>
            </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Pembayaran</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="">
        <i class="icon-paper menu-icon"></i>
        <span class="menu-title">Laporan</span>
      </a>
    </li>
  </ul>
</nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-md-8 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Edit Meja</h4>
                                <form class="forms-sample" method="POST">
                                    <div class="form-group">
                                        <label for="kode_meja">Kode Meja</label>
                                        <input type="text" class="form-control" id="kode_meja" name="kode_meja" value="<?= $kode_meja ?>" placeholder="Kode Meja" readonly>
                                        <small class="form-text text-muted">Kode meja tidak dapat diubah.</small>
                                    </div>
                                    <div class="form-group">
                                        <label for="nomor_meja">Nomor Meja</label>
                                        <input type="text" class="form-control" id="nomor_meja" name="nomor_meja" value="<?= $nomor_meja ?>" placeholder="Nomor Meja" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="kapasitas">Kapasitas</label>
                                        <input type="number" class="form-control" id="kapasitas" name="kapasitas" value="<?= $kapasitas ?>" placeholder="Kapasitas" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="Kosong" <?= ($status == 'Kosong') ? 'selected' : '' ?>>Kosong</option>
                                            <option value="Terisi" <?= ($status == 'Terisi') ? 'selected' : '' ?>>Terisi</option>
                                            <option value="Reservasi" <?= ($status == 'Reservasi') ? 'selected' : '' ?>>Reservasi</option>
                                        </select>
                                    </div>
                                    <button type="submit" name="update" class="btn btn-primary me-2">Update</button>
                                    <a href="meja.php" class="btn btn-light">Cancel</a>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
            <!-- partial:../../partials/_footer.html -->
            <footer class="footer">
                <div class="d-sm-flex justify-content-center justify-content-sm-between">
                    <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright © 2023. Premium <a href="https://www.bootstrapdash.com/" target="_blank">Bootstrap admin template</a> from BootstrapDash. All rights reserved.</span>
                    <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ms-1"></i></span>
                </div>
            </footer>
            <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="../assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="../assets/vendors/chart.js/chart.umd.js"></script>
    <script src="../assets/vendors/datatables.net/jquery.dataTables.js"></script>
    <!-- <script src="assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js"></script> -->
    <script src="../assets/vendors/datatables.net-bs5/dataTables.bootstrap5.js"></script>
    <script src="../assets/js/dataTables.select.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="../assets/js/off-canvas.js"></script>
    <script src="../assets/js/template.js"></script>
    <script src="../assets/js/settings.js"></script>
    <script src="../assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="../assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="../assets/js/dashboard.js"></script>
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->

  </body>
</html>
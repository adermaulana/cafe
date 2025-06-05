<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login' || !isset($_SESSION['username_pelanggan'])){

    header("location:../");

}

$kode_pesanan = $_GET['kode'] ?? '';

// Query untuk mengambil data pesanan
$query_pesanan = mysqli_query($koneksi, "
    SELECT p.*, pl.nama_221042 as nama_pelanggan, pl.telepon_221042, pl.email_221042,
           m.nomor_meja_221042, m.kapasitas_221042,
           pb.metode_pembayaran_221042, pb.status_221042 as status_pembayaran, pb.jumlah_221042 as jumlah_pembayaran
    FROM pesanan_221042 p
    LEFT JOIN pelanggan_221042 pl ON p.nik_221042 = pl.nik_221042
    LEFT JOIN reservasi_221042 r ON p.kode_reservasi_221042 = r.kode_reservasi_221042
    LEFT JOIN meja_221042 m ON r.kode_meja_221042 = m.kode_meja_221042
    LEFT JOIN pembayaran_221042 pb ON p.kode_pesanan_221042 = pb.kode_pesanan_221042
    WHERE p.kode_pesanan_221042 = '$kode_pesanan'
");
$data_pesanan = mysqli_fetch_array($query_pesanan);

// Query untuk mengambil detail pesanan (item-item yang dipesan)
$query_detail = mysqli_query($koneksi, "
    SELECT dp.*, m.nama_menu_221042, m.harga_221042, m.gambar_221042
    FROM detail_pesanan_221042 dp
    LEFT JOIN menu_221042 m ON dp.kode_menu_221042 = m.kode_menu_221042
    WHERE dp.kode_pesanan_221042 = '$kode_pesanan'
");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Pelanggan</title>
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
      <a class="nav-link" href="../daftarmenu.php">
        <i class="icon-grid menu-icon"></i>
        <span class="menu-title">Pesan Menu</span>
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
  </ul>
</nav>
        <!-- partial -->
        <div class="main-panel">
            <div class="content-wrapper">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h4 class="card-title">Detail Pesanan</h4>
                                    <a class="btn btn-secondary" href="pesanan.php">Kembali ke Daftar Pesanan</a>
                                </div>

                                <?php if($data_pesanan): ?>
                                <!-- Informasi Pesanan -->
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Informasi Pesanan</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong>Kode Pesanan:</strong></td>
                                                        <td><?= $data_pesanan['kode_pesanan_221042'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Tanggal Pesanan:</strong></td>
                                                        <td><?= date('d/m/Y H:i', strtotime($data_pesanan['tanggal_pesanan_221042'])) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Total:</strong></td>
                                                        <td><strong><?= 'Rp ' . number_format($data_pesanan['total_221042'], 0, ',', '.') ?></strong></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Catatan:</strong></td>
                                                        <td><?= $data_pesanan['catatan_221042'] ?? '<span class="text-muted">Tidak ada catatan</span>' ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Informasi Pelanggan & Meja</h5>
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-borderless">
                                                    <tr>
                                                        <td><strong>Nama Pelanggan:</strong></td>
                                                        <td><?= $data_pesanan['nama_pelanggan'] ?? 'Tidak ada data' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Telepon:</strong></td>
                                                        <td><?= $data_pesanan['telepon_221042'] ?? 'Tidak ada data' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Email:</strong></td>
                                                        <td><?= $data_pesanan['email_221042'] ?? 'Tidak ada data' ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td><strong>Meja:</strong></td>
                                                        <td>
                                                            <?php if($data_pesanan['nomor_meja_221042']): ?>
                                                                Meja <?= $data_pesanan['nomor_meja_221042'] ?> (Kapasitas: <?= $data_pesanan['kapasitas_221042'] ?> orang)
                                                            <?php else: ?>
                                                                <span class="text-muted">Tidak ada meja</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informasi Pembayaran -->
                                <div class="row mb-4">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h5>Informasi Pembayaran</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <strong>Metode Pembayaran:</strong><br>
                                                        <?= $data_pesanan['metode_pembayaran_221042'] ?? '<span class="text-muted">Belum ditentukan</span>' ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Jumlah Pembayaran:</strong><br>
                                                        <?= $data_pesanan['jumlah_pembayaran'] ? 'Rp ' . number_format($data_pesanan['jumlah_pembayaran'], 0, ',', '.') : '<span class="text-muted">Belum dibayar</span>' ?>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <strong>Status:</strong><br>
                                                        <?php 
                                                            $status_pembayaran = $data_pesanan['status_pembayaran'] ?? 'Menunggu Pembayaran';
                                                            if($status_pembayaran == 'selesai' || $status_pembayaran == 'lunas'): 
                                                        ?>
                                                            <span class="badge badge-success">Selesai</span>
                                                        <?php elseif($status_pembayaran == 'proses'): ?>
                                                            <span class="badge badge-primary">Proses</span>
                                                        <?php else: ?>
                                                            <span class="badge badge-warning">Pending</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detail Item Pesanan -->
                                <div class="card">
                                    <div class="card-header">
                                        <h5>Item Pesanan</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Gambar</th>
                                                        <th>Nama Menu</th>
                                                        <th>Harga Satuan</th>
                                                        <th>Jumlah</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                    $no = 1;
                                                    $total_keseluruhan = 0;
                                                    while($detail = mysqli_fetch_array($query_detail)):
                                                        $total_keseluruhan += $detail['subtotal_221042'];
                                                ?>
                                                    <tr>
                                                        <td><?= $no++ ?></td>
                                                        <td>
                                                            <?php if(!empty($detail['gambar_221042'])): ?>
                                                                <img src="../admin/assets/images/menu/<?= $detail['gambar_221042'] ?>" alt="<?= $detail['nama_menu_221042'] ?>" width="60" height="60" class="img-thumbnail">
                                                            <?php else: ?>
                                                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                                                    <span class="text-muted">No Image</span>
                                                                </div>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?= $detail['nama_menu_221042'] ?></td>
                                                        <td><?= 'Rp ' . number_format($detail['harga_221042'], 0, ',', '.') ?></td>
                                                        <td><?= $detail['jumlah_221042'] ?></td>
                                                        <td><?= 'Rp ' . number_format($detail['subtotal_221042'], 0, ',', '.') ?></td>
                                                    </tr>
                                                <?php endwhile; ?>
                                                </tbody>
                                                <tfoot>
                                                    <tr class="table-active">
                                                        <th colspan="5" class="text-right">Total Keseluruhan:</th>
                                                        <th><?= 'Rp ' . number_format($total_keseluruhan, 0, ',', '.') ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>



                                <?php else: ?>
                                <div class="alert alert-danger">
                                    <strong>Error!</strong> Data pesanan tidak ditemukan.
                                </div>
                                <?php endif; ?>
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
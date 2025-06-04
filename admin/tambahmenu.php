<?php

include '../koneksi.php';

session_start();

if($_SESSION['status'] != 'login' || !isset($_SESSION['username_admin'])){

    header("location:../");

}


if (isset($_POST['simpan'])) {
    $kode_menu = $_POST['kode_menu'];
    $nama_menu = $_POST['nama_menu'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    
    // Handle image upload
    $gambar = "";
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
        $filename = $_FILES["gambar"]["name"];
        $filetype = $_FILES["gambar"]["type"];
        $filesize = $_FILES["gambar"]["size"];
        
        // Verify file extension
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)) {
            echo "<script>
                    alert('Error: Format file tidak didukung!');
                </script>";
        } else {
            // Verify file size - 5MB maximum
            $maxsize = 5 * 1024 * 1024;
            if($filesize > $maxsize) {
                echo "<script>
                        alert('Error: Ukuran file terlalu besar (maks 5MB)!');
                    </script>";
            } else {
                // Verify MIME type
                if(in_array($filetype, $allowed)) {
                    // Generate unique name to prevent overwriting
                    $newname = uniqid() . "." . $ext;
                    $target = "assets/images/menu/" . $newname;
                    
                    // Create directory if it doesn't exist
                    if (!file_exists("assets/images/menu/")) {
                        mkdir("assets/images/menu/", 0777, true);
                    }
                    
                    // Upload file
                    if(move_uploaded_file($_FILES["gambar"]["tmp_name"], $target)) {
                        $gambar = $newname;
                    } else {
                        echo "<script>
                                alert('Error: Gagal mengupload file!');
                            </script>";
                    }
                } else {
                    echo "<script>
                            alert('Error: Format file tidak didukung!');
                        </script>";
                }
            }
        }
    }
    
    // Check if menu code already exists
    $check_code = mysqli_query($koneksi, "SELECT * FROM menu_221042 WHERE kode_menu_221042='$kode_menu'");
    if(mysqli_num_rows($check_code) > 0) {
        echo "<script>
                alert('Error: Kode menu sudah terdaftar!');
            </script>";
    } else {
        // Query to save data to database
        $simpan = mysqli_query($koneksi, "INSERT INTO menu_221042 
                                        (kode_menu_221042, nama_menu_221042, deskripsi_221042, harga_221042, gambar_221042) 
                                        VALUES 
                                        ('$kode_menu', '$nama_menu', '$deskripsi', '$harga', '$gambar')");

        // Check if save was successful
        if ($simpan) {
            echo "<script>
                    alert('Menu berhasil ditambahkan!');
                    document.location='menu.php';
                </script>";
        } else {
            echo "<script>
                    alert('Gagal menambahkan menu! " . mysqli_error($koneksi) . "');
                </script>";
        }
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
                                <h4 class="card-title">Tambah Menu</h4>
                                <form class="forms-sample" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="kode_menu">Kode Menu</label>
                                        <input type="text" class="form-control" id="kode_menu" name="kode_menu" placeholder="Kode Menu" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nama_menu">Nama Menu</label>
                                        <input type="text" class="form-control" id="nama_menu" name="nama_menu" placeholder="Nama Menu" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="deskripsi">Deskripsi</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Deskripsi Menu"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" class="form-control" id="harga" name="harga" placeholder="Harga" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Gambar Menu</label>
                                        <input type="file" name="gambar" class="file-upload-default" id="gambar" accept="image/*">
                                        <div class="input-group col-xs-12">
                                            <input type="text" class="form-control file-upload-info" disabled placeholder="Upload Gambar">
                                            <span class="input-group-append">
                                                <button class="file-upload-browse btn btn-primary" type="button">Upload</button>
                                            </span>
                                        </div>
                                        <small class="form-text text-muted">Format yang diperbolehkan: JPG, JPEG, PNG, GIF. Maksimal ukuran: 5MB.</small>
                                    </div>
                                    <button type="submit" name="simpan" class="btn btn-primary me-2">Submit</button>
                                    <a href="menu.php" class="btn btn-light">Cancel</a>
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

    <script>
    // File upload handler
        $('.file-upload-browse').on('click', function() {
            var file = $(this).parent().parent().parent().find('.file-upload-default');
            file.trigger('click');
        });
        
        $('.file-upload-default').on('change', function() {
            var fileName = $(this).val();
            fileName = fileName.split('\\').pop();
            $(this).parent().find('.file-upload-info').val(fileName);
        });
    </script>
  </body>
</html>
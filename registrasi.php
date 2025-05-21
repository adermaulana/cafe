<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){
        header("location:index.php");
    }

    if (isset($_POST['registrasi'])) {
        $password = md5($_POST['password']);
        $username = $_POST['username'];
        $nama = $_POST['nama'];
        $telepon = $_POST['telepon'];
        $email = $_POST['email'];
        $nik = $_POST['nik']; // Added NIK field

        // Check if the username already exists
        $checkUsername = mysqli_query($koneksi, "SELECT * FROM pelanggan_221042 WHERE username_221042='$username'");
        if (mysqli_num_rows($checkUsername) > 0) {
            echo "<script>
                    alert('Username sudah digunakan, pilih Username lain.');
                    document.location='registrasi.php';
                </script>";
            exit; // Stop further execution
        }

        // If the username is not taken, proceed with the registration
        $simpan = mysqli_query($koneksi, "INSERT INTO pelanggan_221042 (nik_221042, nama_221042, telepon_221042, email_221042, username_221042, password_221042) 
                                         VALUES ('$nik', '$nama', '$telepon', '$email', '$username', '$password')");

        if ($simpan) {
            echo "<script>
                    alert('Berhasil Registrasi!');
                    document.location='index.php';
                </script>";
        } else {
            echo "<script>
                    alert('Gagal! " . mysqli_error($koneksi) . "');
                    document.location='registrasi.php';
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
    <title>Registrasi</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/feather/feather.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="assets/vendors/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth px-0">
          <div class="row w-100 mx-0">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-left py-5 px-4 px-sm-5">
                <div class="brand-logo">
                <h4 class="text-center">Registrasi</h4>
                </div>
                <form class="pt-3" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="nik" id="nik" placeholder="NIK" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="nama" id="nama" placeholder="Nama Lengkap" required>
                  </div>
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="username" id="username" placeholder="Username" required>
                  </div>
                  <div class="form-group">
                    <input type="tel" class="form-control form-control-lg" name="telepon" id="telepon" placeholder="No. Telepon" required>
                  </div>
                  <div class="form-group">
                    <input type="email" class="form-control form-control-lg" name="email" id="email" placeholder="Email" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" id="password" placeholder="Password" required>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" name="registrasi" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">REGISTRASI</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Sudah Punya Akun? <a href="index.php" class="text-primary">Login</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="assets/vendors/js/vendor.bundle.base.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="assets/js/off-canvas.js"></script>
    <script src="assets/js/template.js"></script>
    <script src="assets/js/settings.js"></script>
    <script src="assets/js/todolist.js"></script>
    <!-- endinject -->
  </body>
</html>
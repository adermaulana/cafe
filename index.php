<?php

    include 'koneksi.php';

    session_start();

    if(isset($_SESSION['status']) == 'login'){
        // Redirect based on role
        if($_SESSION['role'] == 'pelanggan') {
            header("location:pelanggan");
        } elseif($_SESSION['role'] == 'admin') {
            header("location:admin");
        } elseif($_SESSION['role'] == 'kasir') {
            header("location:kasir");
        } elseif($_SESSION['role'] == 'pelayan') {
            header("location:pelayan");
        }
    }

    if(isset($_POST['login'])){
        $username = $_POST['username'];
        $password = md5($_POST['password']);
        $role = $_POST['role'];

        // Check login based on role
        if($role == 'pelanggan') {
            // Check in pelanggan table
            $login = mysqli_query($koneksi, "SELECT * FROM pelanggan_221042 WHERE username_221042='$username' AND password_221042='$password'");
            $cek = mysqli_num_rows($login);

            if($cek > 0) {
                $pelanggan_data = mysqli_fetch_assoc($login);
                $_SESSION['id_pelanggan'] = $pelanggan_data['nik_221042'];
                $_SESSION['nama_pelanggan'] = $pelanggan_data['nama_221042'];
                $_SESSION['telepon_pelanggan'] = $pelanggan_data['telepon_221042'];
                $_SESSION['email_pelanggan'] = $pelanggan_data['email_221042'];
                $_SESSION['username_pelanggan'] = $username;
                $_SESSION['role'] = 'pelanggan';
                $_SESSION['status'] = "login";
                header('location:pelanggan');
            } else {
                echo "<script>
                alert('Login Gagal, Periksa Username dan Password Anda!');
                window.location.href='index.php';
                </script>";
            }
        } else {
            // Check in admin table for admin, kasir, pelayan roles
            $login = mysqli_query($koneksi, "SELECT * FROM admin_221042 WHERE username_221042='$username' AND password_221042='$password' AND role_221042='$role'");
            $cek = mysqli_num_rows($login);

            if($cek > 0) {
                $admin_data = mysqli_fetch_assoc($login);
                $_SESSION['id_admin'] = $admin_data['nik_221042'];
                $_SESSION['nama_admin'] = $admin_data['nama_221042'];
                $_SESSION['username_admin'] = $username;
                $_SESSION['role'] = $role;
                $_SESSION['status'] = "login";
                
                // Redirect based on role
                if($role == 'admin') {
                    header('location:admin');
                } elseif($role == 'kasir') {
                    header('location:kasir');
                } elseif($role == 'pelayan') {
                    header('location:pelayan');
                }
            } else {
                echo "<script>
                alert('Login Gagal, Periksa Username dan Password Anda!');
                window.location.href='index.php';
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
    <title>Login</title>
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
                <h4 class="text-center">Login</h4>
                </div>
                <h6 class="font-weight-light text-center">Sign in to continue.</h6>
                <form class="pt-3" method="POST">
                  <div class="form-group">
                    <input type="text" class="form-control form-control-lg" name="username" id="exampleInputEmail1" placeholder="Username" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control form-control-lg" name="password" id="exampleInputPassword1" placeholder="Password" required>
                  </div>
                  <div class="form-group">
                    <select class="form-control form-control-lg" name="role" required>
                      <option value="">Pilih Role</option>
                      <option value="pelanggan">Pelanggan</option>
                      <option value="admin">Admin</option>
                      <option value="kasir">Kasir</option>
                      <option value="pelayan">Pelayan</option>
                    </select>
                  </div>
                  <div class="mt-3 d-grid gap-2">
                    <button type="submit" name="login" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">MASUK</button>
                  </div>
                  <div class="text-center mt-4 font-weight-light"> Belum Punya Akun? <a href="registrasi.php" class="text-primary">Registrasi</a>
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
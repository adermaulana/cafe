<?php
include 'koneksi.php';

session_start();

if(isset($_SESSION['username_admin'])) {
    $isLoggedIn = true;
    $namaAdmin = $_SESSION['nama_admin'];
    $isPelanggan = false;
} else if(isset($_SESSION['username_pelanggan'])) {
    $isLoggedIn = true;
    $namaPelanggan = $_SESSION['nama_pelanggan'];
    $nikPelanggan = $_SESSION['id_pelanggan'];
    $isPelanggan = true;
} else {
    $isLoggedIn = false;
    $isPelanggan = false;
}

// Proses tambah ke keranjang
if($isPelanggan && isset($_POST['tambah_keranjang'])) {
    $kode_menu = $_POST['kode_menu'];
    $jumlah = $_POST['jumlah'];
    
    // Ambil harga menu
    $query_menu = mysqli_query($koneksi, "SELECT harga_221042 FROM menu_221042 WHERE kode_menu_221042 = '$kode_menu'");
    $menu = mysqli_fetch_assoc($query_menu);
    $harga = $menu['harga_221042'];
    $subtotal = $harga * $jumlah;
    
    // Cek apakah menu sudah ada di keranjang pelanggan ini
    $query_cek = mysqli_query($koneksi, "SELECT * FROM keranjang_221042 WHERE nik_pelanggan_221042 = '$nikPelanggan' AND kode_menu_221042 = '$kode_menu'");
    
    if(mysqli_num_rows($query_cek) > 0) {
        // Jika sudah ada, update jumlah dan subtotal
        $item = mysqli_fetch_assoc($query_cek);
        $jumlah_baru = $item['jumlah_221042'] + $jumlah;
        $subtotal_baru = $item['subtotal_221042'] + $subtotal;
        
        mysqli_query($koneksi, "UPDATE keranjang_221042 SET jumlah_221042 = '$jumlah_baru', subtotal_221042 = '$subtotal_baru' WHERE id_keranjang_221042 = '".$item['id_keranjang_221042']."'");
    } else {
        // Jika belum ada, tambahkan ke keranjang
        mysqli_query($koneksi, "INSERT INTO keranjang_221042 (nik_pelanggan_221042, kode_menu_221042, jumlah_221042, subtotal_221042) VALUES ('$nikPelanggan', '$kode_menu', '$jumlah', '$subtotal')");
    }
    
    $_SESSION['success_message'] = "Menu berhasil ditambahkan ke keranjang!";
    header("Location: daftarmenu.php");
    exit();
}
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Daftar Menu - Reservasi Cafe</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.ico">

    <!-- CSS here -->
    <link rel="stylesheet" href="assets/home/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/home/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/home/css/slicknav.css">
    <link rel="stylesheet" href="assets/home/css/flaticon.css">
    <link rel="stylesheet" href="assets/home/css/progressbar_barfiller.css">
    <link rel="stylesheet" href="assets/home/css/gijgo.css">
    <link rel="stylesheet" href="assets/home/css/animate.min.css">
    <link rel="stylesheet" href="assets/home/css/animated-headline.css">
    <link rel="stylesheet" href="assets/home/css/magnific-popup.css">
    <link rel="stylesheet" href="assets/home/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="assets/home/css/themify-icons.css">
    <link rel="stylesheet" href="assets/home/css/slick.css">
    <link rel="stylesheet" href="assets/home/css/nice-select.css">
    <link rel="stylesheet" href="assets/home/css/style.css">
    <style>
        .menu-card {
            transition: transform 0.3s;
            margin-bottom: 30px;
        }
        .menu-card:hover {
            transform: translateY(-5px);
        }
        .menu-img {
            height: 200px;
            object-fit: cover;
        }
        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ff6b6b;
        }
        .quantity-input {
            width: 60px;
            text-align: center;
        }
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            display: none;
        }
    </style>
</head>
<body>
    <!-- ? Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="assets/img/logo/loder.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->
    
    <!-- Notifikasi -->
    <?php if(isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success_message']; ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <?php unset($_SESSION['success_message']); ?>
    <?php endif; ?>
    
    <header>
        <!-- Header Start -->
        <div class="header-area">
            <div class="main-header header-sticky">
                <!-- Logo -->
                <div class="header-left">
                    <div class="logo">
                        <a href="index.php"></a>
                    </div>
                    <div class="menu-wrapper  d-flex align-items-center">
                        <!-- Main-menu -->
                        <div class="main-menu d-none d-lg-block">
                            <nav> 
                                <ul id="navigation">                                                                                          
                                    <li><a href="index.php">Home</a></li>
                                    <li class="active"><a href="daftarmenu.php">Daftar Menu</a></li>

                                    <li><a href="kontak.php">Kontak</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div> 
                <div class="header-right d-none d-lg-block">
                    <a href="#" class="header-btn1"><img src="assets/home/img/icon/call.png" alt=""> (62) 853xxxxxx</a>
                    <?php if($isLoggedIn): ?>
                        <?php if(isset($_SESSION['username_admin'])): ?>
                            <a href="admin" class="header-btn2">Dashboard</a>
                            <a href="logout.php" class="header-btn2">Logout</a>
                        <?php else: ?>
                            <a href="pelanggan" class="header-btn2">Dashboard</a>
                            <a href="keranjang.php" class="header-btn2">Keranjang</a>
                            <a href="logout.php" class="header-btn2">Logout</a>
                        <?php endif; ?>
                    <?php else: ?>
                     <a href="login.php" class="header-btn2">Login</a>
                    <?php endif; ?>
                </div>
                <!-- Mobile Menu -->
                <div class="col-12">
                    <div class="mobile_menu d-block d-lg-none"></div>
                </div>
            </div>
        </div>
        <!-- Header End -->
    </header>
    <main>
        <!--? Hero Start -->
        <div class="slider-area2 section-bg2 hero-overly" data-background="assets/img/hero/hero2.png">
            <div class="slider-height2 d-flex align-items-center">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="hero-cap hero-cap2">
                                <h2>Daftar Menu</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        
        <!--? Menu List Start -->
        <section class="services-area pt-100 pb-150">
            <div class="container">
                <div class="row">
                    <?php
                    $query_menu = mysqli_query($koneksi, "SELECT * FROM menu_221042 ORDER BY nama_menu_221042");
                    while($menu = mysqli_fetch_assoc($query_menu)) {
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6">
                        <div class="single-cat text-center menu-card">
                            <div class="cat-icon">
                                <img src="admin/assets/images/menu/<?php echo $menu['gambar_221042']; ?>" alt="<?php echo $menu['nama_menu_221042']; ?>" class="img-fluid rounded menu-img">
                            </div>
                            <div class="cat-cap">
                                <h5><?php echo $menu['nama_menu_221042']; ?></h5>
                                <p><?php echo $menu['deskripsi_221042']; ?></p>
                                <div class="price mb-3">Rp <?php echo number_format($menu['harga_221042'], 0, ',', '.'); ?></div>
                                
                                <?php if($isPelanggan): ?>
                                <form method="post" action="">
                                    <input type="hidden" name="kode_menu" value="<?php echo $menu['kode_menu_221042']; ?>">
                                    <div class="form-group">
                                        <input type="number" name="jumlah" class="form-control quantity-input" value="1" min="1" required>
                                    </div>
                                    <button type="submit" name="tambah_keranjang" class="btn btn-primary">Tambah ke Keranjang</button>
                                </form>
                                <?php else: ?>
                                    <a href="login.php" class="btn btn-primary">Login untuk Memesan</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- Menu List End -->
    </main>
    
   <footer>
        <!-- Footer Start-->
        <div class="footer-area footer-padding">
            <div class="container">
                <div class="row d-flex justify-content-between">
                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6">
                     <div class="single-footer-caption mb-50">
                       <div class="single-footer-caption mb-30">
                        <!-- logo -->
                        <div class="footer-logo mb-35">
                            <a href="index.html"><img src="assets/img/logo/logo2_footer.png" alt=""></a>
                        </div>
                        <div class="footer-tittle">
                            <div class="footer-pera">
                                <p>Suspendisse varius enim in eros elementum tristique. Duis cursus, mi quis viverra ornare, eros dolor interdum nulla.</p>
                            </div>
                        </div>
                        <!-- social -->
                        <div class="footer-social">
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="https://bit.ly/sai4ull"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-pinterest-p"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div class="single-footer-caption mb-50">
                    <div class="footer-tittle">
                        <h4>Services </h4>
                        <ul>
                            <li><a href="#">- Makanan</a></li>
                            <li><a href="#">- Minuman</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6">
                <div class="single-footer-caption mb-50">
                    <div class="footer-tittle">
                        <h4>Get in touch</h4>
                        <ul>
                            <li class="number"><a href="#">(62) 853xxxxxx</a></li>
                            <li><a href="#">restoran@567.com</a></li>
                            <li><a href="#">Makassar, Indonesia</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>
    <!-- footer-bottom area -->
    <div class="footer-bottom-area section-bg2" data-background="assets/img/gallery/footer-bg.png">
        <div class="container">
            <div class="footer-border">
            <div class="row d-flex align-items-center">
                <div class="col-xl-12 ">
                    <div class="footer-copy-right text-center">
                        <p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
                            <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
  <!-- Footer End-->
</footer>
<!-- Scroll Up -->
<div id="back-top" >
    <a title="Go to Top" href="#"> <i class="fas fa-level-up-alt"></i></a>
</div>
<!-- JS here -->

<script src="assets/home/js/vendor/modernizr-3.5.0.min.js"></script>
<!-- Jquery, Popper, Bootstrap -->
<script src="assets/home/js/vendor/jquery-1.12.4.min.js"></script>
<script src="assets/home/js/popper.min.js"></script>
<script src="assets/home/js/bootstrap.min.js"></script>
<!-- Jquery Mobile Menu -->
<script src="assets/home/js/jquery.slicknav.min.js"></script>

<!-- Jquery Slick , Owl-Carousel Plugins -->
<script src="assets/home/js/owl.carousel.min.js"></script>
<script src="assets/home/js/slick.min.js"></script>
<!-- One Page, Animated-HeadLin -->
<script src="assets/home/js/wow.min.js"></script>
<script src="assets/home/js/animated.headline.js"></script>
<script src="assets/home/js/jquery.magnific-popup.js"></script>

<!-- Date Picker -->
<script src="assets/home/js/gijgo.min.js"></script>
<!-- Nice-select, sticky -->
<script src="assets/home/js/jquery.nice-select.min.js"></script>
<script src="assets/home/js/jquery.sticky.js"></script>

<!-- counter , waypoint,Hover Direction -->
<script src="assets/home/js/jquery.counterup.min.js"></script>
<script src="assets/home/js/waypoints.min.js"></script>
<script src="assets/home/js/jquery.countdown.min.js"></script>
<script src="assets/home/js/hover-direction-snake.min.js"></script>

<!-- contact js -->
<script src="assets/home/js/contact.js"></script>
<script src="assets/home/js/jquery.form.js"></script>
<script src="assets/home/js/jquery.validate.min.js"></script>
<script src="assets/home/js/mail-script.js"></script>
<script src="assets/home/js/jquery.ajaxchimp.min.js"></script>

<!-- Jquery Plugins, main Jquery -->	
<script src="assets/home/js/plugins.js"></script>
<script src="assets/home/js/main.js"></script>

<script>
    // Tampilkan notifikasi
    $(document).ready(function(){
        $('.alert').fadeIn();
        setTimeout(function(){
            $('.alert').fadeOut();
        }, 3000);
    });
</script>

</body>
</html>
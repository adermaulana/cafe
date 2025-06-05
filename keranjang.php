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
    header("Location: login.php");
    exit();
}

// Proses hapus item dari keranjang
if(isset($_GET['hapus'])) {
    $id_keranjang = $_GET['hapus'];
    
    mysqli_query($koneksi, "DELETE FROM keranjang_221042 WHERE id_keranjang_221042 = '$id_keranjang' AND nik_pelanggan_221042 = '$nikPelanggan'");
    
    $_SESSION['success_message'] = "Item berhasil dihapus dari keranjang!";
    header("Location: keranjang.php");
    exit();
}

// Proses update jumlah item
if(isset($_POST['update_keranjang'])) {
    $id_keranjang = $_POST['id_keranjang'];
    $jumlah = $_POST['jumlah'];
    
    // Ambil harga menu dari keranjang
    $query_item = mysqli_query($koneksi, "SELECT m.harga_221042 
                                       FROM keranjang_221042 k
                                       JOIN menu_221042 m ON k.kode_menu_221042 = m.kode_menu_221042
                                       WHERE k.id_keranjang_221042 = '$id_keranjang'");
    $item = mysqli_fetch_assoc($query_item);
    $harga = $item['harga_221042'];
    $subtotal = $harga * $jumlah;
    
    // Update jumlah dan subtotal
    mysqli_query($koneksi, "UPDATE keranjang_221042 SET jumlah_221042 = '$jumlah', subtotal_221042 = '$subtotal' 
                          WHERE id_keranjang_221042 = '$id_keranjang' AND nik_pelanggan_221042 = '$nikPelanggan'");
    
    $_SESSION['success_message'] = "Keranjang berhasil diperbarui!";
    header("Location: keranjang.php");
    exit();
}


// Proses checkout
if(isset($_POST['checkout'])) {
    // Buat pesanan baru
    $kode_pesanan = 'PES' . date('YmdHis');
    $tanggal = date('Y-m-d H:i:s');
    
    // Hitung total dari keranjang
    $query_total = mysqli_query($koneksi, "SELECT SUM(subtotal_221042) as total FROM keranjang_221042 WHERE nik_pelanggan_221042 = '$nikPelanggan'");
    $total = mysqli_fetch_assoc($query_total)['total'];
    
    // Insert ke tabel pesanan
    mysqli_query($koneksi, "INSERT INTO pesanan_221042 (kode_pesanan_221042, nik_221042, tanggal_pesanan_221042, total_221042, catatan_221042, status_221042) 
                          VALUES ('$kode_pesanan', '$nikPelanggan', '$tanggal', '$total', '".$_POST['catatan']."', 'Menunggu Pembayaran')");
    
    // Pindahkan item dari keranjang ke detail pesanan
    $query_keranjang = mysqli_query($koneksi, "SELECT * FROM keranjang_221042 WHERE nik_pelanggan_221042 = '$nikPelanggan'");
    $no_detail = 1;
    while($item = mysqli_fetch_assoc($query_keranjang)) {
        // Gunakan timestamp dengan mikrodetik untuk keunikan
        $kode_detail = 'DTL' . date('YmdHis') . substr(microtime(), 2, 6) . str_pad($no_detail, 2, '0', STR_PAD_LEFT);
        
        mysqli_query($koneksi, "INSERT INTO detail_pesanan_221042 (kode_detailpesanan_221042, kode_pesanan_221042, kode_menu_221042, jumlah_221042, subtotal_221042) 
                              VALUES ('$kode_detail', '$kode_pesanan', '".$item['kode_menu_221042']."', '".$item['jumlah_221042']."', '".$item['subtotal_221042']."')");
        $no_detail++;
    }
    
    // Kosongkan keranjang
    mysqli_query($koneksi, "DELETE FROM keranjang_221042 WHERE nik_pelanggan_221042 = '$nikPelanggan'");
    
    $_SESSION['kode_pesanan'] = $kode_pesanan;
    header("Location: pelanggan/pesanan.php");
    exit();
}

// Ambil data keranjang
$query_items = mysqli_query($koneksi, "SELECT k.id_keranjang_221042, k.kode_menu_221042, m.nama_menu_221042, m.harga_221042, m.gambar_221042, k.jumlah_221042, k.subtotal_221042
                                     FROM keranjang_221042 k
                                     JOIN menu_221042 m ON k.kode_menu_221042 = m.kode_menu_221042
                                     WHERE k.nik_pelanggan_221042 = '$nikPelanggan'");
$items = array();
$total = 0;

while($item = mysqli_fetch_assoc($query_items)) {
    $items[] = $item;
    $total += $item['subtotal_221042'];
}
?>
<!doctype html>
<html class="no-js" lang="zxx">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Keranjang - Reservasi Cafe</title>
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
        .cart-item {
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        .cart-item-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 5px;
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
        .summary-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
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
                                    <li><a href="daftarmenu.php">Daftar Menu</a></li>
                                    <li class="active"><a href="keranjang.php">Keranjang</a></li>

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
                                <h2>Keranjang Pesanan</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Hero End -->
        
        <section class="services-area pt-100 pb-150">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <?php if(count($items) > 0): ?>
                            <h3 class="mb-4">Item Keranjang</h3>
                            <?php foreach($items as $item): ?>
                            <div class="row cart-item">
                                <div class="col-md-2">
                                    <img src="admin/assets/images/menu/<?php echo $item['gambar_221042']; ?>" alt="<?php echo $item['nama_menu_221042']; ?>" class="img-fluid cart-item-img">
                                </div>
                                <div class="col-md-2">
                                    <h5><?php echo $item['nama_menu_221042']; ?></h5>
                                    <p>Rp <?php echo number_format($item['harga_221042'], 0, ',', '.'); ?></p>
                                </div>
                                <div class="col-md-6">
                                    <form method="post" action="">
                                        <input type="hidden" name="id_keranjang" value="<?php echo $item['id_keranjang_221042']; ?>">
                                        <div class="form-group row">
                                            <label class="col-sm-4 col-form-label">Jumlah:</label>
                                            <div class="col-sm-4">
                                                <input type="number" name="jumlah" class="form-control quantity-input" value="<?php echo $item['jumlah_221042']; ?>" min="1">
                                            </div>
                                            <div class="col-sm-4">
                                                <button type="submit" name="update_keranjang" class="btn btn-sm btn-primary">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                    <p class="mt-2">Subtotal: Rp <?php echo number_format($item['subtotal_221042'], 0, ',', '.'); ?></p>
                                    <a href="keranjang.php?hapus=<?php echo $item['id_keranjang_221042']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="alert alert-info">
                                Keranjang Anda kosong. <a href="daftarmenu.php" class="alert-link">Silahkan pesan menu terlebih dahulu</a>.
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="summary-card">
                            <h3 class="mb-4">Ringkasan Keranjang</h3>
                            <?php if(count($items) > 0): ?>
                                <table class="table">
                                    <tr>
                                        <th>Total Item</th>
                                        <td><?php echo count($items); ?></td>
                                    </tr>
                                    <tr>
                                        <th>Total Harga</th>
                                        <td>Rp <?php echo number_format($total, 0, ',', '.'); ?></td>
                                    </tr>
                                </table>
                                
                                <form method="post" action="">
                                    <div class="form-group">
                                        <label>Catatan untuk Pesanan:</label>
                                        <textarea name="catatan" class="form-control" rows="3"></textarea>
                                    </div>
                                    <button type="submit" name="checkout" class="btn btn-primary btn-block">Lanjut ke Reservasi</button>
                                </form>
                            <?php else: ?>
                                <p>Tidak ada item dalam keranjang</p>
                                <a href="daftarmenu.php" class="btn btn-primary btn-block">Pesan Menu</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Keranjang End -->
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
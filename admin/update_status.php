<?php
include '../koneksi.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $kode_meja = $_POST['kode_meja'];
    $status = $_POST['status'];
    
    $update = mysqli_query($koneksi, "UPDATE meja_221042 
                                    SET status_221042 = '$status' 
                                    WHERE kode_meja_221042 = '$kode_meja'");

    if ($update) {
        echo "<script>
                alert('Berhasil memperbarui!');
                document.location='meja.php';
                </script>";
    } else {
        echo json_encode(['success' => false, 'message' => mysqli_error($koneksi)]);
    }
    exit;
}
?>
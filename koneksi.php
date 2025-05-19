<?php
    $server = "localhost";
    $user = "root";
    $pass = "";
    $database = "sintya221042";

    $koneksi = mysqli_connect($server,$user,$pass,$database) or die(mysqli_error($koneksi));
?>
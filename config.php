<?php

include 'assets/QRCode/phpqrcode/qrlib.php';

session_start();
error_reporting();

$conn = mysqli_connect("localhost", "root", "", "penggajian");

// Check connection
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
}

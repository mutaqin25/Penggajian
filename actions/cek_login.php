<?php
// menghubungkan php dengan koneksi database
include '../config.php';

// menangkap data yang dikirim dari form login
$username = $_POST['username'];
$password = $_POST['password'];


// menyeleksi data user dengan username dan password yang sesuai
$login = mysqli_query($conn, "select * from user where username='$username' and password='$password'");
// menghitung jumlah data yang ditemukan
$cek = mysqli_num_rows($login);

// cek apakah username dan password di temukan pada database
if ($cek > 0) {

    $data = mysqli_fetch_assoc($login);

    // cek jika user login sebagai admin
    if ($data['level'] == "Admin") {

        // buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "Admin";
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['nik'] = $data['nik'];

        // alihkan ke halaman dashboard admin
        header("location:../views/Admin/dashboard/dashboard.php");

        // cek jika user login sebagai pegawai
    } else if ($data['level'] == "Pegawai") {
        // buat session login dan username
        $_SESSION['username'] = $username;
        $_SESSION['level'] = "Pegawai";
        $_SESSION['nama'] = $data['nama'];
        $_SESSION['nik'] = $data['nik'];

        // alihkan ke halaman dashboard pegawai
        header("location:../views/Pegawai/dashboard/dashboard.php");
    } else {

        // alihkan ke halaman login kembali
        header("../index.php?pesan=gagal");
    }
} else {
    header("../index.php?pesan=gagal");
}

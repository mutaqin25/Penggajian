<?php
include '../config.php';
session_start();

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

    $id = $_POST['id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];


    // menginput data ke database
    $sql = "UPDATE user SET nik='$nik', nama='$nama', jenis_kelamin='$jenis_kelamin', username='$username', password='$password', level='$level'  WHERE nik='$id'";
    $query = mysqli_query($conn, $sql);
    // echo mysqli_error($conn);
    if ($query) {
        // kalau berhasil alihkan ke halaman index.php dengan status=sukses
        $_SESSION['status'] = "sukses";
        $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
        header('Location: ../views/Admin/user/form-user.php');
    } else {
        // kalau gagal alihkan ke halaman indek.php dengan status=gagal
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
        header('Location: ../views/Admin/user/form-user.php');
    }
} else {
    die("gagal menginputkan data");
}

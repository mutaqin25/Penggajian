<?php
include '../config.php';

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $level = $_POST['level'];

    // membuat id
    $cek_id = mysqli_query($conn, "select max(id_user) as kode from user");
    $jumlah = mysqli_fetch_array($cek_id);
    $no = $jumlah['kode'];
    $id = $no + 1;
    // cek data
    $duplicate = mysqli_query($conn, "select * from user where username = '$username' ");
    if (mysqli_num_rows($duplicate) > 0) {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Username Sudah Dipakai Silahkan Gunakan Yang Lain !";
        header('Location: ../views/Admin/user/form-user.php');
    } else {
        // menginput data ke database
        $sql = "INSERT INTO user (id_user, nik, nama, jenis_kelamin, username, password, level) VALUE ('$id', '$nik', '$nama', '$jenis_kelamin', '$username', '$password', '$level')";
        $query = mysqli_query($conn, $sql);

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
    }
} else {
    die("gagal menginputkan data");
}

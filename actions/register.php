<?php
include '../config.php';

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

    $nama_depan = $_POST['nama_depan'];
    $nama_belakang = $_POST['nama_belakang'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $level = "Costumer";

    // membuat id
    $cek_id = mysqli_query($conn, "select max(id_user) as kode from user");
    $jumlah = mysqli_fetch_array($cek_id);
    $no = $jumlah['kode'];
    $id = $no + 1;


    // menginput data ke database
    $sql = "INSERT INTO user (id_user, nama_depan, nama_belakang, email, password, level) VALUE ('$id', '$nama_depan', '$nama_belakang', '$email', '$password', '$level')";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        header("location:../view/Registration/sign-up.php?pesan=sukses");
    } else {
        // kalau gagal alihkan ke halaman indek.php dengan status=gagal
        header("location:../view/Registration/sign-up.php?pesan=gagal");
    }
} else {
    die("gagal menginputkan data");
}

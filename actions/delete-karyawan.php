<?php
include '../config.php';

if (isset($$_POST['delete']) == "") {

    $id = $_POST['id'];

    // ambil data foto
    $cek_data = mysqli_query($conn, "SELECT foto AS file FROM karyawan WHERE nik=$id");
    $data = mysqli_fetch_array($cek_data);
    $foto = $data['file'];

    // ambil data qrcode
    $cek_data = mysqli_query($conn, "SELECT qrcode AS qr FROM karyawan WHERE nik=$id");
    $data = mysqli_fetch_array($cek_data);
    $qrcode = $data['qr'];

    $sql = "DELETE FROM karyawan WHERE nik=$id";
    $query = mysqli_query($conn, $sql);
    unlink('../assets/images/QRCode/' . $qrcode);
    unlink('../assets/images/profil/' . $foto);

    if ($query) {
        unlink('../assets/images/QRCode/' . $qrcode);
        unlink('../assets/images/profil/' . $foto);
        $_SESSION['status'] = "sukses";
        $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/karyawan/form-karyawan.php');
    } else {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/karyawan/form-karyawan.php');
    }
} else {
    echo $_GET['id'];
}

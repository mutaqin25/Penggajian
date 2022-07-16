<?php
include '../config.php';

if (isset($_POST['id]']) == "") {

    $id = $_POST['id'];

    $sql = "DELETE FROM gaji_bulanan WHERE id_gaji=$id";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $_SESSION['status'] = "sukses";
        $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/penggajian/form-penggajian.php');
    } else {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/penggajian/form-penggajian.php');
    }
} else {
    echo $_POST['id'];
}

<?php
include '../config.php';

if (isset($_POST['id']) != "") {

    $id = $_POST['id'];
    // $id_psl = $_GET['id_psl'];



    $sql_penghasilan = "DELETE FROM penghasilan WHERE id_absen=$id";
    $query_penghasilan = mysqli_query($conn, $sql_penghasilan);

    $sql = "DELETE FROM absen WHERE id_absen=$id";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $_SESSION['status'] = "sukses";
        $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/absensi/form-absensi.php');
    } else {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/absensi/form-absensi.php');
    }
} else {
    echo $_GET['id'];
}

<?php
include '../config.php';

if (isset($_GET['id]']) == "") {

    $id = $_GET['id'];

    $sql = "DELETE FROM user WHERE id_user=$id";
    $query = mysqli_query($conn, $sql);

    if ($query) {
        $_SESSION['status'] = "sukses";
        $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/user/form-user.php');
    } else {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Berhasil Dihapus!";
        header('Location: ../views/Admin/user/form-user.php');
    }
} else {
    echo $_GET['id'];
}

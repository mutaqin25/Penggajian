<?php
include '../config.php';

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];
    $agama = $_POST['agama'];
    $no_hp = $_POST['no_hp'];
    $pendidikan = $_POST['pendidikan'];
    $foto_lama = $_POST['foto_lama'];


    // upload Foto
    $rand = rand();
    $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
    $fileFoto = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];
    $ext = pathinfo($fileFoto, PATHINFO_EXTENSION);


    if (!in_array($ext, $ekstensi)) {
        mysqli_query($conn, "UPDATE karyawan SET  nama='$nama', jenis_kelamin='$jenis_kelamin', tgl_lahir='$tgl_lahir', alamat='$alamat', status='$status', agama='$agama', no_hp='$no_hp', pendidikan='$pendidikan' WHERE nik='$id' ");

        $sql = "UPDATE user SET nama='$nama', jenis_kelamin='$jenis_kelamin' WHERE nik='$id'";
        $query = mysqli_query($conn, $sql);

        $_SESSION['status'] = "sukses";
        $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
        header('Location: ../views/Pegawai/profil/profil.php');
    } else {
        if ($ukuran < 1044070) {
            $xx = $rand . '_' . $fileFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/images/profil/' . $rand . '_' . $fileFoto);

            mysqli_query($conn, "UPDATE karyawan SET  nama='$nama', jenis_kelamin='$jenis_kelamin', tgl_lahir='$tgl_lahir', alamat='$alamat', status='$status', agama='$agama', no_hp='$no_hp', pendidikan='$pendidikan', foto='$xx' WHERE nik='$id' ");

            $sql = "UPDATE user SET nama='$nama', jenis_kelamin='$jenis_kelamin' WHERE nik='$id'";
            $query = mysqli_query($conn, $sql);

            unlink('../assets/images/profil/' . $foto_lama);

            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            header('Location: ../views/Pegawai/profil/profil.php');
            // echo $foto_lama;
            // echo mysqli_errno($conn);
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            header('Location: ../views/Pegawai/profil/profil.php');
        }
    }
} else {
    die("gagal menginputkan data");
}

<?php
include '../config.php';

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

    $id = $_POST['id'];
    $nik = $_POST['nik'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $tgl_lahir = $_POST['tgl_lahir'];
    $alamat = $_POST['alamat'];
    $status = $_POST['status'];
    $agama = $_POST['agama'];
    $no_hp = $_POST['no_hp'];
    $jabatan = $_POST['jabatan'];
    $shift = $_POST['shift'];
    $gaji = $_POST['gaji'];
    $tgl_masuk = $_POST['tgl_masuk'];
    $pendidikan = $_POST['pendidikan'];
    $foto_lama = $_POST['foto_lama'];
    $qrcode_lama = $_POST['qrcode_lama'];


    // upload Foto
    $rand = rand();
    $ekstensi =  array('png', 'jpg', 'jpeg', 'gif');
    $fileFoto = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];
    $ext = pathinfo($fileFoto, PATHINFO_EXTENSION);

    //QRCODE
    $qrvalue = "$nik";
    $tempDir = "../assets/images/QRCode/";
    $codeContents = $qrvalue;
    $fileQRcode = $qrvalue . '.png';
    $pngAbsoluteFilePath = $tempDir . $fileQRcode;
    $urlRelativeFilePath = $tempDir . $fileQRcode;
    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath);
    }

    if (!in_array($ext, $ekstensi)) {
        mysqli_query($conn, "UPDATE karyawan SET nik='$nik', nama='$nama', jenis_kelamin='$jenis_kelamin', tgl_lahir='$tgl_lahir', alamat='$alamat', status='$status', agama='$agama', no_hp='$no_hp', jabatan='$jabatan', shift='$shift', gaji='$gaji', tgl_masuk='$tgl_masuk', pendidikan='$pendidikan', qrcode='$fileQRcode' WHERE nik='$id' ");

        if ($qrcode_lama != $fileQRcode) {
            unlink('../assets/images/QRCode/' . $qrcode_lama);
        }

        $_SESSION['status'] = "sukses";
        $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
        header("location:../views/Admin/karyawan/form-karyawan.php");
    } else {
        if ($ukuran < 1044070) {
            $xx = $rand . '_' . $fileFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/images/profil/' . $rand . '_' . $fileFoto);

            mysqli_query($conn, "UPDATE karyawan SET nik='$nik', nama='$nama', jenis_kelamin='$jenis_kelamin', tgl_lahir='$tgl_lahir', alamat='$alamat', status='$status', agama='$agama', no_hp='$no_hp', jabatan='$jabatan', shift='$shift', gaji='$gaji', tgl_masuk='$tgl_masuk', pendidikan='$pendidikan', foto='$xx', qrcode='$fileQRcode' WHERE nik='$id' ");

            unlink('../assets/images/QRCode/' . $qrcode_lama);
            unlink('../assets/images/profil/' . $foto_lama);

            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            header('Location: ../views/Admin/karyawan/form-karyawan.php');
            // echo $foto_lama;
            // echo mysqli_errno($conn);
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            header('Location: ../views/Admin/karyawan/form-karyawan.php');
        }
    }
} else {
    die("gagal menginputkan data");
}

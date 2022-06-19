<?php
include '../config.php';

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

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
    $ket_bpjs = $_POST['ket_bpjs'];

    if ($ket_bpjs == 'Memiliki') {
        $bpjs = $_POST['bpjs'];
        $nama_bpjs = implode(",", $_POST['bpjs']);
    } else {
        $nama_bpjs = 'Tidak Memiliki';
    }



    // membuat QRCode 
    $qrvalue = "$nik";
    $tempDir = "../assets/images/QRCode/";
    $codeContents = $qrvalue;
    $fileQRcode = $qrvalue . '.png';
    $pngAbsoluteFilePath = $tempDir . $fileQRcode;
    $urlRelativeFilePath = $tempDir . $fileQRcode;
    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath);
    }

    // upload Foto
    $rand = rand();
    $ekstensi =  array(
        'png', 'jpg', 'jpeg', 'gif'
    );
    $fileFoto = $_FILES['foto']['name'];
    $ukuran = $_FILES['foto']['size'];
    $ext = pathinfo($fileFoto, PATHINFO_EXTENSION);


    // menginput data ke database


    if (!in_array($ext, $ekstensi)) {
        header("location:../views/Admin/karyawan/form-karyawan.php");
    } else {
        if ($ukuran < 1044070) {
            $xx = $rand . '_' . $fileFoto;
            move_uploaded_file($_FILES['foto']['tmp_name'], '../assets/images/profil/' . $rand . '_' . $fileFoto);

            mysqli_query($conn, "INSERT INTO karyawan (nik, nama, jenis_kelamin, tgl_lahir, alamat, status, agama, no_hp, jabatan, shift, gaji, bpjs, tgl_masuk, pendidikan, foto, qrcode) VALUE ('$nik', '$nama', '$jenis_kelamin', '$tgl_lahir', '$alamat', '$status', '$agama', '$no_hp', '$jabatan',  '$shift', '$gaji', '$nama_bpjs', '$tgl_masuk', '$pendidikan', '$xx', '$fileQRcode')");

            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            header('Location: ../views/Admin/karyawan/form-karyawan.php');
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

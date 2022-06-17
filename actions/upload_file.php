<?php
include '../config.php';
// excel reader
require_once '../assets/PHPExcel/Classes/PHPExcel/Reader/Excel5.php';

$fileUpl = $_FILES['xls']['name'];
$objReader = new PHPExcel_Reader_Excel5($fileUpl);
$data = $objReader->load($_FILES['xls']['tmp_name']);
$objData = $data->getActiveSheet();
$dataArray = $objData->toArray();
$sql = "INSERT INTO karyawan (nik, nama, jenis_kelamin, alamat, no_hp, jabatan, shift, foto, qrcode) VALUES ";
for ($i = 1; $i < count($dataArray); $i++) {
    $fileQRcode = ""; //new
    $img = []; //new
    $x = 0; //new

    $objData = $data->getActiveSheet();
    foreach ($objData->getDrawingCollection() as $gbr) {
        $string = $gbr->getCoordinates();
        $coord = PHPExcel_Cell::coordinateFromString($string);
        $image = $gbr->getImageResource();
        $img[$x] = $gbr->getIndexedFilename();
        imagejpeg($image, '../assets/images/profil/' . $img[$x]);
        $x++; //new
    }
    $nik = $dataArray[$i]['0'];
    $nama = $dataArray[$i]['1'];
    $jenis_kelamin = $dataArray[$i]['2'];
    $alamat = $dataArray[$i]['3'];
    $no_hp = $dataArray[$i]['4'];
    $jabatan = $dataArray[$i]['5'];
    $shift = $dataArray[$i]['6'];

    if ($nama != null) { // new

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
        $sql .= "('$nik', '$nama', '$jenis_kelamin', '$alamat', '$no_hp', '$jabatan', '$shift', '" . $img[$i - 1] . "', '$fileQRcode'), ";
    } // new

}
$sql = rtrim($sql, ', ');
$query = mysqli_query($conn, $sql);

if ($query) {
    // kalau berhasil alihkan ke halaman index.php dengan status=sukses
    $_SESSION['status'] = "sukses";
    $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
    header('Location: ../views/Admin/karyawan/form-karyawan.php');
} else {
    // kalau gagal alihkan ke halaman indek.php dengan status=gagal
    echo mysqli_error($conn);
    $_SESSION['status'] = "gagal";
    $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
    header('Location: ../views/Admin/karyawan/form-karyawan.php');
}

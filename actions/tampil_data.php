<?php
include '../config.php';

$nik = $_POST['nik'];

$data = mysqli_query($conn, "select * from karyawan where nik=$nik ");
while ($row = mysqli_fetch_array($data)) {
    $datas[] = ["nama" => $row['nama'], "foto" => $row['foto']];
}
echo json_encode($datas);

<?php
include '../../../config.php';
require_once __DIR__ . '/../../../assets/vendor/autoload.php';

$nik = $_GET['nik'];
$data = mysqli_query($conn, "select * from gaji_bulanan where nik =$nik ");

$mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h1 align="center" >Laporan Data Gaji Karyawan</h1>
    <table border="1" align="center">
                                    <thead>
                                        <tr align="center">
                                            <th>No</th>
                                            <th>Nik</th>
                                            <th>Periode</th>
                                            <th>Gaji Pokok</th>
                                            <th>Uang Tunjangan</th>
                                            <th>Uang Lembur</th>
                                            <th>Uang Potongan</th>
                                            <th>BPJS</th>
                                            <th>PPH</th>
                                            <th>Gaji Bersih</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
$i = 1;
foreach ($data as $row) {
    $html .= '<tr>
            <td>' . $i++ . ' </td>
            <td>' . $row["nik"] . ' </td>
            <td>' . $row["periode"] . ' </td>
            <td>Rp. ' . number_format($row["gaji_pokok"], 0, ",", ".") . ' </td>
            <td>Rp. ' . number_format($row["uang_tunjangan"], 0, ",", ".") . ' </td>
            <td>Rp. ' . number_format($row["uang_lembur"], 0, ",", ".") . ' </td>
            <td>Rp. ' . number_format($row["uang_potongan"], 0, ",", ".") . ' </td>
            <td>Rp. ' . number_format($row["bpjs"], 0, ",", ".") . ' </td>
            <td>Rp. ' . number_format($row["pph21"], 0, ",", ".") . ' </td>
            <td>Rp. ' . number_format($row["gaji_bersih"], 0, ",", ".") . ' </td>
            </tr>';
}

$html .= '</tbody>
</table>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan Gaji.pdf', \Mpdf\Output\Destination::INLINE);

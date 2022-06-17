<?php
include '../../../config.php';
require_once __DIR__ . '/../../../assets/vendor/autoload.php';

$nik = $_POST['nik'];
$bulan = $_POST['bulan'];
$tahun = $_POST['tahun'];
$tanggal = $tahun . '-' . $bulan;

$data_karyawan = mysqli_query($conn, "select * from karyawan where nik = $nik ");
$result_karyawan = mysqli_fetch_array($data_karyawan);


$data_gaji = mysqli_query($conn, "select * from gaji_bulanan where nik = $nik and periode like '%$tanggal%' ");
$result_gaji = mysqli_fetch_array($data_gaji);


$mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-L']);

// ---------------------------- pendapatan ---------------------------- //
$cek_makan = mysqli_query($conn, "select sum(uang_makan) as uang_makan from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
$result_makan = mysqli_fetch_array($cek_makan);
$uang_makan = $result_makan['uang_makan'];

$cek_transport = mysqli_query($conn, "select sum(uang_transport) as uang_transport from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
$result_transport = mysqli_fetch_array($cek_transport);
$uang_transport = $result_transport['uang_transport'];

$cek_lembur = mysqli_query($conn, "select sum(uang_lembur) as uang_lembur from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
$result_lembur = mysqli_fetch_array($cek_lembur);
$uang_lembur = $result_lembur['uang_lembur'];


// ---------------------------- pendapatan ---------------------------- //

// ---------------------------- potongan ---------------------------- //
$cek_sakit = mysqli_query($conn, "select sum(uang_sakit) as uang_sakit from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
$result_sakit = mysqli_fetch_array($cek_sakit);
$uang_sakit = $result_sakit['uang_sakit'];

$cek_tidak_masuk = mysqli_query($conn, "select sum(uang_tidak_masuk) as uang_tidak_masuk from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
$result_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
$uang_tidak_masuk = $result_tidak_masuk['uang_tidak_masuk'];

$cek_terlambat = mysqli_query($conn, "select sum(uang_terlambat) as uang_terlambat from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
$result_terlambat = mysqli_fetch_array($cek_terlambat);
$uang_terlambat = $result_terlambat['uang_terlambat'];

$cek_pph = mysqli_query($conn, "select pph21 from gaji_bulanan where nik = $nik and periode like '%$tanggal%'");
$result_pph = mysqli_fetch_array($cek_pph);
$uang_pph = $result_pph['pph21'];

$cek_gaji_bersih = mysqli_query($conn, "select gaji_bersih from gaji_bulanan where nik = $nik and periode like '%$tanggal%'");
$result_gaji_bersih = mysqli_fetch_array($cek_gaji_bersih);
$gaji_bersih = $result_gaji_bersih['pph21'];


$tunjangan = $result_karyawan['gaji'] + $uang_makan + $uang_transport;
$pendapatan = $tunjangan + $uang_lembur;

$html = '<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji</title>
</head>
<style>
    table {
        border: 1px solid black;
    }
</style>

<body>
    <table align="center">

        <tr>
            <th colspan="7">
                <h1>Laporan Slip Gaji Karyawan</h1>
                <hr>
            </th>

        </tr>
        <tr style="border: 0px">
            <td style="width:200px ">Nama Perusahaan</td>
            <td colspan="2" style="width:200px ">: Dinobites Caffe</td>
            <td style="width:50px "></td>
            <td style="width:100px ">Nik</td>
            <td style="width: 200px ">: ' . $nik . '</td>
        </tr>
        <tr>
            <td style=" width:200px ">Tanggal</td>
            <td colspan="2">: ' . $result_gaji["periode"] . '</td>
            <td style="width:20px "></td>
            <td style="width:200px ">Nama Karyawan</td>
            <td>: ' . $result_karyawan["nama"] . '</td>
        </tr>
        <tr>
            <td style="width:200px ">Departemen</td>
            <td colspan="2">: Owner</td>
            <td style="width:20px "></td>
            <td style="width:200px ">Jabatan</td>
            <td>: ' . $result_karyawan["jabatan"] . '</td>
        </tr>
        <tr>
            <td colspan="6">
                <hr>
            </td>
        </tr>
        <tr>
            <td colspan="3">Penerimaan ( + )
                <hr>
            </td>
            <td style="width:20px "></td>
            <td colspan="3">Potongan ( - )
                <hr>
            </td>
        </tr>
        <tr>
            <td style="width: 200px">Gaji Pokok</td>
            <td colspan="2">: Rp. ' . $result_karyawan["gaji"] . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan Terlamabat</td>
            <td>: Rp. ' . $uang_terlambat . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Uang Makan</td>
            <td colspan="2">: Rp. ' . $uang_makan . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan Tidak Masuk</td>
            <td>: Rp. ' . $uang_tidak_masuk . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Uang Transport</td>
            <td colspan="2">: Rp. ' . $uang_transport . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan Sakit</td>
            <td>: Rp. ' . $uang_sakit . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Uang Lembur</td>
            <td colspan="2">: Rp. ' . $uang_lembur . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan PPH</td>
            <td>: Rp. ' . $uang_pph . '</td>
        </tr>
        <tr>
            <td colspan="7">
                <hr>
            </td>
        </tr>
        <tr>
            <td style="width: 200px">Total Penerimaan</td>
            <td colspan="2">: Rp. ' . $pendapatan . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Total Potongan</td>
            <td>: Rp. ' . $result_gaji["uang_potongan"] . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Gaji Yang Diterima</td>
            <td colspan="2">: Rp. ' . $result_gaji["gaji_bersih"] . '</td>
        </tr>
        <tr>
            <td colspan="7">
                <hr>
            </td>
        </tr>
        <tr>
            <td style="width: 200px">Nama Perusahaan</td>
            <td colspan="2">: Dinobites Caffe</td>
            <td style="width: 20px"></td>
            <td align="center" style="width: 200px">Diserahkan</td>
            <td align="center" style="width:100px ">Diterima</td>
        </tr>
        <tr>
            <td style=" width:200px ">Tanggal</td>
            <td colspan="2">: ' . $result_gaji["periode"] . '</td>
        </tr>
        <tr>
            <td style="width:200px ">Departemen</td>
            <td colspan="2">: Owner</td>
        </tr>
        <tr>
            <td style="width:200px ">NIK</td>
            <td colspan="2">: ' . $nik . '</td>
        </tr>
        <tr>
            <td style="width:200px ">Nama</td>
            <td colspan="2" >: ' . $result_karyawan["nama"] . '</td>
        </tr>
        <tr>
            <td style="width:200px ">Jabatan</td>
            <td colspan="2">: ' . $result_karyawan["jabatan"] . '</td>
            <td style="width: 20px"></td>
            <td style="width:200px " align="center">Owner
                <hr>
            </td>
            <td align="center">' . $result_karyawan["nama"] . '
                <hr>
            </td>
        </tr>
    </table>
</body>

</html>';
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan Gaji.pdf', \Mpdf\Output\Destination::INLINE);

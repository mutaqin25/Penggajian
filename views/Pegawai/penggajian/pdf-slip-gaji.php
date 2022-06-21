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
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => 'A4-P']);

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
$gaji_bersih = $result_gaji_bersih['gaji_bersih'];

$cek_bpjs = mysqli_query($conn, "select bpjs as bpjs from karyawan where nik = $nik");
$data_bpjs = mysqli_fetch_array($cek_bpjs);

$exp_bpjs = explode(",", $data_bpjs['bpjs']);
if (in_array(
    "Jaminan Kesehatan",
    $exp_bpjs
)) {
    $jk = 0.04; //penerimaan
} else {
    $jk = 0;
}
if (in_array("Jaminan Kecelakaan Kerja", $exp_bpjs)) {
    $jkk = 0.0024; //penerimaan
} else {
    $jkk = 0;
}
if (in_array("Jaminan Hari Tua", $exp_bpjs)) {
    $jht = 0.02; //pengurangan
} else {
    $jht = 0;
}
if (in_array("Jaminan Pensiun", $exp_bpjs)) {
    $jp = 0.01; //pengrangan
} else {
    $jp = 0;
}
if (in_array("Jaminan Kematian", $exp_bpjs)) {
    $jkm = 0.003; // penambahan
} else {
    $jkm = 0;
}
// tunjangan
$bpjs_jk = $jk * $result_karyawan['gaji'];
$bpjs_jkm = $jkm * $result_karyawan['gaji'];
$bpjs_jkk = $jkk * $result_karyawan['gaji'];

// potongan
$bpjs_jht = $jht * $result_karyawan['gaji'];
$bpjs_jp = $jp * $result_karyawan['gaji'];

$tgl = $result_gaji['periode'];
$date  = date_create($tgl);
$periode = date_format($date, "m-Y");

$tunjangan = $result_karyawan['gaji'] + $uang_makan + $uang_transport;
$pendapatan = $tunjangan + $uang_lembur + $bpjs_jk + $bpjs_jkm + $bpjs_jkk;

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
<h3 align="center"><img style="width:300px" src="../../../assets/images/logo/dinobites.png"></h3>
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
            <td style=" width:200px ">Periode</td>
            <td colspan="2">: ' . $periode . '</td>
            <td style="width:20px "></td>
            <td style="width:200px ">Nama Karyawan</td>
            <td>: ' . $result_karyawan["nama"] . '</td>
        </tr>
        <tr>
            <td style="width:200px ">Pemberi</td>
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
            <td colspan="2">: Rp. ' . number_format($result_karyawan["gaji"], 0, ",", ".") . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan Terlamabat</td>
            <td>: Rp. ' . number_format($uang_terlambat, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Uang Makan</td>
            <td colspan="2">: Rp. ' . number_format($uang_makan, 0, ",", ".") . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan Tidak Masuk</td>
            <td>: Rp. ' . number_format($uang_tidak_masuk, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Uang Transport</td>
            <td colspan="2">: Rp. ' . number_format($uang_transport, 0, ",", ".") . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan Sakit</td>
            <td>: Rp. ' . number_format($uang_sakit, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Uang Lembur</td>
            <td colspan="2">: Rp. ' . number_format($uang_lembur, 0, ",", ".") . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan PPH</td>
            <td>: Rp. ' . number_format($uang_pph, 0, ",", ".") . '</td>
        </tr>
        <tr>
        <td >BPJS <hr></td>
        <td colspan="3" style="width: 20px"></td>
        <td >BPJS <hr></td>
        </tr>
        <tr>
            <td style="width: 200px">Tunjangan JK</td>
            <td colspan="2">: Rp. ' . number_format($bpjs_jk, 0, ",", ".") . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan JHT</td>
            <td>: Rp. ' . number_format($bpjs_jht, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Tunjangan JKM</td>
            <td colspan="2">: Rp. ' . number_format($bpjs_jkm, 0, ",", ".") . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Potongan JP</td>
            <td>: Rp. ' . number_format($bpjs_jp, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Tunjangan JKK</td>
            <td colspan="2">: Rp. ' . number_format($bpjs_jkk, 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td colspan="7">
                <hr>
            </td>
        </tr>
        <tr>
            <td style="width: 200px">Total Penerimaan</td>
            <td colspan="2">: Rp. ' . number_format($pendapatan, 0, ",", ".") . '</td>
            <td style="width: 20px"></td>
            <td style="width: 200px">Total Potongan</td>
            <td>: Rp. ' . number_format($result_gaji["uang_potongan"], 0, ",", ".") . '</td>
        </tr>
        <tr>
            <td style="width: 200px">Gaji Yang Diterima</td>
            <td colspan="2">: Rp. ' . number_format($result_gaji["gaji_bersih"], 0, ",", ".") . '</td>
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
            <td style=" width:200px ">Periode</td>
            <td colspan="2">: ' . $periode . '</td>
        </tr>
        <tr>
            <td style="width:200px ">Pemberi</td>
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
            <td style="width:200px ">Jabatan
                <br> .
            </td>
            <td colspan="2">: ' . $result_karyawan["jabatan"] . '
                <br >.
            </td>
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

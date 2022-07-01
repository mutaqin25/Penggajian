<?php
include  '../../../config.php';



if (isset($_POST['excel'])) {
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=Data Absen.xls");
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tanggal = $tahun . '-' . $bulan;
?>



    <table border="1">
        <thead>
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Ket Masuk</th>
                <th>Jam Keluar</th>
                <th>Ket Keluar</th>
                <th>Keteranan</th>

            </tr>
        </thead>
        <tbody>
            <?php

            $no = 1;
            $data = mysqli_query($conn, "select * from absen where tanggal like '%$tanggal%' ");
            while ($d = mysqli_fetch_array($data)) {
            ?>
                <tr>
                    <td><?php echo $no++ ?></td>
                    <td><?php echo $d['nik'] ?></td>
                    <td><?php echo $d['tanggal'] ?></td>
                    <td><?php echo $d['jam_masuk'] ?></td>
                    <td><?php echo $d['ket_masuk'] ?></td>
                    <td><?php echo $d['jam_keluar'] ?></td>
                    <td><?php echo $d['ket_keluar'] ?></td>
                    <td><?php echo $d['keterangan'] ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
<?php

} else {
    require_once __DIR__ . '/../../../assets/vendor/autoload.php';

    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tanggal = $tahun . '-' . $bulan;

    $data = mysqli_query($conn, "select * from absen where tanggal like '%$tanggal%' ");

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
<h3 align="center"><img style="width:300px" src="../../../assets/images/logo/dinobites.png"></h3>
<h1 align="center" >Laporan Data Absen Karyawan</h1>
    <table border="1" align="center">
                                    <thead>
                                        <tr align="center">
                                            <th>No</th>
                                            <th>Nik</th>
                                            <th>Tanggal</th>
                                            <th>Jam Masuk</th>
                                            <th>Ket Masuk</th>
                                            <th>Jam Keluar</th>
                                            <th>Ket Keluar</th>
                                            <th>Keteranan</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
    $i = 1;
    foreach ($data as $row) {
        $html .= '<tr>
            <td>' . $i++ . '</td>
            <td>' . $row["nik"] . '</td>
            <td>' . $row["tanggal"] . '</td>
            <td>' . $row["jam_masuk"] . '</td>
            <td>' . $row["ket_masuk"] . '</td>
            <td>' . $row["jam_keluar"] . '</td>
            <td>' . $row["ket_keluar"] . '</td>
            <td>' . $row["keterangan"] . '</td>
            </tr>';
    }

    $html .= '</tbody>
</table>
</body>
</html>';
    $mpdf->WriteHTML($html);
    $mpdf->Output('laporan-absensi.pdf', \Mpdf\Output\Destination::INLINE);
}

?>
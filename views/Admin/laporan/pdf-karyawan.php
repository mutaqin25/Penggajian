p<?php
    include '../../../config.php';
    require_once __DIR__ . '/../../../assets/vendor/autoload.php';

    $data = mysqli_query($conn, "select * from karyawan ");

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
<h1 align="center" >Laporan Data Karyawan</h1>
    <table border="1" align="center" >
                                    <thead>
                                        <tr align="center">
                                            <th>No</th>
                                            <th>Nik</th>
                                            <th>Nama</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Alamat</th>
                                            <th>Status</th>
                                            <th>Agama</th>
                                            <th>No Hp</th>
                                            <th>Jabatan</th>
                                            <th>Shift</th>
                                            <th>Gaji</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Pendidikan</th>
                                            <th>Foto</th>
                                            <th>QR Code</th>
                                        </tr>
                                    </thead>
                                    <tbody>';
    $i = 1;
    foreach ($data as $row) {
        $html .= '<tr>
            <td>' . $i++ . '</td>
            <td>' . $row["nik"] . '</td>
            <td>' . $row['nama'] . '</td>
            <td>' . $row['jenis_kelamin'] . '</td>
            <td>' . $row['tgl_lahir'] . '</td>
            <td>' . $row['alamat'] . '</td>
            <td>' . $row['status'] . '</td>
            <td>' . $row['agama'] . '</td>
            <td>' . $row['no_hp'] . '</td>
            <td>' . $row['jabatan'] . '</td>
            <td>' . $row['shift'] . '</td>
            <td>Rp.' . $row['gaji'] . '</td>
            <td>' . $row['tgl_masuk'] . '</td>
            <td>' . $row['pendidikan'] . '</td>
            <td><img style="width: 67px;" src="../../../assets/images/profil/' . $row['foto'] . '"></td>
            <td><img style="width: 67px;" src="../../../assets/images/QRCode/' . $row['qrcode'] . '"></td>
            </tr>';
    }

    $html .= '</tbody>
</table>
</body>
</html>';
    $mpdf->WriteHTML($html);
    $mpdf->Output('Laporan Data Karyawan.pdf', \Mpdf\Output\Destination::INLINE);

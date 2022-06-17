<?php
include  '../../../config.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Absen.xls");

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
        $data = mysqli_query($conn, "select * from absen ");
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
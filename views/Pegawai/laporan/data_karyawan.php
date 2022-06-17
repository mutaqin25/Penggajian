<?php
include  '../../../config.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Karyawan.xls");

?>


<table border="1">
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
    <tbody>
        <?php

        $no = 1;
        $data = mysqli_query($conn, "select * from karyawan ");
        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $d['nik'] ?></td>
                <td><?php echo $d['nama'] ?></td>
                <td><?php echo $d['jenis_kelamin'] ?></td>
                <td><?php echo $d['tgl_lahir'] ?></td>
                <td><?php echo $d['alamat'] ?></td>
                <td><?php echo $d['status'] ?></td>
                <td><?php echo $d['agama'] ?></td>
                <td><?php echo $d['no_hp'] ?></td>
                <td><?php echo $d['jabatan'] ?></td>
                <td><?php echo $d['shift'] ?></td>
                <td>Rp.<?php echo $d['gaji'] ?></td>
                <td><?php echo $d['tgl_masuk'] ?></td>
                <td><?php echo $d['pendidikan'] ?></td>

                <td><img style="width: 64px;" src="../../../assets/images/profil/<?php echo $d['foto'] ?>"></td>
                <td><img style="width: 64px;" src="../../../assets/images/QRCode/<?php echo $d['qrcode'] ?>"></td>

            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
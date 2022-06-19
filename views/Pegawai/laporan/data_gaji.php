<?php
include  '../../../config.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Gaji.xls");

?>


<table border="1">
    <thead>
        <tr align="left">
            <th>No</th>
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
    <tbody>
        <?php
        $nik = $_GET['nik'];
        $no = 1;
        $data = mysqli_query($conn, "select * from gaji_bulanan where nik =$nik ");

        while ($d = mysqli_fetch_array($data)) {
        ?>
            <tr>
                <td><?php echo $no++ ?></td>
                <td><?php echo $d['periode'] ?></td>
                <td>Rp. <?php echo $d['gaji_pokok'] ?></td>
                <td>Rp. <?php echo $d['uang_tunjangan'] ?></td>
                <td>Rp. <?php echo $d['uang_lembur'] ?></td>
                <td>Rp. <?php echo $d['uang_potongan'] ?></td>
                <td>Rp. <?php echo $d['bpjs'] ?></td>
                <td>Rp. <?php echo $d['pph21'] ?></td>
                <td>Rp. <?php echo $d['gaji_bersih'] ?></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
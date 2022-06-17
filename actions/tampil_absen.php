<?php

include '../config.php';
?>

<div class="table-responsive" id="live_data">
    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" align="center">
        <thead>
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Ket Masuk</th>
                <th>Jam Keluar</th>
                <th>Ket Keluar</th>
                <th>ket</th>

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>No</th>
                <th>Nik</th>
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Ket Masuk</th>
                <th>Jam Keluar</th>
                <th>Ket Keluar</th>
                <th>ket</th>
            </tr>
        </tfoot>
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
                    <td>
                        <a class="btn btn-success" href="edit-karyawan.php?id=<?php echo $d['nik']; ?>" data-toggle="tooltip" title="Edit" role="button"><i class="fa-solid fa-pen-to-square"></i></a>
                        <a class="btn btn-danger" href="../../../actions/delete-karyawan.php?id=<?php echo $d['nik']; ?>" data-toggle="tooltip" title="Delete" role="button"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
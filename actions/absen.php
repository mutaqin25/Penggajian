<?php include '../config.php' ?>

<div class="table-responsive">
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
                <th>Keteranan</th>
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
                <th>Keteranan</th>
                <th>ket</th>
            </tr>
        </tfoot>
        <tbody>
            <?php

            if (isset($_POST['tahun']) != '') {
                $bulan = $_POST['bulan'];
                $tahun = $_POST['tahun'];
                $tanggal = $tahun . '-' . $bulan;
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
                        <td>
                            <a class="btn btn-success" href="edit-absensi.php?id=<?php echo $d['id_absen']; ?>" data-toggle="tooltip" title="Edit" role="button"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a class="btn btn-danger" href="../../../actions/delete-absensi.php?id=<?php echo $d['id_absen']; ?>" data-toggle="tooltip" title="Delete" role="button"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
                <?php
                }
            } else if (isset($_POST['tahun']) == '') {
                ?>
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
                        <td>
                            <a class="btn btn-success" href="edit-absensi.php?id=<?php echo $d['id_absen']; ?>" data-toggle="tooltip" title="Edit" role="button"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a class="btn btn-danger" href="../../../actions/delete-absensi.php?id=<?php echo $d['id_absen']; ?>" data-toggle="tooltip" title="Delete" role="button"><i class="fa-solid fa-trash-can"></i></a>
                        </td>
                    </tr>
            <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>
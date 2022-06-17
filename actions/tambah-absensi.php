<?php
include '../config.php';

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

    $nik = $_POST['nik'];
    $tanggal = $_POST['tgl'];
    $jam_masuk = $_POST['jam_masuk'];
    $ket_masuk = $_POST['ket_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    $ket_keluar = $_POST['ket_keluar'];
    $keterangan = $_POST['keterangan'];
    $date1 = date_create($_POST['jam_masuk']);
    $tgl_p = date_format($date1, 'G:i');


    //------------------------------------------ Pecah Tanggal ------------------------------------------//

    $pecah_tgl = explode("-", $tanggal);
    $pecah_thn = $pecah_tgl[0];
    $pecah_bln = $pecah_tgl[1];

    switch ($pecah_bln) {
        case '01';
            $bln = "January";
            break;
        case '02';
            $bln = "February";
            break;
        case '03';
            $bln = "March";
            break;
        case '04';
            $bln = "April";
            break;
        case '05';
            $bln = "May";
            break;
        case '06';
            $bln = "June";
            break;
        case "07";
            $bln = "July";
            break;
        case "08";
            $bln = "August";
            break;
        case "09";
            $bln = "September";
            break;
        case "10";
            $bln = "October";
            break;
        case "11";
            $bln = "November";
            break;
        case "12";
            $bln = "December";
            break;
    }

    //------------------------------------------ Pecah Tanggal ------------------------------------------//


    // membuat id
    $cek_id = mysqli_query($conn, "select max(id_absen) as kode from absen");
    $jumlah = mysqli_fetch_array($cek_id);
    $no = $jumlah['kode'];
    $id = $no + 1;

    // cek tanggal now
    $cek_tgl_now = mysqli_query($conn, "select max(tanggal) as tanggal from absen where nik = $nik ");
    $data_tgl_now = mysqli_fetch_array($cek_tgl_now);
    $tgl_now = $data_tgl_now['tanggal'];

    // cek shift
    $cek_shift = mysqli_query($conn, "select shift as shift from karyawan where nik = $nik");
    $data_shift = mysqli_fetch_array($cek_shift);
    $shift = $data_shift['shift'];

    // ----------------------------------- penghasilan -----------------------------------  //

    // membuat id penghasilan
    $cek_id2 = mysqli_query($conn, "select max(id_penghasilan) as kode from penghasilan");
    $jumlah2 = mysqli_fetch_array($cek_id2);
    $no2 = $jumlah2['kode'];
    $id2 = $no2 + 1;

    // cek gaji
    $cek_gaji = mysqli_query($conn, "select gaji as gaji from karyawan where nik = $nik");
    $data_gaji = mysqli_fetch_array($cek_gaji);
    $gaji = $data_gaji['gaji'];


    // cek status
    $cek_status = mysqli_query($conn, "select status as status from karyawan where nik = $nik");
    $data_status = mysqli_fetch_array($cek_status);
    $status = $data_status['status'];


    if ($tanggal != $tgl_now) {
        if ($keterangan == 'Hadir') {

            if ($shift == 'Shift 1') {
                if ($jam_masuk <= '08:00:00') {
                    $jam_terlambat = 0;
                    $total_terlambat = $jam_terlambat;
                } else if ($jam_masuk > '08:00:00') {
                    date_default_timezone_set('Asia/Jakarta');

                    $date1 = date_create("08:00:00");
                    $date2 = date_create($_POST['jam_masuk']);
                    $diff = date_diff($date1, $date2);
                    $jam_terlambat = $diff->h;
                    $total_terlambat = $jam_terlambat;
                }

                if ($jam_keluar < '15:00:00') {
                    $jam_lembur = 0;
                    $total_lembur = $jam_lembur;
                } else if ($jam_keluar > '15:00:00') {
                    // cek berapa jam lembur
                    $date1 = date_create("15:00:00");
                    $date2 = date_create($_POST['jam_keluar']);;
                    $diff = date_diff($date1, $date2);
                    $jam_lembur = $diff->h;
                    $total_lembur = $jam_lembur;
                }




                $total_hadir = 1;
                $uang_terlambat = $total_terlambat * 10000;
                $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                // $gaji_neto = $gaji + $uang_makan + $uang_transport + - $uang_terlambat;
                $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_terlambat;

                $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal, hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id', '$tanggal', '$total_hadir', '', '','$total_terlambat','$total_lembur','$gaji','$uang_makan','$uang_transport','', '','$uang_lembur', '$uang_terlambat','$gaji_neto')";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
            } else if ($shift == 'Shift 2') {
                // cek jam Masuk
                if ($jam_masuk <= '15:00:00') {
                    $jam_terlambat = 0;
                } else if ($jam_masuk > '15:00:00') {
                    date_default_timezone_set('Asia/Jakarta');

                    $date1 = date_create("15:00:00");
                    $date2 = date_create($_POST['jam_masuk']);
                    $diff = date_diff($date1, $date2);
                    $jam_terlambat = $diff->h;
                }

                // cek Jam Keluar
                if ($jam_keluar < '21:00:00') {
                    $jam_terlambat = 0;
                } else if ($jam_keluar > '21:00:00') {
                    // cek berapa jam lembur
                    $date1 = date_create("21:00:00");
                    $date2 = date_create($_POST['jam_keluar']);
                    $diff = date_diff($date1, $date2);
                    $jam_lembur = $diff->h;
                }

                $total_hadir = 1;
                $total_terlambat = $jam_terlambat;
                $total_lembur = $jam_lembur;
                $uang_terlambat = $total_terlambat * 10000;
                $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                // $gaji_neto = $gaji + $uang_makan + $uang_transport + - $uang_terlambat;
                $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_terlambat;

                $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal, hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id','$tanggal', '$total_hadir', '', '','$total_terlambat','$total_lembur','$gaji','$uang_makan','$uang_transport','', '','$uang_lembur', '$uang_terlambat','$gaji_neto')";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
            }
        } else if ($keterangan == 'Tidak Masuk') {

            $total_tidak_masuk = 1;
            $uang_tidak_masuk = $total_tidak_masuk * 100000;
            $gaji_neto = $gaji - $uang_tidak_masuk;

            $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal, hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id', '$tanggal', '', '$total_tidak_masuk', '','','','$gaji','','','', '$uang_tidak_masuk','', '','$gaji_neto')";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
        } else if ($keterangan == 'Sakit') {
            echo 'adada' . '<br>';

            $total_sakit =  1;
            $uang_sakit = $total_sakit * 75000;
            $gaji_neto = $gaji - $uang_sakit;

            $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal, hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id','$tanggal', '', '', '$total_sakit','','','$gaji','','','$uang_sakit', '','','','$gaji_neto')";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
        }

        $sql = "INSERT INTO absen (id_absen, nik, tanggal, jam_masuk, ket_masuk, jam_keluar, ket_keluar, keterangan) VALUE ('$id', '$nik', '$tanggal', '$jam_masuk', '$ket_masuk', '$jam_keluar', '$ket_keluar', '$keterangan' )";
        $query = mysqli_query($conn, $sql);
        // menginput data ke database

        if ($query) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            header('Location: ../views/Admin/absensi/form-absensi.php');
            // echo mysqli_error($conn);
            // echo $sql;
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            header('Location: ../views/Admin/absensi/form-absensi.php');
            // echo mysqli_error($conn);
            // echo $sql;
        }
    } else {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Sudah Ada!";
        header('Location: ../views/Admin/absensi/form-absensi.php');
        // echo mysqli_error($conn);
        // echo $sql;
    }
} else {
    die("gagal menginputkan data");
}

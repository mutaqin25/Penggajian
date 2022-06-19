<?php
include '../config.php';


$nik = $_POST['nik'];
// $nik = 20160910024;
$tanggal = date("Y-m-d");
$bln = date("F", strtotime('now'));
$thn = date("Y", strtotime('now'));
$strTgl = '2022-06-09';
// $my_date = strtotime($tanggal);
date_default_timezone_set('Asia/Jakarta');
$jam = date('G:i:s');
echo $jam;

// ----------------------------------- absen -----------------------------------  // 

// membuat id_absen
$cek_id = mysqli_query($conn, "select max(id_absen) as kode from absen");
$jumlah = mysqli_fetch_array($cek_id);
$no = $jumlah['kode'];
$id = $no + 1;

// // cek absen
// $cek_id_absen = mysqli_query($conn, "select mx(id_absen) as id_absen from penghasilan where nik = $nik");
// $data_id_absen = mysqli_fetch_array($cek_id_absen);
// $id_absen = $data_id_absen['id_absen'];

// cek shift
$cek_shift = mysqli_query($conn, "select shift as shift from karyawan where nik = $nik");
$data_shift = mysqli_fetch_array($cek_shift);
$shift = $data_shift['shift'];

// cek tanggal now
$cek_tgl_now = mysqli_query($conn, "select max(tanggal) as tanggal from absen where nik = $nik ");
$data_tgl_now = mysqli_fetch_array($cek_tgl_now);
$tgl_now = $data_tgl_now['tanggal'];

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

// // cek tahun
// $cek_tahun = mysqli_query($conn, "select max(tahun) as tahun from penghasilan where nik = $nik ");
// $data_tahun = mysqli_fetch_array($cek_tahun);
// $tahun = $data_tahun['tahun'];

// cek id berdasarkan nik terbaru
$cek_id_p = mysqli_query($conn, "select max(id_penghasilan) as id from penghasilan where nik = $nik ");
$data_id_p = mysqli_fetch_array($cek_id_p);
$id_p = $data_id_p['id'];

// // cek bulan
// $cek_bulan = mysqli_query($conn, "select bulan from penghasilan where id_penghasilan = $id_p ");
// $data_bulan = mysqli_fetch_array($cek_bulan);
// $bulan = $data_bulan['bulan'];


if ($shift == 'Shift 1') {
    if ($tanggal != $tgl_now) {
        if ($jam <= '09:00:00') {
            $jam_masuk = $jam;
            $ket_masuk = "Tepat Waktu";
        } else if ($jam >= '09:00:00') {
            $jam_masuk = $jam;
            $ket_masuk = "Terlambat";
        }

        if ($jam <= '09:00:00') {

            $jam_terlambat = 0;
            $uang_terlambat = $jam_terlambat * 10000;
            $uang_neto = $gaji - $uang_terlambat;
            $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal,  hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id', '$tanggal', '', '', '','$jam_terlambat','','$gaji','','','', '','', '$uang_terlambat','$gaji_neto')";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
        } else if ($jam > '09:00:00') {
            date_default_timezone_set('Asia/Jakarta');

            $date1 = date_create("09:00:00");
            $date2 = date_create();
            $diff = date_diff($date1, $date2);

            $jam_terlambat = $diff->h;
            $uang_terlambat = $jam_terlambat * 10000;
            $gaji_neto = $gaji - $uang_terlambat;

            $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal,  hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id', '$tanggal', '', '', '','$jam_terlambat','','$gaji','','','', '','', '$uang_terlambat','$gaji_neto')";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
            echo mysqli_error($conn);
        }

        $sql = "INSERT INTO absen (id_absen, nik, tanggal, jam_masuk, ket_masuk, jam_keluar, ket_keluar) VALUE ('$id', '$nik', '$tanggal', '$jam_masuk', '$ket_masuk', '', '')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
            echo mysqli_error($conn);
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
            echo mysqli_error($conn);
        }
    } else if ($tanggal == $tgl_now) {
        if ($jam < '17:00:00') {
            $jam_keluar = $jam;
            $ket_keluar = "Pulang Lebih Awal";
            $keterangan = 'Hadir';
        } else if ($jam == '17:00:00') {
            $jam_keluar = $jam;
            $ket_keluar = "Pulang";
            $keterangan = 'Hadir';
        } else if ($jam > '17:00:00') {
            $jam_keluar = $jam;
            $ket_keluar = "Lembur";
            $keterangan = 'Hadir';
        }


        if ($jam <= '17:00:00') {
            // cek jumlah Kehadiran
            $cek_hadir = mysqli_query($conn, "select hadir as hadir from penghasilan where id_penghasilan = $id_p ");
            $data_hadir = mysqli_fetch_array($cek_hadir);
            $hadir = $data_hadir['hadir'];

            // cek uang terlambat
            $cek_uang_terlambat = mysqli_query($conn, "select uang_terlambat as uang_terlambat from penghasilan where id_penghasilan = $id_p");
            $data_uang_terlambat = mysqli_fetch_array($cek_uang_terlambat);
            $uang_terlambat = $data_uang_terlambat['uang_terlambat'];

            // cek uang tidak masuk
            $cek_uang_tidak_masuk = mysqli_query($conn, "select uang_tidak_masuk as uang_tidak_masuk from penghasilan where id_penghasilan = $id_p");
            $data_uang_tidak_masuk = mysqli_fetch_array($cek_uang_tidak_masuk);
            $uang_tidak_masuk = $data_uang_tidak_masuk['uang_tidak_masuk'];

            // cek uang sakit
            $cek_uang_sakit = mysqli_query($conn, "select uang_sakit as uang_sakit from penghasilan where id_penghasilan = $id_p");
            $data_uang_sakit = mysqli_fetch_array($cek_uang_sakit);
            $uang_sakit = $data_uang_sakit['uang_sakit'];

            // cek uang lembur
            $cek_uang_lembur = mysqli_query($conn, "select uang_lembur as uang_lembur from penghasilan where id_penghasilan = $id_p");
            $data_uang_lembur = mysqli_fetch_array($cek_uang_lembur);
            $uang_lembur = $data_uang_lembur['uang_lembur'];



            $jml_hadir = $hadir + 1;
            $uang_makan = $jml_hadir * 20000;
            $uang_transport = $jml_hadir * 20000;
            $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_tidak_masuk - $uang_sakit - $uang_terlambat;


            $sql_penghasilan = "Update penghasilan SET  hadir ='$jml_hadir', uang_makan='$uang_makan', uang_transport='$uang_transport', gaji_neto='$gaji_neto' WHERE id_penghasilan = '$id_p' ";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
        } else if ($jam > '17:00:00') {
            // cek berapa jam lembur
            $date1 = date_create("17:00:00");
            $date2 = date_create();
            $diff = date_diff($date1, $date2);
            $jam_lembur = $diff->h;

            // cek jumlah lembur
            $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_penghasilan = $id_p ");
            $data_lembur = mysqli_fetch_array($cek_lembur);
            $lembur = $data_lembur['lembur'];

            // cek jumlah Kehadiran
            $cek_hadir = mysqli_query($conn, "select hadir as hadir from penghasilan where id_penghasilan = $id_p");
            $data_hadir = mysqli_fetch_array($cek_hadir);
            $hadir = $data_hadir['hadir'];

            // cek uang terlambat
            $cek_uang_terlambat = mysqli_query($conn, "select uang_terlambat as uang_terlambat from penghasilan where id_penghasilan = $id_p");
            $data_uang_terlambat = mysqli_fetch_array($cek_uang_terlambat);
            $uang_terlambat = $data_uang_terlambat['uang_terlambat'];

            // cek uang tidak masuk
            $cek_uang_tidak_masuk = mysqli_query($conn, "select uang_tidak_masuk as uang_tidak_masuk from penghasilan where id_penghasilan = $id_p");
            $data_uang_tidak_masuk = mysqli_fetch_array($cek_uang_tidak_masuk);
            $uang_tidak_masuk = $data_uang_tidak_masuk['uang_tidak_masuk'];

            // cek uang sakit
            $cek_uang_sakit = mysqli_query($conn, "select uang_sakit as uang_sakit from penghasilan where id_penghasilan = $id_p");
            $data_uang_sakit = mysqli_fetch_array($cek_uang_sakit);
            $uang_sakit = $data_uang_sakit['uang_sakit'];

            $jml_hadir = $hadir + 1;
            $uang_makan = $jml_hadir * 20000;
            $uang_transport = $jml_hadir * 20000;
            $total_lembur = $lembur + $jam_lembur;
            $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
            $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_tidak_masuk - $uang_sakit - $uang_terlambat;

            $sql_penghasilan = "Update penghasilan SET  hadir ='$jml_hadir', lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_lembur='$uang_lembur', gaji_neto='$gaji_neto' WHERE id_penghasilan = '$id_p' ";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
        }

        $sql = "UPDATE absen SET jam_keluar='$jam_keluar', ket_keluar='$ket_keluar', keterangan = '$keterangan' WHERE nik='$nik'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
            echo mysqli_error($conn);
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
            echo mysqli_error($conn);
        }
    }
} else if ($shift == 'Shift 2') {
    if ($tanggal != $tgl_now) {
        if ($jam <= '14:00:00') {
            $jam_masuk = $jam;
            $ket_masuk = "Tepat Waktu";
        } else if ($jam >= '14:00:00') {
            $jam_masuk = $jam;
            $ket_masuk = "Terlambat";
        }

        if ($jam <= '14:00:00') {
            echo 'adadas';
            $jam_terlambat = 0;
            $uang_terlambat = $jam_terlambat * 10000;
            $gaji_neto = $gaji - $uang_terlambat;

            $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal, hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id','$tanggal', '', '', '','$jam_terlambat','','$gaji','','','','','', '$uang_terlambat','$gaji_neto')";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
            echo mysqli_error($conn);
        } else if ($jam > '14:00:00') {

            date_default_timezone_set('Asia/Jakarta');

            $date1 = date_create("14:00:00");
            $date2 = date_create();
            $diff = date_diff($date1, $date2);

            $jam_terlambat = $diff->h;
            $uang_terlambat = $jam_terlambat * 10000;
            $gaji_neto = $gaji - $uang_terlambat;



            $sql_penghasilan = "INSERT INTO penghasilan (id_penghasilan, nik, id_absen, tanggal, hadir, tidak_masuk, sakit, terlambat, lembur, gaji_pokok, uang_makan, uang_transport, uang_sakit, uang_tidak_masuk, uang_lembur, uang_terlambat, gaji_neto) VALUE ('$id2', '$nik', '$id', '$tanggal', '', '', '','$jam_terlambat','','$gaji','','','','','', '$uang_terlambat','$gaji_neto')";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
            echo mysqli_error($conn);
        }

        $sql = "INSERT INTO absen (id_absen, nik, tanggal, jam_masuk, ket_masuk, jam_keluar, ket_keluar) VALUE ('$id',  '$nik', '$tanggal', '$jam_masuk', '$ket_masuk', '', '')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
        }
    } else if ($tanggal == $tgl_now) {
        if ($jam < '22:00:00') {
            $jam_keluar = $jam;
            $ket_keluar = "Pulang Lebih Awal";
            $keterangan = 'Hadir';
        } else if ($jam == '22:00:00') {
            $jam_keluar = $jam;
            $ket_keluar = "Tepat Waktu";
            $keterangan = 'Hadir';
        } else if ($jam > '22:00:00') {
            $jam_keluar = $jam;
            $ket_keluar = "Lembur";
            $keterangan = 'Hadir';
        }
        // echo 'adadad';

        if ($jam <= '22:00:00') {
            // cek jumlah Kehadiran
            $cek_hadir = mysqli_query($conn, "select hadir as hadir from penghasilan where id_penghasilan = $id_p ");
            $data_hadir = mysqli_fetch_array($cek_hadir);
            $hadir = $data_hadir['hadir'];


            // cek uang terlambat
            $cek_uang_terlambat = mysqli_query($conn, "select uang_terlambat as uang_terlambat from penghasilan where id_penghasilan = $id_p");
            $data_uang_terlambat = mysqli_fetch_array($cek_uang_terlambat);
            $uang_terlambat = $data_uang_terlambat['uang_terlambat'];

            // cek uang tidak masuk
            $cek_uang_tidak_masuk = mysqli_query($conn, "select uang_tidak_masuk as uang_tidak_masuk from penghasilan where id_penghasilan = $id_p");
            $data_uang_tidak_masuk = mysqli_fetch_array($cek_uang_tidak_masuk);
            $uang_tidak_masuk = $data_uang_tidak_masuk['uang_tidak_masuk'];

            // cek uang sakit
            $cek_uang_sakit = mysqli_query($conn, "select uang_sakit as uang_sakit from penghasilan where id_penghasilan = $id_p");
            $data_uang_sakit = mysqli_fetch_array($cek_uang_sakit);
            $uang_sakit = $data_uang_sakit['uang_sakit'];

            // cek uang lembur
            $cek_uang_lembur = mysqli_query($conn, "select uang_lembur as uang_lembur from penghasilan where id_penghasilan = $id_p");
            $data_uang_lembur = mysqli_fetch_array($cek_uang_lembur);
            $uang_lembur = $data_uang_lembur['uang_lembur'];

            $jml_hadir = $hadir + 1;
            $uang_makan = $jml_hadir * 20000;
            $uang_transport = $jml_hadir * 20000;
            $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_tidak_masuk - $uang_sakit - $uang_terlambat;

            $sql_penghasilan = "Update penghasilan SET  hadir ='$jml_hadir', uang_makan='$uang_makan', uang_transport='$uang_transport', gaji_neto='$gaji_neto' WHERE id_penghasilan = '$id_p' ";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
            echo mysqli_error($conn);
        } else if ($jam > '22:00:00') {
            // cek berapa jam lembur
            $date1 = date_create("22:00:00");
            $date2 = date_create();
            $diff = date_diff($date1, $date2);
            $jam_lembur = $diff->h;

            // cek lembur
            $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_penghasilan = $id_p ");
            $data_lembur = mysqli_fetch_array($cek_lembur);
            $lembur = $data_lembur['lembur'];

            // cek jumlah Kehadiran
            $cek_hadir = mysqli_query($conn, "select hadir as hadir from penghasilan where id_penghasilan = $id_p");
            $data_hadir = mysqli_fetch_array($cek_hadir);
            $hadir = $data_hadir['hadir'];

            // cek uang terlambat
            $cek_uang_terlambat = mysqli_query($conn, "select uang_terlambat as uang_terlambat from penghasilan where id_penghasilan = $id_p");
            $data_uang_terlambat = mysqli_fetch_array($cek_uang_terlambat);
            $uang_terlambat = $data_uang_terlambat['uang_terlambat'];

            // cek uang tidak masuk
            $cek_uang_tidak_masuk = mysqli_query($conn, "select uang_tidak_masuk as uang_tidak_masuk from penghasilan where id_penghasilan = $id_p");
            $data_uang_tidak_masuk = mysqli_fetch_array($cek_uang_tidak_masuk);
            $uang_tidak_masuk = $data_uang_tidak_masuk['uang_tidak_masuk'];

            // cek uang sakit
            $cek_uang_sakit = mysqli_query($conn, "select uang_sakit as uang_sakit from penghasilan where id_penghasilan = $id_p");
            $data_uang_sakit = mysqli_fetch_array($cek_uang_sakit);
            $uang_sakit = $data_uang_sakit['uang_sakit'];

            $jml_hadir = $hadir + 1;
            $uang_makan = $jml_hadir * 20000;
            $uang_transport = $jml_hadir * 20000;
            $total_lembur = $lembur + $jam_lembur;
            $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
            $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_tidak_masuk - $uang_sakit - $uang_terlambat;


            $sql_penghasilan = "Update penghasilan SET  hadir ='$jml_hadir', lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_lembur='$uang_lembur', gaji_neto='$gaji_neto' WHERE id_penghasilan = '$id_p' ";
            $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
            echo mysqli_error($conn);
        }


        $sql = "UPDATE absen SET jam_keluar='$jam_keluar', ket_keluar='$ket_keluar', keterangan = '$keterangan' WHERE nik='$nik'";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            // header('Location: ../views/Admin/absensi/form-absensi.php');
        }
    }
}

<?php
include '../config.php';
// session_start();

if (isset($_POST['simpan'])) {
    // menangkap data yang di kirim dari form

    $id_absen = $_POST['id_absen'];
    $nik_lama = $_POST['nik_lama'];
    $nik = $_POST['nik'];
    $tanggal = $_POST['tgl'];
    $jam_masuk = $_POST['jam_masuk'];
    $ket_masuk = $_POST['ket_masuk'];
    $jam_keluar = $_POST['jam_keluar'];
    $ket_keluar = $_POST['ket_keluar'];
    $keterangan = $_POST['keterangan'];

    //------------------------------------------ Pecah Tanggal ------------------------------------------//
    // cek tanggal
    $cek_tanggal = mysqli_query($conn, "select tanggal as tanggal from absen where id_absen = $id_absen");
    $data_tanggal = mysqli_fetch_array($cek_tanggal);
    $tanggal = $data_tanggal['tanggal'];

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

    // cek tanggal now
    $cek_tgl_now = mysqli_query($conn, "select max(tanggal) as tanggal from absen where nik = $nik_lama ");
    $data_tgl_now = mysqli_fetch_array($cek_tgl_now);
    $tgl_now = $data_tgl_now['tanggal'];

    // cek gaji
    $cek_gaji = mysqli_query($conn, "select gaji as gaji from karyawan where nik = $nik");
    $data_gaji = mysqli_fetch_array($cek_gaji);
    $gaji = $data_gaji['gaji'];

    // cek shift
    $cek_shift = mysqli_query($conn, "select shift as shift from karyawan where nik = $nik");
    $data_shift = mysqli_fetch_array($cek_shift);
    $shift = $data_shift['shift'];

    // cek status
    $cek_status = mysqli_query($conn, "select status as status from karyawan where nik = $nik");
    $data_status = mysqli_fetch_array($cek_status);
    $status = $data_status['status'];


    // ------------------------------ select data absensi ------------------------------ //

    // -------------------------------> cek data lama  

    // cek jam masuk
    $cek_jam_masuk = mysqli_query($conn, "select jam_masuk as jam_masuk from absen where id_absen = $id_absen");
    $data_jam_masuk = mysqli_fetch_array($cek_jam_masuk);
    $dl_jam_masuk = $data_jam_masuk['jam_masuk'];

    // cek jam masuk
    $cek_jam_keluar = mysqli_query($conn, "select jam_keluar as jam_keluar from absen where id_absen = $id_absen");
    $data_jam_keluar = mysqli_fetch_array($cek_jam_keluar);
    $dl_jam_keluar = $data_jam_keluar['jam_keluar'];

    // cek keterangan
    $cek_keterangan = mysqli_query($conn, "select keterangan as keterangan from absen where id_absen = $id_absen");
    $data_keterangan = mysqli_fetch_array($cek_keterangan);
    $dl_keterangan = $data_keterangan['keterangan'];

    // ------------------------------ select data absensi ------------------------------ //






    // -----------------------------> proses <----------------------------- //

    if ($tanggal != $tgl_now) {
        if ($keterangan == 'Hadir') {

            if ($dl_keterangan ==  'Hadir') {
                if ($shift == 'Shift 1') {
                    // cek jam masuk
                    if ($dl_jam_masuk <= '08:00:00' && $jam_masuk <= '08:00:00') {
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 1;
                    } else if ($dl_jam_masuk <= '08:00:00' && $jam_masuk > '08:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("08:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat + $jam_terlambat;
                        // $uang_terlambat = $total_terlambat * 10000;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 2;
                    } else if ($dl_jam_masuk > '08:00:00' && $jam_masuk <= '08:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("08:00:00");
                        $date2 = date_create($dl_jam_masuk);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat - $jam_terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 3;
                    } else if ($dl_jam_masuk > '08:00:00' && $jam_masuk > '08:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("08:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat + $jam_terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 4;
                    }
                    // jam keluar
                    if ($dl_jam_keluar <= '15:00:00' && $jam_keluar <= '15:00:00') {
                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 5;
                    } else if ($dl_jam_keluar <= '15:00:00' && $jam_keluar > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur + $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 6;
                    } else if ($dl_jam_keluar > '15:00:00' && $jam_keluar <= '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($dl_jam_keluar);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur - $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br> lembur' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 7;
                    } else if ($dl_jam_keluar > '15:00:00' && $jam_keluar > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur + $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $lembur;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 8;
                    }

                    $uang_terlambat = $total_terlambat * 10000;
                    $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
                } else if ($shift == 'Shift 2') {
                    // cek jam masuk
                    if ($dl_jam_masuk <= '15:00:00' && $jam_masuk <= '15:00:00') {
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 9;
                    } else if ($dl_jam_masuk <= '15:00:00' && $jam_masuk > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat + $jam_terlambat;
                        // $uang_terlambat = $total_terlambat * 10000;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 10;
                    } else if ($dl_jam_masuk > '15:00:00' && $jam_masuk <= '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($dl_jam_masuk);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat - $jam_terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 11;
                    } else if ($dl_jam_masuk > '15:00:00' && $jam_masuk > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat + $jam_terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 12;
                    }
                    // jam keluar
                    if ($dl_jam_keluar <= '21:00:00' && $jam_keluar <= '21:00:00') {
                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 13;
                    } else if ($dl_jam_keluar <= '21:00:00' && $jam_keluar > '21:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("21:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur + $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 14;
                    } else if ($dl_jam_keluar > '21:00:00' && $jam_keluar <= '21:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("21:00:00");
                        $date2 = date_create($dl_jam_keluar);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur - $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br> lembur' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 15;
                    } else if ($dl_jam_keluar > '21:00:00' && $jam_keluar > '21:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("21:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur + $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $lembur;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 16;
                    }


                    $uang_terlambat = $total_terlambat * 10000;
                    $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
                    echo '<br>' . $total_terlambat . '-' . $total_lembur;
                    echo '<br> uang terlambat' . $uang_terlambat;
                }

                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];


                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];


                $total_hadir = $hadir;
                $total_sakit = $sakit;
                $total_tidak_masuk = $tidak_masuk;

                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_sakit = $total_sakit * 75000;
                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_terlambat - $uang_sakit - $uang_tidak_masuk;



                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', terlambat = '$total_terlambat',  lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit='$uang_sakit', uang_tidak_masuk='$uang_tidak_masuk, uang_lembur='$uang_lembur', uang_terlambat='$uang_terlambat', gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo $sql_penghasilan;
            } else if ($dl_keterangan == 'Sakit') {
                if ($shift == 'Shift 1') {
                    // echo 'adad';
                    if ($jam_masuk <= '08:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                    } else if ($jam_masuk > '08:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $date1 = date_create("08:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        $total_terlambat = $terlambat + $jam_terlambat;
                    }

                    if ($jam_keluar <= '15:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                    } else if ($jam_keluar > '15:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        // cek berapa jam lembur
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;
                        $total_lembur = $lembur + $jam_lembur;
                    }
                } else if ($shift == 'Shift 2') {
                    if ($jam_masuk <= '15:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                    } else if ($jam_masuk > '15:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        $total_terlambat = $terlambat + $jam_terlambat;
                    }

                    if ($jam_keluar < '21:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                    } else if ($jam_keluar > '21:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        // cek berapa jam lembur
                        $date1 = date_create("21:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        $total_lembur = $lembur + $jam_lembur;
                    }
                }
                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];

                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                $total_hadir = $hadir + 1;
                if ($total_sakit = $sakit - 1 <  0) {
                    $total_sakit = 0;
                } else {
                    $total_sakit = $sakit - 1;
                }
                $total_tidak_masuk = $tidak_masuk;

                $uang_terlambat = $total_terlambat * 10000;
                $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_sakit = $total_sakit * 75000;
                $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_terlambat - $uang_sakit - $uang_tidak_masuk;


                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', sakit='$total_sakit', terlambat = '$total_terlambat',  lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit = '$uang_sakit'; uang_lembur='$uang_lembur', uang_terlambat='$uang_terlambat', gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo mysqli_error($conn);
                echo $sql_penghasilan;
            } else if ($dl_keterangan == 'Tidak Masuk') {
                if ($shift == 'Shift 1') {
                    // echo 'adad';
                    if ($jam_masuk <= '08:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                    } else if ($jam_masuk > '08:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $date1 = date_create("08:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        $total_terlambat = $terlambat + $jam_terlambat;
                    }

                    if ($jam_keluar <= '15:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                    } else if ($jam_keluar > '15:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        // cek berapa jam lembur
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;
                        $total_lembur = $lembur + $jam_lembur;
                    }
                } else if ($shift == 'Shift 2') {
                    if ($jam_masuk <= '15:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                    } else if ($jam_masuk > '15:00:00') {
                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $date1 = date_create("15:00:00");
                        $date2 = date_create($_POST['jam_masuk']);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;
                        // echo 'aaaasss';
                        $total_terlambat = $terlambat + $jam_terlambat;
                    }

                    if ($jam_keluar < '21:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                    } else if ($jam_keluar > '21:00:00') {
                        // cek jumlah lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        // cek berapa jam lembur
                        $date1 = date_create("21:00:00");
                        $date2 = date_create($_POST['jam_keluar']);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        $total_lembur = $lembur + $jam_lembur;
                    }
                }


                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];

                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                $total_hadir = $hadir + 1;
                $total_sakit = $sakit;
                if ($total_tidak_masuk = $tidak_masuk - 1 < 0) {
                    $total_tidak_masuk = 0;
                } else {
                    $total_tidak_masuk = $tidak_masuk - 1;
                }

                $uang_terlambat = $total_terlambat * 10000;
                $uang_lembur = $total_lembur * ((1 / 173) * $gaji);
                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_sakit = $total_sakit * 75000;
                $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_terlambat - $uang_sakit - $uang_tidak_masuk;

                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', tidak_masuk ='$total_tidak_masuk', terlambat = '$total_terlambat',  lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_lembur='$uang_lembur', uang_terlambat='$uang_terlambat', gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo mysqli_error($conn);
                echo $sql_penghasilan;
            }
        } else if ($keterangan == 'Sakit') {
            if ($dl_keterangan ==  'Hadir') {
                // cek jam masuk
                if ($shift == 'Shift 1') {
                    if ($dl_jam_masuk <= '08:00:00') {
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 16;
                    } else if ($dl_jam_masuk > '08:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("08:00:00");
                        $date2 = date_create($dl_jam_masuk);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat - $jam_terlambat;
                        // $uang_terlambat = $total_terlambat * 10000;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 17;
                        echo 'adaad';
                    }

                    // jam keluar
                    if ($dl_jam_keluar <= '15:00:00') {
                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 18;
                    } else if ($dl_jam_keluar > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($dl_jam_keluar);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur - $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 19;
                    }
                } else if ($shift == 'Shift 2') {
                    if ($dl_jam_masuk <= '15:00:00') {
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 16;
                    } else if ($dl_jam_masuk > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($dl_jam_masuk);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat - $jam_terlambat;
                        // $uang_terlambat = $total_terlambat * 10000;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 17;
                        echo 'adaad';
                    }

                    // jam keluar
                    if ($dl_jam_keluar <= '21:00:00') {
                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                        echo '<br>' . $dl_jam_keluar;
                        // echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 18;
                    } else if ($dl_jam_keluar > '21:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("21:00:00");
                        $date2 = date_create($dl_jam_keluar);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur - $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 19;
                    }
                }
                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];


                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                if ($total_hadir = $hadir - 1 < 0) {
                    $total_hadir = 0;
                } else {
                    $total_hadir = $hadir - 1;
                }

                $total_sakit = $sakit + 1;
                $total_tidak_masuk = $tidak_masuk;

                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_sakit = $total_sakit * 75000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_terlambat = $total_terlambat * 10000;
                $uang_lembur = $total_lembur * ((1 / 173) * $gaji);

                $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_terlambat - $uang_sakit - $uang_tidak_masuk;

                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', sakit='$total_sakit', terlambat='$total_terlambat',  lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit='$uang_sakit', uang_tidak_masuk='$uang_tidak_masuk', uang_lembur='$uang_lembur', uang_terlambat='$uang_terlambat', gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                // echo mysqli_error($conn);
                echo '<br>' . $sql_penghasilan;
            } else if ($dl_keterangan == 'Sakit') {
                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];

                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                $total_hadir = $hadir;
                $total_sakit = $sakit;
                $total_tidak_masuk = $tidak_masuk;

                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_sakit = $total_sakit * 75000;
                $gaji_neto = $gaji + $uang_makan + $uang_transport - $uang_sakit - $uang_tidak_masuk;

                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', sakit='$total_sakit', terlambat='$total_terlambat',  lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit='$uang_sakit', uang_tidak_masuk='$uang_tidak_masuk', uang_lembur='$uang_lembur', uang_terlambat='$uang_terlambat', gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo mysqli_error($conn);
            } else if ($dl_keterangan == 'Tidak Masuk') {
                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];

                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                if ($total_tidak_masuk = $tidak_masuk - 1 < 0) {
                    $total_tidak_masuk = 0;
                } else {
                    $total_tidak_masuk = $hadir - 1;
                }

                $total_hadir = $hadir;
                $total_sakit = $sakit + 1;


                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_sakit = $total_sakit * 75000;
                $gaji_neto = $gaji + $uang_makan + $uang_transport - $uang_sakit - $uang_tidak_masuk;

                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', total_tidak_masuk ='$total_tidak_masuk', sakit='$total_sakit', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit='$uang_sakit', uang_tidak_masuk='$uang_tidak_masuk',gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo mysqli_error($conn);
                echo $sql_penghasilan;
            }
        } else if ($keterangan == 'Tidak Masuk') {
            if ($dl_keterangan ==  'Hadir') {
                // cek jam masuk
                if ($shift == 'Shift 1') {
                    if ($dl_jam_masuk <= '08:00:00') {
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 16;
                    } else if ($dl_jam_masuk > '08:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("08:00:00");
                        $date2 = date_create($dl_jam_masuk);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat - $jam_terlambat;
                        // $uang_terlambat = $total_terlambat * 10000;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 17;
                        echo 'adaad';
                    }

                    // jam keluar
                    if ($dl_jam_keluar <= '15:00:00') {
                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 18;
                    } else if ($dl_jam_keluar > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($dl_jam_keluar);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur - $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 19;
                    }
                } else if ($shift == 'Shift 2') {
                    if ($dl_jam_masuk <= '15:00:00') {
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];
                        $total_terlambat = $terlambat;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 16;
                    } else if ($dl_jam_masuk > '15:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("15:00:00");
                        $date2 = date_create($dl_jam_masuk);
                        $diff = date_diff($date1, $date2);
                        $jam_terlambat = $diff->h;

                        // cek terlambat
                        $cek_terlambat = mysqli_query($conn, "select terlambat as terlambat from penghasilan where id_absen = $id_absen ");
                        $data_terlambat = mysqli_fetch_array($cek_terlambat);
                        $terlambat = $data_terlambat['terlambat'];

                        $total_terlambat = $terlambat - $jam_terlambat;
                        // $uang_terlambat = $total_terlambat * 10000;
                        echo '<br>' . $dl_jam_masuk;
                        echo '<br>' . $jam_terlambat;
                        echo '<br>' . $terlambat;
                        echo '<br>' . $total_terlambat . '<br>';
                        echo 17;
                        echo 'adaad';
                    }

                    // jam keluar
                    if ($dl_jam_keluar <= '21:00:00') {
                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];
                        $total_lembur = $lembur;
                        echo '<br>' . $dl_jam_keluar;
                        // echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 18;
                    } else if ($dl_jam_keluar > '21:00:00') {
                        date_default_timezone_set('Asia/Jakarta');
                        $date1 = date_create("21:00:00");
                        $date2 = date_create($dl_jam_keluar);
                        $diff = date_diff($date1, $date2);
                        $jam_lembur = $diff->h;

                        // cek lembur
                        $cek_lembur = mysqli_query($conn, "select lembur as lembur from penghasilan where id_absen = $id_absen ");
                        $data_lembur = mysqli_fetch_array($cek_lembur);
                        $lembur = $data_lembur['lembur'];

                        $total_lembur = $lembur - $jam_lembur;
                        echo '<br>' . $dl_jam_keluar;
                        echo '<br>' . $jam_lembur;
                        echo '<br>' . $lembur;
                        echo '<br>' . $total_lembur . '<br>';
                        echo 19;
                    }
                }
                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];


                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                if ($total_hadir = $hadir - 1 < 0) {
                    $total_hadir = 0;
                } else {
                    $total_hadir = $hadir - 1;
                }


                $total_sakit = $sakit;
                $total_tidak_masuk = $tidak_masuk + 1;

                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_sakit = $total_sakit * 75000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_terlambat = $total_terlambat * 10000;
                $uang_lembur = $total_lembur * ((1 / 173) * $gaji);

                $gaji_neto = $gaji + $uang_makan + $uang_transport + $uang_lembur - $uang_terlambat - $uang_sakit - $uang_tidak_masuk;

                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', tidak_masuk='$total_tidak_masuk', terlambat = '$total_terlambat',  lembur='$total_lembur', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit='$uang_sakit', uang_tidak_masuk='$uang_tidak_masuk', uang_lembur='$uang_lembur', uang_terlambat='$uang_terlambat', gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo $sql_penghasilan;
            } else if ($dl_keterangan == 'Sakit') {
                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];

                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                if ($total_sakit = $sakit - 1 < 0) {
                    $total_tidak_masuk = 0;
                } else {
                    $total_sakit = $sakit - 1;
                }

                $total_hadir = $hadir;

                $total_tidak_masuk = $tidak_masuk + 1;

                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_sakit = $total_sakit * 75000;
                $gaji_neto = $gaji + $uang_makan + $uang_transport - $uang_sakit - $uang_tidak_masuk;

                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', tidak_masuk='$total_tidak_masuk', sakit='$total_sakit', uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit='$uang_sakit', uang_tidak_masuk='$uang_tidak_masuk', gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo mysqli_error($conn);
                echo $sql_penghasilan;
            } else if ($dl_keterangan == 'Tidak Masuk') {
                // cek data hadir
                $cek_hadir = mysqli_query($conn, "select hadir from penghasilan where id_absen = $id_absen ");
                $data_hadir = mysqli_fetch_array($cek_hadir);
                $hadir = $data_hadir['hadir'];

                // cek sakit
                $cek_sakit = mysqli_query($conn, "select sakit as sakit from penghasilan where id_absen = $id_absen ");
                $data_sakit = mysqli_fetch_array($cek_sakit);
                $sakit = $data_sakit['sakit'];

                //cek tidak hadir
                $cek_tidak_masuk = mysqli_query($conn, "select tidak_masuk as tidak_masuk from penghasilan where id_absen = $id_absen ");
                $data_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
                $tidak_masuk = $data_tidak_masuk['tidak_masuk'];

                $total_hadir = $hadir;
                $total_sakit = $sakit;
                $total_tidak_masuk = $tidak_masuk;

                $uang_makan = $total_hadir * 20000;
                $uang_transport = $total_hadir * 20000;
                $uang_tidak_masuk = $total_tidak_masuk * 100000;
                $uang_sakit = $total_sakit * 75000;
                $gaji_neto = $gaji + $uang_makan + $uang_transport - $uang_sakit - $uang_tidak_masuk;

                $sql_penghasilan = "Update penghasilan SET nik= '$nik',  hadir ='$total_hadir', tidak_masuk='$total_tidak_masuk',  uang_makan='$uang_makan', uang_transport='$uang_transport', uang_sakit='$uang_sakit', uang_tidak_masuk='$uang_tidak_masuk',  gaji_neto='$gaji_neto' WHERE id_absen = '$id_absen' ";
                $query_penghasilan = mysqli_query($conn, $sql_penghasilan);
                echo mysqli_error($conn);
                echo $sql_penghasilan;
            }
        }




        // menginput data ke database
        $sql = "UPDATE absen SET nik='$nik', tanggal='$tanggal', jam_masuk='$jam_masuk', ket_masuk='$ket_masuk', jam_keluar='$jam_keluar', ket_keluar='$ket_keluar', keterangan='$keterangan'  WHERE id_absen='$id_absen'";
        $query = mysqli_query($conn, $sql);
        echo mysqli_error($conn);
        if ($query) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            header('Location: ../views/Admin/absensi/form-absensi.php');
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            header('Location: ../views/Admin/absensi/form-absensi.php');
        }
    } else {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Sudah Ada!";
        header('Location: ../views/Admin/absensi/form-absensi.php');
    }
} else {
    die("gagal menginputkan data");
}

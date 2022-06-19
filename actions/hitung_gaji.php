<?php
include '../config.php';

if (isset($_POST['hitung'])) {
    // $id = $_GET['id'];
    $nik = $_POST['nik'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tanggal = $tahun . '-' . $bulan;
    $tgl_now = date('Y-m-d');
    echo $tgl_now;
    // echo $tanggal;


    // ---------------------------- cek data ---------------------------- //

    $cek_gaji = mysqli_query($conn, "select gaji as gaji from karyawan where nik = $nik");
    $data_gaji = mysqli_fetch_array($cek_gaji);
    $gaji = $data_gaji['gaji'];

    $cek_bpjs = mysqli_query($conn, "select bpjs as bpjs from karyawan where nik = $nik");
    $data_bpjs = mysqli_fetch_array($cek_bpjs);

    // cek status
    $cek_status = mysqli_query($conn, "select status as status from karyawan where nik = $nik");
    $data_status = mysqli_fetch_array($cek_status);
    $status = $data_status['status'];

    $cek_periode = mysqli_query($conn, "select periode as periode from gaji_bulanan where nik = $nik");
    $data_periode = mysqli_fetch_array($cek_periode);
    $periode = $data_periode['periode'];
    // ---------------------------- cek data ---------------------------- //




    if ($periode != $tanggal) {

        // ---------------------------- pendapatan ---------------------------- //
        $cek_makan = mysqli_query($conn, "select sum(uang_makan) as uang_makan from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
        $result_makan = mysqli_fetch_array($cek_makan);
        $uang_makan = $result_makan['uang_makan'];

        $cek_transport = mysqli_query($conn, "select sum(uang_transport) as uang_transport from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
        $result_transport = mysqli_fetch_array($cek_transport);
        $uang_transport = $result_transport['uang_transport'];

        $cek_lembur = mysqli_query($conn, "select sum(uang_lembur) as uang_lembur from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
        $result_lembur = mysqli_fetch_array($cek_lembur);
        $uang_lembur = $result_lembur['uang_lembur'];


        // ---------------------------- pendapatan ---------------------------- //

        // ---------------------------- potongan ---------------------------- //
        $cek_sakit = mysqli_query($conn, "select sum(uang_sakit) as uang_sakit from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
        $result_sakit = mysqli_fetch_array($cek_sakit);
        $uang_sakit = $result_sakit['uang_sakit'];

        $cek_tidak_masuk = mysqli_query($conn, "select sum(uang_tidak_masuk) as uang_tidak_masuk from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
        $result_tidak_masuk = mysqli_fetch_array($cek_tidak_masuk);
        $uang_tidak_masuk = $result_tidak_masuk['uang_tidak_masuk'];

        $cek_terlambat = mysqli_query($conn, "select sum(uang_terlambat) as uang_terlambat from penghasilan where nik = $nik and tanggal like '%$tanggal%'");
        $result_terlambat = mysqli_fetch_array($cek_terlambat);
        $uang_terlambat = $result_terlambat['uang_terlambat'];

        // ---------------------------- potongan ---------------------------- //

        // ---------------------------- cek BPJS ---------------------------- //


        $exp_bpjs = explode(",", $data_bpjs['bpjs']);
        if (in_array(
            "Jaminan Kesehatan",
            $exp_bpjs
        )) {
            $jk = 0.04; //penerimaan
        } else {
            $jk = 0;
        }
        if (in_array("Jaminan Kecelakaan Kerja", $exp_bpjs)) {
            $jkk = 0.0024; //penerimaan
        } else {
            $jkk = 0;
        }
        if (in_array("Jaminan Hari Tua", $exp_bpjs)) {
            $jht = 0.02; //pengurangan
        } else {
            $jht = 0;
        }
        if (in_array("Jaminan Pensiun", $exp_bpjs)) {
            $jp = 0.01; //pengrangan
        } else {
            $jp = 0;
        }
        if (in_array("Jaminan Kematian", $exp_bpjs)) {
            $jkm = 0.003; // penambahan
        } else {
            $jkm = 0;
        }

        // ---------------------------- cek BPJS ---------------------------- //

        // ---------------------------- Penerimaan ---------------------------- //
        $tunjangan = $uang_makan + $uang_transport;
        $bpjs_jkk = $jkk * $gaji;
        $bpjs_jk = $jk * $gaji;
        $bpjs_jkm = $jkm * $gaji;
        $pendapatan = $tunjangan + $uang_lembur + $bpjs_jkk + $bpjs_jk + $bpjs_jkm;
        echo $pendapatan . '=' . $tunjangan . '+' . $uang_lembur . '+' . $bpjs_jkk . '+' . $bpjs_jk . '+' . $bpjs_jkm;
        // ---------------------------- Penerimaan ---------------------------- //

        // ---------------------------- Potongan ---------------------------- //
        $bpjs_jht = $jht * $gaji;
        $bpjs_jp = $jp * $gaji;
        $potongan = $uang_sakit + $uang_tidak_masuk + $uang_terlambat + $bpjs_jht + $bpjs_jp;
        echo '<br>' . $potongan . '=' . $uang_sakit . '+' . $uang_tidak_masuk . '+' . $uang_terlambat . '+' . $bpjs_jht . '+' . $bpjs_jp;
        // ---------------------------- Potongan ---------------------------- //

        // ---------------------------- gaji neto ---------------------------- //
        $bpjs = $bpjs_jk + $bpjs_jkm + $bpjs_jkk - $bpjs_jht - $bpjs_jp;
        $gaji_neto =  $gaji + $pendapatan - $potongan;
        echo '<br> bpjs ' . $bpjs . '=' . $bpjs_jk . '+' . $bpjs_jkm . '+' . $bpjs_jkk . '-' . $bpjs_jht . '-' . $bpjs_jp;

        echo '<br> gaji_neto = ' . $gaji_neto;
        // ---------------------------- gaji neto ---------------------------- //


        // ---------------------------------- hitung pph 21 ---------------------------------- //
        $biaya_jabatan = 5 / 100 * $gaji_neto;
        $neto_perbulan = $gaji_neto - $biaya_jabatan;
        $neto_pertahun = $neto_perbulan * 12;

        if ($status == 'Belum Menikah') {
            $ptkp = 54000000;
        } else if ($status == 'Menikah') {
            $ptkp = 58500000;
        }

        $pkp_pertahun = $neto_pertahun - $ptkp;

        if ($pkp_pertahun > 0 && $pkp_pertahun <= 50000000) {
            $pph_tertuang = 5 / 100 * $pkp_pertahun;
        } else if ($pkp_pertahun > 50000000 && $pkp_pertahun <= 250000000) {
            $pph_tertuang = 15 / 100 * $pkp_pertahun;
        } else if ($pkp_pertahun > 250000000 && $pkp_pertahun <= 500000000) {
            $pph_tertuang = 25 / 100 * $pkp_pertahun;
        } else if ($pkp_pertahun > 500000000 && $pkp_pertahun <= 5000000000) {
            $pph_tertuang = 30 / 100 * $pkp_pertahun;
        } else if ($pkp_pertahun > 5000000000) {
            $pph_tertuang = 35 / 100 * $pkp_pertahun;
        } else if ($pkp_pertahun < 0) {
            $pph_tertuang = 0;
        }

        $pph21 = $pph_tertuang / 12;
        $gaji_bersih = $gaji_neto - $pph21;

        // ---------------------------------- hitung pph 21 ---------------------------------- //
        echo '<br> uang_makan ' . $uang_makan;
        echo '<br> uang_transport ' . $uang_transport;
        echo '<br> uang_lembur ' . $uang_lembur;
        echo '<br> tunjangan ' . $tunjangan;
        echo '<br> pendapatan ' . $pendapatan;
        echo '<br>';

        echo '<br> uang_sakit ' . $uang_sakit;
        echo '<br> uang_tidak_masuk ' . $uang_tidak_masuk;
        echo '<br> uang_terlambat ' . $uang_terlambat;
        echo '<br> potongan ' . $potongan;
        echo '<hr align="left" style="width:200px; ">';
        echo '<br> pendapatan bruto ' . $gaji_neto;

        echo '<br> pph21 ' . $pph21;
        echo '<br> gaji bersih ' . $gaji_bersih;

        // membuat id
        $cek_id = mysqli_query($conn, "select max(id_gaji) as kode from gaji_bulanan");
        $jumlah = mysqli_fetch_array($cek_id);
        $no = $jumlah['kode'];
        $id_gaji = $no + 1;


        // menginput data ke database
        $sql = "INSERT INTO gaji_bulanan (id_gaji, periode, nik, tanggal, gaji_pokok, uang_tunjangan, uang_lembur, uang_potongan, bpjs, pph21, gaji_bersih) VALUE ('$id_gaji', '$tanggal', '$nik', '$tgl_now', '$gaji', '$tunjangan', '$uang_lembur', '$potongan', '$bpjs', '$pph21', '$gaji_bersih')";
        echo '<br> ' . $sql;
        $query = mysqli_query($conn, $sql);
        echo mysqli_error($conn);

        if ($query) {
            // kalau berhasil alihkan ke halaman index.php dengan status=sukses
            $_SESSION['status'] = "sukses";
            $_SESSION['message'] = "<strong>Sukses!</strong> Data Berhasil Disimpan!";
            header('Location: ../views/Admin/penggajian/form-penggajian.php');
        } else {
            // kalau gagal alihkan ke halaman indek.php dengan status=gagal
            $_SESSION['status'] = "gagal";
            $_SESSION['message'] = "<strong>Gagal!</strong> Data Gagal Disimpan!";
            header('Location: ../views/Admin/penggajian/form-penggajian.php');
        }
    } else {
        $_SESSION['status'] = "gagal";
        $_SESSION['message'] = "<strong>Gagal!</strong> Data Sudah Ada!";
        header('Location: ../views/Admin/penggajian/form-penggajian.php');
        // echo mysqli_error($conn);
        // echo $sql;
    }
} else {
    die("gagal menginputkan data");
}

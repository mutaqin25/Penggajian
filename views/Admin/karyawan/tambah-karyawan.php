<?php include '../../../config.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tambah Karyawan</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <!-- <link rel="stylesheet" href="../../../assets/Admin/plugins/fontawesome-free/css/all.min.css"> -->
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../../../assets/Admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="../../../assets/Admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="../../../assets/Admin/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../../../assets/Admin/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../../../assets/Admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../../../assets/Admin/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="../../../assets/Admin/plugins/summernote/summernote-bs4.min.css">
    <!-- Font Awasome -->
    <link href="../../../assets/fontawesome/css/all.css" rel="stylesheet">
    <!-- end font awaseome -->
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php
    // cek apakah yang mengakses halaman ini sudah login
    if ($_SESSION['level'] !== "Admin") {

        header("location:../../../index.php?pesan=gagal");
    }

    ?>
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../../../assets/Admin/dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="../dashboard/dashboard.php" class="nav-link">Home</a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link " href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"></span>
                        <i class="fa-solid fa-user"></i>
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-center shadow animated--grow-in" aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#accountModal">
                            <i class="fa-solid fa-file-lines mr-2 text-gray-400"></i>
                            My Account
                        </a>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="../../../assets/Admin/dist/img/user.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"> <?php echo $_SESSION['nama']; ?></a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="../dashboard/dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>
                                    Dashboard
                                    <!-- <i class="right fas fa-angle-left"></i> -->
                                </p>
                            </a>
                        </li>
                        <li class="nav-item menu-open">
                            <a href="#" class="nav-link ">
                                <i class="nav-icon fas fa-edit"></i>
                                <p>
                                    Data Master
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="form-karyawan.php" class="nav-link active">
                                        <i class="nav-icon fa-solid fa-user-tie"></i>
                                        <p>Karyawan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../absensi/form-absensi.php" class="nav-link">
                                        <i class="nav-icon fa-solid fa-pen-to-square"></i>
                                        <p>Absensi</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="../penggajian/form-penggajian.php" class="nav-link">
                                        <i class="nav-icon fa-solid fa-file-invoice-dollar"></i>
                                        <p>Penggajian</p>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a href="../user/form-user.php" class="nav-link">
                                        <i class="nav-icon fa-solid fa-users"></i>
                                        <p>
                                            Users
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="../laporan/form_laporan.php" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-lines"></i>
                                <p>
                                    Data Laporan
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="color: gray;">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Input Karyawan</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../dashboard/dashboard.php">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Input Data</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form action="../../../actions/tambah-karyawan.php" method="POST" enctype="multipart/form-data">
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Nik</label>
                                        <div class="col-sm-5">
                                            <input type="number" name="nik" required class="form-control" placeholder="Nik">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Nama</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="nama" required class="form-control" placeholder="Nama">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label pt-0">Jenis Kelamin</label>
                                        <div class="col-sm-10">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="gridRadios1" value="Laki-Laki" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Laki-Laki
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="jenis_kelamin" id="gridRadios1" value="Perempuan">
                                                <label class="form-check-label" for="gridRadios1">
                                                    Perempuan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Tanggal Lahir</label>
                                        <div class="col-sm-5">
                                            <input type="date" name="tgl_lahir" required class="form-control" placeholder="Tanggal Lahir">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Alamat</label>
                                        <div class="col-sm-5">
                                            <textarea type="text" name="alamat" required class="form-control" placeholder="Alamat">
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Status</label>
                                        <div class="col-sm-5">
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="status">
                                                <option selected>Choose...</option>
                                                <option value="Menikah">Menikah</option>
                                                <option value="Belum Menikah">Belum Menikah</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Agama</label>
                                        <div class="col-sm-5">
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="agama">
                                                <option selected>Choose...</option>
                                                <option value="Islam">Islam</option>
                                                <option value="Protestan">Protestan</option>
                                                <option value="Katolik">Katolik</option>
                                                <option value="Hindu">Hindu</option>
                                                <option value="Buddha">Buddha</option>
                                                <option value="Khonghucu">Khonghucu</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">No Handphone</label>
                                        <div class="col-sm-5">
                                            <input type="number" name="no_hp" required class="form-control" placeholder="08XXXXXXXXXX">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Jabatan</label>
                                        <div class="col-sm-5">
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="jabatan">
                                                <option selected>Choose...</option>
                                                <option value="Supervisor">Supervisor</option>
                                                <option value="Kepala Koki">Kepala Koki</option>
                                                <option value="Staff Dapur">Staf Dapur</option>
                                                <option value="Leader Bar">Leader Bar</option>
                                                <option value="Staff Bar">Staff Bar</option>
                                                <option value="Leader Pelayan">Leader Pelayan</option>
                                                <option value="Staff Pelayan">Staff Pelayan</option>
                                                <option value="Kasir">Kasir</option>
                                                <option value="Leader Gudang">Leader Gudang</option>
                                                <option value="Staff Gudang">Staff Gudang</option>
                                                <option value="Leader Marketing & Design">Leader Marketing & Design</option>
                                                <option value="Staff Marketing & Design">Staff Marketing & Design</option>
                                            </select>
                                            
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Shift</label>
                                        <div class="col-sm-5">
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="shift">
                                                <option selected>Choose...</option>
                                                <option value="Shift 1">Shift 1</option>
                                                <option value="Shift 2">Shift 2</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Gaji</label>
                                        <div class="col-sm-5">
                                            <input type="text" name="gaji" required class="form-control" placeholder="Gaji">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label pt-0">BPJS</label>
                                        <div class="col-sm-10">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="ket_bpjs" id="yesCheck" onclick="javascript:yesnoCheck();" value="Memiliki">
                                                <label class="form-check-label" for="gridRadios1">
                                                    Memiliki
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" onclick="javascript:yesnoCheck();" name="ket_bpjs" id="noCheck" value="Tidak Memiliki" checked>
                                                <label class="form-check-label" for="gridRadios1">
                                                    Tidak Memiliki
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label pt-0"></label>
                                        <div class="col-sm-10" id="ifYes" style="display:none ;">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="Jaminan Kecelakaan Kerja" name="bpjs[]" id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Jaminan Kecelakaan Kerja
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="Jaminan Kematian" name="bpjs[]" id="flexCheckChecked">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Jaminan Kematian
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="Jaminan Hari Tua" name="bpjs[]" id="flexCheckChecked">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Jaminan Hari Tua
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="Jaminan Pensiun" name="bpjs[]" id="flexCheckChecked">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Jaminan Pensiun
                                                </label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox" value="Jaminan Kesehatan" name="bpjs[]" id="flexCheckChecked">
                                                <label class="form-check-label" for="flexCheckChecked">
                                                    Jaminan Kesehatan
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Tanggal Masuk</label>
                                        <div class="col-sm-5">
                                            <input type="date" name="tgl_masuk" required class="form-control" placeholder="Tanggal Masuk">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Pendidikan</label>
                                        <div class="col-sm-5">
                                            <select class="custom-select mr-sm-2" id="inlineFormCustomSelect" name="pendidikan">
                                                <option selected>Choose...</option>
                                                <option value="Sekolah Dasar">Sekolah Dasar</option>
                                                <option value="Sekolah Menengah Pertama">Sekolah Menengah Pertama</option>
                                                <option value="Sekolah Menengah Atas">Sekolah Menengah Atas</option>
                                                <option value="Kejuruan">Kejuruan</option>
                                                <option value="Diploma">Diploma</option>
                                                <option value="Sarjana">Sarjana</option>
                                                <option value="Pasca Sarjana">Pasca Sarjana</option>
                                                <option value="Lainnya">Lainnya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label">Foto</label>
                                        <div class="col-sm-5">
                                            <input type="file" name="foto" required class="form-control-file" placeholder="Foto">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <button type="submit" value="simpan" name="simpan" class="btn btn-primary" style="width: 24%;">Simpan</button>
                                            <a class="btn btn-success" href="form-karyawan.php" role="button" style="width: 24%;">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </form>
                        </div>

                    </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2022 Sistem Informasi Penggajian</strong>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- My Account Modal -->
    <div class="modal fade" id="accountModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Hello <?php echo $_SESSION['nama'] ?></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <!-- main modal -->
                <div class="modal-body">
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Profil</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form>
                                <?php
                                $id = $_SESSION['nik'];
                                $data = mysqli_query($conn, "select * from user where nik='$id'");
                                while ($d = mysqli_fetch_array($data)) {
                                ?>
                                    <div class="card-body">
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label">Nama</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $d['nama'] ?>" class="form-control" disabled placeholder=" Nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label">Jenis Kelamin</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $d['jenis_kelamin'] ?>" class="form-control" disabled placeholder=" Nama">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label">Username</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $d['username'] ?>" class="form-control" disabled placeholder=" Email">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label">Password</label>
                                            <div class="col-md-8">
                                                <input type="text" value="<?php echo $d['password'] ?>" class="form-control" disabled placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="" class="col-sm-4 col-form-label">Level</label>
                                            <div class="col-md-8">
                                                <input type="text" disabled value="<?php echo $d['level'] ?>" required class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->
                                <?php
                                }
                                ?>
                            </form>
                        </div>
                    </div>
                    <!-- end main modal -->
                    <div class="modal-footer">
                        <button class="btn btn-danger" type="button" data-dismiss="modal">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">??</span>
                    </button>
                </div>
                <div class="modal-body">
                    Select "Logout" below if you are ready to end your current session.
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">
                        Cancel
                    </button>
                    <a class="btn btn-primary" href="../../../actions/log_out.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip()
        });

        function yesnoCheck() {
            if (document.getElementById('yesCheck').checked) {
                document.getElementById('ifYes').style.display = 'block';
            } else document.getElementById('ifYes').style.display = 'none';
        }
    </script>



    <!-- alert fade Out-->
    <?php

    if (isset($_SESSION['status']) == "sukses") {
    ?>
        <script>
            document.getElementById('message-success').innerHTML = "<?= $_SESSION['message']; ?>";
            window.setTimeout(function() {
                $("#alert-success").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 3000);
        </script>
    <?php
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    } elseif (isset($_SESSION['status']) == "gagal") {
    ?>
        <script>
            document.getElementById('message-warning').innerHTML = "<?= $_SESSION['message']; ?>";
            window.setTimeout(function() {
                $("#alert-warning").fadeTo(500, 0).slideUp(500, function() {
                    $(this).remove();
                });
            }, 3000);
        </script>
    <?php
        unset($_SESSION['status']);
        unset($_SESSION['message']);
    }
    ?>

    <!-- jQuery -->
    <script src="../../../assets/Admin/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="../../../assets/Admin/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="../../../assets/Admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="../../../assets/Admin/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="../../../assets/Admin/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="../../../assets/Admin/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="../../../assets/Admin/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="../../../assets/Admin/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="../../../assets/Admin/plugins/moment/moment.min.js"></script>
    <script src="../../../assets/Admin/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="../../../assets/Admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="../../../assets/Admin/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="../../../assets/Admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../../assets/Admin/dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../../assets/Admin/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="../../../assets/Admin/dist/js/pages/dashboard.js"></script>
</body>

</html>
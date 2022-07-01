<?php include '../../../config.php' ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard</title>

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
          <a href="dashboard.php" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
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
            <a href="#" class="d-block">
              <p><?php echo $_SESSION['nama']; ?></p>
            </a>
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
            <li class="nav-item menu-open">
              <a href="dashboard.php" class="nav-link active">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                  <!-- <i class="right fas fa-angle-left"></i> -->
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                  Data Master
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <a href="../karyawan/form-karyawan.php" class="nav-link">
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
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0">Dashboard</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
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
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $cek_jumlah = mysqli_query($conn, "select count(nik) as nik from karyawan");
                  $result = mysqli_fetch_array($cek_jumlah);
                  $total = $result['nik'];
                  ?>
                  <h3><?php echo $total ?></h3>

                  <p>Data Karyawan</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-users"></i>
                </div>
                <a href="../karyawan/form-karyawan.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-success">
                <div class="inner">
                  <?php
                  $cek_jumlah = mysqli_query($conn, "select count(id_absen) as id_absen from absen");
                  $result = mysqli_fetch_array($cek_jumlah);
                  $total = $result['id_absen'];
                  ?>
                  <h3><?php echo $total ?></sup></h3>

                  <p>Data Absen</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-calendar-check"></i>
                </div>
                <a href="../absensi/form-absensi.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-warning">
                <div class="inner">
                  <?php
                  $cek_jumlah = mysqli_query($conn, "select count(id_gaji) as total from gaji_bulanan");
                  $result = mysqli_fetch_array($cek_jumlah);
                  $total = $result['total'];
                  ?>
                  <h3><?php echo $total ?></h3>

                  <p>Data Gaji</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <a href="../laporan/form_laporan.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-danger">
                <div class="inner">
                  <?php
                  $cek_jumlah = mysqli_query($conn, "select count(nik) as total from user");
                  $result = mysqli_fetch_array($cek_jumlah);
                  $total = $result['total'];
                  ?>
                  <h3><?php echo $total ?></h3>

                  <p>Data User</p>
                </div>
                <div class="icon">
                  <i class="fa-solid fa-users"></i>
                </div>
                <a href="../user/form-user.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>


            <!-- ./col -->
            <div class="col-lg-12 col-6" style="align-items:center ;">
              <!-- small box -->
              <div class="small-box " style="align-content:center ;">
                <div class="inner" style="text-align:center ;">
                  <img style="width:60% ;" src="../../../assets/images/logo/dinobites.png">
                </div>
              </div>
            </div>

            <!-- ./col -->
          </div>
          <!-- /.row (main row) -->
        </div><!-- /.container-fluid -->
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
            <span aria-hidden="true">×</span>
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
            <span aria-hidden="true">×</span>
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
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Colorlib Templates">
    <meta name="author" content="Colorlib">
    <meta name="keywords" content="Colorlib Templates">

    <!-- Title Page-->
    <title>Sign-up</title>

    <!-- Icons font CSS-->
    <link href="../../assets/Sign-up/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">
    <link href="../../assets/Sign-up/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <!-- Font special for pages-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- ../../assets/Sign-up/vendor CSS-->
    <link href="../../assets/Sign-up/vendor/select2/select2.min.css" rel="stylesheet" media="all">
    <link href="../../assets/Sign-up/vendor/datepicker/daterangepicker.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../../assets/Sign-up/css/main.css" rel="stylesheet" media="all">
</head>

<body>
    <div class="page-wrapper bg-gra-02 p-t-130 p-b-100 font-poppins">
        <div class="wrapper wrapper--w680">
            <div class="card card-4" style="box-shadow: 2px 2px 2px 2px ;">
                <div class="card-body">
                    <h2 class="title">Registration Form</h2>
                    <form method="POST" action="../../actions/register.php">
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Nama Depan</label>
                                    <input class="input--style-4" type="text" name="nama_depan">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Nama Belakang</label>
                                    <input class="input--style-4" type="text" name="nama_belakang">
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Birthday</label>
                                    <div class="input-group-icon">
                                        <input class="input--style-4 js-datepicker" type="text" name="birthday">
                                        <i class="zmdi zmdi-calendar-note input-icon js-btn-calendar"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Gender</label>
                                    <div class="p-t-10">
                                        <label class="radio-container m-r-45">Male
                                            <input type="radio" checked="checked" name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                        <label class="radio-container">Female
                                            <input type="radio" name="gender">
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row row-space">
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Email</label>
                                    <input class="input--style-4" type="email" name="email">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="input-group">
                                    <label class="label">Password</label>
                                    <input class="input--style-4" type="password" name="password">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="input-group">
                            <label class="label">Subject</label>
                            <div class="rs-select2 js-select-simple select--no-search">
                                <select name="subject">
                                    <option disabled="disabled" selected="selected">Choose option</option>
                                    <option>Subject 1</option>
                                    <option>Subject 2</option>
                                    <option>Subject 3</option>
                                </select>
                                <div class="select-dropdown"></div>
                            </div>
                        </div> -->
                        <div class="p-t-15">
                            <button class="btn btn--radius-2 btn--blue" name="simpan" type="submit">Submit</button>
                            <a href="sign-in.php" class="btn btn--radius-2 btn--green" role=" button">Back</a>

                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery JS-->
    <script src="../../assets/Sign-up/vendor/jquery/jquery.min.js"></script>
    <!-- ../../assets/Sign-up/vendor JS-->
    <script src="../../assets/Sign-up/vendor/select2/select2.min.js"></script>
    <script src="../../assets/Sign-up/vendor/datepicker/moment.min.js"></script>
    <script src="../../assets/Sign-up/vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="../../assets/Sign-up/js/global.js"></script>
    <!-- sweetalert -->
    <script src="../../assets/Registration/js/sweetalert.min.js"></script>


    <?php
    if (isset($_GET['pesan'])) {
        if ($_GET['pesan'] == "sukses") {
    ?>
            <script>
                swal({
                    title: "Succes!",
                    text: "Data Berhasil Di Simpan !",
                    icon: "warning",
                    button: false,
                    timer: 3000,
                }).then(function() {
                    window.location = "sign-in.php";
                });
            </script>
        <?php
            // echo "<div class='alert'>Username dan Password tidak sesuai !</div>";
        } else {
        ?>
            <script>
                swal({
                    title: "Failed!",
                    text: "Data Gagal Di Simpan !",
                    icon: "warning",
                    button: false,
                    timer: 3000,
                }).then(function() {
                    window.location = "sign-up.php";
                });
            </script>
    <?php
        }
    }
    ?>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
<!-- end document-->
<?php
include '../config.php';
?>
<!doctype html>
<html lang="en">



<head>
	<title>Scan Qr Code</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.min.css'>
	<link rel="stylesheet" href="css/style.css">

</head>

<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">Scan QR Code</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12 col-lg-10" style="box-shadow: 2px 2px 2px 2px ;">
					<div class="wrap d-md-flex">
						<div class="img" id="reader" style="width: 500px; height: 690px; background-color:darkcyan; ">
						</div>
						<div class="login-wrap p-4 p-md-5" style="width: 500px;background-color: darkorange; color: white; " id="hasil_scanner">
							<div class="d-flex">
								<div class="w-100">
									<h4 class="mb-4 text-center">Hasil Scanner</h4>
								</div>
							</div>
							<div class="text-center">
								<div id="profil">

								</div>
							</div>
							<div class="form-group mb-3">
								<label class="label" for="name">Nik</label>
								<div id="result">
									<input type="text" name="nik" class="form-control" value="" placeholder="Nik" readonly required>
								</div>
							</div>
							<div class="form-group mb-3">
								<label class="label" for="password">Nama</label>
								<div id="nama">
									<input type="text" class="form-control" readonly placeholder="Nama" value="" required>
								</div>
							</div>
							<div class="form-group mb-3">
								<label class="label" for="password">Tanggal</label>
								<div id="date">
									<input type="date" class="form-control" readonly placeholder="Jam" required>
								</div>
							</div>
							<div class="form-group mb-3">
								<label class="label" for="password">Jam</label>
								<div id="jam">
									<input type="time" class="form-control" readonly placeholder="Jam" required>
								</div>
							</div>
							<!-- <div class="form-group">
									<button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
								</div>

							<p class="text-center">Not a member? <a data-toggle="tab" href="#signup">Sign Up</a></p>/ -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
	<script src="js/qrcode.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@7.12.15/dist/sweetalert2.all.min.js"></script>


	<script type="text/javascript">

		var audio = new Audio('sound/definite-555.mp3');

		function onScanSuccess(qrCodeMessage) {

			const nik = qrCodeMessage;

			arrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
			date = new Date();
			detik = date.getSeconds();
			menit = date.getMinutes();
			jam = date.getHours();
			tanggal = date.getDate();
			hari = date.getDay();
			bulan = date.getMonth();
			tahun = date.getFullYear();

			tanggal_sekarang = tanggal + " - " + arrbulan[bulan] + " - " + tahun;
			jam_sekarang = jam + ":" + menit + ":" + detik;

			$.ajax({
				url: '../actions/tampil_data.php',
				type: 'POST',
				data: 'nik=' + nik,
				// dataType: JSON,
				success: function(response) {
					response = JSON.parse(response);
					document.getElementById("nama").innerHTML = response[0].nama;
					document.getElementById("profil").innerHTML =
						'<span> <img src="../assets/images/profil/' + response[0].foto + ' " class="img-fluid profile-image-pic img-thumbnail rounded-circle my-3" width="100px" alt="profile"> </span>';
					// swal("Succes", "Berhasil Absen!", "success");
					swal({
						title: "Succes!",
						text: "Anda Berhasil Absen.",
						type: "success",
						timer: 3000
					});
					audio.play();

					$.ajax({
						url: '../actions/simpan_absensi.php',
						type: 'POST',
						data: 'nik=' + nik,
					})
					// html5QrcodeScanner.clear();


				},
				error: function(jqXHR, exception) {
					var msg = '';
					if (jqXHR.status === 0) {
						msg = 'Not connect.\n Verify Network.';
					} else if (jqXHR.status == 404) {
						msg = 'Requested page not found. [404]';
					} else if (jqXHR.status == 500) {
						msg = 'Internal Server Error [500].';
					} else if (exception === 'parsererror') {
						msg = 'Requested JSON parse failed.';
					} else if (exception === 'timeout') {
						msg = 'Time out error.';
					} else if (exception === 'abort') {
						msg = 'Ajax request aborted.';
					} else {
						msg = 'Uncaught Error.\n' + jqXHR.responseText;
					}
					$('#post').html(msg);
				}
			});




			// // '<span class="result">' + qrCodeMessage + "</span>";
			document.getElementById("result").innerHTML = nik;
			// document.getElementById("nama").innerHTML = Mutaqin;
			// // document.getElementById("nama").innerHTML = $data['nama'];
			document.getElementById("date").innerHTML = tanggal_sekarang;
			// // '<span class="result">' + tanggal + " - " + arrbulan[bulan] + " - " + tahun + "</span>";
			document.getElementById("jam").innerHTML = jam_sekarang;
			// // '<span class="result">' + jam + " : " + menit + " : " + detik + "</span>";



		}

		function onScanError(errorMessage) {
			//handle scan error
		}
		var html5QrcodeScanner = new Html5QrcodeScanner("reader", {
			fps: 10,
			qrbox: 250,
		});
		html5QrcodeScanner.render(onScanSuccess, onScanError);
	</script>

</body>

</html>
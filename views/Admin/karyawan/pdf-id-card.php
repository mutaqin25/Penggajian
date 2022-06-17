<?php
include '../../../config.php';
require_once __DIR__ . '/../../../assets/vendor/autoload.php';

$nik = $_GET['nik'];
$data = mysqli_query($conn, "select * from karyawan where nik=$nik");

$mpdf = new \Mpdf\Mpdf();
$mpdf = new \Mpdf\Mpdf(['mode' => 'utf-8', 'format' => [100, 150]]);
$stylesheet = file_get_contents('id_card.css');
$mpdf->WriteHTML($stylesheet, \Mpdf\HTMLParserMode::HEADER_CSS);

$html = '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
<div class="id-card-holder">
		<div class="id-card">
			<div class="header">
				<h1>ID CARD</h1>
			</div>
			<div class="photo">';
// for ($i = 0; $i <= 3; $i++) {
foreach ($data as $row) {
	$html .= '<img style="width: 100px" src="../../../assets/images/profil/' . $row["foto"] . '">
	</div>
			<h2>' . $row["nama"] . '</h2>
			<h3>' . $row["jabatan"] . '</h3>
			<div class="qr-code">
				<img style="width:100px" src="../../../assets/images/QRCode/' . $row["qrcode"] . '">
			</div>
			<hr>';
}
// }

$html .= '<p>Alamat: Gg. Macan No.102C, RT.3/RW.13, Duri Kepa, Kec. Kb. Jeruk, Kota Jakarta Barat, Daerah Khusus Ibukota Jakarta 11520

		</div>
	</div>
</body>
</html>';
$mpdf->WriteHTML($html);
$mpdf->Output('Laporan Gaji.pdf', \Mpdf\Output\Destination::INLINE);

<?php
include('includes/config.php');
include('includes/format_rupiah.php');
include('includes/library.php');
$awal = $_GET['awal'];
$akhir = $_GET['akhir'];
// $stt = $_GET['status'];
$sqlsewa = "SELECT booking.*,mobil.*,merek.*,users.* FROM booking,mobil,merek,users WHERE booking.id_mobil=mobil.id_mobil
			AND merek.id_merek=mobil.id_merek AND users.email=booking.email AND booking.status!='cancel' AND booking.status!='menunggu pembayaran' AND booking.status!='menunggu konfirmasi' 
			AND booking.tgl_booking BETWEEN '$awal' AND '$akhir'";
$querysewa = mysqli_query($koneksidb, $sqlsewa);

?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="rental mobil">
	<meta name="author" content="universitas pamulang">

	<title>Cetak Laporan Pemasukan</title>

	<!-- Bootstrap Core CSS -->
	<link href="../assets/new/bootstrap.min.css" rel="stylesheet">

	<!-- Custom CSS -->
	<link href="../assets/new/offline-font.css" rel="stylesheet">
	<link href="../assets/new/custom-report.css" rel="stylesheet">

	<!-- Custom Fonts -->
	<link href="../assets/new/font-awesome.min.css" rel="stylesheet" type="text/css">

	<!-- jQuery -->
	<script src="../assets/new/jquery.min.js"></script>

	<link rel="shortcut icon" href="../assets/images/brand_icons.png">


</head>

<body>
	<section id="header-kop">
		<div class="container-fluid">
			<table class="table table-borderless">
				<tbody>
					<tr>
						<td rowspan="3" width="16%" class="text-center">
							<img src="../assets/images/brand_icons.png" alt="logo" width="80" />
						</td>
						<td class="text-center">
							<h1>DAKOTA Rental Mobil</h1>
						</td>
						<td rowspan="3" width="16%">&nbsp;</td>
					</tr>
					<tr>
						<td class="text-center">Jl. Dakota No.8A, Kelurahan Sukaraja, Kecamatan Cicendo, Kota Bandung,
							Jawa Barat, Indonesia</td>
					</tr>
				</tbody>
			</table>
			<hr class="line-top" />
		</div>
	</section>

	<section id="body-of-report">
		<div class="container-fluid">
			<h2 class="text-center">Pemasukan Sewa</h2>
			<h5 class="text-center">Tanggal
				<?php echo IndonesiaTgl($awal) . " s/d " . IndonesiaTgl($akhir); ?>
			</h5>
			<br />
			<table id="zctb" class="display table table-striped table-bordered table-hover" cellspacing="0"
				width="100%">
				<thead>
					<tr>
						<th>No</th>
						<th>Kode Sewa</th>
						<th>Tanggal Sewa</th>
						<th>Status Penyewaan</th>
						<th>Total Bayar</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$no = 0;
					$pemasukan = 0;
					while ($result = mysqli_fetch_array($querysewa)) {
						$biayamobil = $result['durasi'] * $result['harga'];
						$total = $result['driver'] + $biayamobil;
						$pemasukan += $total;
						$no++;
						?>
						<tr>
							<td>
								<?php echo $no; ?>
							</td>
							<td>
								<?php echo htmlentities($result['kode_booking']); ?>
							</td>
							<td>
								<?php echo IndonesiaTgl(htmlentities($result['tgl_booking'])); ?>
							</td>
							<td>
								<?php
								if ($result['status'] == "Sudah Dibayar") {
									$result['status'] = "Belum Selesai";
								}
								echo htmlentities($result['status']);
								?>
							</td>
							<td>
								<?php echo format_rupiah($total); ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
				<tfoot>
					<?php
					echo '<tr>';
					echo '<th colspan="4" class="text-center">Total Pemasukan</th>';
					echo '<th class="text-center">' . format_rupiah($pemasukan) . '</th>';
					echo '</tr>';
					?>
				</tfoot>
			</table>


		</div><!-- /.container -->
	</section>

	<script type="text/javascript">
		$(document).ready(function () {
			$('#jumlah').terbilang({
				'style': 3,
				'output_div': "jumlah2",
				'akhiran': "Rupiah",
			});

			window.print();
		});
	</script>

	<!-- Bootstrap Core JavaScript -->
	<script src="../assets/new/bootstrap.min.js"></script>
	<!-- jTebilang JavaScript -->
	<script src="../assets/new/jTerbilang.js"></script>

</body>

</html>
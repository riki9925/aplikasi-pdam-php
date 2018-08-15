<?php
include "../config.php";
session_start();

if(isset($_POST['tambah']))
{	

	$sql=$conn->query("select id_bayar from pembayaran order by id_bayar desc limit 1");
	$row=$sql->num_rows;
	$a=$sql->fetch_assoc();

    if ( $row == 0 ){
		$byr = 1;
	}else{
		$byr = (($a['id_bayar']) + 1);
	}

	$pelanggan 	= $_POST['tambah'];
	$volume		= $_POST['volume'];
	$beban		= $_POST['beban'];
	$jumlah		= $_POST['jumlah'];
	$total		= $_POST['total'];
	$pegawai	= $_SESSION['id'];

	$sql1=	$conn->query("INSERT INTO 
		pembayaran 	(id_bayar,id_pel, 		tanggal, 	volume, 	beban, jumlah, 		total, 	  id_peg)
			VALUES 	('$byr','$pelanggan', 	NOW(),'		$volume',	'$beban', '$jumlah',	'$total','$pegawai')");

	$id = explode(",", $_POST['meter']);
	// echo $id;
	foreach ($id as $m) {
		$sql3=$conn->query("INSERT INTO 
		detail_pembayaran 	(id_bayar, id_meter, tanggal)
					VALUES 	('$byr', '$m', 	NOW())");
		$sql4=$conn->query("UPDATE meter SET st='1' WHERE id_meter='$m'");
	}


		if($sql1){
			echo json_encode(array("status"=>true,"kode"=>$byr));
		}else{
			echo json_encode(array("status"=>false));
		}
}

elseif(isset($_POST['lihat']))
{	
	$id = $_POST['lihat'];
	$sql=$conn->query("
						select p.*, g.golongan, g.harga beban
						from pelanggan p
						left join golongan g on p.gol = g.id_gol 
						where p.id_pel='$id'");
		if($sql){
			$r=$sql->fetch_assoc();
			echo json_encode($r);
		}else{
			echo "Gagal";
		}
}
elseif(isset($_POST['total']))
{	
	$id 	= explode(",", $_POST['total']);
	$volume = 0;
	$pertama = 0;
	$kedua = 0;
	$ketiga = 0;
	$keempat = 0;
	$kelima = 0;
	$keenam = 0;
	$total 	= 0;

	$beban 	= 0;

	foreach ($id as $r) {
		$sql = $conn->query("
			SELECT
			meter.id_meter id,
			date_format(meter.tanggal,'%M') bulan,
			meter.jumlah volume,
			if(meter.jumlah > 10,(golongan.pertama * 10),(golongan.pertama * (meter.jumlah))) PERTAMA,
			if(meter.jumlah > 20,(golongan.kedua * 10),(golongan.kedua * (meter.jumlah - 10))) KEDUA,
			if(meter.jumlah > 30,(golongan.ketiga * 10),(golongan.ketiga * (meter.jumlah - 20))) KETIGA,
			if(meter.jumlah > 40,(golongan.keempat * 10),(golongan.keempat * (meter.jumlah - 30))) KEEMPAT,
			if(meter.jumlah > 50,(golongan.kelima * 10),(golongan.kelima * (meter.jumlah - 40))) KELIMA,
			if(meter.jumlah >= 51,(golongan.keenam * (meter.jumlah - 50)),0) KEENAM,
			(
			if(meter.jumlah > 10,(golongan.pertama * 10),(golongan.pertama * (meter.jumlah))) +
			if(meter.jumlah > 20,(golongan.kedua * 10),(golongan.kedua * (meter.jumlah - 10))) +
			if(meter.jumlah > 30,(golongan.ketiga * 10),(golongan.ketiga * (meter.jumlah - 20))) +
			if(meter.jumlah > 40,(golongan.keempat * 10),(golongan.keempat * (meter.jumlah - 30))) +
			if(meter.jumlah > 50,(golongan.kelima * 10),(golongan.kelima * (meter.jumlah - 40))) +
			if(meter.jumlah >= 51,(golongan.keenam * (meter.jumlah - 50)),0)
			) total,
			golongan.harga beban
			FROM meter
			LEFT JOIN pelanggan ON pelanggan.id_pel = meter.id_pel
			LEFT JOIN golongan ON golongan.id_gol = pelanggan.gol

            where meter.id_meter = '$r'");
		$p=$sql->fetch_assoc();

		$volume += $p['volume'];
		$pertama += $p['PERTAMA'];
		$kedua += $p['KEDUA'];
		$ketiga += $p['KETIGA'];
		$keempat += $p['KEEMPAT'];
		$kelima += $p['KELIMA'];
		$keenam += $p['KEENAM'];
		$total += $p['total'];

		$beban += $p['beban'];
	}
	$data['volume'] = $volume;
	$data['pertama'] = $pertama;
	$data['kedua'] = $kedua;
	$data['ketiga'] = $ketiga;
	$data['keempat'] = $keempat;
	$data['kelima'] = $kelima;
	$data['keenam'] = $keenam;
	$data['total'] = $total;

	$data['beban'] = $beban;
	$data['no'] = count($id);

	echo json_encode($data);
}
?>
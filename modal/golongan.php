<?php
include "../config.php";
if(isset($_POST['hapus'])) {
	$id	= $_POST['hapus'];
	$sql=$conn->query("DELETE FROM golongan WHERE id_gol = '$id'");
	if($sql){
		echo "ok";
	}else{
		echo "Gagal";
	}
} 
elseif(isset($_POST['tambah']))
{	
	$kd_gol 	= $_POST['tambah'];
	$golongan	= $_POST['nama'];
	$pertama	= $_POST['pertama'];
	$kedua		= $_POST['kedua'];
	$ketiga		= $_POST['ketiga'];
	$keempat	= $_POST['keempat'];
	$kelima		= $_POST['kelima'];
	$keenam		= $_POST['keenam'];
	$harga		= $_POST['harga'];
	$denda		= $_POST['denda'];

	$sql=$conn->query("INSERT INTO golongan 
						(kd_gol,golongan,pertama,kedua,ketiga,keempat,kelima,keenam,harga,denda) VALUES
					('$kd_gol','$golongan','$pertama','$kedua','$ketiga','$keempat','$kelima','$keenam','$harga','$denda')");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
elseif(isset($_POST['lihat']))
{	
	$id = $_POST['lihat'];

	$sql=$conn->query("select * from golongan where id_gol='$id'");
		if($sql){
			$r=$sql->fetch_assoc();
			echo json_encode($r);
		}else{
			echo "Gagal";
		}
}
elseif(isset($_POST['ubah']))
{	
	$id 		= $_POST['ubah'];
	$kd_gol 	= $_POST['kd_gol'];
	$golongan 	= $_POST['nama'];
	$pertama	= $_POST['pertama'];
	$kedua		= $_POST['kedua'];
	$ketiga		= $_POST['ketiga'];
	$keempat	= $_POST['keempat'];
	$kelima		= $_POST['kelima'];
	$keenam		= $_POST['keenam'];
	$harga 		= $_POST['harga'];
	$denda 		= $_POST['denda'];

	$sql=$conn->query("UPDATE golongan SET kd_gol='$kd_gol', golongan='$golongan', pertama='$pertama', kedua='$kedua', ketiga='$ketiga', keempat='$keempat', kelima='$kelima', keenam='$keenam', harga='$harga', denda='$denda' WHERE id_gol='$id'");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
?>
<?php
include "../config.php";
session_start();
if(isset($_POST['hapus'])) {
	$id	= $_POST['hapus'];
	$sql=$conn->query("DELETE FROM meter WHERE id_meter = '$id'");
	if($sql){
		echo "ok";
	}else{
		echo "Gagal";
	}
} 

elseif(isset($_POST['tambah']))
{	
	$pegawai 	= $_POST['tambah'];
	$pelanggan	= $_POST['pelanggan'];
	$lalu		= $_POST['lalu'];
	$sekarang	= $_POST['sekarang'];
	$jumlah		= $_POST['jumlah'];
	$admin		= $_SESSION['id'];

	$sql=$conn->query("INSERT INTO meter (id_peg, id_pel, lalu, sekarang, jumlah, st, tanggal, entry_user)
						VALUES ('$pegawai','$pelanggan','$lalu','$sekarang','$jumlah', '0', CURDATE(), '$admin' )");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal".mysql_error();
		}
}

elseif(isset($_POST['lihat']))
{	
	$id = $_POST['lihat'];

	$sql=$conn->query("
						select m.* , pg.nama pegawai, pl.nama pelanggan
						from meter m
						left join pegawai pg on m.id_peg=pg.id_peg
						left join pelanggan pl on m.id_pel=pl.id_pel
						where m.id_meter='$id'");
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
	$sekarang 	= $_POST['sekarang'];
	$jumlah 	= $_POST['jumlah'];

	$sql=$conn->query("UPDATE meter SET sekarang='$sekarang', jumlah='$jumlah', last_update = NOW() WHERE id_meter='$id'");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}

elseif(isset($_POST['lalu']))
{	
	$id = $_POST['lalu'];

	$sql=$conn->query("select sekarang from meter WHERE id_pel='$id' ORDER BY id_meter DESC");
		if($sql){
			$r=$sql->fetch_assoc();
			echo json_encode($r);
		}else{
			echo json_encode(false);
		}
}
?>
<?php
include "../config.php";
session_start();
if(isset($_POST['hapus'])) {
	$id	= $_POST['hapus'];
	$sql=$conn->query("DELETE FROM pengeluaran WHERE id_pengeluaran = '$id'");
	if($sql){
		echo "ok";
	}else{
		echo "Gagal";
	}
} 

elseif(isset($_POST['tambah']))
{	
	$keterangan = $_POST['tambah'];
	$total		= $_POST['total'];

	$sql=$conn->query("INSERT INTO pengeluaran ( keterangan, total, tanggal)
						VALUES ('$keterangan','$total', NOW() )");
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
						select *
						from pengeluaran where id_pengeluaran='$id'");
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
	$keterangan = $_POST['keterangan'];
	$total 		= $_POST['total'];

	$sql=$conn->query("UPDATE pengeluaran SET keterangan='$keterangan', total='$total', tanggal = NOW() WHERE id_pengeluaran='$id'");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
?>
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
	$sql4=$conn->query("SELECT * from kas where date_format(tanggal,'%y-%m') = date_format(DATE_ADD(curdate(), INTERVAL 1 MONTH) ,'%y-%m')");
	if ($sql4->num_rows > 0) {
			echo "Gagal".mysql_error();
	}else{
	$keterangan = $_POST['tambah'];

	$sql1=$conn->query("SELECT sum(total) pemasukan from pemasukan where date_format(tanggal,'%y-%m') = date_format(NOW(),'%y-%m')");
	$r1=$sql1->fetch_assoc();

	$sql2=$conn->query("SELECT sum(total) pengeluaran from pengeluaran where date_format(tanggal,'%y-%m') = date_format(NOW(),'%y-%m')");
	$r2=$sql2->fetch_assoc();

	$sql3=$conn->query("SELECT sum(total) pembayaran from pembayaran where date_format(tanggal,'%y-%m') = date_format(NOW(),'%y-%m')");
	$r3=$sql3->fetch_assoc();

	$sql4=$conn->query("SELECT total kas from kas ORDER BY id_kas DESC limit 1");
	$r4=$sql4->fetch_assoc();

	$newkas = ($r4['kas'] + $r3['pembayaran']);
	$total 	= ($r1['pemasukan'] - $r2['pengeluaran']) + $newkas;
	
	$sql=$conn->query("INSERT INTO kas (keterangan, total, tanggal)
						VALUES ('$keterangan','$total', DATE_ADD(curdate(), INTERVAL 1 MONTH) )");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal".mysql_error();
		}
	}
}

elseif(isset($_POST['lihat']))
{	
	$id = $_POST['lihat'];

	$sql=$conn->query("
						select *
						from kas where id_kas='$id'");
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
	$total 		= $_POST['total'];

	$sql=$conn->query("UPDATE kas SET total='$total' WHERE id_kas='$id'");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
?>
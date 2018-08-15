<?php
include "../config.php";
if(isset($_POST['hapus'])) {
	$id	= $_POST['hapus'];
	$sql=$conn->query("DELETE FROM pelanggan WHERE id_pel = '$id'");
	if($sql){
		echo "ok";
	}else{
		echo "Gagal";
	}
} 
elseif(isset($_POST['tambah']))
{	
	$no_ktp 	= $_POST['tambah'];
	$nama		= $_POST['nama'];
	$alamat		= $_POST['alamat'];
	$no_telp	= $_POST['no_telp'];
	$tanggal	= $_POST['tanggal'];
	$golongan	= $_POST['golongan'];

	$sql=$conn->query("INSERT INTO pelanggan (nopel,nama,alamat,no_telp,tanggal,gol) VALUES ('$no_ktp','$nama','$alamat','$no_telp','$tanggal','$golongan')");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
elseif(isset($_POST['lihat']))
{	
	$id = $_POST['lihat'];

	$sql=$conn->query("select * from pelanggan where id_pel='$id'");
		if($sql){
			$r=$sql->fetch_assoc();
			echo json_encode($r);
		}else{
			echo "Gagal";
		}
}
elseif(isset($_POST['ubah']))
{	
	$id = $_POST['ubah'];
	$no_ktp = $_POST['no_ktp'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$no_telp = $_POST['no_telp'];
	$tanggal	= $_POST['tanggal'];
	$golongan	= $_POST['golongan'];

	$sql=$conn->query("UPDATE pelanggan SET nopel='$no_ktp', nama='$nama', alamat='$alamat', no_telp='$no_telp', tanggal='$tanggal', gol='$golongan' WHERE id_pel='$id'");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
?>
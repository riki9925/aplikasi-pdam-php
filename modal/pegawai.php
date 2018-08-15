<?php
include "../config.php";
if(isset($_POST['hapus'])) {
	$id	= $_POST['hapus'];
	$sql=$conn->query("DELETE FROM pegawai WHERE id_peg = '$id'");
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

	$sql=$conn->query("INSERT INTO pegawai (no_ktp,nama,alamat,no_telp) VALUES ('$no_ktp','$nama','$alamat','$no_telp')");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
elseif(isset($_POST['lihat']))
{	
	$id = $_POST['lihat'];

	$sql=$conn->query("select * from pegawai where id_peg='$id'");
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

	$sql=$conn->query("UPDATE pegawai SET no_ktp='$no_ktp', nama='$nama', alamat='$alamat', no_telp='$no_telp' WHERE id_peg='$id'");
		if($sql){
			echo "ok";
		}else{
			echo "Gagal";
		}
}
?>
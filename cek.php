<?php
session_start(); 
include "config.php";
 
$username = $_POST["username"];
$password = $_POST["password"];
 
$sql=$conn->query("SELECT * FROM user WHERE username='$username' AND password='$password'");
$row=$sql->num_rows;
$r=$sql->fetch_assoc();
    if ( $row > 0 ){

        $_SESSION["id"] 		= $r['id'];
		$_SESSION["username"]	= $r['username'];
		$_SESSION["password"]   = $r['password'];
		$_SESSION["nama"]   	= $r['nama'];
		$_SESSION["tgl_login"]  = $r['tgl_login'];
		$_SESSION["token"]   	= $r['token'];
		$_SESSION["foto"]    	= $r['foto'];
		$_SESSION["id_user"]    = $r['id_user'];
		$_SESSION["level"]    	= $r['level'];
		echo "ok";
    }else{
    	echo "no";
    }
?>
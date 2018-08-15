<?php
// $db2 = array(
// 	'db_username'	=>'SIAKOFF',
// 	'db_password'	=>'ora_off_05',
// 	'db_name'	=>'localhost/XE'
// );

$SETT = array (
	'db_host'	 	=> 'localhost',
	'db_username' 	=> 'root',
	'db_password' 	=> '',
	'db_name'		=> 'pdam'
);

$conn = new mysqli($SETT['db_host'], $SETT['db_username'], $SETT['db_password'], $SETT['db_name']);
// $conn2 = oci_connect($db2['db_username'], $db2['db_password'], $db2['db_name']);

if ($conn->connect_error){
	echo "Gagal terkoneksi ke database : (".$mysqli->connect_error.")".$mysqli->connect_error;
}

?>
<?php
session_start();
ob_start();
ob_end_clean();
include "config.php";
date_default_timezone_set("Asia/Jakarta");
$id = $_GET['code'];
require('fpdf/textbox.php');


if($_SESSION['level'] == '1'){

$user = $conn->query("
SELECT

date_format(meter.tanggal,'%m') bulan,
date_format(meter.tanggal,'%Y') tahun,
pelanggan.nopel,
pelanggan.nama,
pelanggan.alamat,
golongan.golongan,
date_format(meter.tanggal,'%d %M %Y') periksa,
meter.lalu,
meter.sekarang,
meter.jumlah,

golongan.pertama per,
golongan.kedua ked,
golongan.ketiga ket,
golongan.keempat kpt,
golongan.kelima kel,
golongan.keenam knm,

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

FROM detail_pembayaran
LEFT JOIN pembayaran ON pembayaran.id_bayar = detail_pembayaran.id_bayar
LEFT JOIN meter ON meter.id_meter = detail_pembayaran.id_meter
LEFT JOIN pelanggan ON pelanggan.id_pel = meter.id_pel
LEFT JOIN golongan ON golongan.id_gol = pelanggan.gol
where detail_pembayaran.id_bayar = '$id'");

function Terbilang($x)
{
  $abil = array("", "SATU", "DUA", "TIGA", "EMPAT", "LIMA", "ENAM", "TUJUH", "DELAPAN", "SEMBILAN", "SEPULUH", "SEBELAS");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "BELAS";
  elseif ($x < 100)
    return Terbilang($x / 10) . " PULUH" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " RATUS" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " RIBU" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " JUTA" . Terbilang($x % 1000000);
}


$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'temp'.DIRECTORY_SEPARATOR;
$PNG_WEB_DIR = 'temp/';
include "phpqrcode/qrlib.php";   
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);
$filename = $PNG_TEMP_DIR.'test.png';
$errorCorrectionLevel = 'L';
$matrixPointSize = 2;


// $pdf = new FPDF('P', 'cm', 'Letter');
$pdf=new PDF_TextBox('P', 'cm', 'Legal');
$pdf->AliasNbPages();
$pdf->SetMargins(0.6,0.6,1);
$pdf->AddPage();

$uk = 0;
$brcode = 0.6;

while($s=$user->fetch_assoc()){
if ($s['bulan']=='01') {
	$bulan='JANUARI';
}elseif($s['bulan']=='02'){
	$bulan='FEBRUARI';
}elseif($s['bulan']=='03'){
	$bulan='MARET';
}elseif($s['bulan']=='04'){
	$bulan='APRIL';
}elseif($s['bulan']=='05'){
	$bulan='MEI';
}elseif($s['bulan']=='06'){
	$bulan='JUNI';
}elseif($s['bulan']=='07'){
	$bulan='JULI';
}elseif($s['bulan']=='08'){
	$bulan='AGUSTUS';
}elseif($s['bulan']=='09'){
	$bulan='SETEMBER';
}elseif($s['bulan']=='10'){
	$bulan='OKTOBER';
}elseif($s['bulan']=='11'){
	$bulan='NOVEMBER';
}else{
	$bulan='DESEMBER';
}

$data= $s['nopel'].", ".date("Y-m-d H:i:s") ;
$filename = $PNG_TEMP_DIR.'test'.md5(date("H:i:s").'|'.$errorCorrectionLevel.'|'.$matrixPointSize).'.png';
QRcode::png($data, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
$total = $s['beban']+$s['total'];

$pdf->SetY($uk);
$pdf->Image('temp/'.basename($filename),0.6,$brcode);
$pdf->SetFont('times','B',12);
// $pdf->SetLineWidth(0.1);
// $pdf->Rect(0.6,3,20,0);

$pdf->Ln(1);
$pdf->Cell(0,0,'PENGELOLA AIR MINUM',0,0,'C');
$pdf->Ln(0.5);
$pdf->Cell(0,0,'(PAMDUS) TIRTO KATU DUSUN KASIKON',0,0,'C');
$pdf->Ln(0.5);
$pdf->Cell(0,0,'DESA WADUNG KECAMATAN PAKISAJI KABUPATEN MALANG',0,0,'C');


$pdf->Ln(1);
$pdf->SetFont('Times','B',10);
$pdf->Cell(2.5,0,'BULAN',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0, $bulan.' '.$s['tahun'] ,0,0,'L');
$pdf->Cell(0.5,0,'',0,0,'L');

$pdf->Ln(0.4);
$pdf->Cell(2.5,0,'NO',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0, $s['nopel'] ,0,0,'L');

$pdf->Ln(0.4);
$pdf->Cell(2.5,0,'NAMA',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->drawTextBox($s['nama'], 4, 0, 'L', 'T', false);

$pdf->Ln(0.4);
$pdf->Cell(2.5,0,'ALAMAT',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->drawTextBox( $s['alamat'] , 4, 0, 'L', 'T', false);

$pdf->Ln(0.4);
$pdf->Cell(2.5,0,'GOLONGAN',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,$s['golongan'],0,0,'L');

$pdf->Ln(0.4);
$pdf->Cell(2.5,0,'PERIKSA',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0, $s['periksa'] ,0,0,'L');





$pdf->SetY($uk);

$pdf->Ln(3);
$pdf->Cell(9,0,'',0,'L');
$pdf->Cell(4,0,'METER AWAL',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,$s['lalu'].' M3',0,0,'L');

$pdf->Ln(0.6);
$pdf->Cell(10,0,'',0,'L');
$pdf->Cell(3,0,'1 - 10',0,0,'L');
$pdf->Cell(2,0,'Rp. '.number_format($s['per']),0,0,'R');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['PERTAMA']),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(10,0,'',0,'L');
$pdf->Cell(3,0,'11 - 20',0,0,'L');
$pdf->Cell(2,0,'Rp. '.number_format($s['ked']),0,0,'R');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['KEDUA']),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(10,0,'',0,'L');
$pdf->Cell(3,0,'21 - 30',0,0,'L');
$pdf->Cell(2,0,'Rp. '.number_format($s['ket']),0,0,'R');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['KETIGA']),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(10,0,'',0,'L');
$pdf->Cell(3,0,'31 - 40',0,0,'L');
$pdf->Cell(2,0,'Rp. '.number_format($s['kpt']),0,0,'R');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['KEEMPAT']),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(10,0,'',0,'L');
$pdf->Cell(3,0,'41 - 50',0,0,'L');
$pdf->Cell(2,0,'Rp. '.number_format($s['kel']),0,0,'R');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['KELIMA']),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(10,0,'',0,'L');
$pdf->Cell(3,0,'51 Keatas',0,0,'L');
$pdf->Cell(2,0,'Rp. '.number_format($s['knm']),0,0,'R');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['KEENAM']),0,0,'R');

$pdf->Ln(0.6);
$pdf->Cell(9,0,'',0,'L');
$pdf->Cell(4,0,'METER AKHIR',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,$s['sekarang'].' M3',0,0,'L');


$pdf->Ln(0.6);
$pdf->Cell(9,0,'',0,'L');
$pdf->Cell(4,0,'PEMAKAIAN',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,$s['jumlah'].' M3',0,0,'L');

$pdf->Ln(0.4);
$pdf->Cell(9,0,'',0,'L');
$pdf->Cell(4,0,'TOTAL HARGA',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['total']),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(9,0,'',0,'L');
$pdf->Cell(4,0,'BEBAN ADMIN',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($s['beban']),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(9,0,'',0,'L');
$pdf->Cell(4,0,'TOTAL BAYAR',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');
$pdf->Cell(4,0,'Rp. '.number_format($total),0,0,'R');

$pdf->Ln(0.4);
$pdf->Cell(9,0,'',0,'L');
$pdf->Cell(4,0,'TERBILANG',0,0,'L');
$pdf->Cell(0.2,0,':',0,0,'L');

// $pdf->Cell(4,0,ucwords(Terbilang($total)),0,0,'L');
$pdf->drawTextBox( ucwords(Terbilang($total)) , 5, 0, 'L', 'T', false);
$uk += 10; 
$brcode += 10; 
}
}
$pdf->Output('I');
?>
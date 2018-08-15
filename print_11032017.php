<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
// error_reporting(0);
include "config.php";
$id = $_GET['code'];
?> 
<?php if($_SESSION['level'] == '1'){ ?>

<?php
$sql = $conn->query("
        select
        pelanggan.nama pelanggan, pelanggan.nopel ktp, pelanggan.alamat, pembayaran.id_peg, pembayaran.total,
        date_format(pembayaran.tanggal,'%Y/%m') tgl, pembayaran.id_pel, pembayaran.tanggal, golongan.harga beban

        from pembayaran
        left join pelanggan on pelanggan.id_pel = pembayaran.id_pel 
        left join golongan on golongan.id_gol = pelanggan.gol 
        where pembayaran.id_bayar = '$id'");
$r=$sql->fetch_assoc();
// $id_admin = $r->['id_peg'];

// $sql1 = $conn->query("
        // select from user where id = '$id_admin'");
// $n=$sql1->fetch_assoc();

$sql2 = $conn->query("
SELECT
meter.jumlah volume,
date_format(meter.tanggal,'%m') bulan,
CASE WHEN meter.jumlah BETWEEN 0  and 10 THEN golongan.pertama
     WHEN meter.jumlah BETWEEN 11 and 20 THEN golongan.kedua
     WHEN meter.jumlah BETWEEN 21 and 30 THEN golongan.ketiga
     WHEN meter.jumlah BETWEEN 31 and 40 THEN golongan.keempat
     WHEN meter.jumlah BETWEEN 41 and 50 THEN golongan.kelima
     WHEN meter.jumlah > 50 THEN golongan.keenam
END jumlah,
(meter.jumlah *
CASE WHEN meter.jumlah BETWEEN 0  and 10 THEN golongan.pertama
     WHEN meter.jumlah BETWEEN 11 and 20 THEN golongan.kedua
     WHEN meter.jumlah BETWEEN 21 and 30 THEN golongan.ketiga
     WHEN meter.jumlah BETWEEN 31 and 40 THEN golongan.keempat
     WHEN meter.jumlah BETWEEN 41 and 50 THEN golongan.kelima
     WHEN meter.jumlah > 50 THEN golongan.keenam
END) total
FROM detail_pembayaran
LEFT JOIN meter ON meter.id_meter = detail_pembayaran.id_meter
LEFT JOIN pelanggan ON pelanggan.id_pel = meter.id_pel
LEFT JOIN golongan ON golongan.id_gol = pelanggan.gol
where detail_pembayaran.id_bayar = '$id'");
$no=0;


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

?>

<style type="text/css">
@page {
    margin: 5px;
}
th, td{
    border-bottom: 1px solid #ddd;
    height: 25px;
}
table{
    font-size: 10px;
}
</style>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Pengelola Air Minum</title>

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/plugins.css">
        <link rel="stylesheet" href="css/print.css">
        <script src="js/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
        <div id="page-wrapper">
            <div id="page-container">
                <div id="main-container">
                    <div id="page-content">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-2 col-lg-6 col-lg-offset-3">
                                <div class="block">
                                    <div class="block-title">
                                        <div class="block-options pull-right">
                                            <a href="javascript:void(0)" class="btn btn-effect-ripple btn-default" onclick="App.pagePrint();" id="print"><i class="fa fa-print"></i> Print</a>
                                        </div>
                                        <h2>Slip Tagihan <small>#<?php echo $r['tgl'].'/'.$r['id_pel'].'/'.$id;?></small></h2>
                                    </div>
                                    <h4 class="h1 text-center" style="padding: 0px;" style="margin-top: 0px;">
                                        <strong>
                                        TIRTO KATU
                                        </strong>
                                    </h4>
                                    <p class="text-center">Desa wadung Kec. Pakisaji Kab. Malang</p>
                                    <hr/>
                                    <div>
                                        <table width="80%" align="center">
                                            <thead>
                                                <tr>
                                                    <th width="30%">TANGGAL</th>
                                                    <td width="5px">: </td>
                                                    <td> <?php echo $r['tanggal'];?></td>
                                                </tr>
                                                <tr style="height: 20px">
                                                    
                                                </tr>
                                                <tr>
                                                    <th>NO KTP</th>
                                                    <td>: </td>
                                                    <td> <?php echo $r['ktp'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>NAMA</th>
                                                    <td>: </td>
                                                    <td> <?php echo $r['pelanggan'];?></td>
                                                </tr>
                                                <tr>
                                                    <th>ALAMAT</th>
                                                    <td>: </td>
                                                    <td> <?php echo $r['alamat'];?></td>
                                                </tr>
                                                <?php
                                                while($s=$sql2->fetch_assoc()){ $no++;
                                                    if ($s['bulan'] == '01') {
                                                        $bulan = 'JANUARI';
                                                    }else
                                                    if ($s['bulan'] == '02') {
                                                        $bulan = 'FEBRUARI';
                                                    }else
                                                    if ($s['bulan'] == '03') {
                                                        $bulan = 'MARET';
                                                    }else
                                                    if ($s['bulan'] == '04') {
                                                        $bulan = 'APRIL';
                                                    }else
                                                    if ($s['bulan'] == '05') {
                                                        $bulan = 'MEI';
                                                    }else
                                                    if ($s['bulan'] == '06') {
                                                        $bulan = 'JUNI';
                                                    }else
                                                    if ($s['bulan'] == '07') {
                                                        $bulan = 'JULI';
                                                    }else
                                                    if ($s['bulan'] == '08') {
                                                        $bulan = 'AGUSTUS';
                                                    }else
                                                    if ($s['bulan'] == '08') {
                                                        $bulan = 'SEPTEMBER';
                                                    }else
                                                    if ($s['bulan'] == '10') {
                                                        $bulan = 'OKTOBER';
                                                    }else
                                                    if ($s['bulan'] == '11') {
                                                        $bulan = 'NOVEMBER';
                                                    }else
                                                    if ($s['bulan'] == '12') {
                                                        $bulan = 'DESEMBER';
                                                    }

                                                    // $total = ($s['harga'] + $s['denda']);
                                                ?>
                                                <tr style="height: 20px">
                                                </tr>
                                                <tr>
                                                    <th>BULAN</th>
                                                    <td>: </td>
                                                    <td> <?php echo $bulan;?></td>
                                                </tr>
                                                <tr>
                                                    <th>VOLUME</th>
                                                    <td>:</td>
                                                    <td> <?php echo number_format($s['volume']); ?> /M3</td>
                                                </tr>
                                                <tr>
                                                    <th>HARGA</th>
                                                    <td>:</td>
                                                    <td class="text-right"> <?php echo number_format($s['total']); ?></td>
                                                </tr>
                                                <?php } ?>
                                                <tr style="height: 20px">
                                                </tr>
                                                <tr>
                                                    <th>ADMIN</th>
                                                    <td>:</td>
                                                    <td class="text-right"> <?php echo number_format($r['beban']); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>TOTAL TAGIHAN</th>
                                                    <td>:</td>
                                                    <td class="text-right"> <strong><?php echo number_format($r['total']);?></strong></td>
                                                </tr>
                                                <tr>
                                                <tr style="height: 20px">
                                                </tr>
                                                    <th>TERBILANG</th>
                                                    <td>:</td>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-center"> <h3 class="h4"><?php echo ucwords(Terbilang($r['total'])); ?></h3></th>
                                                </tr>
        
                                            </thead>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-lg-12 text-center" style="margin-top: 0px;">
                                            <h4 class="h2"><strong>TERIMA KASIH</strong></h4>
                                        </div>
                                    </div>
                                </div>
                                <!-- END Invoice Block -->
                            </div>
                        </div>
                    </div>
                    <!-- END Page Content -->
                </div>
                <!-- END Main Container -->
            </div>
            <!-- END Page Container -->
        </div>
        <!-- END Page Wrapper -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="js/vendor/jquery-2.2.4.min.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>
        <script type="text/javascript">
        $( document ).ready(function() {
            App.pagePrint();
        });

        </script>
    </body>
</html>
<?php }else{ 
echo 'Session Limit';
}
?>

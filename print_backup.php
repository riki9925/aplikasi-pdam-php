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
        date_format(pembayaran.tanggal,'%Y/%m') tgl, pembayaran.id_pel, pembayaran.tanggal

        from pembayaran
        left join pelanggan on pelanggan.id_pel = pembayaran.id_pel 
        where pembayaran.id_bayar = '$id'");
$r=$sql->fetch_assoc();
// $id_admin = $r->['id_peg'];

// $sql1 = $conn->query("
        // select from user where id = '$id_admin'");
// $n=$sql1->fetch_assoc();

$sql2 = $conn->query("
SELECT
meter.id_meter id,
date_format(meter.tanggal,'%m') bulan,
meter.jumlah volume,
(meter.jumlah * golongan.harga) harga,
((meter.jumlah * golongan.harga) * TIMESTAMPDIFF(MONTH, meter.tanggal, CURDATE()) ) denda
FROM detail_pembayaran
LEFT JOIN meter ON meter.id_meter = detail_pembayaran.id_meter
LEFT JOIN pelanggan ON pelanggan.id_pel = meter.id_pel
LEFT JOIN golongan ON golongan.id_gol = pelanggan.gol
where detail_pembayaran.id_bayar = '$id'");
$no=0;
?>

<style type="text/css">
@page {
    margin: 5px;
}
</style>
<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Aplikasi Rekening Air</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/plugins.css">
        <link rel="stylesheet" href="css/print.css">
        <link rel="stylesheet" href="css/themes.css">
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
                                        <h2>Slip Pembayaran <small>#<?php echo $r['tgl'].'/'.$r['id_pel'].'/'.$id;?></small></h2>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-lg-12 text-center" style="margin-top: 0px;">
                                            <h4 class="h3"><strong>TIRTA DAWUNG</strong></h4>
                                            <p>JL. Diponegoro 17, Pakisaji, Malang</p>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>NO KTP</th>
                                                    <th style="width: 80%">: <?php echo $r['ktp'];?></th>
                                                </tr>
                                                <tr>
                                                    <th>NAMA</th>
                                                    <th style="width: 80%">: <strong><?php echo $r['pelanggan'];?></strong></th>
                                                </tr>
                                                <tr>
                                                    <th>ALAMAT</th>
                                                    <th style="width: 80%">: <?php echo $r['alamat'];?></th>
                                                </tr>
                                                <tr>
                                                    <th>TANGGAL</th>
                                                    <th style="width: 80%">: <?php echo $r['tanggal'];?></th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-vcenter">
                                            <thead>
                                                <tr>
                                                    <th style="width: 5px;" class="text-center">NO</th>
                                                    <th style="width: 20%;">BULAN</th>
                                                    <th class="text-center">VOLUME/M3</th>
                                                    <th class="text-center">DENDA</th>
                                                    <th class="text-center">HARGA</th>
                                                    <th class="text-center">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
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

                                                    $total = ($s['harga'] + $s['denda']);
                                                ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $no; ?></td>
                                                    <td><strong><?php echo $bulan; ?></strong></td>
                                                    <td class="text-right"><?php echo number_format($s['volume']); ?></td>
                                                    <td class="text-right"><?php echo number_format($s['denda']); ?></td>
                                                    <td class="text-right"><?php echo number_format($s['harga']); ?></td>
                                                    <td class="text-right"><?php echo number_format($total); ?></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <td colspan="5" class="text-right"><strong>TOTAL TAGIHAN</strong></td>
                                                    <td class="text-right"><strong><?php echo number_format($r['total']);?></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-lg-12 text-center" style="margin-top: 0px;">
                                            <h4 class="h3"><strong>TERIMA KASIH</strong></h4>
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

<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
// error_reporting(0);
include "config.php";
?>

 
<?php if($_SESSION['level'] == '1'){ ?>
<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en">
<![endif]-->
<!--[if gt IE 9]>
<!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>APLIKASI REKENING PAM</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/plugins.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/themes/passion.css" id="theme-link">
        <link rel="stylesheet" type="text/css" href="plugin/sweetalert/dist/sweetalert.css">
        <link rel="stylesheet" type="text/css" href="DataTables/extensions/Buttons/css/buttons.dataTables.min.css">
        <script type="text/javascript" src="plugin/sweetalert/dist/sweetalert.min.js"></script>
        <script src="js/vendor/modernizr-3.3.1.min.js"></script>
        <script src="js/vendor/jquery-2.2.4.min.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>
        <!-- <link rel="canonical" href="http://openexchangerates.github.io/accounting.js/" /> -->

    <script>
     $(document).ajaxStop(function() {
          //setTimeout(function(){
             $( ".se-pre-con" ).hide();
          //},1500);
      });
      $(document).ajaxStart(function() {
          $(".se-pre-con").show();
      });
      $(document).ajaxError(function() {
          //setTimeout(function(){
             $( ".se-pre-con" ).hide();
          //},1500);
      });
    </script>

<style type="text/css">
.se-pre-con {      
    position: fixed;
    left: 0px;
    top: 0px;
    width: 100%;
    height: 100%;
    z-index: 9999;
    opacity: 0.9;
    background: url(https://garamina.com/fintech2/theme/images/new/Preloader_2.gif) center no-repeat #fff;
    } 
}
</style>



<!-- </head> -->
<!-- <body class="hold-transition skin-blue-light sidebar-mini"> -->
<!-- <div class="page-loading"></div> -->



    </head>
    <body>
        <!-- <div class="se-pre-con"></div> -->
        <div id="page-wrapper" class="page-loading">
            <div class="preloader">
                <div class="inner">
                    <div class="preloader-spinner themed-background hidden-lt-ie10"></div>
                    <h3 class="text-primary visible-lt-ie10"><strong>Loading..</strong></h3>
                </div>
            </div>
            <div id="page-container" class="header-fixed-top sidebar-visible-lg-full">
                <div id="sidebar">
                    <div id="sidebar-brand" class="themed-background">
                        <a href="index.html" class="sidebar-title">
                            <i class="gi gi-snowflake"></i> <span class="sidebar-nav-mini-hide"><strong>TIRTO KATU</strong></span>
                        </a>
                    </div>
                    <div id="sidebar-scroll">
                        <div class="sidebar-content">
                            <ul class="sidebar-nav">
                                <li>
                                    <a href="#" id="dashboard" onclick="load('dashboard')"><i class="gi gi-snowflake sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Dashboard</span></a>
                                </li>

                                <li class="sidebar-separator"><i class="fa fa-ellipsis-h"></i></li>

                                <li>
                                    <a href="#" id="pembayaran" onclick="load('pembayaran')"><i class="hi hi-list sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Pembayaran</span></a>
                                </li>
                                <li>
                                    <a href="#" id="meter" onclick="load('meter')"><i class="gi gi-cloud-download sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Data Meter</span></a>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-calculator sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Pencatatan</span></a>
                                    <ul>
                                        <li><a href="#" id="pemasukan" onclick="load('pemasukan')">Pemasukkan</a></li>
                                        <li><a href="#" id="pengeluaran" onclick="load('pengeluaran')">Pengeluaran</a></li>
                                        <li><a href="#" id="kas" onclick="load('kas')">Tutup Buku</a></li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-file sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Laporan</span></a>
                                    <ul>
                                        <li><a href="#" id="tagihan" onclick="load('tagihan')">Lunas</a></li>
                                        <li><a href="#" id="tunggakan" onclick="load('tunggakan')">Jatuh Tempo</a></li>
                                        <li><a href="#" id="bulanan" onclick="load('bulanan')">Bulanan</a></li>
                                    </ul>
                                </li>

                                <li class="sidebar-separator"><i class="fa fa-ellipsis-h"></i></li>

                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-database sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Data Master</span></a>
                                    <ul>
                                        <li><a href="#" id="pelanggan" onclick="load('pelanggan')">Pelanggan</a></li>
                                        <li><a href="#" id="golongan" onclick="load('golongan')">Golongan</a></li>
                                        <li><a href="#" id="pegawai" onclick="load('pegawai')">Pegawai</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                        <div class="text-center">
                            <small>2017 &copy;  TIRTO KATU <br/>Created By <a href="http://wuupz.com/" target="_blank">WUUPZ</a></small>
                        </div>
                    </div>
                </div>
                <div id="main-container">
                    <header class="navbar navbar-inverse navbar-fixed-top">
                        <ul class="nav navbar-nav-custom">
                            <li>
                                <a href="javascript:void(0)" onclick="App.sidebar('toggle-sidebar');this.blur();">
                                    <i class="fa fa-ellipsis-v fa-fw animation-fadeInRight" id="sidebar-toggle-mini"></i>
                                    <i class="fa fa-bars fa-fw animation-fadeInRight" id="sidebar-toggle-full"></i>
                                </a>
                            </li>
                            <li class="hidden-xs animation-fadeInQuick">
                                <a href=""><strong>ADMINISTRATOR</strong></a>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav-custom pull-right">
                            <li class="dropdown">
                                <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="img/placeholders/avatars/avatar.jpg" alt="avatar">
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-header">
                                        <strong>ADMINISTRATOR</strong>
                                    </li>
                                    <li>
                                        <a href="logout.php">
                                            <i class="fa fa-power-off fa-fw pull-right"></i>
                                            Log out
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </header>
                    <div id="page-content">
                    </div>
                </div>
            </div>
        </div>
        <!-- <script type="text/javascript" src="DataTables/extensions/Buttons/js/jquery.dataTables.min.js"></script> -->
        <script type="text/javascript" src="DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>
        <script type="text/javascript" src="DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
        <script type="text/javascript" src="DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>

        <script type="text/javascript" src="DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
        <script type="text/javascript">

        function load(page) {

          $('#dashboard').prop('class','');
          $('#pelanggan').prop('class','');
          $('#meter').prop('class','');
          $('#pembayaran').prop('class','');
          $('#golongan').prop('class','');
          $('#pegawai').prop('class','');
          $('#tagihan').prop('class','');
          $('#tunggakan').prop('class','');
          $('#pemasukan').prop('class','');
          $('#pengeluaran').prop('class','');
          $('#bulanan').prop('class','');
          $('#kas').prop('class','');

          $('#page-content').load('page/'+page+'.php');
          $('#'+page).prop('class', 'active');
        }
        load('dashboard');

        </script>

    </body>
</html>


<?php
}else{
  header('location:index.php');
}
?>
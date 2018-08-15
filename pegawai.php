<?php
session_start();
date_default_timezone_set("Asia/Jakarta");
error_reporting(0);
include "config.php";
?>


<?php if($_SESSION['level'] == '2'){ ?>
<!DOCTYPE html>
<!--[if IE 9]>
<html class="no-js lt-ie10" lang="en">
<![endif]-->
<!--[if gt IE 9]>
<!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>Aplikasi Rekening Air</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/plugins.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/themes/passion.css" id="theme-link">
        <link rel="stylesheet" type="text/css" href="plugin/sweetalert/dist/sweetalert.css">
        <script type="text/javascript" src="plugin/sweetalert/dist/sweetalert.min.js"></script>
        <script src="js/vendor/modernizr-3.3.1.min.js"></script>
        <script>
          $(document).ajaxStop(function() {
              setTimeout(function(){
                 $( ".page-loading" ).hide();
              },1500);
          });
          $(document).ajaxStart(function() {
              $(".page-loading").show();
          });
          $(document).ajaxError(function() {
              setTimeout(function(){
                 $( ".page-loading" ).hide();
              },1500);
          });


</script>



<!-- </head> -->
<!-- <body class="hold-transition skin-blue-light sidebar-mini"> -->
<!-- <div class="page-loading"></div> -->



    </head>
    <body>
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
                            <i class="gi gi-snowflake"></i> <span class="sidebar-nav-mini-hide"><strong>AIR</strong></span>
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
                                    <a href="#"><i class="hi hi-list sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Transaksi</span></a>
                                </li>

                                <li class="sidebar-separator"><i class="fa fa-ellipsis-h"></i></li>

                                <li>
                                    <a href="#" class="sidebar-nav-menu"><i class="fa fa-chevron-left sidebar-nav-indicator sidebar-nav-mini-hide"></i><i class="fa fa-database sidebar-nav-icon"></i><span class="sidebar-nav-mini-hide">Data Master</span></a>
                                    <ul>
                                        <li><a href="#" id="pelanggan" onclick="load('pelanggan')">Pelanggan</a></li>
                                        <li><a href="#" id="golongan" onclick="load('golongan')">Golongan</a></li>
                                        <li><a href="page_ui_widgets.html">Pegawai</a></li>
                                        <li><a href="page_ui_widgets.html">Laporan</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div id="sidebar-extra-info" class="sidebar-content sidebar-nav-mini-hide">
                        <div class="text-center">
                            <small>2017 &copy; <a href="http://aldiragil.blogspot.co.id/" target="_blank">ALDI RAGIL ROMADHON</a></small>
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
                                <a href=""><strong>SELAMAT DATANG</strong></a>
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
        <script src="js/vendor/jquery-2.2.4.min.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>
        <script src="js/pages/uiTables.js"></script>
        <script type="text/javascript">

        function load(page) {

          $('#dashboard').prop('class','');
          $('#pelanggan').prop('class','');
          $('#golongan').prop('class','');
          $('#pegawai').prop('class','');

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
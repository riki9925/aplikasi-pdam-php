<?php 
session_start();
date_default_timezone_set("Asia/Jakarta");
error_reporting(0);
include "config.php";
?>


<?php

if($_SESSION['level'] == '1'){
  header('location:admin.php');
}else{

?>

<!DOCTYPE html>
<!--[if IE 9]>         <html class="no-js lt-ie10" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">

        <title>APLIKASI REKENING PAM</title>

        <meta name="description" content="AppUI is a Web App Bootstrap Admin Template created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="img/favicon.png">
        <link rel="apple-touch-icon" href="img/icon57.png" sizes="57x57">
        <link rel="apple-touch-icon" href="img/icon72.png" sizes="72x72">
        <link rel="apple-touch-icon" href="img/icon76.png" sizes="76x76">
        <link rel="apple-touch-icon" href="img/icon114.png" sizes="114x114">
        <link rel="apple-touch-icon" href="img/icon120.png" sizes="120x120">
        <link rel="apple-touch-icon" href="img/icon144.png" sizes="144x144">
        <link rel="apple-touch-icon" href="img/icon152.png" sizes="152x152">
        <link rel="apple-touch-icon" href="img/icon180.png" sizes="180x180">
        <!-- END Icons -->

        <!-- Stylesheets -->
        <!-- Bootstrap is included in its original form, unaltered -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- Related styles of various icon packs and plugins -->
        <link rel="stylesheet" href="css/plugins.css">

        <!-- The main stylesheet of this template. All Bootstrap overwrites are defined in here -->
        <link rel="stylesheet" href="css/main.css">

        <!-- Include a specific file here from css/themes/ folder to alter the default theme of the template -->

        <!-- The themes stylesheet of this template (for using specific theme color in individual elements - must included last) -->
        <link rel="stylesheet" href="css/themes.css">
        <!-- END Stylesheets -->

        <!-- Modernizr (browser feature detection library) -->
        <script src="js/vendor/modernizr-3.3.1.min.js"></script>
    </head>
    <body>
        <!-- Login Container -->
        <div id="login-container">
            <!-- Login Header -->
            <h1 class="h2 text-light text-center push-top-bottom animation-slideDown">
                <strong>PENGELOLA AIR MINUM</strong> <br/>(PAMDES) TIRTO KATU
            </h1>
                
            <div class="block animation-fadeInQuickInv">
                <!-- Login Title -->
                <div class="block-title">
                    <h2>LOGIN</h2>
                </div>
                <!-- END Login Title -->

                <!-- Login Form -->
                <form id="form-login" class="form-horizontal" tabindex="-1">
                    <div class="form-group">
                        <div class="col-xs-12" id="login"></div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="text" id="username" name="username" class="form-control" placeholder="Your username..">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input type="password" id="password" name="password" class="form-control" placeholder="Your password..">
                        </div>
                    </div>
                    <div class="form-group form-actions">
                        <div class="col-xs-12 text-right">
                            <button type="button" class="btn btn-effect-ripple btn-sm btn-success" onclick="check_login()">LOGIN</button>
                        </div>
                    </div>
                </form>
                <!-- END Login Form -->
            </div>
            <!-- END Login Block -->
            <h2 class="text-light text-center push-top-bottom animation-slideUp">
                <STRONG>DESA WADUNG</STRONG><br/>
            KECAMATAN PAKISAJI
            </h2>
            <!-- END Login Block -->

            <!-- Footer -->
            <footer class="text-muted text-center animation-pullUp">
                <small> 2017 </span> &copy; <a href="http://wuupz.com/" target="_blank">Wuupz.com</a></small>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Login Container -->

        <!-- jQuery, Bootstrap, jQuery plugins and Custom JS code -->
        <script src="js/vendor/jquery-2.2.4.min.js"></script>
        <script src="js/vendor/bootstrap.min.js"></script>
        <script src="js/plugins.js"></script>
        <script src="js/app.js"></script>

        <!-- Load and execute javascript code used only in this page -->
        <script src="js/pages/readyLogin.js"></script>
        <script>$(function(){ ReadyLogin.init(); });</script>
    </body>
</html>

<script type="text/javascript">
function check_login()
{
    // $('#login').hide();
    var username = $('#username').val();
    var password = $('#password').val();

    $.ajax({
        url     : 'cek.php',
        data    : 'username='+username+'&password='+password, 
        type    : 'POST',
        dataType: 'html',
        success : function(pesan){
            if(pesan=='ok'){
                $('#login').show().html('<button type="button" class="btn btn-block btn-success"> Sukses Login </button>');
              window.location='index.php';
            }else{
                $('#login').show().html('<button type="button" class="btn btn-block btn-danger"> Username / Password Salah </button>');
              // window.location='index.php';
            }
        },
    });
}

</script>

<?php } ?>
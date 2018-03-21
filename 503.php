<?php 

    if ($_SERVER["SERVER_NAME"] == "jobbersargentina.com") {
        header("Location: http://jobbersargentina.net");
        exit;
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>JOBBERS - Pagina no Encontrada</title>
    <?php require_once('includes/libs-css.php'); ?>
    <link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">

    <style>
        @media (max-width: 500px){
            .img-503{
                width: 80% !important;
            }
        }
    </style>

    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
        (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-1968505410020323",
            enable_page_level_ads: true
        });
    </script>
</head>

<body class="large-sidebar fixed-sidebar fixed-header" style="background-color: #fff; height: 100vh">
    <div class="overlay" style="opacity: .4; background-color: #042A3B;"></div>
    <div class="bg" style="background: url(img/galaxy.jpg) center fixed no-repeat; background-size: cover; height: 100vh">
        <div class="container text-center">
            <!-- <div class="col-md-12">
                    <img src="img/logo.png" alt="Logo Jobbers" style="margin-top: 25vh; width: 20%">
                </div> -->
            <div class="col-md-12">
                <img class="img-503" src="img/503.png" alt="Error 503" style="margin-top: 15vh; width:30%;">
            </div>
            <div class="col-md-12">
                <h2 style="color: #070725; font-family: 'Patua One', cursive; font-weight:500; font-size: 50px; text-shadow: -3px 1px 13px #3FA2A5;">Error 503!</h2>
                <h2 style="color: #070725; font-family: 'Patua One', cursive; font-weight:500; font-size: 30px; text-shadow: -3px 1px 13px #3FA2A5;">Servicio temporalmente no disponible, estamos trabajando para usted.</h2>
            </div>
        </div>
    </div>
    <?php //require_once('includes/libs-js.php'); ?>
</body>

</html>
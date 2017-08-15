<?php

    require_once('classes/DatabasePDOInstance.function.php');
    $db = DatabasePDOInstance();

    if (isset($_GET['id']) && isset($_GET['n']) && isset($_GET['a'])){
        session_start();

        $id = $_GET['id'];
        $name = $_GET['n'];
        $apellido = $_GET['a'];

        $db->query("UPDATE trabajadores SET confirmar = 1 WHERE id = $id");
        
    } else {
        
        header('Location: ./');
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
    <title>JOBBERS - Iniciar sesión</title>

    <!-- Vendor CSS -->
    <link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="vendor/themify-icons/themify-icons.css">
    <link rel="stylesheet" href="vendor/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="vendor/sweetalert2/sweetalert2.min.css">

    <!-- Neptune CSS -->
    <link rel="stylesheet" href="css/core.css">

    <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<style>
    h4 {
        letter-spacing: 1.5px;
    }
</style>
<body class="img-cover" style="background-image: url(img/OB82100.jpg);">

<div class="container-fluid">
    <div class="sign-form">
        <div class="row">
            <div class="col-md-4 offset-md-4 p-x-3">
                <div class="box b-a-0">
                    <div style="text-align: center;margin: ;">
                        <a href="./"><img src="img/logo_d.png" style="height: 50px; margin-top: 20px;"></a>
                    </div>
                    <div class="p-a-2 text-xs-center">
                        <h5><?= $name . " " . $apellido ?>, Bienvenido a JOBBERS</h5>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="p-a-2 text-center">
                                <h4>Tu correo electronico ha sido confirmado satisfactoriamente... En un momento serás
                                    redireccionado al area de inicio de sesion.</h4>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Vendor JS -->
<script type="text/javascript" src="vendor/jquery/jquery-1.12.3.min.js"></script>
<script type="text/javascript" src="vendor/tether/js/tether.min.js"></script>
<script type="text/javascript" src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="vendor/sweetalert2/sweetalert2.min.js"></script>

<script>
    $(document).ready(function () {

        setTimeout(function () {
            window.location.assign("ingresar.php");
        }, 3000);
    });
</script>
</body>
</html>
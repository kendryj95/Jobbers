<?php
  
  require 'vendor/phpmailer/class.phpmailer.php';
  require 'vendor/phpmailer/class.smtp.php';

$contenido = '<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Latest compiled and minified CSS JS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://jobbersargentina.com/css/plantilla-mail.css">
    <!-- Iconos de FontAwesome -->
    <title>Plantilla Email</title>
</head>

<body>
    <header class=".head">
        <div class="container header-container">
            <div class="col-md-6">
                <img src="https://jobbersargentina.com/img/logo_d.png" alt="Logo" style="width: 200px; height: 90px">
            </div>

            <div class="col-md-6">
                <ul class="list-inline" id="socialMedia">
                    <li class="list-inline-item">
                        <a href="#">
                            <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-globe fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="#">
                            <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                                </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </header>
    <div class="container">
        <h1>Contenido</h1>
        <ul>
            <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</li>
            <li>Cras eget turpis vestibulum ante dictum commodo non non tellus.</li>
            <li>Quisque vel magna mollis, euismod mi id, fermentum nibh</li>
            <li>Duis vitae sem dapibus, vulputate arcu vitae, egestas diam.</li>
            <li>Quisque sagittis nulla a bibendum scelerisque.</li>
            <li>Suspendisse dictum ante quis nisi maximus, non dictum turpis tempus.</li>
            <li>Donec id dolor tincidunt nisi sollicitudin posuere</li>
        </ul>
        <h2>Mas contenido</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas finibus facilisis urna non pulvinar. Etiam ex enim, porttitor vel fringilla sed, convallis dictum felis. Proin ac nulla vel eros iaculis porta. Nam ut erat scelerisque, suscipit
            nisi nec, dapibus tortor. Ut posuere mi in scelerisque malesuada. Suspendisse eget neque consequat lectus auctor vehicula. Ut eget erat at odio pretium pellentesque consequat vitae quam. Aliquam faucibus lorem non felis porttitor ultricies.
            Cras ornare pharetra varius. Sed tempor dapibus cursus. Donec justo erat, cursus quis est eget, ultrices faucibus eros. Nam malesuada nunc vel congue tincidunt.</p>
    </div>

    <footer class="foot">
        <div class="container text-center" style="color: #fff">
            <h5>Visitanos en</h5>
            <ul class="list-inline" id="socialMediaMini">
                <li class="list-inline-item">
                    <a href="#">
                        <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
                                </span>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <span class="fa-stack fa-lg">
                                  <i class="fa fa-circle fa-stack-2x"></i>
                                  <i class="fa fa-globe fa-stack-1x fa-inverse"></i></i>
                                </span>
                    </a>
                </li>
                <li class="list-inline-item">
                    <a href="#">
                        <span class="fa-stack fa-lg">
                            <i class="fa fa-circle fa-stack-2x"></i>
                            <i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
                        </span>
                    </a>
                </li>
            </ul>

            <h6 style="margin-top: 30px;">© 2017 - 2018 | Jobbers - Todos los derechos reservados</h6>
        </div>
    </footer>

</body>

</html>';

$titulo = 'Prueba de html en el mail';
$para = 'ortizkendry95@gmail.com';

$cabeceras = 'MIME-Version: 1.0' . "\r\n";
$cabeceras .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$cabeceras .= 'From: Jobbers Argentina <administracion@jobbers.com>';

/*$enviado = mail($para, $titulo, $contenido, $cabeceras);
 
if ($enviado)
  echo 'Email enviado correctamente';
else
  echo 'Error en el envío del email';*/

  $mail = new PHPMailer;

  //$mail->SMTPDebug = 3;                               // Enable verbose debug output

  $mail->isSMTP();                                      // Set mailer to use SMTP
  $mail->Host = 'smtp.1and1.com';  // Specify main and backup SMTP servers
  $mail->SMTPAuth = true;                               // Enable SMTP authentication
  $mail->Username = 'empleos@jobbersargentina.com';                 // SMTP username
  $mail->Password = 'Paviliong5+';                           // SMTP password
  $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
  $mail->Port = 25;                                    // TCP port to connect to

  $mail->setFrom('administracion@jobbers.com', 'Jobbers Argentina');
  $mail->addAddress('ortizkendry95@gmail.com', 'Kendry Ortiz');     // Add a recipient
  $mail->addAddress('ingvictorfernandezs@gmail.com', 'Victor Fernandez');     // Add a recipient

  $mail->isHTML(true);                                  // Set email format to HTML

  $mail->Subject = $titulo;
  $mail->Body    = $contenido;
  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

  if(!$mail->send()) {
      echo 'Message could not be sent.';
      echo 'Mailer Error: ' . $mail->ErrorInfo;
  } else {
      echo 'Message has been sent';
  }


?>
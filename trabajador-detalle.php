<?php
session_start();
require_once 'classes/DatabasePDOInstance.function.php';
require_once 'slug.function.php';

$db = DatabasePDOInstance();

$t = isset($_REQUEST["t"]) ? $_REQUEST["t"] : false;

$postulado = array();

if ($t) {
    $t = array_pop(explode("-", $t));
    if ($_SESSION['ctc']['type'] == 1) {
        $id_empresa = $_SESSION['ctc']['id'];
        $postulado  = $db->getAll("SELECT * FROM postulaciones pos INNER JOIN publicaciones pub ON pos.id_publicacion = pub.id_empresa WHERE pub.id_empresa = $id_empresa AND pos.id_trabajador = $t");
    }
}

$trabajador = $db->getRow("
        SELECT
            tra.uid,
            tra.nombres,
            tra.apellidos,
            tra.numero_documento_identificacion,
            tra.cuil,
            tra.calle,
            CONCAT(
                img.directorio,
                '/',
                img.nombre,
                '.',
                img.extension
            ) AS imagen,
            tra.telefono,
            tra.telefono_alternativo,
            tra.fecha_nacimiento,
            tra.calificacion_general,
            tra.sitio_web,
            tra.facebook,
            tra.twitter,
            tra.instagram,
            tra.snapchat,
            tra.linkedin,
            tra.id_pais,
            tra.correo_electronico,
            tra.publico,
            localidades.localidad,
            provincias.provincia,
            paises.nombre AS pais
        FROM
            trabajadores AS tra
        LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
        INNER JOIN paises ON paises.id = tra.id_pais INNER JOIN localidades ON localidades.id = tra.localidad INNER JOIN provincias ON provincias.id = tra.provincia
        WHERE tra.id = $t
    ");

$experiencias = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id_trabajador = " . $t . " ORDER BY trabajadores_experiencia_laboral.ano_egreso DESC, trabajadores_experiencia_laboral.mes_egreso DESC");

$educacion = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=$t");

$idiomas = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=$t");

$otros_conocimientos = $db->getAll("SELECT * FROM trabajadores_otros_conocimientos WHERE id_trabajador=$t");

if (!$trabajador["imagen"]) {
    $trabajador["imagen"] = "avatars/user.png";
}

$uid      = $db->getOne("SELECT uid FROM trabajadores WHERE id=$t");
$empresas = $db->getAll("
        SELECT empresas.id, empresas.nombre AS nombre_empresa,
        CONCAT(
            imagenes.directorio,
            '/',
            imagenes.nombre,
            '.',
            imagenes.extension
        ) AS imagen,
        actividades_empresa.nombre AS actividad
        FROM empresas_chat
        INNER JOIN empresas ON empresas.id=empresas_chat.uid_usuario1
        LEFT JOIN imagenes ON imagenes.id=empresas.id_imagen
        LEFT JOIN actividades_empresa ON actividades_empresa.id=empresas.id_actividad
        WHERE empresas_chat.uid_usuario2=$uid GROUP BY empresas.id

    ");


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
        <title>JOBBERS - <?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></title>
        <?php require_once 'includes/libs-css.php';?>
        <link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">

        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <script>
          (adsbygoogle = window.adsbygoogle || []).push({
            google_ad_client: "ca-pub-1968505410020323",
            enable_page_level_ads: true
          });
        </script>
    </head>
    <body class="large-sidebar fixed-sidebar fixed-header skin-5">
        <!-- <div class="wrapper" style="background-color: white;"> -->

            <!-- Sidebar second -->
            <?php require_once('includes/sidebar-second.php'); ?>

            <!-- Header -->
            <?php require_once 'includes/header.php';?>
            
            <div class="site-content bg-white" style="margin-left: 0px;">
                <!-- Content -->
                <div class="container-fluid">
                <?php if ($_SESSION['ctc']['type'] == 1):
 					$grid = "col-md-9";
 					require_once('includes/sidebar.php');
					else:
 					$grid = "container";
 				?>
                <?php endif?>
                    <div class="<?php echo $grid ?>">
                        <ol class="breadcrumb no-bg m-b-1 m-t-1" style="margin-top: 20px;">
                            <li class="breadcrumb-item"><a href="./">JOBBERS</a></li>
                            <li class="breadcrumb-item"><a href="trabajadores.php">Trabajadores</a></li>
                            <li class="breadcrumb-item active"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></li>
                        </ol>
                        <div style="margin-top: 20px;">

                            <!-- Seccion FOTO -->
                            <div class="col-sm-4 col-md-4 no-padding-lat">
                                <div class="content-perfil profile-card" style="margin-top: 0px; padding-bottom: 0px; padding-top: 0px;">
                                    <div class="profile-avatar" style="text-align: center; background-color: #E4E6E3; margin-top: 0px; padding-top: 40px; padding-bottom: 40px;">
                                        <img src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="width: 130px; margin-bottom: 10px;">
                                        <!-- <button type="button" class="col-md-12 btn btn-outline-primary btn-rounded waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Contactar
                                        </button> -->
                                        <!-- <h4 style="padding-bottom: 20px; text-align: center; margin-bottom: 0px;"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></h4> -->
                                    </div>
                                    <div class="card-block" style="background-color: #E4E6E3;">
                                        <ul class="list-group" style="margin-bottom: 0px;">
                                        <li class="list-group-item item-profile" style="border-radius: 0px; background-color:#2E358D;">
                                            <span class="fa-stack fa-lg icon-item-profile">
                                            <i class="fa fa-square-o fa-stack-2x"></i>
                                            <i class="fa fa-user fa-stack-1x"></i>
                                            </span>
                                            <span class="info-item-profile" style="text-transform: uppercase" id="labelCalle"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></span>
                                        </li>

                                        <li class="list-group-item item-profile" style="border-radius: 0px; background-color:#2043a0;">
                                            <span class="fa-stack fa-lg icon-item-profile">
                                            <i class="fa fa-square-o fa-stack-2x"></i>
                                            <i class="fa fa-map-marker fa-stack-1x"></i>
                                            </span>
                                            <span class="info-item-profile" id="labelCalle"><?php echo $trabajador["calle"]; ?></span>
                                        </li>

                                        <li class="list-group-item item-profile" style="background-color: #235AD1">
                                            <span class="fa-stack fa-lg icon-item-profile">
                                            <i class="fa fa-square-o fa-stack-2x"></i>
                                            <i class="fa fa-phone fa-stack-1x"></i>
                                            </span>
                                            <span class="info-item-profile" id="labelTlf"><?php echo $trabajador["telefono"] . $trabajador["telefono_alternativo"] = !"" ? " / " . $trabajador["telefono_alternativo"] : ''; ?></span>
                                        </li>

                                        <li class="list-group-item item-profile" style="background-color: #2393D2; border-radius: 0px;">
                                            <span class="fa-stack fa-lg icon-item-profile">
                                            <i class="fa fa-square-o fa-stack-2x"></i>
                                            <i class="fa fa-envelope fa-stack-1x" style="bottom: 2px;"></i>
                                            </span>
                                            <span class="info-item-profile" id="labelEmail"><?php echo $trabajador["correo_electronico"]; ?></span>
                                        </li>
                                        </ul>
                                        <?php if(isset($_SESSION["ctc"])): ?>
                                                <?php if($_SESSION["ctc"]["type"] != 2): ?>
                                                    <?php if ($trabajador["telefono"] != ""): ?>
                                                    <div style="padding-bottom: 20px;">
                                                        <div class="btn-group " role="group" style="margin-top: 20px; width: 100%">
                                                            <button type="button" class="btn btn-outline-primary btn-block btn-rounded waves-effect dropdown-toggle contact-btn" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 100%">
                                                                Contactar
                                                            </button>
                                                            <div class="dropdown-menu col-md-12">
                                                                <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#contactPhone"><span class="ti-mobile" style="margin-right: 3px;"></span> Whatsapp</a>
                                                                <a class="dropdown-item" href="javascript:void(0)"  id="contact" data-toggle="modal" data-target="#contactM"><span class="ti-comments" style="margin-right: 3px;"></span> Chat / Correo</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php else: ?>
                                                        <button type="button" class="btn btn-primary btn-block btn-rounded waves-effect contact-btn" id="contact" data-toggle="modal" data-target="#contactM" style="width: 100%">Contactar</button>
                                                    <?php endif ?>
                                                <?php endif ?>
                                            <?php endif ?>


                                            
                                            <?php if (($_SESSION['ctc']['type'] == 1 && $trabajador['publico'] == 1) || ($_SESSION['ctc']['type'] == 2) || count($postulado) > 0): ?>

                                                <?php if (isset($_SESSION["ctc"])): ?>
                                                    <a class="btn btn-outline-primary btn-block btn-rounded waves-effect contact-btn" style="margin-top: 10px;" href="vendor/tcpdf/pdf/curriculum.php?i=<?php echo $t; ?>" target="_blank"><span class="fa fa-download" style="margin-right: 3px;"></span> Descargar currículum</a>
                                                <?php endif?>
                                        <?php endif;?>
                                    </div>

                                    <div class="empresas" style="background-color: #e4e6e3; padding: 20px 10px; margin-top: 3px;">
                                        <h5 style="text-align: left; margin-top: 0px;">EMPRESAS QUE LO HAN CONTACTADO</h5>
                                        <?php $i = 1;if ($empresas): ?>
                                            <?php foreach ($empresas as $e): ?>
                                                <?php if ($i <= 5): ?>
                                                    <div class="il-item">
                                                        <a class="text-black" href="empresa/perfil.php?e=<?php echo strtolower(str_replace(" ", "-", $e["nombre_empresa"])) . "-$e[id]"; ?>">
                                                            <div class="media">
                                                                <div class="media-left">
                                                                    <div class="avatar box-48">
                                                                        <img class="b-a-radius-circle" src="empresa/img/<?php echo !$e["imagen"] ? "avatars/user.png" : $e["imagen"]; ?>" alt="">
                                                                        <i class="status bg-success bottom right"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="media-body">
                                                                    <h6 class="media-heading"><?php echo $e["nombre_empresa"]; ?></h6>
                                                                    <span class="text-muted"><?php echo $e["actividad"] ? $e["actividad"] : 'Sin definir'; ?></span>
                                                                </div>
                                                            </div>
                                                            <div class="il-icon"><i class="fa fa-angle-right"></i></div>
                                                        </a>
                                                    </div>
                                                <?php endif?>
                                            <?php $i++;endforeach?>
                                        <?php endif?>
                                    </div>

                                    <!--Estilos estrellas de ranking-->
                                <style type="text/css">
                                    .rating {
                                          overflow: hidden;
                                          vertical-align: bottom;
                                          display: inline-block;
                                          width: auto;
                                          height: 20px;
                                        }

                                        .rating > input {
                                          opacity: 0; 
                                        }

                                        .rating > label {
                                          position: relative;
                                          display: block;
                                          float: right;
                                          background: url('img/star-off-big.png');
                                          background-size: 20px 20px; 
                                        }

                                        .rating > label:before {
                                          display: block;
                                          opacity: 0;
                                          content: '';
                                          width: 20px;
                                          height: 20px;
                                          background: url('img/star-on-big.png');
                                          background-size: 20px 20px;
                                          transition: opacity 0.2s linear;
                                          cursor: pointer;
                                        }

                                        .rating > label:hover:before,  .rating > label:hover ~ label:before,  .rating:not(:hover) > :checked ~ label:before { opacity: 1; }                                        
 
                                </style>

                                <?php if($_SESSION["ctc"]["type"]==1){?>
                                <div class="jobbers" style="background-color: #e4e6e3; padding: 20px 10px; margin-top: 3px;">
                                    <h5 style="text-align: left; margin-top: 0px;">GESTIONAR JOBBER</h5>
                                    <div style="padding-top: 15px;">

                                         <label><strong>Calificar</strong></label><br/>
                                            <span class="rating" style="margin-left: -80px;">
                                             
                                              <input id="rating5" type="radio" name="rating" value="5" onClick="calificar(this.value,<?php echo  $_SESSION['ctc']['id'];?>,<?php echo $_GET['t']?>,<?php echo $_GET['pubid']?>)">
                                              <label for="rating5">15</label>

                                              <input id="rating4" type="radio" name="rating" value="4"  onClick="calificar(this.value,<?php echo $_SESSION['ctc']['id'];?>,<?php echo $_GET['t']?>,<?php echo $_GET['pubid']?>)">
                                              <label for="rating4">54</label>  

                                              <input id="rating3" type="radio" name="rating" value="3"  onClick="calificar(this.value,<?php echo $_SESSION['ctc']['id'];?>,<?php echo $_GET['t']?>,<?php echo $_GET['pubid']?>)">
                                              <label for="rating3">3</label>
                                              <input id="rating2" type="radio" name="rating" value="2"  onClick="calificar(this.value,<?php echo $_SESSION['ctc']['id'];?>,<?php echo $_GET['t']?>,<?php echo $_GET['pubid']?>)">
                                              <label for="rating2">2</label>
                                              <input id="rating1" type="radio" name="rating" value="1"  onClick="calificar(this.value,<?php echo $_SESSION['ctc']['id'];?>,<?php echo $_GET['t']?>,<?php echo $_GET['pubid']?>)">
                                              <label for="rating1">1</label>
                                            </span>
                                        </div> 

                                       
                                        <div style="padding-top: 15px;">
                                       
                                            <label><strong>Marcador</strong></label><br/>
                                            <select id="marcador" onChange="marcar(this.value,<?php echo $_SESSION['ctc']['id'];?>,<?php echo $_GET['t']?>,<?php echo $_GET['pubid']?>)" class="form-control">
                                                <option value="">Marcador</option>
                                                <option value="0">Descartar</option>
                                                <option value="1">Contactado</option>
                                                <option value="2">En proceso</option>
                                                <option value="3">Evaluado</option>
                                                <option value="4">Finalista</option>
                                                <option value="5">Contratado</option>
                                            </select>
                                             
                                        </div>
                                        <br> 
                                        <button onClick="window.close()" type="buttom" class="btn btn-xs btn-danger form-control">Ver mas jobbers</button>

                                </div>
                                <?php } ?>

                                </div>

                                <!-- <div class="panel panel-default panel-m30">
                                        <div class="panel-heading">Contacto</div>
                                        <div class="panel-body text-center">
                                            
                                        </div>
                                    </div> -->

                                
                                <!-- <?php if($_SESSION["ctc"]["type"]==1){?>
                                <div class="panel panel-default panel-m30">
                                    <div class="panel-heading"><b>Gestionar Jobber</b></div>
                                    <div class="panel-body items-list text-center"> 
                                                                             
                                    </div>
                                </div>
                                <div class="col-xs-12" style="padding: 0px;">
                                    <button onClick="window.close()" type="buttom" class="btn btn-xs btn-danger form-control">Ver mas jobbers</button>
                                </div>
<br/>
                                 <?php }?>
                                <div class="panel panel-default panel-m30">
                                    <div class="panel-heading"><b>Empresas que lo han contactado</b></div>
                                    <div class="panel-body items-list">
                                        
                                    </div>


                                    <div class="card-block">

                                            <?php if (count($empresas) > 5): ?>
                                                <button type="button" id="showMore" class="btn btn-primary btn-block">Ver más</button>
                                            <?php endif;?>
                                    </div>

                                </div>-->
                            </div> 


                            <!-- Seccion INFORMACION -->
                            <div class="col-sm-8 col-md-8 no-padding-lat">
                                    
                                    <div class="tab-content">
                                        <?php
                                            $idTrab = '';
                                            if (isset($_REQUEST['t'])) {
                                                $detTrab = explode("-", $_REQUEST["t"]);
                                                $idTrab = array_pop($detTrab);
                                            }
                                        ?>
                                        <div class="col-md-12 tab-pane card-block active content-perfil" id="curriculum" role="tabpanel" style="padding-right: 0px; padding-left:0px; padding-top: 0px;">
                                            <!-- <div class="row"> -->
                                            <div class="col-md-12" style="padding-right: 0px; padding-left: 0px;">
                                            <h4 class="title-cv" style="margin-top: 0px;">&nbsp INFORMACIÓN PERSONAL</h4>
                                                <p class="content-cv">
                                                    <!-- <strong>Nombres: </strong> <span id="labelName"><?php echo $trabajador["nombres"]; ?></span><br>
                                                    <strong>Apellidos: </strong> <span id="labelLastName"><?php echo $trabajador["apellidos"]; ?></span><br> -->
                                                    <?php if(isset($_SESSION['ctc']['empresa']) || $_SESSION['ctc']['id'] == $idTrab): ?>
                                                    <?php if(@$_SESSION['ctc']['plan']['id_plan'] > 1 || $_SESSION['ctc']['id'] == $idTrab): ?>
                                                    <strong>DNI: </strong> <span id="labelDNI"><?php echo $trabajador["numero_documento_identificacion"]; ?></span><br>
                                                    <strong>Numero de CUIL: </strong> <span id="labelCuil"><?php echo $trabajador["cuil"]; ?></span><br>
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                    <strong>Lugar de nacimiento: </strong> <span id="labelCountry"><?php echo $trabajador["localidad"] . ", " . $trabajador["provincia"] . ", " . $trabajador["pais"] ?></span><br>
                                                    <?php if(isset($_SESSION['ctc']['empresa'])): ?>
                                                    <?php if($_SESSION['ctc']['plan']['id_plan'] > 1): ?>
                                                    <!-- <strong>Dirección: </strong> <span id="labelCalle"><?php echo $trabajador["calle"]; ?></span><br> -->
                                                    <?php endif; ?>
                                                    <?php endif; ?>
                                                    <strong>Fecha de Nacimiento: </strong> <span id="fecha_nac"><?php echo $trabajador["fecha_nacimiento"] !== null ? date('Y-m-d', strtotime($trabajador["fecha_nacimiento"])) : ""; ?></span><br>
                                                    <strong>Edad: </strong> <span id="edad"><?php echo $trabajador["fecha_nacimiento"] !== null ? intval(date('Y')) - intval(date('Y', strtotime($trabajador["fecha_nacimiento"]))) . "años" : ""; ?></span><br>
                                                    <!-- <strong>Correo electrónico: </strong> <span id="labelEmail"><?php echo $trabajador["correo_electronico"]; ?></span><br> -->
                                                    <strong>Telefonos: </strong> <span id="labelTlf"><?php echo $trabajador["telefono"] . $trabajador["telefono_alternativo"] = !"" ? " / " . $trabajador["telefono_alternativo"] : ''; ?></span>
                                                </p>
                                                <h4 class="title-cv">&nbsp EXPERIENCIA LABORAL</h4>
                                                <div id="experiencias">
                                                    <?php $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");?>
                                                    <?php if ($experiencias): ?>
                                                    <?php foreach ($experiencias as $e): ?>

                                                    <?php $egreso = $e['trab_actualmt'] == 1 ? 'Actualmente' : $mes[$e["mes_egreso"] - 1] . "/" . $e["ano_egreso"] ?>
                                                    <p class="content-cv" style="margin-bottom: 20px;">
                                                        <strong>Empresa: </strong>
                                                        <?php echo $e["nombre_empresa"]; ?><br>
                                                        <strong>País: </strong>
                                                        <?php echo $e["nombre_pais"]; ?><br>
                                                        <strong>Actividad: </strong>
                                                        <?php echo $e["actividad_empresa"]; ?><br>
                                                        <strong>Tipo puesto: </strong>
                                                        <?php echo $e["tipo_puesto"]; ?><br>
                                                        <strong>Tiempo: </strong>
                                                        <?php echo $mes[$e["mes_ingreso"] - 1] . "/" . $e["ano_ingreso"] . " - " . $egreso ?><br>
                                                        <strong>Encargado de Referencias: </strong>
                                                        <?php echo $e["nombre_encargado"] == null ? "No Aplica" : $e["nombre_encargado"] ?><br>
                                                        <strong>Telefono del Encargado: </strong>
                                                        <?php echo $e["tlf_encargado"] == null ? "No Aplica" : $e["tlf_encargado"] ?> <br>
                                                        <strong>Descripción de tareas: </strong>
                                                        <span style="word-wrap: break-word;">
                                                            <?php echo $e["descripcion_tareas"] ?>
                                                        </span>
                                                    </p>
                                                    <?php endforeach?>
                                                    <?php else: ?>
                                                    <p class="content-cv" style="margin-bottom: 20px;"><em><b>"Sin Experiencia Laboral, pero con muchas ganas de aprender"</b></em></p>
                                                    <?php endif?>
                                                </div>


                                                <h4 class="title-cv">&nbsp Estudios</h4>
                                                <div id="educacion">
                                                    <?php if ($educacion): ?>
                                                    <?php foreach ($educacion as $e): ?>
                                                    <p class="content-cv" style="margin-bottom: 20px;">
                                                        <strong>Nivel estudio: </strong>
                                                        <?php echo $e["nivel"]; ?><br>
                                                        <strong>Título o Certificación: </strong>
                                                        <?php echo $e["titulo"] ?> <br>
                                                        <strong>País: </strong>
                                                        <?php echo $e["nombre_pais"]; ?><br>
                                                        <strong>Estado estudio: </strong>
                                                        <?php echo $e["estado_estudio"]; ?><br>
                                                        <strong>Área estudio: </strong>
                                                        <?php echo $e["nombre_estudio"]; ?><br>
                                                    </p>
                                                    <?php endforeach?>
                                                    <?php else: ?>
                                                    <p class="content-cv" style="margin-bottom: 20px;">Sin registros</p>
                                                    <?php endif?>
                                                </div>

                                                <h4 class="title-cv">&nbsp Idiomas</h4>
                                                <div id="idiomas">
                                                    <?php if ($idiomas): ?>
                                                    <?php foreach ($idiomas as $i): ?>
                                                    <?php $nivel_oral    = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]");?>
                                                    <?php $nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");?>
                                                    <p class="content-cv" style="margin-bottom: 20px;">
                                                        <strong>Idioma: </strong>
                                                        <?php echo $i["nombre_idioma"]; ?><br>
                                                        <strong>Nivel Oral: </strong>
                                                        <?php echo $nivel_oral; ?><br>
                                                        <strong>Nivel escrito: </strong>
                                                        <?php echo $nivel_escrito; ?><br>
                                                    </p>
                                                    <?php endforeach?>
                                                    <?php else: ?>
                                                    <p class="content-cv" style="margin-bottom: 20px;">Sin registros</p>
                                                    <?php endif?>
                                                </div>

                                                <h4 class="title-cv">&nbsp Otros conocimientos</h4>
                                                <div id="otros_conocimientos">
                                                    <?php if ($otros_conocimientos): ?>
                                                    <?php foreach ($otros_conocimientos as $o): ?>
                                                    <p class="content-cv" style="margin-bottom: 20px;">
                                                        <strong>Título: </strong>
                                                        <?php echo $o["nombre"]; ?><br>
                                                        <strong>Descripción: </strong>
                                                            <span style="word-wrap: break-word">
                                                                <?php echo $o["descripcion"]; ?>
                                                            </span>
                                                        <br>
                                                    </p>
                                                    <?php endforeach?>
                                                    <?php else: ?>
                                                    <p class="content-cv" style="margin-bottom: 20px;">Sin registros</p>
                                                    <?php endif?>
                                                </div>

                                                <?php $infoExtra = $db->getRow("SELECT * FROM trabajadores_infextra inner join disponibilidad on disponibilidad.id = trabajadores_infextra.disponibilidad WHERE id_trabajador=" . $t);?>

                                                <h4 class="title-cv">&nbsp Información Extra</h4>
                                                <div id="infoExtra">
                                                    <p class="content-cv" style="margin-bottom: 20px;">
                                                        <strong>Remuneración pretendida: </strong> $
                                                        <?=$infoExtra['remuneracion_pret']?> <br>
                                                            <strong>Disponibilidad: </strong>
                                                            <?=$infoExtra['nombre']?> <br>
                                                                <strong>Sobre mí: </strong>
                                                                <span style="word-wrap: break-word">
                                                                    <?=$infoExtra['sobre_mi']?>
                                                                </span>
                                                                <br>
                                                    </p>
                                                </div>
                                            </div>
                                            <!-- </div> -->
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php require_once 'includes/footer.php';?>
            </div>
        <!-- </div> -->

        <?php require_once 'includes/libs-js.php';?>

        <div class="modal fade" id="contactM" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Contacta al trabajador</h4>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="form-group">
                                <label for="messageText" class="form-control-label">Escribe tu mensaje:</label>
                                <textarea class="form-control" id="messageText"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="sendMesage">Enviar</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="contactPhone" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title">Contacta al trabajador</h4>
                    </div>
                    <div class="modal-body">
                        <p>Número de contacto: <a href="tel:<?php echo $trabajador["telefono"]; ?>"><?php echo $trabajador["telefono"]; ?></a></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var u1 = <?php echo isset($_SESSION["ctc"]["uid"]) ? $_SESSION["ctc"]["uid"] : 0; ?>;
            var u2 = <?php echo empty($trabajador["uid"]) ? 0 : $trabajador["uid"]; ?>;
            var empresa = <?php echo $_SESSION["ctc"]["type"] == 1 ? 1 : 0; ?>;
            var cant_c = <?php echo ($_SESSION["ctc"]["type"] == 1 ? $_SESSION["ctc"]["servicio"]["curriculos_disponibles"] : 0); ?>;
             $(function() {
                
                $("#sendMesage").click(function() {
                    var message = $("#messageText").val();
                    if(message != '') {
                        $.ajax({
                            type: 'GET',
                            url: 'empresa/ajax/chat.php',
                            dataType: 'json',
                            data: {
                                op: 5,
                                idc: u1,
                                idc2: u2,
                                msg: message
                            },
                            success: function (response) {
                                $("#messageText").val("");
                                $("#contactM").modal("hide");
                                if(response.msg == "OK") {
                                    swal({
                                        title: 'Operación exitosa!',
                                        text: 'Tu mensaje ha sido enviado satisfactoriamente.',
                                        confirmButtonClass: 'btn btn-primary btn-lg',
                                        buttonsStyling: false
                                    });
                                }
                            }
                        });
                    }
                });
            });
        </script>
        
        <?php echo  "<script>var id_user = ".$_GET['t']." ;</script>";?>
        <?php echo  "<script>var id_emp = ".$_SESSION['ctc']['id']." ;</script>";?>
        <?php echo  "<script>var id_pub = ".$_GET['pubid']." ;</script>";?>

        <script type="text/javascript">
        $( document ).ready(function() {
            setear_calificacion(id_user,id_emp,id_pub);
            setear_marcador(id_user,id_emp,id_pub);
        });

        function setear_calificacion(user,emp,id_pub)
        {   
             $.ajax({
                url : 'empresa/queries/ajax.php',
                data : { op : 11,empresa:emp,usuario:user,public:id_pub},
                type : 'POST',
                success : function(data) { 
                    if(data!=0)
                    {
                        $("#rating"+data).attr('checked', true);
                    }
                }, 
                error : function(xhr, status) {
                    alert('Disculpe, ocurrió un problema');
                },  
                  }); 
        }        
          function calificar(valor,emp,user,pub)
                {
                $.ajax({
                url : 'empresa/queries/ajax.php',
                data : { op : 1,empresa:emp,usuario:user,value:valor,public:pub},
                type : 'POST',
                success : function(data) {

                }, 
                error : function(xhr, status) {
                    alert('Disculpe, ocurrió un problema');
                },  
                  }); 
                }
             
              function marcar(valor,emp,user,pub)            
                { 

                   if(valor!="")
                   {
                     $.ajax({
                        url : 'empresa/queries/ajax.php',
                        data : { op : 2,empresa:emp,usuario:user,value:valor,public:pub},
                        type : 'POST',
                        success : function(data) {  
                        }, 
                        error : function(xhr, status) {
                            alert('Disculpe, ocurrió un problema');
                        },  
                          }); 
                   }
                }      
             function setear_marcador(user,emp,id_pub)
            {   
                 $.ajax({
                    url : 'empresa/queries/ajax.php',
                    data : { op : 22,empresa:emp,usuario:user,public:id_pub},
                    type : 'POST',
                    success : function(data) {  
                        if(data!=0)
                        {
                            $("#marcador").val(data);
                        }
                    }, 
                    error : function(xhr, status) {
                        alert('Disculpe, ocurrió un problema');
                    },  
                      }); 
            }   
        </script>
    </body>
</html>
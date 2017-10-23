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

$empleos = $db->getAll("
        SELECT publicaciones.titulo, empresas_contrataciones.*, empresas.nombre AS nombre_empresa, areas_sectores.nombre AS nombre_sector, areas.nombre AS nombre_area
        FROM empresas_contrataciones
        INNER JOIN empresas ON empresas.id=empresas_contrataciones.id_empresa
        INNER JOIN publicaciones ON publicaciones.id=empresas_contrataciones.id_publicacion
        INNER JOIN publicaciones_sectores ON publicaciones_sectores.id_publicacion=publicaciones.id
        INNER JOIN areas_sectores ON areas_sectores.id=publicaciones_sectores.id_sector
        INNER JOIN areas ON areas.id=areas_sectores.id_area
        WHERE empresas_contrataciones.id_trabajador=$t
    ");

/*$empresas =  $db->getAll("
SELECT empresas.id, empresas.nombre AS nombre_empresa,
CONCAT(
imagenes.directorio,
'/',
imagenes.nombre,
'.',
imagenes.extension
) AS imagen,
actividades_empresa.nombre AS actividad
FROM empresas_contrataciones
INNER JOIN empresas ON empresas.id=empresas_contrataciones.id_empresa
LEFT JOIN imagenes ON imagenes.id=empresas.id_imagen
LEFT JOIN actividades_empresa ON actividades_empresa.id=empresas.id_actividad
WHERE empresas_contrataciones.id_trabajador=$t GROUP BY empresas.id
");*/
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

$publicaciones = $db->getAll("
        SELECT
            trabajadores_publicaciones.*,
            areas_sectores.nombre,
            areas_sectores.amigable AS sector_amigable
        FROM trabajadores_publicaciones
        INNER JOIN trabajadores_areas_sectores ON trabajadores_areas_sectores.id_publicacion=trabajadores_publicaciones.id
        INNER JOIN areas_sectores ON areas_sectores.id=trabajadores_areas_sectores.id_sector
        WHERE trabajadores_publicaciones.id_trabajador=$t"
);

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
    </head>
    <body class="large-sidebar fixed-sidebar fixed-header skin-5">
        <div class="wrapper" style="background-color: white;">
            <!-- Sidebar -->
            <?php require_once 'includes/sidebar.php';?>

            <!-- Sidebar second -->
            <?php //require_once('includes/sidebar-second.php'); ?>

            <!-- Header -->
            <?php require_once 'includes/header.php';?>
            <div class="site-content bg-white">
                <!-- Content -->
                <div class="content-area p-b-1">
                    <div class="container-fluid">
                        <ol class="breadcrumb no-bg m-b-1 m-t-1">
                            <li class="breadcrumb-item"><a href="./">JOBBERS</a></li>
                            <li class="breadcrumb-item"><a href="trabajadores.php">Trabajadores</a></li>
                            <li class="breadcrumb-item active"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></li>
                        </ol>
                        <div class="row" style="margin-top: 15px;">
                            <div class="col-sm-4 col-md-3">
                                <div class="card profile-card" style="margin-top: 0px;">
                                    <div class="profile-avatar" style="text-align: center;margin-top: 15px;">
                                        <img src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="width: 130px;">
                                    </div>
                                    <div class="card-block" style="text-align: center;">
                                        <h4 style="margin-bottom: -5px;"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></h4>
                                        <div style="font-size: 28px;margin-bottom: 5px;">

                                        </div>
                                        <?php if ($trabajador["telefono"] != ""): ?>
                                            <div class="btn-group" role="group">
                                                <button type="button" class="btn btn-outline-primary btn-rounded waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    Contactar
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="javascript:void(0)" data-toggle="modal" data-target="#contactPhone"><span class="ti-mobile" style="margin-right: 3px;"></span> Whatsapp</a>
                                                    <a class="dropdown-item" href="javascript:void(0)"  id="contact" data-toggle="modal" data-target="#contactM"><span class="ti-comments" style="margin-right: 3px;"></span> Chat / Correo</a>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <button type="button" class="btn btn-primary btn-rounded waves-effect" id="contact" data-toggle="modal" data-target="#contactM">Contactar</button>
                                        <?php endif?>
                                        <?php if (($_SESSION['ctc']['type'] == 1 && $trabajador['publico'] == 1) || ($_SESSION['ctc']['type'] == 2) || count($postulado) > 0): ?>
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-outline-primary btn-rounded waves-effect dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Más
                                            </button>
                                            <div class="dropdown-menu">
                                                <?php if (isset($_SESSION["ctc"])): ?>
                                                    <a class="dropdown-item" href="javascript:void(0)" id="downloadC" data-href="vendor/tcpdf/pdf/curriculum.php?i=<?php echo $t; ?>"><span class="ti-download" style="margin-right: 3px;"></span> Descargar currículum</a>
                                                <?php endif?>
                                                <!--<a class="dropdown-item" href="#"><span style="margin-right: 3px;" class="ti-star"></span> Agregar a favoritos</a>-->
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </div>

                                    <?php if ($trabajador["sitio_web"] || $trabajador["facebook"] || $trabajador["twitter"] || $trabajador["instagram"] || $trabajador["snapchat"]): ?>
                                        <?php if ($trabajador["sitio_web"]): ?>
                                            <a class="list-group-item" href="<?php echo $trabajador["sitio_web"]; ?>">
                                                <i class="ti-world m-r-0-5"></i> <?php echo $trabajador["sitio_web"]; ?>
                                            </a>
                                        <?php endif?>

                                        <?php if ($trabajador["facebook"]): ?>
                                            <a class="list-group-item" href="<?php echo $trabajador["facebook"]; ?>">
                                                <i class="ti-facebook m-r-0-5"></i> <?php echo $trabajador["facebook"]; ?>
                                            </a>
                                        <?php endif?>

                                        <?php if ($trabajador["twitter"]): ?>
                                            <a class="list-group-item" href="<?php echo $trabajador["twitter"]; ?>">
                                                <i class="ti-twitter m-r-0-5"></i> <?php echo $trabajador["twitter"]; ?>
                                            </a>
                                        <?php endif?>

                                        <?php if ($trabajador["instagram"]): ?>
                                            <a class="list-group-item" href="<?php echo $trabajador["instagram"]; ?>">
                                                <i class="ti-instagram m-r-0-5"></i> <?php echo $trabajador["instagram"]; ?>
                                            </a>
                                        <?php endif?>

                                        <?php if ($trabajador["snapchat"]): ?>
                                            <a class="list-group-item" href="<?php echo $trabajador["snapchat"]; ?>">
                                                <i class="ion-social-snapchat m-r-0-5"></i> <?php echo $trabajador["snapchat"]; ?>
                                            </a>
                                        <?php endif?>

                                        <?php if ($trabajador["linkedin"]): ?>
                                            <a class="list-group-item" href="<?php echo $trabajador["linkedin"]; ?>">
                                                <i class="ti-linkedin m-r-0-5"></i> <?php echo $trabajador["linkedin"]; ?>
                                            </a>
                                        <?php endif?>
                                    <?php endif?>
                                </div>
                                <!--<div class="card">
                                    <div class="card-header text-uppercase"><b>Resumen del perfil</b></div>

                                </div>-->
                                <div class="card">
                                    <div class="card-header text-uppercase"><b>Empresas que lo han contactado</b></div>
                                    <div class="items-list">
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


                                    <div class="card-block">

                                            <?php if (count($empresas) > 5): ?>
                                                <button type="button" id="showMore" class="btn btn-primary btn-block">Ver más</button>
                                            <?php endif;?>
                                    </div>

                                </div>
                            </div>
                            <div class="col-sm-8 col-md-9">

                                <div class="card m-b-0">
                                    <ul class="nav nav-tabs nav-tabs-2 profile-tabs" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" data-toggle="tab" href="#publicaciones" role="tab">Servicios free lance</a>
                                        </li>
                                        <?php if (($_SESSION['ctc']['type'] == 1 && $trabajador['publico'] == 1) || ($_SESSION['ctc']['type'] == 2) || count($postulado) > 0): ?>
                                        <li class="nav-item">
                                            <a class="nav-link" data-toggle="tab" href="#curriculum" role="tab">Curriculum</a>
                                        </li>
                                        <?php endif;?>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane card-block active" id="publicaciones" role="tabpanel">
                                            <?php foreach ($publicaciones as $p): ?>
                                                <div class="pl-item">
                                                    <div class="media">
                                                        <div class="media-body">
                                                            <div class="pli-content">
                                                                <h5><a class="text-black" href="javascript:void(0)"><?php echo $p["titulo"]; ?></a></h5>
                                                                <p class="m-b-0-5"><?php echo $p["descripcion"]; ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach?>
                                        </div>
                                        <?php
                                            $idTrab = '';
                                            if (isset($_REQUEST['t'])) {
                                                $detTrab = explode("-", $_REQUEST["t"]);
                                                $idTrab = array_pop($detTrab);
                                            }
                                        ?>
                                        <div class="tab-pane card-block " id="curriculum" role="tabpanel">
                                            <div class="row">
                                                <div class="col-md-8">
                                                    <div class="row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-3">
                                                            <img src="img/<?php echo $trabajador["imagen"]; ?>" alt="" class="img-circle m-r-1" width="100" height="100">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <p>
                                                                <strong>Nombres: </strong> <span id="labelName"><?php echo $trabajador["nombres"]; ?></span><br>
                                                                <strong>Apellidos: </strong> <span id="labelLastName"><?php echo $trabajador["apellidos"]; ?></span><br>
                                                                <?php if(isset($_SESSION['ctc']['empresa']) || $_SESSION['ctc']['id'] == $idTrab): ?>
                                                                    <?php if(@$_SESSION['ctc']['plan']['id_plan'] > 1 || $_SESSION['ctc']['id'] == $idTrab): ?>
                                                                <strong>DNI: </strong> <span id="labelDNI"><?php echo $trabajador["numero_documento_identificacion"]; ?></span><br>
                                                                <strong>Numero de CUIL: </strong> <span id="labelCuil"><?php echo $trabajador["cuil"]; ?></span><br>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                                <strong>Lugar de nacimiento: </strong> <span id="labelCountry"><?php echo $trabajador["localidad"] . ", " . $trabajador["provincia"] . ", " . $trabajador["pais"] ?></span><br>
                                                                <?php if(isset($_SESSION['ctc']['empresa'])): ?>
                                                                    <?php if($_SESSION['ctc']['plan']['id_plan'] > 1): ?>
                                                                <strong>Dirección: </strong> <span id="labelCalle"><?php echo $trabajador["calle"]; ?></span><br>
                                                                   <?php endif; ?>
                                                                <?php endif; ?>
                                                                <strong>Fecha de Nacimiento: </strong> <span id="fecha_nac"><?php echo $trabajador["fecha_nacimiento"] !== null ? date('Y-m-d', strtotime($trabajador["fecha_nacimiento"])) : ""; ?></span><br>
                                                                <strong>Edad: </strong> <span id="edad"><?php echo $trabajador["fecha_nacimiento"] !== null ? intval(date('Y')) - intval(date('Y', strtotime($trabajador["fecha_nacimiento"]))) . "años" : ""; ?></span><br>
                                                                <strong>Correo electrónico: </strong> <span id="labelEmail"><?php echo $trabajador["correo_electronico"]; ?></span><br>
                                                                <strong>Telefonos: </strong> <span id="labelTlf"><?php echo $trabajador["telefono"] . $trabajador["telefono_alternativo"] = !"" ? " / " . $trabajador["telefono_alternativo"] : ''; ?></span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"></div>
                                            </div>
                                            <h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Experiencia laboral</h4>
                                            <div id="experiencias">
                                            <?php $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");?>
                                                <?php if ($experiencias): ?>
                                                    <?php foreach ($experiencias as $e): ?>
                                                        <p style="margin-left: 50px;">
                                                            <strong>Empresa: </strong> <?php echo $e["nombre_empresa"]; ?><br>
                                                            <strong>País: </strong> <?php echo $e["nombre_pais"]; ?><br>
                                                            <strong>Actividad: </strong> <?php echo $e["actividad_empresa"]; ?><br>
                                                            <strong>Tipo puesto: </strong> <?php echo $e["tipo_puesto"]; ?><br>
                                                            <strong>Tiempo: </strong> <?php echo $mes[$e["mes_ingreso"] - 1] . "/" . $e["ano_ingreso"] . " a " . $mes[$e["mes_egreso"] - 1] . "/" . $e["ano_egreso"] ?><br>
                                                            <strong>Encargado de Referencias: </strong> <?php echo $e["nombre_encargado"] == null ? "No Aplica" : $e["nombre_encargado"] ?><br>
                                                            <strong>Telefono del Encargado: </strong><?php echo $e["tlf_encargado"] == null ? "No Aplica" : $e["tlf_encargado"] ?> <br>
                                                            <strong>Descripción de tareas: </strong> <?php echo $e["descripcion_tareas"] ?>
                                                        </p>
                                                    <?php endforeach?>
                                                <?php else: ?>
                                                    <p style="margin-left: 50px;">Sin registros</p>
                                                <?php endif?>
                                            </div>

                                            <h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Estudios</h4>
                                            <div id="educacion">
                                                <?php if ($educacion): ?>
                                                    <?php foreach ($educacion as $e): ?>
                                                        <p style="margin-left: 50px;">
                                                            <strong>Nivel estudio: </strong> <?php echo $e["nivel"]; ?><br>
                                                            <strong>Título o Certificación: </strong> <?php echo $e["titulo"] ?> <br>
                                                            <strong>País: </strong> <?php echo $e["nombre_pais"]; ?><br>
                                                            <strong>Estado estudio: </strong> <?php echo $e["estado_estudio"]; ?><br>
                                                            <strong>Área estudio: </strong> <?php echo $e["nombre_estudio"]; ?><br>
                                                        </p>
                                                    <?php endforeach?>
                                                <?php else: ?>
                                                    <p style="margin-left: 50px;">Sin registros</p>
                                                <?php endif?>
                                            </div>

                                            <h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Idiomas</h4>
                                            <div id="idiomas">
                                                <?php if ($idiomas): ?>
                                                    <?php foreach ($idiomas as $i): ?>
                                                        <?php $nivel_oral    = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]");?>
                                                        <?php $nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");?>
                                                        <p style="margin-left: 50px;">
                                                            <strong>Idioma: </strong> <?php echo $i["nombre_idioma"]; ?><br>
                                                            <strong>Nivel Oral: </strong> <?php echo $nivel_oral; ?><br>
                                                            <strong>Nivel escrito: </strong> <?php echo $nivel_escrito; ?><br>
                                                        </p>
                                                    <?php endforeach?>
                                                <?php else: ?>
                                                    <p style="margin-left: 50px;">Sin registros</p>
                                                <?php endif?>
                                            </div>

                                            <h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Otros conocimientos</h4>
                                            <div id="otros_conocimientos">
                                                <?php if ($otros_conocimientos): ?>
                                                    <?php foreach ($otros_conocimientos as $o): ?>
                                                        <p style="margin-left: 50px;">
                                                            <strong>Título: </strong> <?php echo $o["nombre"]; ?><br>
                                                            <strong>Descripción: </strong> <?php echo $o["descripcion"]; ?><br>
                                                        </p>
                                                    <?php endforeach?>
                                                <?php else: ?>
                                                    <p style="margin-left: 50px;">Sin registros</p>
                                                <?php endif?>
                                            </div>

                                            <?php $infoExtra = $db->getRow("SELECT * FROM trabajadores_infextra WHERE id_trabajador=" . $t);?>

                                            <h4 style="border-bottom: 1px solid #3e70c9;margin-left: 25px;margin-right: 25px;margin-bottom: 25px;padding-bottom: 5px; width: 220px;">Información Extra</h4>
                                            <div id="infoExtra">
                                                <p style="margin-left: 50px;">
                                                    <strong>Remuneración pretendida: </strong> $<?=$infoExtra['remuneracion_pret']?> <br>
                                                    <strong>Sobre mí: </strong> <?=$infoExtra['sobre_mi']?> <br>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php require_once 'includes/footer.php';?>
            </div>
        </div>

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
                $("#downloadC").click(function() {
                    var band = true;
                    if(band) {
                        window.location.assign($(this).attr("data-href"));
                    }
                });
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

    </body>
</html>
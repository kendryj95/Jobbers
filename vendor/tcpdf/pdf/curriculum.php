<?php
session_start();
if (!isset($_SESSION["ctc"]["id"])) {
    header("Location: ./");
}
require_once '../../../classes/DatabasePDOInstance.function.php';
$db = DatabasePDOInstance();
$id = isset($_REQUEST['i']) ? $_REQUEST['i'] : false;

if ($_SESSION["ctc"]["type"] == 1) {
    //$_SESSION["ctc"]["servicio"]["curriculos_disponibles"] = intval($_SESSION["ctc"]["servicio"]["curriculos_disponibles"]) - 1;
    //$db->query("UPDATE empresas_servicios SET curriculos_disponibles='".$_SESSION["ctc"]["servicio"]["curriculos_disponibles"]."' WHERE id_empresa=".$_SESSION["ctc"]["id"]);
}

if ($id) {
    require_once 'tcpdf_include.php';

    $trabajador = $db->getRow("
        SELECT
                CONCAT(
                tra.nombres,
                ' ',
                tra.apellidos
                ) AS nombres,
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
                tra.fecha_nacimiento,
                TIMESTAMPDIFF(YEAR,tra.fecha_nacimiento,CURDATE()) AS edad,
                tra.calificacion_general,
                tra.sitio_web,
                tra.facebook,
                tra.twitter,
                tra.instagram,
                tra.snapchat,
                tra.id_pais,
                tra.correo_electronico,
                tra.telefono,
                tra.telefono_alternativo,
                localidades.localidad,
                provincias.provincia,
                paises.nombre AS pais
            FROM
                trabajadores AS tra
            LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
            INNER JOIN paises ON paises.id = tra.id_pais INNER JOIN localidades ON localidades.id = tra.localidad INNER JOIN provincias ON provincias.id = tra.provincia
            WHERE tra.id = $id
        ");
    $edad = "Sin registrar";
    if ($trabajador["fecha_nacimiento"] != "") {
        $edad = intval(date('Y')) - intval(date('Y', strtotime($trabajador["fecha_nacimiento"])));
        $edad = $edad . "años";
    }

    $experiencias = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id_trabajador=" . $id . " ORDER BY trabajadores_experiencia_laboral.ano_egreso DESC, trabajadores_experiencia_laboral.mes_egreso DESC");

    $educacion = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=$id");

    $idiomas = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=$id");

    $otros_conocimientos = $db->getAll("SELECT * FROM trabajadores_otros_conocimientos WHERE id_trabajador=$id");

    $infoExtra = $db->getRow("SELECT ti.*, d.nombre AS disponibilidad FROM trabajadores_infextra ti INNER JOIN disponibilidad d ON d.id = ti.disponibilidad WHERE id_trabajador=" . $id);

    if (!$trabajador["imagen"]) {
        $trabajador["imagen"] = "avatars/user.png";
    }

    $empleos = $db->getAll("
            SELECT empresas_contrataciones.*, empresas.nombre AS nombre_empresa, actividades_empresa.nombre AS actividad
            FROM empresas_contrataciones
            INNER JOIN empresas ON empresas.id=empresas_contrataciones.id_empresa
            INNER JOIN actividades_empresa ON actividades_empresa.id=empresas.id_actividad
            WHERE empresas_contrataciones.id_trabajador = $id
        ");

    $publicaciones = $db->getAll("SELECT * FROM trabajadores_publicaciones WHERE id_trabajador = $id");

    class MYPDF extends TCPDF
    {
        public function Header()
        {
            // Logo
            /*if($_SESSION["gps"]["pais"] == 1) {
            $name_file = 'logo_venezuela.png';
            }
            else {
            $name_file = 'logo_colombia.png';
            }
            $this->Image($name_file, 70, 5, 70, '', 'png', '', 'C', false, 300, '', false, false, 0, false, false, false);

            $this->Image('body.jpg', 45, 85, 170, 200, '', '', '', false, 0, '', false, false, 0, false, false, false);*/
            $this->Image('logo_d.png', 13, 257, 50, 20, '', '', '', false, 0, '', false, false, 0, false, false, false);
            $this->SetFont('helvetica', 'B', 20);
        }
        public function Footer()
        {
            /*if($_SESSION["gps"]["pais"] == 1) {
            $image_file = "footer_venezuela.png";
            }
            else {
            $image_file = "footer_colombia.png";
            }

            $this->Image($image_file, 0, 255, 215, '', 'png', '', 'T', false, 400, '', false, false, 0, false, false, false);*/

            $this->SetY(-15);
            $this->SetFont('helvetica', 'N', 7);
            $this->Cell(201, 21, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
        }
    }

    $pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    $pdf->SetCreator(PDF_CREATOR);

    $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');

    $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

    //$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);

    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

    if (@file_exists(dirname(__FILE__) . '/lang/spa.php')) {
        require_once dirname(__FILE__) . '/lang/spa.php';
        $pdf->setLanguageArray($l);
    }

    $pdf->AddPage();

    $pdf->setJPEGQuality(75);

    $html = '<table style="border-collapse: collapse">
    <tr style="border-bottom: 3px solid #00AEEF;">
        <td colspan="1">
            <div style="text-align: center">
                <img src="../../../img/'.$trabajador["imagen"].'" alt="Foto Usuario" style="width : 110px;
                height: 100px;
                border-radius: 50%;" />
                <div style="font-size: 22px; color: #2E3192"><b>'.$trabajador["nombres"].'</b></div>
            </div>
        </td>
        <td style="background-color: #bbbcc1" colspan="3">
        <sub>
            <ul style="list-style-type: none; padding-top: 20px;">
                <li style=" color: #2E358D;"><img src="../../../curriculum/001-contact.svg" alt="phone" width="20"><sup><span style="font-size: 14px; color: #fff"> &nbsp; Correo Electrónico</span></sup><sup><b> &nbsp; <h2 style="font-size: 16px">'.$trabajador["correo_electronico"].'</h2></b></sup></li>
                <li style=" color: #2E358D"><img src="../../../curriculum/003-house.svg" alt="email" width="20"><sup><span style="font-size: 14px; color: #fff"> &nbsp; Ubicación</span></sup><sup><b> &nbsp; <h2 style="font-size: 16px">'.$trabajador["pais"].'</h2> </b></sup></li>
                <li style=" color: #2E358D"><img src="../../../curriculum/002-phone-call.svg" alt="web" width="20"><sup><span style="font-size: 14px; color: #fff"> &nbsp; Teléfono</span></sup><sup><b> &nbsp; <h2 style="font-size: 16px">'.$trabajador["telefono"].'</h2></b></sup></li>
            </ul>
            </sub>
        </td>
    </tr>
    <tr style="border-bottom: 1px solid #848584;">
        <th style="max-width: 170px; padding-top: 40px; vertical-align:middle" colspan="4">
            <div style="
                font-size: 1.5em;
                text-align:center;
                color: rgb(46, 49, 146);
                background-color: rgb(206, 206, 206);
                padding: 5px;"><b>Información Personal</b></div>
        </th>
    </tr>';


    $idTrab = ''; 
    if (isset($_REQUEST['i'])) {
        $idTrab = $_REQUEST['i'];
    }

    $tlf_alternativo = $trabajador["telefono_alternativo"] != "" ? $trabajador["telefono_alternativo"] : 'Sin especificar';

    $dni = '';
    $cuil = '';
    $calle = '';

    if(isset($_SESSION['ctc']['empresa']) || $_SESSION['ctc']['id'] == $idTrab){ // DNI Y CUIL

       if(@$_SESSION['ctc']['plan']['id_plan'] > 1 || $_SESSION['ctc']['id'] == $idTrab){
            $dni = '<span style="color: #00AEEF; font-size: 18px">DNI: </span> <span>'.$trabajador["numero_documento_identificacion"].'</span><br />';
            $cuil = '<span style="color: #00AEEF; font-size: 18px">Numero de CUIL: </span> <span>'.$trabajador["cuil"].'</span><br />';
       } 
    }


    if(isset($_SESSION['ctc']['empresa']) || $_SESSION['ctc']['type'] == 2){ // DIRECCIÓN

       if(@$_SESSION['ctc']['plan']['id_plan'] > 1 || $_SESSION['ctc']['type'] == 2){
            $calle = '<span style="color: #00AEEF; font-size: 18px">Dirección: </span> <span> '.$trabajador["calle"].'</span>';
       } 
    }

    $html .= '<tr>
        <td style="padding-left: 30px; padding-top: 40px; padding-bottom: 40px;" colspan="2">
        <br />
                '.$dni.'
                '.$cuil.'
                <span style="color: #00AEEF; font-size: 18px">Lugar de nacimiento: </span> <span>'.$trabajador["pais"].'</span> <br />
                '.$calle.'
        </td>
        <td colspan="2">
        <br />
                <span style="color: #00AEEF; font-size: 18px">Fecha de nacimiento: </span> <span> '.$trabajador["fecha_nacimiento"].'</span><br />
                <span style="color: #00AEEF; font-size: 18px">Edad: </span> <span> '.$trabajador["edad"].' años</span><br />
                <span style="color: #00AEEF; font-size: 18px">Telefono Alternativo: </span> <span>'.$tlf_alternativo.'</span>
            
        </td>
    </tr>';

    $mes = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    if ($experiencias) {

        $html .= '<tr style="border-bottom: 1px solid #848584">
                    <th style="padding-top: 40px;padding-bottom: 40px" colspan="4">
                        <div style="
                            font-size: 1.5em;
                            text-align:center;
                            color: rgb(46, 49, 146);
                            background-color: rgb(206, 206, 206);
                            padding: 5px;"><b>Experiencia Laboral</b></div>
                    </th>
                </tr>';

        $i = 1;
        $j = 1;
        $cantExp = count($experiencias);
        $colspan = '';
        
        foreach ($experiencias as $e) {
            $encargado_ref = $e["nombre_encargado"] == null ? "No Aplica" : $e["nombre_encargado"];
            $tlf_encargado = $e["tlf_encargado"] == null ? "No Aplica" : $e["tlf_encargado"];
            $egreso = $e['trab_actualmt'] == 1 ? "Actualmente" : $mes[$e["mes_egreso"] - 1] . "/" . $e["ano_egreso"];

            if ($i === 1) {
                if ($j === $cantExp) { // ¿Es la última iteración?
                    $colspan = 'colspan="2"';
                }
                $html .= '<tr>';
            }

            $html .= '<td style="padding-left: 30px; padding-top: 40px; padding-bottom: 40px;" '.$colspan.'>
                        <br />
                                <span style="
                                font-size: 1.3em;
                                color: #2e3192;"><b>'.$e["nombre_empresa"].'</b></span>
                                <div>
                                <br />
                                    <span style="color: #00AEEF; font-size: 16px;">Pais:</span> '.$e["nombre_pais"].'<br />
                                    <span style="color: #00AEEF; font-size: 16px;">Actividad:</span> '.$e["actividad_empresa"].'<br />
                                    <span style="color: #00AEEF; font-size: 16px;">Tipo de Puesto:</span> ' . $e["tipo_puesto"] . '<br />
                                    <span style="color: #00AEEF; font-size: 16px;">Tiempo:</span> ' . $mes[$e["mes_ingreso"] - 1] . "/" . $e["ano_ingreso"] . " - " . $egreso . '<br />
                                    <span style="color: #00AEEF; font-size: 16px;">Encargado de Referencias:</span> ' . $encargado_ref . '<br />
                                    <span style="color: #00AEEF; font-size: 16px;">Telefono del encargado:</span> ' . $tlf_encargado . '<br />
                                    <span style="color: #00AEEF; font-size: 16px;">Descripcón de tareas:</span> ' . $e["descripcion_tareas"] . '
                                </div>
                           
                        </td>';


            if ($i === 2) {
                $html .= '</tr>';
                $i = 0;
            } elseif ($j === $cantExp) { // ¿Es la última iteración?
                $html .= '</tr>';
            }

            $i++;
            $j++;
        }
    } else {
        $html .= '<tr style="border-bottom: 1px solid #848584">
                    <th style="padding-top: 40px;padding-bottom: 40px" colspan="2">
                        <div style="
                            font-size: 1.5em;
                            text-align:center;
                            color: rgb(46, 49, 146);
                            background-color: rgb(206, 206, 206);
                            padding: 5px;"><b>Experiencia Laboral</b></div>
                    </th>
                </tr>';

        $html .= '<tr><td style="padding-left: 30px; padding-top: 40px; padding-bottom: 40px;" colspan="2">
                        <br />
                            <p style="text-align: center"><em><b>"Sin Experiencia Laboral, pero con muchas ganas de aprender"</b></em></p>
                  </td></tr>';

    }


    if ($educacion) {

        $html .= '<tr style="border-bottom: 1px solid #848584">
                    <td style="padding-top: 40px; padding-left: 30px; padding-bottom: 40px;" colspan="2">
                        <div style="
                            font-size: 1.5em;
                            text-align:center;
                            color: rgb(46, 49, 146);
                            background-color: rgb(206, 206, 206);
                            padding: 5px;"><b>Estudios</b></div>
                    </td>
                </tr>  ';

        $i = 1;
        $j = 1;
        $cantEdu = count($educacion);
        $colspan = '';

        foreach ($educacion as $e) {

            if ($i === 1) {
                if ($j === $cantEdu) { // ¿Es la última iteración?
                    $colspan = 'colspan="2"';
                }
                $html .= '<tr>';
            }

            $html .= '<td style="padding-left: 30px; padding-top: 40px; padding-bottom: 40px;" '.$colspan.'>
            
                        <br />
                                <span style="
                                font-size: 1.2em;
                                color: #2e3192;"><b>'.$j.'</b></span>
                                <span style="color: #00AEEF; font-size: 16px">Nivel de estudio: </span> <span>  ' . $e["nivel"] . '</span> <br />
                                <span style="color: #00AEEF; font-size: 16px">Título o certificación: </span> <span> ' . $e["titulo"] . '</span><br />
                                <span style="color: #00AEEF; font-size: 16px">País: </span> <span> ' . $e["nombre_pais"] . '</span><br />
                                <span style="color: #00AEEF; font-size: 16px">Estado estudio: </span> <span> ' . $e["estado_estudio"] . '</span><br />
                                <span style="color: #00AEEF; font-size: 16px">Área estudio: </span> <span> ' . $e["nombre_estudio"] . '</span>            
                    </td>';

            if ($i === 2) {
                $html .= '</tr>';
                $i = 0;
            } elseif ($j === $cantEdu) { // ¿Es la última iteración?
                $html .= '</tr>';
            }

            $i++;
            $j++;
        }
    }


    if ($idiomas) {

        $html .= '<tr style="border-bottom: 1px solid #848584">
                    <td colspan="2">
                        <div style="
                            font-size: 1.5em;
                            text-align:center;
                            color: rgb(46, 49, 146);
                            background-color: rgb(206, 206, 206);
                            padding: 5px;"><b>Idiomas</b></div>
                    </td>
                </tr>';

        $i = 1;
        $j = 1;
        $cantIdi = count($idiomas);
        $colspan = '';

        foreach ($idiomas as $id) {
            $nivel_oral    = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$id[nivel_oral]");
            $nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$id[nivel_escrito]");

            if ($i === 1) {
                if ($j === $cantIdi) { // ¿Es la última iteración?
                    $colspan = 'colspan="2"';
                }
                $html .= '<tr>';
            }

            $html .= '<td style="padding-left: 30px; padding-top: 40px; padding-bottom: 40px;" '.$colspan.'>
                        <br />
                        <span style="
                        font-size: 1.2em;
                        color: #2e3192;"><b>'.$j.'</b></span>
                        <span style="color: #00AEEF; font-size: 16px">Idioma: </span> <span> '.$id["nombre_idioma"].'</span><br />
                        <span style="color: #00AEEF; font-size: 16px">Nivel Oral: </span> <span> '.$nivel_oral.'</span><br />
                        <span style="color: #00AEEF; font-size: 16px">Nivel Escrito: </span> <span> '.$nivel_escrito.'</span>
                    </td>';

            if ($i === 2) {
                $html .= '</tr>';
                $i = 0;
            } elseif ($j === $cantIdi) { // ¿Es la última iteración?
                $html .= '</tr>';
            }

            $i++;
            $j++;
        }
    }


    if ($otros_conocimientos) {

        $html .= '<tr style="border-bottom: 1px solid #848584">
                    <td style="max-width: 190px; padding-top: 40px; padding-bottom: 40px;" colspan="2">
                        <div style="
                            font-size: 1.5em;
                            text-align:center;
                            color: rgb(46, 49, 146);
                            background-color: rgb(206, 206, 206);
                            padding: 5px;"><b>Otros Conocimientos</b></div>
                    </td>
                </tr>';

        $i = 1;
        $j = 1;
        $cantOtr = count($otros_conocimientos);
        $colspan = '';

        foreach ($otros_conocimientos as $o) {

            if ($i === 1) {
                if ($j === $cantOtr) { // ¿Es la última iteración?
                    $colspan = 'colspan="2"';
                }
                $html .= '<tr>';
            }

            $html .= '<td style="padding-left: 30px; padding-top: 40px; padding-bottom: 40px;" '.$colspan.'>
                        <br />
                        <span style="
                        font-size: 1.2em;
                        color: #2e3192;"><b>'.$j.'</b></span>
                        <span style="color: #00AEEF; font-size: 16px">Título: </span> <span> '.$o["nombre"].'</span><br />
                        <span style="color: #00AEEF; font-size: 16px">Descripción: </span>
                        <span style="margin: 0px;"> '.$o["descripcion"].'</span> 
                    </td>';

            if ($i === 2) {
                $html .= '</tr>';
                $i = 0;
            } elseif ($j === $cantOtr) { // ¿Es la última iteración?
                $html .= '</tr>';
            }

            $i++;
            $j++;
        }
    }

    
    if ($infoExtra) {

        $html .= '<tr>
                    <td style="padding-top: 40px;padding-bottom: 40px;" colspan="2">
                        <div style="
                            font-size: 1.5em;
                            text-align:center;
                            color: rgb(46, 49, 146);
                            background-color: rgb(206, 206, 206);
                            padding: 5px;"><b>Información Extra</b></div>
                    </td>
                </tr>';

        $html .= '<tr>    
                    <td style="padding-left: 30px; padding-top: 40px; padding-bottom: 40px;" colspan="2">
                        <br />
                        <span style="color: #00AEEF; font-size: 16px">Remuneración pretendida: </span> <span> $' . $infoExtra["remuneracion_pret"] . '</span><br />
                        <span style="color: #00AEEF; font-size: 16px">Disponibilidad: </span> <span> '. $infoExtra["disponibilidad"] . '</span><br />
                        <span style="color: #00AEEF; font-size: 16px">Sobre mí: </span> <span> ' . $infoExtra["sobre_mi"] . '</span>
                    </td>
                </tr>';

    }

    $html .= '</table>';

    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();

    $pdf_filename = $pdf->Output("curriculum_".strtolower(str_replace(" ", "_", $trabajador["nombres"])).".pdf", "I");
}

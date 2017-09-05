<?php
	session_start();
	if(!isset($_SESSION["ctc"]["id"])) {
		header("Location: ./");
	}
	require_once('../../../classes/DatabasePDOInstance.function.php');
	$db = DatabasePDOInstance();
	$id = isset($_REQUEST['i']) ? $_REQUEST['i'] : false;

	if($_SESSION["ctc"]["type"] == 1) {
		//$_SESSION["ctc"]["servicio"]["curriculos_disponibles"] = intval($_SESSION["ctc"]["servicio"]["curriculos_disponibles"]) - 1;
		//$db->query("UPDATE empresas_servicios SET curriculos_disponibles='".$_SESSION["ctc"]["servicio"]["curriculos_disponibles"]."' WHERE id_empresa=".$_SESSION["ctc"]["id"]);
	}
	
	if($id) {
		require_once('tcpdf_include.php');
		
		$trabajador = $db->getRow("
		SELECT
				tra.nombres,
				tra.apellidos,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen,
				tra.fecha_nacimiento,
				tra.calificacion_general,
				tra.sitio_web,
				tra.facebook,
				tra.twitter,
				tra.instagram,
				tra.snapchat,
				tra.id_pais,
				tra.correo_electronico,
				tra.telefono,
				tra.telefono_alternativo
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			WHERE tra.id = $id
		");
		$edad = "Sin registrar";
		if($trabajador["fecha_nacimiento"] != "") {
			$edad = intval(date('Y')) - intval(date('Y', strtotime($trabajador["fecha_nacimiento"])));
			$edad = $edad . "años";
		}

		$experiencias = $db->getAll("SELECT trabajadores_experiencia_laboral.*, paises.nombre as nombre_pais, actividades_empresa.nombre as actividad_empresa FROM trabajadores_experiencia_laboral INNER JOIN paises ON paises.id=trabajadores_experiencia_laboral.id_pais INNER JOIN actividades_empresa ON actividades_empresa.id=trabajadores_experiencia_laboral.id_actividad_empresa WHERE trabajadores_experiencia_laboral.id_trabajador = " . $id ." ORDER BY trabajadores_experiencia_laboral.ano_egreso DESC, trabajadores_experiencia_laboral.mes_egreso DESC");

		$educacion = $db->getAll("SELECT trabajadores_educacion.*, paises.nombre as nombre_pais, nivel_estudio.nombre as nivel, areas_estudio.nombre as nombre_estudio, estado_estudio.nombre as estado_estudio FROM trabajadores_educacion INNER JOIN paises ON paises.id=trabajadores_educacion.id_pais INNER JOIN nivel_estudio ON nivel_estudio.id=trabajadores_educacion.id_nivel_estudio INNER JOIN areas_estudio ON areas_estudio.id=trabajadores_educacion.id_area_estudio INNER JOIN estado_estudio ON estado_estudio.id=trabajadores_educacion.id_estado_estudio WHERE trabajadores_educacion.id_trabajador=$id");

		$idiomas = $db->getAll("SELECT trabajadores_idiomas.*, idiomas.nombre as nombre_idioma FROM trabajadores_idiomas INNER JOIN idiomas ON idiomas.id=trabajadores_idiomas.id_idioma WHERE trabajadores_idiomas.id_trabajador=$id");

		$otros_conocimientos = $db->getAll("SELECT * FROM trabajadores_otros_conocimientos WHERE id_trabajador=$id");

		if(!$trabajador["imagen"]) {
			$trabajador["imagen"] = "avatars/user.png";
		}
		
		$empleos =  $db->getAll("
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
				$this->Image('logo_d.png', 75, 115, 70, 25, '', '', '', false, 0, '', false, false, 0, false, false, false);
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
				$this->Cell(201, 21, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
			}
		}

		$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

		$pdf->SetCreator(PDF_CREATOR);

		$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
		
		$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

		$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

		//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
		$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
		$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

		$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

		$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

		if (@file_exists(dirname(__FILE__).'/lang/spa.php')) {
			require_once(dirname(__FILE__).'/lang/spa.php');
			$pdf->setLanguageArray($l);
		}
		
		$pdf->AddPage();

		$pdf->setJPEGQuality(75);
		
		$html = '<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold;"> CURRICULUM '.strtoupper("$trabajador[nombres] $trabajador[apellidos]").'</p><br><br>
		';
		
		/*$html .= '<table cellpadding="4" style="background-color: white; border: 1px solid #e5e5e5; font-size: 9px; line-height: 1.2; font-family: "Open Sans", Helvetica, Arial, sans-serif; font-size: 13px; font-weight: 400; width: 400px; line-height: 1.5; color: #666666; background-color: transparent; border-collapse: collapse; border-spacing: 0;">
			<tr style="background-color: #d9f1d5; color: #3f9532;">
				<th align="center" style="border-bottom: 1px solid #afe1a8;">Inico de parada</th>
				<th align="center" style="border-bottom: 1px solid #afe1a8;">Fin</th>
				<th align="center" style="border-bottom: 1px solid #afe1a8;">Tiempo</th>
				<th align="center" width="200px" style="border-bottom: 1px solid #afe1a8;">Ubicacion</th>
			</tr>
			';*/

		$tlf_alternativo = $trabajador["telefono_alternativo"] =! "" ? ' / ' . $trabajador["telefono_alternativo"] : '';	
		
		$html .= '<p></p><p></p>
			<table border="0">
				<tr>
					<td colspan="2">
						<b>Nombres: </b> <span id="labelName">'.$trabajador["nombres"].'</span><br>
						<b>Apellidos: </b> <span id="labelLastName">'.$trabajador["apellidos"].'</span><br>
						<b>Edad: </b> <span id="labelE">'.$edad.'</span><br>
						<b>Lugar de nacimiento: </b> <span id="labelCountry">'.($trabajador["id_pais"] != "" ? $db->getOne("SELECT nombre FROM paises WHERE id=$trabajador[id_pais]") : "Sin especificar").'</span><br>
						<b>Correo electrónico: </b> <span id="labelEmail">'.$trabajador["correo_electronico"].'</span><br>
						<b>Telefonos: </b> <span id="labelTlf">'.$trabajador["telefono"] . $tlf_alternativo . '</span><br>
						<a href="http://jobbersargentina.com/trabajador-detalle.php?t='.$trabajador["nombres"].'-'.$trabajador["apellidos"].'-'.$id.'">Visitar perfil</a><br>
						O copia y pega esto en tu navegador para visitar el perfil
						<strong>http://jobbersargentina.com/trabajador-detalle.php?t='.$trabajador["nombres"].'-'.$trabajador["apellidos"].'-'.$id.'</strong>
					</td>
					<td></td>
					<td>
						<img src="../../../img/'.$trabajador["imagen"].'" alt="" class="img-circle m-r-1" width="100" height="100">
					</td>
				</tr>
			</table>
		';

		if($educacion) {

			$html .= '<p></p><p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; border-bottom: 1px solid #3e70c9; "> ESTUDIOS </p><p></p>';

			foreach($educacion as $e) {
				$html .= '
					<p style="margin-left: 50px;">
						<strong>Nivel estudio: </strong> '.$e["nivel"].'<br>
						<strong>País: </strong> '.$e["nombre_pais"].'<br>
						<strong>Estado estudio: </strong> '.$e["estado_estudio"].'<br>
						<strong>Área estudio: </strong> '.$e["nombre_estudio"].'<br>
					</p>
				';
			}
		}

		if($empleos) {

			$html .= '<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; border-bottom: 1px solid #3e70c9; "> EXPERIENCIA LABORAL </p><p></p>';
		
			$html .= '<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; "> DENTRO DE LA PLATAFORMA </p><p></p>';
			foreach($empleos as $e) {
				$html .= '
					<br>
					<b>Empresa: </b> '.$e["nombre_empresa"].'<br>
					<b>Actividad:</b> '.$e["actividad"].'<br>
				';
			}
			
			if($experiencias) {
				$html .= '<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; "> AÑADIDO COMO EXPERIENCIA AL CURRICULUM </p><p></p>';
			}
		}

		$mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		
		if($experiencias) {
			if (!$empleos) {
				$html .= '<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; border-bottom: 1px solid #3e70c9; "> EXPERIENCIA LABORAL </p><p></p>';
			}
			 foreach($experiencias as $e) {
			 	$html .= '
					<br>
					<b>Empresa: </b> '.$e["nombre_empresa"].'<br>
					<b>País: </b> '.$e["nombre_pais"].'<br>
					<b>Actividad:</b> '.$e["actividad_empresa"].'<br>
					<b>Tipo puesto: </b> '.$e["tipo_puesto"].'<br>
					<b>Tiempo: </b> ' . $mes[$e["mes_ingreso"]-1] . "/" . $e["ano_ingreso"] . " a " . $mes[$e["mes_egreso"]-1] . "/" . $e["ano_egreso"] . '<br>
				';
			 }
		}

		if($idiomas) {

			$html .= '<p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; border-bottom: 1px solid #3e70c9; "> IDIOMAS </p><p></p>';
		
			foreach($idiomas as $i) {
				$nivel_oral = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_oral]");
				$nivel_escrito = $db->getOne("SELECT nombre FROM nivel_idioma WHERE id=$i[nivel_escrito]");
				$html .= '
					<br>
					<strong>Idioma: </strong> '.$i["nombre_idioma"].'<br>
					<strong>Nivel Oral: </strong> '.$nivel_oral.'<br>
					<strong>Nivel escrito: </strong> '.$nivel_escrito.'
					<br>
				';
			}
		}

		if($otros_conocimientos) {

			$html .= '<p></p><p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; border-bottom: 1px solid #3e70c9; "> OTROS CONOCIMIENTOS </p><p></p>';
		
			foreach($otros_conocimientos as $o) {
				$html .= '
					<br>
					<strong>Título: </strong> '.$o["nombre"].'<br>
					<strong>Descripción: </strong> '.$o["descripcion"].'
					<br>
				';
			}
		}

		if($publicaciones) {

			$html .= '<p></p><p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; border-bottom: 1px solid #3e70c9; "> SERVICIOS FREELANCE </p><p></p>';
			foreach($publicaciones as $p) {
				$html .= '
					<br>
					<strong>Título: </strong> '.$p["titulo"].'<br>
					<strong>Descripción: </strong> '.$p["descripcion"].'
					<br>
				';
			}
		}

 		$infoExtra = $db->getRow("SELECT * FROM trabajadores_infextra WHERE id_trabajador=". $_SESSION['ctc']['id']);

		if ($infoExtra){

			$html .= '<p></p><p align="center" style="font-family: Arial, Helvetica, sans-serif; font-size: 11pt; font-weight:bold; border-bottom: 1px solid #3e70c9; "> INFORMACIÓN EXTRA </p><p></p>';

			$html .= '
					<br>
					<strong>Remuneración Pretendida: </strong> $'.$infoExtra["remuneracion_pret"].'<br>
					<strong>Sobre mí: </strong> '.$infoExtra["sobre_mi"].'
					<br>
				';

		}


		$pdf->writeHTML($html, true, false, true, false, '');

		// reset pointer to the last page
		$pdf->lastPage();
		
		$pdf_filename = $pdf->Output("curriculum_$trabajador[nombres]_$trabajador[apellidos].pdf", "I"); 
	}
?>
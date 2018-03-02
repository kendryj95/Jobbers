<?php
	session_start();

	define('IVA', 1);
	define('PLANES', 2);
	define('SERVICIOS', 3);
	define('CAMBIAR_NOSOTROS', 4);
	define('CAMBIAR_POLITICAS', 5);
	define('CAMBIAR_CONTACTO', 6);
	define('CAMBIAR_REDES', 7);
	define('CAMBIAR_TERMINOS', 8);
	define('CAMBIAR_ADMLANDING', 9);
	define('CARGAR_PLANES_BENEFICIOS', 10);
	define('GUARDAR_BENEFICIOS', 11);
	define('DELETE_BENEFICIO', 12);
	define('DETALLES_BENEFICIO', 13);
	define('UPDATE_BENEFICIO', 14);

	require_once('../../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	if($op) {
		switch($op) {
			case IVA: 
				$exist = $db->getOne("SELECT id FROM configuraciones");
				if($exist) {
					$db->query("UPDATE configuraciones SET iva='$_REQUEST[iva]' WHERE id=1");
				}
				else {
					$db->query("INSERT INTO configuraciones (iva) VALUES ('$_REQUEST[iva]');");
				}
				echo json_encode(array("msg" => "OK"));
				break;
			case PLANES:
				$db->query("UPDATE planes SET precio='$_REQUEST[bronce]' WHERE id=2");
				$db->query("UPDATE planes SET precio='$_REQUEST[plata]' WHERE id=3");
				$db->query("UPDATE planes SET precio='$_REQUEST[oro]' WHERE id=4");
				echo json_encode(array("msg" => "OK"));
				break;
			case SERVICIOS:
				$db->query("UPDATE servicios SET precio='$_REQUEST[serv1]' WHERE id=1");
				$db->query("UPDATE planes SET precio='$_REQUEST[serv2]' WHERE id=2");
				$db->query("UPDATE planes SET precio='$_REQUEST[serv3]' WHERE id=3");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_NOSOTROS:
				$db->query("UPDATE plataforma SET nosotros='$_REQUEST[nosotros]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_POLITICAS:
				$db->query("UPDATE plataforma SET politicas='$_REQUEST[politicas]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_CONTACTO:
				$db->beginTransaction();
				try{
					$db->query("UPDATE plataforma SET correo_contacto='$_REQUEST[contacto]',telefono_contacto='$_REQUEST[telefono]',direccion_contacto='$_REQUEST[direccion]' WHERE id=1");
					$db->commitTransaction();
					echo json_encode(array("msg" => "OK"));
				}catch(Exception $e){
					$db->rollBackTransaction();
					echo json_encode(array("msg" => "Lo sentimos, ha ocurrido un error de conexión, por favor verifique su conexión a internet e intente de nuevo."));
				}
				break;
			case CAMBIAR_REDES:
				$db->query("UPDATE plataforma SET facebook='$_REQUEST[facebook]', instagram='$_REQUEST[instagram]', twitter='$_REQUEST[twitter]', youtube='$_REQUEST[youtube]', linkedin='$_REQUEST[linkedin]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_TERMINOS:
				$db->query("UPDATE plataforma SET terminos='$_REQUEST[terminos]' WHERE id=1");
				echo json_encode(array("msg" => "OK"));
				break;
			case CAMBIAR_ADMLANDING:
				$db->beginTransaction();
				try{
					$db->query("UPDATE plataforma SET section1_landing='$_REQUEST[section1]',section2_landing='$_REQUEST[section2]',section3_landing='$_REQUEST[section3]' WHERE id=1");
					$db->commitTransaction();
					echo json_encode(array("msg" => "OK"));
				}catch(Exception $e){
					$db->rollBackTransaction();
					echo json_encode(array("msg" => "Lo sentimos, ha ocurrido un error de conexión, por favor verifique su conexión a internet e intente de nuevo."));
				}
				break;
			case CARGAR_PLANES_BENEFICIOS:
				$beneficios["data"] = array();
				$datos = $db->getAll("SELECT pb.id, pb.beneficio, GROUP_CONCAT(p.nombre ORDER BY p.id SEPARATOR ',') AS planes_asignados FROM db678638694.planes_beneficios pb INNER JOIN db678638694.beneficios_per_plan bpp ON pb.id=bpp.id_beneficio INNER JOIN db678638694.planes p ON p.id=bpp.id_plan WHERE bpp.estatus=1 GROUP BY bpp.id_beneficio");

				if($datos) {
					foreach($datos as $k => $pub) {
						$beneficios["data"][] = array(
							$k + 1,
							$pub['beneficio'],
							$pub['planes_asignados'],
							'<div class="btn-group">
							  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							    <i class="glyphicon glyphicon-wrench"></i>
							  </button>
							  <ul class="dropdown-menu" style="left: -38px; min-width: 100px;">
							    <li><a href="javascript:void(0)" data-benef="'.$pub["id"].'" onClick="modBenef(this)"><i class="glyphicon glyphicon-pencil"></i> Editar</a></li>
							    <li><a href="javascript:void(0)" data-benef="'.$pub["id"].'" onClick="elimBenef(this)"><i class="glyphicon glyphicon-remove"></i> Eliminar</a></li>
							  </ul>
							</div>'
						);
					}
				}
				echo json_encode($beneficios);
				break;
			case GUARDAR_BENEFICIOS:

				$response = '';

				if ($_REQUEST['desc_beneficio'] && $_REQUEST['alias_gratis'] && $_REQUEST['alias_bronce'] && $_REQUEST['alias_plata'] && $_REQUEST['alias_oro'] && $_REQUEST['asig_planes']) {
					
					$db->beginTransaction();

					try {

						$db->query("INSERT INTO planes_beneficios(beneficio, alias_gratis, alias_bronce, alias_plata, alias_oro) VALUES ('".$_REQUEST["desc_beneficio"]."', '".$_REQUEST['alias_gratis']."', '".$_REQUEST['alias_bronce']."', '".$_REQUEST['alias_plata']."', '".$_REQUEST['alias_oro']."')");

						$lastID = $db->getInsertID();

						$sql = array();

						foreach ($_REQUEST['asig_planes'] as $plan) {
							$sql[] = "($plan, $lastID)";
						}

						$db->query("INSERT INTO beneficios_per_plan(id_plan, id_beneficio) VALUES " . implode(",", $sql));

						$db->commitTransaction();
						$response = 200;
					} catch (Exception $e){
						$db->rollBackTransaction();
						$response = 500;
					}
				} else {
					$response = 500;
				}

				echo json_encode(array(
					"data" => $response
				));

				break;
			case DELETE_BENEFICIO:
				$response = '';
				if ($_REQUEST['id_beneficio']) {
					
					$db->beginTransaction();

					try {
						$db->query("DELETE FROM planes_beneficios WHERE id=".$_REQUEST['id_beneficio']);
						$db->commitTransaction();
						$response = 200;
					} catch (Exception $e){
						$db->rollBackTransaction();
						$response = 500;
					}
				} else {
					$response = 500;
				}
				echo json_encode(array(
					"data" => $response
				));
				break;
			case DETALLES_BENEFICIO:
				if ($_REQUEST['id_beneficio']) {
					$datos = $db->getRow("SELECT pb.id, pb.beneficio, pb.alias_gratis, pb.alias_bronce, pb.alias_plata, pb.alias_oro, GROUP_CONCAT(CONCAT(p.id,'-',p.nombre) ORDER BY p.id SEPARATOR ',') AS planes_asignados FROM db678638694.planes_beneficios pb INNER JOIN db678638694.beneficios_per_plan bpp ON pb.id=bpp.id_beneficio INNER JOIN db678638694.planes p ON p.id=bpp.id_plan WHERE pb.id=$_REQUEST[id_beneficio] AND bpp.estatus=1 GROUP BY bpp.id_beneficio");

					echo json_encode(array(
						"status" => 200,
						"data" => $datos
					));
				} else {
					echo json_encode(array(
						"status" => 500
					));
				}
				break;
			case UPDATE_BENEFICIO:
				$response = '';

				if ($_REQUEST['desc_beneficio'] && $_REQUEST['alias_gratis'] && $_REQUEST['alias_bronce'] && $_REQUEST['alias_plata'] && $_REQUEST['alias_oro'] && $_REQUEST['asig_planes']) {
					
					$db->beginTransaction();

					try {

						$db->query("UPDATE planes_beneficios SET beneficio='".$_REQUEST["desc_beneficio"]."', alias_gratis='".$_REQUEST['alias_gratis']."', alias_bronce='".$_REQUEST['alias_bronce']."', alias_plata='".$_REQUEST['alias_plata']."', alias_oro='".$_REQUEST['alias_oro']."', updated_at=NOW() WHERE id=".$_REQUEST['id_beneficio']);

						$db->query("UPDATE beneficios_per_plan SET estatus=0 WHERE id_beneficio=$_REQUEST[id_beneficio]");

						$sql = array();

						foreach ($_REQUEST['asig_planes'] as $plan) {
							$sql[] = "($plan, $_REQUEST[id_beneficio])";
						}

						$db->query("INSERT INTO beneficios_per_plan(id_plan, id_beneficio) VALUES " . implode(",", $sql));

						$db->commitTransaction();
						$response = 200;
					} catch (PDOException $e){
						$db->rollBackTransaction();
						$response = 500;
					}
				} else {
					$response = 500;
				}

				echo json_encode(array(
					"data" => $response
				));
				break;
		}
	}
	function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
?>
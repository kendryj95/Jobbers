<?php
	session_start();

	define('CARGAR', 1);
	define('DETALLE', 2);
	define('MODIFICAR', 3);
	define('SUSPENDER', 4);
	define('VERIFICAR', 5);
	define('ELIMINAR', 6);

	require_once('../../classes/DatabasePDOInstance.function.php');

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	if($op) {
		switch($op) {
			case CARGAR:
				$noticias["data"] = array();
				$datos = $db->getAll("
					SELECT
						*
					FROM
						empresas ORDER BY suspendido DESC
				");

				if($datos) {
					$datos = array_reverse($datos);					
					foreach($datos as $k => $pub) {
						$plan = $db->getOne("SELECT planes.nombre FROM empresas_planes INNER JOIN planes ON planes.id = empresas_planes.id_plan WHERE empresas_planes.id_empresa = $pub[id]");
						$empSuspendida = $pub['suspendido'] == null || $pub['suspendido'] == 0 ? 0 : 1;
						$empSuspendidaClass = $empSuspendida == 1 ? 'btn-success' : 'btn-danger';
						$empSuspendidaTitle = $empSuspendida == 1 ? 'Desbloquear empresa' : 'Suspender empresa';
						$noticias["data"][] = array(
							$k + 1,
							$pub["nombre"],
							$plan,
							$plan,
							$pub["correo_electronico"],
							date('d/m/Y', strtotime($pub["fecha_creacion"])),
							'<div class="acciones-publicacion" data-target="' . $pub["id"] . '"> <button type="button" class="accion-publicacion btn btn-default waves-effect waves-light" onclick="empresaVerificada(this);" title="Verificar empresa"><span class="ti-thumb-up"></span></button><button type="button" class="accion-publicacion btn btn-primary waves-effect waves-light" onclick="modificarEmpresa(this);" title="Modificar plan"><span class="ti-pencil"></span></button><button type="button" class="accion-publicacion btn '. $empSuspendidaClass .' waves-effect waves-light" data-susp="'.$empSuspendida.'" title="'.$empSuspendidaTitle.'" onclick="suspenderEmpresa(this);"><span class="ti-power-off"></span></button><button type="button" class="accion-publicacion btn waves-effect waves-light" style="background: black; color: white;" title="Eliminar empresa" onclick="eliminarEmpresa(this);"><span class="ti-close"></span></button> </div>'
						);
					}
				}
				echo json_encode($noticias);
				break;
			case DETALLE:
				$info = $db->getRow("SELECT empresas.*, empresas_planes.*, empresas_servicios.*, planes.nombre AS nombre_plan, servicios.nombre AS nombre_servicio FROM empresas INNER JOIN empresas_planes ON empresas_planes.id_empresa=empresas.id INNER JOIN empresas_servicios ON empresas_servicios.id_empresa=empresas.id INNER JOIN planes ON planes.id=empresas_planes.id_plan INNER JOIN servicios ON servicios.id=empresas_servicios.id_servicio WHERE empresas.id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK", "data" => $info));
				break;
			case MODIFICAR:
				$plan = $db->getRow("SELECT * FROM planes WHERE id=$_REQUEST[plan]");
				$db->query("UPDATE empresas_planes SET id_plan=$_REQUEST[plan], fecha_plan='".date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d'))))."', logo_home=$plan[logo_home], link_empresa=$plan[link_empresa] WHERE id_empresa=$_REQUEST[i]");
				$servicio = $db->getRow("SELECT * FROM servicios WHERE id=$_REQUEST[servicio]");
				$db->query("UPDATE empresas_servicios SET id_servicio=$_REQUEST[servicio], fecha_servicio='".date('Y-m-d', strtotime('+1 month', strtotime(date('Y-m-d'))))."', curriculos_disponibles=$servicio[curriculos_disponibles], filtros_personalizados=$servicio[filtros_personalizados] WHERE id_empresa=$_REQUEST[i]");
				$db->query("INSERT INTO empresas_pagos (id_empresa, informacion, plan, servicio, fecha) VALUES ($_REQUEST[i], 'Pago de prueba realizado por el administrador', $_REQUEST[plan], $_REQUEST[servicio], '".date('Y-m-d')."')");
				echo json_encode(array("msg" => "OK"));
				break;
			case SUSPENDER:
				switch ($_REQUEST['susp']) {
					case 0:
						$db->query("UPDATE empresas SET suspendido=1 WHERE id=$_REQUEST[i]");
						break;
					
					default:
						$db->query("UPDATE empresas SET suspendido=0 WHERE id=$_REQUEST[i]");
						
						break;
				}
				echo json_encode(array("msg" => "OK"));
				
				break;
			case VERIFICAR:
				$db->query("UPDATE empresas SET verificado=1 WHERE id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK"));
				break;
			case ELIMINAR:
				$db->query("DELETE FROM empresas WHERE id=$_REQUEST[i]");
				echo json_encode(array("msg" => "OK"));
				break;
		}
	}
	function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
?>
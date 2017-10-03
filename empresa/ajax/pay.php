<?php
	session_start();

	define('ADD', 1);
	define('UPDATE', 2);
	
	require_once('../../classes/DatabasePDOInstance.function.php');
	require_once "../../vendor/mp/mercadopago.php";

	$mp = new MP("4579409850187892", "o8xeJmZi960OlaXUrb3Yo8ylOujVdU2W");

	$db = DatabasePDOInstance();

	$op = isset($_REQUEST["op"]) ? $_REQUEST["op"] : false;

	if($op) {
		switch($op) {
			case ADD:
				$iva = $db->getOne("SELECT iva FROM configuraciones WHERE id=1");
				if(!$iva) {
					$iva = 0;
				}
				$total = 0;
				$servicios = array();
				$plan = $db->getRow("SELECT nombre, precio FROM planes WHERE id=$_REQUEST[plan]");
				$total += floatval($plan["precio"]);
				
				$suttotal = $total * floatval($iva);
				try {
					$ex = "succesfull";
					$st = 1;
					$preference_data = array(
						"items" => array(
							array(
								"title" => "Pago servicios",
								"currency_id" => "ARS",
								"quantity" => 1,
								"unit_price" => ($total + $suttotal)
							)
						)
					);
					$preference = $mp->create_preference($preference_data);
				}
				catch(Exception $e) {
					$st = 2;
					$ex = $e->getMessage();
				}
				echo json_encode(array("status" => $st, "data" => $preference, "servicios" => $plan, "msg" => $ex, "iva" => $iva));
				break;
			case UPDATE:
				$info_plan = $db->getRow("SELECT * FROM planes WHERE id=$_REQUEST[plan]");
				$db->query("UPDATE empresas_planes SET id_plan='$info_plan[id]', fecha_plan='".date('Y-m-d')."', logo_home='$info_plan[logo_home]', link_empresa='$info_plan[link_empresa]' WHERE id_empresa=".$_SESSION["ctc"]["id"]);
				$serv = $_REQUEST["serv"] == 0 ? 4 : $_REQUEST["serv"];
				$info_serv = $db->getRow("SELECT * FROM servicios WHERE id=$serv");
				$db->query("UPDATE empresas_servicios SET id_servicio='$info_serv[id]', fecha_servicio='".date('Y-m-d')."', curriculos_disponibles='$info_serv[curriculos_disponibles]', filtros_personalizados='$info_serv[filtros_personalizados]' WHERE id_empresa=".$_SESSION["ctc"]["id"]);
				$_SESSION["ctc"]["plan"] = $info_plan;
				$_SESSION["ctc"]["servicio"] = $info_serv;
				
				$db->query("INSERT INTO empresas_pagos (id_empresa, informacion, plan, servicio, fecha) VALUES (".$_SESSION["ctc"]["id"].", '".(isset($_REQUEST["transaction"]) ? $_REQUEST["transaction"] : 'Plan gratis')."', $_REQUEST[plan], $serv, '".date('Y-m-d')."')");
				
				echo json_encode(array("status" => 1));
				break;
		}
	}
?>
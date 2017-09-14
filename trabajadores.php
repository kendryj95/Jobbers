<?php
	session_start();
	require_once('classes/DatabasePDOInstance.function.php');
	require_once('slug.function.php');

	$db = DatabasePDOInstance();

	$busquedaAvanzada = (isset($_REQUEST["accion"]) && $_REQUEST["accion"] == "busqueda") ? true : false;
	$palabrasClave = isset($_REQUEST["busqueda"]) ? $_REQUEST["busqueda"] : false;

	$filtroArea = isset($_REQUEST["area"]) ? $_REQUEST["area"] : false;
	$filtroSector = isset($_REQUEST["sector"]) ? $_REQUEST["sector"] : false;
	$filtroMomento = isset($_REQUEST["momento"]) ? $_REQUEST["momento"] : false;
	$filtroTipo = isset($_REQUEST["tipo"]) ? $_REQUEST["tipo"] : false;
	$filtroGenero = isset($_REQUEST["genero"]) ? $_REQUEST["genero"] : false;
	$filtroIdioma = isset($_REQUEST["idioma"]) ? $_REQUEST["idioma"] : false;
	$filtroLocalidades = isset($_REQUEST["localidad"]) ? $_REQUEST["localidad"] : false;
	$filtroProvincia = isset($_REQUEST["provincia"]) ? $_REQUEST["provincia"] : false;
	$filtroRemuneracion = isset($_REQUEST["remuneracion"]) ? $_REQUEST["remuneracion"] : false;

	$busqueda = isset($_REQUEST["busqueda"]) ? $_REQUEST["busqueda"] : false;

	$filtroActivado = $filtroArea || $filtroMomento || $filtroTipo || $filtroGenero || $filtroIdioma || $filtroLocalidades || $filtroProvincia || $filtroRemuneracion;

	$cantidadRegistros = 0;

	if($filtroActivado || ($busqueda || $busquedaAvanzada)) {
		$pagina = isset($_REQUEST["pagina"]) ? $_REQUEST["pagina"] : 1;
		$final = 5;
		$inicial = $final * ($pagina - 1);
	}

	function filtroMomento($cond) {
		$res = "";
		$filtroMomento = $GLOBALS["filtroMomento"];
        if($filtroMomento) {
			$infoMomento = $GLOBALS["infoMomento"];
            $res = "(TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])";
        }
		return $res;
	}

	function filtroTipo($cond) {
		$res = "";
		$filtroTipo = $GLOBALS["filtroTipo"];
		switch($filtroTipo) {
			case "nuevos":
				$res = $cond ? " AND " : " WHERE ";
				$res .= " (TIMESTAMPDIFF(MONTH, tra.fecha_creacion, CURDATE()) <= 3 AND ec.id_trabajador IS NULL)";
				break;
			case "contratados":
				$res = $cond ? " AND " : " WHERE ";
				$res .= " (ec.id_trabajador IS NOT NULL AND TIMESTAMPDIFF(MONTH, tra.fecha_creacion, CURDATE()) >= 3)";
				break;
		}
		return $res;
	}

	function filtroGenero($cond) {
		$res = "";
		$filtroGenero = $GLOBALS["filtroGenero"];
		switch($filtroGenero) {
			case "masculino":
				$res = $cond ? " AND " : " WHERE ";
				$res .= " (tra.id_sexo = 1)";
				break;
			case "femenino":
				$res = $cond ? " AND " : " WHERE ";
				$res .= " (tra.id_sexo = 2)";
				break;
		}
		return $res;
	}

	function filtroIdioma($cond) {
		$res = "";
		$filtroIdioma = $GLOBALS["filtroIdioma"];
		if($filtroIdioma) {
			$infoIdioma = $GLOBALS["infoIdioma"];
			$res = $cond ? " AND " : " WHERE ";
			#$res .= " (VERIFICAR_IDIOMA(tra.id, $infoIdioma[id]) = 1)";
			$res .= "ti.id_idioma = $infoIdioma[id]";
		}
		return $res;
	}

	function crearBreadcrumb() {
		$arr = array();
		
		$filtroActivado = $GLOBALS["filtroActivado"];
		
		$filtroArea = $GLOBALS["filtroArea"];
		$filtroMomento = $GLOBALS["filtroMomento"];
		$filtroTipo = $GLOBALS["filtroTipo"];
		$filtroGenero = $GLOBALS["filtroGenero"];
		$filtroIdioma = $GLOBALS["filtroIdioma"];
		$filtroLocalidades = $GLOBALS["filtroLocalidades"];
		$filtroProvincia = $GLOBALS["filtroProvincia"];
		$filtroRemuneracion = $GLOBALS["filtroRemuneracion"];
		
		$html = '<ol class="breadcrumb no-bg m-b-1">';
		$html .= '<li class="breadcrumb-item"><a href="./trabajadores.php">JOBBERS</a></li>';
		
		if($filtroArea) {
			$arr[] = array(
				"href" => crearURL(array( array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ), array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))),
				"text" => $GLOBALS["infoArea"]["nombre"]
			);			
		}
		
		if($filtroActivado) {
			if($filtroMomento || $filtroTipo || $filtroGenero || $filtroIdioma || $filtroLocalidades || $filtroProvincia || $filtroRemuneracion) {
				if($filtroMomento) {
					$arr[] = array(
						"href" => crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))),
						"text" => $GLOBALS["infoMomento"]["nombre"]
					);
				}
				if($filtroTipo) {
					$arr[] = array(
						"href" => crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))),
						"text" => $GLOBALS["infoTipo"]["nombre"]
					);
				}
				if($filtroGenero) {
					$arr[] = array(
						"href" => crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))),
						"text" => $GLOBALS["infoGenero"]["nombre"]
					);
				}
				if($filtroIdioma) {
					$arr[] = array(
						"href" => crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))),
						"text" => $GLOBALS["infoIdioma"]["nombre"]
					);
				}
				if ($filtroLocalidades) {
					$arr[] = array(
						"href" => crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ),array("clave" => "idioma", "valor" => $filtroIdioma),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))),
						"text" => $GLOBALS["infoLocalidad"]["localidad"]
					);
				}
				if ($filtroProvincia) {
					$arr[] = array(
						"href" => crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ),array("clave" => "idioma", "valor" => $filtroIdioma),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))),
						"text" => $GLOBALS["infoProvincia"]["provincia"]
					);
				}
				if ($filtroRemuneracion) {
					$arr[] = array(
						"href" => crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ),array("clave" => "idioma", "valor" => $filtroIdioma),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia), array( "clave" => "pagina", "valor" => 1 ))),
						"text" => $GLOBALS["infoRemuneracion"]["nombre"]
					);
				}
			}
		}
		
		for($i = 0; $i < count($arr) - 1; $i++) {
			$html .= '<li class="breadcrumb-item"><a href="' . $arr[$i]["href"] . '">' . $arr[$i]["text"] . '</a></li>';
		}
		$html .= '<li class="breadcrumb-item active">' . $arr[count($arr) - 1]["text"] . '</li>';
		
		$html .= '</ol>';
		
		return $html;
	}

	function crearURL($params = array()) {
		$parametros = array();
		foreach($params as $p) {
			if($p["valor"]) {
				$parametros[] = $p;
			}
		}
		$url = "trabajadores.php";
		$cant = count($parametros);
		if($cant > 0) {
			$primerParametro = $parametros[0];
			if($primerParametro["valor"] != "") {
				$url .= "?$primerParametro[clave]=$primerParametro[valor]";
			}
			for($i = 1; $i < $cant; $i++) {
				$parametro = $parametros[$i];
				if($parametro["valor"] != "") {
					$url .= (htmlentities("&") . "$parametro[clave]=$parametro[valor]");
				}
			}
		}
		return $url;
	}

	$contRemuneracion = 0;
	$remuneraciones = array(
			array(
				"nombre" => "$0 - $2000",
				"amigable" => "0-2000",
				"cantidad" => 0,
				"rango_a" => 0,
				"rango_b" => 2000
				),
			array(
				"nombre" => "$2000 - $5000",
				"amigable" => "2000-5000",
				"cantidad" => 0,
				"rango_a" => 2000,
				"rango_b" => 5000
				),
			array(
				"nombre" => "$5000 - $10000",
				"amigable" => "5000-10000",
				"cantidad" => 0,
				"rango_a" => 5000,
				"rango_b" => 10000
				),
			array(
				"nombre" => "$10000 - $15000",
				"amigable" => "10000-15000",
				"cantidad" => 0,
				"rango_a" => 10000,
				"rango_b" => 15000
				),
			array(
				"nombre" => "$15000 - $20000",
				"amigable" => "15000-20000",
				"cantidad" => 0,
				"rango_a" => 15000,
				"rango_b" => 20000
				),
			array(
				"nombre" => "$20000 o más",
				"amigable" => "20000-mas",
				"cantidad" => 0,
				"rango_a" => 20000,
				"rango_b" => 1000000
				)

	);

	foreach ($remuneraciones as $i => $rem) {
		if ($rem['amigable'] == $filtroRemuneracion) {
			$infoRemuneracion = $rem;
		}
	}

	$contMomentos = 0;
	$momentos = array(
		array(
			"nombre" => "De 18 a 23 años",
			"amigable" => "de-18-a-23",
			"cantidad" => 0,
            "rango_a" => 18,
            "rango_b" => 23
		),
		array(
			"nombre" => "De 24 a 30 años",
			"amigable" => "de-24-a-30",
			"cantidad" => 0,
            "rango_a" => 24,
            "rango_b" => 30
		),
		array(
			"nombre" => "De 31 a 36 años",
			"amigable" => "de-31-a-36",
			"cantidad" => 0,
            "rango_a" => 31,
            "rango_b" => 36
		),
		array(
			"nombre" => "De 37 a 45 años",
			"amigable" => "de-37-a-45",
			"cantidad" => 0,
            "rango_a" => 37,
            "rango_b" => 45
		)
	);

	foreach($momentos as $m) {
		if($m["amigable"] == $filtroMomento) {
			$infoMomento = $m;
		}
	}

	$contTipos = 0;
	$tipos = array(
		array(
			"nombre" => "Nuevos Jobbers",
			"amigable" => "nuevos",
			"cantidad" => 0
		),
		array(
			"nombre" => "Jobbers contratados",
			"amigable" => "contratados",
			"cantidad" => 0
		)
	);

	foreach($tipos as $t) {
		if($t["amigable"] == $filtroTipo) {
			$infoTipo = $t;
		}
	}

	$contGeneros = 0;
	$generos = array(
		array(
			"nombre" => "Masculino",
			"amigable" => "masculino",
			"cantidad" => 0
		),
		array(
			"nombre" => "Femenino",
			"amigable" => "femenino",
			"cantidad" => 0
		)
	);

	foreach($generos as $g) {
		if($g["amigable"] == $filtroGenero) {
			$infoGenero = $g;
		}
	}

    $contIdiomas = 0;

    $idiomas = $db->getAll("SELECT id, nombre, amigable, 0 as cantidad FROM idiomas ORDER BY nombre");

    if($filtroIdioma) {
        foreach($idiomas as $idioma) {
            if($idioma["amigable"] == $filtroIdioma) {
                $infoIdioma = $idioma;
            }
        }
    }
    else {   
        if($filtroActivado) {
            $arr = array();
			if($filtroArea) {
				$infoArea = $db->getRow("
					SELECT
						id,
						nombre
					FROM
						areas_estudio
					WHERE
						amigable = '$filtroArea'
				");
			}
            foreach($idiomas as $i => $idioma) {
				$query = "
					SELECT
						tra.id
					FROM
						trabajadores AS tra
					LEFT JOIN trabajadores_idiomas AS ti ON ti.id_trabajador = tra.id
					LEFT JOIN idiomas AS i ON ti.id_idioma = i.id
					LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
					LEFT JOIN areas_estudio AS ae ON te.id_area_estudio = ae.id
					LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
					LEFT JOIN paises pais ON tra.id_pais = pais.id
					LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
					WHERE
						ti.id_idioma = $idioma[id]
				";
				
				if($filtroArea) {
					$query .= " AND ae.id = $infoArea[id]";
				}
				
				if($filtroMomento) {
					$query .= " AND " . filtroMomento(true);
				}
				
				if($filtroTipo) {
					$query .= " AND " . filtroTipo(true);
				}
				
				if($filtroGenero) {
					$query .= " AND " . filtroGenero(true);
				}

				if($filtroLocalidades) {
					@$query .= " AND " . "tra.localidad = $infoLocalidad[id]";
				}

				if ($filtroProvincia) {
					@$query .= " AND " . "tra.provincia = $infoProvincia[id]";
					
				}

				if ($filtroRemuneracion) {
					@$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				}
				
				if(!$filtroArea) {
					$query .= " GROUP BY tra.id";
				}
				
				$query = "SELECT COUNT(*) FROM ($query) AS T";
				
				$c = $db->getOne($query);
				
				//echo "<br><br><br>$query;<br><br><br>";
				
				$contIdiomas += $c;
				$idiomas[$i]["cantidad"] = $c;
            }
        }
        else {
            foreach($idiomas as $i => $idioma) {
                $idiomas[$i]["cantidad"] = $db->getOne("
                    SELECT
                        COUNT(*)
                    FROM
                        trabajadores_idiomas AS tra_i
                    WHERE
                        tra_i.id_idioma = $idioma[id]
                ");
                $contIdiomas += $idiomas[$i]["cantidad"];
            }
        }
    }

    $contProvincias = 0;

    $provincias = $db->getAll("SELECT id, provincia, 0 as cantidad FROM provincias ORDER BY provincia");

    if ($filtroProvincia) {
    	foreach ($provincias as $i => $prov) {
    		if ($prov['provincia'] == $filtroProvincia) {
    			$infoProvincia = $prov;
    		}
    	}
    } else {
    	if ($filtroActivado) {
            $arr = array();
			if($filtroArea) {
				$infoArea = $db->getRow("
					SELECT
						id,
						nombre
					FROM
						areas_estudio
					WHERE
						amigable = '$filtroArea'
				");
			}
            foreach($provincias as $i => $prov) {
				$query = "
					SELECT
						tra.id
					FROM
						trabajadores AS tra
					LEFT JOIN trabajadores_idiomas AS ti ON ti.id_trabajador = tra.id
					LEFT JOIN idiomas AS i ON ti.id_idioma = i.id
					LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
					LEFT JOIN areas_estudio AS ae ON te.id_area_estudio = ae.id
					LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
					LEFT JOIN paises pais ON tra.id_pais = pais.id
					LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
					WHERE
						tra.provincia = $prov[id]
				";
				
				if($filtroArea) {
					$query .= " AND ae.id = $infoArea[id]";
				}
				
				if($filtroMomento) {
					$query .= " AND " . filtroMomento(true);
				}
				
				if($filtroTipo) {
					$query .= " AND " . filtroTipo(true);
				}
				
				if($filtroGenero) {
					$query .= " AND " . filtroGenero(true);
				}

				if($filtroIdioma) {
					$query .= " AND " . filtroIdioma(true);
				}

				if($filtroLocalidades) {
					@$query .= " AND " . "tra.localidad = $infoLocalidad[id]";
				}

				if ($filtroRemuneracion) {
					@$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				}
				
				#if(!$filtroArea) {
					$query .= " GROUP BY tra.id";
				#}
				
				$query = "SELECT COUNT(*) FROM ($query) AS T";
				
				$c = $db->getOne($query);
				
				//echo "<br><br><br>$query;<br><br><br>";
				
				$contProvincias += $c;
				$provincias[$i]["cantidad"] = $c;
            }
    	} else {
    		foreach($provincias as $i => $prov) {
                $provincias[$i]["cantidad"] = $db->getOne("
                    SELECT
                        COUNT(*)
                    FROM
                        trabajadores AS tra
                    WHERE
                        tra.provincia = $prov[id]
                ");
                $contProvincias += $provincias[$i]["cantidad"];
            }
    	}
    }

    $contLocalidades = 0;

    $localidades = $db->getAll("SELECT id, id_provincia, localidad, 0 as cantidad FROM localidades ORDER BY localidad");

    if ($filtroLocalidades) {
    	foreach ($localidades as $i => $loc) {
    		if($loc["localidad"] == $filtroLocalidades) {
    		    $infoLocalidad = $loc;
    		}
    	}
    } else {
    	if ($filtroActivado) {
            $arr = array();
			if($filtroArea) {
				$infoArea = $db->getRow("
					SELECT
						id,
						nombre
					FROM
						areas_estudio
					WHERE
						amigable = '$filtroArea'
				");
			}
            foreach($localidades as $i => $loc) {
				$query = "
					SELECT
						tra.id
					FROM
						trabajadores AS tra
					LEFT JOIN trabajadores_idiomas AS ti ON ti.id_trabajador = tra.id
					LEFT JOIN idiomas AS i ON ti.id_idioma = i.id
					LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
					LEFT JOIN areas_estudio AS ae ON te.id_area_estudio = ae.id
					LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
					LEFT JOIN paises pais ON tra.id_pais = pais.id
					LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
					WHERE
						tra.localidad = $loc[id]
				";
				
				if($filtroArea) {
					$query .= " AND ae.id = $infoArea[id]";
				}
				
				if($filtroMomento) {
					$query .= " AND " . filtroMomento(true);
				}
				
				if($filtroTipo) {
					$query .= " AND " . filtroTipo(true);
				}
				
				if($filtroGenero) {
					$query .= " AND " . filtroGenero(true);
				}

				if($filtroIdioma) {
					$query .= " AND " . filtroIdioma(true);
				}

				if ($filtroProvincia) {
					@$query .= " AND " . "tra.provincia = $infoProvincia[id]";
					
				}

				if ($filtroRemuneracion) {
					@$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				}
				
				#if(!$filtroArea) {
					$query .= " GROUP BY tra.id";
				#}
				
				$query = "SELECT COUNT(*) FROM ($query) AS T";
				
				$c = $db->getOne($query);
				
				//echo "<br><br><br>$query;<br><br><br>";
				
				$contLocalidades += $c;
				$localidades[$i]["cantidad"] = $c;
            }
    	} else {
    		foreach($localidades as $i => $loc) {
                $localidades[$i]["cantidad"] = $db->getOne("
                    SELECT
                        COUNT(*)
                    FROM
                        trabajadores AS tra
                    WHERE
                        tra.localidad = $loc[id]
                ");
                $contLocalidades += $localidades[$i]["cantidad"];
            }
    	}
    }

	$contAreas = 0;

	if(!$filtroArea) {
		$areas = $db->getAll("
			SELECT
				id,
				nombre,
				amigable
			FROM
				areas_estudio
			ORDER BY
				nombre
		");

		if($filtroMomento) {
			foreach($areas as $i => $area) {
				$query = "
					SELECT
						COUNT(te.id_area_estudio)
					FROM
						trabajadores AS tra
					LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
					LEFT JOIN areas_estudio AS ae ON te.id_area_estudio = ae.id
					LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
					LEFT JOIN paises pais ON tra.id_pais = pais.id
					LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
					WHERE
						te.id_area_estudio = $area[id]
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
				if($filtroTipo) {
					$query .= filtroTipo(true);
				}
				if($filtroGenero) {
					$query .= filtroGenero(true);
				}
				if($filtroIdioma) {
					$query .= filtroIdioma(true);
				}

				if ($filtroLocalidades) {
					$query .= " AND tra.localidad = $infoLocalidad[id]";
				}

				if ($filtroProvincia) {
					@$query .= " AND " . "tra.provincia = $infoProvincia[id]";
					
				}

				if ($filtroRemuneracion) {
					@$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				}

				$c = $db->getOne($query);
				$areas[$i]["cantidad"] = $c;
				$contAreas += $c;
			}
		}
		else {
			foreach($areas as $i => $area) {
				$query = "
					SELECT
						COUNT(te.id_area_estudio)
					FROM
						trabajadores AS tra
					LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
					LEFT JOIN areas_estudio AS ae ON te.id_area_estudio = ae.id
					LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
					LEFT JOIN paises pais ON tra.id_pais = pais.id
					LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
					WHERE
						te.id_area_estudio = $area[id]
				";
				if($filtroTipo) {
					$query .= filtroTipo(true);
				}
				if($filtroGenero) {
					$query .= filtroGenero(true);
				}
				if($filtroIdioma) {
					$query .= filtroIdioma(true);
				}

				if ($filtroLocalidades) {
					$query .= " AND tra.localidad = $infoLocalidad[id]";
				}

				if ($filtroProvincia) {
					@$query .= " AND " . "tra.provincia = $infoProvincia[id]";
					
				}

				if ($filtroRemuneracion) {
					@$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				}

				$c = $db->getOne($query);
				$areas[$i]["cantidad"] = $c;
				$contAreas += $c;
			}
		}
	}

	if($busquedaAvanzada) {
		$query = "
			SELECT
				tra.id,
				tra.fecha_nacimiento,
				tra.fecha_creacion,
                TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) AS edad,
				TIMESTAMPDIFF(MONTH, tra.fecha_creacion, CURDATE()) AS antiguedad,
                tra.nombres,
				tra.apellidos,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen,
				tra.calificacion_general,
				pais.nombre AS pais,
				ie.sobre_mi,
				ie.remuneracion_pret
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
			LEFT JOIN paises pais ON tra.id_pais = pais.id
			LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
			WHERE 1
		";
		$query2 = "
			SELECT
				COUNT(*)
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			WHERE 1
		";
		
		if($palabrasClave != "") {
			$tokens = explode(",", $palabrasClave);
			$l = count($tokens);
			if($l > 1) {
				$query .= " AND ((tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
				$query2 .= " AND ((tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
				for($i = 1; $i < $l; $i++) {
					$query .= " OR (tra.nombres LIKE '%$tokens[$i]%' OR tra.apellidos LIKE '%$tokens[$i]%')";
					$query2 .= " OR (tra.nombres LIKE '%$tokens[$i]%' OR tra.apellidos LIKE '%$tokens[$i]%')";
				}
				$query .= ")";
				$query2 .= ")";
			}
			else {
				$query .= " AND (tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
				$query2 .= " AND (tra.nombres LIKE '%$tokens[0]%' OR tra.apellidos LIKE '%$tokens[0]%')";
			}
		}
				
		if($filtroArea) {           
            if($filtroMomento) {	
				$query .= "
                    AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
				if($filtroTipo) {
					$tmp = filtroTipo(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				if($filtroGenero) {
					$tmp = filtroGenero(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				if($filtroIdioma) {
					$tmp = filtroIdioma(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
			}
			if($filtroTipo) {
				$tmp = filtroTipo(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
			if($filtroGenero) {
				$tmp = filtroGenero(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
			if($filtroIdioma) {
				$tmp = filtroIdioma(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
		}
		else {
            if($filtroMomento) {
				$query .= "
                    AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
				
				if($filtroTipo) {
					$tmp = filtroTipo(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				
				if($filtroGenero) {
					$tmp = filtroGenero(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				
				if($filtroIdioma) {
					$tmp = filtroIdioma(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
			}
			
			if($filtroTipo) {
				$tmp = filtroTipo(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
			
			if($filtroGenero) {
				$tmp = filtroGenero(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
			
			if($filtroIdioma) {
				$tmp = filtroIdioma(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
        }
		
		$cantidadRegistros = $db->getOne($query2);
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);		
		
		#$query .= "GROUP BY tra.id LIMIT $inicial, $final";
		$query .= "GROUP BY tra.id";
		
		$trabajadores = $db->getAll($query);
        
        if($trabajadores) {
			foreach($trabajadores as $k => $t) {
				if(!$t["imagen"]) {
					$trabajadores[$k]["imagen"] = "avatars/user.png";
				}
			}
		}
	}
	elseif($filtroActivado) {        
		$query = "
			SELECT
                tra.id,
                tra.fecha_nacimiento,
                TIMESTAMPDIFF(
                    YEAR,
                    tra.fecha_nacimiento,
                    CURDATE()
                ) AS edad,
                tra.nombres,
                tra.apellidos,
                CONCAT(
                    img.directorio,
                    '/',
                    img.nombre,
                    '.',
                    img.extension
                ) AS imagen,
                tra.calificacion_general,
				pais.nombre AS pais,
				ie.sobre_mi,
				ie.remuneracion_pret
            FROM
                trabajadores AS tra
            LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
            LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
			LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
			LEFT JOIN paises pais ON tra.id_pais = pais.id
			LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
			LEFT JOIN trabajadores_idiomas ti ON tra.id = ti.id_trabajador
		";
		$query2 = "
			SELECT
                COUNT(*)
            FROM
                trabajadores AS tra
            LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
            LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
			LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
			LEFT JOIN paises pais ON tra.id_pais = pais.id
			LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
			LEFT JOIN trabajadores_idiomas ti ON tra.id = ti.id_trabajador
		";
		
		if($filtroArea) {            
            $query .= "
                WHERE
                    te.id_area_estudio = $infoArea[id]
            ";            
            $query2 .= "
                WHERE
                    te.id_area_estudio = $infoArea[id]
            ";
            
            if($filtroMomento) {
				$query .= "
                    AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					AND (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
				
				if($filtroTipo) {
					$tmp = filtroTipo(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				
				if($filtroGenero) {
					$tmp = filtroGenero(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				if($filtroIdioma) {
					$tmp = filtroIdioma(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				if ($filtroLocalidades) {
						$query .= " AND tra.localidad = $infoLocalidad[id]";
						$query2 .= " AND tra.localidad = $infoLocalidad[id]";
				}
				if ($filtroProvincia) {
					$query .= " AND tra.provincia = $infoProvincia[id]";
					$query2 .= " AND tra.provincia = $infoProvincia[id]";
				}
				if ($filtroRemuneracion) {
					$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
					$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				}
			}
			
			if($filtroTipo) {
				$tmp = filtroTipo(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
			
			if($filtroGenero) {
				$tmp = filtroGenero(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
			
			if($filtroIdioma) {
				$tmp = filtroIdioma(true);
				$query .= $tmp;
				$query2 .= $tmp;
			}
			if ($filtroLocalidades) {
				$query .= " AND tra.localidad = $infoLocalidad[id]";
				$query2 .= " AND tra.localidad = $infoLocalidad[id]";
			}
			if ($filtroProvincia) {
				$query .= " AND tra.provincia = $infoProvincia[id]";
				$query2 .= " AND tra.provincia = $infoProvincia[id]";
			}
			if ($filtroRemuneracion) {
				$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
			}
		}
		else {           
            if($filtroMomento) {
				$query .= "
                    WHERE (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";			
				$query2 .= "
					WHERE (TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) >= $infoMomento[rango_a] AND TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) <= $infoMomento[rango_b])
				";
				
				if($filtroTipo) {
					$tmp = filtroTipo(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				
				if($filtroGenero) {
					$tmp = filtroGenero(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				if($filtroIdioma) {
					$tmp = filtroIdioma(true);
					$query .= $tmp;
					$query2 .= $tmp;
				}
				if ($filtroLocalidades) {
					$query .= " AND tra.localidad = $infoLocalidad[id]";
					$query2 .= " AND tra.localidad = $infoLocalidad[id]";
				}
				if ($filtroProvincia) {
					$query .= " AND tra.provincia = $infoProvincia[id]";
					$query2 .= " AND tra.provincia = $infoProvincia[id]";
				}
				if ($filtroRemuneracion) {
					$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
					$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
				}
			}
            else {
                if($filtroTipo) {
                    $tmp = filtroTipo(false);
                    $query .= $tmp;
                    $query2 .= $tmp;
                    if($filtroGenero) {
                        $tmp = filtroGenero(true);
                        $query .= $tmp;
                        $query2 .= $tmp;
                    }
					if($filtroIdioma) {
						$tmp = filtroIdioma(true);
						$query .= $tmp;
						$query2 .= $tmp;
					}
					if ($filtroLocalidades) {
						$query .= " AND tra.localidad = $infoLocalidad[id]";
						$query2 .= " AND tra.localidad = $infoLocalidad[id]";
					}
					if ($filtroProvincia) {
						$query .= " AND tra.provincia = $infoProvincia[id]";
						$query2 .= " AND tra.provincia = $infoProvincia[id]";
					}
					if ($filtroRemuneracion) {
						$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
					}
                }
                else {
                    if($filtroGenero) {
                        $tmp = filtroGenero(false);
                        $query .= $tmp;
                        $query2 .= $tmp;
						if($filtroIdioma) {
							$tmp = filtroIdioma(true);
							$query .= $tmp;
							$query2 .= $tmp;
						}
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							$query2 .= " AND tra.localidad = $infoLocalidad[id]";
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							$query2 .= " AND tra.provincia = $infoProvincia[id]";
						}
						if ($filtroRemuneracion) {
							$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
							$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                    }
					else {
						if($filtroIdioma) {
							$tmp = filtroIdioma(false);
							$query .= $tmp;
							$query2 .= $tmp;

							if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							$query2 .= " AND tra.localidad = $infoLocalidad[id]";
							}

							if ($filtroProvincia) {
								$query .= "AND tra.provincia = $infoProvincia[id]";
								$query2 .= "AND tra.provincia = $infoProvincia[id]";
							}
							if ($filtroRemuneracion) {
								$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
								$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
							}
						} else {
							if ($filtroLocalidades) {
							$query .= "WHERE tra.localidad = $infoLocalidad[id]";
							$query2 .= "WHERE tra.localidad = $infoLocalidad[id]";

								if ($filtroProvincia) {
									$query .= "AND tra.provincia = $infoProvincia[id]";
									$query2 .= "AND tra.provincia = $infoProvincia[id]";
								}
								if ($filtroRemuneracion) {
									$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
									$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
								}
							} else {
								if ($filtroProvincia) {
									$query .= "WHERE tra.provincia = $infoProvincia[id]";
									$query2 .= "WHERE tra.provincia = $infoProvincia[id]";

									if ($filtroRemuneracion) {
										$query .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
										$query2 .= " AND " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
									}
								} else {
									if ($filtroRemuneracion) {
										$query .= " WHERE " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
										$query2 .= " WHERE " . "ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
									}
								}
							}
						}
					}
                }
            }
        }
		
		$cantidadRegistros = $db->getOne($query2);
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
		
		#$query .= " GROUP BY tra.id LIMIT $inicial, $final";
		$query .= " GROUP BY tra.id";

		$trabajadores = $db->getAll($query);	
		
		if($trabajadores) {
			foreach($trabajadores as $k => $t) {
				if(!$t["imagen"]) {
					$trabajadores[$k]["imagen"] = "avatars/user.png";
				}
			}
		}
	}
	else if($busqueda) {
		$trabajadores = $db->getAll("
			SELECT
				tra.id,
				tra.fecha_nacimiento,
				tra.fecha_creacion,
                TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) AS edad,
				TIMESTAMPDIFF(MONTH, tra.fecha_creacion, CURDATE()) AS antiguedad,
                tra.nombres,
				tra.apellidos,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen,
				tra.calificacion_general,
				pais.nombre AS pais,
				ie.sobre_mi,
				ie.remuneracion_pret
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			LEFT JOIN paises pais ON tra.id_pais = pais.id
			LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
			WHERE tra.nombres LIKE '%$busqueda%' OR tra.apellidos LIKE '%$busqueda%'
		");

		foreach($trabajadores as $k => $t) {
			if(!$t["imagen"]) {
				$trabajadores[$k]["imagen"] = "avatars/user.png";
			}
		}
		
		$cantidadRegistros = $db->getOne("
			SELECT
				COUNT(*)
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			WHERE tra.nombres LIKE '%$busqueda%' OR tra.apellidos LIKE '%$busqueda%'
		");
		
		$cantidadPaginas = ceil($cantidadRegistros / $final);
	}
	else {
		$trabajadores = $db->getAll("
			SELECT
				tra.id,
				tra.fecha_nacimiento, TIMESTAMPDIFF(YEAR, tra.fecha_nacimiento, CURDATE()) AS edad,
                tra.nombres,
				tra.apellidos,
				CONCAT(
					img.directorio,
					'/',
					img.nombre,
					'.',
					img.extension
				) AS imagen,
				tra.calificacion_general,
				pais.nombre AS pais,
				ie.sobre_mi,
				ie.remuneracion_pret
			FROM
				trabajadores AS tra
			LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
			LEFT JOIN paises pais ON tra.id_pais = pais.id
			LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
			GROUP BY tra.id
			ORDER BY ie.sobre_mi DESC, tra.id DESC
			LIMIT 0,15
		");

		foreach($trabajadores as $k => $t) {
			if(!$t["imagen"]) {
				$trabajadores[$k]["imagen"] = "avatars/user.png";
			}
		}
	}

	if (!$filtroRemuneracion) {
		$band = false;
		foreach ($remuneraciones as $i => $rem) {
			if ($filtroActivado) {
				if ($filtroArea) {
					$query = "
					SELECT
							COUNT(*)
						FROM
						(
							SELECT
								tra.id
							FROM
								trabajadores AS tra
							LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
							LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
                            LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
                            LEFT JOIN paises pais ON tra.id_pais = pais.id
                            LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
							WHERE
								(
									ie.remuneracion_pret
									BETWEEN $rem[rango_a] AND $rem[rango_b]
								) AND te.id_area_estudio = $infoArea[id]";

							$query .= filtroTipo(true);
							$query .= filtroGenero(true);
							$query .= filtroIdioma(true);
							$query .= filtroMomento(true);
							if ($filtroLocalidades) {
								$query .= " AND tra.localidad = $infoLocalidad[id]";
								
							}

							if ($filtroProvincia) {
								$query .= " AND tra.provincia = $infoProvincia[id]";
								
							}

							$query .= "
								GROUP BY
									tra.id
									) AS t
							";	
				} else {
					$query = "
					SELECT
							COUNT(*)
						FROM
						(
							SELECT
								tra.id
							FROM
								trabajadores AS tra
							LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
							LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
                            LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
                            LEFT JOIN paises pais ON tra.id_pais = pais.id
                            LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
							WHERE
								(
									ie.remuneracion_pret
									BETWEEN $rem[rango_a] AND $rem[rango_b]
								)
							";

							$query .= filtroTipo(true);
							$query .= filtroGenero(true);
							$query .= filtroIdioma(true);
							$query .= filtroMomento(true);
							if ($filtroLocalidades) {
								$query .= "AND tra.localidad = $infoLocalidad[id]";
								
							}

							if ($filtroProvincia) {
								$query .= "AND tra.provincia = $infoProvincia[id]";
								
							}

							$query .= "
								GROUP BY
									tra.id
									) AS t
							";

                    		$query .= "";

				}
			} else {
				$query = "
							SELECT
								tra.id
							FROM
								trabajadores AS tra
							LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
							LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
                            LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
                            LEFT JOIN paises pais ON tra.id_pais = pais.id
                            LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
							WHERE
								(
									ie.remuneracion_pret
									BETWEEN $rem[rango_a] AND $rem[rango_b]
								)
							";

							$query .= filtroTipo(true);
							$query .= filtroGenero(true);
							$query .= filtroIdioma(true);
							$query .= filtroMomento(true);
							if ($filtroLocalidades) {
								$query .= " AND tra.localidad = $infoLocalidad[id]";
								
							}

							if ($filtroProvincia) {
								$query .= " AND tra.provincia = $infoProvincia[id]";
								
							}

                			$query = "SELECT COUNT(*) FROM ($query GROUP BY tra.id) AS T";

			}

			$c = $db->getOne($query);
			$remuneraciones[$i]["cantidad"] = $c;
			$contRemuneracion += $c;
		}
	}


    if(!$filtroMomento) {
		$band = false;
		foreach($momentos as $i => $momento) {
			if($filtroActivado) {
				if($filtroArea) {
					$query = "
						SELECT
							COUNT(*)
						FROM
						(
							SELECT
								tra.id
							FROM
								trabajadores AS tra
							LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
							LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
                            LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
                            LEFT JOIN paises pais ON tra.id_pais = pais.id
                            LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
							WHERE
								(
									TIMESTAMPDIFF(
										YEAR,
										tra.fecha_nacimiento,
										CURDATE()
									) >= $momento[rango_a]
									AND TIMESTAMPDIFF(
										YEAR,
										tra.fecha_nacimiento,
										CURDATE()
									) <= $momento[rango_b]
								) AND te.id_area_estudio = $infoArea[id] ";
                    
                    $query .= filtroTipo(true);
                    $query .= filtroGenero(true);
                    $query .= filtroIdioma(true);
                    if ($filtroLocalidades) {
                    	$query .= " AND tra.localidad = $infoLocalidad[id]";
                    	
                    }

                    if ($filtroProvincia) {
                    	$query .= " AND tra.provincia = $infoProvincia[id]";
                    	
                    }

                    if ($filtroRemuneracion) {
                    	$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
                    }
                    
                    $query .= "
							GROUP BY
								tra.id
						) AS t
					";
				}
				else {
					$query = "
						SELECT
							COUNT(*)
						FROM
						(
							SELECT
								tra.id
							FROM
								trabajadores AS tra
							LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
							LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
                            LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
                            LEFT JOIN paises pais ON tra.id_pais = pais.id
                            LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
							WHERE
								(
									TIMESTAMPDIFF(
										YEAR,
										tra.fecha_nacimiento,
										CURDATE()
									) >= $momento[rango_a]
									AND TIMESTAMPDIFF(
										YEAR,
										tra.fecha_nacimiento,
										CURDATE()
									) <= $momento[rango_b]
								)
					";
                    
                    $query .= filtroTipo(true);
                    $query .= filtroGenero(true);
                    $query .= filtroIdioma(true);
                    if ($filtroLocalidades) {
                    	$query .= " AND tra.localidad = $infoLocalidad[id]";
                    	
                    }
                    if ($filtroProvincia) {
                    	$query .= " AND tra.provincia = $infoProvincia[id]";
                    	
                    }

                    if ($filtroRemuneracion) {
                    	$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
                    }

                    $query .= "
							GROUP BY
								tra.id
						) AS t";
                    
                    $query .= "";
				}
			}
			else {
				$query = "
                    SELECT
                        tra.id
                    FROM
                        trabajadores AS tra
                    LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
                    LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
					LEFT JOIN paises pais ON tra.id_pais = pais.id
					LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
                    WHERE TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) >= $momento[rango_a] AND TIMESTAMPDIFF(YEAR,  tra.fecha_nacimiento, CURDATE()) <= $momento[rango_b]
                ";
                
                $query .= filtroTipo(true);
                $query .= filtroGenero(true);
                $query .= filtroIdioma(true);
                if ($filtroLocalidades) {
                    $query .= " AND tra.localidad = $infoLocalidad[id]";
                    	
                }

                if ($filtroProvincia) {
                	$query .= " AND tra.provincia = $infoProvincia[id]";
                	
                }

                if ($filtroRemuneracion) {
                    	$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
                    }
                
                $query = "SELECT COUNT(*) FROM ($query GROUP BY tra.id) AS T";
			}
            
			$c = $db->getOne($query);
			$momentos[$i]["cantidad"] = $c;
			$contMomentos += $c;
		}
	}

	if(!$filtroTipo) {
		$band = false;
		foreach($tipos as $i => $tipo) {
			$condt = "";
			switch($tipo["amigable"]) {
				case "nuevos":
					$condt = "(TIMESTAMPDIFF(MONTH, tra.fecha_creacion, CURDATE()) <= 3 AND ec.id_trabajador IS NULL)";
					break;
				case "contratados":
					$condt = "(ec.id_trabajador IS NOT NULL AND TIMESTAMPDIFF(MONTH, tra.fecha_creacion, CURDATE()) >= 3)";
					break;
			}
			if($filtroActivado) {
				if($filtroArea) {
					if($filtroMomento) {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE $condt AND te.id_area_estudio = $infoArea[id]
						";
                        $query .= filtroMomento(true);
                        $query .= filtroGenero(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
                    		$query .= " AND tra.localidad = $infoLocalidad[id]";
                    	
                    	}
                    	if ($filtroProvincia) {
                    		$query .= " AND tra.provincia = $infoProvincia[id]";
                    		
                    	}

                    	if ($filtroRemuneracion) {
                    		$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
                    	}

                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
					}
					else {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE $condt AND te.id_area_estudio = $infoArea[id]
						";
                        
                        $query .= filtroGenero(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							
						}

						if ($filtroRemuneracion) {
							$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                        
                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
					}
				}
				else {
					if($filtroMomento) {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE $condt
						";
                        
                        $query .= filtroMomento(true);
                        $query .= filtroGenero(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							
						}

						if ($filtroRemuneracion) {
							$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                        
                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
                        
					}
					else {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE $condt
						";
                        
                        $query .= filtroGenero(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							
						}

						if ($filtroRemuneracion) {
							$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                        
                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
					}
				}
			}
			else {
				if($filtroMomento) {
					$query = "
						SELECT
							COUNT(*)
						FROM
							trabajadores AS tra
						LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
						LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
						LEFT JOIN paises pais ON tra.id_pais = pais.id
						LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
						WHERE $condt
					";
                    
                    $query .= filtroMomento(true);
                    $query .= filtroGenero(true);
					$query .= filtroIdioma(true);
					if ($filtroLocalidades) {
						$query .= " AND tra.localidad = $infoLocalidad[id]";
						
					}
					if ($filtroProvincia) {
						$query .= " AND tra.provincia = $infoProvincia[id]";
						
					}

					if ($filtroRemuneracion) {
						$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
					}
				}
				else {
                    $query = "
                        SELECT
                            COUNT(*)
                        FROM
                            (
                                SELECT
                                    tra.id
                                FROM
                                    trabajadores AS tra
                                LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
                                LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
                                LEFT JOIN paises pais ON tra.id_pais = pais.id
                                LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
                                WHERE $condt
                    ";
                    
                    $query .= filtroGenero(true);
					$query .= filtroIdioma(true);
					if ($filtroLocalidades) {
						$query .= " AND tra.localidad = $infoLocalidad[id]";
						
					}
					if ($filtroProvincia) {
						$query .= " AND tra.provincia = $infoProvincia[id]";
						
					}

					if ($filtroRemuneracion) {
						$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
					}
                    
                    $query .= "
                        GROUP BY
                            tra.id
                    ) AS T";
				}
			}
			
			$c = $db->getOne($query);
			
			$tipos[$i]["cantidad"] = $c;
			$contTipos += $c;
		}
	}

	if(!$filtroGenero) {
		$band = false;
		foreach($generos as $i => $genero) {
			$condt = "";
			switch($genero["amigable"]) {
				case "masculino":
					$condt = "(id_sexo = 1)";
					break;
				case "femenino":
					$condt = "(id_sexo = 2)";
					break;
			}
			if($filtroActivado) {
				if($filtroArea) {
					if($filtroMomento) {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE
									$condt AND te.id_area_estudio = $infoArea[id]
						";
                        $query .= filtroMomento(true);
                        $query .= filtroTipo(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							
						}
						if ($filtroRemuneracion) {
							$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
					}
					else {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE $condt AND te.id_area_estudio = $infoArea[id]
						";

                        $query .= filtroTipo(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							
						}

						if ($filtroRemuneracion) {
							$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                        
                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
					}
				}
				else {
					if($filtroMomento) {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE $condt
						";
                        
                        $query .= filtroMomento(true);
                        $query .= filtroTipo(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							
						}

						if ($filtroRemuneracion) {
							$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                        
                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
                        
					}
					else {
						$query = "
							SELECT
								COUNT(*)
							FROM
							(
								SELECT
									tra.id
								FROM
									trabajadores AS tra
								LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
								LEFT JOIN trabajadores_educacion AS te ON tra.id = te.id_trabajador
								LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
								LEFT JOIN paises pais ON tra.id_pais = pais.id
								LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
								WHERE $condt
						";
                        
                        $query .= filtroTipo(true);
						$query .= filtroIdioma(true);
						if ($filtroLocalidades) {
							$query .= " AND tra.localidad = $infoLocalidad[id]";
							
						}
						if ($filtroProvincia) {
							$query .= " AND tra.provincia = $infoProvincia[id]";
							
						}

						if ($filtroRemuneracion) {
							$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
						}
                        
                        $query .= "
                            GROUP BY
                                tra.id
                        ) AS t";
					}
				}
			}
			else {
				if($filtroMomento) {
					$query = "
						SELECT
							COUNT(*)
						FROM
							trabajadores AS tra
						LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
						LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador					
						LEFT JOIN paises pais ON tra.id_pais = pais.id
						LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
						WHERE $condt
					";
                    
                    $query .= filtroMomento(true);
                    $query .= filtroTipo(true);
					$query .= filtroIdioma(true);
					if ($filtroLocalidades) {
						$query .= " AND tra.localidad = $infoLocalidad[id]";
						
					}
					if ($filtroProvincia) {
						$query .= " AND tra.provincia = $infoProvincia[id]";
						
					}

					if ($filtroRemuneracion) {
						$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
					}
				}
				else {
                    $query = "
                        SELECT
                            COUNT(*)
                        FROM
                            (
                                SELECT
                                    tra.id
                                FROM
                                    trabajadores AS tra
                                LEFT JOIN imagenes AS img ON tra.id_imagen = img.id
                                LEFT JOIN empresas_contrataciones AS ec ON tra.id = ec.id_trabajador
                                LEFT JOIN paises pais ON tra.id_pais = pais.id
                                LEFT JOIN trabajadores_infextra ie ON tra.id = ie.id_trabajador
                                WHERE $condt
                    ";                    
                    
                    $query .= filtroTipo(true);
					$query .= filtroIdioma(true);
					if ($filtroLocalidades) {
						$query .= " AND tra.localidad = $infoLocalidad[id]";
						
					}
					if ($filtroProvincia) {
						$query .= " AND tra.provincia = $infoProvincia[id]";
						
					}

					if ($filtroRemuneracion) {
						$query .= " AND ie.remuneracion_pret BETWEEN $infoRemuneracion[rango_a] AND $infoRemuneracion[rango_b]";
					}
                    
                    $query .= "
                        GROUP BY
                            tra.id
                    ) AS T";
				}
			}
			
			$c = $db->getOne($query);
			
			$generos[$i]["cantidad"] = $c;
			$contGeneros += $c;
		}
        
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
		<title>JOBBERS - Trabajadores</title>
		<?php require_once('includes/libs-css.php'); ?>
		<link rel="stylesheet" href="vendor/ionicons/css/ionicons.min.css">
		<style>
			.tra {
				min-height: 150px;
				margin-bottom: 30px;
			}
			.tra-f {
				min-height: 110px;
			}
			.tra, .tra-f {
				background-color: #f8f8f8 !important;
				-webkit-transition: all 0.2s ease-in-out;
				transition: all 0.2s ease-in-out;
				cursor: pointer;
			}			
			.tra:hover, .tra-f:hover {
				background-color: #DADADA !important;
			}
			.tra:hover *, .tra-f:hover * {
				/*color: #fff !important;*/
			}
		</style>
	</head>
	<body class="large-sidebar fixed-sidebar fixed-header skin-5">
		<div class="wrapper">
		<!-- Sidebar -->
		<?php require_once('includes/sidebar.php'); ?>

		<!-- Sidebar second -->
		<?php require_once('includes/sidebar-second.php'); ?>

		<!-- Header -->
		<?php require_once('includes/header.php'); ?>
			<div class="site-content bg-white">
				<!-- Content -->
				<div class="content-area p-y-1">
				
					<div class="container-fluid">
						<div class="col-md-6">				
							<?php if($filtroActivado): ?>
								<h4>Trabajadores</h4>
								
								<?php echo crearBreadcrumb(); ?>
							
							<?php else: ?>
								<br>
							<?php endif ?>					
						</div>
						<?php if($cantidadRegistros > 0): ?>
							<?php if($filtroActivado): ?>
								<div class="col-md-6 text-xs-right">
									<h6 class="m-t-1"><?php echo $filtroArea ? ($infoArea["nombre"] . ($filtroSector ? " ($infoSector[nombre])" : "")) : (empty($infoMomento) ? "" : "$infoMomento[nombre]"); ?></h6>
									<h6>Trabajadores: <?php echo ($inicial + 1); ?> - <?php echo ($final * $pagina) > $cantidadRegistros ? $cantidadRegistros : ($final * $pagina); ?> de <?php echo $cantidadRegistros; ?></h6>
								</div>
							<?php elseif($busqueda): ?>
								<div class="col-md-6 text-xs-right">
									<h6 class="m-t-1">Resultados de búsqueda para <strong><?php echo $busqueda; ?></strong></h6>
									<h6>Trabajadores: <?php echo ($inicial + 1); ?> - <?php echo ($final * $pagina) > $cantidadRegistros ? $cantidadRegistros : ($final * $pagina); ?> de <?php echo $cantidadRegistros; ?></h6>
								</div>
							<?php endif ?>
						<?php endif ?>
					</div>

					<div class="container-fluid">

						<div class="col-md-3">
							<?php if($contAreas > 0 || $filtroArea): ?>
								<div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="ion-ios-list m-sm-r-1"></i> Área de estudio</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php if($filtroArea): ?>
												<tr>
													<td style="word-break: break-all;">
														<a style="margin-left: 7px;" class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoArea["nombre"]; ?></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array(array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($areas as $area): ?>
													<?php if($area["cantidad"] > 0): ?>
														<tr>
															<td style="word-break: break-all;">
																<a style="margin-left: 7px;" class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $area["amigable"] ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><span class="underline"><?php echo $area["nombre"]; ?></span></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $area["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>
											<?php endif ?>
										</tbody>
									</table>
								</div>
							<?php endif ?>
							
							<?php if($contMomentos > 0 || $filtroMomento): ?>
								<div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Edad</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>						
											<?php if($filtroMomento): ?>
												<tr>
													<td>
														<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoMomento["nombre"]; ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($momentos as $momento): ?>
													<?php if($momento["cantidad"] > 0): ?>
														<tr>
															<td>
																<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $momento["amigable"] ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $momento["nombre"]; ?></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $momento["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>									
											<?php endif ?>							
										</tbody>
									</table>
								</div>
							<?php endif ?>
                           
                           <?php if($contTipos > 0 || $filtroTipo): ?>
                           	<div class="box bg-white">
								<div class="box-block clearfix">
									<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Etapa</h5>
								</div>
								<table class="table m-md-b-0">
									<tbody>
                                        <?php if($filtroTipo): ?>
											<tr>
												<td>
													<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoTipo["nombre"]; ?><span class="underline"></span></a>
												</td>
												<td>
													<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
														<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
													<?php endif ?>
												</td>
											</tr>
										<?php else: ?>
											<?php foreach($tipos as $tipo): ?>
												<?php if($tipo["cantidad"] > 0): ?>
													<tr>
														<td>
															<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $tipo["amigable"] ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $tipo["nombre"]; ?></a>
														</td>
														<td>
															<span class="text-muted pull-xs-right"><?php echo $tipo["cantidad"]; ?></span>
														</td>
													</tr>
												<?php endif ?>
											<?php endforeach ?>									
										<?php endif ?>							
									</tbody>
								</table>
							</div>
                           <?php endif ?>
                           
                           <?php if($contGeneros > 0 || $filtroGenero): ?>
                           
							   <div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Género</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php if($filtroGenero): ?>
												<tr>
													<td>
														<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoGenero["nombre"]; ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($generos as $genero): ?>
													<?php if($genero["cantidad"] > 0): ?>
														<tr>
															<td>
																<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $genero["amigable"] ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $genero["nombre"]; ?></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $genero["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>									
											<?php endif ?>							
										</tbody>
									</table>
								</div>
                          	<?php endif ?>
                          	
                          	<?php if($contIdiomas > 0 || $filtroIdioma): ?>
                           
							   <div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Idioma</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php if($filtroIdioma): ?>
												<tr>
													<td>
														<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "idioma", "valor" => $filtroIdioma ), array( "clave" => "genero", "valor" => $filtroGenero ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoIdioma["nombre"]; ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($idiomas as $idioma): ?>
													<?php if($idioma["cantidad"] > 0): ?>
														<tr>
															<td>
																<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "idioma", "valor" => $idioma["amigable"] ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $idioma["nombre"]; ?></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $idioma["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>									
											<?php endif ?>							
										</tbody>
									</table>
								</div>
                          	<?php endif ?>

                          	<?php if($contLocalidades > 0 || $filtroLocalidades): ?>
                           
							   <div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Localidades</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php if($filtroLocalidades): ?>
												<tr>
													<td>
														<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "localidad", "valor" => $filtroLocalidades),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoLocalidad["localidad"] ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($localidades as $loc): ?>
													<?php if($loc["cantidad"] > 0): ?>
														<!-- <span>Hola mundo</span> -->
														<tr>
															<td>
																<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion),array("clave" => "localidad", "valor" => $loc["localidad"]), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $loc["localidad"]; ?></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $loc["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>									
											<?php endif ?>							
										</tbody>
									</table>
								</div>
                          	<?php endif ?>

                          	<?php if($contProvincias > 0 || $filtroProvincia): ?>
                           
							   <div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Provincias</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php if($filtroProvincia): ?>
												<tr>
													<td>
														<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "idioma", "valor" => $filtroIdioma ), array( "clave" => "genero", "valor" => $filtroGenero ),array( "clave" => "localidad", "valor" => $filtroLocalidades ),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoProvincia["provincia"] ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($provincias as $prov): ?>
													<?php if($prov["cantidad"] > 0): ?>
														<!-- <span>Hola mundo</span> -->
														<tr>
															<td>
																<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array( "clave" => "tipo", "valor" => $filtroLocalidades ),array("clave" => "provincia", "valor" => $prov["provincia"]), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $prov["provincia"]; ?></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $prov["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>									
											<?php endif ?>							
										</tbody>
									</table>
								</div>
                          	<?php endif ?>

                          	<?php if($contRemuneracion > 0 || $filtroRemuneracion): ?>
                           
							   <div class="box bg-white">
									<div class="box-block clearfix">
										<h5 class="pull-xs-left"><i class="m-sm-r-1"></i> Remuneraciones</h5>
									</div>
									<table class="table m-md-b-0">
										<tbody>
											<?php if($filtroRemuneracion): ?>
												<tr>
													<td>
														<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ),array("clave" => "genero", "valor" => $filtroGenero), array( "clave" => "idioma", "valor" => $filtroIdioma ),array( "clave" => "localidad", "valor" => $filtroLocalidades ),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $filtroRemuneracion), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $infoRemuneracion["nombre"] ?><span class="underline"></span></a>
													</td>
													<td>
														<?php if(!$busquedaAvanzada || $palabrasClave == ""): ?>
															<span class="text-muted pull-xs-right" title="Remover filtro"><a href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "pagina", "valor" => 1 ))); ?>"><i class="ion-close text-danger"></i></a></span>
														<?php endif ?>
													</td>
												</tr>
											<?php else: ?>
												<?php foreach($remuneraciones as $rem): ?>
													<?php if($rem["cantidad"] > 0): ?>
														<!-- <span>Hola mundo</span> -->
														<tr>
															<td>
																<a class="text-primary" href="<?php echo crearURL(array( array( "clave" => "area", "valor" => $filtroArea ), array( "clave" => "momento", "valor" => $filtroMomento ), array( "clave" => "tipo", "valor" => $filtroTipo ), array( "clave" => "genero", "valor" => $filtroGenero ), array( "clave" => "idioma", "valor" => $filtroIdioma ),array( "clave" => "localidad", "valor" => $filtroLocalidades ),array("clave" => "provincia", "valor" => $filtroProvincia),array("clave" => "remuneracion", "valor" => $rem["amigable"]), array( "clave" => "pagina", "valor" => 1 ))); ?>"><?php echo $rem["nombre"]; ?></a>
															</td>
															<td>
																<span class="text-muted pull-xs-right"><?php echo $rem["cantidad"]; ?></span>
															</td>
														</tr>
													<?php endif ?>
												<?php endforeach ?>									
											<?php endif ?>							
										</tbody>
									</table>
								</div>
                          	<?php endif ?>
                            
						</div>
						
						<div class="col-md-9">

							<?php if($filtroActivado || $busqueda || $busquedaAvanzada): ?>
								<?php if($cantidadRegistros > 0): ?>
									<div class="row row-sm">
										<?php foreach($trabajadores as $trabajador): ?>										
												<div class="col-md-12">
											<a href="trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>">
												<div class="tra box box-block bg-white user-5">
													<div class="u-content">
														<div class="row">
															<div class="col-xs-12 col-md-3  text-center">
																<div class="avatar box-96 m-b-2" style="margin-right: 11px;">
																<img class="b-a-radius-circle" src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="max-height: 90px;height: 100%;">
																</div>
															</div>
															<div class="col-xs-12 col-md-6">
																
																<h4>
																	<span class="text-black pull-left"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></span>

																</h4>
																<div class="row">
																	<div class="col-xs-12 col-md-12">
																		
																	<div class="pull-left">
																		<b class="" style="">&nbsp;&nbsp;<?= $trabajador['pais'] ?></b>
																	</div>
																	</div>
																</div>
																<div style="font-size: 28px;"></div>
															</div>
															<div class="col-xs-12 col-md-3">
																<button class="btn btn-info" style="margin-bottom: 10px">Ver Perfil</button>
																<div class="col-xs-12 col-md-12">
																	<div class="pull-left">
																		<span style="font-size: 12px">Remuneración Pretendida:</span>
																		<h3><?= $trabajador['remuneracion_pret'] != "" ? "$" . $trabajador['remuneracion_pret'] : "Vacío" ?></h3>
																	</div>
																</div>
															</div>
															<div class="col-xs-12 col-md-12">
																<?php
																	$sobre_mi_len = strlen($trabajador['sobre_mi']);
																?>
																<?php if ($sobre_mi_len > 300): 300?>
																	<span class="summary">
																		<?php $resumen = substr($trabajador['sobre_mi'], 0, 300) ?>
																		<?php $completo = substr($trabajador['sobre_mi'], 300) ?>
																		<p style="text-align: justify;"><?= $resumen ?><span class="complete" style=""><?= $completo ?></span></p>
																	</span>
																	
																	<span>
																		<a href="javascript:void(0)" class="more">Leer más...</a>
																	</span>
																<?php else: ?>
																	<p style="text-align: justify;"><?= $trabajador['sobre_mi'] ?></p>
																<?php endif; ?>
															</div>
														</div>
														
													</div>
												</div>
											</a>
										</div>
										<?php endforeach ?>	
										</div>
								<?php else: ?>	
								<div class="alert alert-danger fade in" role="alert">
									<i class="ion-android-alert"></i> No hemos obtenido ningún resultado que se ajuste a tus criterios de búsqueda.
								</div>
								<?php endif ?>
							<?php else: ?>
								<div class="row row-sm" id="box-trab">
									<?php foreach($trabajadores as $trabajador): ?>
										<div class="col-md-12">
											<a href="trabajador-detalle.php?t=<?php echo slug("$trabajador[nombres] $trabajador[apellidos]") . "-$trabajador[id]"; ?>">
												<div class="tra box box-block bg-white user-5">
													<div class="u-content">
														<div class="row">
															<div class="col-xs-12 col-md-3  text-center">
																<div class="avatar box-96 m-b-2" style="margin-right: 11px;">
																<img class="b-a-radius-circle" src="img/<?php echo $trabajador["imagen"]; ?>" alt="" style="max-height: 90px;height: 100%;">
																</div>
															</div>
															<div class="col-xs-12 col-md-6">
																
																<h4>
																	<span class="text-black pull-left"><?php echo "$trabajador[nombres] $trabajador[apellidos]"; ?></span>

																</h4>
																<div class="row">
																	<div class="col-xs-12 col-md-12">
																		
																	<div class="pull-left">
																		<b class="" style="">&nbsp;&nbsp;<?= $trabajador['pais'] ?></b>
																	</div>
																	</div>
																</div>
																<div style="font-size: 28px;"></div>
															</div>
															<div class="col-xs-12 col-md-3">
																<button class="btn btn-info" style="margin-bottom: 10px">Ver Perfil</button>
																<div class="col-xs-12 col-md-12">
																	<div class="pull-left">
																		<span style="font-size: 12px">Remuneración Pretendida:</span>
																		<h3> <?= $trabajador['remuneracion_pret'] != "" ? "$" . $trabajador['remuneracion_pret'] : "Vacío" ?></h3>
																	</div>
																</div>
															</div>
															<div class="col-xs-12 col-md-12">
																<?php
																	$sobre_mi_len = strlen($trabajador['sobre_mi']);
																?>
																<?php if ($sobre_mi_len > 300): 300?>
																	<span class="summary">
																		<?php $resumen = substr($trabajador['sobre_mi'], 0, 300) ?>
																		<?php $completo = substr($trabajador['sobre_mi'], 300) ?>
																		<p style="text-align: justify;"><?= $resumen ?><span class="complete" style=""><?= $completo ?></span></p>
																	</span>
																	
																	<span>
																		<a href="javascript:void(0)" class="more">Leer más...</a>
																	</span>
																<?php else: ?>
																	<p style="text-align: justify;"><?= $trabajador['sobre_mi'] ?></p>
																<?php endif; ?>
															</div>
														</div>
														
													</div>
												</div>
											</a>
										</div>
									<?php endforeach ?>	
								</div>
									<?php if (count($trabajadores) > 0): ?>
									<div style="text-align: center">
										<button class="pagination-next">+ Jobbers</button>
									</div>
									<?php endif; ?>
							<?php endif ?>

						</div>
					</div>

				</div>
				<?php require_once('includes/footer.php'); ?>
			</div>
		</div>

		<?php require_once('includes/libs-js.php'); ?>
		<script>

		var limit_ini = 0;

		$(document).ready(function() {

			$('.complete').hide();

			$('.more').on('click',function(){
				console.log('boton');
				var btnMore = $(this).text();

				if (btnMore == 'Leer más...') {
					$(this).text('Retraer...');
				} else {
					$(this).text('Leer más...');
				}
				
				//$(this).siblings('summary').find('span.complete').toggle(function(){
					//$(this).closest('span.complete').toggle();
					//$('.more').text('Leer más...');
				//});
				$(this).parent().find('.complete').toggle('slow');
			});
			
			$('.pagination-next').on('click',function(){

				limit_ini += 15;

				$.ajax({
					url: 'ajax/trabajadores.php',
					type: 'POST',
					dataType: 'json',
					data: {op: 1, limit_ini: limit_ini},
					success: function(response){

						var html = "";

						var json_length = Object.keys(response.trabajador).length;

						if (json_length > 0) {
							response.trabajador.forEach(function(e){
								html += e;
							});
						} else {
							$('.pagination-next').remove();
						}

						
						
						$('#box-trab').append(html);
					},
					error: function(error){
						console.log('Error en el ajax: '+error);
					}
				});
				

			});

		});
            
		</script>
	</body>
</html>
<?php
	function funcLimpiarCadena($valor)
		{
			$valor = str_ireplace("SELECT","",$valor);
			$valor = str_ireplace("COPY","",$valor);
			$valor = str_ireplace("DELETE","",$valor);
			$valor = str_ireplace("DROP","",$valor);
			$valor = str_ireplace("DUMP","",$valor);
			$valor = str_ireplace(" OR ","",$valor);
			$valor = str_ireplace("%","",$valor);
			$valor = str_ireplace("LIKE","",$valor);
			$valor = str_ireplace("--","",$valor);
			$valor = str_ireplace("^","",$valor);
			$valor = str_ireplace("[","",$valor);
			$valor = str_ireplace("]","",$valor); 
			$valor = str_ireplace("!","",$valor);
			$valor = str_ireplace("¡","",$valor);
			$valor = str_ireplace("?","",$valor);
			$valor = str_ireplace("=","",$valor);
			$valor = str_ireplace("&","",$valor);
			return $valor;
		}
?>
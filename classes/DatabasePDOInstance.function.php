<?php
	require_once("DatabasePDO.class.php");
	function DatabasePDOInstance()
	{		
		/*$servername = "db678638694.db.1and1.com";
		$username 	= "dbo678638694";		
		$password = "30777920Ca100pesos+";
		$database 	= "db678638694";*/
		$servername = "localhost";
		$username 	= "root";
		$password = "";
		$database 	= "db678638694";
		return new DatabasePDO($servername, $username, $password, $database);
	}
?>
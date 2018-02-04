<?php

require "lib/nusoap.php";

function userForgotPass($accion, $destEmail,$destName, $code){
	
	$cliente = new nusoap_client("http://www.ingvictorfernandez.com.ve/webservice/email.php?wsdl", "wsdl");

	$error = $cliente->getError();

	if ($error) {
	    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
	}

	$params = array("destEmail" => $destEmail, "destName" => $destName, "code" => $code);

	$result = $cliente->call("enviarMail", array("accion" => $accion, "params" => $params));

	if ($cliente->fault) {
	    return false;
	}
	else {
	    $error = $cliente->getError();
	    if ($error) {
	        return $error;
	    }
	    else {
	        return $result;
	    }
	}
}

function prueba($accion, $destEmail,$destName, $code){
	$cliente = new nusoap_client("http://www.ingvictorfernandez.com.ve/webservice/email.php?wsdl", "wsdl");

	$error = $cliente->getError();

	if ($error) {
	    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
	}

	$params = array("destEmail" => $destEmail, "destName" => $destName, "code" => $code);

	$result = $cliente->call("enviarMail", array("accion" => $accion, "params" => $params));

	if ($cliente->fault) {
	    return false;
	}
	else {
	    $error = $cliente->getError();
	    if ($error) {
	        return $error;
	    }
	    else {
	        return $result;
	    }
	}
}

?>
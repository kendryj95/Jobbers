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

function soporteTecnico($accion, $email, $name, $asunto1, $asunto2, $mensaje){

	$cliente = new nusoap_client("http://www.ingvictorfernandez.com.ve/webservice/email.php?wsdl", "wsdl");

	$error = $cliente->getError();

	if ($error) {
	    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
	}

	 $params = array("email" => $email, "name" => $name, "asunto1" => $asunto1, "asunto2" => $asunto2, "mensaje" => $mensaje);

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

function email_chat($accion, $emisorMsg,$destEmail,$destName, $msg){

	$cliente = new nusoap_client("http://www.ingvictorfernandez.com.ve/webservice/email.php?wsdl", "wsdl");

	$error = $cliente->getError();

	if ($error) {
	    echo "<h2>Constructor error</h2><pre>" . $error . "</pre>";
	}

	 $params = array("emisorMsg" => $emisorMsg, "destEmail" => $destEmail, "destName" => $destName, "msg" => $msg);

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
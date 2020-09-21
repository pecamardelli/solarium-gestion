<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_REQUEST['id'];
	$nombre = $_REQUEST['nombre'];
	$apellido = $_REQUEST['apellido'];
	$dni = $_REQUEST['dni'];
	$email = $_REQUEST['email'];
	$celular = $_REQUEST['cel1'];
	$zona = $_REQUEST['zona'];
	$cuenta = $_REQUEST['cuenta'];
	$knownBy = $_REQUEST['knownBy'];
	$balance = $_REQUEST['balance'];
	$opcion = $_REQUEST['opcion'];
	$estado = $_REQUEST['estado'];
	
	if(!is_numeric($zona)){
		$query = "INSERT INTO config (descConfig, charValue) VALUES ('zona', '$zona')";
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$zona = $dbcon->insert_id;
	}

	if(!is_numeric($knownBy)){
		$query = "INSERT INTO config (descConfig, charValue) VALUES ('nos_conocio_por', '$knownBy')";
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$knownBy = $dbcon->insert_id;
	}

	if($opcion == "ADD"){
		$query="INSERT INTO clientes (nombreCliente, apellidoCliente, dniCliente, emailCliente, telCliente, telCliente2, idZona, ctaCte, estado, idKnownBy, balance, observaciones)
				VALUES ('$nombre', '$apellido', '$dni', '$email', '$celular', '$celular2', '$zona', '$cuenta', '$estado', '$knownBy', '$balance', '')";
	}
	else
	{
		$query="UPDATE clientes SET nombreCliente='$nombre', apellidoCliente='$apellido', dniCliente='$dni', emailCliente='$email', telCliente='$celular', telCliente2='$celular2', idZona='$zona', ctaCte='$cuenta', estado='$estado', idKnownBy='$knownBy', balance='$balance', observaciones='' WHERE idCliente='$id'";
	}

	$result=mysqli_query($dbcon, $query);

	if(!$result){
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "DATOS CARGADOS CORRECTAMENTE.";
		logger("INFO", $_SESSION['user'] . " agrego/modifico un nuevo cliente: $nombre $apellido, $dni, $email, $celular $celular2, $zona, cuenta corriente $cuenta, estado $estado, balance cta. cte.: $balance");
	}
?>

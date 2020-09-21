<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/log.php";

	$nombreServ = $_REQUEST['nombre'];
	$descServ = $_REQUEST['desc'];
	$tipoServ = $_REQUEST['tipoServ'];
	$cantServ = $_REQUEST['cantServ'];
	$color = $_REQUEST['servColor'];
	$query="INSERT INTO servicios (nombreServ, descServ, tipoServ, cantServ, eventColor) VALUES ('$nombreServ', '$descServ', '$tipoServ', '$cantServ', '$color')";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));

	if($result){
		logger("INFO", $_SESSION['user'] . " agrego el servicio $nombreServ $descServ, tipo $tipoServ, servicios simultaneos $cantServ y color $color.");
	}

	HEADER('location: servicios.php');
?>

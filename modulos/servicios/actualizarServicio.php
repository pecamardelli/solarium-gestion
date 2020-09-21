<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$idServ = $_REQUEST['ident'];
	$nombre = $_REQUEST['nombre'];
	$descr = $_REQUEST['desc'];
	$tipo = $_REQUEST['tipo'];
	$cant = $_REQUEST['cant'];
	$color = $_REQUEST['servColor'];

	if($_SESSION['rol'] > 2){
		$query = ("UPDATE servicios SET eventColor='$color' WHERE idServ='$idServ'");
	}
	else{
		$query = ("UPDATE servicios SET nombreServ='$nombre', descServ='$descr', tipoServ='$tipo', cantServ='$cant', eventColor='$color' WHERE idServ='$idServ'");
	}

	$result = mysqli_query($dbcon, $query);

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "SERVICIO ACTUALIZADO CORRECTAMENTE.";
		logger("INFO", $_SESSION['user'] . " cambio el servicio $nombre, $descr (id $idServ): NOMBRE: $nombre, DESCRIPCION: $descr, TIPO: $tipo, CANT: $cant, COLOR: $color");
	}
?>


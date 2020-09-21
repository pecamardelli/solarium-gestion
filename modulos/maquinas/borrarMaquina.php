<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 2;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_REQUEST['id'];
	$marca = $_REQUEST['marca'];
	$modelo = $_REQUEST['modelo'];
	$momento = strftime("%d-%m-%Y %R");
	$query = ("UPDATE maquinas SET estado='ELIMINADA', observaciones='Eliminado en la fecha $momento'	WHERE idMaq='$id'");
	$result=mysqli_query($dbcon, $query);

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "MAQUINA ELIMINADA CORRECTAMENTE.";
		logger("INFO", $_SESSION['user'] . " elimino la maquina " . $marca . ", modelo " . $modelo . " (id producto $id)");
	}
?>

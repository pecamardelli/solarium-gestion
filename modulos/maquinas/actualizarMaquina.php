<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_REQUEST['idMaq'];
	$controller = $_REQUEST['controller'];
	$controllerOpt = $_REQUEST['controllerOpt'];
	$graficar = $_REQUEST['graficar'];
	$estado = $_REQUEST['estado'];
	$color = $_REQUEST['color'];

	if($_SESSION['rol'] > 2){
		echo "ERROR! No tiene permisos para realizar esta accion.";
		return;
	}

	if($controller == "ARDUINO" || $controller == "RASPBERRY"){
		$query = "SELECT COUNT(*) FROM maquinas WHERE controller='$controller' AND controllerOpt = '$controllerOpt' AND idMaq != '$id'";
		$result = mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
		$row = mysqli_fetch_array($result , MYSQLI_NUM);

		if($row[0] > 0){
			echo "El puerto o IP seleccionado esta siendo utilizado/a por otra maquina: $controllerOpt";
			return;
		}
	}
	
	$query = "UPDATE maquinas SET controller='$controller', controllerOpt='$controllerOpt', graficar='$graficar', estado='$estado', color='$color' WHERE idMaq='$id'";
	$result = mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
	echo "MAQUINA ACTUALIZADA CORRECTAMENTE";
	logger("INFO", $_SESSION['user'] . " cambio la configuracion de la maquina " . $id . ": " . $controller . ", " . $controllerOpt . ", graficar: " . $graficar . ", " . $estado);
?>


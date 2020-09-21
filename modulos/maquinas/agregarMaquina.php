<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$tipo = $_REQUEST['tipo'];
	$marca = $_REQUEST['marca'];
	$modelo = $_REQUEST['modelo'];
	$tubos = $_REQUEST['tubos'];
	$fecha = $_REQUEST['fecha'];
	$serv = $_REQUEST['serv'];
	$estado = $_REQUEST['estado'];
	$controller = $_REQUEST['controller'];
	$controllerOpt = $_REQUEST['controllerOpt'];
	$graficar = $_REQUEST['graficar'];
	$color = $_REQUEST['color'];

	$query="INSERT INTO maquinas (tipoMaq, marcaMaq, modeloMaq, tubosMaq, fechaMaq, idServicio, controller, controllerOpt, graficar, estado, observaciones) VALUES ('$tipo', '$marca', '$modelo', '$tubos', '$fecha', '$serv', '$controller', '$controllerOpt', '$graficar', '$estado', '$color', '')";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));

	logger("INFO", $_SESSION['user'] . " agrego la maquina $marca $modelo, tipo $tipo");
	echo "MAQUINA AGREGADA CORRECTAMENTE";
?>

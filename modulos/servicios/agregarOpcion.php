<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$nombre = $_REQUEST['nombre'];
	$desc = $_REQUEST['desc'];
	$precio = $_REQUEST['precio'];
	$idServ = $_REQUEST['servicio'];
	//$opColor = $_REQUEST['opColor'];
	$query="INSERT INTO opciones (idServ, nombreOp, descOp, precioOp) VALUES ('$idServ', '$nombre', '$desc', '$precio')";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));

	if ($result) {
		$sql="SELECT descServ AS descServ FROM servicios WHERE idServ='$idServ'";
		$result = mysqli_query($dbcon, $sql);
		$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);
		logger("INFO", $_SESSION['user'] . " agrego la opcion $nombre $desc, precio $" . $precio . " del servicio " . $fila['descServ']);
	}

	HEADER('location: modulos/servicios/editarServicio.php?id=' . $idServ);
?>

<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_REQUEST['idOp'];
	$idServ = $_REQUEST['idServ'];
	$nombre = $_REQUEST['nombre'];
	$desc = $_REQUEST['desc'];
	$precio = $_REQUEST['precio'];

	$query = ("UPDATE opciones SET nombreOp='$nombre', descOp='$desc', precioOp='$precio' WHERE idOpcion='$id'");
	$result = mysqli_query($dbcon, $query);

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "OPCION ACTUALIZADA CORRECTAMENTE.";
		$sql = "SELECT nombreServ AS np, descServ AS dp FROM servicios WHERE idServ='$idServ'";
		$result = mysqli_query($dbcon, $sql);
		if (!$result) {
			die('Consulta no válida: ' . mysqli_error($dbcon));
			logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
		}
		else{
			$serv = mysqli_fetch_array($result, MYSQLI_NUM);
			logger("INFO", $_SESSION['user'] . " cambio la opcion $nombre, $desc (id $id) del servicio $serv[0], $serv[1] (id $idServ): NOMBRE: $nombre, DESCRIPCION: $desc, PRECIO: $$precio");
		}
	}
?>


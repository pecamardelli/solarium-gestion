<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_REQUEST['idProd'];
	$nombre = $_REQUEST['nombre'];
	$desc = $_REQUEST['desc'];
	$precio = $_REQUEST['precio'];
	$stock = $_REQUEST['stock'];

	if($_SESSION['rol'] > 2){
		$query = ("UPDATE productos SET precioProd='$precio', stockProd='$stock'	WHERE idProd='$id'");
	}
	else{
		$query = ("UPDATE productos SET nombreProd='$nombre', descProd='$desc', precioProd='$precio', stockProd='$stock'	WHERE idProd='$id'");
	}

	$result = mysqli_query($dbcon, $query);

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "PRODUCTO ACTUALIZADO CORRECTAMENTE.";
		logger("INFO", $_SESSION['user'] . " cambio el producto $nombre, $desc (id $id): NOMBRE: $nombre, DESCRIPCION: $desc, PRECIO: $$precio, STOCK: $stock");
	}
?>


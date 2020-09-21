<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$nom = $_REQUEST['nombre'];
	$desc = $_REQUEST['desc'];
	$precio = $_REQUEST['precio'];
	$stock = $_REQUEST['stock'];
	$query="INSERT INTO productos (nombreProd, descProd, precioProd, stockProd, comentarios, estado) VALUES ('$nom', '$desc', '$precio', '$stock', '', 'VIGENTE')";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));

	if ($result) {
		logger("INFO", $_SESSION['user'] . " agrego el producto $nombre $desc, precio $$precio");
	}
		
	HEADER('location: productos.php');
?>

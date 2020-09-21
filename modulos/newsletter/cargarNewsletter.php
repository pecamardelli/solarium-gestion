<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	
	$idNews = $_REQUEST['idNews'];

	$query="SELECT contenido FROM newsletters WHERE idNews='$idNews'";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));
	$fila = mysqli_fetch_array($result, MYSQLI_NUM);	
	echo $fila[0];
?>
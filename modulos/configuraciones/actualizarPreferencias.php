<?php
	include "../dbconfig.php";
	
	session_start();

	$id = $_SESSION['id'];
	$tema = $_REQUEST['tema'];

	$query = "UPDATE usuarios SET usuarioTema='$tema' WHERE idUsuario='$id'";
	$result=mysqli_query($dbcon, $query);

	if(!$result){
		die('Consulta no válida: ' . mysqli_error($dbcon));
	}
	else{
		echo "OK";
		$_SESSION['tema'] = "$tema";
	}
?>

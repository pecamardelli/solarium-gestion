<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 2;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_REQUEST['id'];
	$momento = strftime("%d-%m-%Y %R");
	$query = ("UPDATE productos SET estado='ELIMINADO', prodObs='Eliminado en la fecha $momento'	WHERE idProd='$id'");
	$result=mysqli_query($dbcon, $query);

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "PRODUCTO ELIMINADO CORRECTAMENTE.";
		$sql="SELECT nombreProd AS nomProd, descProd AS descProd FROM productos WHERE idProd='$id'";
		$result = mysqli_query($dbcon, $sql);
		
		if (!$result) {
			logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
			die('Consulta no válida: ' . mysqli_error($dbcon));
		}
		else{
			$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);
			logger("INFO", $_SESSION['user'] . " elimino el producto " . $fila['nomProd'] . ", " . $fila['descProd'] . " (id producto $id)");
			echo "";
		}
	}
?>

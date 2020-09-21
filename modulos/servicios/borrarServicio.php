<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 2;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$idServ = $_REQUEST['ids'];
	$momento = strftime("%d-%m-%Y %R");
	$query = ("UPDATE servicios SET estado='ELIMINADO', servObs='Eliminado en la fecha $momento'	WHERE idServ='$idServ'");
	$result=mysqli_query($dbcon, $query);

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "SERVICIO ELIMINADO CORRECTAMENTE.";
		$sql="SELECT nombreServ AS nomServ, descServ AS descServ FROM servicios WHERE idServ='$idServ'";
		$result = mysqli_query($dbcon, $sql);
		
		if (!$result) {
			logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
			die('Consulta no válida: ' . mysqli_error($dbcon));
		}
		else{
			$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);
			logger("INFO", $_SESSION['user'] . " elimino el servicio " . $fila['nomServ'] . ", " . $fila['descServ'] . " (id producto $idServ)");
			echo "";
		}
	}
?>

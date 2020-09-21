<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	$access_level = 2;
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/allow.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$idOpcion = $_REQUEST['ids'];
	$momento = strftime("%d-%m-%Y %R");
	//$query="DELETE FROM opciones WHERE idOpcion='$idOpcion'";
	$query=("UPDATE opciones SET estado='ELIMINADO', observaciones='Eliminado en la fecha $momento' WHERE idOpcion='$idOpcion'");
	$result=mysqli_query($dbcon, $query);

	if (!$result) {
		die('Consulta no válida: ' . mysqli_error($dbcon));
		logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
	}
	else{
		echo "OPCION ACTUALIZADA CORRECTAMENTE.";
		//$sql = "SELECT nombreServ AS np, descServ AS dp FROM servicios WHERE idServ='$idOpcion'";
		$sql="SELECT opciones.nombreOp AS nomOp,
				opciones.descOp AS descOp,
				opciones.idServ AS idServ,
				servicios.nombreServ AS nomServ,
				servicios.descServ AS descServ
				FROM opciones
				INNER JOIN servicios ON opciones.idServ = servicios.idServ
				WHERE idOpcion='$idOpcion'";
		$result = mysqli_query($dbcon, $sql);
		if (!$result) {
			logger("ERROR", "Consulta no válida: " . mysqli_error($dbcon));
			die('Consulta no válida: ' . mysqli_error($dbcon));
		}
		else{
			$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);
			logger("INFO", $_SESSION['user'] . " elimino la opcion " . $fila['nomOp'] . ", " . $fila['descOp'] . " (id opcion $idOpcion) del servicio " . $fila['nomServ'] . ", " . $fila['descServ'] . " (id servicio " . $fila['idServ'] . ")");
		}
	}
?>

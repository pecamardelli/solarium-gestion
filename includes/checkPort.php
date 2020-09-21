<?php
	include "auth.php";
	include "../dbconfig.php";
	include "log.php";

	$controllerOpt = $_REQUEST['controllerOpt'];

	$query = ("SELECT COUNT(*) FROM maquinas WHERE arduinoPort='$controllerOpt' AND estado='VIGENTE'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$fila = mysqli_fetch_array($result);
	
	if($fila[0] != 0){
		echo "NACK";
	}
	else{
		echo "ACK";
	}

?>


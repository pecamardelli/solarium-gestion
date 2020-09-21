<?php			
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$to_encode = array();

	$query="SELECT intValue FROM config WHERE descConfig = 'hora_inicio_agenda'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$value = mysqli_fetch_array($result, MYSQLI_NUM);

	$to_encode['inicio'] = $value;

	$query="SELECT intValue FROM config WHERE descConfig = 'hora_fin_agenda'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$value = mysqli_fetch_array($result, MYSQLI_NUM);

	$to_encode['fin'] = $value;

	$query="SELECT charValue FROM config WHERE descConfig = 'vista_agenda'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$value = mysqli_fetch_array($result, MYSQLI_NUM);

	$to_encode['vista'] = $value;

	echo json_encode($to_encode);
?>
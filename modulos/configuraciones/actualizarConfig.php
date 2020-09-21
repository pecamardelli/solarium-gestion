<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$vent = $_REQUEST['vent'];
	$ilum = $_REQUEST['ilum'];
	$wait = $_REQUEST['wait'];
	$ports = $_REQUEST['ports'];
	$agStart = $_REQUEST['agStart'];
	$agEnd = $_REQUEST['agEnd'];
	$agView = $_REQUEST['agView'];

	if($vent < 3 || $vent > 10)
	{
		echo "Valor de ventilacion fuera de rango (3-10): $vent";
		return;
	}

	$query = ("UPDATE config SET intValue='$vent' WHERE descConfig='tiempo_ventilacion'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if($ilum < 10 || $ilum > 99)
	{
		echo "Valor de iluminacion fuera de rango (5-10): $ilum";
		return;
	}

	$query = ("UPDATE config SET intValue='$ilum' WHERE descConfig='tiempo_iluminacion'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if($wait < 1 || $wait > 10)
	{
		echo "Valor de espera para inicio de turno fuera de rango (1-10): $wait";
		return;
	}

	$query = ("UPDATE config SET intValue='$wait' WHERE descConfig='espera_turno'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if($ports < 1 || $ports > 10)
	{
		echo "Cantidad de puertos del Arduino fuera de rango (1-10): $ports";
		return;
	}

	$query = ("UPDATE config SET intValue='$ports' WHERE descConfig='puertos_arduino'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if($agStart < 0 || $agStart > 24){
		echo "Hora de inicio de agenda fuera de rango (0-24): $agStart";
		return;
	}

	if($agEnd < 0 || $agEnd > 24){
		echo "Hora de fin de agenda fuera de rango (0-24): $agEnd";
		return;
	}

	if($agStart >= $agEnd)
	{
		echo "La Hora de inicio de la agenda debe ser inferior a la hora del final: $agStart - $agEnd";
		return;
	}

	$query = ("UPDATE config SET intValue='$agStart' WHERE descConfig='hora_inicio_agenda'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	$query = ("UPDATE config SET intValue='$agEnd' WHERE descConfig='hora_fin_agenda'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if($agView != "agendaDay" && $agView != "agendaWeek" && $agView != "month"){
		echo "Opcion de vista de agenda no valida: $agView";
		return;
	}

	$query = ("UPDATE config SET charValue='$agView' WHERE descConfig='vista_agenda'");
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	logger("INFO", $_SESSION['user'] . " actualizo las opciones: Ventilacion: " . $vent . ", Iluminacion: " . $ilum . ", Espera: " . $wait . ", Puertos del Arduino: " . $ports . ", Inicio de agenda: " . $agStart . ", Fin de agenda: " . $agEnd);

	echo "Opciones actualizadas correctamente.";
?>


<?php    
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

	$hoy = getdate();

	if($hoy['mon'] <= 9){
		$mes = "0$hoy[mon]";
	}
	else{
		$mes = $hoy['mon'];
	}

	if($hoy['mday'] <= 9){
		$dia = "0$hoy[mday]";
	}
	else{
		$dia = $hoy['mday'];
	}

	$cuerpo = "Fecha: $hoy[mday] del $hoy[mon] del $hoy[year]";

	$query="SELECT SUM(montoTotal) AS monto FROM ventas WHERE fechaVenta >= '$hoy[year]-$mes-$dia 00:00:00' AND fechaVenta <= '$hoy[year]-$mes-$dia 23:59:59'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);

	$cuerpo =  $cuerpo . "\n\nINGRESOS:\t\t\$$fila[monto]";

	$query="SELECT numeroVenta AS nro FROM ventas WHERE fechaVenta >= '$hoy[year]-$mes-$dia 00:00:00' AND fechaVenta <= '$hoy[year]-$mes-$dia 23:59:59'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	
	$cantidad = 0;
	while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		$query="SELECT COUNT(*) AS cantidad FROM detalleVentas WHERE numeroVenta = '$fila[nro]'";
		$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$row = mysqli_fetch_array($result2, MYSQLI_ASSOC);
		$cantidad = (($cantidad + $row['cantidad']));
	}

	$cuerpo =  $cuerpo . "\nTURNOS VENDIDOS:\t$cantidad";

	$date = new DateTime($hoy['year'] . '-' . $mes . '-' . $dia . 'T00:00:00'); // For today/now, don't pass an arg.
	$start = (($date->format('U') * 1000));
	$date->modify("+1 day");
	$end = (($date->format('U') * 1000));
	
	$query="SELECT COUNT(*) AS cant FROM turnos WHERE start >= $start AND end < $end AND estado='TOMADO'";
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$fila = mysqli_fetch_array($result, MYSQLI_ASSOC);

	$cuerpo =  $cuerpo . "\nTURNOS TOMADOS:\t\t" . $fila['cant'];

	$cuerpo = $cuerpo . "\n\nFIN DEL REPORTE.";
	$command = "sendEmail -f pecamardelli@gmail.com -t pecamardelli@gmail.com -s smtp.gmail.com:587 -o tls=yes -xu oxumsolarium@gmail.com -xp Cach1986 -u 'REPORTE DIARIO' -m '$cuerpo'";

	shell_exec($command);
?>

<?php
	include "includes/auth.php";
	
	$contenido = $_POST['contenido'];
	include "dbconfig.php";
	include "includes/log.php";

	# CHEQUEO DE QUE EL CLIENTE NO TENGA ASIGNADO UN TURNO A ESA HORA
	$query="SELECT COUNT(*) FROM turnos WHERE idCliente='$idcli' AND start='$start' AND estado!='CANCELADO'";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	$fila = mysqli_fetch_array($result, MYSQLI_NUM);
	#echo $fila[0];

	$com = "sendEmail -f oxumsolarium@gmail.com -t pecamardelli@gmail.com -s smtp.gmail.com:587 -o tls=yes -o message-content-type=html -xu oxumsolarium@gmail.com -xp Cach1986 -u 'Newsletter' -m '$contenido'";
	$output = shell_exec($com);
	echo $output;
?>
<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";
	
	$idcli = $_POST['idCliente'];
	$idDetalle = $_POST['idDetalle'];
	$start = $_POST['start'];
	$end = $_POST['end'];
	$maq = $_POST['maq'];
	$momento = date('Y-m-d H:i:s');
	$query="INSERT INTO turnos (idDetalle, idCliente, idMaq, start, end, ultimoCambio) VALUES ('$idDetalle', '$idcli', '$maq', '$start', '$end', '$momento')";
	$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if($result){
		echo "AGENDADO EXITOSAMENTE!";

		$sql="SELECT nombreCliente, apellidoCliente FROM clientes WHERE idCliente='$idcli'";
		$res1 = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon));
		$data_cliente = mysqli_fetch_array($res1, MYSQLI_NUM);

		$sql="SELECT detalleVentas.idServicio AS idServ,
					detalleVentas.idOpcion AS idOp,
					servicios.descServ AS descServ,
					opciones.descOp AS descOp
					FROM detalleVentas
					INNER JOIN servicios ON detalleVentas.idServicio = servicios.idServ
					INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
					WHERE idDetalle='$idDetalle'";
		$res2 = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon));
		$data_turno = mysqli_fetch_array($res2, MYSQLI_ASSOC);

		logger("INFO", $_SESSION['user'] . " agendo un turno para " . $data_cliente[0] . " " . $data_cliente[1] . " de " . $data_turno['descServ'] . " - " . $data_turno['descOp']);
		$query = ("UPDATE detalleVentas SET estadoVenta='AGENDADO'	WHERE idDetalle='$idDetalle'");
		$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	}
?>
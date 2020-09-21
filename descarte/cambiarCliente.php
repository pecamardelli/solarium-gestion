<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$id = $_REQUEST['id'];
	$state = $_REQUEST['est'];
	$query="UPDATE clientes SET estado='$state' WHERE idCliente='$id'";
	$result=mysqli_query($dbcon, $query) or die('Consulta no válida: ' . mysqli_error($dbcon));

	if (!$result) {
		$sql="SELECT nombreCliente, apellidoCliente, dniCliente FROM clientes WHERE idCliente='$id'";
		$res1 = mysqli_query($dbcon, $sql) or die(mysqli_error($dbcon));
		$data_cliente = mysqli_fetch_array($res1, MYSQLI_NUM);
		logger("INFO", $_SESSION['user'] . " actualizo el estado del cliente $data_cliente[0] $data_cliente[1], DNI $data_cliente[2] (id $id) a $state");
	}

	HEADER('location: modulos/clientes/listaClientes.php');
?>

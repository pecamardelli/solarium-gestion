<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$idCli = $_POST['idCli'];
	$servId = $_POST['idServ'];
	$opId = $_POST['idOp'];
	$opPrecio = $_POST['precioOp'];
	$cliente = $_POST['cliente'];
	$servName = $_POST['servName'];
	$opName = $_POST['opName'];
	$dif = $_POST['dif'];
	$servs = $_POST['servs'];
	$ventas = $_POST['ventas'];

	$ops = "";

	if($dif != 0){
		$query = "SELECT balance FROM clientes WHERE idCliente='$idCli'";
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$fila = mysqli_fetch_array($result, MYSQLI_NUM);
		
		$suma = (($fila[0] + $dif*(-1)));
		
		$query = ("UPDATE clientes SET balance='$suma' WHERE idCliente='$idCli'");
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));		
	}

	foreach($servs as $id){
		$ops = $ops . " $id";
		$query = ("UPDATE detalleVentas SET idServicio='$servId', idOpcion='$opId', monto='$opPrecio' WHERE idDetalle='$id'");
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));	
	}

	$ventas = array_unique($ventas);

	foreach($ventas as $item){
		$query = "SELECT monto, descuento FROM detalleVentas WHERE numeroVenta='$item'";
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		
		$total = 0;
		while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
			$total = (($total + $fila[0] * (100-$fila[1])/100));
		}
		
		$query = ("UPDATE ventas SET montoTotal='$total' WHERE numeroVenta='$item'");
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
	}

	logger("INFO", $_SESSION['user'] . " cambio " . count($servs) . " servicio(s) (IDs:" . $ops . ") del cliente " .  $cliente . " a " . $servName . " " . $opName . " con una diferencia de monto de: $" . $dif . ". Balance del cliente: $" . $suma);

	echo "Producto(s) cambiados correctamente.";
?>

<?php
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
	include $_SERVER['DOCUMENT_ROOT'] . "sistema/modulos/logger/log.php";

	$servIds = $_POST['servsIds'];
	$opIds = $_POST['opsIds'];
	$cants = $_POST['cantidades'];
	$precios = $_POST['precios'];
	$desc = $_POST['descuentos'];
	$subs = $_POST['subTotales'];

	$prodsIds = $_POST['prodIds'];
	$cantsProds = $_POST['cantsProd'];
	$preciosProds = $_POST['preciosProd'];
	$stocksProds = $_POST['stocksProd'];
	$descsProds = $_POST['descsProd'];
	$subsProds = $_POST['subsProd'];

	$cliente = $_POST['cliente'];
	$totalServ = $_POST['totServ'];
	$totalProd = $_POST['totProd'];
	$total = $totalServ + $totalProd;
	$fpago = $_POST['formapago'];
	$hay_serv = $_POST['hay_serv'];
	$hay_prod = $_POST['hay_prod'];
	$usar_bal = $_POST['usar_bal'];
	$bal = $_POST['bal'];

	$obs = $_POST['obs'];
#echo "$hay_serv - $hay_prod";exit;

	#$fecha = time();
	$user = $_SESSION['id'];
	$query = "INSERT INTO ventas (idCliente, montoTotal, formaPago, estado, idUsuario, observaciones) VALUES ('$cliente', '$total', '$fpago', 'PAGA', '$user', '$obs')";
	$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	$idVenta = mysqli_insert_id($dbcon);
	$obs = htmlspecialchars("<a href=\"modulos/ventas/detalleVentas.php?nroVenta=$idVenta&idCli=$cliente&lightbox[iframe]=true&lightbox[width]=890&lightbox[height]=560\" class=\"lightbox\" title=\"DETALLE DE LA VENTA\"><input type=\"button\" value=\"Ver Detalle\" class=\"boton2\"></a>");
	#$obs = htmlspecialchars("<b><p>HOLA MUNDO</p></b>");

	$i=0;

	if($hay_serv == 1){
		foreach($servIds as $servs){
			for($j=0;$j<$cants[$i];$j++){
				$query = "INSERT INTO detalleVentas (numeroVenta, idCliente, idServicio, idOpcion, monto, descuento, estadoVenta) VALUES ('$idVenta', '$cliente', '$servs', '$opIds[$i]', '$precios[$i]', '$desc[$i]', 'NO TOMADO')";
				$result = mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			}
			$i++;
		}
	}

	$i=0;
#echo "$hay_serv - $hay_prod";exit;
	if($hay_prod == 1){
		foreach($prodsIds as $prods){
			$query="INSERT INTO detalleVentaProd (numeroVenta, idCliente, idProducto, cantidadProducto, montoProducto, descuentoProducto, comentarioProducto) VALUES ('$idVenta', '$cliente', '$prods', '$cantsProds[$i]', '$preciosProds[$i]', '$descsProds[$i]', 'ENTREGADO')";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$query="UPDATE productos SET stockProd='$stocksProds[$i]' WHERE idProd='$prods'";
			$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
			$i++;
		}
	}

	echo "VENTA CARGADA EXITOSAMENTE!";

	if($usar_bal == 1){
		if($bal >= $total){
			$bal = (($bal - $total));
		}
		else{
			$bal = 0;
		}

		$query="UPDATE clientes SET balance='$bal' WHERE idCliente='$cliente'";
		$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
		$obs = $obs . " Se utilizó el saldo de la cuenta corriente del cliente.";
	}

	logger("VENTA", $_SESSION['user'] . " realizo una venta por un total de $$total (id venta $idVenta)", "$obs");
?>

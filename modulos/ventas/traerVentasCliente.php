<?php
include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

$clientId = $_REQUEST['idClient'];

$query="SELECT	ventas.numeroVenta,
				ventas.montoTotal,
				ventas.fechaVenta,
				ventas.estado,
				ventas.formaPago,
				ventas.observaciones,
				clientes.nombreCliente,
				clientes.apellidoCliente
				FROM ventas 
				INNER JOIN clientes ON ventas.idCliente = clientes.idCliente
				WHERE ventas.idCliente='$clientId'";
$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if(mysqli_num_rows($result) > 0){
		while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
		  echo "<tr class='filaRep'>
					<td style='width: 50px;'>$fila[0]</td>
					<td>$fila[2]</td>
					<td>$fila[6] $fila[7]</td>
					<td>\$$fila[1]</td>
					<td>$fila[4]</td>
					<td>$fila[3]</td>
					<td style='width: 200px;'>$fila[5]</td>
					<td>
						<a href='modulos/ventas/detalleVentas.php?nroVenta=$fila[0]&idCli=$clientId&lightbox[iframe]=true&lightbox[width]=890&lightbox[height]=560' class='lightbox' title='DETALLE DE LA VENTA'><input type='button' value='Ver Detalle' class='boton2' onClick=''></a>
					</td>
				</tr>";
		}
	}
	else{
		echo "EMPTY";
	}
?>

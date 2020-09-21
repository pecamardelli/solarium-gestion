<?php
include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php";
include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";

$clientId = $_REQUEST['idClient'];

$query="SELECT	detalleVentas.idDetalle AS id,
				detalleVentas.numeroVenta AS nro,
				detalleVentas.idServicio AS idserv,
				detalleVentas.idOpcion AS idop,
				detalleVentas.monto AS monto,
				detalleVentas.descuento AS descnt,
				servicios.descServ AS descServ,
				opciones.descOp AS descOp
				FROM detalleVentas 
				INNER JOIN servicios ON detalleVentas.idServicio = servicios.idServ
				INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
				WHERE detalleVentas.idCliente='$clientId' AND (detalleVentas.estadoVenta='NO TOMADO' OR detalleVentas.estadoVenta='CANCELADO')";
$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));

	if(mysqli_num_rows($result) > 0){
		while($fila = mysqli_fetch_array($result, MYSQLI_ASSOC)){
		  echo "<tr class='filaServ'>
					<td style='width: 50px;'>$fila[id]</td>
					<td style='width: 50px;' id='$fila[id]-venta'>$fila[nro]</td>
					<td>$fila[descServ]</td>
					<td>$fila[descOp]</td>
					<td id='$fila[id]-monto'>\$$fila[monto]</td>
					<td id='$fila[id]-descuento'>$fila[descnt]</td>
					<td>
						<input type='checkbox' name='servs' value='$fila[id]' class='checks'>
					</td>
				</tr>";
		}
	}
	else{
		echo "EMPTY";
	}
?>

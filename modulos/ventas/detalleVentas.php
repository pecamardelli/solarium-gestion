<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/auth.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php include $_SERVER['DOCUMENT_ROOT'] . "sistema/includes/titulo.php"; ?>
	</head>
	
	<body id="body">
		<div id="header">
				<img src="../../imagenes/logo.png">
		</div>

		<div id="user1">
			<center>
				<?php
					include $_SERVER['DOCUMENT_ROOT'] . "sistema/dbconfig.php";
					$idCli = $_REQUEST['idCli'];
					$venta = $_REQUEST['nroVenta'];
					$query="SELECT ventas.fechaVenta AS fecha,
								ventas.montoTotal AS totalVen,
								ventas.formaPago AS fpago,
								ventas.idUsuario AS usuario,
								ventas.observaciones AS obs,
								usuarios.usuarioNombre AS nombre,
								usuarios.usuarioApellido AS ap,
								clientes.nombreCliente AS nomCli,
								clientes.apellidoCliente AS apCli
								FROM ventas
								INNER JOIN usuarios ON ventas.idUsuario = usuarios.idUsuario
								INNER JOIN clientes ON clientes.idCliente = $idCli
								WHERE ventas.numeroVenta = '$venta'";
					$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
					$data = mysqli_fetch_array($result, MYSQLI_ASSOC);

					$query="SELECT any_value(detalleVentas.idServicio),
								any_value(detalleVentas.idCliente),
								any_value(detalleVentas.idOpcion),
								any_value(detalleVentas.monto),
								any_value(detalleVentas.descuento),
								any_value(detalleVentas.estadoVenta) AS est,
								any_value(servicios.nombreServ) AS nomSrv,
								any_value(servicios.descServ) AS descSrv,
								any_value(opciones.descOp) AS descOp,
								COUNT(descOp) AS cantidad
								FROM detalleVentas
								INNER JOIN servicios ON detalleVentas.idServicio = servicios.idServ
								INNER JOIN opciones ON detalleVentas.idOpcion = opciones.idOpcion
								WHERE detalleVentas.numeroVenta='$venta'
								GROUP BY descOp, detalleVentas.descuento";
					$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
					$rowcount=mysqli_num_rows($result);

					$fila3 = mysqli_fetch_array($result, MYSQLI_BOTH);
					mysqli_data_seek($result, 0);

					$user = $data['usuario'];

					echo "<table id='pie' class='toPDF'>
							<tr>
								<td style='font-weight: bold; width: 500px;'>Reporte generado el " . strftime("%A, %d de %B de %Y a las %R") . "</td>
							</tr>
						</table>

						<table id='pie'>
							<tr>
								<td style='font-weight: bold; width: 350px;'>CLIENTE NÚMERO " . $idCli . " - " . $data[nomCli] . " " . $data[apCli] ."</td>
								<td style='width: 50px;'>
									<a href='' title='Imprimir' onClick='window.print()'><img src='../../imagenes/printer.png'></a>
								</td>
								<td style='width: 50px;'>
									<a href='' onClick='pdf()' title='Descargar PDF'><img src='../../imagenes/pdf.png'></a>
								</td>
								<td style='width: 50px;'>
									<a href='' title='Enviar por e-mail'><img src='../../imagenes/email2.png'></a>
								</td>
							</tr>
						</table>";

					if($rowcount > 0){
						echo "<table id='tablaVentas' class='toPDF'>
								<tr>
									<td style='font-weight: bold;' colspan='7'>SERVICIOS VENDIDOS</td>
								</tr>
								<tr>
									<td>Servicio</td>
									<td>Opcion</td>
									<td>Cantidad</td>
									<td>Tomados</td>
									<td>Precio Unitario</td>
									<td>Descuento %</td>
									<td>Subotal</td>
								</tr>";

						while($fila = mysqli_fetch_array($result, MYSQLI_BOTH)){
							$subTotal = $fila[3]*$fila[cantidad]-$fila[3]*$fila[cantidad]*$fila[4]/100;
							$fecha = $fila[fecha];
							$totalVenta = $fila[totalVen];
							$fpago = $fila[fpago];

							$query="SELECT COUNT(*) FROM detalleVentas WHERE detalleVentas.idOpcion='$fila[2]' AND detalleVentas.estadoVenta='TOMADO' AND detalleVentas.numeroVenta = '$venta'";
							$result2=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
							$fila2 = mysqli_fetch_array($result2);

						  echo "<tr>
									<td style='width: 200px;'>$fila[descSrv]</td>
									<td style='width: 150px;'>$fila[descOp]</td>
									<td>$fila[cantidad]</td>
									<td>$fila2[0]</td>
									<td>\$$fila[3]</td>
									<td>$fila[4]</td>
									<td>\$$subTotal</td>
								</tr>";
						}
						echo "</table>";
					}
					else{
						echo "<table id='tablaProductos' class='toPDF'>
								<tr>
									<td style='font-weight: bold; width: 500px;'>NO HAY SERVICIOS EN ESTA VENTA</td>
								</tr>
							</table>";
					}

					$query="SELECT detalleVentaProd.idProducto,
								detalleVentaProd.cantidadProducto,
								detalleVentaProd.montoProducto,
								detalleVentaProd.descuentoProducto,
								detalleVentaProd.comentarioProducto,
								productos.nombreProd,
								productos.descProd
								FROM detalleVentaProd
								INNER JOIN productos ON detalleVentaProd.idProducto = productos.idProd
								WHERE detalleVentaProd.numeroVenta='$venta'";
					$result=mysqli_query($dbcon, $query) or die(mysqli_error($dbcon));
					$rowcount=mysqli_num_rows($result);

					if($rowcount > 0){
						echo "<table id='tablaProductos' class='toPDF'>
								<tr>
									<td style='font-weight: bold;' colspan='6'>PRODUCTOS VENDIDOS</td>
								</tr>
								<tr>
									<td>Producto</td>
									<td>Descripción</td>
									<td>Cantidad</td>
									<td>Precio Unitario</td>
									<td>Descuento %</td>
									<td>Subtotal</td>
								</tr>";

						while($fila = mysqli_fetch_array($result, MYSQLI_NUM)){
							$subTotal = $fila[1] * $fila[2]-$fila[1] * $fila[2] * $fila[3]/100;
						  echo "<tr>
									<td style='width: 200px;'>$fila[5]</td>
									<td style='width: 150px;'>$fila[6]</td>
									<td>$fila[1]</td>
									<td>\$$fila[2]</td>
									<td>$fila[3]</td>
									<td>\$$subTotal</td>
								</tr>";
						}
						echo "</table>";
					}
					else{
						echo "<table id='tablaProductos' class='toPDF'>
								<tr>
									<td style='font-weight: bold; width: 500px;'>NO HAY PRODUCTOS EN ESTA VENTA</td>
								</tr>
							</table>";
					}

					if($data[obs] != ""){
						echo "<table id='table1'>
								<tr>
									<td style='width: 500px; font-weight: bold;'>Observaciones</td>
								</tr>
								<tr>
									<td>$data[obs]</td>
								</tr>
							</table>";
					}

					echo "<table id='pie' class='toPDF'>
						<tr>
							<td style='font-weight: bold; width: 200px;'>TOTAL GENERAL: \$$data[totalVen]<br>Pagado con: $data[fpago]</td>
							<td style='font-weight: bold; width: 380px;'>Venta realizada el $data[fecha] por " . $data[nombre] . " " . $data[ap] . "</td>
						</tr>
					</table>";
				?>
			</center>
		</div>
	</body>
</html>
